<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class KodeInduk extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('setup-akuntansi/M_kode_induk');    
    }
    function index(){
        $data['title'] = 'Kode Induk';
        $data['path'] = "setup-akuntansi/kode-induk/list-kode-induk";
        $data['kodeInduk'] = $this->M_kode_induk->getAll();
        $this->load->view('master_template',$data);
    }
    //Function add() digunakan untuk aksi input ke tabel anggota
    function add(){
        //Melakukan Validasi Form Untuk Menjamin data terisi semua
        $config = array(
            array(
                'field' => 'kode_induk',
                'label' => 'Kode Induk',
                'rules' => 'required|is_unique[ak_kode_induk.kode_induk]'
            ),
            array(
                'field' => 'nama',
                'label' => 'Nama Kode Induk',
                'rules' => 'required'
            ),
            array(
                'field' => 'tipe',
                'label' => 'Tipe',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){ //Jika validasi Form Berhasil
            //Input Ke Tabel Anggota
            $data = array(
                'kode_induk' => $this->input->post('kode_induk'),
                'nama' => ucwords($this->input->post('nama')),
                'tipe' => $this->input->post('tipe'),
            );
            $this->M_kode_induk->addKodeInduk($data);
            //Input Ke Tabel Simpanan Pokok
            $this->session->set_flashdata("input_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil ditambahkan.<br></div>");

        }else{ //Jika validasi Form Gagal
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        redirect(base_url('index.php/setup-akuntansi/kodeinduk'));
    }
    function edit($kode){
        $data['kodeInduk'] = $this->M_kode_induk->getOne(array('kode_induk' => $kode));    
        $this->load->view('setup-akuntansi/kode-induk/edit-kode-induk',$data);
    }

    function update(){
        //Melakukan Validasi Form Untuk Menjamin data terisi semua
        $config = array(
            array(
                'field' => 'new_kode_induk',
                'label' => 'Kode Induk',
                'rules' => 'required'
            ),
            array(
              'field' => 'nama',
              'label' => 'Nama Kode Induk',
              'rules' => 'required'
            ),
            array(
                'field' => 'tipe',
                'label' => 'Tipe',
                'rules' => 'required'
            ),
        );

        $cek = $this->M_kode_induk->countKodeInduk($this->input->post('kode'), $this->input->post('new_kode_induk'))[0];

        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE && $cek['countKode'] == 0){ //Jika validasi Form Berhasil
            //Input Ke Tabel Anggota
            $where = array('kode_induk' => $this->input->post('kode'));
            $data = array(
                'kode_induk' => $this->input->post('new_kode_induk'),
                'nama' =>ucwords($this->input->post('nama')),
                'tipe' => $this->input->post('tipe')
            );
            $this->M_kode_induk->updateKodeInduk($where,$data);
            
            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil diperbarui.<br></div>");


        }else{ //Jika validasi Form Gagal
            $gagal = validation_errors();

            if ($cek['countKode'] > 0) {
              $gagal = $gagal . 'Kode induk tidak boleh duplicate.';
            }

            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah.<br>".$gagal."</div>");
        }
        redirect(base_url('index.php/setup-akuntansi/kodeinduk'));
    }

    public function delete($kode)
    {
        $where = ['kode_induk' => $kode];
        if ($this->M_kode_induk->deleteKodeInduk($where)) {
            $this->session->set_flashdata("delete_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        }else{
            $this->session->set_flashdata("delete_failed","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        }
        redirect(base_url('index.php/setup-akuntansi/kodeinduk'));
    }
}