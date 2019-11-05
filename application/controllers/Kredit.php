<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Kredit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_kredit');
    }

    function pengajuanRekening()
    {
        $data['path'] = 'kredit/form_kredit_baru';
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

    //Form rekening baru
    function rekening_baru()
    {
        $data['path'] = 'kredit/form_kredit_baru';
        $data['anggota'] = $this->M_anggota->getAnggota();
        $this->load->view('master_template', $data);
    }

    //Ajax Get Data Anggota
    function manageAjaxGetDataAnggota()
    {
        $no_anggota = $this->input->post('id');
        $data['anggota'] = $this->M_anggota->get1Anggota(array('no_anggota' => $no_anggota));
        $this->load->view('kredit/get_data_anggota', $data);
    }
}
