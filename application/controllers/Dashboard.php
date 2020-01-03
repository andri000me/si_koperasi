<?php
defined("BASEPATH") or die("No Direct Access Allowed");

Class Dashboard extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_simuda');
        $this->load->model('M_anggota');
        $this->load->model('M_sijaka');
        $this->load->model('M_kredit');
    }
    function index(){
        $data['title'] = "Dashboard";
        $data['ttlAnggota'] = $this->M_anggota->getTtlAnggota();
        $data['ttlRekSimuda'] = $this->M_simuda->getTtlRek();
        $data['ttlRekSijaka'] = $this->M_sijaka->getTtlRekSijaka();
        $data['ttlRekKredit'] = $this->M_kredit->getTtlRekKredit();
        $data['path'] = "dashboard/v_dashboard";
        $this->load->view("master_template",$data);
    }
}
