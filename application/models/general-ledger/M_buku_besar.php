<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_buku_besar extends CI_Model{

    // get all trx bank
    function getAll(){
        $this->db->order_by('kode_trx_bank', 'DESC');
        return $this->db->get($this->_table)->result();
    }
    
    // get rekening kode induk != bank & bank
    function getAllRekening(){
        return $this->db->query("SELECT r.kode_rekening, r.nama FROM ak_rekening r")->result();
    }
    
    // get kode, nama (satu rekening)
    function getOneRekening($kode){
        return $this->db->query("SELECT kode_rekening, nama FROM ak_rekening WHERE kode_rekening = '$kode' ")->result();
    }
    
    // get saldo awal per rekening
    function getSaldoAwal($kode){
        return $this->db->query("SELECT saldo_awal FROM ak_rekening WHERE kode_rekening = '$kode' ")->result();
    }
    
    // get kode, nama (beberapa rekening)
    function getSomeRekening($kode, $rk_sampai){
        return $this->db->query("SELECT kode_rekening, nama FROM ak_rekening WHERE kode_rekening BETWEEN '$kode' AND '$rk_sampai'")->result();
    }
    
    // cek transaksi sebelumnya dari tb_jurnal
    function cekTransaksi($kode, $tgl)
    {
        return $this->db->query("SELECT COUNT(id_jurnal) jml_transaksi FROM ak_jurnal WHERE tanggal < '$tgl 00:00:00' AND kode = '$kode' OR tanggal < '$tgl 00:00:00' AND lawan = '$kode' ")->result();
    }

    // untuk cek kode rk tsb apakah terdapat di field kode di tb jurnal
    function getField($kode, $tgl)
    {
        return $this->db->query("SELECT COUNT(id_jurnal) jml FROM ak_jurnal WHERE kode = '$kode' AND tanggal < '$tgl 00:00:00' ")->result();
    }
    
    // untuk cek kode rk tsb apakah terdapat di field lawan di tb jurnal
    function cekLawan($kode, $tgl)
    {
        return $this->db->query("SELECT COUNT(id_jurnal) jml FROM ak_jurnal WHERE lawan = '$kode' AND tanggal < '$tgl 00:00:00' ")->result();
    }
    
    // untuk menghitung total nominal debet per kode_rekening
    function getSaldoDebet($kode, $tgl)
    {
        return $this->db->query("SELECT SUM(nominal) saldo FROM ak_jurnal WHERE kode = '$kode' AND tipe = 'D' AND tanggal < '$tgl 00:00:00' ")->result();
    }
    
    // untuk menghitung total nominal debet per kode_rekening ketika kode tsb terdapat di field lawan
    function getSaldoDebet2($kode, $tgl)
    {
        return $this->db->query("SELECT SUM(nominal) saldo FROM ak_jurnal WHERE lawan = '$kode' AND tipe = 'K' AND tanggal < '$tgl 00:00:00' ")->result();
    }
    
    // untuk menghitung total nominal kredit per kode_rekening
    function getSaldoKredit($kode, $tgl)
    {
        return $this->db->query("SELECT SUM(nominal) saldo FROM ak_jurnal WHERE kode = '$kode' AND tipe = 'K' AND tanggal < '$tgl 00:00:00' ")->result();
    }
    
    // untuk menghitung total nominal kredit per kode_rekening ketika kode tsb terdapat di field lawan
    function getSaldoKredit2($kode, $tgl)
    {
        return $this->db->query("SELECT SUM(nominal) saldo FROM ak_jurnal WHERE lawan = '$kode' AND tipe = 'D' AND tanggal < '$tgl 00:00:00' ")->result();
    }

    // untuk cek tipe rekening
    function cekTipeRk($kode)
    {
        return $this->db->query("SELECT i.tipe FROM ak_kode_induk i JOIN ak_rekening r ON i.kode_induk = r.kode_induk AND r.kode_rekening = '$kode' ")->result();
    }

    function getBukuBesar($kode, $tgl_dari, $tgl_sampai)
    {
        return $this->db->query("SELECT id_jurnal, tanggal, kode_transaksi, keterangan, kode, lawan, tipe, nominal, SUM(nominal) nominal FROM ak_jurnal WHERE tanggal BETWEEN '$tgl_dari 00:00:00' AND '$tgl_sampai 23:59:59' AND kode = '$kode' OR tanggal BETWEEN '$tgl_dari 00:00:00' AND '$tgl_sampai 23:59:59' AND lawan = '$kode' GROUP BY kode_transaksi, MONTH(tanggal), keterangan ORDER BY tanggal ASC ")->result();
    }
    
}