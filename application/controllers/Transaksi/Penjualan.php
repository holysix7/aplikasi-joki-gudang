<?php

class Penjualan extends CI_Controller
{
  function __construct(){
      parent::__construct();
      $this->load->model('Auth/Auth_model', 'm_auth');
      $this->load->model('MasterData/Customer_model', 'm_pelanggan');
      $this->load->model('MasterData/Stok_model', 'm_stok');
      $this->load->model('MasterData/Stok_child_model', 'm_child_stok');
      $this->load->model('MasterData/Menu_model', 'm_menu');
      $this->load->model('MasterData/Level_Pedas_model', 'm_pedas');
      $this->load->model('MasterData/Table_model', 'm_meja');
      $this->load->model('MasterData/Kuah_model', 'm_kuah');
      $this->load->model('MasterData/Akun_model', 'm_akun');
      $this->load->model('Buku/Jurnal_model', 'm_jurnal');
      $this->load->model('Transaksi/Penjualan_model', 'm_penjualan');
      $this->load->model('Saldo_model', 'm_saldo');
      if($this->session->userdata('login') != true){
        redirect('');
      }
  }

  //dashboard
  public function index(){
      date_default_timezone_set("Asia/Jakarta");
      $date       = date('Y-m-d H:i:s');
      $name       = $this->session->userdata('name');
      $role       = $this->session->userdata('role');
      $penjualan  = $this->m_penjualan->get_data_join();
      $pelanggan  = $this->m_pelanggan->get_data_status();
      $meja       = $this->m_meja->get_data_status();
      $menu       = $this->m_menu->get_data();
      $lvPedas    = $this->m_pedas->get_data();
      $kuah       = $this->m_kuah->get_data();
      $generate   = $this->m_penjualan->generate_code();
      // var_dump($penjualan); die;
      $this->load->view('Template/Header');
      $this->load->view('Transaksi/Penjualan/index', compact('name', 'date', 'role', 'penjualan', 'pelanggan', 'menu', 'meja', 'lvPedas', 'kuah', 'generate'));
  }

  public function showPenjualan($id){
    $name     = $this->session->userdata('name');
    $role     = $this->session->userdata('role');
    $dataloop = $this->m_penjualan->get_penjualan_item($id);
    // var_dump($dataloop); die;
    $data     = [];
    foreach($dataloop as $row){
      if($row['id_pedas'] > 0 && $row['id_kuah'] > 0){
        $idPedas = $row['id_pedas'];
        $id_pedas = $this->m_pedas->show($idPedas);
        $idKuah = $row['id_kuah'];
        $id_kuah = $this->m_kuah->show($idKuah);
        $arrData = [
          'nama_menu' => $row['nama_menu'],
          'id_pedas'  => $row['id_pedas'],
          'id_kuah'   => $row['id_kuah'],
          'nama_kuah' => $id_kuah->nama_kuah,
          'lvl_pedas' => $id_pedas->lvl_pedas,
          'jumlah'    => $row['jumlah'],
        ];
        array_push($data, $arrData);
      }else{
        $arrData2 = [
          'nama_menu' => $row['nama_menu'],
          'id_pedas'  => null,
          'id_kuah'   => null,
          'nama_kuah' => null,
          'lvl_pedas' => null,
          'jumlah'    => $row['jumlah'],
        ];
        array_push($data, $arrData2);
      }
    }
    // var_dump($data); die;
    $this->load->view('Template/Header');
    $this->load->view('Transaksi/Penjualan/show', compact('data', 'name'));
  }

  public function ajaxPenjualan($id){
    header('Content-Type: application/json');
    $data = $this->m_penjualan->get_penjualan_item($id);
    echo json_encode($data);
  }
  
  public function addPenjualan(){
    $date = date_default_timezone_set("Asia/Jakarta");
    $idMeja     = $this->input->post('id_meja');
    $dataMeja   = [
      "table_status" => 'Sedang Diisi',
    ];
    $idMenu       = $_POST['id_menu'];
    $id_kuah      = $_POST['id_kuah'];
    $id_pedas     = $_POST['id_pedas'];
    $jumlah       = $_POST['jumlah'];
    $jumlahFix    = [];
    $indexJumlah = -1;
    foreach($idMenu as $idm){
      $indexJumlah++;
      $fixJumlah  = $this->m_menu->show($idm);
      $total      = intVal($fixJumlah->harga_menu) * $jumlah[$indexJumlah];
      // var_dump($total); die;
      array_push($jumlahFix, $total);
    }
    $total_harga  = 0;
    $indexNilai = -1;
    foreach($jumlahFix as $finalJumlah){
      $total_harga += $finalJumlah;
    }
    $data = [
      'id_pelanggan'       => $this->input->post('id_pelanggan'),
      'id_meja'            => $this->input->post('id_meja'),
      'total_harga'        => $total_harga,
      'tanggal_penjualan'  => $this->input->post('tanggal_penjualan'),
      'status_penjualan'   => $this->input->post('status_penjualan'),
      'kode_penjualan'   => $this->input->post('kode_penjualan')
    ];
    $generate   = $this->m_penjualan->generate_code();
    
    $status_insert = false;
    $indexSatu = -1;
    foreach($idMenu as $row){  
      // var_dump($idMenu); die;
      $indexSatu++;
      $okelah     = $this->m_menu->show($idMenu[$indexSatu]);
      $getBahan1  = $okelah->id_bahan_1 != null ? $this->m_stok->show($okelah->id_bahan_1) : null;
      $getBahan2  = $okelah->id_bahan_2 != null ? $this->m_stok->show($okelah->id_bahan_2) : null;
      $getBahan3  = $okelah->id_bahan_3 != null ? $this->m_stok->show($okelah->id_bahan_3) : null;
      $getBahan4  = $okelah->id_bahan_4 != null ? $this->m_stok->show($okelah->id_bahan_4) : null;
      $getBahan5  = $okelah->id_bahan_5 != null ? $this->m_stok->show($okelah->id_bahan_5) : null;

      $jumlah_stok1 = $getBahan1 != null ? $getBahan1->jumlah_stok > 0 ? $getBahan1->jumlah_stok : $status_insert = false : null;
      $jumlah_stok2 = $getBahan2 != null ? $getBahan2->jumlah_stok > 0 ? $getBahan2->jumlah_stok : $status_insert = false : null;
      $jumlah_stok3 = $getBahan3 != null ? $getBahan3->jumlah_stok > 0 ? $getBahan3->jumlah_stok : $status_insert = false : null;
      $jumlah_stok4 = $getBahan4 != null ? $getBahan4->jumlah_stok > 0 ? $getBahan4->jumlah_stok : $status_insert = false : null;
      $jumlah_stok5 = $getBahan5 != null ? $getBahan5->jumlah_stok > 0 ? $getBahan5->jumlah_stok : $status_insert = false : null;

      $status_insert = $getBahan1 != null ? $getBahan1->jumlah_stok > 0 ? true : false : false;
      $status_insert = $getBahan2 != null ? $getBahan2->jumlah_stok > 0 ? true : false : false;
      $status_insert = $getBahan3 != null ? $getBahan3->jumlah_stok > 0 ? true : false : false;
      $status_insert = $getBahan4 != null ? $getBahan4->jumlah_stok > 0 ? true : false : false;
      $status_insert = $getBahan5 != null ? $getBahan5->jumlah_stok > 0 ? true : false : false;
      
      if($jumlah_stok1 > 0 && $jumlah_stok2 > 0){
        $status_insert = true;
      }else{
        $status_insert = false;
      }

      
      $hasilStok1 = $getBahan1 != null ? $getBahan1->jumlah_stok - $jumlah[$indexSatu] : null;
      $hasilStok2 = $getBahan2 != null ? $getBahan2->jumlah_stok - $jumlah[$indexSatu] : null;
      $hasilStok3 = $getBahan3 != null ? $getBahan3->jumlah_stok - $jumlah[$indexSatu] : null;
      $hasilStok4 = $getBahan4 != null ? $getBahan4->jumlah_stok - $jumlah[$indexSatu] : null;
      $hasilStok5 = $getBahan5 != null ? $getBahan5->jumlah_stok - $jumlah[$indexSatu] : null;

      if($hasilStok1 > 0){
        $status_insert = true;
      }else{
        $status_insert = false;
      }
      
      if($hasilStok2 > 0){
        $status_insert = true;
      }else{
        $status_insert = false;
      }

    }
    if($status_insert == true){
      $insertPenjulalan = $this->m_penjualan->insert($data);
      $lastId = $this->db->insert_id();
      $index = -1;
      $dataItemInsert = [];
      foreach($idMenu as $row){  
        $index++;
        $okelah     = $this->m_menu->show($idMenu[$index]);
        // var_dump($okelah); die;
        $getBahan1  = $okelah->id_bahan_1 != null ? $this->m_stok->show($okelah->id_bahan_1) : null;
        $getBahan2  = $okelah->id_bahan_2 != null ? $this->m_stok->show($okelah->id_bahan_2) : null;
        $getBahan3  = $okelah->id_bahan_3 != null ? $this->m_stok->show($okelah->id_bahan_3) : null;
        $getBahan4  = $okelah->id_bahan_4 != null ? $this->m_stok->show($okelah->id_bahan_4) : null;
        $getBahan5  = $okelah->id_bahan_5 != null ? $this->m_stok->show($okelah->id_bahan_5) : null;

        $childsStok1  = $okelah->id_bahan_1 != null ? $this->m_child_stok->get_data_order($okelah->id_bahan_1) : null;
        $childsStok2  = $okelah->id_bahan_2 != null ? $this->m_child_stok->get_data_order($okelah->id_bahan_2) : null;
        $childsStok3  = $okelah->id_bahan_3 != null ? $this->m_child_stok->get_data_order($okelah->id_bahan_3) : null;
        $childsStok4  = $okelah->id_bahan_4 != null ? $this->m_child_stok->get_data_order($okelah->id_bahan_4) : null;
        $childsStok5  = $okelah->id_bahan_5 != null ? $this->m_child_stok->get_data_order($okelah->id_bahan_5) : null;
        // var_dump($this->m_child_stok->get_data_order()); die;
        if($status_insert == true){
          $hs1 = intVal($getBahan1->jumlah_stok) - $jumlah[$index];
          $hs2 = 0;
          $hs3 = 0;
          $hs4 = 0;
          $hs5 = 0;
          if($getBahan2 != null){
            $hs2 = $getBahan2->jumlah_stok - $jumlah[$index];
          }else{
            $status_insert = false;
          }
          if($getBahan3 != null){
            $hs3 = $getBahan3->jumlah_stok - $jumlah[$index];
          }else{
            $status_insert = false;
          }
          if($getBahan4 != null){
            $hs4 = $getBahan4->jumlah_stok - $jumlah[$index];
          }else{
            $status_insert = false;
          }
          if($getBahan5 != null){
            $hs5 = $getBahan5->jumlah_stok - $jumlah[$index];
          }else{
            $status_insert = false;
          }
          // $hs2 = $getBahan2 != null ? $getBahan2->jumlah_stok - $jumlah[$index] : $status_insert = false;
          // $hs3 = $getBahan3 != null ? $getBahan3->jumlah_stok - $jumlah[$index] : $status_insert = false;
          // $hs4 = $getBahan4 != null ? $getBahan4->jumlah_stok - $jumlah[$index] : $status_insert = false;
          // $hs5 = $getBahan5 != null ? $getBahan5->jumlah_stok - $jumlah[$index] : $status_insert = false;

          $cs1 = $childsStok1 != null ? $childsStok1->sisa_stok - $jumlah[$index] : null;
          $cs2 = $childsStok2 != null ? $childsStok2->sisa_stok - $jumlah[$index] : null;
          $cs3 = $childsStok3 != null ? $childsStok3->sisa_stok - $jumlah[$index] : null;
          $cs4 = $childsStok4 != null ? $childsStok4->sisa_stok - $jumlah[$index] : null;
          $cs5 = $childsStok5 != null ? $childsStok5->sisa_stok - $jumlah[$index] : null;

          $status_insert1 = $childsStok1 != null ? true : false;
          $status_insert2 = $childsStok2 != null ? true : false;
          $status_insert3 = $childsStok3 != null ? true : false;
          $status_insert4 = $childsStok4 != null ? true : false;
          $status_insert5 = $childsStok5 != null ? true : false;
          // var_dump($hs3); die;
          if($hs1 > 0 && $hs2 > 0){
            $jumlah_stok1 = [
              'jumlah_stok' => $hs1
            ];
            $jumlah_stok2 = [
              'jumlah_stok' => $hs2
            ];
            if($hs3 > 0){
              $jumlah_stok3 = [
                'jumlah_stok' => $hs3
              ];
            }
            if($hs4 > 0){
              $jumlah_stok4 = [
                'jumlah_stok' => $hs4
              ];
            }
            if($hs5 > 0){
              $jumlah_stok5 = [
                'jumlah_stok' => $hs4
              ];
            }
            $sisa_stok1 = [
              'sisa_stok' => $cs1
            ];
            $sisa_stok2 = [
              'sisa_stok' => $cs2
            ];
            if($hs3 > 0){
              $sisa_stok3 = [
                'sisa_stok' => $cs3
              ];
            }
            if($hs4 > 0){
              $sisa_stok4 = [
                'sisa_stok' => $cs4
              ];
            }
            if($hs3 > 0){
              $sisa_stok5 = [
                'sisa_stok' => $cs4
              ];
            }
            // var_dump($hs2); die;
            $arrData = [
              'id_menu'     => $row,
              'id_penjualan'=> $lastId,
              'id_pedas'    => $id_pedas[$index],
              'id_kuah'     => $id_kuah[$index],
              'jumlah'      => $jumlah[$index]
            ];
            array_push($dataItemInsert, $arrData);
            if($hs1 > 0 && $hs2 > 0){
              $this->m_stok->update($jumlah_stok1, $getBahan1->id);
              $this->m_stok->update($jumlah_stok2, $getBahan2->id);
              $this->m_child_stok->update($sisa_stok1, $childsStok1->id);
              $this->m_child_stok->update($sisa_stok2, $childsStok2->id);
              if($hs3 > 0){
                $this->m_stok->update($jumlah_stok3, $getBahan3->id);
                $this->m_child_stok->update($sisa_stok3, $childsStok3->id);
              }
              if($hs4 > 0){
                $this->m_stok->update($jumlah_stok4, $getBahan4->id);
                $this->m_child_stok->update($sisa_stok4, $childsStok4->id);
              }
              if($hs5 > 0){
                $this->m_stok->update($jumlah_stok5, $getBahan5->id);
                $this->m_child_stok->update($sisa_stok5, $childsStok5->id);
              }
              $status_insert = true;
            }else{
              $status_insert = false;
            }
            // var_dump($hs5); die;
            // if($hs3 != null || $hs4 != null || $hs5 != null){
            //   if($hs1 != null && $hs2 != null && $hs3 != null && $hs4 != null && $hs5 != null){
            //     $status_insert = true;
            //     $this->m_stok->update($jumlah_stok1, $getBahan1->id);
            //     $this->m_stok->update($jumlah_stok2, $getBahan2->id);
            //     $this->m_stok->update($jumlah_stok3, $getBahan3->id);
            //     $this->m_stok->update($jumlah_stok4, $getBahan4->id);
            //     $this->m_stok->update($jumlah_stok5, $getBahan5->id);
            //     $this->m_child_stok->update($sisa_stok1, $childsStok1->id);
            //     $this->m_child_stok->update($sisa_stok2, $childsStok2->id);
            //     $this->m_child_stok->update($sisa_stok3, $childsStok3->id);
            //     $this->m_child_stok->update($sisa_stok4, $childsStok4->id);
            //     $this->m_child_stok->update($sisa_stok5, $childsStok5->id);
            //   }else{
            //     $status_insert = false;
            //   }
            // }else{
            //   if($hs1 != null && $hs2 != null){
            //     $status_insert = true;
            //     $this->m_stok->update($jumlah_stok1, $getBahan1->id);
            //     $this->m_stok->update($jumlah_stok2, $getBahan2->id); 
            //   }
            // }
          }
        }
      }
    }
    // var_dump(count($dataItemInsert));
    // die;
    if($status_insert == true && count($dataItemInsert) > 0){
      if($this->m_meja->update($dataMeja, $idMeja) && $this->m_penjualan->multiple_insert($dataItemInsert)){
        $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
      }else{
        $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-times"></i></b> Data Gagal Ditambahkan','danger'));
      }
    }else{
      $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-times"></i></b> Gagal Menyimpan Data Dikarenakan Stok Habis Atau Stok Kurang','danger'));
    }
    redirect('transaksi/penjualan');
  }

  public function updatePenjualan(){
    $id_meja          = $this->input->post('id_meja');
    $id_penjualan     = $this->input->post('id_penjualan');
    $status_penjualan = $this->input->post('status_penjualan');
    $customer_name    = $this->input->post('customer_name');
    $dataTotalModal   = [];
    $item = $this->m_penjualan->get_item();
    foreach($item as $el){
      $dataMenu = $this->m_menu->show($el['id_menu']);
      $idBahan1 = $this->m_stok->show($dataMenu->id_bahan_1);
      $idBahan2 = $dataMenu->id_bahan_2 != null ? $this->m_stok->show($dataMenu->id_bahan_2) : null;
      $idBahan3 = $dataMenu->id_bahan_3 != null ? $this->m_stok->show($dataMenu->id_bahan_3) : null;
      $idBahan4 = $dataMenu->id_bahan_4 != null ? $this->m_stok->show($dataMenu->id_bahan_4) : null;
      $idBahan5 = $dataMenu->id_bahan_5 != null ? $this->m_stok->show($dataMenu->id_bahan_5) : null;
      if($id_penjualan == $el['id_penjualan']){
        if($idBahan2 != null){
          $total = $idBahan1->unit_price + $idBahan2->unit_price;
        }
        if($idBahan3 != null){
          $total += $idBahan3->unit_price;
        }
        if($idBahan4 != null){
          $total += $idBahan4->unit_price;
        }
        if($idBahan5 != null){
          $total += $idBahan5->unit_price;
        }
        $arrDaata = [
          'modal'   => $total,
          'jumlah'  => $el['jumlah']
        ];
        array_push($dataTotalModal, $arrDaata);
      }
    }
    $nilaiLooped = 0;
    foreach($dataTotalModal as $row){
      $nilaiLooped += $row['modal'] * $row['jumlah'];
    }

    $dataMeja = [
      "table_status" => $this->input->post('table_status')
    ];

    $customer_data  = $this->m_pelanggan->show_cust_data($customer_name);
    $data_meja      = $this->m_penjualan->get_meja($id_meja);
    $meja_update            = [];
    $meja_update['id_meja'] = [];
    $dataJurnal     = [];
    foreach($data_meja as $row_meja){
      if($customer_data->id == $row_meja['id_pelanggan'] && $row_meja['status_penjualan'] == 'Show'){
        array_push($meja_update, $row_meja);
        array_push($meja_update['id_meja'], $row_meja['id_meja']);
        // var_dump($meja_update['id_meja'][0]); die;
        $dataJurnal1 = [
          'id_akun'       => 1,
          'id_penjualan'  => $id_penjualan,
          'id_persediaan' => null,
          'status_jurnal' => 'Debet',
          'jumlah'        => $row_meja['total_harga'],
          'tanggal_jurnal'=> date('Y-m-d')
        ];
        $dataJurnal2 = [
          'id_akun'       => 3,
          'id_penjualan'  => $id_penjualan,
          'id_persediaan' => null,
          'status_jurnal' => 'Kredit',
          'jumlah'        => $row_meja['total_harga'],
          'tanggal_jurnal'=> date('Y-m-d')
        ];
        $dataJurnal3 = [
          'id_akun'       => 4,
          'id_penjualan'  => $id_penjualan,
          'id_persediaan' => null,
          'status_jurnal' => 'Debet',
          'jumlah'        => $nilaiLooped,
          'tanggal_jurnal'=> date('Y-m-d')
        ];
        $dataJurnal4 = [
          'id_akun'       => 2,
          'id_penjualan'  => $id_penjualan,
          'id_persediaan' => null,
          'status_jurnal' => 'Kredit',
          'jumlah'        => $nilaiLooped,
          'tanggal_jurnal'=> date('Y-m-d')
        ];
        // var_dump($dataJurnal2); die;
        array_push($dataJurnal, $dataJurnal1);
        array_push($dataJurnal, $dataJurnal2);
        array_push($dataJurnal, $dataJurnal3);
        array_push($dataJurnal, $dataJurnal4);
      }
    }
    $dataPenjualan = [
      'status_penjualan'  => $this->input->post('status_penjualan')
    ];

    $dataJurnalPenjualan = $dataJurnal;
    
    $nominal = 0;
    foreach ($dataJurnalPenjualan as $rowPenjualan) {
      if($rowPenjualan['status_jurnal'] == 'Debet'){
        $nominal += $rowPenjualan['jumlah']; 
      }
    }
    // var_dump($sisaSaldo); die;
    $saldo = $this->m_saldo->get_data();
    $saldoSkrg = $saldo->saldo_kas;
    $sisaSaldo = $saldoSkrg + $this->input->post('total_harga');
    $dataSaldo = [
      'saldo_kas' => $sisaSaldo
    ];

    if($this->m_saldo->update($dataSaldo, 1) && $this->m_penjualan->update($dataPenjualan, $meja_update[0]['id_meja']) && $this->m_meja->update($dataMeja, $id_meja) && $this->m_jurnal->multiple_insert($dataJurnalPenjualan)){
      $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
    }else{
      $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
    }
    redirect('transaksi/penjualan');
  }

  public function deletePenjualan($id){
    $show = $this->m_persediaan->show($id);
    if($this->m_persediaan->delete($id)){
    $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
  }else{
    $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
  }
    redirect('transaksi/penjualan');
  }
}