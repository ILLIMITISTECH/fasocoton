@include('forums.header2')
<!--<div class="row">

    <div class="col-lg-12 margin-tb">

        

        <div class="pull-right">

            <a class="btn btn-success" href="#"></a>

        </div>

    </div>

</div> -->
<!-- @include('statistique/sidebar') -->
<center><section class="navbar custom-navbar navbar-fixed-top"   role="navigation">
          <div>

               <img class="pub-image" style="width:100px; height:100px;margin-left:600px" src="{{asset('sbpme/logo-salon-9em.png')}}">

             
          </div> 
     </section></center>

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
<div class="card-header" style="background:#84009c; color:white;"><b style="font-size:20px;font-weight:normal;">Statistiques Globales</b></div></center>
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
                    
                    $sum = $intervenant + $organisateur + $facilitateur + $traducteur + $membre + $delegations;
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
<div class="card-header" style="background:#84009c; color:white;"><b style="font-size:20px;font-weight:normal;">Statistiques par pays </b></div></center>
<div class="card-body">

<table id="datatable-buttons" style="border: 1px solid black;" class="table">
    <thead>
        <tr>
                <!--<th id="b" style="font-size:12px;">Nombre total de comptes créés</th>-->
                <th id="a" style="font-size:15px;font-weight: normal;"><b> Pays</b></th>
                <th id="c" style="font-size:15px;font-weight: normal;"><b></b></th>
                <th id="c" style="font-size:15px;font-weight: normal;"><b></b></th>
               
               
        </tr>
    <thead>
    @php $pays_part = DB::table('participants')->where('pays_id', '!=' ,null)
        ->select('pays_id', DB::raw('count(*) as `total`'))
        ->groupBy('pays_id')->orderBy('total','DESC')->get(); 
      
    @endphp
    <tbody>
       @foreach($pays_part as $pay)
       
        <tr>
                <?php $parpays = DB::table('pays')->where('id', $pay->pays_id)->first(); ?>
                @if($parpays->libelle_fr != "Pérou" && $parpays->libelle_fr != "Colombie" && $parpays->libelle_fr != "Arménie" && $parpays->libelle_fr != "Azerbaïdjan" && $parpays->libelle_fr != "Grèce" && $parpays->libelle_fr != "Viêt Nam" && $parpays->libelle_fr != "Pays-Bas" && $parpays->libelle_fr != "Swaziland")
                <td id="b" style="font-size:12px;">{{ ($parpays) ? $parpays->libelle_fr : '--' }}</td>
                <tr>
                    <?php 
                    $entreb2bvirtus = array();
                    $parb2bvirtus = DB::table('participants')->where('pays_id', $pay->pays_id)->where('presence', '=', 2)->get(); 
                     foreach($parb2bvirtus as $parb2bvirtu)
                     {
                        $entreb2bvirtu = DB::table('entreprises')->where('rendez_vous', '=', 'AVEC un planning B 2 B')->where('id', $parb2bvirtu->entreprise_id)->count();
                        
                        array_push($entreb2bvirtus, $entreb2bvirtu);
                        
                     }
                     $totalentreb2bvirtus = array_sum($entreb2bvirtus);
                    
                    ?> 
                     <td id="b" style="font-size:12px;"></td>
                     <td id="b" style="font-size:12px;">Nombre d'entreprises B2B virtuel</td>
                     <td id="b" style="font-size:12px;">{{ $totalentreb2bvirtus}}</td>
                </tr>
                <tr>
                    <?php 
                    $entreb2bpresences = array();
                    $parb2bpresences = DB::table('participants')->where('pays_id', $pay->pays_id)->where('presence', '=', 1)->get(); 
                     foreach($parb2bpresences as $parb2bpresence)
                     {
                        $entreb2bpresence = DB::table('entreprises')->where('rendez_vous', '=', 'AVEC un planning B 2 B')->where('id', $parb2bpresence->entreprise_id)->count();
                        
                        array_push($entreb2bpresences, $entreb2bpresence);
                        
                     }
                     $totalentreb2bpresences = array_sum($entreb2bpresences);
                    
                    ?> 
                     <td id="b" style="font-size:12px;"></td>
                     <td id="b" style="font-size:12px;">Nombre d'entreprises B2B présentiel</td>
                     <td id="b" style="font-size:12px;">{{ $totalentreb2bpresences }}</td>
                </tr>
                <tr>
                     <?php $parstand = DB::table('participants')->where('pays_id', $pay->pays_id)->where('stand', '=', 1)->count(); ?>
                     <td id="b" style="font-size:12px;"></td>
                     <td id="b" style="font-size:12px;">Demande de Stands</td>
                     <td id="b" style="font-size:12px;">{{ $parstand}}</td>
                </tr>
                <tr>
                     <?php $parheberg = DB::table('participants')->where('pays_id', $pay->pays_id)->where('hebergement', '=', 1)->count(); ?>
                     <td id="b" style="font-size:12px;"></td>
                     <td id="b" style="font-size:12px;">Hebergement</td>
                     <td id="b" style="font-size:12px;">{{ $parheberg }}</td>
                </tr>
                <tr>
                     <?php $parkit = DB::table('participants')->where('pays_id', $pay->pays_id)->where('kit', '=', 1)->count(); ?>
                     <td id="b" style="font-size:12px;"></td>
                     <td id="b" style="font-size:12px;">Demandes pack</td>
                     <td id="b" style="font-size:12px;">{{ $parkit }}</td>
                </tr>
                <tr>
                     <?php $parvisa = DB::table('participants')->where('pays_id', $pay->pays_id)->where('visa', '=', 1)->count(); ?>
                     <td id="b" style="font-size:12px;"></td>
                     <td id="b" style="font-size:12px;">Demandes VISA</td>
                     <td id="b" style="font-size:12px;">{{ $parvisa }}</td>
                </tr>
                <tr>
                    <?php $parligne = DB::table('participants')->where('pays_id', $pay->pays_id)->where('presence', '=', 2)->count(); ?>
                     <td id="b" style="font-size:12px;"></td>
                     <td id="b" style="font-size:12px;">Participant en ligne</td>
                     <td id="b" style="font-size:12px;">{{ $parligne }}</td>
                </tr>
                <tr>
                     <?php $parpresen = DB::table('participants')->where('pays_id', $pay->pays_id)->where('presence', '=', 1)->count(); ?>
                     <td id="b" style="font-size:12px;"></td>
                     <td id="b" style="font-size:12px;">Présentiel</td>
                     <td id="b" style="font-size:12px;">{{ $parpresen}}</td>
                </tr>
               
               
               
            @endif
        </tr>
    @endforeach
    <tbody>

</table>

</div>
</div><br><br>

<div class="card">
    <center>
<div class="card-header" style="background:#84009c; color:white;"><b style="font-size:20px;font-weight:normal;">Situation des inscriptions en présentiel et virtuel</b></div></center>
<div class="card-body">

<table id="datatable-buttons" class="table table-light table-hover">
    <thead>
        <tr>
                <!--<th id="b" style="font-size:12px;">Nombre total de comptes créés</th>-->
                <th id="a" style="font-size:15px;font-weight: normal;"><b> Total Inscrits Présentiel</b></th>
                <th id="c" style="font-size:15px;font-weight: normal;"><b>Total Inscrits Virtuel</b></th>
               
               
        </tr>
    <thead>

    <tbody>
        <tr>
                 
                <!--<td id="b" style="font-size:12px;">{{ count($users) }} <a href="/page_comptes" style="font-size:13px; color:green;  margin-left:10px;">Liste des Comptes</a></td>-->
                
                <?php 
                
                    $presence = DB::table('participants')->where('presence', '=', 1)->count();
                    $virtuelle = DB::table('participants')->where('presence', '=', 2)->count();
                ?>
                <td id="a" style="font-size:13px; ">{{$presence }} </td>
                <td id="b" style="font-size:13px; ">{{$virtuelle }}</td>
               
               

        </tr>
    <tbody>

</table>

</div>
</div><br><br>

<!--<div class="card">
    <center>
<div class="card-header" style="background:#84009c; color:white;"><b style="font-size:20px;font-weight:normal;">Statistiques des B to B: {{ count($entreprisess) }} </b></div></center>
<div class="card-body">

<table id="datatable-buttons" class="table table-light table-hover">
    <thead>
        <tr>
                
                <th id="a" style="font-size:15px;font-weight: normal;"><b> Pays</b></th>
                <th id="c" style="font-size:15px;font-weight: normal;"><b>Nombre inscrits</b></th>
               
               
        </tr>
    <thead>

    <tbody>
       @foreach($all_pays as $pay)

        <tr>
                
                <td id="b" style="font-size:12px;">{{ $pay->pays}}</td>
                <td id="c" style="font-size:13px;">{{ $pay->total }}</td>
               

        </tr>
    @endforeach
    <tbody>

</table>

</div>
</div><br><br> -->

<!--<div class="card">
    <center>
<div class="card-header" style="background:#84009c; color:white;"><b style="font-size:20px;font-weight:normal;">Statistiques des B to G: {{ count($entreprisess) }} </b></div></center>
<div class="card-body">

<table id="datatable-buttons" class="table table-light table-hover">
    <thead>
        <tr>
                <th id="a" style="font-size:15px;font-weight: normal;"><b> Pays</b></th>
                <th id="c" style="font-size:15px;font-weight: normal;"><b>Nombre inscrits</b></th>
               
               
        </tr>
    <thead>

    <tbody>
       @foreach($demandeur as $demandeurs)

        <tr>
             
                
                <td id="b" style="font-size:12px;">{{ $demandeurs->pays}}</td>
                
               

        </tr>
    @endforeach
    <tbody>

</table>

</div>
</div><br><br>
-->


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
   
   