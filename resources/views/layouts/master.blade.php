<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Hi-code
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Files -->
  <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
  <link href="{{asset('assets/css/now-ui-dashboard.css?v=1.5.0')}}" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="{{asset('assets/demo/demo.css')}}" rel="stylesheet" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->

</head>

<body class="" style="background-image:url('https://iversity.org/blog/wp-content/uploads/2015/06/bigstock-Business-doodles-Sketch-set-84640172.jpg')">
  <div class="wrapper ">
    <div class="sidebar" data-color="orange">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          HI -
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          CODE
        </a>
      </div>
       @include('layouts/sidebar')
    </div>
    <div class="main-panel" id="main-panel">
      <!-- Navbar -->
    @include('layouts/navbar')
      <!-- End Navbar -->
       <div class="panel-header panel-header-sm">
      </div>
      <div class="content" style="background-image:url('https://iversity.org/blog/wp-content/uploads/2015/06/bigstock-Business-doodles-Sketch-set-84640172.jpg')">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
                @yield('content')
                </div>
            </div>
        </div>
      </div>
    @include('layouts/footer')
     
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="{{asset('assets/js/core/jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
  <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/plugins/perfect-scrollbar.jquery.min.js')}}"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chart JS -->
  <script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>
  <!--  Notifications Plugin    -->
  <script src="{{asset('assets/js/plugins/bootstrap-notify.js')}}"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('assets/js/now-ui-dashboard.min.js?v=1.5.0')}}" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
  <script src="{{asset('assets/demo/demo.js')}}"></script>
  <!-- <script src="{{asset('assets/calx.js-2.2.0/jquery-1.9.1.min.js')}}"></script>
  <script src="{{asset('assets/calx.js-2.2.0/jquery-calx-2.2.0.js')}}"></script>
  <script src="{{asset('assets/calx.js-2.2.0/jquery-calx-2.2.0.min.js')}}"></script>
  <script src="{{asset('assets/calx.js-2.2.0/jquery-1.9.1.min.js')}}"></script> -->

    <!-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script> -->
    <!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script> -->
    <!-- <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script> -->
    <!-- <script src="{{asset('js/jQuery.print.min.js')}}"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script> -->
    
    <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>-->
    <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>-->
    <!--<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>-->
    
    <!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>-->
    <!--<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>-->
    <!--<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script> -->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- @if(Auth::user()->hak_akses == 'Helpdesk')
        <script src="{{asset('js/helpdesk.js')}}"></script>
        <script src="{{asset('js/dashboardhelpdesk.js')}}"></script>
    @elseif(Auth::user()->hak_akses == 'Infra')
        <script src="{{asset('js/infra.js')}}"></script>
    @elseif(Auth::user()->hak_akses == 'Rnd')
        <script src="{{asset('js/rnd.js')}}"></script>
    @elseif(Auth::user()->hak_akses == 'Chiefstore')
        <script src="{{asset('js/chiefstore.js')}}"></script>
        <script src="{{asset('js/dashboardchiefstore.js')}}"></script>
    @elseif(Auth::user()->hak_akses == 'Produksi')
        <script src="{{asset('js/produksi.js')}}"></script>
        <script src="{{asset('js/dashboardproduksi.js')}}"></script>
    @endif -->
    @stack('myjs')
    <script>
       $('.input-daterange').datepicker({
                todayBtn: 'linked',
                format: 'yyyy-mm-dd',
                autoclose: true
            });
            $('#filter').click(function () {
                var from_date = $('#from_date').val(); 
                var to_date = $('#to_date').val(); 
                if (from_date != '' && to_date != '') {
                    $('#table_pegawai').DataTable().destroy();
                    load_data(from_date, to_date);
                } else {
                    alert('Both Date is required');
                }
            });
            $('#refresh').click(function () {
                $('#from_date').val('');
                $('#to_date').val('');
                $('#table_pegawai').DataTable().destroy();
                load_data();
            });
    </script>
    <script>
    $('table').DataTable({
        "scrollX": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print',
        ]
    });

    </script>
</script>
</body>

</html>
