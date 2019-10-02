<?php
defined("BASEPATH") or die("No Direct Access Allowed");

Class Dashboard extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    function index(){
        $data['title'] = "Dashboard";
        $data['path'] = "dashboard/v_dashboard";
        $this->load->view("master_template",$data);
    }
}
