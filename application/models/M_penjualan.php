<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_penjualan extends CI_Model
{
    private $_table = 'penjualan';
    private $_detail_table = 'detail_penjualan';
    private $_v_table = 'v_penjualan';
    private $_v_detail_table = 'v_detail_penjualan';
    function getPenjualan()
    {
        return $this->db->query("SELECT * FROM $this->_v_table ORDER BY id_penjualan DESC")->result();
    }
    function get1Penjualan($where)
    {
        return $this->db->get_where($this->_v_table, $where)->result();
    }
    function getDetailPenjualan($where)
    {
        return $this->db->get_where($this->_v_detail_table, $where)->result();
    }
    function insertPenjualan($data)
    {
        $this->db->insert($this->_table, $data);
    }
    function insertDetailPenjualan($data)
    {
        $this->db->insert($this->_detail_table, $data);
    }
    function getTotalHarian()
    {
        $total_hari_ini = 0;
        $tgl_hari_ini = date("Y-m-d");
        $query = $this->db->query("SELECT getTotalHarian('$tgl_hari_ini') AS total_hari_ini")->result();
        foreach ($query as $q) {
            $total_hari_ini = $q->total_hari_ini;
        }
        return number_format($total_hari_ini, 2, ',', '.');
    }
    function getTotalBulanan()
    {
        $total_bulan_ini = 0;
        $bulan_ini = date("m");
        $tahun_ini = date("Y");
        $query = $this->db->query("SELECT getTotalBulanan('$bulan_ini','$tahun_ini') AS total_bulan_ini")->result();
        foreach ($query as $q) {
            $total_bulan_ini = $q->total_bulan_ini;
        }
        return number_format($total_bulan_ini, 2, ',', '.');
    }
    function getTotalTahunan()
    {
        $total_tahun_ini = 0;
        $tahun_ini = date("Y");
        $query = $this->db->query("SELECT getTotalTahunan('$tahun_ini') AS total_tahun_ini")->result();
        foreach ($query as $q) {
            $total_tahun_ini = $q->total_tahun_ini;
        }
        return number_format($total_tahun_ini, 2, ',', '.');
    }
    function getRekapHarian()
    {
        $data = array();
        for ($i = 1; $i <= date('t'); $i++) {
            $tgl = date('Y-m-').$i;
            $query = $this->db->query("SELECT getTotalHarian('$tgl') AS total_harian")->result();
            foreach ($query as $q) {
                $total_harian = $q->total_harian;
                if($total_harian == NULL|| $total_harian == 0){
                    array_push($data, 0);
                } else {
                    array_push($data, $total_harian);
                }
            }
        }
        return $data;
    }
    function getRekapBulanan()
    {
        $tahun_ini = date("Y");
        $data = array();
        for ($i = 1; $i <= 12; $i++) { //Loop Bulan 1 Sampai Bulan 12
            $query = $this->db->query("SELECT getTotalBulanan('$i','$tahun_ini') AS total_bulanan")->result();
            foreach ($query as $q) {
                $pemasukan_bulanan = $q->total_bulanan;
                if ($pemasukan_bulanan == NULL || $pemasukan_bulanan == 0) {
                    array_push($data, 0);
                } else {
                    array_push($data, $pemasukan_bulanan);
                }
            }
        }
        return $data;
        //Hasil Array Push Adalah index = bulan -1, contoh Januari memiliki index 0
    }
}
