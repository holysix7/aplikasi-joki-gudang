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
                    <h1 class="h3 mb-2 text-gray-800">Laporan Penjualan </h1>
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="float-left">
                            </div>
                        </div>
                        <div class="card-body text-center">
                          <h5 class="card-title font-weight-bold">Laporan Penjualan</h5>
                          <h5 class="card-title font-weight-bold">Ramen AA</h5>
                          <p class="card-text font-weight-bold">Jl. Raya Cicalengka - Majalaya No.229, Sukamanah, Kec. Paseh, Bandung, Jawa Barat 40392</p>
                        </div>
                        <div class="card-footer text-center">
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="float-left">
                                <!-- <button class="btn btn-primary" id="btnExport" onclick="fnExcelReport()"> EXPORT </button> -->
                                <button class="btn btn-primary" id="btnExport" onclick="exportKedua()"> EXPORT </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <input class="form-control" name="start_date" type="date" id="id_start_date">
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control" name="end_date" type="date" id="id_end_date">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No </th>
                                            <th>Kode Penjualan </th>
                                            <th>Tanggal Penjualan </th>
                                            <th>Sub Total </th>
                                        </tr>
                                    </thead>
                                    <tbody id="content_id">
                                    </tbody>
                                    <tfoot id="tFootId">
                                    </tfoot>
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
</body>

<script type="text/javascript">
    $(document).ready(function(){   
        var start_date = null
        var end_date = null
        $('#id_start_date').change(function(){
            start_date = $('#id_start_date').val()
            // console.log(start_date)
        })
        
        function addCommas(nStr){
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
        function format_rp(value){
            if($.isNumeric(value) == false){
                return null;
            } 
            var jumlah_desimal="0";
            var pemisah_desimal="";
            var pemisah_ribuan=".";
            var angka="Rp " + addCommas(value, jumlah_desimal, pemisah_desimal, pemisah_ribuan);
            return angka;
        }
        function format_angka(valuea){
            var angka = preg_replace("/[^0-9]/", "", valuea);
            return angka*1;
        }

        $('#id_end_date').change(function(){
            end_date = $('#id_end_date').val()
            // console.log($('#example').innerHTML)
            // console.log(end_date)
            if(start_date != null || end_date != null){
                $('#content_id').html("")
                $('#tFootId').html("")
                var getUrl = window.location;
                var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                $.get(baseUrl+"/laporan/ajax/"+start_date+"/"+end_date+"/"+"penjualan", function(data, status){
                    if(data != null){
                        if(data.data_pembelian.length > 0){
                            var arrData = data.data_pembelian
                            var number = 1
                            var newArrayBody = []
                            var newArrayFooter = "<tr>" +
                            "<th colspan='3'>Jumlah</th>" +
                            "<th class='text-right'>"+ format_rp(data.total_pembelian) +"</th>" +
                            "</tr>"
                            arrData.map(function(element){
                                var dateFormatPHP = new Date(element.tanggal_penjualan)
                                var Day = dateFormatPHP.getDate()
                                var Month = dateFormatPHP.getMonth()
                                var Year = dateFormatPHP.getFullYear()
                                Month += 1
                                if(Month > 9){
                                    var fixedDate = Day + "-" + Month + "-" + Year
                                }else{
                                    var fixedDate = Day + "-" + "0" + Month + "-" + Year
                                }
                                console.log(fixedDate)
                                var numberPlusOne = number++
                                var newObject = "<tr>" +
                                    "<td>"+ numberPlusOne +"</td>" +
                                    "<td>"+ element.kode_penjualan +"</td>" +
                                    "<td>"+ fixedDate +"</td>" +
                                    "<td class='text-right'>"+ format_rp(element.total_harga) +"</td>" +
                                "</tr>"
                                newArrayBody.push(newObject)
                            })
                            $('#content_id').append(newArrayBody);
                            $('#tFootId').append(newArrayFooter);
                        }else{
                            var newArrayBody = []
                            if(start_date == end_date){
                                var newObject = "<tr>" +
                                    "<td colspan='4' class='text-center'>--- Tidak Ada Data Di Tanggal <b>"+ start_date +"</b> ---</td>" +
                                "</tr>"

                            }else{
                                var newObject = "<tr>" +
                                    "<td colspan='4' class='text-center'>--- Tidak Ada Data Di Tanggal <b>"+ start_date +" - "+ end_date +"</b> ---</td>" +
                                "</tr>"
                            }
                            newArrayBody.push(newObject)
                            $('#content_id').append(newArrayBody);
                        }
                    }
                });
            }else{
                var getUrl = window.location;
                var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                $.get(baseUrl+"/buku-besar/kas/ajax/", function(data, status){
                    if(data != null){
                        console.log(data.saldo_kas)
                        // var element = JSON.parse(data)
                        // $('#dataIdMeja').html("")
                        // $('#idPelangganValue').val(data.id_pelanggan)
                        // $('#dataIdMeja').append(
                        //     "<input name='id_meja' class='form-control' readonly value='"+ data.id_meja +"'>"
                        // )
                        // $('#idMeja').val(data.id_meja)
                    }
                });
            }
        })
    });
</script>
<script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
<script type="text/javascript">
    function exportKedua(){
        $('#example').table2excel({
            filename: "Ramen AA Laporan Penjualan"
        });
    }
</script>

</html>