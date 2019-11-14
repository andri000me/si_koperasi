<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Memorial extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('transaksi/M_memorial');
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

        unset($_SESSION["$session1"]);
        unset($_SESSION["$session2"]);

        redirect(base_url()."index.php/transaksi/memorial/$redirect");
    }

    // menghapus transaksi memorial
    function deleteMemorial($kode)
    {
        $this->M_memorial->deleteMemorial('ak_jurnal', ['kode_transaksi' => $kode]);
        $this->M_memorial->deleteMemorial('ak_detail_trx_memorial', ['kode_trx_memorial' => $kode]);
        $this->M_memorial->deleteMemorial('ak_trx_memorial', ['kode_trx_memorial' => $kode]);

        $this->session->set_flashdata("delete_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        redirect(base_url().'index.php/transaksi/memorial/');
    }
}