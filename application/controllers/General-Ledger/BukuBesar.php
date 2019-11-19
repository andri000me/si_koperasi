<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class BukuBesar extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // $this->load->model('general-ledger/M_buku_besar');
    }

    function index()
    {
        $data['path'] = 'general-ledger/buku-besar';
        $data['allRekening'] = $this->M_buku_besar->getAllRekening();
        
        if (!empty($_GET['kode']) && empty($_GET['rk_sampai'])) {
            $data['kode'] = $this->M_buku_besar->getOneRekening($_GET['kode']);
        }
        elseif (!empty($_GET['kode']) && !empty($_GET['rk_sampai'])) {
            $data['kode'] = $this->M_buku_besar->getSomeRekening($_GET['kode'], $_GET['rk_sampai']);
        }
        
        $this->load->view('master_template', $data);
    }
}
?>