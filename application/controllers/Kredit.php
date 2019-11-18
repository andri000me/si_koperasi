<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Kredit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_kredit');
        $this->load->model('M_anggota');
        $this->load->model('M_kelola_kredit');
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

    function kelolaKredit()
    {
        $data['title'] = 'Kelola Kredit';
        $data['path'] = "kredit/v_kelola_kredit";
        $data['kredit'] = $this->M_kredit->getKelolakredit();
        $this->load->view('master_template', $data);
    }

    function manageAjaxGetNoKredit()
    {
        $no_rekening_pembiayaan = $this->input->post('id');
        $data['kredit'] = $this->M_kredit->get1noKelolaKredit(array('no_rekening_pembiayaan' => $no_rekening_pembiayaan));
        $this->load->view('kredit/get_data_no_anggota', $data);
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

    function manageajaxPokok()
    {
        $jumlah_pembiayaan = $this->input->post('jumlah_pembiayaan_field');
        $jangka_waktu = $this->input->post('jangka_waktu_field');
        // $pokok = jumlah_pembiayaan_field; // jangka_waktu_field; ini buat ngitungnya
        // echo $pokok;
    }

    //Aksi form kredit 
    function simpanKreditBaru()
    {
        $config = array(
            array('field' => 'no_rekening_pembiayaan', 'label' => 'No. Rekening Pembiayaan', 'rules' => 'required'),
            array('field' => 'no_anggota', 'label' => 'No. Anggota', 'rules' => 'required'),
            array('field' => 'tgl_pembayaran', 'label' => 'Tanggal Pembayaran', 'rules' => 'required'),
            array('field' => 'jumlah_pembiayaan', 'label' => 'Jumlah Pembiayaan', 'rules' => 'required'),
            array('field' => 'jangka_waktu_bulan', 'label' => 'Jangka Waktu', 'rules' => 'required'),
            array('field' => 'jml_pokok_bulanan', 'label' => 'Jumlah Pokok Bulanan', 'rules' => 'required'),
            array('field' => 'jml_bahas_bulanan', 'label' => 'Jumlah Bahas Bulanan', 'rules' => 'required'),
            array('field' => 'tgl_lunas', 'label' => 'Tanggal Lunas', 'rules' => 'required')
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == TRUE) {
            //Simpan Ke Tabel Master Rekening pembiayaan
            $data_master = array(
                'no_rekening_pembiayaan' => $this->input->post('no_rekening_pembiayaan'),
                'no_anggota' => $this->input->post('no_anggota'),
                'tgl_pembayaran' => $this->input->post('tgl_pembayaran'),
                'jumlah_pembiayaan' => $this->input->post('jumlah_pembiayaan'),
                'jangka_waktu_bulan' => $this->input->post('jangka_waktu_bulan'),
                'jml_pokok_bulanan' => $this->input->post('jml_pokok_bulanan'),
                'jml_bahas_bulanan' => $this->input->post('jml_bahas_bulanan'),
                'tgl_lunas' => $this->input->post('tgl_lunas'),
                'tgl_temp' => $this->input->post('tgl_pembayaran'),

            );
            $this->M_kredit->simpanKredit($data_master);
            $this->session->set_flashdata("input_success", "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil ditambahkan.<br></div>");
        } else {
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>" . $gagal . "</div>");
        }
        redirect('kredit/pengajuanRekening');
    }

    //digunakan untuk aksi input ke tabel simpanan pokok
    function simpanKelolaKredit()
    {
        $config = array(
            array('field' => 'no_rekening_pembiayaan', 'label' => 'No. Rekening Pembiayaan', 'rules' => 'required'),
            array('field' => 'tanggal_pembayaran', 'label' => 'Tanggal Pembayaran', 'rules' => 'required'),
            array('field' => 'periode_tagihan', 'label' => 'Periode Tagihan', 'rules' => 'required'),
            array('field' => 'jml_pokok', 'label' => 'Jumlah Pokok', 'rules' => 'required'),
            array('field' => 'jml_bahas', 'label' => 'Jumlah Bahas', 'rules' => 'required'),
            array('field' => 'denda', 'label' => 'Denda', 'rules' => 'required'),
            array('field' => 'total', 'label' => 'Jumlah', 'rules' => 'required')
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == TRUE) {
            //Simpan Ke Tabel Master detail Rekening pembiayaan
            $detail_table = array(
                'no_rekening_pembiayaan' => $this->input->post('no_rekening_pembiayaan'),
                'tanggal_pembayaran' => $this->input->post('tanggal_pembayaran'),
                'periode_tagihan' => $this->input->post('periode_tagihan'),
                'jml_pokok' => $this->input->post('jml_pokok'),
                'jml_bahas' => $this->input->post('jml_bahas'),
                'denda' => $this->input->post('denda'),
                'total' => $this->input->post('total'),
                'id_user' => '1'
            );
            $this->M_kelola_kredit->simpanKelolaKredit($detail_table);
            $this->session->set_flashdata("input_success", "<div class='alert alert-success'>
             <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data berhasil ditambahkan.<br></div>");
        } else {
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
             <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>" . $gagal . "</div>");
        }
        redirect('kelola_kredit');
    }
}
