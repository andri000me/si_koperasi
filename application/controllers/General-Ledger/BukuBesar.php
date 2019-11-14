<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class BukuBesar extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_GeneralLedger');
    }

    function index()
    {
        $data['path'] = 'General_Ledger/buku_besar';
        $this->load->view('master_template', $data);
    }
}
?>