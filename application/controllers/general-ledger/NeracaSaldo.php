<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class NeracaSaldo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('general-ledger/M_neraca_saldo');
    }
    function index()
    {
        $data['title'] = 'Neraca Saldo';
        $data['path'] = "general-ledger/neraca-saldo.php";
        $data['allRekening'] = $this->M_neraca_saldo->getAllRekening();   
        
        if (!empty($_GET['dari']) && !empty($_GET['sampai']) && !empty($_GET['kode']) ) {
            if ($_GET['kode'] == 'semua') {
                $data['rekening'] = $this->M_neraca_saldo->getAllRekening($_GET['kode']);
            }
            else{
                $data['rekening'] = $this->M_neraca_saldo->getSomeRekening($_GET['kode'], $_GET['rk_sampai']);
            }
        }

        $this->load->view('master_template', $data);
    }


}
