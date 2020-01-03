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
        $this->load->view('sijaka/get_data_anggota',$data);
    }


    //Aksi Pembukaan Rekening Baru Sijaka
    function simpanRekeningBaruSijaka(){
        $config = array(
            //array('field'=>'name view','label'=>'nama label','rules'=>'required')
            array('field'=>'NRSj','label'=>'No. Rekening','rules'=>'required|is_unique[master_rekening_sijaka.NRSj]'),
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
            //array('field'=>'saldo','label'=>'','rules'=>'required')
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

    function manageAjaxDate()
    {
        $tgl_awal = $this->input->post('tgl_awal_field');
        $jangka_waktu = $this->input->post('jangka_waktu_field');
        $date = date('Y-m-d', strtotime("+" . $jangka_waktu . " months", strtotime($tgl_awal)));
        echo $date;
    }

    function daftarNominatifSijaka(){
        $data['path'] = 'sijaka/daftar_nominatif_sijaka';
        $data['nominatif'] = $this->M_sijaka->getSemuaMasterSijaka();
        $this->load->view('master_template',$data);
    }

    //perhitungan akhir bulan sijaka
    function perhitunganAkhirBulanSijaka(){
        $data['path'] = 'sijaka/perhitungan_akhir_bulan_sijaka';
        $data['akhir_bulan'] = $this->M_sijaka->getSijakaBerjalan();
        $this->load->view('master_template',$data);
    }

    function updatePerhitunganAkhirBulanSijaka(){
        $sijakaBerjalan = $this->M_sijaka->getSijakaBerjalan();
        // echo "<pre>";
        // print_r($sijakaBerjalan);
        // echo "</pre>";
        foreach ($sijakaBerjalan as $value) {
            $nrsj = $value->NRSj;
            $jumlah_awal = $value->jumlah_awal;
            $bahas = $value->presentase_bagi_hasil_bulanan;
            $ttl_bahas = $value->total_bahas;
            $bulan_berjalan = $value->bulan_berjalan + 1;
            $total_bahas = $ttl_bahas + $bahas;
            // echo $total_bahas . "<br>";
            $data = array(
                'total_bahas' => $total_bahas,
                'grandtotal' => $jumlah_awal + $total_bahas,
                'bulan_berjalan' => $bulan_berjalan
            );
            $where = array('NRSj' => $nrsj);

            $this->M_sijaka->updateSijakaBerjalan($where,$data);

        }

        // $NRSj = $this->input->post('NRSj');
        // $total_bahas = $this->input->post('total_bahas'); //presentase_bagi_hasil_bulanan * (bulan_berjalan + 1)
        // $grandtotal = $this->input->post('grandtotal'); // jumlah_sekarang + total_bahas 
        // //$jumlah_sekarang = $this->input->('jumlah_sekarang'); //jumlah_awal + total_bahas
        // $berjalan = $bulan_berjalan + 1;
        // $data = array(
        //     'total_bahas' => $presentase_bagi_hasil_bulanan * $berjalan,
        //     'grandtotal' => $jumlah_awal + $total_bahas
        // );
        // $where = array('NRSj'=>$NRSj);
        // $this->m_sijaka->updateSijakaBerjalan($data,$where);
        redirect('sijaka/perhitunganAkhirBulanSijaka');
    }

    function detailRekeningSijaka($id){
        $data['path'] = 'sijaka/detail_rekening_sijaka';
        $data['id'] = $id;
        $where = array('NRSj' => $id);
        $data['master_rekening_sijaka'] = $this->M_sijaka->get1MasterSijaka($where);
        $data['detail_rekening_sijaka'] = $this->M_sijaka->getDetailSijaka($where);
        $this->load->view('master_template',$data);
    }

    //-----Halaman Form Buka Rekening----------------
    //Form Kelola Rekening
    function kelolaRekeningSijaka(){
        $data['path'] = 'sijaka/kelola_rekening_sijaka';
        $data['master_sijaka'] = $this->M_sijaka->getSemuaMasterSijaka();
        $this->load->view('master_template',$data);
    }

    //get saldo awal di form kelola rekening
    //cari algoritma get nominal sijaka dulu
    function getNominalSaldoSijaka(){
        $NRSj = $this->input->post('id');
        $data_nominal = $this->M_sijaka->getJumlahRecordBulanIni($NRSj, date('m'), date('Y'));
    }

    //digunakan untuk memproses rekening / kirim ke halaman otorisasi
    function simpanKelolaRekeningSijaka(){
        //melakukan form validasi
        $config = array(
            array('field'=>'NRSj','label'=>'No. Rekening','rules'=>'required'),
            array('field'=>'datetime','label'=>'Datetime','rules'=>'required'),
            array('field'=>'tipe','label'=>'Tipe','rules'=>'required'),
            array('field'=>'jumlah','label'=>'Jumlah','rules'=>'required'),
            array('field'=>'saldo_akhir','label'=>'saldo_akhir','rules'=>'required'),
        );
        $this->form_validation->set_rules($config);
        if($this->form_validation->run() == TRUE){
            //Jika yang diklik adalah tombol proses, maka :
            if($this->input->post('simpan_') == "proses"){
                //input ke table detai sijaka
                if($this->input->post('tipe') == "K"){
                    //jika tipe kredit
                    $data = array(
                        'NRSj' => $this->input->post('NRSj'),
                        'datetime' => $this->input->post('datetime'),
                        'kredit' => $this->input->post('jumlah'),
                        'saldo' => $this->input->post('saldo_akhir'),
                        'id_user' => 1
                    );
                }else if($this->input->post('tipe') == "D"){
                    //jika tipe debet
                    $data = array(
                        'NRSj' => $this->input->post('NRSj'),
                        'datetime' => $this->input->post('datetime'),
                        'debet' => $this->input->post('jumlah'),
                        'saldo' => $this->input->post('saldo_akhir'),
                        'id_user' => 1
                    );
                }
                $save1 = $this->M_simuda->simpanDetailSijaka($data);

                //insert ke table jurnal
                $data_jurnal = array(
                    'tanggal' => $datetime,
                    'kode' => '', //Belum Dikasih
                    'lawan' => '',
                    'tipe' => 'K',
                    'nominal' => $this->input->post('jumlah'),
                    'tipe_trx_koperasi' => 'Sijaka',
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
            }else if($this->input->post('simpan_') == "pengajuan"){
                //jika yang diklik adalah tombol pengajuan
                //input ke tabel otorisasi
                $data_otorisasi = array(
                    'tipe' => 'Sijaka',
                    'NRSj' => $this->input->post('NRSj'),
                    'nominal_debet' => $this->input->post('jumlah'),
                    'status' => 'Open'
                );
                if($this->M_otorisasi->saveOtorisasi($data_otorisasi) == TRUE){
                    $this->session->set_flashdata("input_success","<div class='alert alert-success'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan!!</div>");
                }
            }
        }else{
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed","<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>".$gagal."</div>");
        }
        //redirect ke halaman kelola rekening
        redirect('Sijaka/kelolaRekeningSijaka');
    }

}
?>