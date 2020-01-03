<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Memorial extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('transaksi/M_memorial');
        $this->load->model('M_log_activity');
    }
    function index(){
        $data['title'] = 'Memorial';
        $data['path'] = "transaksi/memorial/list-memorial";
        $data['memorial'] = $this->M_memorial->getAll();
        $this->load->view('master_template',$data);
    }

    public function getNomor()
    {
        $tgl = explode("-",$_POST['tanggal']);
        $year = $tgl[0];
        $month = $tgl[1];
        $nomor = $this->M_memorial->getNomor($year, $month);
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
       $data['title'] = 'Input Memorial';
       $data['path'] = "transaksi/memorial/input-memorial";
       $data['nomor'] = $this->M_memorial->getNomor(date('Y'), date('m'));
      //  $data['rekening'] = $this->M_memorial->getRekening();
       $data['allRekening'] = $this->M_memorial->getAllRekening();
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
        );

        $this->form_validation->set_rules($config);
        if (isset($_POST['tanggal'])) {
          if($this->form_validation->run() == TRUE){
              $tgl = explode("-",$_POST['tanggal']);
              $year = $tgl[0];
              $month = $tgl[1];
              $ym = substr($year,2,2).$month;
              $sess_input_bukti_memorial = array(
                  'kode_trx_memorial' => "BM"."-".$ym."-".$_POST['nomor'],
                  'tanggal' => $this->input->post('tanggal'),
                  'tipe' => $this->input->post('tipe'),
                  'nomor' => $this->input->post('nomor'),
              );

              $_SESSION['bukti_memorial'] = $sess_input_bukti_memorial;
              redirect(base_url().'index.php/transaksi/memorial/input');
          }
        }
        elseif (isset($_POST['add_detail'])) {
          $sess_detail = array(
                'kode_trx_memorial' => $_SESSION['bukti_memorial']['kode_trx_memorial'],
                'kode_perkiraan' => $this->input->post('kode_perkiraan'),
                'lawan' => $this->input->post('lawan'),
                'nominal' => $this->input->post('nominal'),
                'keterangan' => $this->input->post('keterangan'),
            );
          $_SESSION['detail_memorial'][] = $sess_detail;
          redirect(base_url().'index.php/transaksi/memorial/input');
        }
        
        $this->load->view('master_template',$data);
        // $this->load->view('transaksi/memorial/input-memorial');
    }

    public function hapus_session_detail($key='')
    {
        // $_SESSION['ttl_detail_kas'] = $_SESSION['ttl_detail_kas'] - $_SESSION['detail_kas'][$key]['jumlah_rp'];
        unset($_SESSION['detail_memorial'][$key]);
        redirect(base_url().'index.php/transaksi/memorial/input');
    }
    
    // save trx memorial
    function save()
    {
        $bukti_memorial = $_SESSION['bukti_memorial'];
        $bukti_memorial['grand_total'] = 0;

        foreach ($_SESSION['detail_memorial'] as $key => $value) {
            $bukti_memorial['grand_total'] = $bukti_memorial['grand_total'] + $value['nominal'];
        }

        $memorial = array(
            'kode_trx_memorial' => $bukti_memorial['kode_trx_memorial'],
            'tanggal' => $bukti_memorial['tanggal'],
            'tipe' => $bukti_memorial['tipe'],
            'nomor' => $bukti_memorial['nomor'],
            'grand_total' => $bukti_memorial['grand_total'],
        );

        $this->M_memorial->insertData('ak_trx_memorial',$memorial);
        
        $detail = $_SESSION['detail_memorial'];
        foreach ($detail as $key => $value) {
            unset($value['key']);
            $jurnal = array();
            $this->M_memorial->insertData('ak_detail_trx_memorial',$value);
            $lastId = $this->M_memorial->getLastId()[0];
            $jurnal = array(
                'tanggal' => $bukti_memorial['tanggal']. ' ' . date('H:i:s'),
                'kode_transaksi' => $bukti_memorial['kode_trx_memorial'],
                'keterangan' => $value['keterangan'],
                'kode' => $value['kode_perkiraan'],
                'lawan' => $value['lawan'],
                'tipe' => $bukti_memorial['tipe'],
                'nominal' => $value['nominal'],
                'tipe_trx_koperasi' => 'Memorial',
                'id_detail' => $lastId['lastId'],
            );

            $this->M_memorial->insertData('ak_jurnal',$jurnal);
        }

        $datetime = date('Y-m-d H:i:s');
        $activity = array(
            'id_user' => '1', //sementara
            'datetime' => $datetime,
            'keterangan' => 'Menginput bukti memorial dengan kode ' . $bukti_memorial['kode_trx_memorial'],
        );
        $this->M_log_activity->insertActivity($activity);

        unset($_SESSION['bukti_memorial']);
        unset($_SESSION['detail_memorial']);

        $this->session->set_flashdata("input_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil ditambahkan.<br></div>");
        redirect(base_url().'index.php/transaksi/memorial/input');
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

        redirect(base_url()."index.php/transaksi/memorial/$redirect");
    }

    public function createEditSession($kode = null)
    {
        if ($kode != null) {
            $_SESSION['edit_bukti_memorial'][$kode] = $this->M_memorial->getMemorial($kode)[0];
            $_SESSION['detail_edit_bukti_memorial'][$kode] = $this->M_memorial->getDetailMemorial($kode);
            
            redirect(base_url().'index.php/transaksi/memorial/editMemorial/'.$kode);
        }
        else{
            show_404();
        }
    }

    public function editMemorial($kode="")
    {
        if ($kode != "") {
            $data['title'] = 'Edit Memorial';
            $data['path'] = "transaksi/memorial/edit-memorial";
            // $data['nomor'] = $this->M_memorial->getNomor(date('Y'), date('m'));
            $data['rekening'] = $this->M_memorial->getAllRekening();
            // $data['allRekening'] = $this->M_memorial->getAllRekening();
            $data['edit_bukti_memorial'] = $_SESSION['edit_bukti_memorial'][$kode];                
            $data['detail_edit_bukti_memorial'] = $_SESSION['detail_edit_bukti_memorial'][$kode];
            
            if (!empty($this->input->post('edit_bukti_memorial'))) {
                $_SESSION['edit_bukti_memorial'][$kode]->tanggal = $this->input->post('tanggal');
                // $_SESSION['edit_bukti_memorial'][$kode]->kode_perkiraan = $this->input->post('kode_perkiraan');
                $_SESSION['edit_bukti_memorial'][$kode]->tipe = $this->input->post('tipe');
                redirect(base_url().'index.php/transaksi/memorial/editMemorial/'.$kode);
            }

            if (!empty($this->input->post('add_detail_bukti_memorial'))) {

                $_SESSION['detail_edit_bukti_memorial'][$kode][count($_SESSION['detail_edit_bukti_memorial'][$kode])]->id_detail_trx_memorial = $this->input->post('id_detail_trx_memorial');

                $_SESSION['detail_edit_bukti_memorial'][$kode][count($_SESSION['detail_edit_bukti_memorial'][$kode]) - 1]->keterangan = $this->input->post('keterangan');

                $_SESSION['detail_edit_bukti_memorial'][$kode][count($_SESSION['detail_edit_bukti_memorial'][$kode]) - 1]->kode_trx_memorial = $kode;

                $_SESSION['detail_edit_bukti_memorial'][$kode][count($_SESSION['detail_edit_bukti_memorial'][$kode]) - 1]->kode_perkiraan = $this->input->post('kode_perkiraan');

                $_SESSION['detail_edit_bukti_memorial'][$kode][count($_SESSION['detail_edit_bukti_memorial'][$kode]) - 1]->lawan = $this->input->post('lawan');

                $_SESSION['detail_edit_bukti_memorial'][$kode][count($_SESSION['detail_edit_bukti_memorial'][$kode]) - 1]->nominal = $this->input->post('nominal');
                
                redirect(base_url().'index.php/transaksi/memorial/editMemorial/'.$kode);
            }
            

            $this->load->view('master_template',$data);
            
        }
    }

    public function deleteSessionDetailEdit($kode, $key)
    {
        if($_SESSION['detail_edit_bukti_memorial'][$kode][$key]->id_detail_trx_memorial != 0){
            $id = $_SESSION['detail_edit_bukti_memorial'][$kode][$key]->id_detail_trx_memorial;
            if(isset($_SESSION['edit_bukti_memorial'][$kode]->del_id_detail_trx_memorial) && count($_SESSION['edit_bukti_memorial'][$kode]->del_id_detail_trx_memorial) > 0){
                array_push($_SESSION['edit_bukti_memorial'][$kode]->del_id_detail_trx_memorial, $id);
            }
            else{
                $_SESSION['edit_bukti_memorial'][$kode]->del_id_detail_trx_memorial = [$id];
            }
        }
        
        unset($_SESSION['detail_edit_bukti_memorial'][$kode][$key]);
        redirect(base_url().'index.php/transaksi/memorial/editMemorial/'.$kode);
        
        // echo "<pre>";
        // print_r ($_SESSION['edit_bukti_memorial'][$kode]);
        // echo "</pre>";
        
    }

    public function update($kode)
    {
        $edit_bukti_memorial = $_SESSION['edit_bukti_memorial'][$kode];
        $ttl = 0;
        $detail_edit_bukti_memorial = $_SESSION['detail_edit_bukti_memorial'][$kode];
        
        foreach ($detail_edit_bukti_memorial as $key => $value) {
            $ttl = $ttl + $value->nominal;

            if ($value->id_detail_trx_memorial == 0) {
                $newDetail = array(
                    'kode_trx_memorial' => $value->kode_trx_memorial,
                    'keterangan' => $value->keterangan,
                    'kode_perkiraan' => $value->kode_perkiraan,
                    'lawan' => $value->lawan,
                    'nominal' => $value->nominal,
                );
                $this->M_memorial->insertData('ak_detail_trx_memorial', $newDetail);
                $lastId = $this->M_memorial->getLastId()[0];

                $jurnal = array(
                    'tanggal' => $edit_bukti_memorial->tanggal. ' ' . date('H:i:s'),
                    'kode_transaksi' => $kode,
                    'keterangan' => $value->keterangan,
                    'kode' => $value->kode_perkiraan,
                    'lawan' => $value->lawan,
                    'tipe' => $edit_bukti_memorial->tipe,
                    'nominal' => $value->nominal,
                    'tipe_trx_koperasi' => 'Memorial',
                    'id_detail' => $lastId['lastId'],
                );
                $this->M_memorial->insertData('ak_jurnal',$jurnal);
            }
            else{
                $detail = array(
                    'kode_trx_memorial' => $value->kode_trx_memorial,
                    'keterangan' => $value->keterangan,
                    'kode_perkiraan' => $value->kode_perkiraan,
                    'lawan' => $value->lawan,
                    'nominal' => $value->nominal,
                );
                $this->M_memorial->updateData('ak_detail_trx_memorial',$detail, ['id_detail_trx_memorial' => $value->id_detail_trx_memorial]);

                $jurnal = array(
                    'tanggal' => $edit_bukti_memorial->tanggal. ' ' . date('H:i:s'),
                    'kode_transaksi' => $kode,
                    'keterangan' => $value->keterangan,
                    'kode' => $value->kode_perkiraan,
                    'lawan' => $value->lawan,
                    'tipe' => $edit_bukti_memorial->tipe,
                    'nominal' => $value->nominal,
                );
                $this->M_memorial->updateData('ak_jurnal',$jurnal, ['kode_transaksi' => $kode, 'id_detail' => $value->id_detail_trx_memorial]);
            }
        }

        
        
        
        
        if(isset($_SESSION['edit_bukti_memorial'][$kode]->del_id_detail_trx_memorial) && count($_SESSION['edit_bukti_memorial'][$kode]->del_id_detail_trx_memorial) > 0){
            foreach ($_SESSION['edit_bukti_memorial'][$kode]->del_id_detail_trx_memorial as $key => $idDel) {
                // echo $idDel;
                $this->M_memorial->deleteMemorial('ak_jurnal', ['kode_transaksi' => $kode, 'id_detail' => $idDel]);
                $this->M_memorial->deleteMemorial("ak_detail_trx_memorial",["id_detail_trx_memorial" => $idDel]);
            }
        }

        $memorial = array(
            'tanggal' => $edit_bukti_memorial->tanggal,
            // 'kode_perkiraan' => $edit_bukti_memorial->kode_perkiraan,
            'tipe' => $edit_bukti_memorial->tipe,
            'grand_total' => $ttl
        );
        $this->M_memorial->updateData('ak_trx_memorial',$memorial, ['kode_trx_memorial' => $kode]);

        $datetime = date('Y-m-d H:i:s');
        $activity = array(
            'id_user' => '1', //sementara
            'datetime' => $datetime,
            'keterangan' => 'Mengedit bukti memorial dengan kode ' . $kode,
        );
        $this->M_log_activity->insertActivity($activity);

        unset($_SESSION['edit_bukti_memorial'][$kode]);
        unset($_SESSION['detail_edit_bukti_memorial'][$kode]);

        $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil diperbarui.<br></div>");
        redirect(base_url().'index.php/transaksi/memorial/createEditSession/'.$kode);
        
        // echo "<pre>";
        // print_r ($detail_edit_bukti_memorial);
        // echo "</pre>";
        
    }

    // menghapus transaksi memorial
    function deleteMemorial($kode)
    {
        $this->M_memorial->deleteMemorial('ak_jurnal', ['kode_transaksi' => $kode]);
        $this->M_memorial->deleteMemorial('ak_detail_trx_memorial', ['kode_trx_memorial' => $kode]);
        $this->M_memorial->deleteMemorial('ak_trx_memorial', ['kode_trx_memorial' => $kode]);

        $datetime = date('Y-m-d H:i:s');
        $activity = array(
            'id_user' => '1', //sementara
            'datetime' => $datetime,
            'keterangan' => 'Menghapus bukti memorial dengan kode ' . $kode,
        );
        $this->M_log_activity->insertActivity($activity);


        $this->session->set_flashdata("delete_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        redirect(base_url().'index.php/transaksi/memorial/');
    }
}