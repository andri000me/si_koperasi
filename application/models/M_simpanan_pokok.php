<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_simpanan_pokok extends CI_Model
{
    private $_table = 'master_simpanan_pokok';

    function getSimpananpokok()
    {
        return $this->db->query('select * from anggota inner join master_simpanan_pokok on master_simpanan_pokok.no_anggota=anggota.no_anggota join user on master_simpanan_pokok.id_user = user.id_user')->result();
    }

    function get1Anggota($where)
    {
        return $this->db->get_where($this->_table, $where)->result();
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
}
