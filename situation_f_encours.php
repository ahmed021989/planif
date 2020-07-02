<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_msprh');
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
	
	
}






?>
<?php
$titre = "Liste des opérations en cours";
$active_menu = "index";
$header = array('situation_f');
if ($user->type =='administrateur' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_msprh'){
	require_once("composit/header.php");
}
?>
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                  
                    <li class="active">Liste Des Opérations En cours</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
       			
               <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>| Liste des opérations planifiées <span style="color:red;font-weight:bold"> &nbsp; En Cours </span>&nbsp; du  :&nbsp; <span style="color:#1caf9a;font-weight:bold"><?php if ( $ord=Ordonnateur::trouve_par_id($user->id_ord)){ echo $ord->nom_ord;}else{}?> </span></strong></h3>
								
                                                                  
                                </div>
                                <div class="panel-body">
								 <div class="scrollable">
                                    <table class="table datatable table-striped">
                                      <thead>
                                       <tr>
									   <th>Rubrique</th>
									    <th>N° d'opération</th>
										<th> Intitulé d'opération</th>
										<th>Date d'incription</th>
										<?php  
										$ordo=Ordonnateur::trouve_par_id($user->id_ord);
										if($ordo->id_prog==42){
										?>
										<th>Type de programme</th>
										<?php } ?>
                                        <th>AP actuel </th>
                                        <th>AP engagement </th>
                                        <th>Paiements</th>
										<th>PEC</th>
										<th>Taux</th>
										<th>Observation</th>
											
                                       </tr>
                                      </thead>
										 <tbody>
									<?php
									$operations=Operation::trouve_filtre_ord($user->id_ord);
foreach($operations as $operation){
	$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
			if($situation_f = Situation_f::trouve_par_operation2_valider($operation->id_op)){
				if($situation_f->etat_operation=='En cours' ){
								
									  $APacc=0;
									if(  $operation=Operation::trouve_par_id($situation_f->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									   $operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									  ?>
                                            <tr id ="<?php echo html_entity_decode($situation_f->id_situation_f); ?>">
											<td><?php $rub=Rubrique::trouve_par_code($operation->code_rubrique); echo html_entity_decode($rub->nom_rubrique);  ?></td>
											<td><?php  echo html_entity_decode($operation->num_op);  ?></td>
                                              
											  <td><?php  echo html_entity_decode($operation->libelle_op);  ?></td>
                                             <td><?php  echo html_entity_decode($operation->date_inscription);  ?></td>
                                         
										    <?php 
                                       if($ordonnateur->id_prog==42){
									   ?>
										  <td>
										   <?php
										   	$top="";
									        if($operation->topographie=="PN") $top="Programme normal";
									        if($operation->topographie=="PHP") $top="Programme spécial hauts plateaux";
									        if($operation->topographie=="PS") $top="Programme spécial Sud";
												echo "<option value=".$operation->topographie.">".html_entity_decode($top)."</option>"; ?>
											
										   </td>
				                        <?php } ?>
										
                                         
										  <td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
												 <td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
												  <td><?php echo html_entity_decode($situation_f->paiements); ?></td>
												     <td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->
						
												   <td><?php  if ($APacc!=0){echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else echo 0.00; ?></td><!-- taux-->
												 
                                                 <td><?php echo html_entity_decode($situation_f->obs); ?></td>
												
                                              
                                              
                                            </tr>
                                  <?php
}

}
//operations sans situation
else{
 $APacc=0;
									  $APacc=$APacc+$operation->ap_initial  ;
								
									   $operation_modifs=Operation_modif::trouve_tous_reev($operation->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									  ?>
                                            <tr id ="<?php echo html_entity_decode($operation->id_op); ?>">
											<td><?php $rub=Rubrique::trouve_par_code($operation->code_rubrique); echo html_entity_decode($rub->nom_rubrique);  ?></td>
											<td><?php echo html_entity_decode($operation->num_op);  ?></td>
                                              
											  <td><?php echo html_entity_decode($operation->libelle_op);  ?></td>
                                             <td><?php echo html_entity_decode($operation->date_inscription);  ?></td>
                                        
										    <?php 
                                       if($ordonnateur->id_prog==42){
									   ?>
										  <td>
										   <?php
										   	$top="";
									        if($operation->topographie=="PN") $top="Programme normal";
									        if($operation->topographie=="PHP") $top="Programme spécial hauts plateaux";
									        if($operation->topographie=="PS") $top="Programme spécial Sud";
												echo "<option value=".$operation->topographie.">".html_entity_decode($top)."</option>"; ?>
											
										   </td>
				                        <?php } ?>
										 
                                         
										  <td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
												 <td><?php echo html_entity_decode(0); ?></td>
												  <td><?php echo html_entity_decode(0); ?></td>
												     <td><?php echo html_entity_decode($APacc); ?></td><!-- PEC-->
						
												   <td><?php  echo 0.00; ?></td><!-- taux-->
												 
                                                 <td></td>
												
                                              
                                              
                                            </tr>
 <?php	
	
}
}

                                 ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div></div>
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
		
		       <style>

 
   .scrollable {
      float: left !important;
      width: 100%;
      overflow-x: scroll !important ;
    
	  white-space: nowrap;
 
	  
   		
 
	
	</style>

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






