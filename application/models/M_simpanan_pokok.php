<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_simpanan_pokok extends CI_Model
{
    private $_table = 'master_simpanan_pokok';
    private $_table_anggota = 'anggota';
    private $_table_user = 'user';

    function getSimpananpokok(){
        $this->db->select('master_simpanan_pokok.id_simpanan_pokok, master_simpanan_pokok.no_anggota, anggota.nama, master_simpanan_pokok.tanggal_pembayaran, master_simpanan_pokok.jumlah, master_simpanan_pokok.id_user, user.nama_terang');
        $this->db->from($this->_table);
        $this->db->join($this->_table_anggota, 'master_simpanan_pokok.no_anggota=anggota.no_anggota');
        $this->db->join($this->_table_user, 'master_simpanan_pokok.id_user = user.id_user');
        return $this->db->get();
    }

    function get1SimpananPokok($id){
        $this->db->select('master_simpanan_pokok.id_simpanan_pokok, master_simpanan_pokok.no_anggota, anggota.nama, master_simpanan_pokok.tanggal_pembayaran, master_simpanan_pokok.jumlah, master_simpanan_pokok.id_user, user.nama_terang');
        $this->db->from($this->_table);
        $this->db->join($this->_table_anggota, 'master_simpanan_pokok.no_anggota=anggota.no_anggota');
        $this->db->join($this->_table_user, 'master_simpanan_pokok.id_user = user.id_user');
        $this->db->where(array('master_simpanan_pokok.no_anggota' => $id));
        return $this->db->get();
    }

    function addSimpananpokok($data)
    {
        if ($this->db->insert($this->_table, $data) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function hapus_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    function updateAnggota($where, $data)
    {
        $this->db->where($where);
        if ($this->db->update($this->_table, $data) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
