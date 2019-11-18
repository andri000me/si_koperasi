<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Kelola_kredit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_kelola_kredit');
    }
    function index()
    {
        $data['title'] = 'Kelola Kredit';
        $data['path'] = "kelola_kredit/v_kelola_kredit";
        $data['kelola_kredit'] = $this->M_kelola_kredit->getKelolakredit();
        $this->load->view('master_template', $data);
    }

    function manageAjaxGetNoKredit()
    {
        $no_rekening_pembiayaan = $this->input->post('id');
        $data['kelola_kredit'] = $this->M_kelola_kredit->get1noKelolaKredit(array('no_rekening_pembiayaan' => $no_rekening_pembiayaan));
        $this->load->view('kelola_kredit/get_data_anggota', $data);
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
