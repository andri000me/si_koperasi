<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Simuda extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_simuda');
        $this->load->model('M_anggota');    
    }
    //Form Buka Rekening
    function bukaRekening(){
        $data['path'] = 'simuda/buka_rekening';
        $data['anggota'] = $this->M_anggota->getAnggota();
        $this->load->view('master_template',$data);
    }
    function manageAjaxGetDataAnggota(){
        
        $no_anggota = $this->input->post('id');
        $data['anggota'] = $this->M_anggota->get1Anggota(array('no_anggota' => $no_anggota));
        $this->load->view('simuda/get_data_anggota',$data);
    }
    function simpanRekeningBaru(){
        $config = array(
            array('field'=>'no_rekening_simuda','label'=>'No. Rekening Simuda','rules'=>'required'),
            array('field'=>'no_anggota','label'=>'No. Anggota','rules'=>'required'),
            array('field'=>'nama','label'=>'Nama','rules'=>'required'),
            array('field'=>'alamat','label'=>'Alamat','rules'=>'required')
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            $data = array(
                'no_rekening_simuda' => $this->input->post('no_rekening_simuda'),
                'no_anggota' => $this->input->post('no_anggota')
            );
            $this->M_simuda->simpanRekeningBaru($data);
            
        }else{
            
        }
        redirect('simuda/bukaRekening');
    }
    //Form Kelola Rekening
    function kelolaRekening(){
        $data['path'] = 'simuda/kelola_rekening';
        $this->load->view('master_template',$data);   
    }
    function manageAjaxGetMasterSimuda(){
        $no_rekening = $this->input->post('id');
        $data['master_simuda'] = $this->M_simuda->get1MasterSimuda();
        print_r($data['master_simuda']);
        // $this->load->view('simuda/get_data_master_simuda',$data);
    }
    //Stel Limit Debet Simuda
    function stelLimitDebet(){
        $data['path'] = 'simuda/stel_limit_debet';
        $data['limit_debet'] = $this->M_simuda->getLimitNominalSimuda();
        $this->load->view('master_template',$data);   
    }
    
    function updateLimitDebet(){
        $config = array(array('field' => 'nominal','label'=>'Nominal','rules'=>'required'));
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){ //Jika validasi Form Berhasil
            $where = array('id_limit_simuda' => 1);
            $data = array('nominal' => $this->input->post('nominal'));
            $this->M_simuda->updateLimitNominalSimuda($where,$data);
            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Diubah</div>");
        }else{
            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!<br>".$gagal."</div>");
        }
        redirect('simuda/stelLimitDebet');
    }
}