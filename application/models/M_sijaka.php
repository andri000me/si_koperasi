<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_sijaka extends CI_Model{
    private $master_table ='master_rekening_sijaka';
    private $detail_table = 'master_detail_rekening_sijaka';
    private $support_table = 'support_bagi_hasil_sijaka';
    
    //.....Tabel Master Sijaka
    //tabel daftar nominatif sijaka
    function getSemuaMasterSijaka(){
        $this->db->join('anggota','master_rekening_sijaka.no_anggota = anggota.no_anggota');
        return $this->db->get($this->master_table)->result();
    }

    //Mendapatkan 1 Record dari Tabel Master Sijaka
    function get1MasterSijaka($where){
        $this->db->select('*');
        $this->db->from($this->master_table);
        $this->db->join('anggota','master_rekening_sijaka.no_anggota = anggota.no_anggota');
        $this->db->where($where);
        return $this->db->get()->result();

    }

    //Simpan Data Ke Tabel Master Sijaka
    function simpanSijaka($data){
        if($this->db->insert($this->master_table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    //Update Tabel Master Sijaka
    function updateMasterSijaka($NRSj,$data){
        $this->db->where('NRSj',$NRSj);
        $this->db->update($this->master_table,$data);
    }

    //Mendapatkan Record Sijaka Untuk Pembayaran Bulan Selanjutnya
    function getPreviewDataPembayaranSijakaBulanDepan(){
        $this->db->select('NRSj,anggota.no_anggota,nama,tanggal_pembayaran,jumlah_bahas_bulanan');
        $this->db->from($this->master_table);
        $this->db->join('anggota','master_rekening_sijaka.no_anggota = anggota.no_anggota');
        $this->db->where("bulan_berjalan < jangka_waktu");
        return $this->db->get()->result();
    }
    //............Tabel Detail Sijaka
    //Simpan Data Ke Tabel Master Detail Sijaka
    function simpanDetailSijaka($data){
        if($this->db->insert($this->detail_table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function getDetailSijaka($where){
        $this->db->select('id_detail_sijaka,NRSj,datetime,nominal,tipe_penarikan,user.id_user,user.nama_terang');
        $this->db->from($this->detail_table);
        $this->db->join('user','master_detail_rekening_sijaka.id_user = user.id_user');
        $this->db->where($where);
        return $this->db->get()->result();
    }

    //.......Tabel Support Bagi Hasil Sijaka
    function simpanDataPembayaranSijakaBulanDepan($data){
        if($this->db->insert($this->support_table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function getDataPembayaranSijakaBulanDepan(){
        $this->db->select('id_support_bagi_hasil,support_bagi_hasil_sijaka.NRSj,anggota.no_anggota,nama,support_bagi_hasil_sijaka.tanggal_pembayaran,jumlah_pembayaran');
        $this->db->from($this->support_table);
        $this->db->join('master_rekening_sijaka','support_bagi_hasil_sijaka.NRSj  = master_rekening_sijaka.NRSj');
        $this->db->join('anggota','master_rekening_sijaka.no_anggota = anggota.no_anggota');
        return $this->db->get();
    }
    function get1DataPembayaranSijakaBulanDepan($id){
        $this->db->select('id_support_bagi_hasil,support_bagi_hasil_sijaka.NRSj,anggota.no_anggota,nama,rekening_simuda,support_bagi_hasil_sijaka.tanggal_pembayaran,jumlah_pembayaran');
        $this->db->from($this->support_table);
        $this->db->join('master_rekening_sijaka','support_bagi_hasil_sijaka.NRSj  = master_rekening_sijaka.NRSj');
        $this->db->join('anggota','master_rekening_sijaka.no_anggota = anggota.no_anggota');
        $this->db->where(array('id_support_bagi_hasil' => $id));
        return $this->db->get();
    }

    function deleteDataPembayaranSijakaBulanDepan($id){
        $this->db->where('id_support_bagi_hasil', $id);
        $this->db->delete($this->support_table);
        
    }

    //Mendapatkan Record Sijaka Selesai
    function getRecordSijakaSelesai(){
        $this->db->select('NRSj,anggota.no_anggota,nama,tanggal_pembayaran,jumlah_simpanan,jangka_waktu,progress_bahas');
        $this->db->from($this->master_table);
        $this->db->join('anggota','master_rekening_sijaka.no_anggota = anggota.no_anggota');
        $this->db->where("jangka_waktu = progress_bahas");
        $this->db->where('status_dana','Belum Diambil');
        return $this->db->get()->result();
    }
    
    ///////////////////////////////////

    

    //tabel perhitungan akhir bulan sijaka
    function getSijakaBerjalan(){
        $this->db->select('m.NRSj, m.no_anggota, m.jumlah_awal, m.presentase_bagi_hasil_bulanan , m.bulan_berjalan, m.jangka_waktu, m.tanggal_akhir, m.total_bahas, m.grandtotal, a.nama');
        $this->db->from("$this->master_table m");
        $this->db->join('anggota a','m.no_anggota = a.no_anggota');
        $this->db->where('jangka_waktu > bulan_berjalan');
        return $this->db->get()->result();
    }

    function updateSijakaBerjalan($where,$data){
        // $this->db->where($where);
        $this->db->update($this->master_table,$data, $where);
    }

    

    function getJumlahSaldo($NRSj){
        $where = array(
            'NRSj' => $NRSj
        );
        $this->db->select('grandtotal');
        $this->db->from($this->master_table);
        $this->db->where($where);
        foreach($this->db->get()->result() as $data){ //ngeluarkan data
            return $data->grandtotal; 
        }
    }

    public function getTtlRekSijaka()
    {
        $this->db->select('COUNT(NRSj) ttlRekSijaka');
        $this->db->from($this->master_table);
        return $this->db->get()->result();
    }
}