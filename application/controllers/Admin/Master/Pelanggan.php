<?php

class Pelanggan extends CI_Controller
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

  //pelanggan
  public function index(){
      $name       = $this->session->userdata('name');
      $role       = $this->session->userdata('role');
      $customers  = $this->m_customer->get_data();
    //   var_dump(strlen($customers[2]['customer_phone'])); die;
      $this->load->view('Template/Header');
      $this->load->view('Admin/MasterData/pelanggan', compact('role', 'name', 'customers'));
  }

  public function createPelanggan(){
    $customerName   = $this->input->post('customer_name');
    $customerPhone  = $this->input->post('customer_phone');
    $checkName      = $this->m_customer->get_by_name($customerName);
    $dataPhone      = $this->m_customer->get_by_phone($customerPhone)->row();
    $checkPhone     = $this->m_customer->get_by_phone($customerPhone)->num_rows();
    $data = [];
    if($dataPhone->customer_phone == ""){
        if($customerPhone == $dataPhone->customer_phone){
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data No. Telepon Pelanggan Yang Dimasukkan Sudah Ada!','danger'));
        }else{
            // if($checkName > 0 || $checkPhone > 0){
            //     $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Pelanggan Yang Dimasukkan Sudah Ada!','danger'));
            // }else{
                $arrData = [
                    'customer_name'     => $customerName,
                    'customer_phone'    => $customerPhone,
                    'customer_status'   => "Belum Makan"
                ];
                array_push($data, $arrData);
            // }
        }
    }else{
        if($customerPhone == $dataPhone->customer_phone){
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data No. Telepon Pelanggan Yang Dimasukkan Sudah Ada!','danger'));
        }else{
            // if($checkName > 0 || $checkPhone > 0){
            //     $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Pelanggan Yang Dimasukkan Sudah Ada!','danger'));
            // }else{
                $arrData = [
                    'customer_name'     => $customerName,
                    'customer_phone'    => $customerPhone,
                    'customer_status'   => "Belum Makan"
                ];
                array_push($data, $arrData);
            // }
        }
    }
    // var_dump($checkPhone); die;
    // var_dump($arrData); die;
    if(count($data) > 0){
        if($this->m_customer->insert_array($data)){
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
        }else{
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
        }
    }
    redirect('admin/pelanggan');
  }

  public function editPelanggan(){
      $data = $this->input->post();
      $id   = $data['id'];
      if($this->m_customer->update($data, $id)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
      }
      redirect('admin/pelanggan');
  }

  public function deletePelanggan($id){
      if($this->m_customer->delete($id)){
    $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
  }else{
    $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
  }
      redirect('admin/pelanggan');
  }
}