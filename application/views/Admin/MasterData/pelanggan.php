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
                    <h1 class="h3 mb-2 text-gray-800">Master Data Pelanggan</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                    <?php if($this->session->userdata('role') == 'superadmin'){ ?>
                        <div class="card-header py-3">
                            <div class="float-left">
                                <a type="button" href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#exampleModal">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">Tambah Pelanggan</span>
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
                                            <th>Nama Pelanggan </th>
                                            <th>Nomor Telepon Pelanggan </th>
                                            <th class="text-center"><i class="fas fa-cogs"></i> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($customers as $customer){?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $customer['customer_name'] ?></td>
                                            <td><?= strlen($customer['customer_phone']) > 0 ? $customer['customer_phone'] : '-' ?></td>
                                            <td class="text-center">
                                                <button href="javascript:void(0)" data-toggle="tooltip" title="Ubah" class="btn btn-warning"
                                                onclick="
                                                        edit(
                                                            '<?php echo $customer['id'] ?>',
                                                            '<?php echo $customer['customer_name'] ?>',
                                                            '<?php echo $customer['customer_phone'] ?>',
                                                            )">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <a onclick="return confirm('Hapus data ini ?')" href="<?php echo base_url("admin/pelanggan/delete/".$customer['id']) ?>" data-toggle="tooltip" title="Hapus" class="btn btn-danger">
                                                  <i class="fa fa-trash"></i>
                                                </a>             
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/pelanggan/add'); ?>" method="POST">
                    <div class="form-group">
                        <label>Nama Pelanggan </label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Nama Pelanggan" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon Pelanggan </label>
                        <input type="number" name="customer_phone" class="form-control" placeholder="Nomor Telepon Pelanggan" min="0" value="0" onkeyup="countChar(this)" id="phoneId">
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/pelanggan/edit'); ?>" method="POST">
                    <div class="form-group">
                        <label>Nama Pelanggan </label>
                        <input type="text" id="e_customer_name" name="customer_name" class="form-control" placeholder="Nama Pelanggan">
                        <input type="hidden" id="e_id" name="id" class="form-control" placeholder="Nama Pelanggan">
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon Pelanggan </label>
                        <input type="number" id="e_customer_phone" name="customer_phone" class="form-control" placeholder="Nomor Pelanggan">
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
function edit(id, customer_name, customer_phone){
  $('#e_id').val(id);
  $('#e_customer_name').val(customer_name);
  $('#e_customer_phone').val(customer_phone);

  $('#editModal').modal('show'); 
}

function countChar(val){
    var len = val.value.length
    if(len > 15){
        val.value = val.value.slice(0, -1)
        alert("Nomor Telepon Tidak Boleh Lebih Dari 15 Character")
        var id = $("#phoneId").append(val.value)
    }
}
</script>

</html>