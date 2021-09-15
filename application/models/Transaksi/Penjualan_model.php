<?php

Class Penjualan_model extends CI_Model {

    protected $table = 'tr_penjualan';

    public function get_data(){
      return $this->db->get("$this->table a")->result_array();
    }

    public function get_data_by_date($start_date, $end_date){
      $this->db->where('YEAR(tanggal_penjualan) >=', date("Y", strtotime($start_date)));
      $this->db->where('MONTH(tanggal_penjualan) >=', date("m", strtotime($start_date)));
      $this->db->where('DAY(tanggal_penjualan) >=', date("d", strtotime($start_date)));
      $this->db->where('YEAR(tanggal_penjualan) <=', date("Y", strtotime($end_date)));
      $this->db->where('MONTH(tanggal_penjualan) <=', date("m", strtotime($end_date)));
      $this->db->where('DAY(tanggal_penjualan) <=', date("d", strtotime($end_date)));
      $this->db->order_by('a.kode_penjualan ASC');
      return $this->db->get("$this->table a")->result_array();
    }
    public function get_user_id($value){
        return $this->db->get_where($this->table, ['id_pelanggan' => $value, 'status_penjualan' => 'Show'])->row();
    }

    public function get_data_join(){
      $this->db->join("md_pelanggan b", "b.id = a.id_pelanggan");
      $this->db->join("md_table c", "c.id = a.id_meja");
      $this->db->order_by("a.kode_penjualan ASC");
      return $this->db->get("$this->table a")->result_array();
    }

    public function get_penjualan_item($id){
      $this->db->join("md_menu e", "e.id = d.id_menu");
      // $this->db->join("md_kuah f", "f.id = d.id_kuah");
      // $this->db->join("md_lv_pedas g", "g.id = d.id_pedas");
      return $this->db->get_where("item d", ['id_penjualan' => $id])->result_array();
    }

    public function insert_item($data){
      return $this->db->insert("item", $data);
    }	
    
    public function generate_code(){
      $this->db->select('RIGHT(kode_penjualan,4) as kode', FALSE)
          ->order_by('kode_penjualan','DESC')
          ->limit(1);    
      
      $query = $this->db->get($this->table);  
      if($query->num_rows() <> 0){
        $data = $query->row();      
        $kode = intval($data->kode) + 1;    
      }else{
        $kode = 1;    
      }
    
      $kodemax = str_pad($kode, 4, "0", STR_PAD_LEFT);
      $code = "PNJ-".$kodemax;
      return $code;
    }


    public function get_item(){
      return $this->db->get("item")->result_array();
    }

    public function multiple_insert($data){
      return $this->db->insert_batch('item', $data);
    }
    
    public function show($id){		
  		return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_meja($id){		
  		return $this->db->get_where($this->table, ['id_meja' => $id])->result_array();
    }

    public function insert($data){
      $this->db->insert($this->table, $data);
      $idPenjualan = $this->db->insert_id();
      return $idPenjualan;
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
      $this->db->where('id_meja', $id)
               ->update($this->table, $data);
      return true;
    }

    // public function update_banyak($data, $id_meja){
      // var_dump($data); die;
    //   $this->db->update_batch($this->table, $data, $id_meja);
    //   return true;
    // }

}