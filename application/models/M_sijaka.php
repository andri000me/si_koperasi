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

    function getSemuaMasterSijaka(){
        $this->db->join('anggota','master_rekening_sijaka.no_anggota = anggota.no_anggota');
        return $this->db->get($this->master_table)->result();
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
    function getMasterSijaka($bulan_ini, $tahun){
        $query = $this->db->query("CALL perhitungan_tutup_bulan_sijaka(".$bulan_ini.",".$tahun.")");
        $res = $query->result();

        $query->next_result();
        $query->free_result();

        return $res;
    }

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

    public function getTtlRekSijaka()
    {
        $this->db->select('COUNT(NRSj) ttlRekSijaka');
        $this->db->from($this->master_table);
        return $this->db->get()->result();
    }

}