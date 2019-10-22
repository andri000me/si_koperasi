<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Simuda extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_simuda');
        $this->load->model('M_anggota');
        $this->load->model('M_jurnal');    
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
    //Aksi Pembukaan Rekening Baru
    function simpanRekeningBaru(){
        $config = array(
            array('field'=>'no_rekening_simuda','label'=>'No. Rekening Simuda','rules'=>'required'),
            array('field'=>'no_anggota','label'=>'No. Anggota','rules'=>'required'),
            array('field'=>'nama','label'=>'Nama','rules'=>'required'),
            array('field'=>'alamat','label'=>'Alamat','rules'=>'required'),
            array('field'=>'saldo_awal','label'=>'Saldo Awal','rules'=>'required'),
            array('field'=>'status_pembukaan_rekening','label'=>'Status Pembukaan Rekening','rules'=>'required')
        );

        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            //Simpan Ke Tabel Master Rekening Simuda
            $data_master = array(
                'no_rekening_simuda' => $this->input->post('no_rekening_simuda'),
                'no_anggota' => $this->input->post('no_anggota')
            );
            $this->M_simuda->simpanRekeningBaru($data_master);

            $datetime = date('Y-m-d h:i:s');
            //Simpan Ke Tabel Master Detail Rekening Simuda
            $data_detail = array(
                'no_rekening_simuda' => $this->input->post('no_rekening_simuda'),
                'datetime' => $datetime,
                'kredit' => $this->input->post('saldo_awal'),
                'saldo' => $this->input->post('saldo_awal'),
                'id_user' => '1' //Sementara
            );
            $this->M_simuda->simpanDetailSimuda($data_detail);

            //Jika Status Rekening Baru (Bukan Migrasi) Insert Ke Tabel Jurnal
            if($this->input->post('status_pembukaan_rekening')=='0'){
                $data_jurnal = array(
                    'tanggal' => $datetime,
                    'kode' => '', //Belum Dikasih
                    'lawan' => '',
                    'tipe' => 'K',
                    'nominal' => $this->input->post('saldo_awal'),
                    'tipe_trx_koperasi' => 'Simuda',
                    'id_detail' => $this->db->insert_id()

                );
                $this->M_jurnal->inputJurnal($data_jurnal);
                $this->session->set_flashdata("input_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan!!</div>");
            }
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
        $data['master_simuda'] = $this->M_simuda->get1MasterSimuda(array('no_rekening_simuda' => $this->input->post('id')));
        // $data['master_simuda'] = $this->M_simuda->getMasterSimuda();
        // print_r($data['master_simuda']);
        
        $this->load->view('simuda/get_data_master_simuda',$data);
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
    //Daftar Nominatif
    function daftarNominatif(){ 
        $data['path'] = 'simuda/daftar_nominatif';
        $data['nominatif'] = $this->M_simuda->getMasterSimuda();
        $this->load->view('master_template',$data);
    }
}