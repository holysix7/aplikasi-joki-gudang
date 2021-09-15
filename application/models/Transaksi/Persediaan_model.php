<?php

Class Persediaan_model extends CI_Model {

    protected $table = 'tr_persediaan';

    public function get_data(){
      return $this->db->get("$this->table a")->result_array();
    }

    public function get_data_by_date($start_date, $end_date){
      $this->db->where('purchase_date >=', $start_date);
      $this->db->where('purchase_date <=', $end_date);
      $this->db->order_by('a.id_persediaan ASC');
      return $this->db->get_where("$this->table a")->result_array();
    }

    public function show($id){		
      // var_dump($id); die;
		return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    public function join_persediaan(){
      $this->db->select('a.id_persediaan, a.kode_pembelian, c.nama_stok, a.jumlah, a.total_price, a.purchase_date, a.expired_date, a.status, a.id_supplier, b.supplier_name');
      $this->db->order_by('a.kode_pembelian', 'ASC');
      $this->db->join("md_supplier b", "a.id_supplier = b.id");
      $this->db->join("md_stok c", "a.id_stok = c.id");
      return $this->db->get("$this->table a")->result_array(); 
    }

    public function multiple_insert($data){
      return $this->db->insert_batch($this->table, $data);
    }

    public function generate_code(){
      $this->db->select('RIGHT(kode_pembelian,4) as kode', FALSE)
          ->order_by('kode_pembelian','DESC')
          ->limit(1);    
      
      $query = $this->db->get($this->table);  
      if($query->num_rows() <> 0){
        $data = $query->row();      
        $kode = intval($data->kode) + 1;    
      }else{
        $kode = 1;    
      }
    
      $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
      $code = "PMB-".$kodemax;
      return $code;
    }

    public function insert($data){
      return $this->db->insert($this->table, $data);
    }

    public function delete($id){
      $this->db->where('id_persediaan', $id)
          ->delete($this->table);
    
      if($this->db->affected_rows() > 0){
        return true;
      }
      return false;
    }

    public function update($data, $id){
      $this->db->where('id_persediaan', $id)
               ->update($this->table, $data);
      return true;
    }

}