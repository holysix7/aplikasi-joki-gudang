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
                    <h1 class="h3 mb-2 text-gray-800">Penjualan</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="float-left">
                                <a type="button" href="#" class="btn btn-success btn-icon-split" data-toggle="modal" data-target="#exampleModal">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span class="text">Tambah Penjualan</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No </th>
                                            <th>Kode Penjualan </th>
                                            <th>Nama Pelanggan </th>
                                            <th>Nomor Meja </th>
                                            <th>Total Harga </th>
                                            <th>Tanggal Penjualan </th>
                                            <th>Status Meja </th>
                                            <th class="text-center"><i class="fas fa-cogs"></i> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                            foreach ($penjualan as $row){
                                            if($row['status_penjualan'] == 'Show'){
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['kode_penjualan'] ?></td>
                                            <td><?= $row['customer_name'] ?></td>
                                            <td><?= $row['table_number'] ?></td>
                                            <td class="text-right" style="width:11%"><?= format_rp($row['total_harga']) ?></td>
                                            <td style="width:16%"><?= date("d-M-Y h:i:s", strtotime($row['tanggal_penjualan'])) ?></td>
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
                                            <td style="width:11%" class="text-center">
                                                <!-- <button href="javascript:void(0)" data-toggle="modal" data-target="#editModal" title="Ubah" class="btn btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </button> -->
                                                <button href="javascript:void(0)" data-toggle="tooltip" title="Ubah" class="btn btn-warning"
                                                onclick="
                                                        edit(
                                                            '<?php echo $row['id_penjualan'] ?>',
                                                            '<?php echo $row['id_meja'] ?>',
                                                            '<?php echo $row['kode_penjualan'] ?>',
                                                            '<?php echo $row['customer_name'] ?>',
                                                            '<?php echo $row['table_number'] ?>',
                                                            '<?php echo $row['total_harga'] ?>',
                                                            '<?php echo date('d-M-Y h:i:s', strtotime($row['tanggal_penjualan'])) ?>',
                                                            )">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <a href="<?php echo base_url("transaksi/penjualan/rincian/".$row['id_penjualan']) ?>" data-toggle="tooltip" class="btn btn-success">
                                                  <i class="fa fa-book"></i>
                                                </a>             
                                            </td>
                                        </tr>
                                            <?php } ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Penjualan</h5>
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
                        <span class="text">Tambah Form Penjualan</span>
                    </a><br><br>
                    <div class="form-group">
                        <label>Nama Pelanggan </label>
                        <select required class="form-control" name="id_pelanggan" id="idPelanggan">
                            <option value="">-- Pilih --</option>
                        <?php foreach ($pelanggan as $rowPelanggan) { ?>
                          <?php if(count($rowPelanggan) > 0){ ?>
                            <option value="<?= $rowPelanggan['id'] ?>"><?= $rowPelanggan['customer_name'] ?></option>
                          <?php } ?>
                        <?php } ?>
                        </select>
                        <input type="hidden" name="idPelangganAjax" id="idPelangganValue">
                    </div>
                    <div class="form-group">
                        <label>Nomor Meja</label>
                        <div id="dataIdMeja">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <select name="id_menu[]" class="form-control" placeholder="Nama Bahan" required id="id_menu">
                            <option value="null">-- Pilih --</option>
                            <?php foreach($menu as $rowMenu){ ?>
                                <option value="<?= $rowMenu['id'] ?>"><?= $rowMenu['nama_menu'] ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Level Pedas</label>
                        <select name="id_pedas[]" class="form-control" placeholder="Nama Bahan" id="id_pedas">
                            <option value="null">-- Pilih --</option>
                            <?php $i = 1; foreach($lvPedas as $rowPedas){ ?>
                                <option value="<?= $rowPedas['id'] ?>"><?= $rowPedas['lvl_pedas'] ?> - <?= $i++ ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <div class="form-group">
                        <label>Jenis Kuah</label>
                        <select name="id_kuah[]" class="form-control" placeholder="Nama Bahan" id="id_kuah">
                            <option value="null">-- Pilih --</option>
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
                        <input type="hidden" name="kode_penjualan" class="form-control" value="<?= $generate ?>">
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ubah Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url('transaksi/penjualan/update'); ?>" method="POST">
                    <div class="form-group">
                        <label>Kode Penjualan </label>
                        <input type="text" name="" id="e_kode_penjualan" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama Pelanggan </label>
                        <input type="hidden" name="id_penjualan" id="e_id" class="form-control" placeholder="Nama Karyawan" required readonly>
                        <input type="hidden" name="id_meja" id="e_id_meja" class="form-control" placeholder="Nama Karyawan" required readonly>
                        <input type="hidden" name="status_penjualan" id="e_status_penjualan" class="form-control" value="Hide" required readonly>
                        <input type="text" name="customer_name" id="e_customer_name" class="form-control" placeholder="Nama Pelanggan" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Nomor Meja </label>
                        <input type="number" name="" id="e_table_number" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Total Harga </label>
                        <input type="number" name="total_harga" id="e_total_harga" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Penjualan </label>
                        <input type="text" name="" id="e_tanggal_penjualan" class="form-control" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Status Meja </label>
                        <input type="text" name="table_status" id="e_table_status" value="Tidak Diisi" class="form-control" required readonly>
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
    $(document).ready(function(){ // Ketika halaman sudah diload dan siap
        $("#btn-tambah-form").click(function(){ // Ketika tombol Tambah Data Form di klik
            var jumlah = parseInt($("#jumlah-form").val()); // Ambil jumlah data form pada textbox jumlah-form
            var nextform = jumlah + 1; // Tambah 1 untuk jumlah form nya
        
        // Kita akan menambahkan form dengan menggunakan append
        // pada sebuah tag div yg kita beri id insert-form
            $("#insert-form").append(
                "<div class='form-group'><label>Nama Menu Ke-</label>" + nextform +
                "<select name='id_menu[]' class='form-control' placeholder='Nama Bahan' id='id_child_menu' required>" +
                "<option value=''>-- Pilih --</option>" +
                "<?php foreach($menu as $rowMenu){?><option value='<?= $rowMenu["id"] ?>'><?= $rowMenu['nama_menu'] ?></option><?php } ?> </select></div>" +
                "<div class='form-group'><label>Level Pedas Menu Ke-</label>" + nextform + "<select name='id_pedas[]' class='form-control' placeholder='Nama Bahan'><option value=''>-- Pilih --</option><?php $i = 1; foreach($lvPedas as $rowPedas){ ?><option value='<?= $rowPedas['id'] ?>'>" + "<?= $rowPedas['lvl_pedas'] ?>" + " - <?= $i++ ?></option><?php } ?></select></div>" +
                "<div class='form-group'><label>Jenis Kuah Menu Ke-</label>" + nextform + "<select name='id_kuah[]' class='form-control' placeholder='Nama Bahan'><option value=''>-- Pilih --</option><?php $i = 1; foreach($kuah as $rowKuah){ ?><option value='<?= $rowKuah['id'] ?>''><?= $rowKuah['nama_kuah'] ?></option><?php } ?></select></div>" +
                "<div class='form-group'><label>Jumlah Menu Ke-</label>" + nextform + "<input type='number' name='jumlah[]' class='form-control' placeholder='Jumlah' required min=1></div>");
            
            $("#jumlah-form").val(nextform); // Ubah value textbox jumlah-form dengan variabel nextform
        });

        $("#id_menu").change(function() {
            if(this.value == 28){
                $("#id_kuah").prop('disabled', 'disabled')
                $("#id_pedas").prop('disabled', 'disabled')
            }else{
                $("#id_kuah").removeAttr('disabled')
                $("#id_pedas").removeAttr('disabled')
            }
        })
        $("#id_child_menu").change(function() {
            if(this.value == 28){
                $("#id_kuah").prop('disabled', 'disabled')
                $("#id_pedas").prop('disabled', 'disabled')
            }else{
                $("#id_kuah").removeAttr('disabled')
                $("#id_pedas").removeAttr('disabled')
            }
        })

        var status_meja = true
        $('#dataIdMeja').append(
            "<select name='id_meja' class='form-control' placeholder='Nomor Meja' required id='idMeja'>" + 
            "<option value=''>-- Pilih --</option>" +
            "<?php foreach($meja as $rowMeja){ ?><option value='<?= $rowMeja['id'] ?>'><?= $rowMeja['table_number'] ?> - <?= $rowMeja['table_status'] ?></option><?php } ?>" +
            "</select>"
        )
        $('#idPelanggan').change(function(){
            // console.log('ini id pelanggan: ' + $('#idPelanggan').val())
            var user_id = $('#idPelanggan').val()
            // console.log(user_id)
            var getUrl = window.location;
            var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
            $.get(baseUrl+"/admin/user-penjualan/ajax/"+user_id, function(data, status){
                if(data != null){
                    console.log(data.id_meja)
                    // var element = JSON.parse(data)
                    $('#dataIdMeja').html("")
                    $('#idPelangganValue').val(data.id_pelanggan)
                    $('#dataIdMeja').append(
                        "<input name='id_meja' class='form-control' readonly value='"+ data.id_meja +"'>"
                    )
                    $('#idMeja').val(data.id_meja)
                }else{
                    $('#idPelangganValue').val("")
                    $('#dataIdMeja').html("")
                    $('#dataIdMeja').append(
                        "<select name='id_meja' class='form-control' placeholder='Nomor Meja' required id='idMeja'>" + 
                        "<option value=''>-- Pilih --</option>" +
                        "<?php foreach($meja as $rowMeja){ ?><option value='<?= $rowMeja['id'] ?>'><?= $rowMeja['table_number'] ?> - <?= $rowMeja['table_status'] ?></option><?php } ?>" +
                        "</select>"
                    )
                }
            });
        })
    });

function edit(id_penjualan, id_meja, kode_penjualan, customer_name, table_number, total_harga, tanggal_penjualan){
  $('#e_id').val(id_penjualan);
  $('#e_id_meja').val(id_meja);
  $('#e_kode_penjualan').val(kode_penjualan);
  $('#e_customer_name').val(customer_name);
  $('#e_table_number').val(table_number);
  $('#e_total_harga').val(total_harga);
  $('#e_tanggal_penjualan').val(tanggal_penjualan);

  $('#editModal').modal('show'); 
}
$(document).on('click', '#btn-rincian-penjualan', function() {
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    var idPenjualan = $(this).data('id')
    $('#editModal').modal('show')   
    
    // $.get(baseUrl+"/admin/penjualan/ajax/"+idPenjualan, function(data, status){
    //     var element = JSON.parse(data)    
    //     $.each(element, function(i, item){
    //         console.log(i.item)
    //         $('#id_penjualan').text(item.id_penjualan)
    //         $('#nama-menu').text(item.nama_menu)
    //     })
        // $('#ttl_ibu').text(element.ot_ib_tempat_lahir+', '+element.ot_ib_tanggal_lahir)
        // $('#no_telp_ibu').text(element.ot_ib_no_telp)
        // $('#agama_ibu').text(element.ot_ib_agama)
        // $('#pekerjaan_ibu').text(element.ot_ib_pekerjaan)
        // $('#pendidikan_ibu').text(element.ot_ib_pendidikan)

        // $('#nama_lengkap_bapak').text(element.ot_bpk_nama_lengkap)
        // $('#ttl_bapak').text(element.ot_bpk_tempat_lahir+', '+element.ot_bpk_tanggal_lahir)
        // $('#no_telp_bapak').text(element.ot_bpk_no_telp)
        // $('#agama_bapak').text(element.ot_bpk_agama)
        // $('#pekerjaan_bapak').text(element.ot_bpk_pekerjaan)
        // $('#pendidikan_bapak').text(element.ot_bpk_pendidikan)
    // });
})
</script>

</html>