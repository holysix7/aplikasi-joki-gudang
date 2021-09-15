<?php

class Menu extends CI_Controller
{
  function __construct(){
      parent::__construct();
      $this->load->model('Auth/Auth_model', 'm_auth');
      $this->load->model('MasterData/Menu_model', 'm_menu');
      $this->load->model('MasterData/Stok_model', 'm_bahan');
      if($this->session->userdata('login') != true){
          redirect('');
      }
  }
  
  public function index(){
      $name   = $this->session->userdata('name');
      $role   = $this->session->userdata('role');
      $menu   = $this->m_menu->get_data();
      $bahan  = $this->m_bahan->get_data();
      $this->load->view('Template/Header');
      $this->load->view('Admin/MasterData/Menu/index', compact('name', 'menu', 'role', 'bahan'));
  }
  
  public function showMenu($id){
    $name   = $this->session->userdata('name');
    $menu   = $this->m_menu->show($id);
    $data = [];
    for($i = 1; $i < 6; $i++){
        $id = $i;
        $bahanId = "id_bahan_".$id;
        // var_dump($bahanId); die;
        $arr = [
            'id'    => $id,
            "bahan" => $bahanId
        ];
        array_push($data, $arr);
    }

    $dataMenu = [];
    
    foreach($data as $rowId){
        $new = $rowId['bahan'];
        $id = $menu->$new;
        $arr = [
            'id_bahan_menu' => $id
        ];
        array_push($dataMenu, $arr);
        // var_dump($id); die;
        // $joinBahan = $this->m_bahan->getBahanMenu($rowId['id'], $rowId['bahan']);
    }


    foreach($dataMenu as $rowMenu){
        foreach($data as $rowId){
            $joinBahan = $this->m_bahan->getBahanMenu($rowMenu['id_bahan_menu'], $rowId['bahan']);
            var_dump($joinBahan); die;
        }
    }
    
    var_dump($dataMenu); die;
    $this->load->view('Template/Header');
    $this->load->view('Admin/MasterData/Menu/show', compact('name', 'menu', 'bahan'));
  }

  public function addMenu(){
      $getBahan1    = $this->m_bahan->show($this->input->post('id_bahan_1'));
      $getBahan2    = $this->m_bahan->show($this->input->post('id_bahan_2'));
      $getBahan3    = $this->input->post('id_bahan_3') != null ? $this->m_bahan->show($this->input->post('id_bahan_3')) : null;
      $getBahan4    = $this->input->post('id_bahan_4') != null ? $this->m_bahan->show($this->input->post('id_bahan_4')) : null;
      $getBahan5    = $this->input->post('id_bahan_5') != null ? $this->m_bahan->show($this->input->post('id_bahan_5')) : null;
      $jumlah_harga = intVal($getBahan1->unit_price) + intVal($getBahan2->unit_price) + intVal($getBahan3->unit_price) + intVal($getBahan4->unit_price) + intVal($getBahan5->unit_price) ;
      if($this->input->post('jenis_menu') == 'Makanan'){
        $hargaAwal    = intVal($jumlah_harga) * 30 / 100;
        $harga_menu   = intVal($jumlah_harga) + intVal($hargaAwal);
        $data = [
            'nama_menu'   => $this->input->post('nama_menu'),
            'id_bahan_1'  => intVal($this->input->post('id_bahan_1')),
            'id_bahan_2'  => intVal($this->input->post('id_bahan_2')),
            'id_bahan_3'  => intVal($this->input->post('id_bahan_3')),
            'id_bahan_4'  => intVal($this->input->post('id_bahan_4')),
            'id_bahan_5'  => intVal($this->input->post('id_bahan_5')),
            'harga_menu'  => $harga_menu,
            'jenis_menu'  => $this->input->post('jenis_menu')
        ];
    }else{
        $hargaAwal    = intVal($jumlah_harga) * 10 / 100;
        $harga_menu   = intVal($jumlah_harga) + intVal($hargaAwal); 
        $data = [
            'nama_menu'   => $this->input->post('nama_menu'),
            'id_bahan_1'  => intVal($this->input->post('id_bahan_1')),
            'id_bahan_2'  => intVal($this->input->post('id_bahan_2')),
            'id_bahan_3'  => intVal($this->input->post('id_bahan_3')),
            'id_bahan_4'  => intVal($this->input->post('id_bahan_4')),
            'id_bahan_5'  => intVal($this->input->post('id_bahan_5')),
            'harga_menu'  => $harga_menu,
            'jenis_menu'  => $this->input->post('jenis_menu')
        ];
      }
    //   var_dump($harga_menu); die;
      if($this->m_menu->insert($data)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
      }
      redirect('admin/menu');
  }

  public function editMenu(){
      $data = $this->input->post();
      $id   = $data['id'];
      $id   = $this->input->post('id');
      if($this->m_menu->update($data, $id)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
      }
      redirect('admin/menu');
  }

  public function deleteMenu($id){
    if($this->m_menu->delete($id)){
        $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
    }else{
        $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
    }
    redirect('admin/menu');
  }
}