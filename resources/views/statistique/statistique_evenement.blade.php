@include('forums.header2')
<!--<div class="row">

    <div class="col-lg-12 margin-tb">

        

        <div class="pull-right">

            <a class="btn btn-success" href="#"></a>

        </div>

    </div>

</div> -->
 @include('statistique/sidebar')
<section class="navbar custom-navbar navbar-fixed-top"   role="navigation">
          <div class="container">

               
             
          </div>
     </section>

<div class="container">
   <!-- <center>
     <div class="card-header">
     <b style="font-size:20px; color:green;"><a href="/page_entreprises" style="font-size:20px; color:green;  margin-left:-10px;">Liste des Entreprises</a></b>
     <b style="font-size:20px; color:green;"><a href="/page_participants" style="font-size:20px; color:green; margin-left:10px;">Liste des  Participants</a></b>
     </div>
    </center> -->
<center>
    <h2 style="font-size:12px;"><strong style="font-size:30px;font-weight: normal;Color:#84009c;">STATISTIQUES DE L'EVENEMENT</strong></h2>
    <br><br><br>


    
</center><br>
<div class="card">
    <center>
<div class="card-header" style="background:#84009c; color:white;"><b style="font-size:20px;font-weight:normal;">Statistiques Globales</b></div></center>
<div class="card-body">

<table id="datatable-buttons" class="table table-light table-hover">
    <thead>
        <tr>
                <!--<th id="b" style="font-size:12px;">Nombre total de comptes créés</th>-->
               
                 <th id="c" style="font-size:15px;font-weight: normal;"><b>Nombre total de rendez-vous</b></th>
                <th id="c" style="font-size:15px;font-weight: normal;"><b>Nombre de participants présents sur place</b></th>
                <th id="c" style="font-size:15px;font-weight: normal;"><b>Nombre de participants participeront en ligne</b></th>
                 <th id="c" style="font-size:15px;font-weight: normal;"><b>Nombre de rendez-vous B2B ayant eu lieu</b></th>




        </tr>
    <thead>

    <tbody>
        <tr>
                 <!--<td id="b" style="font-size:12px;">{{ count($users) }} <a href="/page_comptes" style="font-size:13px; color:green;  margin-left:10px;">Liste des Comptes</a></td>-->
                 <?php 
                $qrcode = DB::table('qrcode')->count();
                    $plannings = DB::table('plannings')->count();
                    $plannings_rvs = DB::table('plannings_rvs')->count();
                    $parti = DB::table('participants')->where('presence', '=', 2)->count();
                ?>
                <td id="c" style="font-size:13px; ">{{$plannings + $plannings_rvs}}</td>
                <td id="c" style="font-size:13px; ">{{$qrcode}}</td>
                <td id="c" style="font-size:13px; ">{{$parti}}</td>
                <td id="c" style="font-size:13px; ">0</td>

        </tr>
    <tbody>

</table>
</div>
</div>
</div>
</div>
<script>
   var resizefunc = [];
   </script>
   
   <!-- jQuery  -->
   <script src="{{asset('assetspdf/js/jquery.min.js')}}"></script>
   <script src="{{asset('assetspdf/js/bootstrap.min.js')}}"></script>
   <script src="{{asset('assetspdf/js/detect.js')}}"></script>
   <script src="{{asset('assetspdf/js/fastclick.js')}}"></script>
   <script src="{{asset('assetspdf/js/jquery.blockUI.js')}}"></script>
   <script src="{{asset('assetspdf/js/waves.js')}}"></script>
   <script src="{{asset('assetspdf/js/wow.min.js')}}"></script>
   
   <!-- Datatables-->
   <script src="{{asset('assetspdf/plugins/datatables/jquery.dataTables.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.bootstrap.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.buttons.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/buttons.bootstrap.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/jszip.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/pdfmake.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/vfs_fonts.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/buttons.html5.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/buttons.print.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.fixedHeader.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.keyTable.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.responsive.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/responsive.bootstrap.min.js')}}"></script>
   <script src="{{asset('assetspdf/plugins/datatables/dataTables.scroller.min.js')}}"></script>
   
   <!-- Datatable init js -->
   <script src="{{asset('assetspdf/pages/datatables.init.js')}}"></script>
   
   <script src="{{asset('assetspdf/js/jquery.app.js')}}"></script>
   
   <script type="text/javascript">
   $(document).ready(function() {
       $('#datatable').dataTable();
       $('#datatable-keytable').DataTable( { keys: true } );
       $('#datatable-responsive').DataTable();
       $('#datatable-scroller').DataTable( { ajax: "{{asset('assetspdf/plugins/datatables/json/scroller-demo.json')}}", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
       var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
   } );
   </script>
   
   