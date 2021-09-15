<?php

class Index extends CI_Controller
{
  function __construct(){
    parent::__construct();
    $this->load->model('Auth/Auth_model', 'm_auth');
    $this->load->model('Buku/Jurnal_model', 'm_jurnal');
    $this->load->model('MasterData/Stok_model', 'm_stok');
    $this->load->model('MasterData/Menu_model', 'm_menu');
    $this->load->model('MasterData/Akun_model', 'm_coa');
    $this->load->model('Saldo_model', 'm_saldo');
    if($this->session->userdata('login') != true){
        redirect('');
    }
  }

  public function index(){
    $name       = $this->session->userdata('name');
    $coas       = $this->m_coa->get_data();
    // var_dump($coas); die;
    $this->load->view('Template/Header');
    $this->load->view('Buku/BukuBesar/Index', compact('name', 'coas'));
  }
  
}