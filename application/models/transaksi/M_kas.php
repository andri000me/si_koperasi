<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_kas extends CI_Model{
    private $_table = 'ak_trx_kas';
    private $_tbdetail = 'ak_detail_trx_kas';

    // get all trx kas
    function getAll(){
        $this->db->order_by('kode_trx_kas', 'DESC');
        return $this->db->get($this->_table)->result();
    }
    
    // get rekening kode induk = kas
    function getRekening(){
        return $this->db->query("SELECT r.kode_rekening, r.nama FROM ak_rekening r JOIN ak_kode_induk i ON i.kode_induk = r.kode_induk WHERE i.nama = 'Kas'")->result();
    }
    
    // get 1 rekening
    function getOneRekening($kode){
        $this->db->select('kode_rekening, nama');
        $this->db->from('ak_rekening');
        $this->db->where('kode_rekening', $kode);
        return $this->db->get()->result();
    }
    
    // get rekening kode induk != kas & bank
    function getAllRekening(){
        return $this->db->query("SELECT r.kode_rekening, r.nama FROM ak_rekening r JOIN ak_kode_induk i ON i.kode_induk = r.kode_induk WHERE i.nama != 'Kas'AND i.nama != 'Bank' ")->result();
    }
    
    // get last nomor
    function getNomor($year, $month){
        return $this->db->query("SELECT MAX(nomor) + 1 as nomor FROM ak_trx_kas WHERE YEAR(tanggal) = '$year' AND MONTH(tanggal) = '$month' ")->result_array();
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
        return $this->db->query("SELECT id_detail_trx_kas AS lastId FROM ak_detail_trx_kas ORDER BY id_detail_trx_kas DESC LIMIT 1")->result_array();
    }

    function deleteKas($tb, $where){
        if($this->db->delete($tb, $where) == TRUE){
    		return TRUE;
    	}else{
    		return FALSE;
    	}
    }

    function laporanKas($kode, $dari, $sampai)
    {
        $this->db->select('d.kode_trx_kas, k.tanggal, k.kode_perkiraan, k.tipe, d.keterangan, d.lawan, d.nominal');
        $this->db->from('ak_trx_kas k');
        $this->db->join('ak_detail_trx_kas d', 'd.kode_trx_kas = k.kode_trx_kas');
        $this->db->where('k.kode_perkiraan', $kode);
        $this->db->where('tanggal >=', $dari);
        $this->db->where('tanggal <=', $sampai);
        return $this->db->get()->result();
    }
    
}