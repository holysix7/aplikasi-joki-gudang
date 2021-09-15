<?php

class Penjualan extends CI_Controller
{
  function __construct(){
    parent::__construct();
    $this->load->model('Auth/Auth_model', 'm_auth');
    $this->load->model('Transaksi/Penjualan_model', 'm_penjualan');
    if($this->session->userdata('login') != true){
        redirect('');
    }
  }

  public function index(){
    $name       = $this->session->userdata('name');
    $penjualan  = $this->m_penjualan->get_data();
    $dataSetuju = [];
    foreach ($penjualan as $row){
      if($row['status_penjualan'] != 'Show'){
        $arrData = [
          'id_penjualan'      => $row['id_penjualan'],
          'id_pelanggan'      => $row['id_pelanggan'],
          'id_meja'           => $row['id_meja'],
          'kode_penjualan'    => $row['kode_penjualan'],
          'total_harga'       => $row['total_harga'],
          'tanggal_penjualan' => $row['tanggal_penjualan'],
          'status_penjualan'  => $row['status_penjualan']
        ];
        array_push($dataSetuju, $arrData);
      }
    }
    // var_dump($dataSetuju); die;
    $this->load->view('Template/Header');
    $this->load->view('Buku/Laporan/penjualan', compact('name', 'dataSetuju'));
  }
  
}