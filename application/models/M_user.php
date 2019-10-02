<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_user extends CI_Model{
    private $_table = 'user';
    function getUser(){
        return $this->db->get($this->_table)->result();
    }
    function get1User($where){
        return $this->db->get_where($this->_table,$where)->result();
    }
    function countUser($where){
        return $this->db->get_where($this->_table,$where)->num_rows();
    }
    function addUser($data){
    	if($this->db->insert($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
    function updateUser($where,$data){
        $this->db->where($where);
    	if($this->db->update($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
    function deleteUser($where){
        $this->db->where($where);
        if($this->db->delete($this->_table) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
}