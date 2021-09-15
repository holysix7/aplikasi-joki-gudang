<?php

Class Akun_model extends CI_Model {

    protected $table = 'md_coa';

    public function get_data(){
      return $this->db->get($this->table)->result_array();
    }

    public function get_kode_akun(){
      $this->db->select('kode_akun');
      return $this->db->get($this->table)->result_array();
    }
    
    public function validation_kode_akun($kode_akun){
      return $this->db->get_where($this->table, ['kode_akun' => $kode_akun]);
    }
    
    public function validation_nama_akun($nama_akun){
      return $this->db->get_where($this->table, ['nama_akun' => $nama_akun]);
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