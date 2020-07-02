<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' );
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

	if ( (isset($_GET['id_type_prog'])) && (is_numeric($_GET['id_type_prog'])) ) { 
		 $id = $_GET['id_type_prog'];
		 $edit =  Type_programme::trouve_par_id($id);
	 } elseif ( (isset($_POST['id_type_prog'])) &&(is_numeric($_POST['id_type_prog'])) ) { 
		 $id = $_POST['id_type_prog'];
		 $edit =  Type_programme::trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
	if(isset($_POST['submit'])){
		
		
	$errors = array();
	
	
	if (isset($_POST['topographie']) and  !empty($_POST['topographie'])){
	if ($_POST['id_prog'] == '-6'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionné Programme Sectoriel de Développement: !!??</p>';
	}
	}
	
	
		$edit->code_type_prog = htmlspecialchars(trim($_POST['code_type_prog']));
	    $edit->nom_type_prog = htmlspecialchars(trim($_POST['nom_type_prog']));
	 $edit->designation = htmlspecialchars(trim($_POST['designation']));
		 $edit->topographie = htmlspecialchars(trim($_POST['topographie']));
	



 
	
	
	$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été mis à jour  "' . html_entity_decode($edit->code_type_prog) .' ".   </p><br />';
														
														
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
$titre = "Modifier type programme";
$active_menu = "index";
$header = array('type_programme');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est'){
	require_once("composit/header.php");
}
?>


  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">type programme</a></li>
                    <li class="active">Modifier type programme</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="type_programme" id = "id_type_prog" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Modifier  type programme </strong></h3>
                                    
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
                                    
                                   
                                            
                                           <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Code type programme : </label>
                                                <div class="col-md-4 col-xs-12">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control"   name ="code_type_prog" value ="<?php if (isset($edit->code_type_prog)){ echo html_entity_decode($edit->code_type_prog); } ?>" >
														
                                                    </div>                                            
                                                 </div>
											
                                            </div>
											 <div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label">Nom type programme : </label>
                                                <div class="col-md-4 col-xs-12">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-sitemap"></span></span>
                                                        <input type="text" class="form-control"    name ="nom_type_prog" value ="<?php if (isset($edit->nom_type_prog)){ echo html_entity_decode($edit->nom_type_prog); } ?>"  >
														
                                                    </div>                                            
                                                 </div>
											
                                            </div>
											<div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Designation</label>
                                        <div class="col-md-4 col-xs-12">
										<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-book"></span></span>
                                            <input type="text" class="form-control"   name ="designation" value ="<?php if (isset($edit->designation)){ echo html_entity_decode($edit->designation); } ?>" >
                                        </div>
                                       </div>
										   </div>	
										<div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label"> Programme Sectoriel de Développement:</label>
                                               <div class="col-md-4 col-xs-12">                                         
                                                    <select class="form-control select"   name="topographie" data-live-search="true"  value ="<?php if (isset($edit->topographie)){ echo html_entity_decode($edit->topographie); } ?>" required />
														
												<option value="-6"> Sélectionné  Programme Sectoriel de Développement</option>
														<option  value = "PN" >Programme Normal</option>
														<option  value = "PHP" >Programme Spécial  Des Wilayas Hauts Plateaux</option>
														<option  value = "PS" >Programme Spécial Des Wilayas Sud </option>
														
																											
														</select> 
                                                         															
													
                                                    												
                                                </div>
										
                                            </div>
                                              
                                      

                                </div>
                                  <div class="panel-footer">
                                                                     
                                    <button class="btn btn-info pull-right"type = "submit" name = "submit">Modifier</button>
                                    <?php echo '<input type="hidden" name="id_type_prog" value="' .$id. '" />';?>
							   </div>
                            </div>
                        </form>
                            
                        </div>
                    </div>  
				
<?php 
			$type_programme = Type_programme::trouve_tous();
		?>				
              <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Listes des types programmes </strong></h3>
									
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
                                               
												<th>Code type programme</th>
												<th>nom type programme</th>
												<th>Designation</th>
												<th>Programme Sectoriel de Développement</th>
                                                <th>Mise à jour</th>
                                                
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
								foreach($type_programme as $type_programme){
									?>
                                      
                                            <tr id ="<?php echo html_entity_decode($type_programme->id_type_prog); ?>">
											
                                                
												  <td><?php echo html_entity_decode($type_programme->code_type_prog); ?></td>
												   <td><?php echo html_entity_decode($type_programme->nom_type_prog); ?></td>
                                                <td><?php echo html_entity_decode($type_programme->designation); ?></td>
													<td><?php echo html_entity_decode($type_programme->topographie); ?></td>
											   <td>
												 	<a style="color:#0f7365;font-size:20px" href="edit_type_programme.php?id_type_prog=<?php echo $type_programme->id_type_prog;?>" class="glyphicon glyphicon-pencil"> </a>&nbsp &nbsp
												<a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo $type_programme->id_type_prog;?>');" class="glyphicon glyphicon-trash"></a>
                                               
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






