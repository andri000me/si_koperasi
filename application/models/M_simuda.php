<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_simuda extends CI_Model{
    private $master_table ='master_rekening_simuda';
    private $detail_table = 'master_detail_rekening_simuda';
    
    function simpanRekeningBaru($data){
        if($this->db->insert($this->master_table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function getMasterSimuda(){
        $this->db->select('no_rekening_simuda,master_rekening_simuda.no_anggota,nama');
        $this->db->from('master_rekening_simuda');
        $this->db->join('anggota','master_rekening_simuda.no_anggota = anggota.no_anggota');
        return $this->db->get()->result();
    }
    function get1MasterSimuda(){
        $this->db->select('no_rekening_simuda');
        $this->db->from('master_rekening_simuda');
        $this->db->join('anggota','master_rekening_simuda.no_anggota = anggota.no_anggota');
        // $this->db->where($where);
        $this->db->get()->result();
    }
    //Limit Debet Simuda
    function getLimitNominalSimuda(){
        $this->db->select('nominal');
        $this->db->from('support_limit_simuda');
        $this->db->where(array('id_limit_simuda' => 1));
        return $this->db->get()->result();
    }
    function updateLimitNominalSimuda($where,$data){
        $this->db->where($where);
        $this->db->update('support_limit_simuda',$data);
    }
}