<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_simpanan_pokok extends CI_Model
{
    private $_table = 'master_simpanan_pokok';

    function getSimpananpokok()
    {
        return $this->db->query('select * from anggota inner join master_simpanan_pokok on master_simpanan_pokok.no_anggota=anggota.no_anggota')->result();
    }
    function addSimpananpokok($data)
    {
        if ($this->db->insert($this->_table, $data) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
