<?php

class Meja extends CI_Controller
{
  function __construct(){
      parent::__construct();
      $this->load->model('Auth/Auth_model', 'm_auth');
      $this->load->model('MasterData/Supplier_model', 'm_supplier');
      $this->load->model('MasterData/Customer_model', 'm_customer');
      $this->load->model('MasterData/Karyawan_model', 'm_karyawan');
      $this->load->model('MasterData/Stok_model', 'm_gudang');
      $this->load->model('MasterData/Table_model', 'm_meja');
      if($this->session->userdata('login') != true){
          redirect('');
      }
  }
  
  //meja
  public function index(){
      $name   = $this->session->userdata('name');
      $role   = $this->session->userdata('role');
      $meja   = $this->m_meja->get_data();
      $generate   = $this->m_meja->generate_code();
      $this->load->view('Template/Header');
      $this->load->view('Admin/MasterData/tables', compact('name', 'meja', 'role', 'generate'));
  }

  public function createMeja(){
      $table_number = $this->input->post('table_number');
      $table_type   = $this->input->post('table_type');
      $table_status = $this->input->post('table_status');
      $data = [
          'table_number'  => $table_number,
          'table_type'    => $table_type,
          'table_status'  => $table_status
      ];
      if($this->m_meja->insert($data)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
      }
      redirect('admin/tables');
  }

  public function editMeja(){
      $data = $this->input->post();
      $id   = $data['id'];
      $id   = $this->input->post('id');
      if($this->m_meja->update($data, $id)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
      }
      redirect('admin/tables');
  }

  public function hapusMeja($id){
    if($this->m_meja->delete($id)){
        $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
    }else{
        $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
    }
    redirect('admin/tables');
  }
}