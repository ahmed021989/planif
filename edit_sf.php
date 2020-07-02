<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
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



if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id'];
		if($situation=Situation_f::trouve_par_id($id)){
$operation=Operation::trouve_par_id($situation->id_op);
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
		 $edit =  Situation_f::trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
		 $edit =  Situation_f::trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
	if(isset($_POST['submit'])){
		
		
	$errors = array();
	
	
    if (isset($_POST['etat_operation']) and  !empty($_POST['etat_operation'])){
	if ($_POST['etat_operation'] == '-2'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionné un Etat de l`operation  !!??</p>';
	}
	}
	
	
	
	
	
		//$edit->id_op =  ($_GET['id_op']); 
	$edit->date_situation_f = htmlspecialchars(trim($_POST['date_situation_f']));

	$edit->ap_engag = htmlspecialchars(trim($_POST['ap_engag']));
	$edit->paiements = htmlspecialchars(trim($_POST['paiements']));
	$edit->etat_operation = htmlspecialchars(trim($_POST['etat_operation']));
	
	$edit->obs = htmlspecialchars(trim($_POST['obs']));
	$edit->situation = htmlspecialchars(trim($_POST['situation']));
	
	
	
	$situation_f=Situation_f::trouve_par_id($id);
	
	
	                               
	
	
	
	
	
	
	if($_POST['paiements']>$_POST['ap_engag']){
			$msg_error = "<h3> Paiement: ".$_POST['paiements']." est superieur a l'engagement : ".$_POST['ap_engag']." </h3>";
		//echo "<script>alert('');</script>";
	}	
	
	else{
	if($_POST['etat_operation']=="Gelee" and (($_POST['paiements']!=0 and $_POST['ap_engag']!=0))){
	  $msg_error = "<h3> Etat de l'opération 'Gelée' mais Paiement ".$_POST['paiements']." est superieur à  0 et Engagement ".$_POST['ap_engag']." superieur à 0  </h3>";
	}
	else{
	

$operation= Operation :: trouve_par_id($id);
	
		
	
if($_POST['etat_operation']=="Cloturées"){
	echo "<script>alert(".$_POST['etat_operation'].")</script>";
		$edit->etat_gelee =-2 ;
		}else{
			if($_POST['etat_operation']=="Gelee"){
		//$situation_f->etat_operation = htmlspecialchars(trim($_POST['etat_operation']));
        $edit->etat_gelee =1	;	
			
		}
		else {
		  $edit->etat_gelee =0	;	
		}
		
		}

 
	
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été mis à jour situation  de l`engagement  "' . html_entity_decode($edit->ap_engag).'" .   </p><br />';
														
														
		}else{
		$msg_error = "
		              <h1>Aucune mise à jour ..??? ! </h1>
                   <p class=\"error\" style= \"font-size: 20px; \" >  S'il vous plaît re- mise à jour à nouveau !!</p>";
		}
 		
 				}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}

	}}}

?>
<?php
$titre = "Modifier situation financiere ";
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
                    <li class="active">Modifier un situation financiere</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="Modifier_sf" id = "Modifier_sf" action="<?php echo $_SERVER['PHP_SELF'].'?id='.$id;?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Modifier situation financiere</strong></h3>
                                    
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
                                        
                                        <div class="col-md-12">
                                            
                                            
                                         <div class="form-group">   
                                              <label class="col-md-3 col-xs-12  control-label"> Date situation financiere :</label>											
                                              <div class="col-md-4 col-xs-12 ">
											    <div class="input-group">
                                                  
                                                    <input type="date" name="date_situation_f" class="form-control" value ="<?php if (isset($edit->date_situation_f)){ echo html_entity_decode($edit->date_situation_f); } ?>" / >     
											 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											
										
											
											<div class="form-group">   
                                              <label class="col-md-3 col-xs-12  control-label"> Ap_engager	 :</label>											
                                              <div class="col-md-4 col-xs-12 ">
											    <div class="input-group">
                                                   
                                                    <input type="number" name="ap_engag" class="form-control" value ="<?php if (isset($edit->ap_engag)){ echo html_entity_decode($edit->ap_engag); } ?>" / >     
											<span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											
											
											
											 <div class="form-group">   
                                              <label class="col-md-3 col-xs-12 control-label"> Paiements :</label>											
                                              <div class="col-md-4 col-xs-12">
											    <div class="input-group">
                                                  
                                                    <input type="number" name="paiements" name="paiements"   class="form-control" value ="<?php if (isset($edit->paiements)){ echo html_entity_decode($edit->paiements); } ?>" oninput="test();" / >   
											 <span class="input-group-addon"><span ></span>DZ</span>
                                                </div>
                                              </div>
                                            </div>
											
											
											
											
							
											
											
										
                                 
                                             
											
											
											
											   <div class="form-group">   
                                              <label class="col-md-3 col-xs-12 control-label"> Situation :</label>											
                                              <div class="col-md-4 col-xs-12 ">
											    <div class="input-group">
                                                 
                                                    <input type="text" name="situation" class="form-control" value ="<?php if (isset($edit->situation)){ echo html_entity_decode($edit->situation); } ?>" / >      
											  <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              </div>
                                            </div>
												 <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label"> Etat de l'operation :</label> 
                                                <div class="col-md-4 col-xs-12">                                          
                                                    <select class="form-control select" id="etat_operation"  name="etat_operation"  value ="<?php if (isset($edit->etat_operation)){ echo html_entity_decode($edit->etat_operation); } ?>" / > 
																			
                                                     	<option value="-2"> Sélectionné  Etat de l'operation</option>
															 
                                                        	<option value="En cours"> En cours</option>
																<option value="Cloturées"> Clôturées</option>
                                                                   <option value="Gelee"> Gelee</option>																
																<option value="Annulées"> Annulées</option>
																
																	
                                                        																			
														</select>   
                                                    												
                                                </div>
												
                                            </div>
											
											
											 <div class="form-group">   
                                              <label class="col-md-3 col-xs-12  control-label"> Obsarvation :</label>											
                                              <div class="col-md-4 col-xs-12 ">
											    
                                                  
                                                   <textarea class="form-control" rows="3" name="obs"  value ="<?php if (isset($edit->obs)){ echo html_entity_decode($edit->obs); } ?>"  ></textarea>
											
                                              
                                              </div>
                                            </div>

                                            
                                           
                                  
										
										
										  
					
                                        
                                    </div>
									
									


                                </div>
																	</br>

                                 <div class="panel-footer">
                                                                     
                                    <button class="btn btn-info pull-right"type = "submit" name = "submit">Modifier</button>
                                    <?php echo '<input type="hidden" name="id" value="' .$id. '" />';?>
							   </div>
                            </div>
                        </form>
                            
                        </div>
                    </div>  
				
                                             
                     
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->
        
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
         <script>
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
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>






