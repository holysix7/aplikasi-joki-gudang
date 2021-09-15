<!DOCTYPE html>
<html lang="en">

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php $this->load->view('Template/Sidebar') ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?php $this->load->view('Template/alertMessage') ?>
                <!-- Topbar -->
                <?php $this->load->view('Template/Topbar') ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Data Item </h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="float-left">
                                <a type="button" href="<?= base_url('transaksi/penjualan') ?>" class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-arrow-left"></i>
                                    </span>
                                    <span class="text">Kembali</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No </th>
                                            <th>Nama Menu </th>
                                            <th>Level Pedas </th>
                                            <th>Nama Kuah </th>
                                            <th>Jumlah (Qty) </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                            foreach ($data as $row){
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama_menu'] ?></td>
                                            <td><?= $row['id_pedas'] != null ? $row['lvl_pedas'] : "-" ?></td>
                                            <td><?= $row['id_kuah'] != null ? $row['nama_kuah'] : "-" ?></td>
                                            <td><?= $row['jumlah'] ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <!-- Button trigger modal -->
<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('transaksi/penjualan/add'); ?>" method="POST">
                    <a type="button" href="#" class="btn btn-success btn-icon-split" id="btn-tambah-form">
                        <span class="icon text-white-50">
                            <i class="fas fa-plus"></i>
                        </span>
                        <span class="text">Tambah Form</span><br><br>
                    </a>
                    <div class="form-group">
                        <label>Nama Pelanggan </label>
                        <select required class="form-control" name="id_pelanggan">
                            <option value="">-- Pilih --</option>
                        <?php foreach ($pelanggan as $rowPelanggan) { ?>
                          <?php if(count($rowPelanggan) > 0){ ?>
                            <option value="<?= $rowPelanggan['id'] ?>"><?= $rowPelanggan['customer_name'] ?></option>
                          <?php } ?>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Meja</label>
                        <select name="id_meja" class="form-control" placeholder="Nomor Meja" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach($meja as $rowMeja){ ?>
                                <option value="<?= $rowMeja['id'] ?>"><?= $rowMeja['table_number'] ?> - <?= $rowMeja['table_status'] ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <select name="id_menu[]" class="form-control" placeholder="Nama Bahan" required>
                            <option value="">-- Pilih --</option>
                            <?php foreach($menu as $rowMenu){ ?>
                                <option value="<?= $rowMenu['id'] ?>"><?= $rowMenu['nama_menu'] ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Level Pedas</label>
                        <select name="id_pedas[]" class="form-control" placeholder="Nama Bahan">
                            <option value="">-- Pilih --</option>
                            <?php $i = 1; foreach($lvPedas as $rowPedas){ ?>
                                <option value="<?= $rowPedas['id'] ?>"><?= $rowPedas['lvl_pedas'] ?> - <?= $i++ ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Jenis Kuah</label>
                        <select name="id_kuah[]" class="form-control" placeholder="Nama Bahan">
                            <option value="">-- Pilih --</option>
                            <?php $i = 1; foreach($kuah as $rowKuah){ ?>
                                <option value="<?= $rowKuah['id'] ?>"><?= $rowKuah['nama_kuah'] ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Jumlah </label>
                        <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" required min=1>
                        <input type="hidden" name="tanggal_penjualan" class="form-control" value="<?= $date ?>">
                        <input type="hidden" name="status_penjualan" class="form-control" value="Show">
                    </div>
                    <div class="form-group" id="insert-form">
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                <input type="hidden" id="jumlah-form" value="1">
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
$(document).ready(function(){ // Ketika halaman sudah diload dan siap
    $("#btn-tambah-form").click(function(){ // Ketika tombol Tambah Data Form di klik
      var jumlah = parseInt($("#jumlah-form").val()); // Ambil jumlah data form pada textbox jumlah-form
      var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya
      
      // Kita akan menambahkan form dengan menggunakan append
      // pada sebuah tag div yg kita beri id insert-form
      $("#insert-form").append(
        "<div class='form-group'><label>Nama Menu Ke-</label>" + nextform +
        "<select name='id_menu[]' class='form-control' placeholder='Nama Bahan' required>" +
        "<option value=''>-- Pilih --</option>" +
        "<?php foreach($menu as $rowMenu){?><option value='<?= $rowMenu["id"] ?>'><?= $rowMenu['nama_menu'] ?></option><?php } ?> </select></div>" +
        "<div class='form-group'><label>Level Pedas Menu Ke-</label>" + nextform + "<select name='id_pedas[]' class='form-control' placeholder='Nama Bahan'><option value=''>-- Pilih --</option><?php $i = 1; foreach($lvPedas as $rowPedas){ ?><option value='<?= $rowPedas['id'] ?>'>" + "<?= $rowPedas['lvl_pedas'] ?>" + " - <?= $i++ ?></option><?php } ?></select></div>" +
        "<div class='form-group'><label>Jenis Kuah Menu Ke-</label>" + nextform + "<select name='id_kuah[]' class='form-control' placeholder='Nama Bahan'><option value=''>-- Pilih --</option><?php $i = 1; foreach($kuah as $rowKuah){ ?><option value='<?= $rowKuah['id'] ?>''><?= $rowKuah['nama_kuah'] ?></option><?php } ?></select></div>" +
        "<div class='form-group'><label>Jumlah Menu Ke-</label>" + nextform + "<input type='number' name='jumlah[]' class='form-control' placeholder='Jumlah' required min=1></div>");
      
      $("#jumlah-form").val(nextform); // Ubah value textbox jumlah-form dengan variabel nextform
    });
  });
</script>

</html>