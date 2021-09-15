<?php

Class Jurnal_model extends CI_Model {

    protected $table = 'tr_jurnal';

    public function get_data(){
      $this->db->order_by('a.id ASC');
      $this->db->join("md_coa b", "b.id = a.id_akun");
      return $this->db->get("$this->table a")->result_array();
    }

    public function get_data_kas(){
      $this->db->order_by('a.id ASC');
      $this->db->join("md_coa b", "b.id = a.id_akun");
      return $this->db->get_where("$this->table a", ['id_akun' => 1])->result_array();
    }

    public function get_data_by_date($start_date, $end_date, $type){
      // var_dump($type); die;
      $this->db->where('tanggal_jurnal >=', $start_date);
      $this->db->where('tanggal_jurnal <=', $end_date);
      $this->db->order_by('a.id ASC');
      $this->db->join("md_coa b", "b.id = a.id_akun");
      if($type != 'jurnal'){
        return $this->db->get_where("$this->table a", ['id_akun' => $type])->result_array();
      }else{
        return $this->db->get_where("$this->table a")->result_array();
      }
    }

    public function get_data_buku_penjualan(){
      $this->db->order_by('a.id ASC');
      $this->db->join("md_coa b", "b.id = a.id_akun");
      return $this->db->get_where("$this->table a", ['id_akun' => 3])->result_array();
    }

    public function get_data_buku_persediaan(){
      $this->db->order_by('a.id ASC');
      $this->db->join("md_coa b", "b.id = a.id_akun");
      return $this->db->get_where("$this->table a", ['id_akun' => 2])->result_array();
    }

    public function get_data_buku_pokok_penjualan(){
      $this->db->order_by('a.id ASC');
      $this->db->join("md_coa b", "b.id = a.id_akun");
      return $this->db->get_where("$this->table a", ['id_akun' => 4])->result_array();
    }

    public function get_data_persediaan($id){
      $this->db->order_by('a.id ASC');
      $this->db->join("md_coa b", "b.id = a.id_akun");
      $this->db->join("tr_persediaan c", "c.id_persediaan = a.id_persediaan");
      return $this->db->get("$this->table a", ['id' => $id])->result_array();
    }

    public function get_data_penjualan($id){
      $this->db->order_by('a.id ASC');
      $this->db->join("md_coa b", "b.id = a.id_akun");
      $this->db->join("tr_penjualan c", "c.id_penjualan = a.id_penjualan");
      return $this->db->get("$this->table a", ['id' => $id])->result_array();
    }
    
    public function multiple_insert($data){
      return $this->db->insert_batch($this->table, $data);
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

}