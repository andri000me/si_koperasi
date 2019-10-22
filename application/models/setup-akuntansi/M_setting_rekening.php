<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_setting_rekening extends CI_Model{
    // private $_tb_rekening = 'ak_rekening';
    private $_table = 'ak_set_rekening';
    function getAll(){
        return $this->db->get($this->_table)->result();
    }

    function getOne($where){
        return $this->db->get_where($this->_table,$where)->result();
    }

    // function countKodeRekening($kode, $newKode){
    //     // $kode_rek = explode('.', $kode);
    //     // $kode = $kode_rek[1];
    //     return $this->db->query("SELECT COUNT(kode_rekening) AS countKode FROM ak_rekening WHERE kode_rekening = '$newKode' AND kode_rekening != '$kode' ")->result_array();
    // }

    function addSettingRekening($data){
    	if($this->db->insert($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }

    function updateSettingRekening($where,$data){
        $this->db->where($where);
    	if($this->db->update($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }

    function deleteSettingRekening($where){
        if($this->db->delete($this->_table, $where) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
}