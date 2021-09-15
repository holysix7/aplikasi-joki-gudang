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
                    <h1 class="h3 mb-2 text-gray-800">Master Data Meja</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                    <?php if($this->session->userdata('role') == 'superadmin'){ ?>
                        <div class="card-header py-3">
                            <div class="float-left">
                                <a type="button" href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#exampleModal">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">Tambah Meja</span>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No </th>
                                            <th class="text-center">Nomor Meja </th>
                                            <th class="text-center">Jenis Meja </th>
                                            <th class="text-center">Status Meja </th>
                                            <th class="text-center"><i class="fas fa-cogs"></i> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($meja as $row){?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= $row['table_number'] ?></td>
                                            <td class="text-center"><?= $row['table_type'] ?></td>
                                            <td class="text-center">
                                            <?php if($row['table_status'] == 'Sedang Diisi'){ ?>
                                                <span class="badge badge-primary" style="height: 20px width: 20px">
                                                    <?= $row['table_status'] ?>
                                                </span>
                                            <?php }else{ ?>
                                                <span class="badge badge-warning" style="height: 20px width: 20px">
                                                    <?= $row['table_status'] ?>
                                                </span>
                                            <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <button href="javascript:void(0)" data-toggle="tooltip" title="Ubah" class="btn btn-warning"
                                                onclick="
                                                        edit(
                                                            '<?php echo $row['id'] ?>',
                                                            '<?php echo $row['table_number'] ?>',
                                                            '<?php echo $row['table_type'] ?>',
                                                            '<?php echo $row['table_status'] ?>',
                                                            )">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <?php if($role == 'superadmin'){ ?>
                                                <a onclick="return confirm('Hapus data ini ?')" href="<?php echo base_url("admin/tables/delete/".$row['id']) ?>" data-toggle="tooltip" title="Hapus" class="btn btn-danger">
                                                  <i class="fa fa-trash"></i>
                                                </a>             
                                                <?php } ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Meja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/tables/add'); ?>" method="POST">
                    <div class="form-group">
                        <label>Nomor Meja </label>
                        <input type="number" name="table_number" class="form-control" value="<?= $generate ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jenis Meja </label>
                        <input type="text" name="table_type" class="form-control" placeholder="Jenis Meja" required>
                    </div>
                    <div class="form-group">
                        <label>Status Meja </label>
                        <input type="text" name="table_status" class="form-control" placeholder="Status Meja" value="Tidak Diisi" required readonly>
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
                <h5 class="modal-title" id="exampleModalLabel">Ubah Data Meja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/tables/edit'); ?>" method="POST">
                    <div class="form-group">
                        <label>Nomor Meja </label>
                        <input type="text" id="e_table_number" name="table_number" class="form-control" placeholder="Nama Pelanggan">
                        <input type="hidden" id="e_id" name="id" class="form-control" placeholder="Nomor Meja">
                    </div>
                    <div class="form-group">
                        <label>Jenis Meja </label>
                        <input type="text" id="e_table_type" name="table_type" class="form-control" placeholder="Jenis Meja">
                    </div>
                    <div class="form-group">
                        <label>Status Meja </label>
                        <select class="form-control" name="table_status" id="e_table_status">
                            <option value="Sedang Diisi">Sedang Diisi</option>
                            <option value="Tidak Diisi">Tidak Diisi</option>
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
</body>

<script type="text/javascript">
function edit(id, table_number, table_type, table_status){
  $('#e_id').val(id);
  $('#e_table_number').val(table_number);
  $('#e_table_type').val(table_type);
  $('#e_table_status').val(table_status);

  $('#editModal').modal('show'); 
}
</script>

</html>