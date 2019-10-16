<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_kode_induk extends CI_Model{
    private $_table = 'ak_kode_induk';

    function getAll(){
        return $this->db->get($this->_table)->result();
    }

    function getOne($where){
        return $this->db->get_where($this->_table,$where)->result();
    }

    function countKodeInduk($kode, $newKode){
        return $this->db->query("SELECT COUNT(kode_induk) AS countKode FROM ak_kode_induk WHERE kode_induk = '$newKode' AND kode_induk != '$kode' ")->result_array();
    }

    function addKodeInduk($data){
    	if($this->db->insert($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }

    function updateKodeInduk($where,$data){
        $this->db->where($where);
    	if($this->db->update($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }

    function deleteKodeInduk($where){
        if($this->db->delete($this->_table, $where) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
}