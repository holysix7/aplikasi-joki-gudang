<?php

Class Customer_model extends CI_Model {

    protected $table = 'md_pelanggan';

    public function get_data(){
        return $this->db->get($this->table)->result_array();
    }

    public function get_data_status(){
        return $this->db->get_where($this->table, ['customer_status' => 'Belum Makan'])->result_array();
    }

    public function get_by_name($value){
        return $this->db->get_where($this->table, ['customer_name' => $value])->num_rows();
    }

    public function show_cust_data($value){
        return $this->db->get_where($this->table, ['customer_name' => $value])->row();
    }

    public function get_by_phone($value){
        return $this->db->get_where($this->table, ['customer_phone' => $value]);
    }

    public function show($id){		
		return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    public function insert($data){
        return $this->db->insert($this->table, $data);
    }
    
    public function insert_array($data){
        return $this->db->insert_batch($this->table, $data);
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