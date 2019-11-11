<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_kredit extends CI_Model
{
    private $master_table = 'master_rekening_pembiayaan';
    function simpanKredit($data)
    {
        if ($this->db->insert($this->master_table, $data)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
