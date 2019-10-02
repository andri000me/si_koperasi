<?php 
defined("BASEPATH") or die("No Direct Access Allowed");
Class M_pelanggan extends CI_Model{
    private $_table = 'customer';
    function getCustomer(){
        return $this->db->get($this->_table)->result();
    }
    function addCustomer($data){
        if($this->db->insert($this->_table,$data) == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function countCustomerByWhere($where){
        return $this->db->get_where($this->_table,$where)->num_rows();
    }
    function get1Customer($where){
        return $this->db->get_where($this->_table,$where)->result();
    }
    function getCustomerWithKeyword($value){
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->like("nama_customer",$value);
        $this->db->or_like("no_hp",$value);
        return $this->db->get()->result();
    }
    function updateCustomer($where,$data){
        $this->db->where($where);
        if($this->db->update($this->_table,$data)==TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function deleteCustomer($where){
        $this->db->where($where);
        if($this->db->delete($this->_table)==TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}