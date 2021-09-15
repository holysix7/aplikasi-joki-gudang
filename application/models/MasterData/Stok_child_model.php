<?php

Class Stok_child_model extends CI_Model {

    protected $table = 'md_stok_item';

    public function get_data($id){
      $this->db->join("md_stok b", "b.id = a.id_stok");
      $this->db->join("tr_persediaan c", "c.id_persediaan = a.id_persediaan");
      return $this->db->get_where("$this->table a", ['a.id_stok' => $id])->result_array();
    }

    public function get_data_order($id){
      $this->db->select("a.id, b.id as id_stok, a.id_persediaan, c.expired_date, c.jumlah as jumlah_order, b.jumlah_stok as total_stok, b.unit_price, c.kode_pembelian, a.sisa_stok");
      $this->db->join("md_stok b", "b.id = a.id_stok");
      $this->db->join("tr_persediaan c", "c.id_persediaan = a.id_persediaan");
      $this->db->order_by("c.expired_date", "ASC");
      return $this->db->get_where("$this->table a", ['a.id_stok' => $id])->row();
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