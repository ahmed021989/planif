<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' ,  'Admin_psd' , 'Admin_psc' );
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page  ccsdcsdc";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 

}
?>
<?php 
$titre = "Programmes sectoriel des wilayas";
$active_menu = "index";
$header = array('projet_supr');
if ($user->type =='administrateur' or 'psd' or 'ministre_SG'  ){
	require_once("composit/header.php");
    
}
?>

             
                   <ul class="breadcrumb">
                  <li><a href="index.php">Acceuil</a></li>  
					  <li class="active"><?php echo $titre ?></li>  
                </ul>
                <!-- END BREADCRUMB -->
              
                <!-- END PAGE TITLE -->
                		<?php 
			//$operation = Operation::trouve_tous_valider_ok($user->id_ord);
			
		?>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                                
      
                
                    <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    <h3 class="panel-title"><B>
									<?php 
									$prog=$_GET['id'];
									if($prog=="PN"){ echo "PROGRAMME NORMAL"; }
									if($prog=="PHP"){ echo "PROGRAMME SPECIAL DES WILAYAS HAUTS PLATEAUX"; }
									if($prog=="PS"){ echo "PROGRAMME SPECIAL DES WILAYAS SUD";}
									?> </B></h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                           
                                    </ul>                                
                                </div>
                                <div class="panel-body">
						<form class="form-horizontal" name="filtre" id = "filtre" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <div class="panel panel-default">
	<div class="panel-body">                                                                        
            <div class="row">
								
                 
					<?php   
					
					
					$sql_topo=$bd->requete("select * from ordonnateur where topographie='".$_GET['id']."' and id_prog=42");
					
					while($row=mysqli_fetch_array($sql_topo)){
						
					?>
					 <div class="col-md-4">
					  
<label  id="<?php echo $row['id_ord'];  ?>" onclick="charger_programe(<?php echo  $row['id_ord'];?>)" style="color:#fff; <?php if($_GET['id']=="PN"){ ?> background:#0dec0d <?php } if($_GET['id']=="PHP"){ ?> background:#1caf9a <?php } if($_GET['id']=="PS"){ ?> background:#FE9A2E <?php } ?> ;font-size:22px" class="btn btn-lg btn-block active">
                       <span class="fa fa-bookmark-o pull-left" style="font-size:24px"> |</span>
					   <?php 
echo $row['wilaya'];
					   ?>   
</label><br>
                    </div>
					
					<?php   } ?>
			
							
             </div>
                      
					  <div class="row">
					  
					 
								 </div><!-- FIN ROW -->
								 </div>
								  </div>
						  </form>

                                </div>
                            </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
		<!-- MESSAGE BOX liste Operations -->
		<div class="message-box animated fadeIn"  id="mb-voir">
            <div class="mb-container" style="background:#fff;margin-top:-200px">
			
	 <div class="mb-footer">
					 
                        <div class="pull-right">
						<div>
						
                           <button class="btn btn-danger fa fa-times btn-lg mb-control-close"></button>
						   
						   </div>
						    <div><br></div>
                        </div>
                    </div> 
				
					  <center><span id="charge" style="font-size:14px">CHARGEMENT ...<img src="img/fileinput/loading.gif" width="20" height="20"/> </span></center>
							
                       <!--***********************-->
					    <div class="panel-body scrollable" id="operations">
						
						 	<!-- contenu de la page charger_infra.php -->
                                 
                        </div>  
					   
					   <!--***********************-->
				
                    </div>
                  </div>						 
        <!-- MESSAGE BOX-->
        <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Déconnexion <strong></strong> ?</div>
                    <div class="mb-content">
                        <p>Êtes-vous sûr vous déconnecter?</p>                    
                        <p>Appuyez sur Non si vous souhaitez continuer à travailler. Appuyez sur Oui pour déconnecter l'utilisateur actuel</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <a href="logout.php" class="btn btn-success btn-lg">Oui</a>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="message-box message-box-danger animated fadeIn" id="message-box-danger" data-sound="fail" >
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Supprimer <strong> les données </strong> ?</div>
                    <div class="mb-content">
                        <p>Etes-vous sûr de vouloir supprimer cette ligne?</p>                    
                        <p>Appuyez sur Oui si vous sûr</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-right">
                            <button class="btn btn-success btn-lg mb-control-yes">Oui</button>
                            <button class="btn btn-default btn-lg mb-control-close">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
       <!-- END MESSAGE BOX-->
       
        <!-- START PRELOADS -->
        <audio id="audio-alert" src="audio/alert.mp3" preload="auto"></audio>
        <audio id="audio-fail" src="audio/fail.mp3" preload="auto"></audio>
        <!-- END PRELOADS -->                
    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>                
        <!-- END PLUGINS -->
        
        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="js/demo_tables.js"></script>          
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>   
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <!-- END THIS PAGE PLUGINS -->       
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>   

 <script type="text/javascript" src="js/dataTables.fixedColumns.min.js"></script> 
<script>
//function valider_sf
function valider_sf(id){

$.ajax({
				
	method:"post",
	url:"ajax_valider_sf.php",
    data:{ id: id},
	success:function(resultData){
		alert(resultData);
	//$('#mb-change_date').hide(); 	
	window.location.reload();

}
})
	 
 }
  $('#table0').dataTable( 
{
  
    "searching": true,
    "paging":true,
    "ordering": false,
    "scrollX": "150%", 
    "fixedColumns":   {
            leftColumns: 0,
            rightColumns: 1
        },

} ); 


function charger_programe(ord){
	                        $("#operations").empty();
                            $('#charge').show();
							$("#mb-voir").show();
							$("#operations").load('charger_programme.php?ord='+ord+'');	
                             }
 $('.mb-control-close').on('click',function(){
	                                         $('#mb-voir').hide(); 				
	                                         })

</script>
<style>

#img{
height:100px;
	text-align:center;
	border:1px solid black;
	
}

 #img:hover{

opacity:0.6;
cursor:pointer;
		
		 }
#imga {
 overflow: hidden;
}

.full {
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  display: block;
}

.zoom {
	 
  animation: scale 40s  infinite;
}
  
@keyframes scale {
  50% {
 -webkit-transform:scale(1.5);
-moz-transform:scale(1.2);
    -ms-transform:scale(1.2);
    -o-transform:scale(1.2);
  transform:scale(1.5);
  }
}
		 
		 #test{
    animation: Test 2s infinite;

}
@keyframes Test{
    0%{opacity: 1;}
    50%{opacity: 0;}
    100%{opacity: 1;}
}

		 body,td,th {
	font-family: Roboto, sans-serif;
}
</style>		
        <!-- END TEMPLATE -->    
    <!-- END SCRIPTS -->                   
    </body>
</html>

