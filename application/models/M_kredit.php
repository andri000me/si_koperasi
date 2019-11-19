<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_kredit extends CI_Model
{
    private $master_table = 'master_rekening_pembiayaan';
    private $detail_table = 'master_detail_rekening_pembiayaan';

    function simpanKredit($data)
    {
        if ($this->db->insert($this->master_table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getKelolakredit()
    {
        return $this->db->query('select * from master_detail_rekening_pembiayaan')->result();
    }

    function get1noKelolaKredit($where)
    {
        return $this->db->get_where($this->master_table, $where)->result();
    }

    function simpanKelolaKredit($data)
    {
        if ($this->db->insert($this->detail_table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
