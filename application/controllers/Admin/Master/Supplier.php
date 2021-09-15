<?php

class Supplier extends CI_Controller
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
  //supplier
  public function index(){
      $name       = $this->session->userdata('name');
      $role       = $this->session->userdata('role');
      $suppliers  = $this->m_supplier->get_data();
      $this->load->view('Template/Header');
      $this->load->view('Admin/MasterData/supplier', compact('name', 'role', 'suppliers'));
  }

  public function createSupplier(){
      $data = [
          'supplier_name' => $this->input->post('supplier_name'),
          'address'       => $this->input->post('address'),
          'phone'         => $this->input->post('phone')
      ];
      $this->form_validation->set_data($this->input->post());
      $this->form_validation->set_rules('supplier_name', 'Nama Supplier', 'Required');
      $this->form_validation->set_rules('address', 'Alamat Supplier', 'Required');
      $this->form_validation->set_rules('phone', 'Nomor Telepon Supplier', 'Required');
      if($this->form_validation->run() == TRUE)
      {
          if($this->m_supplier->insert($data)){
              $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
          }else{
              $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
          }
      }else{
          $this->session->set_flashdata('alert_message', show_alert(validation_errors(),'warning'));
      }
      redirect('admin/supplier');
  }

  public function editSupplier(){
      $data = $this->input->post();
      $id   = $data['id'];
      if($this->m_supplier->update($data, $id)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
      }
      redirect('admin/supplier');
  }

  public function deleteSupplier($id){
      if($this->m_supplier->delete($id)){
    $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
  }else{
    $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
  }
      redirect('admin/supplier');
  }
  //end Supplier
}