<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Sijaka extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_sijaka');
    }

    function bukaRekeningSijaka(){
        $data['path'] = 'sijaka/form_rekening_baru';
        $this->load->view('master_template',$data);
    }

    function daftarNominatifSijaka(){
        $data['path'] = 'sijaka/daftar_nominatif_sijaka';
        $this->load->view('master_template',$data);
    }

    function perhitunganAkhirBulanSijaka(){
        $data['path'] = 'sijaka/perhitungan_akhir_bulan_sijaka';
        $this->load->view('master_template',$data);
    }

    function kelolaRekeningSijaka(){
        $data['path'] = 'sijaka/kelola_rekening_sijaka';
        $this->load->view('master_template',$data);
    }
}
?>