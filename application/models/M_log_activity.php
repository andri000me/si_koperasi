<?php
defined("BASEPATH") or die("No Direct Access Allowed");

Class M_log_activity extends CI_Model{
    
    function getAll(){
      $this->db->select('l.datetime, l.keterangan, u.nama_terang');
      $this->db->from('log_activity l'); 
      $this->db->join('user u', 'u.id_user = l.id_user');
      $this->db->order_by('l.datetime','desc');         
      $query = $this->db->get(); 
      return $query->result();
    }

    function getByDate($date){
      $this->db->select('l.datetime, l.keterangan, u.nama_terang');
      $this->db->from('log_activity l'); 
      $this->db->join('user u', 'u.id_user = l.id_user');
      $this->db->where('datetime >=', "$date 00:00:00");
      $this->db->where('datetime <=', "$date 23:59:59");
      $this->db->order_by('l.datetime','desc');         
      $query = $this->db->get(); 
      return $query->result();
    }
    
    function getByUser($user){
      $this->db->select('l.datetime, l.keterangan, u.nama_terang');
      $this->db->from('log_activity l'); 
      $this->db->join('user u', 'u.id_user = l.id_user');
      $this->db->where('id_user', $user);
      $this->db->order_by('l.datetime','desc');         
      $query = $this->db->get(); 
      return $query->result();
    }
    
    function getByDateAndUser($date, $user){
      $this->db->select('l.datetime, l.keterangan, u.nama_terang');
      $this->db->from('log_activity l'); 
      $this->db->join('user u', 'u.id_user = l.id_user');
      $this->db->where('datetime >=', "$date 00:00:00");
      $this->db->where('datetime <=', "$date 23:59:59");
      $this->db->where('id_user', $user);
      $this->db->order_by('l.datetime','desc');         
      $query = $this->db->get(); 
      return $query->result();
    }
}