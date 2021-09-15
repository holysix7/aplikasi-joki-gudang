 <?php

class Karyawan extends CI_Controller
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
  //karyawan
  public function index(){
      $name       = $this->session->userdata('name');
      $dataKaryawan  = $this->m_karyawan->get_karyawan();
      $karyawans = [];
      foreach($dataKaryawan as $row){
        if($row['role'] != 'superadmin'){
            array_push($karyawans, $row); 
        }
      }
      $this->load->view('Template/Header');
      $this->load->view('Admin/MasterData/karyawan', compact('name', 'karyawans'));
  }

  public function createKaryawan(){
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $name     = $this->input->post('name');
      $role     = $this->input->post('role');
      $data = [
          'username' => $username,
          'password' => md5($password),
          'name'     => $name,
          'role'     => $role
      ];
      if($this->m_karyawan->insert($data)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
      }
      redirect('admin/karyawan');
  }

  public function editKaryawan(){
      $username = $this->input->post('username');
      $password = $this->input->post('password');
      $name     = $this->input->post('name');
      $role     = $this->input->post('role');
      $data = [
          'username' => $username,
          'password' => md5($password),
          'name'     => $name,
          'role'     => $role
      ];
      $id   = $this->input->post('id');
      if($this->m_karyawan->update($data, $id)){
          $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
      }else{
          $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
      }
      redirect('admin/karyawan');
  }

  public function deleteKaryawan($id){
      if($this->m_karyawan->delete($id)){
    $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
  }else{
    $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
  }
      redirect('admin/karyawan');
  }
  //end karyawan
}