<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Daftar_nominatif_kredit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_daftar_nominatif_kredit');
    }

    function index()
    {
        $data['title'] = 'Daftar Nominatif Kredit/Pembayaran';
        $data['path'] = "daftar_nominatif_kredit/v_daftar_nominatif_kredit";
        // $data['simpanan_wajib'] = $this->M_simpanan_wajib->getSimpananpokok();
        $this->load->view('master_template', $data);
    }
}
