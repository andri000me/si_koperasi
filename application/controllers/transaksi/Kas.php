<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Kas extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('transaksi/M_kas');
        $this->load->model('M_log_activity');
    }
    function index(){
        $data['title'] = 'Kas';
        $data['path'] = "transaksi/kas/list-kas";
        $data['kas'] = $this->M_kas->getAll();
        $this->load->view('master_template',$data);
    }

    public function getNomor()
    {
        $tgl = explode("-",$_POST['tanggal']);
        $year = $tgl[0];
        $month = $tgl[1];
        $nomor = $this->M_kas->getNomor($year, $month);
        if($nomor[0]['nomor']==""){
            $data['nomor'] =  "0001";
        }
        else{
            $data['nomor'] = sprintf("%04s",$nomor[0]['nomor']);
        }

        $data['ym'] = substr($year,2,2).$month;
        $json = array(
            "#nomor" => $data['nomor'],
            "#nomor2" => $data['nomor'],
            "#ym" => $data['ym'],
        );

        header("content-type:json/application");
        echo json_encode($json);
    }

    //Function add() digunakan untuk aksi input ke tabel anggota
    function input(){
       $data['title'] = 'Input Kas';
       $data['path'] = "transaksi/kas/input-kas";
       $data['nomor'] = $this->M_kas->getNomor(date('Y'), date('m'));
       $data['rekening'] = $this->M_kas->getRekening();
       $data['allRekening'] = $this->M_kas->getAllRekening();
        //Melakukan Validasi Form Untuk Menjamin data terisi semua
        $config = array(
            array(
                'field' => 'tanggal',
                'label' => 'Tanggal',
                'rules' => 'required'
            ),
            array(
                'field' => 'tipe',
                'label' => 'Tipe',
                'rules' => 'required'
            ),
            array(
                'field' => 'kode_perkiraan',
                'label' => 'Kode Perkiraan',
                'rules' => 'required'
            ),
        );

        $this->form_validation->set_rules($config);
        if (isset($_POST['tanggal'])) {
            if($this->form_validation->run() == TRUE){
                $tgl = explode("-",$_POST['tanggal']);
                $year = $tgl[0];
                $month = $tgl[1];
                $ym = substr($year,2,2).$month;
                $sess_input_bukti_kas = array(
                    'kode_trx_kas' => "BK"."-".$ym."-".$_POST['nomor'],
                    'tanggal' => $this->input->post('tanggal'),
                    'kode_perkiraan' => $this->input->post('kode_perkiraan'),
                    'tipe' => $this->input->post('tipe'),
                    'nomor' => $this->input->post('nomor'),
                );

                $_SESSION['bukti_kas'] = $sess_input_bukti_kas;
                redirect(base_url().'index.php/transaksi/kas/input');
            }
        }
        elseif (isset($_POST['add_detail'])) {
            $sess_detail = array(
                'kode_trx_kas' => $_SESSION['bukti_kas']['kode_trx_kas'],
                'lawan' => $this->input->post('lawan'),
                'nominal' => $this->input->post('nominal'),
                'keterangan' => $this->input->post('keterangan'),
            );
            $_SESSION['detail_kas'][] = $sess_detail;
            redirect(base_url().'index.php/transaksi/kas/input');
        }
        
        $this->load->view('master_template',$data);
        // $this->load->view('transaksi/kas/input-kas');
    }

    public function hapus_session_detail($key='')
    {
        // $_SESSION['ttl_detail_kas'] = $_SESSION['ttl_detail_kas'] - $_SESSION['detail_kas'][$key]['jumlah_rp'];
        unset($_SESSION['detail_kas'][$key]);
        redirect(base_url().'index.php/transaksi/kas/input');
    }
    
    // save trx kas
    function save()
    {
        $bukti_kas = $_SESSION['bukti_kas'];
        $bukti_kas['grand_total'] = 0;

        foreach ($_SESSION['detail_kas'] as $key => $value) {
            $bukti_kas['grand_total'] = $bukti_kas['grand_total'] + $value['nominal'];
        }

        $kas = array(
            'kode_trx_kas' => $bukti_kas['kode_trx_kas'],
            'tanggal' => $bukti_kas['tanggal'],
            'kode_perkiraan' => $bukti_kas['kode_perkiraan'],
            'tipe' => $bukti_kas['tipe'],
            'nomor' => $bukti_kas['nomor'],
            'grand_total' => $bukti_kas['grand_total'],
        );

        $this->M_kas->insertData('ak_trx_kas',$kas);
        
        $detail = $_SESSION['detail_kas'];
        foreach ($detail as $key => $value) {
            unset($value['key']);
            $jurnal = array();
            $this->M_kas->insertData('ak_detail_trx_kas',$value);
            $lastId = $this->M_kas->getLastId()[0];
            $jurnal = array(
                'tanggal' => $bukti_kas['tanggal']. ' ' . date('H:i:s'),
                'kode_transaksi' => $bukti_kas['kode_trx_kas'],
                'keterangan' => $value['keterangan'],
                'kode' => $bukti_kas['kode_perkiraan'],
                'lawan' => $value['lawan'],
                'tipe' => $bukti_kas['tipe'],
                'nominal' => $value['nominal'],
                'tipe_trx_koperasi' => 'Kas',
                'id_detail' => $lastId['lastId'],
            );

            $this->M_kas->insertData('ak_jurnal',$jurnal);
        }

        $datetime = date('Y-m-d H:i:s');
        $activity = array(
            'id_user' => '1', //sementara
            'datetime' => $datetime,
            'keterangan' => 'Menginput bukti kas dengan kode ' . $bukti_kas['kode_trx_kas'],
        );
        $this->M_log_activity->insertActivity($activity);

        unset($_SESSION['bukti_kas']);
        unset($_SESSION['detail_kas']);

        $this->session->set_flashdata("input_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil ditambahkan.<br></div>");
        redirect(base_url().'index.php/transaksi/kas/input');
    }

    function resetSession($reset)
    {
        $reset = str_replace('%7C', '|', $reset);
        $reset = explode('|', $reset);
        $session1 = $reset[0];
        $session2 = $reset[1];
        $redirect = $reset[2];
        $redirect = str_replace(':','/',$redirect);

        unset($_SESSION["$session1"]);
        unset($_SESSION["$session2"]);

        redirect(base_url()."index.php/transaksi/kas/$redirect");
    }

    public function createEditSession($kode = null)
    {
        if ($kode != null) {
            $_SESSION['edit_bukti_kas'][$kode] = $this->M_kas->getKas($kode)[0];
            $_SESSION['detail_edit_bukti_kas'][$kode] = $this->M_kas->getDetailKas($kode);
            
            redirect(base_url().'index.php/transaksi/kas/editKas/'.$kode);
        }
        else{
            show_404();
        }
    }

    public function editKas($kode="")
    {
        if ($kode != "") {
            $data['title'] = 'Edit Kas';
            $data['path'] = "transaksi/kas/edit-kas";
            // $data['nomor'] = $this->M_kas->getNomor(date('Y'), date('m'));
            $data['rekening'] = $this->M_kas->getRekening();
            $data['allRekening'] = $this->M_kas->getAllRekening();
            $data['edit_bukti_kas'] = $_SESSION['edit_bukti_kas'][$kode];                
            $data['detail_edit_bukti_kas'] = $_SESSION['detail_edit_bukti_kas'][$kode];
            
            if (!empty($this->input->post('edit_bukti_kas'))) {
                $_SESSION['edit_bukti_kas'][$kode]->tanggal = $this->input->post('tanggal');
                $_SESSION['edit_bukti_kas'][$kode]->kode_perkiraan = $this->input->post('kode_perkiraan');
                $_SESSION['edit_bukti_kas'][$kode]->tipe = $this->input->post('tipe');
                redirect(base_url().'index.php/transaksi/kas/editKas/'.$kode);
            }

            if (!empty($this->input->post('add_detail_bukti_kas'))) {

                $_SESSION['detail_edit_bukti_kas'][$kode][count($_SESSION['detail_edit_bukti_kas'][$kode])]->id_detail_trx_kas = $this->input->post('id_detail_trx_kas');

                $_SESSION['detail_edit_bukti_kas'][$kode][count($_SESSION['detail_edit_bukti_kas'][$kode]) - 1]->keterangan = $this->input->post('keterangan');

                $_SESSION['detail_edit_bukti_kas'][$kode][count($_SESSION['detail_edit_bukti_kas'][$kode]) - 1]->kode_trx_kas = $kode;

                $_SESSION['detail_edit_bukti_kas'][$kode][count($_SESSION['detail_edit_bukti_kas'][$kode]) - 1]->lawan = $this->input->post('lawan');

                $_SESSION['detail_edit_bukti_kas'][$kode][count($_SESSION['detail_edit_bukti_kas'][$kode]) - 1]->nominal = $this->input->post('nominal');
                
                redirect(base_url().'index.php/transaksi/kas/editKas/'.$kode);
            }
            

            $this->load->view('master_template',$data);
            
        }
    }

    public function deleteSessionDetailEdit($kode, $key)
    {
        if($_SESSION['detail_edit_bukti_kas'][$kode][$key]->id_detail_trx_kas != 0){
            $id = $_SESSION['detail_edit_bukti_kas'][$kode][$key]->id_detail_trx_kas;
            if(isset($_SESSION['edit_bukti_kas'][$kode]->del_id_detail_trx_kas) && count($_SESSION['edit_bukti_kas'][$kode]->del_id_detail_trx_kas) > 0){
                array_push($_SESSION['edit_bukti_kas'][$kode]->del_id_detail_trx_kas, $id);
            }
            else{
                $_SESSION['edit_bukti_kas'][$kode]->del_id_detail_trx_kas = [$id];
            }
        }
        
        unset($_SESSION['detail_edit_bukti_kas'][$kode][$key]);
        redirect(base_url().'index.php/transaksi/kas/editKas/'.$kode);
        
        // echo "<pre>";
        // print_r ($_SESSION['edit_bukti_kas'][$kode]);
        // echo "</pre>";
        
    }

    public function update($kode)
    {
        $edit_bukti_kas = $_SESSION['edit_bukti_kas'][$kode];
        $ttl = 0;
        $detail_edit_bukti_kas = $_SESSION['detail_edit_bukti_kas'][$kode];
        
        foreach ($detail_edit_bukti_kas as $key => $value) {
            $ttl = $ttl + $value->nominal;

            if ($value->id_detail_trx_kas == 0) {
                $newDetail = array(
                    'kode_trx_kas' => $value->kode_trx_kas,
                    'keterangan' => $value->keterangan,
                    'lawan' => $value->lawan,
                    'nominal' => $value->nominal,
                );
                $this->M_kas->insertData('ak_detail_trx_kas', $newDetail);
                $lastId = $this->M_kas->getLastId()[0];

                $jurnal = array(
                    'tanggal' => $edit_bukti_kas->tanggal. ' ' . date('H:i:s'),
                    'kode_transaksi' => $kode,
                    'keterangan' => $value->keterangan,
                    'kode' => $edit_bukti_kas->kode_perkiraan,
                    'lawan' => $value->lawan,
                    'tipe' => $edit_bukti_kas->tipe,
                    'nominal' => $value->nominal,
                    'tipe_trx_koperasi' => 'Kas',
                    'id_detail' => $lastId['lastId'],
                );
                $this->M_kas->insertData('ak_jurnal',$jurnal);
            }
            else{
                $detail = array(
                    'kode_trx_kas' => $value->kode_trx_kas,
                    'keterangan' => $value->keterangan,
                    'lawan' => $value->lawan,
                    'nominal' => $value->nominal,
                );
                $this->M_kas->updateData('ak_detail_trx_kas',$detail, ['id_detail_trx_kas' => $value->id_detail_trx_kas]);

                $jurnal = array(
                    'tanggal' => $edit_bukti_kas->tanggal. ' ' . date('H:i:s'),
                    'kode_transaksi' => $kode,
                    'keterangan' => $value->keterangan,
                    'kode' => $edit_bukti_kas->kode_perkiraan,
                    'lawan' => $value->lawan,
                    'tipe' => $edit_bukti_kas->tipe,
                    'nominal' => $value->nominal,
                );
                $this->M_kas->updateData('ak_jurnal',$jurnal, ['kode_transaksi' => $kode, 'id_detail' => $value->id_detail_trx_kas]);
            }
        }

        
        
        
        
        if(isset($_SESSION['edit_bukti_kas'][$kode]->del_id_detail_trx_kas) && count($_SESSION['edit_bukti_kas'][$kode]->del_id_detail_trx_kas) > 0){
            foreach ($_SESSION['edit_bukti_kas'][$kode]->del_id_detail_trx_kas as $key => $idDel) {
                // echo $idDel;
                $this->M_kas->deleteKas('ak_jurnal', ['kode_transaksi' => $kode, 'id_detail' => $idDel]);
                $this->M_kas->deleteKas("ak_detail_trx_kas",["id_detail_trx_kas" => $idDel]);
            }
        }

        $kas = array(
            'tanggal' => $edit_bukti_kas->tanggal,
            'kode_perkiraan' => $edit_bukti_kas->kode_perkiraan,
            'tipe' => $edit_bukti_kas->tipe,
            'grand_total' => $ttl
        );
        $this->M_kas->updateData('ak_trx_kas',$kas, ['kode_trx_kas' => $kode]);

        $datetime = date('Y-m-d H:i:s');
        $activity = array(
            'id_user' => '1', //sementara
            'datetime' => $datetime,
            'keterangan' => 'Mengedit bukti kas dengan kode ' . $kode,
        );
        $this->M_log_activity->insertActivity($activity);


        unset($_SESSION['edit_bukti_kas'][$kode]);
        unset($_SESSION['detail_edit_bukti_kas'][$kode]);

        $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil diperbarui.<br></div>");
        redirect(base_url().'index.php/transaksi/kas/createEditSession/'.$kode);
        
        // echo "<pre>";
        // print_r ($detail_edit_bukti_kas);
        // echo "</pre>";
        
    }

    // menghapus transaksi kas
    function deleteKas($kode)
    {
        $this->M_kas->deleteKas('ak_jurnal', ['kode_transaksi' => $kode]);
        $this->M_kas->deleteKas('ak_detail_trx_kas', ['kode_trx_kas' => $kode]);
        $this->M_kas->deleteKas('ak_trx_kas', ['kode_trx_kas' => $kode]);

        $datetime = date('Y-m-d H:i:s');
        $activity = array(
            'id_user' => '1', //sementara
            'datetime' => $datetime,
            'keterangan' => 'Menghapus bukti kas dengan kode ' . $kode,
        );
        $this->M_log_activity->insertActivity($activity);


        $this->session->set_flashdata("delete_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        redirect(base_url().'index.php/transaksi/kas/');
    }
}