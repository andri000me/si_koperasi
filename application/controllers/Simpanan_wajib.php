<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Simpanan_wajib extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_simpanan_wajib');
    }
    function index()
    {
        $data['title'] = 'Simpanan Wajib';
        $data['path'] = "simpanan_wajib/v_simpanan_wajib";
        $data['simpanan_wajib'] = $this->M_simpanan_wajib->getSimpananpokok();
        $this->load->view('master_template', $data);
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
                'field' => 'tgl_pembayaran',
                'label' => 'Tanggal Pembayaran',
                'rules' => 'required'
            ),
            array(
                'field' => 'jumlah',
                'label' => 'Jumlah',
                'rules' => 'required'
            ),

        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == TRUE) {
            // jika validasi berhasil maka input ke tabel simpanan pokok
            $data = array(
                'no_anggota' => $this->input->post('no_anggota'),
                'tgl_pembayaran' => $this->input->post('tgl_pembayaran'),
                'jumlah' => $this->input->post('jumlah'),
                'id_user' => '1'
            );
            $this->M_simpanan_wajib->addSimpananwajib($data);
            $this->session->set_flashdata("input_success", "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan.</div>");
            //INPUT KE TABEL SIMPANAN POKOK
        } else { //jika validasi form gagal
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>" . $gagal . "</div>");
        }
        redirect('Simpanan_wajib');
    }
    function delete($id)
    {
        // $id = $this->input->post('id');
        $where = array('id_simpanan_wajib' => $id);
        $this->M_simpanan_wajib->hapus_data($where, 'master_simpanan_wajib');
        redirect('Simpanan_wajib');
    }
    function edit()
    {
        $id_simpanan_wajib = $this->input->post('id');
        $data['simpanan_wajib'] = $this->M_simpanan_wajib->get1Anggota(array('id_simpanan_wajib' => $id_simpanan_wajib));
        $this->load->view('simpanan_wajib/edit_simpanan_wajib', $data);
    }

    function update()
    {
        $config = array(
            array(
                'field' => 'temp_id_simpanan_wajib',
                'label' => 'Temp',
                'rules' => 'required'
            ),
            array(
                'field' => 'no_anggota',
                'label' => 'No anggota',
                'rules' => 'required'
            ),
            array(
                'field' => 'tgl_pembayaran',
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
            $where = array('id_simpanan_wajib' => $this->input->post('temp_id_simpanan_wajib'));
            $data = array(
                'id_simpanan_wajib' => $this->input->post('id_simpanan_wajib'),
                'no_anggota' => $this->input->post('no_anggota'),
                'tgl_pembayaran' => $this->input->post('tgl_pembayaran'),
                'jumlah' => $this->input->post('jumlah')
            );
            $this->M_simpanan_wajib->updateAnggota($where, $data);
            $this->session->set_flashdata("update_success", "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Diperbarui.</div>");
        } else {
            $gagal = validation_errors();
            $this->session->set_flashdata("update_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!<br>" . $gagal . "</div>");
        }
        redirect('simpanan_wajib');
    }
}
