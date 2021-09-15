<?php

class Persediaan extends CI_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->model('Auth/Auth_model', 'm_auth');
        $this->load->model('MasterData/Supplier_model', 'm_supplier');
        $this->load->model('Buku/Jurnal_model', 'm_jurnal');
        $this->load->model('Transaksi/Persediaan_model', 'm_persediaan');
        $this->load->model('MasterData/Stok_model', 'm_stok');
        $this->load->model('MasterData/Stok_child_model', 'm_child_stok');
        $this->load->model('Saldo_model', 'm_saldo');
        if($this->session->userdata('login') != true){
            redirect('');
        }
    }

    //dashboard
    public function index(){
        date_default_timezone_set("Asia/Jakarta");
        $date =  date('Y-m-d');
        $checkData   = date("Y-m-d", strtotime("+1 month"));
        // var_dump($checkData); die;
        $name        = $this->session->userdata('name');
        $role        = $this->session->userdata('role');
        $stok        = $this->m_stok->get_data();
        $suppliers   = $this->m_supplier->get_data();
        $persediaans = $this->m_persediaan->join_persediaan();
        $generate    = $this->m_persediaan->generate_code();
        $inputTgl    = "<input type='date' name='expired_date[]' class='form-control' placeholder='Tanggal Kadaluarsa' required min='".$checkData."'>";
        // var_dump($inputTgl); die;
        $this->load->view('Template/Header');
        $this->load->view('Transaksi/Pembelian/index', compact('name', 'persediaans', 'suppliers', 'date', 'role', 'stok', 'checkData', 'inputTgl', 'generate'));
    }
    
    public function add(){
        $date           = date_default_timezone_set("Asia/Jakarta");
        $id_supplier    = $_POST['id_supplier'];
        $idStok         = $_POST['id_stok'];
        $amount         = $_POST['jumlah'];
        $expired_date   = $_POST['expired_date'];
        $kode_pembelian = $_POST['kode_pembelian'];
        $totalPesanan   = count($id_supplier);
        $data           = [];
        $index = -1;
        foreach ($id_supplier as $rowSupplier) {
            $index++;
            $stok           = $this->m_stok->show($idStok[$index]);
            $unit_price     = intVal($stok->unit_price);
            $total_price    = $unit_price * intVal($amount[$index]);
            $arrData        = [
                'id_supplier'       => $rowSupplier,
                'id_stok'           => $idStok[$index],
                'jumlah'            => $amount[$index],
                'total_price'       => $total_price,
                'purchase_date'     => date('Y-m-d'),
                'expired_date'      => $expired_date[$index],
                'status'            => 'Belum Disetujui',
                'kode_pembelian'    => $this->m_persediaan->generate_code(),
            ];
            array_push($data, $arrData);
        }
        if($this->m_persediaan->multiple_insert($data)){
            $generate    = $this->m_persediaan->generate_code();
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Ditambahkan','success'));
        }else{
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-danger"><i class="fa fa-check-circle"></i></b> Data Gagal Ditambahkan','danger'));
        }
        redirect('transaksi/pembelian');
    }

    public function delete($id){
        $show = $this->m_persediaan->show($id);
        if($this->m_persediaan->delete($id)){
			$this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Dihapus','success'));
		}else{
			$this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Dihapus','danger'));
		}
        redirect('transaksi/pembelian');
    }

    public function update(){
        $id_persediaan   = $this->input->post('id');
        $nama_stok = $this->input->post('nama_stok');
        $stok = $this->m_stok->getByName($nama_stok);
        $jumlah_stok = intVal($stok->jumlah_stok);
        $jumlah = $this->input->post('jumlah');
        $saldo = $this->m_saldo->get_data();
        $sisaSaldo = $saldo->saldo_kas - $this->input->post('total_price');
        $totalPcs = $jumlah_stok + intVal($jumlah);
        if($this->input->post('status') == 'Disetujui'){
            $dataStok = [
                'id' => $stok->id,
                'nama_stok' => $nama_stok,
                'jumlah_stok' => $totalPcs,
                'unit_price'  => $stok->unit_price
            ];
            $updateStok = $this->m_stok->updateByName($dataStok, $nama_stok);
            $dataChild = [
                'id_stok' => $stok->id,
                'id_persediaan' => $id_persediaan,
                'sisa_stok'     => $jumlah
            ];
            $insertChild = $this->m_child_stok->insert($dataChild);
        }
        $data = [
            'id_persediaan' => $id_persediaan,
            'id_supplier'   => $this->input->post('id_supplier'),
            'jumlah'        => $jumlah,
            'total_price'   => $this->input->post('total_price'),
            'purchase_date' => $this->input->post('purchase_date'),
            'expired_date'  => $this->input->post('expired_date'),
            'status'        => $this->input->post('status')
        ];
        $jurnal1 = [
            'id_akun'       => 2,
            'id_penjualan'  => null,
            'id_persediaan' => $id_persediaan,
            'status_jurnal' => 'Debet',
            'jumlah'        => $this->input->post('total_price'),
            'tanggal_jurnal'=> date('Y-m-d')
        ];
        $jurnal2 = [
            'id_akun'       => 1,
            'id_penjualan'  => null,
            'id_persediaan' => $id_persediaan,
            'status_jurnal' => 'Kredit',
            'jumlah'        => $this->input->post('total_price'),
            'tanggal_jurnal'=> date('Y-m-d')
        ];
        $dataJurnal = [$jurnal1, $jurnal2];
        $dataUpdateSaldo = [
            'saldo_kas' => $sisaSaldo
        ];
        if($this->m_persediaan->update($data, $id_persediaan) && $this->m_jurnal->multiple_insert($dataJurnal) && $this->m_saldo->update($dataUpdateSaldo, 1)){
            $this->session->set_flashdata('alert_message', show_alert('<b class="text-success"><i class="fa fa-check-circle"></i></b> Data Berhasil Diubah','success'));
        }else{
            $this->session->set_flashdata('alert_message', show_alert('<i class="fa fa-times"></i> Data Gagal Diubah','danger'));
        }
        redirect('transaksi/pembelian');
    }
}