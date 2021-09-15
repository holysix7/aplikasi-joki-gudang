<?php

class Pembelian extends CI_Controller
{
  function __construct(){
    parent::__construct();
    $this->load->model('Auth/Auth_model', 'm_auth');
    $this->load->model('Transaksi/Persediaan_model', 'm_pembelian');
    if($this->session->userdata('login') != true){
        redirect('');
    }
  }

  public function index(){
    $name       = $this->session->userdata('name');
    $pembelian  = $this->m_pembelian->get_data();
    $dataSetuju = [];
    foreach ($pembelian as $row){
      if($row['status'] != 'Belum Disetujui'){
        $arrData = [
          'id_persediaan'     => $row['id_persediaan'],
          'id_supplier'       => $row['id_supplier'],
          'id_stok'           => $row['id_stok'],
          'kode_pembelian'    => $row['kode_pembelian'],
          'total_price'       => $row['total_price'],
          'purchase_date'     => $row['purchase_date'],
          'status'            => $row['status']
        ];
        array_push($dataSetuju, $arrData);
      }
    }
    // var_dump($dataSetuju); die;
    $this->load->view('Template/Header');
    $this->load->view('Buku/Laporan/pembelian', compact('name', 'dataSetuju'));
  }
  
}