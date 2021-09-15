<?php

class LevelPedas extends CI_Controller
{
  function __construct(){
      parent::__construct();
      $this->load->model('Auth/Auth_model', 'm_auth');
      $this->load->model('MasterData/Level_Pedas_model', 'm_pedas');
      if($this->session->userdata('login') != true){
          redirect('');
      }
  }
  
  public function index(){
      $name   = $this->session->userdata('name');
      $role   = $this->session->userdata('role');
      $pedas   = $this->m_pedas->get_data();
      $this->load->view('Template/Header');
      $this->load->view('Admin/MasterData/levelpedas', compact('name', 'pedas', 'role'));
  }

  public function addLevelPedas(){
      $data = [
          'lvl_pedas'  => $this->input->post('lvl_pedas')
      ];
      if($this->m_pedas->insert($data)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
      }
      redirect('admin/level/pedas');
  }

  public function editLevelPedas(){
      $data = $this->input->post();
      $id   = $data['id'];
      $id   = $this->input->post('id');
      if($this->m_pedas->update($data, $id)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
      }
      redirect('admin/level/pedas');
  }

  public function deleteLevelPedas($id){
    if($this->m_pedas->delete($id)){
        $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
    }else{
        $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
    }
    redirect('admin/level/pedas');
  }
}