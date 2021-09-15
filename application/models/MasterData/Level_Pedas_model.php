<?php

Class Level_Pedas_model extends CI_Model {

    protected $table = 'md_lv_pedas';

    public function get_data(){
      return $this->db->get($this->table)->result_array();
    }

    public function show($id){		
		return $this->db->get_where($this->table, ['id' => $id])->row();
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
}