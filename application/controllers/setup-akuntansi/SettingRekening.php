<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class SettingRekening extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('setup-akuntansi/M_kode_rekening');    
        $this->load->model('setup-akuntansi/M_setting_rekening');    
        // $this->load->model('setup-akuntansi/M_kode_induk');
    }
    function index(){
        $data['title'] = 'Setting Rekening';
        $data['path'] = "setup-akuntansi/setting-rekening/list-setting-rekening";
        $data['setting'] = $this->M_setting_rekening->getAll();
        $data['kodeRekening'] = $this->M_kode_rekening->getAll();
        $this->load->view('master_template',$data);
    }
    //Function add() digunakan untuk aksi input ke tabel anggota
    function add(){
        //Melakukan Validasi Form Untuk Menjamin data terisi semua
        $config = array(
            array(
                'field' => 'jenis_trx',
                'label' => 'Jenis transaksi',
                'rules' => 'required'
            ),
            array(
                'field' => 'rek_debet',
                'label' => 'Rekening Debet',
                'rules' => 'required'
            ),
            array(
                'field' => 'rek_kredit',
                'label' => 'Rekening Kredit',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){ //Jika validasi Form Berhasil
            //Input Ke Tabel Anggota
            $data = array(
                'jenis_trx' => $this->input->post('jenis_trx'),
                'rek_debet' => $this->input->post('rek_debet'),
                'rek_kredit' => $this->input->post('rek_kredit'),
            );
            $this->M_setting_rekening->addSettingRekening($data);
            //Input Ke Tabel Simpanan Pokok
            $this->session->set_flashdata("input_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil ditambahkan.<br></div>");

        }else{ //Jika validasi Form Gagal
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        redirect(base_url('index.php/setup-akuntansi/settingrekening'));
    }

    function edit($id){
        // $data['kodeRekening'] = $this->M_kode_rekening->getOne(array('kode_rekening' => $kode));
        // $data['kodeInduk'] = $this->M_kode_induk->getAll();
        $data = array(
          'kodeRekening' => $this->M_kode_rekening->getAll(),
          'setting' => $this->M_setting_rekening->getone(array('id' => $id)),
        );
        
        $this->load->view('setup-akuntansi/setting-rekening/edit-setting-rekening', $data);
    }

    function update(){
        //Melakukan Validasi Form Untuk Menjamin data terisi semua
        $config = array(
            array(
                'field' => 'jenis_trx',
                'label' => 'Jenis Transaksi',
                'rules' => 'required'
            ),
            array(
              'field' => 'rek_debet',
              'label' => 'Rekening Debet',
              'rules' => 'required'
            ),
            array(
                'field' => 'rek_kredit',
                'label' => 'Rekening Kredit',
                'rules' => 'required'
            ),
        );

        // $cek = $this->M_kode_rekening->countSettingRekening($this->input->post('kode'), $this->input->post('kode_induk').'.'.$this->input->post('new_kode_rekening'))[0];

        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){ //Jika validasi Form Berhasil
            //Input Ke Tabel Anggota
            $where = array('id' => $this->input->post('id'));
            $data = array(
                'jenis_trx' => trim( $this->input->post('jenis_trx')),
                'rek_debet' => trim($this->input->post('rek_debet')),
                'rek_kredit' => trim($this->input->post('rek_kredit')),
            );
            $this->M_setting_rekening->updateSettingRekening($where,$data);
            
            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil diperbarui.<br></div>");


        }else{ //Jika validasi Form Gagal
            $gagal = validation_errors();

            // if ($cek['countKode'] > 0) {
            //   $gagal = $gagal . 'Kode rekening tidak boleh duplicate.';
            // }

            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah.<br>".$gagal."</div>");
        }
        redirect(base_url('index.php/setup-akuntansi/settingrekening'));
    }

    public function delete($id)
    {
        $where = ['id' => $id];
        if ($this->M_setting_rekening->deleteSettingRekening($where)) {
            $this->session->set_flashdata("delete_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        }else{
            $this->session->set_flashdata("delete_failed","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        }
        redirect(base_url('index.php/setup-akuntansi/settingrekening'));
    }
}