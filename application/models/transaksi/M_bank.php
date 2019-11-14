<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_bank extends CI_Model{
    private $_table = 'ak_trx_bank';
    private $_tbdetail = 'ak_detail_trx_bank';

    // get all trx bank
    function getAll(){
        $this->db->order_by('kode_trx_bank', 'DESC');
        return $this->db->get($this->_table)->result();
    }
    
    // get rekening kode induk = bank
    function getRekening(){
        return $this->db->query("SELECT r.kode_rekening, r.nama FROM ak_rekening r JOIN ak_kode_induk i ON i.kode_induk = r.kode_induk WHERE i.nama = 'Bank'")->result();
    }
    
    // get rekening kode induk != bank & bank
    function getAllRekening(){
        return $this->db->query("SELECT r.kode_rekening, r.nama FROM ak_rekening r JOIN ak_kode_induk i ON i.kode_induk = r.kode_induk WHERE i.nama != 'Kas' AND i.nama != 'Bank' ")->result();
    }
    
    // get last nomor
    function getNomor($year, $month){
        return $this->db->query("SELECT MAX(nomor) + 1 as nomor FROM ak_trx_bank WHERE YEAR(tanggal) = '$year' AND MONTH(tanggal) = '$month' ")->result_array();
    }

    // insert data
    function insertData($tb, $data)
    {
        if ($this->db->insert($tb, $data) == TRUE) {
            return TRUE;
        }else{
    		return FALSE;
    	}
    }

    // get last id
    function getLastId()
    {
        return $this->db->query("SELECT id_detail_trx_bank AS lastId FROM ak_detail_trx_bank ORDER BY id_detail_trx_bank DESC LIMIT 1")->result_array();
    }

    function deleteBank($tb, $where){
        if($this->db->delete($tb, $where) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }
    
}