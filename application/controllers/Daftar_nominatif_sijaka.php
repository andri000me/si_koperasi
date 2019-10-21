<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Daftar_nominatif_sijaka extends CI_Controller{

    function index(){
        $data['path'] = 'sijaka/daftar_nominatif_sijaka';
        $this->load->view('master_template',$data);
    }   
}
?>
