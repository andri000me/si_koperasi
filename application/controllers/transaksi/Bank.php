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

        unset($_SESSION["$session1"]);
        unset($_SESSION["$session2"]);

        redirect(base_url()."index.php/transaksi/bank/$redirect");
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