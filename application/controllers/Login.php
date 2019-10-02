<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_user');
    }
    function index(){
        $this->load->view('login');
    }
    function login_act(){
        $config = array(
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $where = array(
                'username' => $username
            );
            if($this->M_user->countUser($where) == 1){
                $user = $this->M_user->get1User($where);
                foreach($user as $s){
                    $_id = $s->id_user;
                    $nama_terang = $s->nama_terang;
                    $dbpassword = $s->password;
                    $level = $s->level;
                    $status = $s->status;
                    
                }
                if(password_verify($password,$dbpassword)){
                    if($status == 1){
                        $login_data = array(
                            '_id' => $_id,
                            'username' => $username,
                            'nama_terang' => $nama_terang,
                            'level' => $level,
                            '_login' => TRUE
                        );
                        $this->session->set_userdata($login_data);
                        redirect('dashboard');
                    }else{
                        $this->session->set_flashdata("login_failed","<div class='alert alert-danger'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Username Atau Password Salah</div>");
                    }
                }else{
                    $this->session->set_flashdata("login_failed","<div class='alert alert-danger'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Username Atau Password Salah</div>");
                }
            }else{
                $this->session->set_flashdata("login_failed","<div class='alert alert-danger'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Username Atau Password Salah</div>");
            }
            
        }else{
            $this->session->set_flashdata("login_failed","<div class='alert alert-danger'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Username & Password Wajib Diisi</div>");
        }
        redirect("login");
    }
    function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }

}