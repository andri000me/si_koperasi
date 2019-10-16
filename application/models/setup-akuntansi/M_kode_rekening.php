<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_kode_rekening extends CI_Model{
    private $_table = 'ak_rekening';

    function getAll(){
        $this->db->select('r.kode_rekening, r.nama, r.inisial, r.saldo_awal, i.nama nama_induk')
                 ->from('ak_rekening r')
                 ->join('ak_kode_induk i', 'i.kode_induk = r.kode_induk');
        
        return $this->db->get()->result();
    }

    function getOne($where){
        return $this->db->get_where($this->_table,$where)->result();
    }

    function countKodeRekening($kode, $newKode){
        // $kode_rek = explode('.', $kode);
        // $kode = $kode_rek[1];
        return $this->db->query("SELECT COUNT(kode_rekening) AS countKode FROM ak_rekening WHERE kode_rekening = '$newKode' AND kode_rekening != '$kode' ")->result_array();
    }

    function addKodeRekening($data){
    	if($this->db->insert($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }

    function updateKodeRekening($where,$data){
        $this->db->where($where);
    	if($this->db->update($this->_table,$data) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }

    function deleteKodeRekening($where){
        if($this->db->delete($this->_table, $where) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
}