<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Sijaka extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_sijaka');
        $this->load->model('M_anggota');
        $this->load->model('M_simuda');
    }

    function bukaRekeningSijaka(){
        $data['path'] = 'sijaka/form_rekening_baru';
        $data['anggota'] = $this->M_anggota->getAnggota();
        $data['simuda'] = $this->M_simuda->getSemuaMasterSimuda();
        $this->load->view('master_template',$data);
    }

    //ajax get data anggota
    function manageAjaxGetDataAnggota(){
        $no_anggota = $this->input->post('id');
        $data['anggota'] = $this->M_anggota->get1Anggota(array('no_anggota' => $no_anggota));
        $this->load->view('sijaka/get_data_anggota',$data);
    }


    //Aksi Pembukaan Rekening Baru Sijaka
    function simpanRekeningBaruSijaka(){
        $config = array(
            //array('field'=>'name view','label'=>'nama label','rules'=>'required')
            array('field'=>'NRSj','label'=>'No. Rekening','rules'=>'required'),
            array('field'=>'no_anggota','label'=>'No. Anggota','rules'=>'required'),
            array('field'=>'jumlah','label'=>'Jumlah','rules'=>'required'),
            //array('field'=>'jumlah_sekarang','label'=>'Jumlah','rules'=>'required'),
            array('field'=>'jangka_waktu','label'=>'Jangka Waktu','rules'=>'required'),
            array('field'=>'tanggal_awal','label'=>'Tanggal Awal','rules'=>'required'),
            array('field'=>'tanggal_akhir','label'=>'Tanggal Akhir','rules'=>'required'),
            array('field'=>'presentase_bagi_hasil_bulanan','label'=>'Jumlah Bayar Bahas','rules'=>'required'),
            array('field'=>'pembayaran_bahas','label'=>'Pembayaran','rules'=>'required'),
            //array('field'=>'no_rekening_simuda','label'=>'Rekening Simuda','rules'=>'required'),
            array('field'=>'perpanjangan_otomatis','label'=>'Perpanjangan Otomatis','rules'=>'required')
            // array('field'=>'rekening_simuda','label'=>'Jumlah Bayar','rules'=>'required'),
            // array('field'=>'otomatis_perpanjangan','label'=>'Perpanjangan Otomatis','rules'=>'required'),
            // array('field'=>'debet','label'=>'','rules'=>'required'),
            // array('field'=>'kredit','label'=>'','rules'=>'required'),
            // array('field'=>'saldo','label'=>'','rules'=>'required')
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            //Simpan Ke Table Master Rekening Sijaka
            $data_master = array(
                //'nama field db' => $this->input->post('name di view')
                'NRSj' => $this->input->post('NRSj'),
                'no_anggota' => $this->input->post('no_anggota'),
                'jumlah_awal' => $this->input->post('jumlah'),
                'jumlah_sekarang' => 0, //muncul ketika anggota sudah gabung sijaka sudah lama
                'jangka_waktu' => $this->input->post('jangka_waktu'),
                'tanggal_awal' => $this->input->post('tanggal_awal'),
                'tanggal_akhir' => $this->input->post('tanggal_akhir'),
                'presentase_bagi_hasil_bulanan' => $this->input->post('presentase_bagi_hasil_bulanan'),
                'pembayaran_bahas' => $this->input->post('pembayaran_bahas'),
                'rekening_simuda' => $this->input->post('no_rekening_simuda'), 
                'otomatis_perpanjang' => $this->input->post('perpanjangan_otomatis')                
            );
            $this->M_sijaka->simpanSijaka($data_master);

            // $data_detail = array(
            //     'NRSj' => $this->input->post('NRSj'),
            //     'kredit' => $this->input->post('saldo_awal'),
            //     'saldo' => $this->input->post('saldo_awal'),
            //     'id_user' => '1' //Sementara
            // );

            $this->session->set_flashdata("input_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan!!</div>");
        }else{
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        redirect('sijaka/bukaRekeningSijaka');
    }

    function manageAjaxDate()
    {
        $tgl_awal = $this->input->post('tgl_awal_field');
        $jangka_waktu = $this->input->post('jangka_waktu_field');
        $date = date('Y-m-d', strtotime("+" . $jangka_waktu . " months", strtotime($tgl_awal)));
        echo $date;
    }

    function daftarNominatifSijaka(){
        $data['path'] = 'sijaka/daftar_nominatif_sijaka';
        $data['nominatif'] = $this->M_sijaka->getMasterSijaka();
        $this->load->view('master_template',$data);
    }

    function perhitunganAkhirBulanSijaka(){
        $data['path'] = 'sijaka/perhitungan_akhir_bulan_sijaka';
        $this->load->view('master_template',$data);
    }

    function kelolaRekeningSijaka(){
        $data['path'] = 'sijaka/kelola_rekening_sijaka';
        $this->load->view('master_template',$data);
    }

    function detailRekeningSijaka($id){
        $data['path'] = 'sijaka/detail_rekening_sijaka';
        $data['id'] = $id;
        $where = array('NRSj' => $id);
        $data['master_rekening_sijaka'] = $this->M_sijaka->get1MasterSijaka($where);
        $data['detail_rekening_sijaka'] = $this->M_sijaka->getDetailSijaka($where);
        $this->load->view('master_template',$data);
    }
}
?>