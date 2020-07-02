<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system =" Accès non autorisé! <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 
?>
<?php
	if(isset($_POST['submit'])){
	$errors = array();
	

	// new object document
	$secteur = new secteur();

	$secteur->Nom_derc_ar = htmlentities(trim($_POST['Nom_derc_ar']));
	$secteur->Nom_derc_fr = htmlentities(trim($_POST['Nom_derc_fr']));
	$secteur->Add_derc_ar = htmlentities(trim($_POST['Add_derc_ar']));
	$secteur->Add_derc_fr = htmlentities(trim($_POST['Add_derc_fr']));
	$secteur->Num_tele_der = htmlentities(trim($_POST['Num_tele_der']));
	$secteur->Num_fax = htmlentities(trim($_POST['Num_fax']));
	

	
	if (empty($errors)){
   		if ($secteur->existe()) {
			$msg_error = '<p style= "font-size: 20px; ">   secteur  " '  . html_entity_decode($secteur->Nom_derc_fr) . ' " existe Déja !!!</p><br />';
			
		}else{
			$secteur->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">   secteur  "  ' .html_entity_decode($secteur->Nom_derc_fr) . '  " est bien ajouté  </p><br />';
		
		}
 		 
 		}else{
		// errors occurred
		$msg_error = '<h1> !! err  </h1>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}

?>
<?php
$titre = "Ajouterun nouveau secteur";
$active_menu = "index";
$header = array('secteur');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est'){
	require_once("composit/header.php");
}
?>


<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">paramètres</a></li>
                    <li class="active">Ajouter un nouveau secteur</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_four" id = "ajouter_four" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Ajouter  Employé </strong></h3>
                                    
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
                                                <label class="col-md-3 control-label">Nom : </label>
                                                <div class="col-md-6">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name ="nom_emp" required/ style = "text-align: right;">
                                                    </div>                                            
                                                 </div>
												 <label class="col-md-3 "> :  اللقب  </label>
                                            </div>
											 <div class="form-group">
                                                <label class="col-md-3 control-label">Prénom :</label>
                                                <div class="col-md-6">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name ="prenom_emp" required/ style = "text-align: right;" >
                                                    </div>                                            
                                                 </div>
												 <label class="col-md-3 ">:  الإســم </label>
                                            </div>
											 <div class="form-group">
                                                <label class="col-md-3 control-label"> N° beraux / رقم المكتب:</label>
                                                <div class="col-md-6">                                          
                                                    <select class="form-control select" id="Id_br" value = "<?php echo $num_br;?>" name="Id_br" data-live-search="true" required/>
															<?php $SQL = $bd->requete("SELECT * FROM `bureau`,`service` where bureau.`Id_ser`= service.`Id_ser`");
															while ($rows = $bd->fetch_array($SQL))
														{
														 
														echo '<option  value = "'.$rows["id_br"].'" >'.$rows["num_br"]. '    ' .$rows["lib_ser"].'</option>';
														} ?>															   
														</select>   
                                                    												
                                                </div>
												
												 <a href="ajouter_bereau.php" class="btn btn-primary btn-rounded btn-lg"> + </a>
												
                                            </div>
                                              
                                        </div>
                                        <div class="col-md-6">
                                             
											
											<div class="form-group">   
                                              <label class="col-md-4  control-label">الرتبـــــة / Grade :</label>											
                                              <div class="col-md-8 ">
											    <div class="input-group">
                                                   <span class="input-group-addon"><span class="fa fa-phone"></span></span>
                                                    <input type="text" name="grade_emp" class="form-control" required    />   
											
                                                </div>
                                              </div>
                                            </div>

                                            
                                            
                                            
                                           
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="panel-footer">
                                    <button class="btn btn-default"type = "reset">Vider les Champs</button>                                    
                                    <button class="btn btn-primary pull-right"type = "submit" name = "submit">Ajouter</button>
                                </div>
                            </div>
                        </form>
                            
                        </div>
                    </div>  
				
<?php 
			$employe = employe::trouve_tous();
		?>				
              <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Listes des Employés </strong></h3>
									
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
                                                <th>Id_Employé</th>
                                                <th>Nom / اللقب</th>
                                                <th>N° beraux / رقم المكتب</th>
                                                <th>Grade/الرتبـــــة</th>
                                                <th>Mise à jour </th>
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
								foreach($employe as $employe){
									?>
                                      
                                            <tr id ="<?php echo html_entity_decode($employe->num_emp); ?>">
                                                <td><?php echo html_entity_decode($employe->num_emp); ?></td>
                                                <td><?php echo html_entity_decode($employe->nom_emp); ?>&nbsp;<?php echo html_entity_decode($employe->prenom_emp); ?></td>
                                                
                                                <td><?php $bureau = Bureau:: trouve_par_id($employe->Id_br); echo html_entity_decode($bureau->num_br);  ?></td>
                                                <td><?php echo html_entity_decode($employe->grade_emp); ?></td>
                                                <td>
												  <button class="btn btn-danger btn-rounded " onClick="delete_row('<?php echo $employe->num_emp;?>');"><span class="glyphicon glyphicon-trash"></span></button>
												   <a href="edit_emp.php?id=<?php echo $employe->num_emp;?>"><button class="btn btn-info btn-rounded " style = "text-align: right;"><span class="fa fa-pencil"></span></button><a>
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
		 <div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Supprimer<strong>Données </strong> ?</div>
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






