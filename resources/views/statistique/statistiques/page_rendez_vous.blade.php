@include('forums.header3')
@extends('templates.master')

<!--<div class="row">

    <div class="col-lg-12 margin-tb">

        

        <div class="pull-right">

            <a class="btn btn-success" href="#"></a>

        </div>

    </div>

</div> -->

<div class="container">
<a class="card-title" href="/page_statistiques_a" style="border:solid 1 px blue; background-color:blue; padding-top:5px; padding-bottom:5px; margin-left:10px; color:white;">Retour</a>

<center><h2 style="font-size:12px;"><strong><b style="font-size:20px;">Les Entreprises</b></strong></h2></center>
<div class="card">
<div class="card-header"><b style="font-size:20px;">Liste des entreprises</b>
<p><b>Liste des Entreprises pour B2B:</b> <b style="font-size:20px; color:green;"><strong>{{ count($entreprises) }}</strong></b></p></div>
<div class="card-body">

<table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
        <tr>

                <th id="a" style="font-size:12px;">Nom participant principal</th>
                <th id="b" style="font-size:12px;">Pays</th>
                <th id="c" style="font-size:12px;">Nom Entreprise</th>
                <th id="c" style="font-size:12px;">Secteur principal</th>
                <th id="a" style="font-size:12px;">Contacts</th>
                <th id="c" style="font-size:12px;">participation aux B2B</th>

        </tr>
    <thead>

    <tbody>
    @foreach($entreprises as $entreprise)
        <tr>

                <td id="a" style="font-size:12px;">{{ $entreprise->prenom }}      {{ $entreprise->nom }}</td>
                <td id="b" style="font-size:12px;">{{ $entreprise->pays }}</td>
                <td id="c" style="font-size:12px;">{{ $entreprise->nom_entreprise }}</td>
                <td id="c" style="font-size:12px;">{{ $entreprise->secteur_a }}</td>
                <td id="a" style="font-size:12px;">{{ $entreprise->email }} <br>{{ $entreprise->portable }}</td>
                <td id="c" style="font-size:12px;">{{ $entreprise->rendez_vous }}</td>


        </tr>
    @endforeach
    <tbody>

</table>
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
   TableManageButtons.init();
   </script>
   