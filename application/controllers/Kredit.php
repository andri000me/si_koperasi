<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class Kredit extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('M_kredit');
        $this->load->model('M_anggota');
        $this->load->model('M_jurnal');
        $this->load->model('M_log_activity');
    }
    ///////////////////////////////
    //Pengajuan Rekening
    function pengajuanRekening(){
        $data['path'] = 'kredit/form_kredit_baru';
        $data['anggota'] = $this->M_anggota->getAnggota();
        $this->load->view('master_template', $data);
    }

    //Ajax Get Data Anggota
    function manageAjaxGetDataAnggota(){
        $no_anggota = $this->input->post('id');
        $data['anggota'] = $this->M_anggota->get1Anggota(array('no_anggota' => $no_anggota));
        $this->load->view('kredit/get_data_anggota', $data);
    }
    //Ajax Set Date
    function manageAjaxDate(){
        $tgl_pembayaran = $this->input->post('tgl_pembayaran_field');
        $jangka_waktu = $this->input->post('jangka_waktu_field');
        $date = date('Y-m-d', strtotime("+" . $jangka_waktu . " months", strtotime($tgl_pembayaran)));
        echo $date;
    }
    function simpanKreditBaru(){
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
                'tgl_temp' => date("Y-m-d", strtotime("+1 month", strtotime($this->input->post('tgl_pembayaran')))),


            );
            $this->M_kredit->simpanKredit($data_master);

            $datetime = date('Y-m-d H:i:s');
            $activity = array(
                'id_user' => '1', //sementara
                'datetime' => $datetime,
                'keterangan' => 'Menginput pembiayaan dengan no rekening ' . $this->input->post('no_rekening_pembiayaan') . ' dari anggota ' .$this->input->post('no_anggota') . ' dengan nominal ' . $this->input->post('jumlah_pembiayaan'),
            );
            $this->M_log_activity->insertActivity($activity);

            $this->session->set_flashdata("input_success", "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Pengajuan Berhasil<br></div>");
        } else {
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Pengajuan Gagal<br>" . $gagal . "</div>");
        }
        redirect('kredit/pengajuanRekening');
    }
    ///////////////////////////////
    //Daftar Nominatif
    function daftarNominatif(){
        $data['title'] = 'Daftar Nominatif Kredit/Pembayaran';
        $data['path'] = "kredit/v_daftar_nominatif_kredit";
        $data['kredit'] = $this->M_kredit->getNominatifKredit()->result();
        $this->load->view('master_template', $data);
    }
    function detail($id){
        $data['title'] = 'Detail Kredit/Pembiayaan';
        $data['path'] = "kredit/detail_daftar_nominatif_kredit";
        $data['id'] = $id;
        $data['detail_kredit'] = $this->M_kredit->getNominatifDetailKredit($id)->result();
        $this->load->view('master_template', $data);
    }
    /////////////////////////////
    //Kelola Kredit
    function kelolaKredit(){
        $data['title'] = 'Kelola Kredit';
        $data['path'] = "kredit/v_kelola_kredit";
        $data['kredit'] = $this->M_kredit->getNominatifKredit()->result();
        $this->load->view('master_template', $data);
    }

    function manageAjaxGetDataKelolaKredit(){
        $no_rekening_pembiayaan = $this->input->post('id');
        $kredit = $this->M_kredit->get1NominatifKredit(array('no_rekening_pembiayaan' => $no_rekening_pembiayaan));
        if($kredit->num_rows() == 0){
            echo json_encode(   
                array(
                    "nama" => "",
                    "date" => "",
                    "show_date" => "",
                    "cicilan_terbayar" => "",
                    "pokok" => "",
                    "bagi_hasil" => ""
                )
            );
        }else{
            foreach($kredit->result() as $i){
                echo json_encode(   
                    array(
                        "nama" => $i->nama,
                        "date" => $i->tgl_temp,
                        "show_date" => date('m-y',strtotime($i->tgl_temp)),
                        "cicilan_terbayar" => $i->cicilan_terbayar,
                        "pokok" => $i->jml_pokok_bulanan,
                        "bagi_hasil" => $i->jml_bahas_bulanan
                    )
                );
            }
        }
    }
    //digunakan untuk aksi input ke tabel simpanan Kelola Kredit
    function simpanKelolaKredit(){
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
                'periode_tagihan' => $this->input->post('show_periode_tagihan'),
                'jml_pokok' => $this->input->post('jml_pokok'),
                'jml_bahas' => $this->input->post('jml_bahas'),
                'denda' => $this->input->post('denda'),
                'total' => $this->input->post('total'),
                'id_user' => '1'
            );
            $save1 = $this->M_kredit->simpanKelolaKredit($detail_table);

            //Update Tabel Rekening Pembiayaan
            $where = array('no_rekening_pembiayaan' => $this->input->post('no_rekening_pembiayaan'));
            $next_month = date('Y-m-d', strtotime("+1 months", strtotime($this->input->post('periode_tagihan'))));//Next Month
            $cicilan_terbayar = intval($this->input->post('cicilan_terbayar'));
            $cicilan_terbayar++;
            $data = array(
                'tgl_temp' => $next_month,
                'cicilan_terbayar' => $cicilan_terbayar
            );
            $save2 = $this->M_kredit->updateKredit($where,$data);

            //Simpan Ke Tabel Jurnal
            $data_jurnal = array(
                'tanggal' => $this->input->post('tanggal_pembayaran'),
                'kode' => '', //Belum Dikasih
                'lawan' => '',
                'tipe' => 'K',
                'nominal' => $this->input->post('total'),
                'tipe_trx_koperasi' => 'Kredit',
                'id_detail' => $this->db->insert_id()
            );
            $save3 = $this->M_jurnal->inputJurnal($data_jurnal);

            if($save1 == TRUE || $save2 == TRUE || $save3 == TRUE){
                $this->session->set_flashdata("input_success", "<div class='alert alert-success'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Pembayaran Berhasil<br></div>");
            }else{
                $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Pembayaran Gagal</div>");
            }
        } else {
            $gagal = validation_errors();
            $this->session->set_flashdata("input_failed", "<div class='alert alert-danger'>
             <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Pembayaran Gagal<br>" . $gagal . "</div>");
        }
        redirect('kredit/kelolakredit');
    }
}
