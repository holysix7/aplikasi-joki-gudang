<?php

Class Table_model extends CI_Model {

    protected $table = 'md_table';

    public function get_data(){
      return $this->db->get($this->table)->result_array();
    }
    public function generate_code(){
      $this->db->select('RIGHT(table_number,3) as kode', FALSE)
          ->order_by('table_number','DESC')
          ->limit(1);    
      
      $query = $this->db->get($this->table);  
      if($query->num_rows() <> 0){
        $data = $query->row();      
        $kode = intval($data->kode) + 1;    
      }else{
        $kode = 1;    
      }
    
      $kodemax = str_pad($kode, 3, "0", STR_PAD_LEFT);
      $code = $kodemax;
      return $code;
    }
    public function show($id){
      return $this->db->get_where($this->table, ["id" => $id])->row();
    }

    public function show_by_number($table_number){
      return $this->db->get_where($this->table, ["table_number" => $table_number]);
    }

    public function get_data_status(){
      return $this->db->get_where($this->table, ["table_status" => 'Tidak Diisi'])->result_array();
    }
    
    public function insert($data){
      return $this->db->insert($this->table, $data);
    }

    public function delete($id){
      $this->db->where('id', $id)
          ->delete($this->table);
    
      if($this->db->affected_rows() > 0){
        return true;
      }
      return false;
    }

    public function update($data, $id){
      $this->db->where('id', $id)
               ->update($this->table, $data);
      return true;
    }
    
    // public function update_banyak($data, $id){
    //   $this->db->update_batch($this->table, $data, $id);
    //   return true;
    // }
}