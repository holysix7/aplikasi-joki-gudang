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
                    <h1 class="h3 mb-2 text-gray-800">Master Data Akun</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                    <?php if($this->session->userdata('role') == 'superadmin'){ ?>
                        <div class="card-header py-3">
                            <div class="float-left">
                                <a type="button" href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#exampleModal">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">Tambah Data Akun</span>
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
                                            <th>Kode Akun </th>
                                            <th>Nama Akun </th>
                                            <!-- <th class="text-center"><i class="fas fa-cogs"></i> </th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($akun as $row){?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['kode_akun'] ?></td>
                                            <td><?= $row['nama_akun'] ?></td>
                                            <!-- <td class="text-center">
                                                <button href="javascript:void(0)" data-toggle="tooltip" title="Ubah" class="btn btn-warning"
                                                onclick="
                                                        edit(
                                                            '<?php echo $row['id'] ?>',
                                                            '<?php echo $row['kode_akun'] ?>',
                                                            '<?php echo $row['nama_akun'] ?>',
                                                            )">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </td> -->
                                                <!-- <a onclick="return confirm('Hapus data ini ?')" href="<?php echo base_url("admin/akun/delete/".$row['id']) ?>" data-toggle="tooltip" title="Hapus" class="btn btn-danger">
                                                  <i class="fa fa-trash"></i>
                                                </a>              -->
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/akun/add'); ?>" method="POST">
                    <div class="form-group">
                        <label>Kode Akun </label>
                        <input type="number" name="kode_akun" class="form-control" placeholder="Kode Akun" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Akun </label>
                        <input type="text" name="nama_akun" class="form-control" placeholder="Nama Akun" required>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Akun</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/akun/edit'); ?>" method="POST">
                    <div class="form-group">
                        <label>Kode Akun </label>
                        <input type="hidden" name="id" id="e_id" class="form-control" required>
                        <input type="text" name="kode_akun" id="e_kode_akun" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Akun </label>
                        <input type="text" name="nama_akun" id="e_nama_akun" class="form-control" required>
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
function edit(id, kode_akun, nama_akun){
  $('#e_id').val(id);
  $('#e_kode_akun').val(kode_akun);
  $('#e_nama_akun').val(nama_akun);

  $('#editModal').modal('show'); 
}
</script>

</html>