<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Simpanan_pokok extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_simpanan_pokok');
    }
    function index()
    {
        $data['title'] = 'Simpanan Pokok';
        $data['path'] = "simpanan_pokok/v_simpanan_pokok";
        $data['simpanan_pokok'] = $this->M_simpanan_pokok->getSimpananpokok();
        $this->load->view('master_template', $data);
    }
    //function add() digunakan untuk aksi input ke tabel simpanan pokok
    function add()
    {
        $config = array(
            array(
                'field' => 'no_anggota',
                'label' => 'No Anggota',
                'rules' => 'required'
            ),
            array(
                'field' => 'nama_anggota',
                'label' => 'Nama Anggota',
                'rules' => 'required'
            ),
            array(),
            array(),
            array(),
        );
    }
}
