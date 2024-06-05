@include('forums.header3')


 @include('statistique/sidebar')
<section class="navbar custom-navbar navbar-fixed-top"  role="navigation">
          <div class="container">

               
             
          </div>
     </section>

<div class="container">


<center><h2 style="font-size:12px;"><strong style="font-size:30px;font-weight: normal;Color:#84009c;">STATISQUE DES INSCRITS</strong></h2></center><br><br><br>
<div class="card">
    <div class="card-header" style="background:#84009c; color:white;">
<p><b style="font-size:20px;font-weight:normal;">Liste des inscrits :</b> <b style="font-size:20px; color:white;"><strong>{{ count($inscrits) }}</strong></b></p></div>
<div class="card-body">

<table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
        <tr>

                <th id="b" style="font-size:15px;font-weight: normal;">Nom et prénom</th>
                <th id="c" style="font-size:15px;font-weight: normal;">Contacts</th>
                <th id="c" style="font-size:15px;font-weight: normal;">pays</th>
              

        </tr>
    <thead>

    <tbody>
    @foreach($inscrits as $inscrit)
        <tr>

                <td id="b" style="font-size:13px;">{{ $inscrit->prenom }}  {{ $inscrit->nom }}</td>
                <td id="c" style="font-size:13px;">{{ $inscrit->email }} <br>{{ $inscrit->portable }}</td>
                 <?php $pays = DB::table('pays')->where('id', $inscrit->pays_id)->first(); ?>
                @if($pays)
                    <td id="c" style="font-size:13px;">{{ $pays->libelle_fr }}</td>
                @else
                    <td>---</td>
                @endif

        </tr>
    @endforeach
    <tbody>

</table>
</div>

</div><br><br>
<a class="card-title" href="/page_statistiques" style="border:solid 1 px blue;background:#84009c; padding-top:5px; padding-bottom:5px; margin-left:10px; color:white;">Retour</a>
</div><br><br><br><br>
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
   TableManageButtons.init();
   </script>
   