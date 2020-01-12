<?php
Class Otorisasi extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_otorisasi');
        $this->load->model('M_simuda');
        $this->load->model('M_jurnal');
        $this->load->model('M_log_activity');
    }
    //Halaman Index Otorisasi
    function index(){
      $data['path'] = 'otorisasi/v_otorisasi';
      $data['otorisasi'] = $this->M_otorisasi->getOtorisasi();
      $this->load->view('master_template',$data);  
    }

    //Digunakan Untuk Pop Up Modal
    function modalUbahStatus(){
        $data['id'] = $this->input->post('id');
        $this->load->view('otorisasi/modal_update_status',$data);
    }
    //Aksi Untuk Update Status Otorisasi
    function updateStatus(){
        $id = $this->input->post('id_otorisasi');
        $status = $this->input->post('status');
        $datetime = date('Y-m-d H:i:s');

        //Update Tabel Otorisasi
        $data_otorisasi = array(
            'tanggal_persetujuan' => $datetime,
            'status' => $status
        );
        $this->M_otorisasi->updateOtorisasi(array('id_otorisasi' => $id),$data_otorisasi);

        $activity = array(
            'id_user' => $this->session->userdata('_id'),
            'datetime' => $datetime,
            'keterangan' => 'Melakukan otorisasi dengan status ' . $this->input->post('status'),
        );
        $this->M_log_activity->insertActivity($activity);
        
        //Melakukan Operasi Ketika Otorisasi Disetujui
        if($status == 'Accepted'){
            //Mengambil Detail Informasi Dari Record Tabel Otorisasi
            $record_otorisasi = $this->M_otorisasi->get1Otorisasi(array('id_otorisasi' => $id));
            foreach($record_otorisasi as $i){
                $tipe = $i->tipe;
                $no_rek = $i->no_rek;
                $nominal_debet = $i->nominal_debet;

                //Memilih Transaksi Berdasarkan Tipe
                if($tipe == "Simuda"){ //Input Ke Tabel Detail Simuda
                    //Mengambil Saldo Terakhir
                    $data_nominal = $this->M_simuda->getSaldoRecordTerakhir($no_rek);

                    //Saldo
                    $saldo_akhir = $data_nominal - $nominal_debet;                    

                    //Saldo Terendah
                    $saldo_terendah = 0;
                    if($this->M_simuda->getJumlahRecordBulanIni($no_rek) >0){ //Jika Bulan Ini Ada Transaksi, Maka Menggunakan Pengolahan ini
                        $record_terakhir_db = $this->M_simuda->getSaldoTerendahRecordTerakhir($no_rek);
                        if($nominal_debet <= $record_terakhir_db){
                            $saldo_terendah = $saldo_akhir;
                        }else{
                            $saldo_terendah = $record_terakhir_db;
                        }
                    }else{ //Jika Bulan Ini Tidak Ada Transaksi, Maka Menggunakan Pengolahan ini
                        $saldo_terendah = $saldo_akhir;
                    }

                    //Input Ke Tabel Simuda
                    $data_detail = array(
                        'no_rekening_simuda' => $no_rek,
                        'datetime' => $datetime,
                        'debet' => $nominal_debet,
                        'saldo' => $saldo_akhir,
                        'saldo_terendah' => $saldo_terendah,
                        'id_user' => $this->session->userdata('_id')
                    );
                    $this->M_simuda->simpanDetailSimuda($data_detail);

                    //Input Ke Tabel Jurnal
                    $data_jurnal = array(
                        'tanggal' => $datetime,
                        'keterangan' => 'Debet Simuda no rekening '. $no_rek . ' (Disetujui)',
                        'kode' => '01.210.10', //Belum Dikasih
                        'lawan' => '01.100.20',
                        'tipe' => 'D',
                        'nominal' => $nominal_debet,
                        'tipe_trx_koperasi' => $tipe,
                        'id_detail' => NULL

                    );
                    $this->M_jurnal->inputJurnal($data_jurnal);

                }else if($tipe == "Sijaka"){
                    
                }
                
                
            }
            
            
        }
        redirect('otorisasi');
    }
}