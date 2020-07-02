<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp');
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
	if(isset($_POST['submit'])){
	$errors = array();
	
	
	 if (isset($_POST['id_prog']) and  !empty($_POST['id_prog'])){
	if ($_POST['id_prog'] == '-3'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionner  Code Programme  !!??</p>';
	}
	}
	
	
	

	// new object document
	$structure = new Structure();

	$structure->code_structure = htmlspecialchars(trim(addslashes($_POST['code_structure'])));
	$structure->nom_structure = htmlspecialchars(trim(addslashes($_POST['nom_structure'])));
	$structure->id_prog = ($_POST['id_prog']);
	$prog_geste = Prog_geste:: trouve_par_id($structure->id_prog);

	
	if (empty($errors)){
   		if ($structure->existe()) {
			$msg_error = '<p style= "font-size: 20px; ">   structure  " '  . html_entity_decode($structure->code_structure) . '"  de programme  "'. $prog_geste->code_prog.' " Existe Déja !!!</p><br />';
			
		}else{
			$structure->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">   structure  "  ' .html_entity_decode($structure->code_structure) . '"  de programme   "'. $prog_geste->code_prog.'  " Est bien ajoutée  </p><br />';
		
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
$titre = "Ajouter structure";
$active_menu = "index";
$header = array('structure');
if ($user->type =='administrateur' or 'Admin_dsp'){
	require_once("composit/header.php");
}
?>


<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">Structure</a></li>
                    <li class="active">Ajouter une nouvelle Structure</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_stru" id = "ajouter_stru" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Nouvelle Structure </strong></h3>
                                    
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
                                                     <label class="col-md-3 col-xs-12 control-label">Code de structure : </label>
                                                <div class="col-md-4 col-xs-12">                                              
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name ="code_structure" required/ >
                                                    </div>                                            
                                                 </div>
												
                                            </div>
											 <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Structure :</label>
                                                <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-hospital-o"></span></span>
                                                        <input type="text" class="form-control" name ="nom_structure" required /  >
                                                    </div>                                            
                                                 </div>
											
                                            </div>
											 <div class="form-group">
                                                  <label class="col-md-3 col-xs-12 control-label"> Code Programme:</label>
                                              <div class="col-md-4 col-xs-12">                                         
                                                    <select class="form-control select" id="id_prog"  name="id_prog" data-live-search="true" required />
															<option value="-3"> Sélectionner Code Programme</option>	
                                                         <?php $SQL = $bd->requete("SELECT * FROM  prog_geste ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["id_prog"].'" >'.$rows["code_prog"].'</option>';
														} ?>														
														</select>   
                                                    												
                                                </div>
												
												 <a href="ajouter_prog_gest.php" class="btn btn-primary btn-rounded btn-lg"> + </a>
												
                                            </div>
                                              
                                      

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default"type = "reset">Vider les Champs</button>                                    
                                    <button class="btn btn-primary pull-right"type = "submit" name = "submit">Ajouter</button>
                                </div>
                            </div>
							 </div>
                        </form>
                            
                        </div>
                    </div>  
				
<?php 
		$structure = Structure:: trouve_tous();	
		?>				
              <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Liste des Structures </strong></h3>
									
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>                                
                                </div>
                                <div class="panel-body">
                                   <table class="table datatable">
                                        <thead>
                                            <tr>
                                               
												<th>Code de structure</th>
												<th>Nom de structure</th>
												<th>Programme de gestion</th>
                                                <th>Mise à jour</th>
                                                
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
								foreach($structure as $structure){
									?>
                                      
                                            <tr id ="<?php echo html_entity_decode($structure->id_structure); ?>">
											
                                                
												  <td><?php echo html_entity_decode($structure->code_structure); ?></td>
												   <td><?php echo html_entity_decode($structure->nom_structure); ?></td>
                                                 <td><?php $prog_geste = Prog_geste:: trouve_par_id($structure->id_prog); echo html_entity_decode($prog_geste->code_prog); ?></td>
                                                
                                                <td>
												 	<a style="color:#0f7365;font-size:20px" href="edit_structure.php?id_structure=<?php echo $structure->id_structure;?>" class="glyphicon glyphicon-pencil"> </a>&nbsp &nbsp
												<a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo $structure->id_structure;?>');" class="glyphicon glyphicon-trash"></a>
                                               
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
        
        <!-- MESSAGE BOX-->
		<div class="message-box message-box-danger animated fadeIn" id="message-box-danger" data-sound="fail" >
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="glyphicon glyphicon-trash"></span> Supprimer <strong> les  Données </strong> !!??</div>
                    <div class="mb-content">
                        <p>Etes-vous sûr de vouloir supprimer cette ligne?</p>                    
                        <p>Appuyez sur Oui pour supprimer </p>
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






