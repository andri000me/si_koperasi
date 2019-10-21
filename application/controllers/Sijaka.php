<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Sijaka extends CI_Controller{

    function index(){
        $data['path'] = 'sijaka/form_rekening_baru';
        $this->load->view('master_template',$data);
    }
}
?>