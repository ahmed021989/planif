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
		 $edit =  Situation_ph::trouve_par_id($id);
	 } elseif ( (isset($_POST['id'])) &&(is_numeric($_POST['id'])) ) { 
		 $id = $_POST['id'];
		 $edit =  Situation_ph::trouve_par_id($id);
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 



	if(isset($_POST['submit'])){
	$errors = array();

	
	
	
	
	
    if (isset($_POST['etat_projet']) and  !empty($_POST['etat_projet'])){
	if ($_POST['etat_projet'] == '-2'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionné un Etat de projet  !!??</p>';
	}
	}
	  
	   
	
	
 
	
	

	
	$edit->date_ph = htmlspecialchars(trim($_POST['date_ph']));
	$edit->etudes = htmlspecialchars(trim($_POST['etudes']));
	
	$edit->eqt = htmlspecialchars(trim($_POST['eqt']));
	$edit->etat_projet = htmlspecialchars(trim($_POST['etat_projet']));
	
	
	$edit->date_ser = htmlspecialchars(trim($_POST['date_ser']));
	$edit->cpo = htmlspecialchars(trim($_POST['cpo']));
	$edit->ces = htmlspecialchars(trim($_POST['ces']));
	$edit->vrd = htmlspecialchars(trim($_POST['vrd']));
	$edit->obs = htmlspecialchars(trim($_POST['obs']));

		$edit->realisation = htmlspecialchars(trim($_POST['realisation']));
	
	
	
$rubrique= Rubrique :: trouve_par_id($id);
$operation= Operation :: trouve_par_id($id);




$msg_positif= '';
 	$msg_system= '';
	if (empty($errors)){
					

 		if ($edit->save()){
		$msg_positif .= '<p style= "font-size: 20px; ">  Il a été mis à jour situation   "' . html_entity_decode($edit->etudes). ' "   .   </p><br />';
														
														
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
$titre = "Modifier  situation phisique";
$active_menu = "index";
$header = array('situation_ph');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est'){
	require_once("composit/header.php");
}
?>
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#">situation Physique</a></li>
                    <li class="active">Modifier un situation Physique</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="Modifier_s_ph" id = "Modifier_s_ph" action="<?php echo $_SERVER['PHP_SELF'].'?id='.$id;?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Modifier situation Physique</strong></h3>
                                    
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
                                              <label class="col-md-4  control-label"> Date situation physique :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                  
                                                    <input type="date" name="date_ph" class="form-control"   value ="<?php if (isset($edit->date_ph)){ echo html_entity_decode($edit->date_ph); } ?>"required    />   
											 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											
											<div class="form-group">   
                                              <label class="col-md-4  control-label"> Etudes :</label>										
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                 
                                                    <input type="text" name="etudes" class="form-control"  value ="<?php if (isset($edit->etudes)){ echo html_entity_decode($edit->etudes); } ?>" required    />   
											  <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
												<div class="form-group">   
                                              <label class="col-md-4  control-label"> consteruction	 :</label>
												<div class="col-md-6 ">	
												<table cellpadding="50" style="text-align:center;">
												<tr><td>CPO</td><td>CES</td><td>VRD</td><td>&nbsp;&nbsp;&nbsp;  </td></tr>
                                              <tr>
											  <td>
											    <div class="input-group">
                                                   
                                                    <input type="number" name="cpo" step="0.01"  max="100" min="0" class="form-control" value ="<?php if (isset($edit->cpo)){ echo html_entity_decode($edit->cpo); } ?>" required    />  
										
													
                                                </div>
                                             
											  </td>
											  <td>
											    <div class="input-group">
                                                   
                                                    <input type="number" name="ces" step="0.01"  max="100" min="0" class="form-control" value ="<?php if (isset($edit->ces)){ echo html_entity_decode($edit->ces); } ?>" required    /> 
									
													
                                                </div>
											  </td>
											  <td>
											    <div class="input-group">
                                                   
                                                    <input type="number" name="vrd" step="0.01" max="100"  min="0"  class="form-control" value ="<?php if (isset($edit->vrd)){ echo html_entity_decode($edit->vrd); } ?>" required    />   
							
											
                                                </div>
												
											  </td>
											  <td style="background:black;color:#fff;font-size:22px">% </td>
											  </tr>
											 
											  </table>
                                            </div>
											</div>
											
											
											
											
											 <div class="form-group">   
                                              <label class="col-md-4  control-label"> Equipements :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                  
                                                    <input type="text" name="eqt"   class="form-control"   value ="<?php if (isset($edit->eqt)){ echo html_entity_decode($edit->eqt); } ?>" required    />   
											<span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											
											
											
											
								</div>
											
											
										
                                        <div class="col-md-6">
                                             
											
											  
											
											 
											   <div class="form-group">   
                                              <label class="col-md-4  control-label"> Date de réception :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                   
                                                    <input type="date" name="date_reception" class="form-control"  value ="<?php if (isset($edit->date_reception)){ echo html_entity_decode($edit->date_reception); } ?>" required    />   
											 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											  
											
											
											
											
											 <div class="form-group">   
                                              <label class="col-md-4  control-label"> Réalisation:</label>											
                                              <div class="col-md-6 ">
											    
                                                <div class="input-group">
                                                 
                                                    <input type="text" name="realisation" class="form-control"  value ="<?php if (isset($edit->realisation)){ echo html_entity_decode($edit->realisation); } ?>" required    />   
											  <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              
                                              </div>
                                            </div>
											
											
											  <div class="form-group">   
                                              <label class="col-md-4  control-label"> Date Mise en service :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                  
                                                    <input type="date" name="date_ser" class="form-control"  value ="<?php if (isset($edit->date_ser)){ echo html_entity_decode($edit->date_ser); } ?>" required    />   
											 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                              </div>
                                            </div>

                                             <div class="form-group">   
                                              <label class="col-md-4  control-label"> Observation / contraintes:</label>											
                                              <div class="col-md-6 ">
											    
                                                <div class="input-group">
                                                 
                                                    <input type="text" name="obs" class="form-control"  value ="<?php if (isset($edit->obs)){ echo html_entity_decode($edit->obs); } ?>" required    />   
											  <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              
                                              </div>
                                            </div>
											
											
											 

                                            
                                           
                                        </div>
										
										
										  
					
                                        
                                    </div>
									
									
									


                                </div>
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
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>






