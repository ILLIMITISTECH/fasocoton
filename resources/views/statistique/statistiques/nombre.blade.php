@include('forums.header2')
@extends('templates.master')

<!--<div class="row">

    <div class="col-lg-12 margin-tb">

        

        <div class="pull-right">

            <a class="btn btn-success" href="#"></a>

        </div>

    </div>

</div> -->

<div class="container">
   <!-- <center>
     <div class="card-header">
     <b style="font-size:20px; color:green;"><a href="/page_entreprises" style="font-size:20px; color:green;  margin-left:-10px;">Liste des Entreprises</a></b>
     <b style="font-size:20px; color:green;"><a href="/page_participants" style="font-size:20px; color:green; margin-left:10px;">Liste des  Participants</a></b>
     </div>
    </center> -->
<center><h2 style="font-size:12px;"><strong><b style="font-size:20px;">Statistiques Inscriptions</b></strong></h2></center>
<div class="card">
<div class="card-header"><b style="font-size:20px;">Statistiques Globales</b></div>
<div class="card-body">

<table id="datatable-buttons" class="table table-striped table-bordered">
    <thead>
        <tr>
                <th id="b" style="font-size:12px;">Nombre total de comptes créés</th>
                <th id="a" style="font-size:12px;">Nombre total d’entreprises inscrites</th>
                <th id="c" style="font-size:12px;">Nombre total de participants inscrits</th>
                <th id="c" style="font-size:12px;">Nombre total de pays inscrits</th>


        </tr>
    <thead>

    <tbody>
        <tr>
                 <td id="b" style="font-size:12px;"><b style="color:black;">{{ count($users) }}</b> <a href="/page_comptes_a" style="font-size:13px; color:green;  margin-left:10px;">Liste des Comptes</a></td>
                <td id="a" style="font-size:12px;"><b style="color:black;">{{ count($entreprises) }}</b> <a href="/page_entreprises_a" style="font-size:13px; color:green;  margin-left:10px;">Liste des Entreprises</a> <br><b style="color:black;">{{ count($entreprisess) }}</b><a href="/page_rendez_vous_a" style="font-size:13px; color:green; margin-left:20px;">Liste des Entreprises pour B2B</a></td>
                <td id="b" style="font-size:12px;"><b style="color:black;">{{ count($participants) }}</b><a href="/page_participants_a" style="font-size:13px; color:green; margin-left:10px;">Liste des  Participants</a></td>
                <td id="c" style="font-size:12px;"><b style="color:black;">{{ $pays}}</b></td>

        </tr>
    <tbody>

</table>

</div>
</div>

<div class="card">
<div class="card-header"><b style="font-size:20px;">Statistiques Par Pays</b></div>
<div class="card-body">

<table id="datatable-buttons" class="table table-striped table-bordered">


<thead>
        <tr>

                <th id="a" style="font-size:12px;">Pays</th>
                <th id="b" style="font-size:12px;">Total Inscrits</th>
                <th id="c" style="font-size:12px;">Pourcentage</th>

        </tr>
    <thead>

    <tbody>
    @foreach($all_pays as $pay)

        <tr>
                <td id="c" style="font-size:12px;">{{ $pay->pays }}</td>
                <td id="c" style="font-size:12px;">{{ $pay->total }}</td>
                <td id="c" style="font-size:12px;">{{ round($pay->total/$all_pays_total*100,2) }}%</td>

        </tr>
    @endforeach
    
    <tbody>
    


</table>
<tr>
    <td id="c" style="font-size:12px;">TOTAL <b style="margin-left:270px;">{{ $all_pays_total }}</b></td>
    </tr>
</div>
</div>


<div class="card">
<div class="card-header"><b style="font-size:20px;">Statistiques Par Secteur d’Activités Principal</b></div>
<div class="card-body">

<table id="datatable-buttons" class="table table-striped table-bordered">


<thead>
        <tr>

                <th id="a" style="font-size:12px;">Secteur d’Activités</th>
                <th id="b" style="font-size:12px;">Total Inscrits</th>
                <th id="c" style="font-size:12px;">Pourcentage</th>

        </tr>
    <thead>
    <tbody>

    @foreach($all_secteurs as $secteur)
        <tr>
                <td id="c" style="font-size:12px;">{{ $secteur->secteur_a }}</td>
                <td id="c" style="font-size:12px;">{{ $secteur->total }}</td>
                <td id="c" style="font-size:12px;">{{ round($secteur->total/$all_secteur_total*100,2) }}%</td>

        </tr>
    @endforeach
    <tbody>



</table>
<tr>
    <td id="c" style="font-size:12px;">TOTAL <b style="margin-left:250px;">{{ $all_secteur_total }}</b></td>
    </tr>
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
   
   