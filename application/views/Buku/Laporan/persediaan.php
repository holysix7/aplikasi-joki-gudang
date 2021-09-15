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
                    <h1 class="h3 mb-2 text-gray-800">Laporan Persediaan </h1>
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="float-left">
                            </div>
                        </div>
                        <div class="card-body text-center">
                          <h5 class="card-title font-weight-bold">Laporan Persediaan</h5>
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
                            <div class="table-responsive">
                                <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No </th>
                                            <th>Nama Stok </th>
                                            <th>Jumlah Stok </th>
                                            <th>Harga/Unit </th>
                                            <th>Total Nilai Stok </th>
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
      var getUrl = window.location;
      var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
      $.get(baseUrl+"/laporan/ajax/persediaan", function(data, status){
          if(data != null){
              if(data.data.length > 0){
                  var arrData = data.data
                  var number = 1
                  var newArrayBody = []
                  var newArrayFooter = "<tr>" +
                  "<th colspan='3'>Jumlah</th>" +
                  "<th class='text-right'>"+ format_rp(data.total_perunit) +"</th>" +
                  "<th class='text-right'>"+ format_rp(data.total_stok) +"</th>" +
                  "</tr>"
                  arrData.map((element => {
                    var numberPlusOne = number++
                    var newObject = "<tr>" +
                        "<td>"+ numberPlusOne +"</td>" +
                        "<td>"+ element.nama_stok +"</td>" +
                        "<td class='text-right'>"+ element.jumlah_stok +"</td>" +
                        "<td class='text-right'>"+ format_rp(element.unit_price) +"</td>" +
                        "<td class='text-right'>"+ format_rp(element.total_harga) +"</td>" +
                    "</tr>"
                    newArrayBody.push(newObject)
                  }))
                  $('#content_id').append(newArrayBody);
                  $('#tFootId').append(newArrayFooter);
              }
          }
      });
    })
</script>
<script src="https://rawgit.com/unconditional/jquery-table2excel/master/src/jquery.table2excel.js"></script>
<script type="text/javascript">
    function exportKedua(){
        $('#example').table2excel({
            filename: "Ramen AA Laporan Persediaan"
        });
    }
</script>

</html>