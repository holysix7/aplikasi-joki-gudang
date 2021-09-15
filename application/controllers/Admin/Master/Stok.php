<?php

class Stok extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('Auth/Auth_model', 'm_auth');
        $this->load->model('MasterData/Supplier_model', 'm_supplier');
        $this->load->model('MasterData/Customer_model', 'm_customer');
        $this->load->model('MasterData/Karyawan_model', 'm_karyawan');
        $this->load->model('MasterData/Stok_model', 'm_gudang');
        $this->load->model('MasterData/Table_model', 'm_meja');
        $this->load->model('Transaksi/Persediaan_model', 'm_persediaan');
        $this->load->model('MasterData/Stok_child_model', 'm_child_stok');
        if($this->session->userdata('login') != true){
            redirect('');
        }
    }
    
    public function index(){
        $name = $this->session->userdata('name');
        $role = $this->session->userdata('role');
        $data['stok'] = $this->m_gudang->get_data();
        // $abv = $this->m_child_stok->get_data_order(6);
        // var_dump($this->session->userdata('role')); die;
        $data['persediaan'] = $this->m_persediaan->get_data();
        $data['compare'] = [];
        foreach($data['stok'] as $stok){
            foreach($data['persediaan'] as $persediaan){
                if($stok['id'] == $persediaan['id_stok']){
                    $element = [
                        'id'            => $stok['id'],
                        'expired_date'  => $persediaan['expired_date'],
                        'status'        => $persediaan['status'],
                    ];
                    array_push($data['compare'], $element);
                }
            }
        }
        // var_dump($data['compare']); die;
        // var_dump($data); die;
        $this->load->view('Template/Header');
        $this->load->view('Admin/MasterData/Gudang/stok', compact('name', 'data', 'role'));
    }

    public function Persediaan(){
        $name = $this->session->userdata('name');
        $role = $this->session->userdata('role');
        $data['stok'] = $this->m_gudang->get_data();
        // $abv = $this->m_child_stok->get_data_order(6);
        // var_dump($this->session->userdata('role')); die;
        $data['persediaan'] = $this->m_persediaan->get_data();
        $data['compare'] = [];
        foreach($data['stok'] as $stok){
            foreach($data['persediaan'] as $persediaan){
                if($stok['id'] == $persediaan['id_stok']){
                    $element = [
                        'id'            => $stok['id'],
                        'expired_date'  => $persediaan['expired_date'],
                        'status'        => $persediaan['status'],
                    ];
                    array_push($data['compare'], $element);
                }
            }
        }
        // var_dump($data['compare']); die;
        // var_dump($data); die;
        $this->load->view('Template/Header');
        $this->load->view('Transaksi/Persediaan/index', compact('name', 'data', 'role'));
    }

    public function show($id){
        $name = $this->session->userdata('name');
        $role = $this->session->userdata('role');
        $data = $this->m_gudang->show($id);
        $childs = $this->m_child_stok->get_data($id);
        // var_dump($childs); die;
        $this->load->view('Template/Header');
        $this->load->view('Admin/MasterData/Gudang/stok_child', compact('name', 'data', 'role', 'childs'));
    }

    public function showPersediaan($id){
        $name = $this->session->userdata('name');
        $role = $this->session->userdata('role');
        $data = $this->m_gudang->show($id);
        $childs = $this->m_child_stok->get_data($id);
        // var_dump($childs); die;
        $this->load->view('Template/Header');
        $this->load->view('Transaksi/Persediaan/show', compact('name', 'data', 'role', 'childs'));
    }

    public function add(){
        $nama_stok      = $this->input->post('nama_stok');
        $jumlah_stok    = $this->input->post('jumlah_stok');
        $unit_price     = $this->input->post('unit_price');
        $data = [
            'nama_stok'     => $nama_stok,
            'jumlah_stok'   => $jumlah_stok,
            'unit_price'    => $unit_price,
        ];
        if($this->m_gudang->insert($data)){
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
        }else{
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
        }
        redirect('admin/gudang');
    }

    public function editGudang(){
        $data = $this->input->post();
        $id   = $data['id'];
        if($this->m_gudang->update($data, $id)){
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
        }else{
            $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
        }
        redirect('admin/gudang');
    }

    public function delete($id){
        if($this->m_gudang->delete($id)){
			$this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
		}else{
			$this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
		}
        redirect('admin/gudang');
    }
}