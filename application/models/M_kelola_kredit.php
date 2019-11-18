<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_kelola_kredit extends CI_Model
{
    private $_table = 'master_rekening_pembiayaan';
    private $detail_table = 'master_detail_rekening_pembiayaan';

    function getKelolakredit()
    {
        return $this->db->query('select * from master_detail_rekening_pembiayaan')->result();
    }

    function get1noKelolaKredit($where)
    {
        return $this->db->get_where($this->_table, $where)->result();
    }

    function simpanKelolaKredit($data)
    {
        if ($this->db->insert($this->detail_table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

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
