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
                    <h1 class="h3 mb-2 text-gray-800">Persediaan</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No </th>
                                            <th>Nama Stok </th>
                                            <th>Jumlah Stok </th>
                                            <th>Harga Per Unit </th>
                                            <th>Tanggal Kadaluarsa </th>
                                            <th class="text-center"><i class="fas fa-cog"></i></th>
                                            <!-- <th class="text-center"><i class="fas fa-cogs"></i> </th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($data['stok'] as $stok){?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $stok['nama_stok'] ?></td>
                                            <td class="text-right"><?= $stok['jumlah_stok'] ?></td>
                                            <td class="text-right"><?= format_rp($stok['unit_price']) ?></td>
                                            <td>
                                                <?php if($stok['jumlah_stok'] > 0){?>
                                                    <?php foreach($data['compare'] as $compare){ ?>
                                                        <?php if($stok['id'] == $compare['id'] && $compare['status'] == 'Disetujui'){ ?>
                                                            <?php if(count($stok) > 1){ ?>
                                                                <?= date("d-m-Y", strtotime($compare['expired_date'])) ?>,
                                                            <?php }else{ ?>
                                                                <?= date("d-m-Y", strtotime($compare['expired_date'])) ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php }else{ ?>
                                                    Belum ada stok
                                                <?php } ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if($stok['jumlah_stok'] > 0){ ?>
                                                    <a href="<?= base_url('transaksi/persediaan//'.$stok['id']) ?>" class="btn btn-primary">Show</a>
                                                <?php }else{ ?>
                                                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="tooltip" onclick="showNoData()">Show</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Stok</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('admin/gudang/add'); ?>" method="POST">
                    <div class="form-group">
                        <label>Nama Stok </label>
                        <input type="text" name="nama_stok" class="form-control" placeholder="Nama Stok" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Stok </label>
                        <input type="number" name="jumlah_stok" class="form-control" value="0" readonly>
                    </div>
                    <div class="form-group">
                        <label>Harga Per Unit </label>
                        <input type="number" name="unit_price" class="form-control" placeholder="Harga Per Unit" required>
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
function showNoData(){
    alert("Belum Ada Stok")
}
</script>

</html>