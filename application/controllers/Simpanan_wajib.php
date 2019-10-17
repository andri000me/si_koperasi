<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Simpanan_wajib extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_simpanan_wajib');
    }
    function index()
    {
        $data['title'] = 'Simpanan Wajib';
        $data['path'] = "simpanan_wajib/v_simpanan_wajib";
        $data['simpanan_wajib'] = $this->M_simpanan_wajib->getSimpananpokok();
        $this->load->view('master_template', $data);
    }
}
