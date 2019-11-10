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
        // $data['kelola_kredit'] = $this->M_kelola_kredit->getKelolakredit();
        $this->load->view('master_template', $data);
    }
    
    //function add() digunakan untuk aksi input ke tabel simpanan pokok
    /*function add()
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
            ),

        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == TRUE) {
            // jika validasi berhasil maka input ke tabel simpanan pokok
            $data = array(
                'no_anggota' => $this->input->post('no_anggota'),
                'tanggal_pembayaran' => $this->input->post('tanggal_pembayaran'),
                'jumlah' => $this->input->post('jumlah'),
                'id_user' => '1'
            );
            $this->M_simpanan_pokok->addSimpananpokok($data);
            $this->session->set_flashdata("input_success", "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Ditambahkan.</div>");
            //INPUT KE TABEL SIMPANAN POKOK
        } else { //jika validasi form gagal
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Ditambahkan!!<br>" . $gagal . "</div>");
        }
        redirect('Simpanan_pokok');
    }
    */
/*
    function delete($id)
    {
        // $id = $this->input->post('id');
        $where = array('id_simpanan_pokok' => $id);
        $this->M_simpanan_pokok->hapus_data($where, 'master_simpanan_pokok');
        redirect('Simpanan_pokok');
    }
*/
//     function edit()
//     {
//         $id_simpanan_pokok = $this->input->post('id');
//         $data['simpanan_pokok'] = $this->M_simpanan_pokok->get1Anggota(array('id_simpanan_pokok' => $id_simpanan_pokok));
//         $this->load->view('simpanan_pokok/edit_simpanan_pokok', $data);
//     }
// 
    /*function update()
    {
        $config = array(
            array(
                'field' => 'temp_id_simpanan_pokok',
                'label' => 'Temp',
                'rules' => 'required'
            ),
            array(
                'field' => 'no_anggota',
                'label' => 'No anggota',
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
            $where = array('id_simpanan_pokok' => $this->input->post('temp_id_simpanan_pokok'));
            $data = array(
                'id_simpanan_pokok' => $this->input->post('id_simpanan_pokok'),
                'no_anggota' => $this->input->post('no_anggota'),
                'tanggal_pembayaran' => $this->input->post('tanggal_pembayaran'),
                'jumlah' => $this->input->post('jumlah')
            );
            $this->M_simpanan_pokok->updateAnggota($where, $data);
            $this->session->set_flashdata("update_success", "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Diperbarui.</div>");
        } else {
            $gagal = validation_errors();
            $this->session->set_flashdata("update_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!<br>" . $gagal . "</div>");
        }
        redirect('simpanan_pokok');
    } */
}
