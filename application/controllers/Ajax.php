<?php

class Ajax extends CI_Controller {

  function __construct(){
      parent::__construct();
      $this->load->model('Transaksi/Penjualan_model', 'm_penjualan');
      $this->load->model('Transaksi/Persediaan_model', 'm_pembelian');
      $this->load->model('Buku/Jurnal_model', 'm_jurnal');
      $this->load->model('MasterData/Stok_model', 'm_stok');
      $this->load->model('MasterData/Menu_model', 'm_menu');
      $this->load->model('Saldo_model', 'm_saldo');
  }

  public function ajaxUserPenjualan($user_id){
    header('Content-Type: application/json');
    $data = $this->m_penjualan->get_user_id($user_id);
    echo json_encode($data);
  }

  public function ajaxRangeDate($start_date, $end_date, $type){
    header('Content-Type: application/json');
    $saldo                = $this->m_saldo->get_data();
    $saldo_kas            = $saldo->saldo_kas;
    $data['status']       = "200 OK";
    $data['saldo_awal']   = 0;
    $data['saldo_kas']    = intVal($saldo_kas);
    $data['total_debet']  = 0;
    $data['total_kredit'] = 0;
    $data['data_jurnal']  = [];
    $jurnal     = $this->m_jurnal->get_data_by_date($start_date, $end_date, $type);
    foreach($jurnal as $element){
      if($element['id_penjualan'] == null){
        $dataPersediaan = $this->m_jurnal->get_data_persediaan($element['id']);
        if($element['status_jurnal'] == 'Debet'){
          $data['total_debet'] += $element['jumlah'];
          // $data['saldo_awal'] += $data['saldo_kas'] + $element['jumlah'];
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
          array_push($data['data_jurnal'], $arrData);
        }else{
          $data['total_kredit'] += $element['jumlah'];
          // $data['saldo_awal'] += $data['saldo_kas'] - $element['jumlah'];
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
          array_push($data['data_jurnal'], $arrData);

        }
      }else{
        $dataPenjualan = $this->m_jurnal->get_data_penjualan($element['id']);
        if($element['status_jurnal'] == 'Debet'){
          $data['total_debet'] += $element['jumlah'];
          // $data['saldo_awal'] += $data['saldo_kas'] + $element['jumlah'];
          // var_dump($element['jumlah'] + $saldo_kas); die;
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
          array_push($data['data_jurnal'], $arrData2);
        }else{
          $data['total_kredit'] += $element['jumlah'];
          // $data['saldo_awal'] += $data['saldo_kas'] - $element['jumlah'];
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
          array_push($data['data_jurnal'], $arrData2);
        }
      }
    }
    $data['saldo_awal'] += $data['saldo_kas'] - $data['total_debet'];
    // var_dump($data['total_debet']); die;
    if($data['saldo_awal'] < 0){
      $data['saldo_awal'] = 0;
    }
    echo json_encode($data);
  }

  public function ajaxRangeDateWithId($start_date, $end_date, $type){
    header('Content-Type: application/json');
    $saldo                = $this->m_saldo->get_data();
    $saldo_kas            = $saldo->saldo_kas;
    $data['status']       = "200 OK";
    $data['saldo_awal']   = 0;
    $data['saldo_kas']    = intVal($saldo_kas);
    $data['total_debet']  = 0;
    $data['total_kredit'] = 0;
    $data['total_saldo_debet']  = 0;
    $data['total_saldo_kredit'] = 0;
    $data['data_jurnal']  = [];
    $jurnal      = $this->m_jurnal->get_data_by_date($start_date, $end_date, $type);
    $index = -1;
    $indexDua = 0;
    foreach($jurnal as $element){
      $index++;
      $indexDua++;
      if($jurnal[0]['status_jurnal'] == 'Debet'){
        if($index > 0){
          if($element['status_jurnal'] == 'Debet'){
            $data['total_saldo_debet'] += $jurnal[$index]['jumlah'];
            $fixed_jumlah += $jurnal[$index]['jumlah'];
          }else{
            $data['total_saldo_kredit'] += $jurnal[$index]['jumlah'];
            $fixed_jumlah -= $jurnal[$index]['jumlah'];
          }
        }else{
          $fixed_jumlah = intVal($element['jumlah']);
        }
      }else{
        if($index > 0){
          if($element['status_jurnal'] == 'Kredit'){
            $fixed_jumlah += $jurnal[$index]['jumlah'];
            $data['total_saldo_kredit'] += $fixed_jumlah;
          }else{
            $fixed_jumlah -= $jurnal[$index]['jumlah'];
            $data['total_saldo_debet'] += $fixed_jumlah;
          }
        }else{
          $fixed_jumlah = intVal($element['jumlah']);
        }
      }
      if($element['id_penjualan'] == null){
        $dataPersediaan = $this->m_jurnal->get_data_persediaan($element['id']);
        if($element['status_jurnal'] == 'Debet'){
          $data['total_debet'] += $element['jumlah'];
          $arrData = [
            'id'              => $element['id'],
            'id_akun'         => $element['id_akun'],
            'id_persediaan'   => $element['id_persediaan'],
            'id_penjualan'    => null,
            'status_jurnal'   => $element['status_jurnal'],
            'tanggal_jurnal'  => $element['tanggal_jurnal'],
            'kode_akun'       => $element['kode_akun'],
            'nama_akun'       => $element['nama_akun'],
            'jumlah'          => $element['jumlah'],
            'index'           => $index,
            'fixed_jumlah'    => $fixed_jumlah
          ];
          array_push($data['data_jurnal'], $arrData);
        }else{
          $data['total_kredit'] += $element['jumlah'];
          $arrData = [
            'id'              => $element['id'],
            'id_akun'         => $element['id_akun'],
            'id_persediaan'   => $element['id_persediaan'],
            'id_penjualan'    => null,
            'status_jurnal'   => $element['status_jurnal'],
            'tanggal_jurnal'  => $element['tanggal_jurnal'],
            'kode_akun'       => $element['kode_akun'],
            'nama_akun'       => $element['nama_akun'],
            'jumlah'          => $element['jumlah'],
            'index'           => $index,
            'fixed_jumlah'    => $fixed_jumlah
          ];
          array_push($data['data_jurnal'], $arrData);

        }
      }else{
        $dataPenjualan = $this->m_jurnal->get_data_penjualan($element['id']);
        if($element['status_jurnal'] == 'Debet'){
          $data['total_debet'] += $element['jumlah'];
          $arrData2 = [
            'id'              => $element['id'],
            'id_akun'         => $element['id_akun'],
            'id_persediaan'   => null,
            'id_penjualan'    => $element['id_penjualan'],
            'status_jurnal'   => $element['status_jurnal'],
            'tanggal_jurnal'  => $element['tanggal_jurnal'],
            'kode_akun'       => $element['kode_akun'],
            'nama_akun'       => $element['nama_akun'],
            'jumlah'          => $element['jumlah'],
            'index'           => $index,
            'fixed_jumlah'    => $fixed_jumlah
          ];
          array_push($data['data_jurnal'], $arrData2);
        }else{
          $data['total_kredit'] += $element['jumlah'];
          $arrData2 = [
            'id'              => $element['id'],
            'id_akun'         => $element['id_akun'],
            'id_persediaan'   => null,
            'id_penjualan'    => $element['id_penjualan'],
            'status_jurnal'   => $element['status_jurnal'],
            'tanggal_jurnal'  => $element['tanggal_jurnal'],
            'kode_akun'       => $element['kode_akun'],
            'nama_akun'       => $element['nama_akun'],
            'jumlah'          => $element['jumlah'],
            'index'           => $index,
            'fixed_jumlah'    => $fixed_jumlah
          ];
          array_push($data['data_jurnal'], $arrData2);
        }
      }
    }
    $data['saldo_awal'] += $data['saldo_kas'] - $data['total_debet'];
    if($data['saldo_awal'] < 0){
      $data['saldo_awal'] = 0;
    }
    echo json_encode($data);
  }

  public function laporan($start_date, $end_date, $type){
    header('Content-Type: application/json');
    $data['status']          = "200 OK";
    $data['total_pembelian'] = 0;
    $data['data_pembelian']  = [];
    if($type == 'pembelian'){
      $pembelian            = $this->m_pembelian->get_data_by_date($start_date, $end_date);
      foreach ($pembelian as $row){
        if($row['status'] != 'Belum Disetujui'){
          $data['total_pembelian'] += $row['total_price'];
          $arrData = [
            'id_persediaan'     => $row['id_persediaan'],
            'id_supplier'       => $row['id_supplier'],
            'id_stok'           => $row['id_stok'],
            'kode_pembelian'    => $row['kode_pembelian'],
            'total_price'       => $row['total_price'],
            'purchase_date'     => $row['purchase_date'],
            'status'            => $row['status']
          ];
          array_push($data['data_pembelian'], $arrData);
        }
      }
    }else{
      $penjualan            = $this->m_penjualan->get_data_by_date($start_date, $end_date);
      foreach ($penjualan as $row){
        $data['total_pembelian'] += $row['total_harga'];
        $arrData = [
          'id_penjualan'      => $row['id_penjualan'],
          'id_pelanggan'      => $row['id_pelanggan'],
          'id_meja'           => $row['id_meja'],
          'kode_penjualan'    => $row['kode_penjualan'],
          'total_harga'       => $row['total_harga'],
          'tanggal_penjualan' => $row['tanggal_penjualan'],
          'status_penjualan'  => $row['status_penjualan']
        ];
        array_push($data['data_pembelian'], $arrData);
      }
    }
    echo json_encode($data);
  }

  public function persediaan(){
    header('Content-Type: application/json');
    $data['status']   = "200 OK";
    $data['total_perunit']  = 0;
    $data['total_stok']     = 0;
    $data['data']     = [];
    $persediaan = $this->m_stok->get_data();
    foreach($persediaan as $row){
      $totalHarga = 0;
      $totalHarga += $row['jumlah_stok'] * $row['unit_price'];
      $data['total_perunit'] += $row['unit_price'];
      $data['total_stok'] += $totalHarga;
      $arr = [
        'id' => $row['id'],
        'nama_stok' => $row['nama_stok'],
        'jumlah_stok' => $row['jumlah_stok'],
        'unit_price' => $row['unit_price'],
        'total_harga' => $totalHarga,
      ];
      array_push($data['data'], $arr);
    }
    echo json_encode($data);
  }
}