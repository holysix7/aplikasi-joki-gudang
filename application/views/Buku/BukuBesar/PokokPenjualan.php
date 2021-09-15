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
                    <h1 class="h3 mb-2 text-gray-800">Buku Besar Pokok Penjualan </h1>

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
                                            <th>Tanggal </th>
                                            <th>Keterangan </th>
                                            <th>Ref </th>
                                            <th>Debet </th>
                                            <th>Kredit </th>
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
            console.log(start_date)
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
            console.log(end_date)
            if(start_date != null || end_date != null){
                $('#content_id').html("")
                $('#tFootId').html("")
                var getUrl = window.location;
                var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
                $.get(baseUrl+"/buku-besar/ajax/"+start_date+"/"+end_date+"/"+4, function(data, status){
                    if(data != null){
                        if(data.data_jurnal.length > 0){
                            var total_debit = 0
                            var total_kredit = 0
                            var arrData = data.data_jurnal
                            var number = 1
                            var newArrayBody = []
                            var newArrayFooter = "<tr>" +
                            "<th colspan='4'>Jumlah</th>" +
                            "<th class='text-right'>"+ format_rp(data.total_debet) +"</th>" +
                            "<th class='text-right'>"+ format_rp(data.total_kredit) +"</th>" +
                            "</tr>" 
                            // "<tr>" +
                            // "<th colspan='5'>Saldo Awal</th>" +
                            // "<th class='text-right'>" + format_rp(data.saldo_awal) + " </th>" +
                            // "</tr>" +
                            // "<tr>" +
                            // "<th colspan='5'>Saldo Akhir</th>" +
                            // "<th class='text-right'>" + format_rp(data.saldo_kas) + " </th>" +
                            // "</tr>"
                            arrData.map(function(element){
                                console.log(element)
                                var dateFormatPHP = new Date(element.tanggal_jurnal)
                                var Day = dateFormatPHP.getDate()
                                var Month = dateFormatPHP.getMonth()
                                var Year = dateFormatPHP.getFullYear()
                                if(Month > 9){
                                    var fixedDate = Day + "-" + Month + "-" + Year
                                }else{
                                    var fixedDate = Day + "-" + "0" + (parseInt(Month) + 1) + "-" + Year
                                }
                                var nilaiDuit
                                if(element.status_jurnal == 'Kredit'){
                                    nilaiDuit = "<td></td>" + "<td class='text-right'>"+ format_rp(element.jumlah) + "</td>"
                                    keterangan = "<td class='text-right'>"+ element.nama_akun +"</td>" 
                                }else{
                                    nilaiDuit = "<td class='text-right'>"+ format_rp(element.jumlah) +"</td>" + "<td></td>"
                                    keterangan = "<td>"+ element.nama_akun +"</td>" 
                                }
                                var numberPlusOne = number++
                                var newObject = "<tr>" +
                                    "<td>"+ numberPlusOne +"</td>" +
                                    "<td>"+ fixedDate +"</td>" +
                                    keterangan +
                                    "<td> JU "+ element.kode_akun +"</td>" +
                                    nilaiDuit +
                                "</tr>"
                                newArrayBody.push(newObject)
                            })
                            $('#content_id').append(newArrayBody);
                            $('#tFootId').append(newArrayFooter);
                        }else{
                            var newArrayBody = []
                            if(start_date == end_date){
                                var newObject = "<tr>" +
                                    "<td colspan='6' class='text-center'>--- Tidak Ada Data Di Tanggal <b>"+ start_date +"</b> ---</td>" +
                                "</tr>"

                            }else{
                                var newObject = "<tr>" +
                                    "<td colspan='6' class='text-center'>--- Tidak Ada Data Di Tanggal <b>"+ start_date +" - "+ end_date +"</b> ---</td>" +
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
            filename: "Ramen AA Buku Besar Harga Pokok Penjualan"
        });
    }
</script>

</html>