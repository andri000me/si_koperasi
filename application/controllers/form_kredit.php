<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class form_kredit extends CI_Controller{

	function index(){
		$data['path'] = 'form_kredit/form_kredit_baru';
		$this->load->view('master_template',$data);
	}
}
?>