<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_kelola_kredit extends CI_Model
{
    private $_table = 'master_rekening_pembiayaan';

    function getKelolakredit()
    {
        return $this->db->query('select * from master_rekening_pembiayan')->result();
    }

    // function get1Anggota($where)
    // {
    //     return $this->db->get_where($this->_table, $where)->result();
    // }

    // function addSimpananpokok($data)
    // {
    //     if ($this->db->insert($this->_table, $data) == TRUE) {
    //         return TRUE;
    //     } else {
    //         return FALSE;
    //     }
    // }

    // function hapus_data($where, $table)
    // {
    //     $this->db->where($where);
    //     $this->db->delete($table);
    // }

    // function updateAnggota($where, $data)
    // {
    //     $this->db->where($where);
    //     if ($this->db->update($this->_table, $data) == TRUE) {
    //         return TRUE;
    //     } else {
    //         return FALSE;
    //     }
    // }
}
