<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_kredit extends CI_Model
{
    private $master_table = 'master_rekening_pembiayaan';
    private $master_anggota = 'anggota';
    private $detail_table = 'master_detail_rekening_pembiayaan';

    function getNominatifKredit(){
        $this->db->select('no_rekening_pembiayaan, anggota.no_anggota, anggota.nama, tgl_pembayaran, jumlah_pembiayaan, jangka_waktu_bulan, jml_pokok_bulanan, jml_bahas_bulanan, tgl_lunas, tgl_temp');
        $this->db->from($this->master_table);
        $this->db->join($this->master_anggota,'anggota.no_anggota = master_rekening_pembiayaan.no_anggota');
        return $this->db->get()->result();
    }

    function get1NominatifKredit($where){
        $this->db->select('no_rekening_pembiayaan, anggota.no_anggota, anggota.nama, tgl_pembayaran, jumlah_pembiayaan, jangka_waktu_bulan, jml_pokok_bulanan, jml_bahas_bulanan, tgl_lunas, tgl_temp');
        $this->db->from($this->master_table);
        $this->db->join($this->master_anggota,'anggota.no_anggota = master_rekening_pembiayaan.no_anggota');
        $this->db->where($where);
        return $this->db->get()->result();
    }

    function simpanKredit($data)
    {
        if ($this->db->insert($this->master_table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function updateKredit($where,$data){
        $this->db->where($where);
        if($this->db->update($this->master_table,$data)){
            return true;
        }else{
            return false;
        }
    }

    /////////////

    

    function simpanKelolaKredit($data)
    {
        if ($this->db->insert($this->detail_table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
