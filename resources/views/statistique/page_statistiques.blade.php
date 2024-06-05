@include('forums.header2')
<!--<div class="row">

    <div class="col-lg-12 margin-tb">

        

        <div class="pull-right">

            <a class="btn btn-success" href="#"></a>

        </div>

    </div>

</div> -->
<!-- @include('statistique/sidebar') -->
<section class="navbar custom-navbar navbar-fixed-top"   role="navigation">
         </center> <div>

               <img class="pub-image pull-right" style="width:100px; height:100px; margin-left:570px;" src="{{asset('sbpme/logo-salon-9em.png')}}">

             
          </div> <center>
     </section>

<div class="container">
   <!-- <center>
     <div class="card-header">
     <b style="font-size:20px; color:green;"><a href="/page_entreprises" style="font-size:20px; color:green;  margin-left:-10px;">Liste des Entreprises</a></b>
     <b style="font-size:20px; color:green;"><a href="/page_participants" style="font-size:20px; color:green; margin-left:10px;">Liste des  Participants</a></b>
     </div>
    </center> -->
<center>
    <h2 style="font-size:12px;"><strong style="font-size:30px;font-weight: normal;Color:#84009c;">STATISTIQUES INSCRIPTIONS</strong></h2>
    <br><br><br>


    
</center><br>
<div class="card">
    <center>
<div class="card-header" style="background:#84009c; color:white;text-align:center"><b style="font-size:20px;font-weight:normal;">Statistiques Globales</b></div></center>
<!--<b style="font-size:20px;font-weight:normal;margin-left:200px"><a href="/page_rendez_vous">Liste des entreprises</a></b>   |  <b style="font-size:20px;font-weight:normal;margin-left:20px"><a href="/page_inscrits">Liste des inscrits</a></b>-->
<div class="card-body">

<table id="datatable-buttons" class="table table-light table-hover">
    <thead>
        <tr>
                <!--<th id="b" style="font-size:12px;">Nombre total de comptes créés</th>-->
                <th id="a" style="font-size:15px;font-weight: normal;"><b>Total entreprises inscrites</b></th>
                <th id="c" style="font-size:15px;font-weight: normal;"><b>Total participants inscrits</b></th>
                <!-- <th id="c" style="font-size:15px;font-weight: normal;"><b>Autres participants inscrits</b></th> -->
                <th id="c" style="font-size:15px;font-weight: normal;"><b>Total pays inscrits</b></th>
               
        </tr>
    <thead>

    <tbody>
        <tr>
                 <!--<td id="b" style="font-size:12px;">{{ count($users) }} <a href="/page_comptes" style="font-size:13px; color:green;  margin-left:10px;">Liste des Comptes</a></td>-->
                <td id="a" style="font-size:13px; ">{{ count($entreprises) }} <!--<a href="/page_entreprises" style="font-size:13px; color:green;  margin-left:10px;">Liste des Entreprises</a> <br><b style="color:black;">{{ count($entreprisess) }}</b><a href="/page_rendez_vous" style="font-size:13px; color:green; margin-left:20px;">Liste des Entreprises pour B2B</a>--></td>
                <td id="b" style="font-size:13px; ">{{ count($participants) }}<!--<a href="/page_participants" style="font-size:13px; color:green; margin-left:10px;">Liste des  Participants</a>--></td>
                <?php 
                $qrcode = DB::table('qrcode')->count();
                    $intervenant = DB::table('intervenants')->count();
                    $organisateur = DB::table('organisateurs')->count();
                    $facilitateur = DB::table('facilitateurs')->count();
                    $traducteur = DB::table('traducteurs')->count();
                    $membre = DB::table('membres')->count();
                    $delegations = DB::table('chef_delegations')->count();
                    
                    $sum = $intervenant + $organisateur + $facilitateur + $facilitateur + $traducteur + $membre + $delegations;
                    $plannings = DB::table('plannings')->count();
                    $plannings_rvs = DB::table('plannings_rvs')->count();
                    $parti = DB::table('participants')->where('presence', '=', 2)->count();
                ?>
               <!-- <td id="b" style="font-size:13px; ">{{$sum}} -->
                <td id="c" style="font-size:13px; ">{{ $pays}}</td>
               

        </tr>
    <tbody>

</table>

</div>
</div><br><br>

<div class="card">
    <center>
<div class="card-header"  style="background:#84009c; color:white;"><b style="font-size:20px;font-weight: normal;">Statistiques Par Pays</b></div></center>
<div class="card-body">

<table id="datatable-buttons" class="table table-light table-hover"


<thead>
        <tr>

                <th id="a" style="font-size:15px;font-weight: normal;"><b>Pays</b></th>
                <th id="b" style="font-size:15px;font-weight: normal;"><b>Total Inscrits</b></th>
                <th id="c" style="font-size:15px;font-weight: normal;"><b>Pourcentage</b></th>

        </tr>
    <thead>

    <tbody>
    @foreach($all_pays as $pay)

        <tr>
                
                <td id="b" style="font-size:12px;">{{ $pay->pays}}</td>
                <td id="c" style="font-size:13px;">{{ $pay->total }}</td>
               
                <td id="c" style="font-size:13px;">{{ round($pay->total/$all_pays_total*100,2) }}%</td>

        </tr>
    @endforeach
    
    <tbody>
    


</table>
<tr>
    <td id="c" style="font-size:12px;font-weight: normal">TOTAL <b style="">{{ count($entreprises) }}</b></td>
    </tr>
</div>
</div><br><br>


<div class="card">
<center><div class="card-header"  style="background:#84009c; color:white;"><b style="font-size:20px; font-weight:normal;">Statistiques Par Secteur d’Activités Principal</b></div></center>
<div class="card-body">

<table id="datatable-buttons" class="table table-light">


<thead>
        <tr>

                <th id="a" style="font-size:15px;font-weight:normal;"><b>Secteur d’Activités</b></th>
                <th id="b" style="font-size:15px;font-weight:normal; "><b>Total Inscrits</b></th>
                <th id="c" style="font-size:15px;font-weight:normal;"><b>Pourcentage</b></th>

        </tr>
    <thead>
    <tbody>

    @foreach($all_secteurs as $secteur)
        <tr>
                <td id="c" style="font-size:13px;">{{ $secteur->secteur_a }}</td>
                <td id="c" style="font-size:13px;">{{ $secteur->total }}</td>
                <td id="c" style="font-size:13px;">{{ round($secteur->total/$all_secteur_total*100,2) }}%</td>

        </tr>
    @endforeach
    <tbody>



</table>
<tr>
    <td id="c" style="font-size:12px;font-weight: normal">TOTAL <b style="">{{ count($entreprises) }}</b></td>
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
   
   