<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="Accès non autorisé!<br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 
?>
<?php

	if ( (isset($_GET['id_op'])) && (is_numeric($_GET['id_op'])) ) { 
		 $id = $_GET['id_op'];
		 $edit =  Operation::trouve_par_id($id);
	 } elseif ( (isset($_POST['id_op'])) &&(is_numeric($_POST['id_op'])) ) { 
		 $id = $_POST['id_op'];
		 $edit =  Operation::trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
	if(isset($_POST['submit'])){
		
		
	$errors = array();
	
	 if (isset($_POST['id_rubrique']) and  !empty($_POST['id_rubrique'])){
	if ($_POST['id_rubrique'] == '-1'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionner code rubrique !!??</p>';
	}
	}
	
    if (isset($_POST['code_type_prog']) and  !empty($_POST['code_type_prog'])){
	if ($_POST['code_type_prog'] == '-2'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionner un type de  Programme  !!??</p>';
	}
	}
	
	if (isset($_POST['id_ord']) and  !empty($_POST['id_ord'])){
	if ($_POST['id_ord'] == '-3'){
		$errors[] = '<p style= "font-size: 20px; "> Sélectionner un ordonnaateur !!??</p>';
	}
	}
	if (isset($_POST['id_ss']) and  !empty($_POST['id_ss'])){
	if ($_POST['id_ss'] == '-4'){
		$errors[] = '<p style= "font-size: 20px; ">   Sélectionner  sous Sucteur !!??</p>';
	}
	}
	
	
	
	
	
	
	
	
		$edit->num_op = htmlspecialchars(trim($_POST['num_op']));
	    $edit->libelle_op = htmlspecialchars(trim($_POST['libelle_op']));
		 $edit->num_dp = htmlspecialchars(trim($_POST['num_dp']));
		  $edit->ap_initial = htmlspecialchars(trim($_POST['ap_initial']));
		   $edit->date_inscription = htmlspecialchars(trim($_POST['date_inscription']));
		
		 $edit->id_rubrique = ($_POST['id_rubrique']);
		$edit->id_ss = ($_POST['id_ss']);
		 $edit->code_type_prog = htmlspecialchars(trim($_POST['code_type_prog']));
		 $edit->id_ord = ($_POST['id_ord']);
		 
	



 
	
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été mis à jour  "' . html_entity_decode($edit->nom_op) .' ".   </p><br />';
														
														
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
	
}

?>
<?php
$titre = "Modifier  operation";
$active_menu = "index";
$header = array('operation');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est'){
	require_once("composit/header.php");
}
?>


<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#"> operation</a></li>
                    <li class="active">Modifier un  operation</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
				
				
				<?php  
					
				if($user->type=='administrateur' or $user->type=='Admin_psc' or $user->type=='Admin_psd' or $user->type=='Admin_dsp'){
				?>
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="Modifier_operation" id = "id_op" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Modifier  L'operation </strong></h3>
                                    
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
                               
								
                                <div class="panel-body">                                                                        
                                    
                                 
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label"> Numéro opération : </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon">N°</span>
                                                        <input type="text" class="form-control" name ="num_op" value ="<?php if (isset($edit->num_op)){ echo html_entity_decode($edit->num_op); } ?>" required   >
                                                    </div>                                            
                                                 </div>
												
                                            </div> 
                                            
                                           <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label"> libellé opération : </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-check"></span></span>
                                                        <input type="text" class="form-control" name ="libelle_op"  value ="<?php if (isset($edit->libelle_op)){ echo html_entity_decode($edit->libelle_op); } ?>" required  >
                                                    </div>                                            
                                                 </div>
												
                                            </div>
											
											 <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label"> Numéro de loi finance : </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon">N°</span>
                                                        <input type="text" class="form-control" name ="num_dp"    value ="<?php if (isset($edit->num_dp)){ echo html_entity_decode($edit->num_dp); } ?>" required  >
                                                    </div>                                            
                                                 </div>
												
                                            </div>
											
											 <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">AP Initiale : </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon">DZ</span>
                                                        <input type="number" class="form-control" name ="ap_initial"   value ="<?php if (isset($edit->ap_initial)){ echo html_entity_decode($edit->ap_initial); } ?>" required  >
                                                    </div>                                            
                                                 </div>
												
                                            </div>
											
											 <div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label">Date Inscription :</label>
                                               <div class="col-md-4 col-xs-12">                                           
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                        <input type="date" class="form-control" name ="date_inscription"  value ="<?php if (isset($edit->date_inscription)){ echo html_entity_decode($edit->date_inscription); } ?>" required >
                                                    </div>                                            
                                                 </div>
											
                                            </div>
											
										
                                          <div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label"> Code Rubrique:</label>
                                               <div class="col-md-4 col-xs-12">                                         
                                                    <select class="form-control select"   name="id_rubrique"     value ="<?php if (isset($edit->id_rubrique)){ echo html_entity_decode($edit->id_rubrique); } ?>"   data-live-search="true" required />
															<option value="-1"> Sélectionné   Code Rubrique</option>
                                                           <?php $SQL = $bd->requete("SELECT * FROM   rubrique ");
															while ($rows = $bd->fetch_array($SQL))
														{
														if($id!=0 and ($rows["code_rubrique"]=='r1' or $rows["code_rubrique"]=='r2')){
														echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["code_rubrique"].'  /  '.$rows["nom_rubrique"].'</option>';
														}else{if(($id==0) and ($user->type=='administrateur' or $user->type=='Admin_psc')){

														echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["code_rubrique"].'  /  '.$rows["nom_rubrique"].'</option>';

														}
														else {if (($id==0) and ($user->type!='administrateur' )and ($rows["code_rubrique"]=='r1' or $rows["code_rubrique"]=='r2' or $rows["code_rubrique"]=='r3' or $rows["code_rubrique"]=='r4' or $rows["code_rubrique"]=='r5' )){
															
														echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["code_rubrique"].'  /  '.$rows["nom_rubrique"].'</option>';
														}}}	}													?>															
														</select>   
                                                    												
                                                </div>
										   </div>
                                              
											  
												 <div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label">Type de Programme :</label>
                                               <div class="col-md-4 col-xs-12">                                         
                                                    <select class="form-control select"   name="code_type_prog"   value ="<?php if (isset($edit->code_type_prog)){ echo html_entity_decode($edit->code_type_prog); } ?>"   required />
														<option value="-2"> Sélectionné  un  programme</option>	
                                                              <?php $SQL = $bd->requete("SELECT * FROM   type_programme ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["code_type_prog"].'" >'.$rows["code_type_prog"].'  /  '.$rows["nom_type_prog"].'</option>';
														} ?>														
														</select>   
                                                    												
                                                </div>
											
                                            </div>		  								
											
											
											
											
											<div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label"> Nom Ordonnateur:</label>
                                               <div class="col-md-4 col-xs-12">                                         
                                                    <select class="form-control select "   name="id_ord"  value ="<?php if (isset($edit->id_ord)){ echo html_entity_decode($edit->id_ord); } ?>"   required />
														
                                                 <?php 
												 $operation=Operation::trouve_par_id($_GET['id_op']);
												 	$ordonnaateur=Ordonnateur::trouve_par_id($operation->id_ord);
													echo '<option  value = "'.$ordonnaateur->id_ord.'" >'.$ordonnaateur->nom_ord.'</option>';
												  ?>
																											
														</select>   
                                                    												
                                                </div>
								             </div>
											
									

                                             <div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label"> Nom  sous Sucteur:</label>
                                               <div class="col-md-4 col-xs-12">                                         
                                                    <select class="form-control select"   name="id_ss"    value ="<?php if (isset($edit->id_ss)){ echo html_entity_decode($edit->id_ss); } ?>"  data-live-search="true"   required />
														<option value="-4"> Sélectionné  sous Sucteur</option>	
                                                         <?php $SQL = $bd->requete("SELECT * FROM   sous_secteur ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["id_ss"].'" >'.$rows["nom_ssecteur"].'</option>';
														} ?>														
														</select>   
                                                    												
                                                </div>
											  </div>												
                                     

                                </div>
								
                                <div class="panel-footer">
                                                                     
                                    <button class="btn btn-info pull-right"type = "submit" name = "submit">Modifier</button>
                                    <?php echo '<input type="hidden" name="id_op" value="' .$id. '" />';?>
							   </div>
                            </div>
							 </div>
                        </form>
                            
                        </div>
                    </div>  
				<?php }?>

                <!-- END PAGE CONTENT WRAPPER -->                                                
                     
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
		
		
       <div class="message-box  animated fadeIn" data-sound="alert" id="mb-signout">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-sign-out"></span> Déconnexion <strong></strong> ?</div>
                    <div class="mb-content">
                        <p>Êtes-vous sûr de vouloir déconnecter?</p>                    
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
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>






