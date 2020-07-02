<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
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

if ( (isset($_GET['id_projet'])) && (is_numeric($_GET['id_projet'])) ) {
$id = $_GET['id_projet'];
	
	
}




	if(isset($_POST['submit'])){
	$errors = array();

	
	
	
	
	
    if (isset($_POST['etat_projet']) and  !empty($_POST['etat_projet'])){
	if ($_POST['etat_projet'] == '-2'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionner un état de l`operation  !!??</p>';
	}
	}
	 
	    if (isset($_POST['libelle_op']) and  !empty($_POST['libelle_op'])){
	if ($_POST['libelle_op'] == '-3'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionner libélle de l`operation  !!??</p>';
	}
	}
	    if (isset($_POST['code_rubrique']) and  !empty($_POST['code_rubrique'])){
	if ($_POST['code_rubrique'] == '-4'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionner code de rubrique  !!??</p>';
	}
	}
	
	
	
	// new object document
	$situation_ph = new Situation_ph();

	
	

	$situation_ph->id_projet =  ($_GET['id_projet']); 
	$situation_ph->date_ph = htmlspecialchars(trim($_POST['date_ph']));
	$situation_ph->etudes = htmlspecialchars(trim($_POST['etudes']));
	
	$situation_ph->eqt = htmlspecialchars(trim($_POST['eqt']));

	$situation_ph->date_reception = htmlspecialchars(trim($_POST['date_reception']));
	
	$situation_ph->cpo = htmlspecialchars(trim($_POST['cpo']));
	$situation_ph->ces = htmlspecialchars(trim($_POST['ces']));
	$situation_ph->vrd = htmlspecialchars(trim($_POST['vrd']));
	$situation_ph->date_ser = htmlspecialchars(trim($_POST['date_ser']));
	$situation_ph->obs = htmlspecialchars(trim($_POST['obs']));
	$situation_ph->realisation = htmlspecialchars(trim($_POST['realisation']));
	
	

	if (empty($errors)){
   		
			$situation_ph->save();
 		$msg_positif = '<p style= "font-size: 20px; ">   La situation physique du Etude " ' .  html_entity_decode($situation_ph->etudes).  '"est bien ajouter  </p><br />';
		
		
 		 
 		}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
		
	    $msg_error .= '</p>';	  
	}
	}


?>
<?php
$titre = "Ajouter  situation phisique";
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
                    <li class="active"> situation Physique mise à jour</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_sf" id = "ajouter_sf" action="<?php echo $_SERVER['PHP_SELF'].'?id_projet='.$id;?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>actualiser la situation Physique</strong></h3>
                                    
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
                                                  
                                                    <input type="date" name="date_ph" class="form-control" required    />   
											 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
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
        $projet=Projet::trouve_par_id($id);
		
		if($user->type=='Admin_psd' or $user->type=='administrateur' or  $user->id_ord==$projet->id_ord) {
					?>	
              <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Liste des Situations phisiques </strong></h3>
									
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>                                
                                </div>
                                <div class="panel-body scrollable">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
											<th>Gestionnaire</th>
										<th>Infrastructure</th>
                                                <th>Date Situation phisique</th>
                                                <th>etudes </th>
                                                <th>construction </th>
                                                <th>Equipements </th>
												 <th>date reception</th>
												
												  <th>Réalisation</th> 
												   <th>Observation</th> 
												 
												   <th> Mise en service</th>
												
                                                <th>Mise à jour </th>
                                            </tr>
                                        </thead>
										 <tbody>
								<?php 
			if ($situation_ph = Situation_ph::trouve_par_projet($id)){
							
			
		?>
                                      
                                              <tr id ="<?php echo html_entity_decode($situation_ph->id_situation_ph); ?>">
											 <td><?php $projet = Projet :: trouve_par_id($id);echo html_entity_decode($projet->nom_projet); ?></td>
											  <td><?php $infrastructur = Infrastructure :: trouve_par_id($id);echo html_entity_decode($infrastructur->nom_infra); ?></td>
											   <td><?php echo html_entity_decode($situation_ph->date_ph); ?></td>
                                                <td><?php echo html_entity_decode($situation_ph->etudes); ?></td>
												 <td><strong><?php echo html_entity_decode($situation_ph->cpo); ?>%|<?php echo html_entity_decode($situation_ph->ces); ?>%|<?php echo html_entity_decode($situation_ph->vrd); ?>%</strong></td>
												  <td><?php echo html_entity_decode($situation_ph->eqt); ?></td>
												   <td><?php echo html_entity_decode($situation_ph->date_reception); ?></td>
												
													   <td><?php echo html_entity_decode($situation_ph->realisation); ?></td>
													      <td><?php echo html_entity_decode($situation_ph->obs); ?></td>
                                                  
											            	 <td><?php echo html_entity_decode($situation_ph->date_ser); ?></td>
                                               
                                                <td >
												<a href="edit_s_ph.php?id=<?php echo $situation_ph->id_situation_ph;?>"><button class="btn btn-info btn-rounded " style = "text-align: right;"><span class="fa fa-pencil"></span></button><a>
											
												  <button class="btn btn-danger btn-rounded " onClick="delete_row('<?php echo $situation_ph->id_situation_ph;?>');"><span class="glyphicon glyphicon-trash"></span></button>
												  	</td>
                                            </tr>
			<?php } } ?>
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
        
		
		<style>
	
    .scrollable {
      float: left !important;
      width: 100%;
      overflow: scroll !important ;
      overflow-y: hidden;
	  white-space: nowrap;
 
	  
    }
	
	</style>
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>






