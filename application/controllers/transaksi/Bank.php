<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Bank extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('transaksi/M_bank');
    }
    function index(){
        $data['title'] = 'Bank';
        $data['path'] = "transaksi/bank/list-bank";
        $data['bank'] = $this->M_bank->getAll();
        $this->load->view('master_template',$data);
    }

    public function getNomor()
    {
        $tgl = explode("-",$_POST['tanggal']);
        $year = $tgl[0];
        $month = $tgl[1];
        $nomor = $this->M_bank->getNomor($year, $month);
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
       $data['title'] = 'Input Bank';
       $data['path'] = "transaksi/bank/input-bank";
       $data['nomor'] = $this->M_bank->getNomor(date('Y'), date('m'));
       $data['rekening'] = $this->M_bank->getRekening();
       $data['allRekening'] = $this->M_bank->getAllRekening();
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
              $sess_input_bukti_bank = array(
                  'kode_trx_bank' => "BB"."-".$ym."-".$_POST['nomor'],
                  'tanggal' => $this->input->post('tanggal'),
                  'kode_perkiraan' => $this->input->post('kode_perkiraan'),
                  'tipe' => $this->input->post('tipe'),
                  'nomor' => $this->input->post('nomor'),
              );

              $_SESSION['bukti_bank'] = $sess_input_bukti_bank;
              redirect(base_url().'index.php/transaksi/bank/input');
          }
        }
        elseif (isset($_POST['add_detail'])) {
          $sess_detail = array(
                'kode_trx_bank' => $_SESSION['bukti_bank']['kode_trx_bank'],
                'lawan' => $this->input->post('lawan'),
                'nominal' => $this->input->post('nominal'),
                'keterangan' => $this->input->post('keterangan'),
            );
          $_SESSION['detail_bank'][] = $sess_detail;
          redirect(base_url().'index.php/transaksi/bank/input');
        }
        
        $this->load->view('master_template',$data);
        // $this->load->view('transaksi/bank/input-bank');
    }

    public function hapus_session_detail($key='')
    {
        // $_SESSION['ttl_detail_kas'] = $_SESSION['ttl_detail_kas'] - $_SESSION['detail_kas'][$key]['jumlah_rp'];
        unset($_SESSION['detail_bank'][$key]);
        redirect(base_url().'index.php/transaksi/bank/input');
    }
    
    // save trx bank
    function save()
    {
        $bukti_bank = $_SESSION['bukti_bank'];
        $bukti_bank['grand_total'] = 0;

        foreach ($_SESSION['detail_bank'] as $key => $value) {
            $bukti_bank['grand_total'] = $bukti_bank['grand_total'] + $value['nominal'];
        }

        $bank = array(
            'kode_trx_bank' => $bukti_bank['kode_trx_bank'],
            'tanggal' => $bukti_bank['tanggal'],
            'kode_perkiraan' => $bukti_bank['kode_perkiraan'],
            'tipe' => $bukti_bank['tipe'],
            'nomor' => $bukti_bank['nomor'],
            'grand_total' => $bukti_bank['grand_total'],
        );

        $this->M_bank->insertData('ak_trx_bank',$bank);
        
        $detail = $_SESSION['detail_bank'];
        foreach ($detail as $key => $value) {
            unset($value['key']);
            $jurnal = array();
            $this->M_bank->insertData('ak_detail_trx_bank',$value);
            $lastId = $this->M_bank->getLastId()[0];
            $jurnal = array(
                'tanggal' => $bukti_bank['tanggal']. ' ' . date('H:i:s'),
                'kode_transaksi' => $bukti_bank['kode_trx_bank'],
                'keterangan' => $value['keterangan'],
                'kode' => $bukti_bank['kode_perkiraan'],
                'lawan' => $value['lawan'],
                'tipe' => $bukti_bank['tipe'],
                'nominal' => $value['nominal'],
                'tipe_trx_koperasi' => 'Bank',
                'id_detail' => $lastId['lastId'],
            );

            $this->M_bank->insertData('ak_jurnal',$jurnal);
        }

        unset($_SESSION['bukti_bank']);
        unset($_SESSION['detail_bank']);

        $this->session->set_flashdata("input_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil ditambahkan.<br></div>");
        redirect(base_url().'index.php/transaksi/bank/input');
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

        redirect(base_url()."index.php/transaksi/bank/$redirect");
    }

    public function createEditSession($kode = null)
    {
        if ($kode != null) {
            $_SESSION['edit_bukti_bank'][$kode] = $this->M_bank->getBank($kode)[0];
            $_SESSION['detail_edit_bukti_bank'][$kode] = $this->M_bank->getDetailBank($kode);
            
            redirect(base_url().'index.php/transaksi/bank/editBank/'.$kode);
        }
        else{
            show_404();
        }
    }

    public function editBank($kode="")
    {
        if ($kode != "") {
            $data['title'] = 'Edit Bank';
            $data['path'] = "transaksi/bank/edit-bank";
            // $data['nomor'] = $this->M_bank->getNomor(date('Y'), date('m'));
            $data['rekening'] = $this->M_bank->getRekening();
            $data['allRekening'] = $this->M_bank->getAllRekening();
            $data['edit_bukti_bank'] = $_SESSION['edit_bukti_bank'][$kode];                
            $data['detail_edit_bukti_bank'] = $_SESSION['detail_edit_bukti_bank'][$kode];
            
            if (!empty($this->input->post('edit_bukti_bank'))) {
                $_SESSION['edit_bukti_bank'][$kode]->tanggal = $this->input->post('tanggal');
                $_SESSION['edit_bukti_bank'][$kode]->kode_perkiraan = $this->input->post('kode_perkiraan');
                $_SESSION['edit_bukti_bank'][$kode]->tipe = $this->input->post('tipe');
                redirect(base_url().'index.php/transaksi/bank/editBank/'.$kode);
            }

            if (!empty($this->input->post('add_detail_bukti_bank'))) {

                $_SESSION['detail_edit_bukti_bank'][$kode][count($_SESSION['detail_edit_bukti_bank'][$kode])]->id_detail_trx_bank = $this->input->post('id_detail_trx_bank');

                $_SESSION['detail_edit_bukti_bank'][$kode][count($_SESSION['detail_edit_bukti_bank'][$kode]) - 1]->keterangan = $this->input->post('keterangan');

                $_SESSION['detail_edit_bukti_bank'][$kode][count($_SESSION['detail_edit_bukti_bank'][$kode]) - 1]->kode_trx_bank = $kode;

                $_SESSION['detail_edit_bukti_bank'][$kode][count($_SESSION['detail_edit_bukti_bank'][$kode]) - 1]->lawan = $this->input->post('lawan');

                $_SESSION['detail_edit_bukti_bank'][$kode][count($_SESSION['detail_edit_bukti_bank'][$kode]) - 1]->nominal = $this->input->post('nominal');
                
                redirect(base_url().'index.php/transaksi/bank/editBank/'.$kode);
            }
            

            $this->load->view('master_template',$data);
            
        }
    }

    public function deleteSessionDetailEdit($kode, $key)
    {
        if($_SESSION['detail_edit_bukti_bank'][$kode][$key]->id_detail_trx_bank != 0){
            $id = $_SESSION['detail_edit_bukti_bank'][$kode][$key]->id_detail_trx_bank;
            if(isset($_SESSION['edit_bukti_bank'][$kode]->del_id_detail_trx_bank) && count($_SESSION['edit_bukti_bank'][$kode]->del_id_detail_trx_bank) > 0){
                array_push($_SESSION['edit_bukti_bank'][$kode]->del_id_detail_trx_bank, $id);
            }
            else{
                $_SESSION['edit_bukti_bank'][$kode]->del_id_detail_trx_bank = [$id];
            }
        }
        
        unset($_SESSION['detail_edit_bukti_bank'][$kode][$key]);
        redirect(base_url().'index.php/transaksi/bank/editBank/'.$kode);
        
        // echo "<pre>";
        // print_r ($_SESSION['edit_bukti_bank'][$kode]);
        // echo "</pre>";
        
    }

    public function update($kode)
    {
        $edit_bukti_bank = $_SESSION['edit_bukti_bank'][$kode];
        $ttl = 0;
        $detail_edit_bukti_bank = $_SESSION['detail_edit_bukti_bank'][$kode];
        
        foreach ($detail_edit_bukti_bank as $key => $value) {
            $ttl = $ttl + $value->nominal;

            if ($value->id_detail_trx_bank == 0) {
                $newDetail = array(
                    'kode_trx_bank' => $value->kode_trx_bank,
                    'keterangan' => $value->keterangan,
                    'lawan' => $value->lawan,
                    'nominal' => $value->nominal,
                );
                $this->M_bank->insertData('ak_detail_trx_bank', $newDetail);
                $lastId = $this->M_bank->getLastId()[0];

                $jurnal = array(
                    'tanggal' => $edit_bukti_bank->tanggal. ' ' . date('H:i:s'),
                    'kode_transaksi' => $kode,
                    'keterangan' => $value->keterangan,
                    'kode' => $edit_bukti_bank->kode_perkiraan,
                    'lawan' => $value->lawan,
                    'tipe' => $edit_bukti_bank->tipe,
                    'nominal' => $value->nominal,
                    'tipe_trx_koperasi' => 'Bank',
                    'id_detail' => $lastId['lastId'],
                );
                $this->M_bank->insertData('ak_jurnal',$jurnal);
            }
            else{
                $detail = array(
                    'kode_trx_bank' => $value->kode_trx_bank,
                    'keterangan' => $value->keterangan,
                    'lawan' => $value->lawan,
                    'nominal' => $value->nominal,
                );
                $this->M_bank->updateData('ak_detail_trx_bank',$detail, ['id_detail_trx_bank' => $value->id_detail_trx_bank]);

                $jurnal = array(
                    'tanggal' => $edit_bukti_bank->tanggal. ' ' . date('H:i:s'),
                    'kode_transaksi' => $kode,
                    'keterangan' => $value->keterangan,
                    'kode' => $edit_bukti_bank->kode_perkiraan,
                    'lawan' => $value->lawan,
                    'tipe' => $edit_bukti_bank->tipe,
                    'nominal' => $value->nominal,
                );
                $this->M_bank->updateData('ak_jurnal',$jurnal, ['kode_transaksi' => $kode, 'id_detail' => $value->id_detail_trx_bank]);
            }
        }

        
        
        
        
        if(isset($_SESSION['edit_bukti_bank'][$kode]->del_id_detail_trx_bank) && count($_SESSION['edit_bukti_bank'][$kode]->del_id_detail_trx_bank) > 0){
            foreach ($_SESSION['edit_bukti_bank'][$kode]->del_id_detail_trx_bank as $key => $idDel) {
                // echo $idDel;
                $this->M_bank->deleteBank('ak_jurnal', ['kode_transaksi' => $kode, 'id_detail' => $idDel]);
                $this->M_bank->deleteBank("ak_detail_trx_bank",["id_detail_trx_bank" => $idDel]);
            }
        }

        $bank = array(
            'tanggal' => $edit_bukti_bank->tanggal,
            'kode_perkiraan' => $edit_bukti_bank->kode_perkiraan,
            'tipe' => $edit_bukti_bank->tipe,
            'grand_total' => $ttl
        );
        $this->M_bank->updateData('ak_trx_bank',$bank, ['kode_trx_bank' => $kode]);

        unset($_SESSION['edit_bukti_bank'][$kode]);
        unset($_SESSION['detail_edit_bukti_bank'][$kode]);

        $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil diperbarui.<br></div>");
        redirect(base_url().'index.php/transaksi/bank/createEditSession/'.$kode);
        
        // echo "<pre>";
        // print_r ($detail_edit_bukti_bank);
        // echo "</pre>";
        
    }

    // menghapus transaksi bank
    function deleteBank($kode)
    {
        $this->M_bank->deleteBank('ak_jurnal', ['kode_transaksi' => $kode]);
        $this->M_bank->deleteBank('ak_detail_trx_bank', ['kode_trx_bank' => $kode]);
        $this->M_bank->deleteBank('ak_trx_bank', ['kode_trx_bank' => $kode]);

        $this->session->set_flashdata("delete_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        redirect(base_url().'index.php/transaksi/bank/');
    }
}