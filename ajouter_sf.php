<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="Accès non autorisé! <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 
?>
<?php

if ( (isset($_GET['id_op'])) && (is_numeric($_GET['id_op'])) ) {
$id = $_GET['id_op'];


$sql=$bd->requete('select * from situation_f where id_op='.$id.' order by id_situation_f DESC limit 1');
while($row=mysqli_fetch_array($sql)){
	
if($row['valider']==0 or ($row['etat_gelee']==1) ){
readresser_a('ajouter_operation.php?id_projet='.$_GET['id_projet'].'');
}
}	


$id_projet=$_GET['id_projet'];
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
	
	
		if($_POST['etat_operation']=="Cloturee"){
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
			$msg_error = "<h3> AP actuelle '".$APacc."' est inférieur à AP engagée '".$_POST['ap_engag']."' </h3>";
		//echo "<script>alert('');</script>";
	}else{
	if($_POST['paiements']>$_POST['ap_engag']){
			$msg_error = "<h3> Paiement: '".$_POST['paiements']."' est supérieur à AP engagée : '".$_POST['ap_engag']."' </h3>";
		//echo "<script>alert('');</script>";
	}	
	
	else{
	
	
	

$operation= Operation :: trouve_par_id($id);
if($user->type=="administrateur" or $user->type=="Admin_psd" or $user->type=="Admin_psd" or $user->type=="dsp" or $user->type=="chu" or $user->type=="ehs" or  $user->type=="est"){
	$sql=$bd->requete("update situation_f set last=0 where id_op=".$id."");
	$situation_f->valider=1;
	
	$situation_f->last=1;
}
	if (empty($errors)){
   		
			$situation_f->save();
 		$msg_positif = '<p style= "font-size: 20px; ">   Le situation financiere  du   " ' .  html_entity_decode($situation_f->date_situation_f).  '" de l`opération  "' .  html_entity_decode($operation->libelle_op).  '" est bien ajouter  </p><br />';
		if($user->type=="administrateur" or $user->type=="Admin_psd" or $user->type=="Admin_psd" or $user->type=="dsp" or $user->type=="chu" or $user->type=="ehs" or  $user->type=="est"){
		echo "<script>alert('Situation actualisée avec succès '); window.location.replace('ajouter_operation.php?id_projet=".$_GET['id_projet']."');</script>";
		}
		else{
		echo "<script>alert('Attente de validation du Directeur .'); window.location.replace('ajouter_operation.php?id_projet=".$_GET['id_projet']."');</script>";
		}
 		 
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
	
	//readresser_a("link2.php?id_op=".$_GET['id_op']."");
	}
	

?>
<?php
$titre = "Actualiser la situation financière";
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
                    <li><a href="#">Situation financière</a></li>
                    <li class="active">Actualisation </li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_sf" id = "ajouter_sf" action="<?php echo $_SERVER['PHP_SELF'].'?id_op='.$id."&id_projet=".$_GET['id_projet'];?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Actualiser la situation financière de l'opération: <span style="color:#1caf9a"><?php echo $operation->libelle_op?></span> </strong></h3>
                                    
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
                                              <label class="col-md-4  control-label"> Date :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                  
                                                    <input type="date" name="date_situation_f" class="form-control" required    />   
											 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											
										
											
											<div class="form-group">   
                                              <label class="col-md-4  control-label"> Engagement:</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                   
                                                    <input type="number" step="0.01" id="ap_engag" name="ap_engag" class="form-control"  required    />   
											<span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											
											
											
											 <div class="form-group">   
                                              <label class="col-md-4  control-label"> Paiement :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                  
                                                    <input type="number" step="0.01" id="paiements" name="paiements"   class="form-control" oninput="test();" required    />  
		
												
											 <span class="input-group-addon"><span></span>DZ</span>
                                                </div>
                                              </div>
                                            </div>
											
											
											
											
										
											
											
											
								</div>
											
											
										
                                        <div class="col-md-6">
                                             
											
											
											  
											
												 <div class="form-group">
                                                <label class="col-md-4 control-label"> Etat de l'opération :</label> 
                                                <div class="col-md-6">                                          
                                                    <select class="form-control select" id="etat_operation"  name="etat_operation"  required />
																			
                                                     	<option value="-2"> Sélectionner l'état de l'opération</option>
															  
																<option value="En cours"> En cours</option>
																<option value="Gelee"> Gelée</option> 	
															
																
																
                                                        																			
														</select>   
                                                    												
                                                </div>
												
                                            </div>
											
											
											 <div class="form-group">   
                                              <label class="col-md-4  control-label"> Observation :</label>											
                                              <div class="col-md-6 ">
											    
                                                  
                                                   <textarea class="form-control" rows="3" name="obs"></textarea>
											
                                              
                                              </div>
                                            </div>

                                            
                                           
                                        </div>
										
										
										  
					
                                        
                                    </div>
									
									
									


                                </div>
                                <div class="panel-footer">
                                    <a class="btn btn-danger" href='ajouter_operation.php?id_projet=<?php echo $_GET['id_projet'];  ?>'>Retour</a>                                    
                                    <button class="btn btn-primary pull-right"type = "submit" name = "submit" onClick="return test();">Actualiser</button>
                                </div>
                            </div>
					
                        </form>
                            
                        </div>
                    </div>  
					
                                      <center>  <button class="btn btn-info btn-lg" id="voir"><span class="fa fa-eye-o"> Voir toutes les situations précédentes</span></button></center>
                                    
                              
				

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
                        <p>Êtes-vous sûr de vouloir vous déconnecter?</p>                    
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
            <div class="mb-container" style="background:#fff;margin-top:-200px">
			
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
                                                <th>Date</th>
                                                <th>AP Actuelle </th>
                                                <th>Engagement </th>
                                                <th>Paiement</th>
												 <th>PEC</th>
												 <th>Taux</th>
												 <th>Etat d'opération</th> 
												 <th>Obs</th>
												
												
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
		  		
		 
	   	function test(){
			
			
	document.getElementById("paiements").style.background="white";
	document.getElementById("paiements").style.color="#000";
	document.getElementById("ap_engag").style.background="white";
	document.getElementById("ap_engag").style.color="#000";
			var engage=document.getElementById("ap_engag").value;
				var paiement=document.getElementById("paiements").value;
			
				
				if(parseInt(paiement)>parseInt(engage)){
				
				alert('le montant des paiements doit être inferieur ou égale au montant engagé');	
				document.getElementById("paiements").style.background="red";
				document.getElementById("paiements").style.color="#fff";
					return false;
				}
				if(engage==''){
					
				alert('aucun engagement');	
				document.getElementById("ap_engag").style.background="red";
				document.getElementById("ap_engag").style.color="#fff";
				return false;
				}
			
		}
	   
		  
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






