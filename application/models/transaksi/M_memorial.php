<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_memorial extends CI_Model{
    private $_table = 'ak_trx_memorial';
    private $_tbdetail = 'ak_detail_trx_memorial';

    // get all trx memorial
    function getAll(){
        $this->db->order_by('kode_trx_memorial', 'DESC');
        return $this->db->get($this->_table)->result();
    }
    
    // get rekening kode induk = memorial
    // function getRekening(){
    //     return $this->db->query("SELECT r.kode_rekening, r.nama FROM ak_rekening r JOIN ak_kode_induk i ON i.kode_induk = r.kode_induk WHERE i.nama = 'Bank'")->result();
    // }
    
    // get rekening kode induk != memorial & memorial
    function getAllRekening(){
        return $this->db->query("SELECT r.kode_rekening, r.nama FROM ak_rekening r JOIN ak_kode_induk i ON i.kode_induk = r.kode_induk WHERE i.nama != 'Kas' AND i.nama != 'Bank' ")->result();
    }
    
    // get last nomor
    function getNomor($year, $month){
        return $this->db->query("SELECT MAX(nomor) + 1 as nomor FROM ak_trx_memorial WHERE YEAR(tanggal) = '$year' AND MONTH(tanggal) = '$month' ")->result_array();
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
        return $this->db->query("SELECT id_detail_trx_memorial AS lastId FROM ak_detail_trx_memorial ORDER BY id_detail_trx_memorial DESC LIMIT 1")->result_array();
    }

    function deleteMemorial($tb, $where){
        if($this->db->delete($tb, $where) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }

    public function getMemorial($kode)
    {
        $this->db->select('*');
        $this->db->from('ak_trx_memorial');
        $this->db->where('kode_trx_memorial', $kode);
        return $this->db->get()->result();
    }
    
    public function getDetailMemorial($kode)
    {
        $this->db->select('*');
        $this->db->from('ak_detail_trx_memorial');
        $this->db->where('kode_trx_memorial', $kode);
        return $this->db->get()->result();
    }

    public function updateData($tb,$values,$where)
    {
        $this->db->update($tb,$values,$where);
    }
    
}