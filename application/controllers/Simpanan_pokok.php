<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Simpanan_pokok extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_simpanan_pokok');
        $this->load->model('M_jurnal');
        $this->load->model('M_anggota');
    }
    function index()
    {
        $data['title'] = 'Simpanan Pokok';
        $data['path'] = "simpanan_pokok/v_simpanan_pokok";
        $data['anggota'] = $this->M_anggota->getAnggota();
        $this->load->model('M_anggota');
        $data['simpanan_pokok'] = $this->M_simpanan_pokok->getSimpananpokok()->result();
        $this->load->view('master_template', $data);
    }

    function manageAjaxGetDataAnggota(){
        
        $no_anggota = $this->input->post('id');
        $data['anggota'] = $this->M_anggota->get1Anggota(array('no_anggota' => $no_anggota));
        $this->load->view('simpanan_pokok/get_data_anggota',$data);
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

            $datetime = date('Y-m-d H:i:s');
            $data_jurnal = array(
                'tanggal' => $datetime,
                'keterangan' => 'Simpanan pokok dari no anggota ' . $this->input->post('no_anggota'),
                'kode' => '01.100.20',
                'lawan' => '01.260.10',
                'tipe' => 'D',
                'nominal' => $this->input->post('jumlah'),
                'tipe_trx_koperasi' => 'Simpanan Pokok',
                'id_detail' => NULL

            );
            $this->M_jurnal->inputJurnal($data_jurnal);

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

    function delete($id)
    {
        // $id = $this->input->post('id');
        $where = array('id_simpanan_pokok' => $id);
        $this->M_simpanan_pokok->hapus_data($where, 'master_simpanan_pokok');
        redirect('Simpanan_pokok');
    }

    // function edit()
    // {
    //     $id_simpanan_pokok = $this->input->post('id');
    //     $data['simpanan_pokok'] = $this->M_simpanan_pokok->get1Anggota(array('id_simpanan_pokok' => $id_simpanan_pokok));
    //     $this->load->view('simpanan_pokok/edit_simpanan_pokok', $data);
    // }

    function ambilUang(){
        $data['id'] = $this->input->post('id');
        $data['simpanan_pokok'] = $this->M_simpanan_pokok->get1SimpananPokok($data['id'])->result();
        $this->load->view('simpanan_pokok/pencairan_simpanan_pokok',$data);
    }
    function prosesPencairanDana(){
        //Ubah Status Dana
        $where = array('id_simpanan_pokok' => $this->input->post('id_simpanan_pokok'));
        $data = array(
            'status_dana' => 'Diambil'
        );
        $save1 = $this->M_simpanan_pokok->updateSimpananpokok($where, $data);
        //Input Jurnal
        $data_jurnal = array(
            'tanggal' => date('Y-m-d H:i:s'),
            'keterangan' => 'Penarikan Simpanan pokok',
            'kode' => '01.100.20',
            'lawan' => '01.260.10',
            'tipe' => 'K',
            'nominal' => $this->input->post('jumlah'),
            'tipe_trx_koperasi' => 'Simpanan Pokok',
            'id_detail' => $this->db->insert_id()
        );
        $save2 = $this->M_jurnal->inputJurnal($data_jurnal);
        if($save1 AND $save2){
            $this->session->set_flashdata("update_success", "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Berhasil Diperbarui.</div>");
        }else{
            $gagal = validation_errors();
            $this->session->set_flashdata("update_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Data Gagal Diubah!!<br>" . $gagal . "</div>");
        }
        redirect('simpanan_pokok');
    }


    function update()
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
    }
}
