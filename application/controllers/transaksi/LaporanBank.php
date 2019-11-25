<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class LaporanBank extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/M_bank');
    }

    function index()
    {
        $data['path'] = 'transaksi/laporan-bank/laporan-bank';
        $data['rekening'] = $this->M_bank->getRekening();
        
        if (!empty($_GET['kode']) && empty($_GET['rk_sampai'])) {
            $data['namaRekening'] = $this->M_bank->getOneRekening($_GET['kode'])[0];

            $data['laporanBank'] = $this->M_bank->laporanBank($_GET['kode'], $_GET['dari'], $_GET['sampai']);
        }
        
        $this->load->view('master_template', $data);
    }
}
?>