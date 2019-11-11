<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Kredit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_kredit');
        $this->load->model('M_anggota');
    }

    function pengajuanRekening()
    {
        $data['path'] = 'kredit/form_kredit_baru';
        $data['anggota'] = $this->M_anggota->getAnggota();
        $this->load->view('master_template', $data);
    }

    function daftarNominatif()
    {
        $data['title'] = 'Daftar Nominatif Kredit/Pembayaran';
        $data['path'] = "kredit/v_daftar_nominatif_kredit";
        // $data['simpanan_wajib'] = $this->M_simpanan_wajib->getSimpananpokok();
        $this->load->view('master_template', $data);
    }

    function detail()
    {
        $data['title'] = 'Detail Nominatif Kredit/Pembayaran';
        $data['path'] = "kredit/detail_daftar_nominatif_kredit";
        $this->load->view('master_template', $data);
    }

    //Ajax Get Data Anggota
    function manageAjaxGetDataAnggota()
    {
        $no_anggota = $this->input->post('id');
        $data['anggota'] = $this->M_anggota->get1Anggota(array('no_anggota' => $no_anggota));
        $this->load->view('kredit/get_data_anggota', $data);
    }

    function manageAjaxDate()
    {
        $tgl_pembayaran = $this->input->post('tgl_pembayaran_field');
        $jangka_waktu = $this->input->post('jangka_waktu_field');
        $date = date('Y-m-d', strtotime("+" . $jangka_waktu . " months", strtotime($tgl_pembayaran)));
        echo $date;
    }

    //Aksi form kredit 
    function simpanKreditBaru()
    {
        $config = array(
            array('field' => 'no_rekening_pembiayaan', 'label' => 'No. Rekening Pembiayaan', 'rules' => 'required'),
            array('field' => 'no_anggota', 'label' => 'No. Anggota', 'rules' => 'required'),
            array('field' => 'tgl_pembayaran', 'label' => 'Tanggal Pembayaran', 'rules' => 'required'),
            array('field' => 'jumlah_pembiayaan', 'label' => 'Jumlah Pembayaran', 'rules' => 'required'),
            array('field' => 'jangka_waktu_bulan', 'label' => 'Jangka Waktu', 'rules' => 'required'),
            array('field' => 'jml_pokok_bulanan', 'label' => 'Jumlah Pokok Bulanan', 'rules' => 'required'),
            array('field' => 'jml_bahas_bulanan', 'label' => 'Jumlah Bahas Bulanan', 'rules' => 'required'),
            array('field' => 'tgl_lunas', 'label' => 'Tanggal Lunas', 'rules' => 'required')
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == TRUE) {
            //Simpan Ke Tabel Master Rekening pembiayaan
            $data_master = array(
                'no_rekening' => $this->input->post('no_rekening_pembiayaan'),
                'no_anggota' => $this->input->post('no_anggota'),
                'tgl_pembayaran' => $this->input->post('tgl_pembayaran'),
                'jumlah' => $this->input->post('jumlah_pembiayaan'),
                'jangka_waktu' => $this->input->post('jangka_waktu_bulan'),
                'pokok' => $this->input->post('jml_pokok_bulanan'),
                'bahas' => $this->input->post('jml_bahas_bulanan'),
                'lunas' => $this->input->post('tgl_lunas')
            );
            $this->M_kredit->simpanKredit($data_master);

            // $datetime = date('Y-m-d h:i:s');
            // //Simpan Ke Tabel Master Detail Rekening Simuda
            // $data_detail = array(
            //     'no_rekening_simuda' => $this->input->post('no_rekening_simuda'),
            //     'datetime' => $datetime,
            //     'kredit' => $this->input->post('saldo_awal'),
            //     'saldo' => $this->input->post('saldo_awal'),
            //     'id_user' => '1' //Sementara
            // );
            // $this->M_simuda->simpanDetailSimuda($data_detail);

            //Jika Status Rekening Baru (Bukan Migrasi) Insert Ke Tabel Jurnal
            // if ($this->input->post('status_pembukaan_rekening') == '0') {
            //     $data_jurnal = array(
            //         'tanggal' => $datetime,
            //         'kode' => '', //Belum Dikasih
            //         'lawan' => '',
            //         'tipe' => 'K',
            //         'nominal' => $this->input->post('saldo_awal'),
            //         'tipe_trx_koperasi' => 'Simuda',
            //         'id_detail' => $this->db->insert_id()

            //     );
            //     $this->M_jurnal->inputJurnal($data_jurnal);
            //     $this->session->set_flashdata("input_success", "<div class='alert alert-success'>
            //         <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan!!</div>");
            // }
        } else {
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>" . $gagal . "</div>");
        }
        redirect('kredit/pengajuanRekening');
    }
}
