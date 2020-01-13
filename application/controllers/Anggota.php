<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Anggota extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_anggota');
        //Untuk Ke Detail Rekening
        $this->load->model('M_simpanan_pokok');
        $this->load->model('M_simpanan_wajib');
        $this->load->model('M_simuda');
        $this->load->model('M_sijaka');
        $this->load->model('M_kredit');    
    }
    function index(){
        $data['title'] = 'Data Anggota';
        $data['path'] = "anggota/v_anggota";
        $data['anggota'] = $this->M_anggota->getAnggota();
        $this->load->view('master_template',$data);
    }
    //Function add() digunakan untuk aksi input ke tabel anggota
    function add(){
        //Melakukan Validasi Form Untuk Menjamin data terisi semua
        $config = array(
            array(
                'field' => 'no_anggota',
                'label' => 'No. Anggota',
                'rules' => 'required'
            ),
            array(
                'field' => 'nama_terang',
                'label' => 'Nama Terang',
                'rules' => 'required'
            ),
            array(
                'field' => 'alamat',
                'label' => 'Alamat',
                'rules' => 'required'
            ),
            array(
                'field' => 'status',
                'label' => 'status',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){ //Jika validasi Form Berhasil
            //Input Ke Tabel Anggota
            $data = array(
                'no_anggota' => $this->input->post('no_anggota'),
                'nama' => $this->input->post('nama_terang'),
                'alamat' => $this->input->post('alamat'),
                'status' => $this->input->post('status')
            );
            $this->M_anggota->addAnggota($data);
            $this->session->set_flashdata("input_success", "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil ditambahkan.<br></div>");

        }else{ //Jika validasi Form Gagal
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        redirect('anggota');
    }
    function edit(){
        $no_anggota = $this->input->post('id');
        $data['anggota'] = $this->M_anggota->get1Anggota(array('no_anggota' => $no_anggota));
        $this->load->view('anggota/edit_anggota',$data);
    }
    function update(){
        //Melakukan Validasi Form Untuk Menjamin data terisi semua
        $config = array(
            array(
                'field' => 'temp_no_anggota',
                'label' => 'Temp',
                'rules' => 'required'
            ),
            array(
                'field' => 'no_anggota',
                'label' => 'No. Anggota',
                'rules' => 'required'
            ),
            array(
                'field' => 'nama_terang',
                'label' => 'Nama Terang',
                'rules' => 'required'
            ),
            array(
                'field' => 'alamat',
                'label' => 'Alamat',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){ //Jika validasi Form Berhasil
            //Input Ke Tabel Anggota
            $where = array('no_anggota' => $this->input->post('temp_no_anggota'));
            $data = array(
                'no_anggota' => $this->input->post('no_anggota'),
                'nama' => $this->input->post('nama_terang'),
                'alamat' => $this->input->post('alamat')
            );
            $this->M_anggota->updateAnggota($where,$data);
            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Diubah!!</div>");
            
        }else{ //Jika validasi Form Gagal
            $gagal = validation_errors();
            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!<br>".$gagal."</div>");
        }
        redirect('anggota');
    }

    function rekeningAnggota($id){
        $data['title'] = 'Rekening Anggota';
        $data['path'] = "anggota/v_rekening_anggota";
        $data['id'] = $id;
        //Nama Anggota
        $data['anggota'] = $this->M_anggota->get1Anggota(array('no_anggota'=>$id));
        //Simpanan Pokok Anggota
        $data['simpanan_pokok']= $this->M_simpanan_pokok->get1SimpananPokok(array('anggota.no_anggota' => $id))->result();
        $data['simpanan_wajib']= $this->M_simpanan_wajib->get1Nominatif($id);
        $data['simuda'] = $this->M_simuda->get1MasterSimuda($id);
        $data['sijaka'] = "";
        $data['kredit']= $this->M_kredit->get1NominatifKredit(array('master_rekening_pembiayaan.no_anggota' => $id))->result();
        $this->load->view('master_template',$data);
    }
    function disableAccount($id){
        $where = array(
            'no_anggota' => $id
        );
        $data = array(
            'status' => '0'
        );
        if($this->M_anggota->updateAnggota($where,$data) == TRUE){
            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Akun Berhasil Dinonaktifkan!!</div>");
        }else{
            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Akun Gagal Dinonaktifkan!!</div>");
        }
        redirect('anggota');
    }
    function enableAccount($id){
        $where = array(
            'no_anggota' => $id
        );
        $data = array(
            'status' => '1'
        );
        if($this->M_anggota->updateAnggota($where,$data) == TRUE){
            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Akun Berhasil Diaktifkan!!</div>");
        }else{
            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Akun Gagal Diaktifkan!!</div>");
        }
        redirect('anggota');
    }
    
}