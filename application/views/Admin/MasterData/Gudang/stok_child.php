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
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="col" style="padding:25px">
                                <div class="row">
                                    <div class="col-sm-3" style="padding-top:10px">Nama Stok:</div>
                                    <div class="col-sm-3"><input value="<?= $data->nama_stok ?>" class="form-control" readonly></div>
                                    <div class="col-sm-3" style="padding-top:10px">Harga Stok:</div>
                                    <div class="col-sm-3"><input value="<?= format_rp($data->unit_price) ?>" class="form-control text-right" readonly></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No </th>
                                            <th>Jumlah Stok </th>
                                            <th>Tanggal Kadaluarsa </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($childs as $row){?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td class="text-right"><?= $row['sisa_stok'] ?></td>
                                            <td><?= date("d-m-Y", strtotime($row['expired_date'])) ?></td>
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