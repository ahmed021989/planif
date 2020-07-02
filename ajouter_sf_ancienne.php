<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 
?>
<?php

if ( (isset($_GET['id_op'])) && (is_numeric($_GET['id_op'])) ) {
$id = $_GET['id_op'];
if($operation=Operation::trouve_par_id($id)){
	$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
//	echo "<script>alert(".$ordonnateur->id_prog.")</script>";
	if(($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){

		
	}	
	else{

	
	if(($user->type=='Admin_psc' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==41){

		
	}	
	else{
	readresser_a('index.php');	
	}
	
}
}
else{
	readresser_a('index.php');
}
}



	if(isset($_POST['submit'])){
	$errors = array();

	
	
	
	
	
    if (isset($_POST['etat_operation']) and  !empty($_POST['etat_operation'])){
	if ($_POST['etat_operation'] == '-2'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionné un Etat de l`operation  !!??</p>';
	}
	}
	
	  
									  $APacc=0;
									  $operation=Operation::trouve_par_id($_GET['id_op']);
									  $APacc=$APacc+$operation->ap_initial;
									   $operation_modifs=Operation_modif::trouve_tous_reev($_GET['id_op']);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									  
	
	// new object document
	$situation_f = new Situation_f();

	
	

	$situation_f->id_op =  ($_GET['id_op']); 
	$situation_f->date_situation_f = htmlspecialchars(trim($_POST['date_situation_f']));
	$situation_f->ap_engag = htmlspecialchars(trim($_POST['ap_engag']));
	$situation_f->paiements = htmlspecialchars(trim($_POST['paiements']));
	$situation_f->etat_operation = htmlspecialchars(trim($_POST['etat_operation']));
	$situation_f->obs = htmlspecialchars(trim($_POST['obs']));
	$situation_f->situation = htmlspecialchars(trim($_POST['situation']));
	
		if($_POST['etat_operation']=="Cloturées"){
		$situation_f->etat_gelee =-2 ;
		}else{
			if($_POST['etat_operation']=="Gelee"){
		//$situation_f->etat_operation = htmlspecialchars(trim($_POST['etat_operation']));
        $situation_f->etat_gelee =1	;	
			
		}
		else {
		  $situation_f->etat_gelee =0	;	
		}
		}
		
	if($APacc<$_POST['ap_engag']){
			$msg_error = "<h3> AP actuel ".$APacc." est inferieur au engagement ".$_POST['ap_engag']." </h3>";
		//echo "<script>alert('');</script>";
	}else{
	if($_POST['paiements']>$_POST['ap_engag']){
			$msg_error = "<h3> Paiement: ".$_POST['paiements']." est superieur a l'engagement : ".$_POST['ap_engag']." </h3>";
		//echo "<script>alert('');</script>";
	}	
	
	else{
	
	
	

$operation= Operation :: trouve_par_id($id);
	if (empty($errors)){
   		
			$situation_f->save();
 		$msg_positif = '<p style= "font-size: 20px; ">   Le situation financiere  du   " ' .  html_entity_decode($situation_f->date_situation_f).  '" de l`opération  "' .  html_entity_decode($operation->libelle_op).  '" est bien ajouter  </p><br />';
		
		
 		 
 		}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
	
	
	}
	}
	
	readresser_a("link2.php?id_op=".$_GET['id_op']."");
	}
	

?>
<?php
$titre = "Ajouter  situation_f";
$active_menu = "index";
$header = array('situation_f');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est'){
	require_once("composit/header.php");
}
?>
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">situation financiere</a></li>
                    <li class="active">Mise a jour situation financiere</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_sf" id = "ajouter_sf" action="<?php echo $_SERVER['PHP_SELF'].'?id_op='.$id;?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Mise a jour situation financiere</strong></h3>
                                    
                                </div>
                                <div class="panel-body">
                                  <?php 
								
								   
								  
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>
                                </div>
								
                                <div class="panel-body">                                                                        
                                    
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            
                                            
                                         <div class="form-group">   
                                              <label class="col-md-4  control-label"> Date Situation_f :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                  
                                                    <input type="date" name="date_situation_f" class="form-control" required    />   
											 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											
										
											
											<div class="form-group">   
                                              <label class="col-md-4  control-label"> Ap_engager:</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                   
                                                    <input type="number" step="0.01" id="ap_engag" name="ap_engag" class="form-control"  required    />   
											<span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											
											
											
											 <div class="form-group">   
                                              <label class="col-md-4  control-label"> Paiements :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                  
                                                    <input type="number" step="0.01" id="paiements" name="paiements"   class="form-control" oninput="test();" required    />  
		
		<script language="javascript" type="text/javascript">
		 
	   	function test(){
			
			alert('hhh');
	document.getElementById("paiements").style.background="white";
			var engage=document.getElementById("ap_engag").value;
				var paiement=document.getElementById("paiements").value;
				if(engage
				
				if(parseInt(paiement)>parseInt(engage)){
				alert('paiement doive etre inferieur ou egale a engagement');	
				document.getElementById("paiements").style.background="red";
				}
				if(engage==''){
					return false;
				alert('aucun engagement');	
				document.getElementById("paiements").style.background="red";
				}
			
		}
	   </script>													
											 <span class="input-group-addon"><span></span>DZ</span>
                                                </div>
                                              </div>
                                            </div>
											
											
											
											
										
											
											
											
								</div>
											
											
										
                                        <div class="col-md-6">
                                             
											
											
											  
											
											   <div class="form-group">   
                                              <label class="col-md-4  control-label"> Situation :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                 
                                                    <input type="text" name="situation" class="form-control" required    />   
											  <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              </div>
                                            </div>
												 <div class="form-group">
                                                <label class="col-md-4 control-label"> Etat de l'operation :</label> 
                                                <div class="col-md-6">                                          
                                                    <select class="form-control select" id="etat_operation"  name="etat_operation"  required />
																			
                                                     	<option value="-2"> Sélectionné  Etat de l'operation</option>
															  
																<option value="En cours"> En cours</option>
																<option value="Cloturées"> Clôturées</option>
                                                                      <option value="Gelee"> Gelée</option>																
																<option value="Annulées"> Annulées</option>
																
																
                                                        																			
														</select>   
                                                    												
                                                </div>
												
                                            </div>
											
											
											 <div class="form-group">   
                                              <label class="col-md-4  control-label"> Obsarvation :</label>											
                                              <div class="col-md-6 ">
											    
                                                  
                                                   <textarea class="form-control" rows="3" name="obs"></textarea>
											
                                              
                                              </div>
                                            </div>

                                            
                                           
                                        </div>
										
										
										  
					
                                        
                                    </div>
									
									
									


                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default"type = "reset">Vider les Champs</button>                                    
                                    <button class="btn btn-primary pull-right"type = "submit" name = "submit" onClick=" test();">Mettre a jour</button>
                                </div>
                            </div>
					
                        </form>
                            
                        </div>
                    </div>  
				
<?php 
			$situation_f = Situation_f::trouve_par_operation($id);
		?>				
               <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Liste Situations </strong></h3>
									
                                    <ul class="panel-controls">
                                        <li><button class="btn btn-rounded btn-info" id="voir"><span class="fa fa-eye-o"> Voir tous</span></button></li>
                                    
                                    </ul>                                
                                </div>
                                <div class="panel-body scrollable" >
								
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>date_situation_f</th>
                                              <th>ap_Actuel </th>
                                                <th>ap_engag </th>
                                                <th>paiements</th>
												 <th>PEC</th>
												 <th>taux</th>
												
												  <th>etat operation</th> 
												   <th>obs</th>
												    <th>situation</th>
													 <th>Numéro op</th>
												
                                                <th>Mise à jour </th>
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									
								foreach($situation_f as $situation_f){
									?>
                                      <?php 
									  $APacc=0;
									  $operation=Operation::trouve_par_id($situation_f->id_op);
									  $APacc=$APacc+$operation->ap_initial;
									   $operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									  ?>
                                            <tr id ="<?php echo html_entity_decode($situation_f->id_situation_f); ?>">
                                                <td><?php echo html_entity_decode($situation_f->date_situation_f); ?></td>
                                               <td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
												 <td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
												  <td><?php echo html_entity_decode($situation_f->paiements); ?></td>
												     <td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->
						
												   <td><?php echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%'); ?></td><!-- taux-->
												    <td><?php echo html_entity_decode($situation_f->etat_operation); ?></td>
                                                 <td><?php echo html_entity_decode($situation_f->obs); ?></td>
												 <td><?php echo html_entity_decode($situation_f->situation); ?></td>
                                                <td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->libelle_op);  ?></td>
                                               
                                                <td>
												<?php 
												if($situation_f->etat_operation!='Gelee'  and  $situation_f->etat_operation!='Cloturées'){
												?>
											
												  <a href="edit_sf.php?id=<?php echo $situation_f->id_situation_f;?>"><button class="btn btn-info btn-rounded " style = "text-align: right;"><span class="fa fa-pencil"></span></button><a>
											
												  <button class="btn btn-danger btn-rounded " onClick="delete_row('<?php echo $situation_f->id_situation_f;?>');"><span class="glyphicon glyphicon-trash"></span></button>
												<?php } ?>
													</td>
                                            </tr>
                                  <?php
								}
                                 ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
                     
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
         <script>
	
		</script>
        <!-- MESSAGE BOX-->
		<div class="message-box message-box-danger animated fadeIn" id="message-box-danger" data-sound="fail" >
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="glyphicon glyphicon-trash"></span> Supprimer <strong> les  Données </strong> !!??</div>
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
		
		  <div class="message-box animated fadeIn"  id="mb-voir">
            <div class="mb-container" style="background:#fff">
			
	 <div class="mb-footer">
					 
                        <div class="pull-right">
						<div>
						
                           <button class="btn btn-danger fa fa-times btn-lg mb-control-close"></button> 
						   </div>
                        </div>
                    </div>  
					   
                       <!--***********************-->
					    <div class="panel-body scrollable" >
								
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>date_situation_f</th>
                                              <th>ap_Actuel </th>
                                                <th>ap_engag </th>
                                                <th>paiements</th>
												 <th>PEC</th>
												 <th>taux</th>
												
												  <th>etat operation</th> 
												   <th>obs</th>
												    <th>situation</th>
													 <th>Numéro op</th>
												
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$situation_f = Situation_f::trouve_par_operation_tous($id);
								foreach($situation_f as $situation_f){
									?>
                                      <?php 
									  $APacc=0;
									  $operation=Operation::trouve_par_id($situation_f->id_op);
									  $APacc=$APacc+$operation->ap_initial;
									   $operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									  ?>
                                            <tr id ="<?php echo html_entity_decode($situation_f->id_situation_f); ?>">
                                                <td><?php echo html_entity_decode($situation_f->date_situation_f); ?></td>
                                               <td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
												 <td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
												  <td><?php echo html_entity_decode($situation_f->paiements); ?></td>
												     <td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->
						
												   <td><?php echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%'); ?></td><!-- taux-->
												    <td><?php echo html_entity_decode($situation_f->etat_operation); ?></td>
                                                 <td><?php echo html_entity_decode($situation_f->obs); ?></td>
												 <td><?php echo html_entity_decode($situation_f->situation); ?></td>
                                                <td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->libelle_op);  ?></td>
                                               
                                               
                                            </tr>
                                  <?php
								}
                                 ?>  
                                        </tbody>
                                    </table>
                                </div>  
					   
					   <!--***********************-->
				
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
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-file-input.js"></script>
        <script type="text/javascript" src="js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
				        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
		         <script type="text/javascript" src="js/demo_tables.js"></script> 
			       <script type="text/javascript" src="js/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>	
		<!-- END THIS PAGE PLUGINS -->       
        
        <!-- START TEMPLATE -->
      
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>  
		  <script type="text/javascript" >
		  $('#voir').on('click',function(){
			$('#mb-voir').show();  
			  
		  })
		  $('.mb-control-close').on('click',function(){
			 	$('#mb-voir').hide();  
		  })
		  </script>  
 <style>
	
    .scrollable {
      float: left !important;
      width: 100%;
      overflow: scroll !important ;
      overflow-y: hidden;
	  white-space: nowrap;
 
	  
    }
	
	</style>		
        <!-- END TEMPLATE -->
		
    <!-- END SCRIPTS -->                   
    </body>
</html>






