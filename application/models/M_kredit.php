<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_kredit extends CI_Model
{
    private $master_table = 'master_rekening_pembiayaan';
    private $master_anggota = 'anggota';
    private $detail_table = 'master_detail_rekening_pembiayaan';
    private $user_table = 'user';

    ///////////Master Table
    //Menampilkan Seluruh Data dari Tabel master_rekening_pembiayaan
    function getNominatifKredit(){
        $this->db->select('no_rekening_pembiayaan, anggota.no_anggota, anggota.nama, tgl_pembayaran, jumlah_pembiayaan, jangka_waktu_bulan, jml_pokok_bulanan, jml_bahas_bulanan, tgl_lunas, tgl_temp, cicilan_terbayar');
        $this->db->from($this->master_table);
        $this->db->join($this->master_anggota,'anggota.no_anggota = master_rekening_pembiayaan.no_anggota');
        return $this->db->get();
    }

    //Menampilkan 1 Data dari Tabel master_rekening_pembiayaan
    function get1NominatifKredit($where){
        $this->db->select('no_rekening_pembiayaan, anggota.no_anggota, anggota.nama, tgl_pembayaran, jumlah_pembiayaan, jangka_waktu_bulan, jml_pokok_bulanan, jml_bahas_bulanan, tgl_lunas, tgl_temp, cicilan_terbayar');
        $this->db->from($this->master_table);
        $this->db->join($this->master_anggota,'anggota.no_anggota = master_rekening_pembiayaan.no_anggota');
        $this->db->where($where);
        return $this->db->get();
    }

    //Menyimpan Data Ke Tabel master_rekening_pembiayaan
    function simpanKredit($data){
        if ($this->db->insert($this->master_table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Mengupdate Data ke Tabel master_rekening_pembiayaan
    function updateKredit($where,$data){
        $this->db->where($where);
        if($this->db->update($this->master_table,$data)){
            return true;
        }else{
            return false;
        }
    }

    //////////Detail Table
    //Menampilkan Record dari Tabel master_detail_rekening_pembiayaan berdasarkan No Rekening Pembiayaan
    function getNominatifDetailKredit($id){
        $this->db->select("tanggal_pembayaran,periode_tagihan,jml_pokok,jml_bahas,denda,total, user.id_user, nama_terang");
        $this->db->from($this->detail_table);
        $this->db->join($this->user_table,'user.id_user = master_detail_rekening_pembiayaan.id_user', 'left');
        $this->db->where(array('no_rekening_pembiayaan' => $id));
        return $this->db->get();
    }

    //Menyimpan Data Ke Tabel master_detail_rekening_pembiayaan    
    function simpanKelolaKredit($data){
        if ($this->db->insert($this->detail_table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
