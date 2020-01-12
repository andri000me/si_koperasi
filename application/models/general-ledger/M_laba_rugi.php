<?php
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_laba_rugi extends CI_Model{
    
    // get rekening kode induk != bank & bank
    function getAllRekening($tipe){
        if ($tipe == 'Pendapatan') {
            return $this->db->query("SELECT r.kode_rekening, r.nama, r.saldo_awal FROM ak_rekening r WHERE r.kode_rekening LIKE '02.1%' ")->result();
        }
        else if($tipe == 'Biaya'){
            return $this->db->query("SELECT r.kode_rekening, r.nama, r.saldo_awal FROM ak_rekening r WHERE r.kode_rekening LIKE '02.2%' ")->result();
        }
        else if($tipe == 'BiayaNonOperasional'){
            return $this->db->query("SELECT r.kode_rekening, r.nama, r.saldo_awal FROM ak_rekening r WHERE r.kode_rekening LIKE '02.300%' ")->result();
        }
        else if($tipe == 'PajakPenghasilan'){
            return $this->db->query("SELECT r.kode_rekening, r.nama, r.saldo_awal FROM ak_rekening r WHERE r.kode_rekening LIKE '02.320%' ")->result();
        }
    }
    
    // get saldo awal per rekening
    function getSaldoAwal($kode){
        return $this->db->query("SELECT saldo_awal FROM ak_rekening WHERE kode_rekening = '$kode' ")->result();
    }
    
    // cek field 
    function cekField($kode, $tgl_dari)
    {
        return $this->db->query("SELECT COUNT(kode) ttl FROM ak_jurnal WHERE kode = '$kode' AND tanggal BETWEEN '$tgl_dari 00:00:00' AND '$tgl_dari 23:59:59' ")->result();
    }
    
    function cekFieldByMonth($kode, $month, $year)
    {
        return $this->db->query("SELECT COUNT(kode) ttl FROM ak_jurnal WHERE kode = '$kode' AND MONTH(tanggal) = '$month' AND YEAR(tanggal) = '$year' ")->result();
    }

    // cek trx sebelumnya dari field kode
    function cekTrx($kode, $tgl_dari)
    {
        return $this->db->query("SELECT COUNT(kode) ttl FROM ak_jurnal WHERE kode = '$kode' AND tanggal < '$tgl_dari 00:00:00'")->result();
    }
    
    function cekTrxByMonth($kode, $month, $year)
    {
        return $this->db->query("SELECT COUNT(kode) ttl FROM ak_jurnal WHERE kode = '$kode' MONTH(tanggal) = '$month' AND YEAR(tanggal) = '$year'")->result();
    }
    
    // cek trx sebelumnya dari field lawan
    function cekLawanBefore($kode, $tgl_dari)
    {
        return $this->db->query("SELECT COUNT(lawan) ttl FROM ak_jurnal WHERE lawan = '$kode' AND tanggal < '$tgl_dari 00:00:00'")->result();
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
    function cekLawan($kode, $tgl_dari)
    {
        return $this->db->query("SELECT COUNT(lawan) ttl FROM ak_jurnal WHERE lawan = '$kode' AND tanggal BETWEEN '$tgl_dari 00:00:00' AND '$tgl_dari 23:59:59' ")->result();
    }
    
    // untuk menghitung total mutasi debet
    function sumMutasiDebet($kode, $tgl_dari)
    {
        return $this->db->query("SELECT SUM(nominal) ttl FROM ak_jurnal WHERE kode = '$kode' AND tanggal BETWEEN '$tgl_dari 00:00:00' AND '$tgl_dari 23:59:59' AND tipe = 'D'")->result();
    }
    
    // untuk menghitung total mutasi debet
    function sumMutasiKredit($kode, $tgl_dari)
    {
      return $this->db->query("SELECT SUM(nominal) ttl FROM ak_jurnal WHERE kode = '$kode' AND tanggal BETWEEN '$tgl_dari 00:00:00' AND '$tgl_dari 23:59:59'  AND tipe = 'K'")->result();
    }
    
    // untuk menghitung total mutasi debet dari field lawan
    function sumMutasiDebetByLawan($kode, $tgl_dari)
    {
      return $this->db->query("SELECT SUM(nominal) ttl FROM ak_jurnal WHERE lawan = '$kode' AND tanggal BETWEEN '$tgl_dari 00:00:00' AND '$tgl_dari 23:59:59' AND tipe = 'K'")->result();
    }
    
    // untuk menghitung total mutasi debet dari field lawan
    function sumMutasiKreditByLawan($kode, $tgl_dari)
    {
      return $this->db->query("SELECT SUM(nominal) ttl FROM ak_jurnal WHERE lawan = '$kode' AND tanggal BETWEEN '$tgl_dari 00:00:00' AND '$tgl_dari 23:59:59' AND tipe = 'D' ")->result();
    }
    
    // untuk cek tipe rekening
    function cekTipeRk($kode)
    {
      return $this->db->query("SELECT i.tipe FROM ak_kode_induk i JOIN ak_rekening r ON i.kode_induk = r.kode_induk AND r.kode_rekening = '$kode' ")->result();
    }
    
    // untuk menghitung total mutasi sebelum tgl dari
    function sumMutasiAwalDebet($kode, $tgl_dari)
    {
        return $this->db->query("SELECT SUM(nominal) ttl FROM ak_jurnal WHERE kode = '$kode' AND tanggal < '$tgl_dari 00:00:00' AND tipe = 'D'")->result();
    }
    
    function sumMutasiAwalKredit($kode, $tgl_dari)
    {
      return $this->db->query("SELECT SUM(nominal) ttl FROM ak_jurnal WHERE kode = '$kode' AND tanggal < '$tgl_dari 00:00:00' AND tipe = 'K'")->result();
    }
    
    // untuk menghitung total mutasi debet sebelum tgl dari by field lawan
    function sumMutasiAwalDebetByLawan($kode, $tgl_dari)
    {
        return $this->db->query("SELECT SUM(nominal) ttl FROM ak_jurnal WHERE lawan = '$kode' AND tanggal < '$tgl_dari 00:00:00' AND tipe = 'K'")->result();
    }
    
    // untuk menghitung total mutasi kredit sebelum tgl dari by field lawan
    function sumMutasiAwalKreditByLawan($kode, $tgl_dari)
    {
        return $this->db->query("SELECT SUM(nominal) ttl FROM ak_jurnal WHERE lawan = '$kode' AND tanggal < '$tgl_dari 00:00:00' AND tipe = 'D'")->result();
    }

  }