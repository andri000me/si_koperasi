<?php
Class LogActivity extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_log_activity');
        $this->load->model('M_user');
    }
    
    function index(){
      $data['path'] = 'log-activity/log-activity';
      $data['user'] = $this->M_user->getUser();

      if (!empty($_GET['tanggal']) && empty($_GET['id_user'])) {
        $data['activities'] = $this->M_log_activity->getByDate($_GET['tanggal']);
      }
      else if (empty($_GET['tanggal']) && !empty($_GET['id_user'])) {
        $data['activities'] = $this->M_log_activity->getByUser($_GET['id_user']);
      }
      else if (!empty($_GET['tanggal']) && !empty($_GET['id_user'])) {
        $data['activities'] = $this->M_log_activity->getByDateAndUser($_GET['tanggal'], $_GET['id_user']);
      }
      else{
        $data['activities'] = $this->M_log_activity->getAll();
      }

      $this->load->view('master_template',$data);  
    }
}