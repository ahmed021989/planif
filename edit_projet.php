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

	if ( (isset($_GET['id_projet'])) && (is_numeric($_GET['id_projet'])) ) { 
		 $id = $_GET['id_projet'];
		 $edit =  Projet::trouve_par_id($id);
	 } elseif ( (isset($_POST['id_projet'])) &&(is_numeric($_POST['id_projet'])) ) { 
		 $id = $_POST['id_projet'];
		 $edit =  Projet::trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
	if(isset($_POST['submit'])){
		
		
	$errors = array();
	
 if (isset($_POST['id_infra']) and  !empty($_POST['id_infra'])){
	if ($_POST['id_infra'] == '-1'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionné  infrastructure  !!??</p>';
	}
	}
	
	 if (isset($_POST['id_ord']) and  !empty($_POST['id_ord'])){
	if ($_POST['id_ord'] == '-2'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionné   ordonnateur  !!??</p>';
	}
	}
	
	
	
	
	
	
	
	
	
	    $edit->nom_projet = htmlspecialchars(trim($_POST['nom_projet']));
	  $edit->id_infra = htmlspecialchars(trim($_POST['id_infra']));
	    $edit->id_ord = htmlspecialchars(trim($_POST['id_ord']));
  $edit->date_lence = htmlspecialchars(trim($_POST['date_lence']));
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été mis à jour  "' . html_entity_decode($edit->nom_projet) .' ".   </p><br />';
														
														
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
$titre = "Modifier  projet";
$active_menu = "index";
$header = array('projet');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est'){
	require_once("composit/header.php");
}
?>


<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#"> projet</a></li>
                    <li class="active">Modifier  projet</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="modifier_infra" id = "modifier_infra" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Modifier projet </strong></h3>
                                    
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
                                                <label class="col-md-3 col-xs-12 control-label">Nom de  projet : </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name ="nom_projet" value ="<?php if (isset($edit->nom_projet)){ echo html_entity_decode($edit->nom_projet); } ?>" required  >
                                                    </div>                                            
                                                 </div>
												
                                            </div>
											
											
											<div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label">Date Lencement :</label>
                                               <div class="col-md-4 col-xs-12">                                           
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                        <input type="date" class="form-control" name ="date_lence" value ="<?php if (isset($edit->date_lence)){ echo html_entity_decode($edit->date_lence); } ?>" required  >
                                                    </div>                                            
                                                 </div>
											
                                            </div>
											
											 <div class="form-group">   
                                              <label class="col-md-3 col-xs-12  control-label"> infrastructure :</label>											
                                              <div class="col-md-4 col-xs-12">    
	                                                  <select class="form-control select" id="id_infra"  name="id_infra" data-live-search="true" required />
																			
                                                     	<option value="-1"> Sélectionné  un projet</option>
															
															 <?php $SQL = $bd->requete("SELECT * FROM   infrastructure ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["id_infra"].'" >'.$rows["nom_infra"].'</option>';
														} ?>		
                                                        																			
														</select>   
                                              </div>
                                            </div>
										
										
                                            <div class="form-group">   
                                              <label class="col-md-3 col-xs-12  control-label"> ordonnateur :</label>											
                                             <div class="col-md-4 col-xs-12">    
	                                                  <select class="form-control select" id="id_ord"  name="id_ord" data-live-search="true" required />
																			
                                                     <option value="-2"> Sélectionné   ordonnateur</option>
															
															  <?php $SQL = $bd->requete("SELECT * FROM   ordonnateur ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
															if(($user->type=='Admin_psd' or $user->type=='administrateur') and  $rows["id_prog"]==42){
																	
														echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
														}
														
														} 
														$SQL = $bd->requete("SELECT * FROM   ordonnateur where id_ord='".$user->id_ord."'");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
														
														
														} 
														
														
														
														
														?>
														
                                                        																			
														</select>   
                                              </div>
                                            </div>
											
                                              
                                     

                                </div>
								
                                <div class="panel-footer">
                                                               
                                    <button class="btn btn-info pull-right"type = "submit" name = "submit">Modifier</button>
                                    <?php echo '<input type="hidden" name="id_projet" value="' .$id . '" />';?>
							   </div>
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
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>






