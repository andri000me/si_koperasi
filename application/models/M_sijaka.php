<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_sijaka extends CI_Model{
    private $master_table ='master_rekening_sijaka';
    private $detail_table = 'master_detail_rekening_sijaka';

    function simpanSijaka($data){
        if($this->db->insert($this->master_table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    //tabel daftar nominatif sijaka
    function getSemuaMasterSijaka(){
        $this->db->join('anggota','master_rekening_sijaka.no_anggota = anggota.no_anggota');
        return $this->db->get($this->master_table)->result();
    }

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

    function get1MasterSijaka($where){
        $this->db->select('NRSj,master_rekening_sijaka.no_anggota,nama');
        $this->db->from($this->master_table);
        $this->db->join('anggota','master_rekening_sijaka.no_anggota = anggota.no_anggota');
        $this->db->where($where);
        return $this->db->get()->result();
    }

    //tabel master detail rekening sijaka
    function simpanDetailSijaka($data){
        if($this->db->insert($this->detail_table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function getDetailSijaka($where){
        $this->db->order_by('id_detail_sijaka','DESC');
        $this->db->where($where);
        return $this->db->get($this->detail_table)->result();
    }

    //perhitungan akhir bulan
    // function getMasterSijaka($bulan_ini, $tahun){
    //     $query = $this->db->query("CALL perhitungan_tutup_bulan_sijaka(".$bulan_ini.",".$tahun.")");
    //     $res = $query->result();

    //     $query->next_result();
    //     $query->free_result();

    //     return $res;
    // }

    function getJumlahRecordBulanIni($NRSj,$bulan,$tahun){
        $where = array(
            'NRSj' => $NRSj,
            'month(datetime)' => $bulan,
            'year(datetime)' => $tahun
        );
        $this->db->select('id_detail_sijaka');
        $this->db->from($this->detail_table);
        $this->db->where($where);
        return $this->db->count_all_result();
    }

}