<?php

Class Supplier_model extends CI_Model {

    protected $table = 'md_supplier';

    public function get_data(){
      return $this->db->get($this->table)->result_array();
    }

    public function join_persediaan(){
      $this->db->join("tr_persediaan b", "a.id = b.id_supplier");
      $this->db->join("md_stok c", "b.id_stok = c.id");
      return $this->db->get("$this->table a")->result_array(); 
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