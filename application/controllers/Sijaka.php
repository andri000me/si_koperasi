<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class Sijaka extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_sijaka');
        $this->load->model('M_anggota');
        $this->load->model('M_simuda');
        $this->load->model('M_jurnal');
        $this->load->model('M_otorisasi');
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
        if($this->M_anggota->countAnggota(array('no_anggota' => $no_anggota)) == 0){
            echo json_encode(   
                array(
                    "nama" => "",
                    "alamat" => ""
                )
            );
        }else{
            foreach($data['anggota'] as $i){
                echo json_encode(   
                    array(
                        "nama" => $i->nama,
                        "alamat" => $i->alamat
                    )
                );
            }
        }
    }


    //Aksi Pembukaan Rekening Baru Sijaka
    function simpanRekeningBaruSijaka(){
        $config = array(
            //array('field'=>'name view','label'=>'nama label','rules'=>'required')
            array('field'=>'NRSj','label'=>'No. Rekening','rules'=>'required|is_unique[master_rekening_sijaka.NRSj]'),
            array('field'=>'no_anggota','label'=>'No. Anggota','rules'=>'required'),
            array('field'=>'jumlah','label'=>'Jumlah','rules'=>'required'),
            array('field'=>'jangka_waktu','label'=>'Jangka Waktu','rules'=>'required'),
            array('field'=>'tanggal_awal','label'=>'Tanggal Awal','rules'=>'required'),
            array('field'=>'tanggal_akhir','label'=>'Tanggal Akhir','rules'=>'required'),
            array('field'=>'presentase_bagi_hasil_bulanan','label'=>'Jumlah Bayar Bahas','rules'=>'required'),
            array('field'=>'pembayaran_bahas','label'=>'Pembayaran','rules'=>'required'),
            array('field'=>'perpanjangan_otomatis','label'=>'Perpanjangan Otomatis','rules'=>'required')
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            //Simpan Ke Table Master Rekening Sijaka
            $data_master = array(
                //'nama field db' => $this->input->post('name di view')
                'NRSj' => $this->input->post('NRSj'),
                'no_anggota' => $this->input->post('no_anggota'),
                'jumlah_simpanan' => $this->input->post('jumlah'),
                'jangka_waktu' => $this->input->post('jangka_waktu'),
                'tanggal_pembayaran' => $this->input->post('tanggal_awal'),
                'tanggal_akhir' => $this->input->post('tanggal_akhir'),
                'jumlah_bahas_bulanan' => $this->input->post('presentase_bagi_hasil_bulanan'),
                'pembayaran_bahas' => $this->input->post('pembayaran_bahas'),
                'rekening_simuda' => $this->input->post('no_rekening_simuda'),
                'status_dana' => 'Belum Diambil', 
                'otomatis_perpanjang' => $this->input->post('perpanjangan_otomatis')                
            );
            $this->M_sijaka->simpanSijaka($data_master);

            $datetime = date('Y-m-d h:i:s');

            $data_jurnal = array(
                'tanggal' => $datetime,
                'kode' => '', //Belum Dikasih
                'lawan' => '',
                'tipe' => 'K',
                'nominal' => $this->input->post('jumlah'),
                'tipe_trx_koperasi' => 'Sijaka',
                'id_detail' => $this->db->insert_id()
            );
            $this->M_jurnal->inputJurnal($data_jurnal);

            //simpan ke tabel master detail rekening sijaka
            // $data_detail = array(
            //     'NRSj' => $this->input->post('NRSj'),
            //     'kredit' => $this->input->post('jumlah'),
            //     'saldo' => $this->input->post('jumlah'),
            //     'id_user' => '1' //Sementara
            // );
            // $this->M_sijaka->simpanDetailSijaka($data_detail);

            $this->session->set_flashdata("input_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan!!</div>");
        }else{
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        redirect('sijaka/bukaRekeningSijaka');
    }

    function manageAjaxDate(){
        $tgl_awal = $this->input->post('tgl_awal_field');
        $jangka_waktu = $this->input->post('jangka_waktu_field');
        $date = date('Y-m-d', strtotime("+" . $jangka_waktu . " months", strtotime($tgl_awal)));
        echo $date;
    }

    //Hitung Kewajiban Bulanan
    function hitungKewajibanBulanan(){
        $data['path'] = 'sijaka/hitung_kewajiban_bulanan';
        $this->load->view('master_template',$data);
    }
    function previewHitungKewajibanBulanan(){
        $record_bulan_depan = $this->M_sijaka->getPreviewDataPembayaranSijakaBulanDepan();
        $no = 1;
        foreach($record_bulan_depan as $i){
            $newDate = date('d', strtotime($i->tanggal_pembayaran)).date('-m-Y',strtotime("+1 month"));
            
            echo "<tr>
                    <td>".$no++."</td>
                    <td>".$i->NRSj."</td>
                    <td>".$i->no_anggota."-".$i->nama."</td>
                    <td>".$newDate."</td>
                    <td class='text-right'>Rp. ".number_format($i->jumlah_bahas_bulanan,0,',','.')."</td>
            ";
        }
    }
    function simpanPerhitunganKewajibanBulanan(){
        //Mengambil Data Preview
        $record_bulan_depan = $this->M_sijaka->getPreviewDataPembayaranSijakaBulanDepan();
        $total_kewajiban_bahas = 0;

        foreach($record_bulan_depan as $i){
            //Input Ke Tabel Support Pembayaran Bulan Depan
            $total_kewajiban_bahas += $i->jumlah_bahas_bulanan;
            $data = array(
                'NRSj' => $i->NRSj,
                'tanggal_pembayaran' => date('Y-m-',strtotime("+1 month")).date('d', strtotime($i->tanggal_pembayaran)),
                'jumlah_pembayaran' => $i->jumlah_bahas_bulanan
            );
            $this->M_sijaka->simpanDataPembayaranSijakaBulanDepan($data);
            
            //Ambil Data Master Sijaka
            $data_master_sijaka = $this->M_sijaka->get1MasterSijaka(array('NRSj' => $i->NRSj));
            $bulan_berjalan = 0;
            foreach($data_master_sijaka as $i){
                $bulan_berjalan = $i->bulan_berjalan;
            }

            //Update Master Sijaka
            $bulan_berjalan+=1;
            $data_master_sijaka = array(
                'bulan_berjalan' => $bulan_berjalan
            );
            $this->M_sijaka->updateMasterSijaka($i->NRSj,$data_master_sijaka);

        }
        //Insert Ke Tabel Jurnal
        $data_jurnal = array(
            'tanggal' => date('Y-m-d H:i:s'),
            'kode' => '', //Belum Dikasih
            'lawan' => '',
            'tipe' => 'K',
            'nominal' => $total_kewajiban_bahas,
            'tipe_trx_koperasi' => 'Sijaka',
            'id_detail' => NULL
        );
        $this->M_jurnal->inputJurnal($data_jurnal);

        //Redirect
        $this->session->set_flashdata("input_success","<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Kewajiban Pembayaran Sijaka Bulan Depan Berhasil Disimpan!!</div>");
        redirect('sijaka/hitungKewajibanBulanan');
    }

    //Pembayaran Bahas
    function pembayaranBahas(){
        $data['path'] = 'sijaka/pembayaran_bahas';
        $data['dataPembayaranBahas'] = $this->M_sijaka->getDataPembayaranSijakaBulanDepan()->result();
        $this->load->view('master_template',$data);
    }
    function kreditRekeningSimuda($id){
        //Datetime
        $datetime = date('Y-m-d H:i:s');
        //Mengambil Jumlah Pembayaran Dari Tabel Support Bagi Hasil Simuda
        $support_data = $this->M_sijaka->get1DataPembayaranSijakaBulanDepan($id)->result();
        $jumlah_pembayaran_bahas = 0;
        $NRSj = "";
        $no_rekening_simuda = "";
        foreach($support_data as $i){
            $jumlah_pembayaran_bahas = $i->jumlah_pembayaran;
            $NRSj = $i->NRSj;
            $no_rekening_simuda = $i->rekening_simuda;
        }

        //Ambil Saldo Terakhir Rekening Simuda
        $nominal_saldo_terakhir_db = $this->M_simuda->getSaldoRecordTerakhir($no_rekening_simuda);
        //Saldo Baru Setelah Saldo Terakhir Rekening Simuda Ditambah Jumlah Pembayaran Bahas
        $saldo_baru = $nominal_saldo_terakhir_db + $jumlah_pembayaran_bahas;
        //Mendapatkan Saldo Terendah
        $saldo_terendah = 0;
        if($this->M_simuda->getJumlahRecordBulanIni($no_rekening_simuda) >0){ //Jika Bulan Ini Ada Transaksi, Maka Menggunakan Pengolahan ini
            $record_terakhir_db = $this->M_simuda->getSaldoTerendahRecordTerakhir($no_rekening_simuda);
            if($saldo_baru <= $record_terakhir_db){
                $saldo_terendah = $saldo_baru;
            }else{
                $saldo_terendah = $record_terakhir_db;
            }
        }else{ //Jika Bulan Ini Tidak Ada Transaksi, Maka Menggunakan Pengolahan ini
            $saldo_terendah = $saldo_baru;
        }
        //Insert Ke Tabel Detail Simuda
        $data = array(
            'no_rekening_simuda' => $no_rekening_simuda,
            'datetime' => $datetime,
            'kredit' => $jumlah_pembayaran_bahas,
            'saldo' => $saldo_baru,
            'saldo_terendah' => $saldo_terendah,
            'id_user' => $this->session->userdata('_id')
        );
        $save_simuda = $this->M_simuda->simpanDetailSimuda($data);

        //Ambil Data Master Sijaka
        $data_master_sijaka = $this->M_sijaka->get1MasterSijaka(array('NRSj' => $NRSj));
        $progress_bahas = 0;
        foreach($data_master_sijaka as $i){
            $progress_bahas = $i->progress_bahas;
        }

        //Update Master Sijaka
        $progress_bahas+=1;
        $data_master_sijaka = array(
            'progress_bahas' => $progress_bahas
        );
        $this->M_sijaka->updateMasterSijaka($NRSj,$data_master_sijaka);

        //Insert Ke Tabel Detail Sijaka
        $data_detail_sijaka = array(
            'NRSj' => $NRSj,
            'datetime' => date('Y-m-d H:i:s'),
            'nominal' => $jumlah_pembayaran_bahas,
            'tipe_penarikan' => "Kredit Simuda",
            'id_user' => $this->session->userdata('_id')
        );
        $this->M_sijaka->simpanDetailSijaka($data_detail_sijaka);

        //Insert Ke Tabel Jurnal
        $data_jurnal = array(
            'tanggal' => $datetime,
            'kode' => '', //Belum Dikasih
            'lawan' => '',
            'tipe' => 'K',
            'nominal' => $jumlah_pembayaran_bahas,
            'tipe_trx_koperasi' => 'Simuda',
            'id_detail' => NULL
        );
        $save_jurnal = $this->M_jurnal->inputJurnal($data_jurnal);
        //Delete Data Support Bagi Hasil
        $delete_data_support  = $this->M_sijaka->deleteDataPembayaranSijakaBulanDepan($id);

        //Redirect
        $this->session->set_flashdata("input_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Dana Berhasil Dialhikan Ke Rekening Simuda</div>");
        redirect('sijaka/pembayaranBahas');

    }
    function ambilBahasTunai($id){
        //Datetime
        $datetime = date('Y-m-d H:i:s');
        //Mengambil Field Data Dari Tabel Support Bagi Hasil Simuda
        $support_data = $this->M_sijaka->get1DataPembayaranSijakaBulanDepan($id)->result();
        $NRSj = "";
        $jumlah_pembayaran_bahas = 0;
        foreach($support_data as $i){
            $NRSj = $i->NRSj;
            $jumlah_pembayaran_bahas = $i->jumlah_pembayaran;
        }

        //Ambil Data Master Sijaka
        $data_master_sijaka = $this->M_sijaka->get1MasterSijaka(array('NRSj' => $NRSj));
        $progress_bahas = 0;
        foreach($data_master_sijaka as $i){
            $progress_bahas = $i->progress_bahas;
        }

        //Update Master Sijaka
        $progress_bahas+=1;
        $data_master_sijaka = array(
            'progress_bahas' => $progress_bahas
        );
        $this->M_sijaka->updateMasterSijaka($NRSj,$data_master_sijaka);

        //Insert Ke Tabel Detail Sijaka
        $data_detail_sijaka = array(
            'NRSj' => $NRSj,
            'datetime' => date('Y-m-d H:i:s'),
            'nominal' => $jumlah_pembayaran_bahas,
            'tipe_penarikan' => "Tunai",
            'id_user' => $this->session->userdata('_id')
        );
        $this->M_sijaka->simpanDetailSijaka($data_detail_sijaka);

        //Insert Ke Tabel Jurnal
        $data_jurnal = array(
            'tanggal' => $datetime,
            'kode' => '', //Belum Dikasih
            'lawan' => '',
            'tipe' => 'D',
            'nominal' => $jumlah_pembayaran_bahas,
            'tipe_trx_koperasi' => 'Sijaka',
            'id_detail' => NULL
        );
        $save_jurnal = $this->M_jurnal->inputJurnal($data_jurnal);

        //Delete Data Support Bagi Hasil
        $delete_data_support  = $this->M_sijaka->deleteDataPembayaranSijakaBulanDepan($id);
        //Redirect
        $this->session->set_flashdata("input_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Disimpan, Silahkan Melakukan Pencairan</div>");
        redirect('sijaka/pembayaranBahas');
    } 

    function penarikanDana(){
        $data['path'] = 'sijaka/penarikan_dana';
        $data['sijaka_selesai'] = $this->M_sijaka->getRecordSijakaSelesai();
        $this->load->view('master_template',$data);
    }
    function prosesPenarikanPokokSijaka($NRSj){
        //Mengambil Data Simpanan Pokok Dari Tabel Master Sijaka
        $data_master_sijaka = $this->M_sijaka->get1MasterSijaka(array('NRSj' => $NRSj));
        $jumlah_simpanan = 0;
        foreach($data_master_sijaka as $i){
            $jumlah_simpanan = $i->jumlah_simpanan;
        }

        //Update Tabel Master Sijaka
        $data = array(
            'status_dana' => 'Diambil'
        );
        $this->M_sijaka->updateMasterSijaka($NRSj,$data);
        
        //insert ke table jurnal
        $data_jurnal = array(
            'tanggal' => '',
            'kode' => '', //Belum Dikasih
            'lawan' => '',
            'tipe' => 'K',
            'nominal' => $jumlah_simpanan,
            'tipe_trx_koperasi' => 'Sijaka',
            'id_detail' => NULL
        );
        $save2 = $this->M_jurnal->inputJurnal($data_jurnal);

        //Redirect
        $this->session->set_flashdata("input_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Penarikan Dana Berhasil</div>");
        redirect('sijaka/penarikanDana');

        
    }
    function daftarNominatifSijaka(){
        $data['path'] = 'sijaka/daftar_nominatif_sijaka';
        $data['nominatif'] = $this->M_sijaka->getSemuaMasterSijaka();
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

    // //perhitungan akhir bulan sijaka
    // function perhitunganAkhirBulanSijaka(){
    //     $data['path'] = 'sijaka/perhitungan_akhir_bulan_sijaka';
    //     $data['akhir_bulan'] = $this->M_sijaka->getSijakaBerjalan();
    //     $this->load->view('master_template',$data);
    // }

    // function updatePerhitunganAkhirBulanSijaka(){
    //     $sijakaBerjalan = $this->M_sijaka->getSijakaBerjalan();
    //     // echo "<pre>";
    //     // print_r($sijakaBerjalan);
    //     // echo "</pre>";
    //     foreach ($sijakaBerjalan as $value) {
    //         $nrsj = $value->NRSj;
    //         $jumlah_awal = $value->jumlah_awal;
    //         $bahas = $value->presentase_bagi_hasil_bulanan;
    //         $ttl_bahas = $value->total_bahas;
    //         $bulan_berjalan = $value->bulan_berjalan + 1;
    //         $total_bahas = $ttl_bahas + $bahas;
    //         // echo $total_bahas . "<br>";
    //         $data = array(
    //             'total_bahas' => $total_bahas,
    //             'grandtotal' => $jumlah_awal + $total_bahas,
    //             'bulan_berjalan' => $bulan_berjalan
    //         );
    //         $where = array('NRSj' => $nrsj);

    //         $this->M_sijaka->updateSijakaBerjalan($where,$data);

    //     }
    //     redirect('sijaka/perhitunganAkhirBulanSijaka');
    // }

    

    //-----Halaman Form Buka Rekening----------------
    //Form Kelola Rekening
    // function kelolaRekeningSijaka(){
    //     $data['path'] = 'sijaka/kelola_rekening_sijaka';
    //     $data['master_sijaka'] = $this->M_sijaka->getSemuaMasterSijaka();
    //     $this->load->view('master_template',$data);
    // }

    //get saldo awal di form kelola rekening
    // function getNominalSaldoSijaka(){
    //     $NRSj = $this->input->post('id');
    //     $grandtotal = $this->M_sijaka->getJumlahSaldo($NRSj);
    //     // echo "<pre>";
    //     // print_r($grandtotal);
    //     // echo "</pre>";

    //     echo "<label>Saldo Awal</label>";
    //     echo "<input type='number' name='saldo_awal' id='saldo_awal' class='form-control' value='".$grandtotal."' readonly />";
    // }

    // //digunakan untuk memproses rekening / kirim ke halaman otorisasi
    // function simpanKelolaRekeningSijaka(){
    //     //melakukan form validasi
    //     $config = array(
    //         array('field'=>'NRSj','label'=>'No. Rekening','rules'=>'required'),
    //         array('field'=>'datetime','label'=>'Datetime','rules'=>'required'),
    //         array('field'=>'tipe','label'=>'Tipe','rules'=>'required'),
    //         array('field'=>'jumlah','label'=>'Jumlah','rules'=>'required'),
    //         array('field'=>'saldo_akhir','label'=>'saldo_akhir','rules'=>'required'),
    //     );
    //     $this->form_validation->set_rules($config);
    //     if($this->form_validation->run() == TRUE){
    //         //Jika yang diklik adalah tombol proses, maka :
    //         if($this->input->post('simpan_') == "proses"){
    //             //input ke table detai sijaka
    //             if($this->input->post('tipe') == "K"){
    //                 //jika tipe kredit
    //                 $data = array(
    //                     'NRSj' => $this->input->post('NRSj'),
    //                     'datetime' => $this->input->post('datetime'),
    //                     'kredit' => $this->input->post('jumlah'),
    //                     'saldo' => $this->input->post('saldo_akhir'),
    //                     'id_user' => 1
    //                 );
    //             }else if($this->input->post('tipe') == "D"){
    //                 //jika tipe debet
    //                 $data = array(
    //                     'NRSj' => $this->input->post('NRSj'),
    //                     'datetime' => $this->input->post('datetime'),
    //                     'debet' => $this->input->post('jumlah'),
    //                     'saldo' => $this->input->post('saldo_akhir'),
    //                     'id_user' => 1
    //                 );
    //             }
    //             $save1 = $this->M_simuda->simpanDetailSijaka($data);

    //             //insert ke table jurnal
    //             $data_jurnal = array(
    //                 'tanggal' => '',
    //                 'kode' => '', //Belum Dikasih
    //                 'lawan' => '',
    //                 'tipe' => 'K',
    //                 'nominal' => $this->input->post('jumlah'),
    //                 'tipe_trx_koperasi' => 'Sijaka',
    //                 'id_detail' => NULL
    //             );
    //             $save2 = $this->M_jurnal->inputJurnal($data_jurnal);
    //             if($save1 == TRUE && $save2 == TRUE){
    //                 $this->session->set_flashdata("input_success","<div class='alert alert-success'>
    //                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan!!</div>");
    //             }else{
    //                 $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
    //                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!</div>");
    //             }
    //         }else if($this->input->post('simpan_') == "pengajuan"){
    //             //jika yang diklik adalah tombol pengajuan
    //             //input ke tabel otorisasi
    //             $data_otorisasi = array(
    //                 'tipe' => 'Sijaka',
    //                 'NRSj' => $this->input->post('NRSj'),
    //                 'nominal_debet' => $this->input->post('jumlah'),
    //                 'status' => 'Open'
    //             );
    //             if($this->M_otorisasi->saveOtorisasi($data_otorisasi) == TRUE){
    //                 $this->session->set_flashdata("input_success","<div class='alert alert-success'>
    //                 <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan!!</div>");
    //             }
    //         }
    //     }else{
    //         $gagal = validation_errors();
    //         $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
    //         <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
    //     }
    //     //redirect ke halaman kelola rekening
    //     redirect('Sijaka/kelolaRekeningSijaka');
    // }

}
?>