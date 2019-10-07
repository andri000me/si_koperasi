<?php
Class User extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_user');
    }
    function index(){
        $data['path'] = 'user/v_user';
        $data['user'] = $this->M_user->getUser();
        $this->load->view('master_template',$data);
    }
    function add(){
        $config = array(
            array(
                'field' => 'nama_terang',
                'label' => 'Nama Terang',
                'rules' => 'required'
            ),
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'repassword',
                'label' => 'Re-Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'hak_akses',
                'label' => 'Hak Akses',
                'rules' => 'required'
            ),
            array(
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            if($this->input->post('password') == $this->input->post('repassword')){ //Pasword Sama
                $data = array(
                    'nama_terang' => $this->input->post('nama_terang'),
                    'username' => $this->input->post('username'),
                    'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
                    'level' => $this->input->post('hak_akses'),
                    'status' => $this->input->post('status')
                );
                if($this->M_user->addUser($data) == TRUE){
                    $this->session->set_flashdata("input_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan!!</div>");
                }else{
                    $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!</div>");
                }
            }else{ //Password Tidak Sama
                $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Password Tidak Sama!!</div>");
            }
        }else{
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        redirect('user');
    }
    function edit(){
        $id_user = $this->input->post('id');
        $data['user'] = $this->M_user->get1User(array('id_user' => $id_user));
        $this->load->view('user/edit_user',$data);
    }
    function editpassword(){
        $data['id_user'] = $this->input->post('id');
        $this->load->view('user/change_password',$data);
    }
    function editPasswordBySelf(){
        $data['path'] = "user/v_change_pw_byself";
        $this->load->view('master_template',$data);
    }
    function update(){
        $config = array(
            array(
                'field' => 'id_user',
                'label' => 'ID User',
                'rules' => 'required'
            ),
            array(
                'field' => 'nama_terang',
                'label' => 'Nama Terang',
                'rules' => 'required'
            ),
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ),
            array(
                'field' => 'hak_akses',
                'label' => 'Hak Akses',
                'rules' => 'required'
            ),
            array(
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            $where = array(
                'id_user' => $this->input->post('id_user')
            );
            $data = array(
                'nama_terang' => $this->input->post('nama_terang'),
                'username' => $this->input->post('username'),
                'level' => $this->input->post('hak_akses'),
                'status' => $this->input->post('status')
            );
            if($this->M_user->updateUser($where,$data) == TRUE){
                $this->session->set_flashdata("update_success","<div class='alert alert-success'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Diubah!!</div>");
            }else{
                $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!</div>");
            }
            
        }else{
            $gagal = validation_errors();
            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!<br>".$gagal."</div>");
        }
        redirect('user');
    }
    function updatePassword(){
        $config = array(
            array(
                'field' => 'password',
                'label' => 'New Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'repassword',
                'label' => 'Re-Password',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            if($this->input->post('password') == $this->input->post('repassword')){
                $where = array(
                    'id_user' => $this->input->post('id_user')
                );
                $data = array(
                    'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT)
                );
                if($this->M_user->updateUser($where,$data) == TRUE){
                    $this->session->set_flashdata("update_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Diubah!!</div>");
                }else{
                    $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!</div>");
                }
            }else{
                $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!</div>");
            }
            
            
        }else{
            $gagal = validation_errors();
            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!<br>".$gagal."</div>");
        }
        redirect('user');
    }
    function updatePasswordBySelf(){
        $config = array(
            array(
                'field' => 'oldpassword',
                'label' => 'Old Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'password',
                'label' => 'New Password',
                'rules' => 'required'
            ),
            array(
                'field' => 'repassword',
                'label' => 'Re-Password',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            $where = array(
                'id_user' => $this->input->post('id_user')
            );
            $old_data_user = $this->M_user->get1User($where);
            foreach($old_data_user as $u){
                if(password_verify($this->input->post('oldpassword'),$u->password)){
                    if($this->input->post('password') == $this->input->post('repassword')){ //Pasword Sama
                        $data = array(
                            'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT)
                        );
                        if($this->M_user->updateUser($where,$data) == TRUE){
                            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Diubah!!</div>");
                        }else{
                            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!</div>");
                        }
                    }else{
                        $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Password Tidak Sama!!</div>");
                    }    
                }else{
                    $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Password Tidak Sama!!</div>");
                }
            }
            
            
        }else{
            $gagal = validation_errors();
            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!<br>".$gagal."</div>");
            
        }
        redirect('user/editPasswordBySelf');
    }
    function disableAccount($id){
        $where = array(
            'id_user' => $id
        );
        $data = array(
            'status' => '0'
        );
        if($this->M_user->updateUser($where,$data) == TRUE){
            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Akun Berhasil Dinonaktifkan!!</div>");
        }else{
            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Akun Gagal Dinonaktifkan!!</div>");
        }
        redirect('user');
    }
    function enableAccount($id){
        $where = array(
            'id_user' => $id
        );
        $data = array(
            'status' => '1'
        );
        if($this->M_user->updateUser($where,$data) == TRUE){
            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Akun Berhasil Diaktifkan!!</div>");
        }else{
            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Akun Gagal Diaktifkan!!</div>");
        }
        redirect('user');
    }
    function delete($id){
        $where = array(
            'id_user' => $id
        );
        if($this->M_user->deleteUser($where)==TRUE){
            $this->session->set_flashdata("delete_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Dihapus!!</div>");
        }else{
            $this->session->set_flashdata("delete_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Dihapus!!</div>");
        }
        redirect('user');
    }
}