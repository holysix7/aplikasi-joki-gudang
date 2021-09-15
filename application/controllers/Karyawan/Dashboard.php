<?php

class Dashboard extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('Auth/Auth_model', 'm_auth');
        $this->load->model('MasterData/Supplier_model', 'm_supplier');
        $this->load->model('MasterData/Customer_model', 'm_customer');
        if($this->session->userdata('login') != true){
            redirect('');
        }
    }

    public function index(){
        $name = $this->session->userdata('name');
        $this->load->view('Template/Header');
        $this->load->view('Karyawan/index', compact('name'));
    }
    
}