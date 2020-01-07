<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Simuda extends CI_Controller{
    //Konstruktor
    function __construct(){
        parent::__construct();
        $this->load->model('M_simuda');
        $this->load->model('M_anggota');
        $this->load->model('M_jurnal');    
        $this->load->model('M_otorisasi');
        $this->load->model('M_log_activity');
    }
    //-----------Halaman Form Buka Rekening---------------------------------------------------------

    //Form Buka Rekening
    function bukaRekening(){
        $data['path'] = 'simuda/buka_rekening';
        $data['anggota'] = $this->M_anggota->getAnggota();
        $this->load->view('master_template',$data);
    }

    //Ajax Get Data Anggota
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
            
            $datetime = date('Y-m-d H:i:s');
            // simpan ke log activity
            $activity = array(
                'id_user' => '1', //sementara
                'datetime' => $datetime,
                'keterangan' => 'Menginput buka rekening simuda dengan no rekening simuda ' . $this->input->post('no_rekening_simuda') . ' dengan no anggota ' . $this->input->post('no_anggota'),
            );
            $this->M_log_activity->insertActivity($activity);
            
            //Simpan Ke Tabel Master Detail Rekening Simuda
            $data_detail = array(
                'no_rekening_simuda' => $this->input->post('no_rekening_simuda'),
                'datetime' => $datetime,
                'kredit' => $this->input->post('saldo_awal'),
                'saldo' => $this->input->post('saldo_awal'),
                'saldo_terendah' => $this->input->post('saldo_awal'),
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
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        redirect('simuda/bukaRekening');
    }

    //-----Halaman Form Buka Rekening----------------
    //Form Kelola Rekening
    function kelolaRekening(){
        $data['path'] = 'simuda/kelola_rekening';
        $data['master_simuda'] = $this->M_simuda->getMasterSimuda();
        
        foreach($this->M_simuda->getLimitNominalSimuda() as $i){
            $data['limit_debet_simuda'] = $i->nominal;
        }
        $this->load->view('master_template',$data);   
    }

    //Digunakan Untuk Get Saldo Awal Di Form Kelola Rekening
    function getNominalSaldo(){
        $no_rekening_simuda = $this->input->post('id');
        $data_nominal = 0;
        //Mengambil Record Terakhir
        $data_nominal = $this->M_simuda->getSaldoRecordTerakhir($no_rekening_simuda);

        // //Jika Record Lebih dari 0 Maka saldo Mengambil dari bulan ini, jika tidak maka mengambil dari hasil tutup buku bulan lalu
        // if($this->M_simuda->getJumlahRecordBulanIni($no_rekening_simuda) > 0){
        //     //Mengambil Record Terakhir Bulan Ini
        //     $data_nominal = $this->M_simuda->getRecordTerakhirBulanIni($no_rekening_simuda);
        // }else{
        //     //Mengambil Hasil Tutup Buku Bulan Lalu
        //     $data_nominal = $this->M_simuda->getRecordTerakhirTutupBulanLalu($no_rekening_simuda);
        // }
        echo "<label>Saldo Awal</label>";
        echo "<input type='number' name='saldo_awal' id='saldo_awal' class='form-control' value='".$data_nominal."' readonly />";
    }

    //Digunakan Untuk Memproses Rekening / Kirim Ke Halaman Otorisasi
    function simpanKelolaRekening(){
        $datetime = date('Y-m-d H:i:s');
        //Melakukan Form Validasi
        $config = array(
            array('field'=>'no_rekening_simuda','label'=>'No. Rekening','rules'=>'required'),
            array('field'=>'tipe','label'=>'Tipe','rules'=>'required'),
            array('field'=>'jumlah','label'=>'Jumlah','rules'=>'required'),
            array('field'=>'saldo_akhir','label'=>'saldo_akhir','rules'=>'required'),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            //Inisialisasi
            $no_rekening_simuda = $this->input->post('no_rekening_simuda');
            $saldo_akhir_form = $this->input->post('saldo_akhir');
            $saldo_terendah = 0;

            //Jika Yang Diklik adalah tombol Proses, Maka :
            if($this->input->post('simpan_') == "proses"){
                //Mendapatkan Saldo Terakhir
                if($this->M_simuda->getJumlahRecordBulanIni($no_rekening_simuda) >0){ //Jika Bulan Ini Ada Transaksi, Maka Menggunakan Pengolahan ini
                    $record_terakhir_db = $this->M_simuda->getSaldoTerendahRecordTerakhir($no_rekening_simuda);
                    if($saldo_akhir_form <= $record_terakhir_db){
                        $saldo_terendah = $saldo_akhir_form;
                    }else{
                        $saldo_terendah = $record_terakhir_db;
                    }
                }else{ //Jika Bulan Ini Tidak Ada Transaksi, Maka Menggunakan Pengolahan ini
                    $saldo_terendah = $saldo_akhir_form;
                }

                //Input Ke Tabel Detail Simuda
                if($this->input->post('tipe') == "K"){ //Jika Tipe Kredit
                    $data = array(
                        'no_rekening_simuda' => $this->input->post('no_rekening_simuda'),
                        'datetime' => $datetime,
                        'kredit' => $this->input->post('jumlah'),
                        'saldo' => $saldo_akhir_form,
                        'saldo_terendah' => $saldo_terendah,
                        'id_user' => 1
                    );    
                    
                }else if($this->input->post('tipe') == "D"){ //Jika Tipe Debet
                    $data = array(
                        'no_rekening_simuda' => $this->input->post('no_rekening_simuda'),
                        'datetime' => $datetime,
                        'debet' => $this->input->post('jumlah'),
                        'saldo' => $saldo_akhir_form,
                        'saldo_terendah' => $saldo_terendah,
                        'id_user' => 1
                    );    
                }
                $save1 = $this->M_simuda->simpanDetailSimuda($data);
                
                //Insert Ke Tabel Jurnal
                $data_jurnal = array(
                    'tanggal' => $datetime,
                    'kode' => '', //Belum Dikasih
                    'lawan' => '',
                    'tipe' => $this->input->post('tipe'),
                    'nominal' => $this->input->post('jumlah'),
                    'tipe_trx_koperasi' => 'Simuda',
                    'id_detail' => $this->db->insert_id()
                );
                $save2 = $this->M_jurnal->inputJurnal($data_jurnal);
                if($save1 == TRUE && $save2 == TRUE){
                    $this->session->set_flashdata("input_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan!!</div>");
                }else{
                    $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!</div>");
                }
            }else if($this->input->post('simpan_') == "pengajuan"){ //Jika Yang diklik adalah tombol pengajuan
                //Input Ke Tabel Otorisasi
                $data_otorisasi = array(
                    'tipe' => 'Simuda',
                    'tanggal_input' => $datetime,
                    'no_rek' => $this->input->post('no_rekening_simuda'),
                    'nominal_debet' => $this->input->post('jumlah'),
                    'status' => 'Open'
                );
                if($this->M_otorisasi->saveOtorisasi($data_otorisasi) == TRUE){
                    $this->session->set_flashdata("input_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Pengajuan Debet Selesai, Menunggu Konfirmasi Manager</div>");
                }                    
            }
        }else{
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        //Redirect Ke Halaman Kelola Rekening
        redirect('Simuda/kelolaRekening');
    }
   
    //Digunakan Untuk Otorisasi Ketika Debet Simuda Dengan >=Limit

    // -----------------------------------------------------------------------
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
            $gagal = validation_errors();
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
    //Detail Transaksi Per Rekening
    function detailRekening($id){
        $data['path'] = 'simuda/detail_rekening';
        $data['id'] = $id;
        $where = array('no_rekening_simuda' => $id);
        $data['master_rekening_simuda'] = $this->M_simuda->getDetailMasterSimuda($where);
        $data['detail_rekening_simuda'] = $this->M_simuda->get1DetailSimuda($where);
        $this->load->view('master_template',$data);
    }
    function bagiHasil(){
        $data['path'] = 'simuda/perhitungan_bagi_hasil';
        $data['nominatif'] = $this->M_simuda->getMasterSimuda();
        $this->load->view('master_template',$data);
    }
    function previewPerhitunganAkhirBulan(){
        $nominal = $this->input->post('nominal');
        $nominatif = $this->M_simuda->getMasterSimuda();
        
        //Mendapatkan Total Saldo Terendah
        $total_saldo_terendah_akhir_bulan = 0; 
        foreach($nominatif as $i){
            $total_saldo_terendah_akhir_bulan += $i->saldo_terendah_bulan_lalu; 
        }

        //Menampilkan Data
        $no = 1;
        foreach($nominatif as $i){
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$i->no_rekening_simuda."</td>";
            echo "<td>".$i->no_anggota."</td>";
            echo "<td>".$i->nama."</td>";
            echo "<td class='text-right'>".number_format($i->saldo_bulan_lalu,0,',','.')."</td>";
            echo "<td class='text-right'>".number_format($i->saldo_terendah_bulan_lalu,0,',','.')."</td>";
            //Perhitungan Data Saldo Terendah
            $nilai_bagi_hasil = $i->saldo_terendah_bulan_lalu / $total_saldo_terendah_akhir_bulan * $nominal;
            echo "<td class='text-right'>".number_format($nilai_bagi_hasil,0,',','.')."</td>";
            //Perhitungan Data Nominal
            $data_nominal = $i->saldo_bulan_ini + $nilai_bagi_hasil;
            echo "<td class='text-right font-weight-bold'>".number_format($data_nominal,0,',','.')."</td>";
            echo "</tr>";
        }
    }

    function simpanPerhitunganAkhirBulan(){
        $nominal = $this->input->post('nominal');
        $nominatif = $this->M_simuda->getMasterSimuda();
        //Mendapatkan Total Saldo Terendah
        $total_saldo_terendah_akhir_bulan = 0;
        foreach($nominatif as $i){
            $total_saldo_terendah_akhir_bulan += $i->saldo_terendah; 
        }

        //Perhitungan Dan Simpan Data
        foreach($nominatif as $i){
            //Mendapatkan Nilai Bagi Hasil
            $nilai_bagi_hasil = $i->saldo_terendah / $total_saldo_terendah_akhir_bulan * $nominal;

            //Perhitungan Data Saldo
            if($this->M_simuda->getJumlahRecordBulanIni($i->no_rekening_simuda) > 0){
                //Mengambil Record Terakhir Bulan Ini
                $data_saldo = $this->M_simuda->getRecordTerakhirBulanIni($i->no_rekening_simuda) + $nilai_bagi_hasil;
            }else{
                //Mengambil Hasil Tutup Buku Bulan Lalu
                $data_saldo = $this->M_simuda->getRecordTerakhirTutupBulanLalu($i->no_rekening_simuda) + $nilai_bagi_hasil;
            }

            $datetime = date('Y-m-d H:i:s');
            //Insert Ke Tabel Master Detail Simuda
            $data_detail_simuda = array(
                'no_rekening_simuda' => $i->no_rekening_simuda,
                'datetime' => $datetime,
                'kredit' => $nilai_bagi_hasil,
                'saldo' => $data_saldo,
                'id_user' => 1
            );
            $this->M_simuda->simpanDetailSimuda($data_detail_simuda);

            //Tutup Bulan
            $data_tutup_bulan = array(
               'no_rekening_simuda' => $i->no_rekening_simuda,
               'tgl_tutup_bulan' => $datetime,
               'saldo' => $data_saldo

            );
            $this->M_simuda->simpanTutupBulanSimuda($data_tutup_bulan);

            //Insert Ke Tabel Jurnal
            $data_jurnal = array(
                'tanggal' => $datetime,
                'kode' => '', //Belum Dikasih
                'lawan' => '',
                'tipe' => 'K',
                'nominal' => $nilai_bagi_hasil,
                'tipe_trx_koperasi' => 'Simuda',
                'id_detail' => $this->db->insert_id()
            );
            $this->M_jurnal->inputJurnal($data_jurnal);
        }
        $this->session->set_flashdata("input_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Operasi Perhitungan Akhir Bulan Sukses</div>");
        redirect('simuda/perhitunganakhirbulan');
    }

    //Daftar Otorisasi
    function daftarTrxOtorisasi(){
        $data['path'] = 'simuda/daftar_trx_otorisasi';
        $data['otorisasi'] = $this->M_otorisasi->get1Otorisasi(array('tipe' => 'Simuda'));
        $this->load->view('master_template',$data); 
    }
}