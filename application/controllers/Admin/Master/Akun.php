 <?php

class Akun extends CI_Controller
{
  function __construct(){
      parent::__construct();
      $this->load->model('Auth/Auth_model', 'm_auth');
      $this->load->model('MasterData/Akun_model', 'm_akun');
      if($this->session->userdata('login') != true){
          redirect('');
      }
  }
  //karyawan
  public function index(){
      $name  = $this->session->userdata('name');
      $role  = $this->session->userdata('role');
      $akun  = $this->m_akun->get_data();
      $this->load->view('Template/Header');
      $this->load->view('Admin/MasterData/akun', compact('role', 'name', 'akun'));
  }

  public function create(){
    $kodeAkun   = $this->m_akun->get_kode_akun();
    $checkKode  = $this->input->post('kode_akun');
    $checkNama  = $this->input->post('nama_akun');
    $Cvalidate  = $this->m_akun->validation_kode_akun($checkKode);
    $Nvalidate  = $this->m_akun->validation_nama_akun($checkNama);
    if($Cvalidate->num_rows() > 0 || $Nvalidate->num_rows() > 0){
      $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Kode Akun atau Nama Akun Tidak Boleh Sama','danger'));
    }else{
      $data = [
        'kode_akun' => $this->input->post('kode_akun'),
        'nama_akun' => $this->input->post('nama_akun')
      ];
      if($this->m_akun->insert($data)){
        $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
      }else{
        $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
      }
    }
    redirect('admin/akun');
  }

  public function update(){
    $data = [
      'nama_akun' => $this->input->post('nama_akun')
    ];
    $id   = $this->input->post('id');
    if($this->m_akun->update($data, $id)){
        $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
    }else{
        $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
    }
    redirect('admin/akun');
  }

  public function delete($id){
    if($this->m_akun->delete($id)){
      $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
    }else{
      $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
    }
      redirect('admin/akun');
  }
}