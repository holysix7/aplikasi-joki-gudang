<?php

class Penjualan extends CI_Controller
{
  function __construct(){
    parent::__construct();
    $this->load->model('Auth/Auth_model', 'm_auth');
    $this->load->model('Buku/Jurnal_model', 'm_jurnal');
    $this->load->model('MasterData/Stok_model', 'm_stok');
    $this->load->model('MasterData/Menu_model', 'm_menu');
    $this->load->model('Saldo_model', 'm_saldo');
    if($this->session->userdata('login') != true){
        redirect('');
    }
  }

  public function index(){
    $name       = $this->session->userdata('name');
    $saldo      = $this->m_saldo->get_data();
    $saldo_kas  = $saldo->saldo_kas;
    $jurnal     = $this->m_jurnal->get_data_buku_penjualan();
    $saldo_akhir  = 0;
    $dataJurnal = [];
    foreach($jurnal as $element){
      if($element['id_penjualan'] == null){
        $dataPersediaan = $this->m_jurnal->get_data_persediaan($element['id']);
        if($element['status_jurnal'] == 'Debet'){
          // $saldo_akhir += $saldo_kas - $element['jumlah'];
          $arrData = [
            'id'              => $element['id'],
            'id_akun'         => $element['id_akun'],
            'id_persediaan'   => $element['id_persediaan'],
            'id_penjualan'    => null,
            'status_jurnal'   => $element['status_jurnal'],
            'tanggal_jurnal'  => $element['tanggal_jurnal'],
            'kode_akun'       => $element['kode_akun'],
            'nama_akun'       => $element['nama_akun'],
            'jumlah'          => $element['jumlah']  
          ];
          array_push($dataJurnal, $arrData);
        }else{
          // $saldo_akhir -= $saldo_kas + $element['jumlah'];
          $arrData = [
            'id'              => $element['id'],
            'id_akun'         => $element['id_akun'],
            'id_persediaan'   => $element['id_persediaan'],
            'id_penjualan'    => null,
            'status_jurnal'   => $element['status_jurnal'],
            'tanggal_jurnal'  => $element['tanggal_jurnal'],
            'kode_akun'       => $element['kode_akun'],
            'nama_akun'       => $element['nama_akun'],
            'jumlah'          => $element['jumlah']  
          ];
          array_push($dataJurnal, $arrData);

        }
      }else{
        $dataPenjualan = $this->m_jurnal->get_data_penjualan($element['id']);
        if($element['status_jurnal'] == 'Debet'){
          // var_dump($element['jumlah'] + $saldo_kas); die;
          // $saldo_akhir = $saldo_kas + $element['jumlah'];
          // var_dump($saldo_akhir); die;
          $arrData2 = [
            'id'              => $element['id'],
            'id_akun'         => $element['id_akun'],
            'id_persediaan'   => null,
            'id_penjualan'    => $element['id_penjualan'],
            'status_jurnal'   => $element['status_jurnal'],
            'tanggal_jurnal'  => $element['tanggal_jurnal'],
            'kode_akun'       => $element['kode_akun'],
            'nama_akun'       => $element['nama_akun'],
            'jumlah'          => $element['jumlah']
          ];
          array_push($dataJurnal, $arrData2);
        }else{
          // $saldo_akhir -= $saldo_kas + $element['jumlah'];
          $arrData2 = [
            'id'              => $element['id'],
            'id_akun'         => $element['id_akun'],
            'id_persediaan'   => null,
            'id_penjualan'    => $element['id_penjualan'],
            'status_jurnal'   => $element['status_jurnal'],
            'tanggal_jurnal'  => $element['tanggal_jurnal'],
            'kode_akun'       => $element['kode_akun'],
            'nama_akun'       => $element['nama_akun'],
            'jumlah'          => $element['jumlah']
          ];
          array_push($dataJurnal, $arrData2);
        }
      }
    }
    // var_dump($saldo_akhir); die;
    // var_dump($dataJurnal); die;
    $this->load->view('Template/Header');
    $this->load->view('Buku/BukuBesar/Penjualan', compact('name', 'dataJurnal', 'saldo_kas', 'saldo_akhir'));
  }
  
}