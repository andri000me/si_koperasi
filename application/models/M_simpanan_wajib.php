<?php
defined("BASEPATH") or die("No Direct Access Allowed");
class M_simpanan_wajib extends CI_Model
{
    private $_table = 'master_simpanan_wajib';
    private $_v_table = 'v_simpanan_wajib';
    private $_table_user = 'user';

    function getNominatif(){
        return $this->db->get($this->_v_table)->result();
    }
    function get1Nominatif($no_anggota){
        $where = array( 'no_anggota' => $no_anggota);
        return $this->db->get_where($this->_v_table,$where)->result();
    }

    function getSaldoPerAnggota($no_anggota){
        $where = array( 'no_anggota' => $no_anggota);
        $this->db->select('saldo');
        return $this->db->get_where($this->_v_table,$where)->result();
    }
    
    function getSimpananPerAnggota($no_anggota){
        $where = array(
            'no_anggota' => $no_anggota
        );
        $this->db->select('id_simpanan_wajib,tgl_temp,tgl_pembayaran,debet,kredit,saldo,nama_terang');
        $this->db->from($this->_table);
        $this->db->join($this->_table_user,'master_simpanan_wajib.id_user = user.id_user');
        $this->db->where($where);
        $this->db->order_by('id_simpanan_wajib','DESC');
        return $this->db->get()->result();
    }
    
    function countSimpananPerAnggota($no_anggota){
        $where = array(
            'no_anggota' => $no_anggota
        );
        $this->db->where($where);
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    function getTglTempRecordTerakhir($no_anggota){
        $where = array(
            'no_anggota' => $no_anggota
        );
        $this->db->select('tgl_temp');
        $this->db->from($this->_table);
        $this->db->where($where);
        $this->db->order_by('id_simpanan_wajib','DESC');
        $this->db->limit(1);
        $data = $this->db->get()->result();
        foreach($data as $i){
            return $i->tgl_temp;
        }
        
    }

    function addSimpananwajib($data)
    {
        if ($this->db->insert($this->_table, $data) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    // function getSimpananpokok()
    // {
    //     return $this->db->query('select * from anggota inner join master_simpanan_wajib on master_simpanan_wajib.no_anggota=anggota.no_anggota join user on master_simpanan_wajib.id_user = user.id_user')->result();
    // }

    // function get1Anggota($where)
    // {
    //     return $this->db->get_where($this->_table, $where)->result();
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
