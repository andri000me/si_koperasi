<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class LaporanKas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/M_kas');
    }

    function index()
    {
        $data['path'] = 'transaksi/laporan-kas/laporan-kas';
        $data['rekening'] = $this->M_kas->getRekening();
        
        if (!empty($_GET['kode']) && empty($_GET['rk_sampai'])) {
            $data['namaRekening'] = $this->M_kas->getOneRekening($_GET['kode'])[0];

            $data['laporanKas'] = $this->M_kas->laporanKas($_GET['kode'], $_GET['dari'], $_GET['sampai']);
        }
        
        $this->load->view('master_template', $data);
    }
}
?>