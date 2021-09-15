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
                    <h1 class="h3 mb-2 text-gray-800">Master Data Menu</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                    <?php if($this->session->userdata('role') == 'superadmin'){ ?>
                        <div class="card-header py-3">
                            <div class="float-left">
                                <a type="button" href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#exampleModal">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">Tambah Menu</span>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No </th>
                                            <th>Nama Menu </th>
                                            <th>Harga Menu </th>
                                            <th>Jenis Menu </th>
                                            <th class="text-center"><i class="fas fa-cogs"></i> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($menu as $row){?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['nama_menu'] ?></td>
                                            <td class="text-right"><?= format_rp($row['harga_menu']) ?></td>
                                            <td><?= $row['jenis_menu'] ?></td>
                                            <td class="text-center">
                                                <button href="javascript:void(0)" data-toggle="tooltip" title="Ubah" class="btn btn-warning"
                                                onclick="
                                                        edit(
                                                            '<?php echo $row['id'] ?>',
                                                            '<?php echo $row['nama_menu'] ?>',
                                                            '<?php echo $row['harga_menu'] ?>',
                                                            '<?php echo $row['jenis_menu'] ?>',
                                                            )">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <a onclick="return confirm('Hapus data ini ?')" href="<?php echo base_url("admin/menu/delete/".$row['id']) ?>" data-toggle="tooltip" title="Hapus" class="btn btn-danger">
                                                  <i class="fa fa-trash"></i>
                                                </a>             
                                                <!-- <a href="<?php echo base_url("admin/menu/show/".$row['id']) ?>" data-toggle="tooltip" title="Show" class="btn btn-success">
                                                  <i class="fa fa-search"></i>
                                                </a>              -->
                                            </td>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/menu/add'); ?>" method="POST">
                    <div class="form-group">
                        <label>Nama Menu </label>
                        <input type="text" name="nama_menu" class="form-control" placeholder="Nama Menu" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Menu </label>
                        <!-- <select class="form-control" name="jenis_menu" id="jenis_menu">
                            <option value="">-- Pilih --</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                        </select> -->
                        <input type="text" name="jenis_menu" class="form-control" placeholder="Jenis Menu" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Bahan 1 </label>
                        <select required class="form-control" name="id_bahan_1" id="id_bahan_1">
                        <option value="">-- Pilih --</option>
                        <?php foreach ($bahan as $bahrow) { ?>
                            <option value="<?= $bahrow['id'] ?>"><?= $bahrow['nama_stok'] ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Bahan 2 </label>
                        <select required class="form-control" name="id_bahan_2" id="id_bahan_2">
                        <option value="">-- Pilih --</option>
                        <?php foreach ($bahan as $bahrow2) { ?>
                            <option value="<?= $bahrow2['id'] ?>"><?= $bahrow2['nama_stok'] ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Bahan 3 </label>
                        <select class="form-control" name="id_bahan_3" id="id_bahan_3">
                        <option value="">-- Pilih --</option>
                        <?php foreach ($bahan as $bahrow3) { ?>
                            <option value="<?= $bahrow3['id'] ?>"><?= $bahrow3['nama_stok'] ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Bahan 4 </label>
                        <select class="form-control" name="id_bahan_4" id="id_bahan_4">
                        <option value="">-- Pilih --</option>
                        <?php foreach ($bahan as $bahrow4) { ?>
                            <option value="<?= $bahrow4['id'] ?>"><?= $bahrow4['nama_stok'] ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Bahan 5 </label>
                        <select class="form-control" name="id_bahan_5" id="id_bahan_5">
                        <option value="">-- Pilih --</option>
                        <?php foreach ($bahan as $bahrow5) { ?>
                            <option value="<?= $bahrow5['id'] ?>"><?= $bahrow5['nama_stok'] ?></option>
                        <?php } ?>
                        </select>
                    </div>
                <hr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/menu/edit'); ?>" method="POST">
                    <div class="form-group">
                        <label>Nama Menu </label>
                        <input type="text" id="e_nama_menu" name="nama_menu" class="form-control" placeholder="Nama Menu">
                        <input type="hidden" id="e_id" name="id" class="form-control" placeholder="Nama Pelanggan">
                    </div>
                    <div class="form-group">
                        <label>Harga Menu </label>
                        <input type="number" id="e_harga_menu" name="harga_menu" class="form-control" placeholder="Harga Menu">
                    </div>
                    <div class="form-group">
                        <label>Jenis Menu </label>
                        <input type="text" id="e_jenis_menu" name="jenis_menu" class="form-control" placeholder="Harga Menu">
                    </div>
                <hr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</body>
<!-- <script src="assets/vendor/jquery/jquery.min.js"></script> -->

<script type="text/javascript">
function edit(id, nama_menu, harga_menu, jenis_menu){
  $('#e_id').val(id);
  $('#e_nama_menu').val(nama_menu);
  $('#e_harga_menu').val(harga_menu);
  $('#e_jenis_menu').val(jenis_menu);

  $('#editModal').modal('show'); 
}
</script>

</html>