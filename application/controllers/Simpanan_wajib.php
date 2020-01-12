<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Simpanan_wajib extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_simpanan_wajib');
        $this->load->model('M_anggota');
        $this->load->model('M_jurnal');
    }
    //Halaman Kelola Rekening
    function kelolaRekening(){
        $data['title'] = 'Kelola Rekening';
        $data['path'] = "simpanan_wajib/kelola_rekening";
        $data['anggota'] = $this->M_anggota->getAnggota();
        $this->load->view('master_template',$data);
    }
    //Ajax
    function manageAjaxGetSaldo(){
        $no_anggota = $this->input->post('no_anggota');
        $jml_record_simpanan_per_anggota = $this->M_simpanan_wajib->countSimpananPerAnggota($no_anggota);
        if($jml_record_simpanan_per_anggota == 0){ //Jika Record == 0
            echo 0;
        }else if($jml_record_simpanan_per_anggota > 0){ //Jika Record Lebih Dari 0
            $simpanan_wajib_anggota = $this->M_simpanan_wajib->getSaldoPerAnggota($no_anggota);
            foreach($simpanan_wajib_anggota as $i){
            echo $i->saldo;
        }
        }
        
    }
    function manageAjaxGetBulan(){
        $no_anggota = $this->input->post('no_anggota');
        //Mendapatkan Jumlah Record Berdasarkan No.Anggota
        $jml_record_simpanan_per_anggota = $this->M_simpanan_wajib->countSimpananPerAnggota($no_anggota);
        //Declare Variable
        $tgl_temp = '';
        $tgl_temp_show = '';
        if($jml_record_simpanan_per_anggota == 0){//Jika Record == 0, Maka Tgl Temp = 01-Bulan Ini-Tahun Ini
            $tgl_temp = date('Y-m-01');
            $tgl_temp_show = date('m-y');
        }else if($jml_record_simpanan_per_anggota > 0){ //Jika Record >0, Maka tgl temp = get tgl_temp record terakhir + 1 bulan
            $tgl_temp = date('Y-m-01',strtotime($this->M_simpanan_wajib->getTglTempRecordTerakhir($no_anggota).'+1 month'));
            $tgl_temp_show = date('m-y',strtotime($tgl_temp));
        }
        //Mengirim Response Ke Ajax
        echo json_encode(array("tgl_temp" => $tgl_temp,"tgl_temp_show" => $tgl_temp_show));
    }

    function add()
    {
        $config = array(
            array(
                'field' => 'no_anggota',
                'label' => 'No Anggota',
                'rules' => 'required'
            ),
            array(
                'field' => 'saldo_awal',
                'label' => 'Saldo awal',
                'rules' => 'required'
            ),
            array(
                'field' => 'tipe',
                'label' => 'Tipe',
                'rules' => 'required'
            ),
            array(
                'field' => 'jumlah',
                'label' => 'Jumlah',
                'rules' => 'required'
            ),
            array(
                'field' => 'saldo_akhir',
                'label' => 'Saldo Akhir',
                'rules' => 'required'
            ),

        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == TRUE) {
            // jika validasi berhasil maka input ke tabel simpanan Wajib
            $datetime = date('Y-m-d H:i:s');
            if($this->input->post('tipe') == "K"){ //Jika Tipe Kredit
                $data = array(
                    'no_anggota' => $this->input->post('no_anggota'),
                    'tgl_temp' => $this->input->post('tgl_temp'),
                    'tgl_pembayaran' => $datetime,
                    'kredit' => $this->input->post('jumlah'),
                    'saldo' => $this->input->post('saldo_akhir'),
                    'id_user' => '1'
                );
            }else if($this->input->post('tipe') == "D"){ //Jika Tipe Debet
                $data = array(
                    'no_anggota' => $this->input->post('no_anggota'),
                    'tgl_temp' => $this->input->post('tgl_temp'),
                    'tgl_pembayaran' => $datetime,
                    'debet' => $this->input->post('jumlah'),
                    'saldo' => $this->input->post('saldo_akhir'),
                    'id_user' => '1'
                );
            }
            $this->M_simpanan_wajib->addSimpananwajib($data);

            //Insert Ke Tabel Jurnal
            if ($this->input->post('tipe') == "K") {
                $keterangan = 'Kredit ';
                $tipe_jurnal = 'D';
            }
            else {
                $keterangan = 'Debet ';
                $tipe_jurnal = 'K';
            }
            $data_jurnal = array(
                'tanggal' => $datetime,
                'keterangan' => $keterangan.'Simpanan wajib dari no anggota ' . $this->input->post('no_anggota'),
                'kode' => '01.100.20', //Belum Dikasih
                'lawan' => '01.260.20',
                'tipe' => $tipe_jurnal,
                'nominal' => $this->input->post('jumlah'),
                'tipe_trx_koperasi' => 'Simpanan Wajib',
                'id_detail' => NULL
            );
            $save2 = $this->M_jurnal->inputJurnal($data_jurnal);

            $this->session->set_flashdata("input_success", "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan.</div>");
            
        } else { //jika validasi form gagal
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>" . $gagal . "</div>");
        }
        redirect('Simpanan_wajib/nominatif');
    }

    //Daftar Nominatif
    function nominatif(){
        $data['title'] = 'Daftar Nominatif';
        $data['path'] = 'simpanan_wajib/daftar_nominatif_wajib';
        $data['nominatif'] = $this->M_simpanan_wajib->getNominatif();
        $this->load->view('master_template',$data);
    }
    //Detail
    function detail($id){
        $data['title'] = 'Detail Simpanan Per Anggota';
        $data['path'] ='simpanan_wajib/detail_simpanan_per_anggota';
        $data['anggota'] = $this->M_anggota->get1Anggota(array('no_anggota' => $id));
        $data['simpanan_per_anggota'] = $this->M_simpanan_wajib->getSimpananPerAnggota($id);
        $this->load->view('master_template',$data);
    }
}
