<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_anggota extends CI_Model{
    private $_table = 'anggota';
    function getAnggota(){
        return $this->db->get($this->_table)->result();
    }
    function get1Anggota($where){
        return $this->db->get_where($this->_table,$where)->result();
    }
    function countAnggota($where){
        return $this->db->get_where($this->_table,$where)->num_rows();
    }
    function addAnggota($data){
    	if($this->db->insert($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
    function updateAnggota($where,$data){
        $this->db->where($where);
    	if($this->db->update($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
    function deleteAnggota($where){
        $this->db->where($where);
        if($this->db->delete($this->_table) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
}