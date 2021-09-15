<?php

Class Saldo_model extends CI_Model {

    protected $table = 'kas';

    public function get_data(){
      return $this->db->get("$this->table a")->row();
    }
    
    public function update($data, $id){
      $this->db->where('id', $id)
               ->update($this->table, $data);
      return true;
    }
}