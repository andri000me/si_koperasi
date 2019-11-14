<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Kas extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('transaksi/M_kas');
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

        unset($_SESSION["$session1"]);
        unset($_SESSION["$session2"]);

        redirect(base_url()."index.php/transaksi/kas/$redirect");
    }

    // menghapus transaksi kas
    function deleteKas($kode)
    {
        $this->M_kas->deleteKas('ak_jurnal', ['kode_transaksi' => $kode]);
        $this->M_kas->deleteKas('ak_detail_trx_kas', ['kode_trx_kas' => $kode]);
        $this->M_kas->deleteKas('ak_trx_kas', ['kode_trx_kas' => $kode]);

        $this->session->set_flashdata("delete_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        redirect(base_url().'index.php/transaksi/kas/');
    }
}