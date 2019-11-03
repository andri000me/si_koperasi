<?php
Class Otorisasi extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_otorisasi');
        $this->load->model('M_simuda');
        $this->load->model('M_jurnal');
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
        $datetime = date('Y-m-d h:i:s');

        //Update Tabel Otorisasi
        $data_otorisasi = array(
            'status' => $status
        );
        $this->M_otorisasi->updateOtorisasi(array('id_otorisasi' => $id),$data_otorisasi);
        
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
                    //Jika Record Lebih dari 0 Maka saldo Mengambil dari bulan ini, jika tidak maka mengambil dari hasil tutup buku bulan lalu
                    $data_nominal = 0;
                    if($this->M_simuda->getJumlahRecordBulanIni(array('no_rekening_simuda' => $no_rek, 'month(datetime)' => date('m'), 'year(datetime)' => date('Y'))) > 0){
                        //Mengambil Record Terakhir Bulan Ini
                        $data_nominal = $this->M_simuda->getRecordTerakhirBulanIni(array('no_rekening_simuda' => $no_rek, 'month(datetime)' => date('m'), 'year(datetime)' => date('Y')));
                    }else{
                        //Mengambil Hasil Tutup Buku Bulan Lalu
                        $data_nominal = $this->M_simuda->getRecordTerakhirTutupBulanLalu(array('no_rekening_simuda' => $no_rek, 'month(tgl_tutup_bulan)' => date('m',strtotime('last month')), 'year(tgl_tutup_bulan)' => date('Y')));
                    }

                    //Input Ke Tabel Simuda
                    $data_detail = array(
                        'no_rekening_simuda' => $no_rek,
                        'datetime' => $datetime,
                        'debet' => $nominal_debet,
                        'saldo' => $data_nominal - $nominal_debet,
                        'id_user' => '1' //Sementara
                    );
                    $this->M_simuda->simpanDetailSimuda($data_detail);

                }else if($tipe == "Sijaka"){
                    
                }
                
                //Input Ke Tabel Jurnal
                $data_jurnal = array(
                    'tanggal' => $datetime,
                    'kode' => '', //Belum Dikasih
                    'lawan' => '',
                    'tipe' => 'D',
                    'nominal' => $nominal_debet,
                    'tipe_trx_koperasi' => $tipe,
                    'id_detail' => $this->db->insert_id()

                );
                $this->M_jurnal->inputJurnal($data_jurnal);
            }
            
            
        }
        redirect('otorisasi');
    }
}