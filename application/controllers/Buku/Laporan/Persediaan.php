<?php

class Persediaan extends CI_Controller
{
  function __construct(){
    parent::__construct();
    $this->load->model('Auth/Auth_model', 'm_auth');
    if($this->session->userdata('login') != true){
        redirect('');
    }
  }

  public function index(){
    $name       = $this->session->userdata('name');
    $this->load->view('Template/Header');
    $this->load->view('Buku/Laporan/persediaan', compact('name'));
  }
  
}