<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Simpanan_pokok extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_simpanan_pokok');
    }
    function index()
    {
        $data['title'] = 'Simpanan Pokok';
        $data['path'] = "simpanan_pokok/v_simpanan_pokok";
        $data['simpanan_pokok'] = $this->M_simpanan_pokok->getSimpananpokok();
        $this->load->view('master_template', $data);
    }
    //function add() digunakan untuk aksi input ke tabel simpanan pokok
    function add()
    {
        $config = array(
            array(
                'field' => 'no_anggota',
                'label' => 'No Anggota',
                'rules' => 'required'
            ),
            array(
                'field' => 'tanggal_pembayaran',
                'label' => 'Tanggal Pembayaran',
                'rules' => 'required'
            ),
            array(
                'field' => 'jumlah',
                'label' => 'Jumlah',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == TRUE) {
            // jika validasi berhasil maka input ke tabel simpanan pokok
            $data = array(
                'no_anggota' => $this->input->post('no_anggota'),
                'tanggal_pembayaran' => $this->input->post('tanggal_pembayaran'),
                'jumlah' => $this->input->post('jumlah')
            );
            $this->M_simpanan_pokok->addSimpananpokok($data);
            //INPUT KE TABEL SIMPANAN POKOK
        } else { //jika validasi form gagal
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>" . $gagal . "</div>");
        }
        redirect('Simpanan_pokok');
    }
    /*function delete($id)
    {
        $where = array('id_simpanan_pokok' => $id);
        $this->M_simpanan_pokok->delete($where, 'master_simpanan_pokok');
        redirect('simpanan_pokok');
    }*/

    /*function edit()
    {
        $this->load->view('simpanan_pokok/edit_simpanan_pokok');
    }*/
}
