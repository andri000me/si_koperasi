<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class LabaRugi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('general-ledger/M_laba_rugi');
    }

    // laba rugi harian
    function index()
    {
        $data['title'] = 'Laba Rugi';
        $data['path'] = "general-ledger/laba-rugi-harian.php";
        // $data['allRekening'] = $this->M_laba_rugi->getAllRekening(); 
        
        if (!empty($_GET['tanggal']) ) {
            $data['rekeningPendapatan'] = $this->M_laba_rugi->getAllRekening('Pendapatan');
            $data['rekeningBiaya'] = $this->M_laba_rugi->getAllRekening('Biaya');
            $data['rekeningBiayaNonOperasional'] = $this->M_laba_rugi->getAllRekening('BiayaNonOperasional');
          $data['rekeningPajakPenghasilan'] = $this->M_laba_rugi->getAllRekening('PajakPenghasilan');
        }
        else{
            // $data['rekening'] = $this->M_laba_rugi->getSomeRekening($_GET['kode'], $_GET['rk_sampai']);
        }

        $this->load->view('master_template', $data);
    }

    // laba rugi bulanan
    public function lrBulanan()
    {
        $data['title'] = 'Laba Rugi';
        $data['path'] = "general-ledger/laba-rugi-bulanan.php";
        // $data['allRekening'] = $this->M_laba_rugi->getAllRekening(); 
        
        if (!empty($_GET['bulan']) && !empty('tahun') ) {
          $data['rekeningPendapatan'] = $this->M_laba_rugi->getAllRekening('Pendapatan');
          $data['rekeningBiaya'] = $this->M_laba_rugi->getAllRekening('Biaya');
          $data['rekeningBiayaNonOperasional'] = $this->M_laba_rugi->getAllRekening('BiayaNonOperasional');
          $data['rekeningPajakPenghasilan'] = $this->M_laba_rugi->getAllRekening('PajakPenghasilan');
        }
        else{
            // $data['rekening'] = $this->M_laba_rugi->getSomeRekening($_GET['kode'], $_GET['rk_sampai']);
        }

        $this->load->view('master_template', $data);
    }


}
