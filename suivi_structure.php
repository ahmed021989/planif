<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur'  , 'Admin_psd' , 'Admin_psc','ministre_SG' );
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="Accès non autorisé!  ccsdcsdc";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 

}
?>
<?php 
$titre = "structures ";
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
			$operation = Operation::trouve_tous_valider_ok($user->id_ord);
			
		?>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                                
      
                
                    <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    <h3 class="panel-title">Structures   </h3>
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
								
                                   <?php $SQL = $bd->requete("SELECT * FROM   structure ");
								   $m=1;
									while ($rows = $bd->fetch_array($SQL))
											{
												if(!in_array($rows['code_structure'],array("st100",'st101','st102','st103'))){
													if($m>3){ $m=1; 
											echo '<div class="row">&nbsp;</div><div class="col-md-4"><a style="font-size:22px" id="img"  class="col-md-12 btn btn-info"  href="suivi_infra.php?code_structure='.$rows["code_structure"].'"> <br>'.$rows["nom_structure"].'<br></a></div>';
													}
													else{
													echo '<div class="col-md-4"><a style="font-size:22px" id="img"  class="col-md-12 btn btn-info"  href="suivi_infra.php?code_structure='.$rows["code_structure"].'"> <br>'.$rows["nom_structure"].'<br></a></div>';
												
													}
													$m++;
										}	
											}										?>													
												
<!--							 
							 <div class="col-md-4">
						  <div class="form-group">
                                               <label class="col-md-4 control-label"> Infrastructure:</label>
                                               <div class="col-md-8">                                         
                                                    <select class="form-control select" id="infra"  name="infra" data-live-search="true"  required />
															<option value="tous"> Sélectionné l'infrastructure</option>
                                                                              <?php /*$SQL = $bd->requete("SELECT * FROM   infrastructure ");
															while ($rows = $bd->fetch_array($SQL))
														{
														echo '<option  value = "'.$rows["code_infra"].'" >'.$rows["nom_infra"].'</option>';
														}	*/												?>													
														</select>   
                                                    												
                                                </div>
										
                                            </div>
							</div >
							-->
							
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
function lister_infra(){
	var code_structure=$('#structure').val();
	$.ajax({
		method:"post",
		url:"charger_infra.php",
		data:{code_structure:code_structure},
		success:function(resultat){
			//alert(resultat);
				tabl=resultat.split('|');
		//alert(tabl);
		$("#infra").empty();
	 for(i=0;i<tabl.length;i++){
		 if(tabl[i]!=''){
		
			tabl0=tabl[i].split(','); 
		//alert(tabl[i]);
			$("#infra").append(new Option(tabl0[1],tabl0[0]));
			
		 }
	
			$('#infra').selectpicker("refresh");
	 }
	 
			
		}
	})
	

	
}
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

