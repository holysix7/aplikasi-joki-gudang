<?php

class Dashboard extends CI_Controller
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

    //dashboard
    public function index(){
        $name = $this->session->userdata('name');
        $this->load->view('Template/Header');
        $this->load->view('Admin/index', compact('name'));
    }
    
}
