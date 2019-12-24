<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_simuda extends CI_Model{
    private $master_table ='master_rekening_simuda';
    private $detail_table = 'master_detail_rekening_simuda';
    private $tutup_bulan_simuda = 'support_simuda_tutup_bulan';
    private $limit_debet_table = 'support_limit_simuda';
    
    function simpanRekeningBaru($data){
        if($this->db->insert($this->master_table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function getMasterSimuda($bulan_lalu, $bulan_ini, $tahun){
        $query = $this->db->query("CALL perhitungan_tutup_bulan_simuda(".$bulan_lalu.",".$bulan_ini.",".$tahun.")");
        $res = $query->result();

        $query->next_result();
        $query->free_result();

        return $res;
    }

    function getSemuaMasterSimuda(){
        $this->db->join('anggota','master_rekening_simuda.no_anggota = anggota.no_anggota');
        return $this->db->get($this->master_table)->result();
    }

    function get1MasterSimuda($where){
        $this->db->select('no_rekening_simuda,master_rekening_simuda.no_anggota,nama');
        $this->db->from($this->master_table);
        $this->db->join('anggota','master_rekening_simuda.no_anggota = anggota.no_anggota');
        $this->db->where($where);
        return $this->db->get()->result();
    }
    function getJumlahRecordBulanIni($no_rekening_simuda,$bulan,$tahun){ 
        $where = array(
            'no_rekening_simuda' => $no_rekening_simuda,
            'month(datetime)' => $bulan, 
            'year(datetime)' => $tahun
        );
        $this->db->select('id_detail_rekening_simuda');
        $this->db->from($this->detail_table);
        $this->db->where($where);
        return $this->db->count_all_results();
    }
    function getRecordTerakhirBulanIni($no_rekening_simuda,$bulan,$tahun){
        $where = array(
            'no_rekening_simuda' => $no_rekening_simuda,
            'month(datetime)' => $bulan, 
            'year(datetime)' => $tahun
        );
        $this->db->select('saldo');
        $this->db->from($this->detail_table);
        $this->db->where($where);
        $this->db->order_by('id_detail_rekening_simuda','DESC');
        $this->db->limit(1);
        $data = $this->db->get()->result();
        foreach($data as $i){
            return $i->saldo;
        }
    }
    function getRecordTerakhirTutupBulanLalu($no_rekening_simuda,$bulan,$tahun){
        $where = array(
            'no_rekening_simuda' => $no_rekening_simuda,
            'month(tgl_tutup_bulan)' => $bulan, 
            'year(tgl_tutup_bulan)' => $tahun
        );
        $this->db->select('saldo');
        $this->db->from('support_simuda_tutup_bulan');
        $this->db->where($where);
        $this->db->order_by('id_support_simuda_tutup_bulan','DESC');
        $this->db->limit(1);
        $data = $this->db->get()->result();
        foreach($data as $i){
            return $i->saldo;
        }
    }
    
    //Tabel Master Detail Rekening Simuda
    function simpanDetailSimuda($data){
        if($this->db->insert($this->detail_table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function get1DetailSimuda($where){
        $this->db->order_by('id_detail_rekening_simuda','DESC');
        $this->db->where($where);
        return $this->db->get($this->detail_table)->result();
    }

    //Limit Debet Simuda
    function getLimitNominalSimuda(){
        $this->db->select('nominal');
        $this->db->from($this->limit_debet_table);
        $this->db->where(array('id_limit_simuda' => 1));
        return $this->db->get()->result();
    }
    function updateLimitNominalSimuda($where,$data){
        $this->db->where($where);
        $this->db->update($this->limit_debet_table,$data);
    }
    //Tabel Tutup Bulan Simuda
    function simpanTutupBulanSimuda($data){
        $this->db->insert($this->tutup_bulan_simuda,$data);
    }
}