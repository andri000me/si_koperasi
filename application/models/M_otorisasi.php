<?php
defined("BASEPATH") or die("No Direct Access Allowed");

Class M_otorisasi extends CI_Model{
    private $table = 'otorisasi';
    function saveOtorisasi($data){
        if($this->db->insert($this->table,$data)){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function getOtorisasi(){
        $this->db->order_by('id_otorisasi','DESC');
        return $this->db->get($this->table)->result();
    }
    function get1Otorisasi($where){
        return $this->db->get_where($this->table,$where)->result();
    }
    function updateOtorisasi($where,$data){
        $this->db->where($where);
        $this->db->update($this->table,$data);
    }
}