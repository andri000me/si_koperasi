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

    function getMasterSijaka(){
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

}