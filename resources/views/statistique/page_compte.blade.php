 @include('forums.header4')


<!--<div class="row">

    <div class="col-lg-12 margin-tb">

        

        <div class="pull-right">

            <a class="btn btn-success" href="#"></a>

        </div>

    </div>

</div>-->
@include('statistique/sidebar')
<section class="navbar custom-navbar navbar-fixed-top"   role="navigation">
          <div class="container">

               
             
          </div>
     </section>
<div class="container">

<center><h3 style="font-size:12px;"><strong style="font-size:30px;font-weight: normal;Color:#84009c;"> STATISTIQUE DES COMPTES </strong></h3></center>
<br><br>
<div class="card">
 <center>
<div class="card-header" style="background:#84009c; color:white;"><b style="font-size:20px;font-weight:normal;">Liste des Comptes</b></div></center>
<div class="card-body">

<table id="datatable-buttons" class="table table-light table-hover">
    <thead>
        <tr>

                <th id="a" style="font-size:15px;font-weight: normal;"><b>Prénom</b></th>
                <th id="a" style="font-size:15px;font-weight: normal;"><b>Nom</b></th>
                <th id="a" style="font-size:15px;font-weight: normal;"><b>Contacts</b></th>
                <th id="b" style="font-size:15px;font-weight: normal;"><b>Email</b></th>
                

        </tr>
    <thead>

    <tbody>
    @foreach($users as $user)
        <tr>

                <td id="a" style="font-size:12px;">{{ $user->prenom }}</td>
                <td id="a" style="font-size:12px;">{{ $user->nom }}</td>
                <td id="a" style="font-size:12px;">{{ $user->portable }}</td>
                <td id="b" style="font-size:12px;">{{ $user->email }}</td>
               


        </tr>
    @endforeach
    <tbody>

</table>
</div>
</div>
<br><br>
<a class="card-title" href="/page_statistiques" style="border:#84009c 1 px blue; background-color:#84009c; padding-top:5px; padding-bottom:5px; margin-left:10px; color:white;">Retour</a>

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
   