<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Test extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_anggota');
        
    }
    function getData($id){
        // echo "AA";
        $where = array('no_anggota' => $id);
        $data = $this->M_anggota->get1Anggota($where);
        $no = 0;
        foreach($data as $val){
            echo $no++;
        }

    }
}