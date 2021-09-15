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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="float-left">
                            </div>
                        </div>
                        <div class="card-body text-center">
                          <h5 class="card-title font-weight-bold">Buku Besar</h5>
                          <h5 class="card-title font-weight-bold">Ramen AA</h5>
                          <p class="card-text font-weight-bold">Jl. Raya Cicalengka - Majalaya No.229, Sukamanah, Kec. Paseh, Bandung, Jawa Barat 40392</p>
                        </div>
                        <div class="card-footer text-center">
                        </div>
                    </div>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="float-left" id="buttonExport">
                                <!-- <button class="btn btn-primary" id="btnExport" onclick="fnExcelReport()"> EXPORT </button> -->
                                <button class="btn btn-primary" id="btnExport" onclick="exportKedua()"> EXPORT </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <select class="form-control" name="id_akun" id="id_akun_coa">
                                      <option value="null">Pilih</option>
                                      <?php foreach($coas as $row){ ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['kode_akun'] ?> || <?= $row['nama_akun'] ?></option>
                                      <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-sm-2">
                                    <input class="form-control" name="start_date" type="date" id="id_start_date">
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control" name="end_date" type="date" id="id_end_date">
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control btn btn-primary" type="submit" id="id_button">
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan='2' class='text-center'>No </th>
                                            <th rowspan='2' class='text-center'>Tanggal </th>
                                            <th rowspan='2' class='text-center'>Keterangan </th>
                                            <th rowspan='2' class='text-center'>Ref </th>
                                            <th rowspan='2' class='text-center'>Debet </th>
                                            <th rowspan='2' class='text-center'>Kredit </th>
                                            <th colspan='2' class='text-center'>Saldo </th>
                                        </tr>
                                        <tr>
                                            <th class='text-center'>Debet </th>
                                            <th class='text-center'>Kredit </th>
                                        </tr>
                                    </thead>
                                    <div class="col" id='header_id'>
                                    </div>
                                    <br>
                                    <tbody id="content_id">
                                        <!-- <?php $no = 1; $total_debit = 0; $total_kredit = 0;
                                            foreach ($dataJurnal as $row){?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $row['tanggal_jurnal'] ?></td>
                                            <?php if($row['status_jurnal'] != 'Kredit'){ ?>
                                                <?php $total_debit += $row['jumlah'] ?>                                    
                                                <td><?= $row['nama_akun'] ?></td>
                                                <td style="width:5%"><?= $row['kode_akun'] ?></td>
                                                    <?php if($row['id_akun'] == 4 || $row['id_akun'] == 2){ ?>
                                                        <td class="text-right"><?= format_rp($row['jumlah']) ?></td>
                                                    <?php }else{ ?>
                                                        <td class="text-right"><?= format_rp($row['jumlah']) ?></td>
                                                    <?php } ?>
                                                <td></td>
                                            <?php }else{ ?>
                                            <?php $total_kredit += $row['jumlah'] ?>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $row['nama_akun'] ?></td>
                                            <td style="width:5%"><?= $row['kode_akun'] ?></td>
                                            <td></td>
                                                <?php if($row['id_akun'] == 4 || $row['id_akun'] == 2){ ?>
                                                    <td class="text-right"><?= format_rp($row['jumlah']) ?></td>
                                                <?php }else{ ?>
                                                    <td class="text-right"><?= format_rp($row['jumlah']) ?></td>
                                                <?php } ?>
                                            <?php } ?>
                                        </tr>
                                        <?php } ?> -->
                                    </tbody>
                                    <tfoot id="tFootId">
                                        <!-- <tr>
                                            <th colspan="4">Jumlah</th>
                                            <th class="text-right"><?= format_rp($total_debit) ?></th>
                                            <th class="text-right"><?= format_rp($total_kredit) ?></th>
                                        </tr> -->
                                        <!-- <tr>
                                            <th colspan="5">Saldo Awal</th>
                                            <th class="text-right"><?= format_rp($saldo_kas) ?></th>
                                        </tr> -->
                                        <!-- <tr>
                                            <th colspan="5">Saldo Akhir</th>
                                            <th class="text-right"><?= format_rp($saldo_kas) ?></th>
                                        </tr> -->
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

    $(document).ready(function(){
        var start_date = null
        var end_date = null
        var id_akun = null 

        $('#id_akun_coa').change(function(){
          id_akun = $('#id_akun_coa').val()
        })

        $('#id_start_date').change(function(){
            start_date = $('#id_start_date').val()
            console.log(start_date)
        })

        $('#id_end_date').change(function(){
            end_date = $('#id_end_date').val()
            console.log(end_date)
        })
        $('#id_button').click(function(){
          if(start_date != null || end_date != null || id_akun != null){
              $('#header_id').html("")
              $('#content_id').html("")
              $('#tFootId').html("")
              var getUrl = window.location;
              var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
              $.get(baseUrl+"/buku-besar/ajax/"+start_date+"/"+end_date+"/"+id_akun, function(data, status){
                  if(data != null){
                      if(data.data_jurnal.length > 0){
                          var total_debit = 0
                          var total_kredit = 0
                          var arrData = data.data_jurnal
                          var number = 1
                          var newArrayBody   = []
                          var newHeader      = "<div class='row'> Nama Akun: " + arrData[0].nama_akun + "</div><div class='row'>Kode Akun: " + arrData[0].kode_akun + "</div>"
                          var newArrayFooter = "<tr>" +
                          "<th colspan='4'>Jumlah</th>" +
                          "<th class='text-right'>"+ format_rp(data.total_debet) +"</th>" +
                          "<th class='text-right'>"+ format_rp(data.total_kredit) +"</th>" +
                          "<th class='text-right'></th>" +
                          "<th class='text-right'></th>" +
                          "</tr>"
                          arrData.map(function(element){
                              var dateFormatPHP = new Date(element.tanggal_jurnal)
                              var Day = dateFormatPHP.getDate()
                              var Month = dateFormatPHP.getMonth()
                              var Year = dateFormatPHP.getFullYear()
                              if(Month > 9){
                                  var fixedDate = Day + "-" + Month + "-" + Year
                              }else{
                                  var fixedDate = Day + "-" + "0" + (parseInt(Month) + 1) + "-" + Year
                              }
                              // console.log(fixedDate)
                              var nilaiDuit
                            //   if(element.status_jurnal == 'Kredit'){
                            //     nilaiDuit = "<td></td>" + "<td class='text-right'>"+ format_rp(element.jumlah) + "</td>"
                            //     keterangan = "<td class='text-right'>"+ element.nama_akun +"</td>" 
                            //   }else{
                            //     nilaiDuit = "<td class='text-right'>"+ format_rp(element.jumlah) +"</td>" + "<td></td>"
                            //     keterangan = "<td>"+ element.nama_akun +"</td>" 
                            //   }
                              if(element.status_jurnal == 'Kredit'){
                                nilaiDuit = "<td></td>" + "<td class='text-right'>"+ format_rp(element.jumlah) + "</td>"
                                keterangan = "<td class='text-right'>"+ element.nama_akun +"</td>" 
                                fixed_jumlah = "<td></td>" + "<td class='text-right'>"+ format_rp(element.fixed_jumlah) +"</td>" 
                              }else{
                                nilaiDuit = "<td class='text-right'>"+ format_rp(element.jumlah) +"</td>" + "<td></td>"
                                keterangan = "<td>"+ element.nama_akun +"</td>" 
                                fixed_jumlah = "<td>"+ format_rp(element.fixed_jumlah) + "</td>" + "<td></td>"
                              }
                              var numberPlusOne = number++
                              var newObject = "<tr>" +
                                  "<td>"+ numberPlusOne +"</td>" +
                                  "<td>"+ fixedDate +"</td>" +
                                  keterangan +
                                  "<td> JU "+ element.kode_akun +"</td>" +
                                  nilaiDuit +
                                  fixed_jumlah
                              "</tr>"
                              newArrayBody.push(newObject)
                          })
                          $('#header_id').append(newHeader);
                          $('#content_id').append(newArrayBody);
                          $('#tFootId').append(newArrayFooter);
                          // console.log(data.saldo_akhir)
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
                  }
              });
          }
        })
    })
</script>
<script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
<script type="text/javascript">
    function exportKedua(){
        $('#example').table2excel({
            filename: "Ramen AA Buku Besar Kas"
        });
    }
</script>
</html>