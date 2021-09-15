<?php

class Kuah extends CI_Controller
{
  function __construct(){
      parent::__construct();
      $this->load->model('Auth/Auth_model', 'm_auth');
      $this->load->model('MasterData/Kuah_model', 'm_kuah');
      if($this->session->userdata('login') != true){
          redirect('');
      }
  }
  
  public function index(){
      $name   = $this->session->userdata('name');
      $role   = $this->session->userdata('role');
      $kuah   = $this->m_kuah->get_data();
      $this->load->view('Template/Header');
      $this->load->view('Admin/MasterData/kuah', compact('name', 'kuah', 'role'));
  }

  public function addKuah(){
      $data = [
          'nama_kuah'  => $this->input->post('nama_kuah')
      ];
      if($this->m_kuah->insert($data)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
      }
      redirect('admin/kuah');
  }

  public function editKuah(){
      $data = $this->input->post();
      $id   = $data['id'];
      if($this->m_kuah->update($data, $id)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
      }
      redirect('admin/kuah');
  }

  public function deleteKuah($id){
    if($this->m_kuah->delete($id)){
        $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
    }else{
        $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
    }
    redirect('admin/kuah');
  }
}