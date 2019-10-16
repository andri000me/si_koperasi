<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class KodeRekening extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('setup-akuntansi/M_kode_rekening');    
        $this->load->model('setup-akuntansi/M_kode_induk');
    }
    function index(){
        $data['title'] = 'Kode Rekening';
        $data['path'] = "setup-akuntansi/kode-rekening/list-kode-rekening";
        $data['kodeRekening'] = $this->M_kode_rekening->getAll();
        $data['kodeInduk'] = $this->M_kode_induk->getAll();
        $this->load->view('master_template',$data);
    }
    //Function add() digunakan untuk aksi input ke tabel anggota
    function add(){
        //Melakukan Validasi Form Untuk Menjamin data terisi semua
        $config = array(
            array(
                'field' => 'kode_rekening',
                'label' => 'Kode Rekening',
                'rules' => 'required|is_unique[ak_rekening.kode_rekening]|max_length[4]'
            ),
            array(
                'field' => 'nama',
                'label' => 'Nama Kode Rekening',
                'rules' => 'required'
            ),
            array(
                'field' => 'inisial',
                'label' => 'Inisial',
                'rules' => 'max_length[3]'
            ),
            array(
                'field' => 'saldo_awal',
                'label' => 'Saldo Awal',
                'rules' => ''
            ),
            array(
                'field' => 'kode_induk',
                'label' => 'Kode Induk',
                'rules' => 'required'
            ),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){ //Jika validasi Form Berhasil
            //Input Ke Tabel Anggota
            $data = array(
                'kode_rekening' => $this->input->post('kode_induk'). '.' .$this->input->post('kode_rekening'),
                'nama' => $this->input->post('nama'),
                'inisial' => $this->input->post('inisial'),
                'saldo_awal' => $this->input->post('saldo_awal'),
                'kode_induk' => $this->input->post('kode_induk'),
            );
            $this->M_kode_rekening->addKodeRekening($data);
            //Input Ke Tabel Simpanan Pokok
            $this->session->set_flashdata("input_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil ditambahkan.<br></div>");

        }else{ //Jika validasi Form Gagal
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        redirect(base_url('index.php/setup-akuntansi/koderekening'));
    }

    function edit($kode){
        // $data['kodeRekening'] = $this->M_kode_rekening->getOne(array('kode_rekening' => $kode));
        // $data['kodeInduk'] = $this->M_kode_induk->getAll();
        $data = array(
          'kodeRekening' => $this->M_kode_rekening->getOne(array('kode_rekening' => $kode)),
          'kodeInduk' => $this->M_kode_induk->getAll(),
        );
        
        $this->load->view('setup-akuntansi/kode-rekening/edit-kode-rekening', $data);
    }

    function update(){
        //Melakukan Validasi Form Untuk Menjamin data terisi semua
        $config = array(
            array(
                'field' => 'new_kode_rekening',
                'label' => 'Kode Rekening',
                'rules' => 'required'
            ),
            array(
              'field' => 'nama',
              'label' => 'Nama Kode Rekening',
              'rules' => 'required'
            ),
            array(
                'field' => 'kode_induk',
                'label' => 'Kode Induk',
                'rules' => 'required'
            ),
        );

        $cek = $this->M_kode_rekening->countKodeRekening($this->input->post('kode'), $this->input->post('kode_induk').'.'.$this->input->post('new_kode_rekening'))[0];

        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE && $cek['countKode'] == 0){ //Jika validasi Form Berhasil
            //Input Ke Tabel Anggota
            $where = array('kode_rekening' => $this->input->post('kode'));
            $data = array(
                'kode_rekening' => $this->input->post('kode_induk').'.'.$this->input->post('new_kode_rekening'),
                'nama' => $this->input->post('nama'),
                'inisial' => $this->input->post('inisial'),
                'saldo_awal' => $this->input->post('saldo_awal'),
                'kode_induk' => $this->input->post('kode_induk'),
            );
            $this->M_kode_rekening->updateKodeRekening($where,$data);
            
            $this->session->set_flashdata("update_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil diperbarui.<br></div>");


        }else{ //Jika validasi Form Gagal
            $gagal = validation_errors();

            if ($cek['countKode'] > 0) {
              $gagal = $gagal . 'Kode rekening tidak boleh duplicate.';
            }

            $this->session->set_flashdata("update_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah.<br>".$gagal."</div>");
        }
        redirect(base_url('index.php/setup-akuntansi/koderekening'));
    }

    public function delete($kode)
    {
        $where = ['kode_rekening' => $kode];
        if ($this->M_kode_rekening->deleteKodeRekening($where)) {
            $this->session->set_flashdata("delete_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        }else{
            $this->session->set_flashdata("delete_failed","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil dihapus.<br></div>");
        }
        redirect(base_url('index.php/setup-akuntansi/koderekening'));
    }
}