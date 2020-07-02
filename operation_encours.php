<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_psd' );
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="Accès non autorisé!  ccsdcsdc";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 

}
?>
<?php 
$titre = "Les opérations planifiées";
$active_menu = "index";
$header = array('personne');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_psd' ){
	require_once("composit/header.php");
    
}
?>

             
                   <ul class="breadcrumb">
                  <li><a href="index.php">Acceuil</a></li>  
					  <li class="active"><?php echo $titre ?></li>  
                </ul>
                <!-- END BREADCRUMB -->
                <!-- PAGE TITLE -->
				
				
				
				
		<?php if ( $user->type=='Admin_psc') {?>
                <div class="page-title">                    
                    <h3><span class="fa fa-folder-open"></span> Les opérations planifiées (Programme Sectoriel Centralisé)</h3>
					
                </div>
		<?php }else   if ( $user->type=='Admin_psd') { ?>	
				
				<div class="page-title">                    
                    <h3><span class="fa fa-folder-open"></span> Les opérations planifiées  (Programme Sectoriel Déconcentré)</h3>
					
                </div>
				
		<?php }else if ($user->type=='administrateur'){?>
		     <div class="page-title">                    
                    <h2><span class="fa fa-folder-open"></span> Les opérations planifiées</h2>
					
                </div>
				<?php } ?>
                <!-- END PAGE TITLE -->
          
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                 <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_stru" id = "ajouter_stru" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                            <div class="panel panel-info">
                                
                     		
                                                                                                       
              
							 </div>
							
							   <div class="panel-footer">
							   <div class="row">
							 <?php  if($user->type=='Admin_psc') { ?>
							   <div class="col-md-8">
                                      <div class="form-group">   
                                              <label class="col-md-3 col-xs-12  control-label"> Gestionnaire :</label>											
                                             <div class="col-md-4 col-xs-12">    
	                                                  <select class="form-control select" id="id_ord1"  name="id_ord1" data-live-search="true" required />
																			
                                                     <option value="-2"> Sélectionner  gestionnaire</option>
															
															  <?php $SQL = $bd->requete("SELECT * FROM   ordonnateur ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
															if(($user->type=='Admin_psc' or $user->type=='administrateur') and  $rows["id_prog"]==41){
																
														echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
														}
														
														}
															if($user->type=='Admin_chu' or $user->type=='Admin_est' or $user->type=='Admin_ehs' or $user->type=='Admin_msprh'){
																$ordonnaateur=Ordonnateur::trouve_par_id($user->id_ord);
															
														echo '<option  value = "'.$ordonnaateur->id_ord.'" >'.$ordonnaateur->nom_ord.'</option>';
															
															}
														?>
														
                                                        																			
														</select>   
                                              </div>
                                            </div>   
								</div>
								<div class="col-md-4">											
                                    <button class="btn btn-info pull-left" type ="submit" name ="submit2" id ="submit2">Lister</button>
								</div>
									</div><!--fin row -->
                                </div> 
							
                        
						
							 <?php } else  if($user->type=='Admin_psd') {?>
                           
                       <div class="col-md-8">
                                      <div class="form-group">   
                                              <label class="col-md-3 col-xs-12  control-label"> Gestionnaire :</label>											
                                             <div class="col-md-4 col-xs-12">    
	                                                  <select class="form-control select" id="id_ord1"  name="id_ord1" data-live-search="true" required />
																			
                                                     <option value="-2"> Sélectionner gestionnaire</option>
															
															  <?php $SQL = $bd->requete("SELECT * FROM   ordonnateur ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
															if(($user->type=='Admin_psd' or $user->type=='administrateur') and  $rows["id_prog"]==42){
																
														echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
														}
														
														}
															if($user->type=='Admin_dsp'){
																$ordonnaateur=Ordonnateur::trouve_par_id($user->id_ord);
															
														echo '<option  value = "'.$ordonnaateur->id_ord.'" >'.$ordonnaateur->nom_ord.'</option>';
															
															}
														?>
														
                                                        																			
														</select>   
                                              </div>
                                            </div>   
								</div>
								<div class="col-md-4">											
                                    <button class="btn btn-info pull-left" type ="submit" name ="submit2" id ="submit2">Lister</button>
								</div>
									</div><!--fin row -->
                                </div> 
							
                        </form>
						 </div>
					  
					  
					  
							 <?php  }else if($user->type=='administrateur'){ ?>
					  
					   <div class="col-md-8">
                                      <div class="form-group">   
                                              <label class="col-md-3 col-xs-12  control-label"> Gestionnaire :</label>											
                                             <div class="col-md-4 col-xs-12">    
	                                                  <select class="form-control select" id="id_ord1"  name="id_ord1" data-live-search="true" required />
																			
                                                     <option value="-2"> Sélectionner  gestionnaire</option>
															
															  <?php $SQL = $bd->requete("SELECT * FROM   ordonnateur ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														
																
														echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
														}
														
														
															
														
														?>
														
                                                        																			
														</select>   
                                              </div>
                                            </div>   
								</div>
								<div class="col-md-4">											
                                    <button class="btn btn-info pull-left" type ="submit" name ="submit2" id ="submit2">Lister</button>
								</div>
									</div><!--fin row -->
                                </div> 
							 <?php } ?>
					  
					  
                    		<?php 
function lister_projet($ordonnateur,$user){
	global $bd;

		?>

                                
      
                
                    <!-- START DEFAULT DATATABLE -->
                          
								
								
								<div class="col-md-12">                        
                            <!-- START JUSTIFIED TABS -->
                            <div class="panel panel-default ">
                                
                                <div class="panel-body tab-content">
								
								
								
								<?php if($user->type=='Admin_psc' or $user->type=='Admin_psd' or $user->type=='administrateur') { ?>
                                    <div class="tab-pane active" >
                                          <div class="page-content-wrap">
       			
               <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-seccess">
                                <div class="panel-heading">                                
                                  	 <h3 class="panel-title"><strong>| Liste des opérations planifiées <span style="color:red;font-weight:bold"> &nbsp; En Cours </span>&nbsp; du  :&nbsp; <span style="color:#1caf9a;font-weight:bold"><?php if ( $ord=Ordonnateur::trouve_par_id($ordonnateur)){ echo $ord->nom_ord;}else{}?> </span></strong></h3>
								
                                                                  
                                </div>
                                <div class="panel-body">
								<div class="scrollable">
                                    <table class="table datatable table-triped">
                                        <thead>
                                            <tr>
											<th> Rubrique </th>
											<th>N° d'opération</th>
										<th> Intitulé d'opération</th>
										
                                                <th>Date d'inscription</th>
												     <?php 
										$ordo=Ordonnateur::trouve_par_id($ordonnateur);
                                
										if($ordo->id_prog==42){
										?>
										<th>Type de programme</th>
										<?php } ?>
                                              <th>AP Actuelle </th>
                                                <th>AP Engagée </th>
                                                <th>paiements</th>
												 <th>PEC</th>
												 <th>Taux</th>
												 <th>Observation</th>
												
                                              
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									if ($operations=Operation::trouve_filtre_ord($ordonnateur)){
								
foreach($operations as $operation){
	
			if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
				$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
if($situation_f->etat_operation=='En cours' or $situation_f->etat_operation=='Acheve' ){
									?>
                                      <?php 
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
										
											<td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->num_op);  ?></td>
                                              
											  <td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->libelle_op);  ?></td>
                                               <td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->date_inscription);  ?></td>
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
//operations sans situations
else{
	$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);

									?>
                                      <?php 
									  $APacc=0;
								
									  $APacc=$APacc+$operation->ap_initial  ;
									
									   $operation_modifs=Operation_modif::trouve_tous_reev($operation->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									  ?>
                                            <tr id ="<?php echo html_entity_decode($operation->id_op); ?>">
											<td><?php $rub=Rubrique::trouve_par_code($operation->code_rubrique); echo html_entity_decode($rub->nom_rubrique);  ?></td>
										
											<td><?php  echo html_entity_decode($operation->num_op);  ?></td>
                                              
											  <td><?php  echo html_entity_decode($operation->libelle_op);  ?></td>
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
						
												   <td><?php  if ($APacc!=0){echo html_entity_decode (number_format(0.00,2,'.','').'%');}else echo 0.00; ?></td><!-- taux-->
                                                 <td><?php echo html_entity_decode(""); ?></td>
											
                                              
                                            
                                            </tr>
                                  <?php

	
	

}
//fin operations sans situations
}
}
									
                                 ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							 </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
                     
            <!-- END PAGE CONTENT -->
        </div>   </div>
		
     <?php } ?>
                          
                                
								 
								 <?php }
 //fin fonction lister_projet 
//****************************************
if(isset($_POST['submit2'])){

$ordonnateur=$_POST['id_ord1'];
lister_projet($ordonnateur,$user);	
	
}

?>
                                     								
                             
                                   
                           
            <!-- END PAGE CONTENT -->
        </div>
								 
        <!-- MESSAGE BOX-->
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
		<div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-times"></span> Supprimer <strong> les données </strong> ?</div>
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
		
		
	             <style>

 
   .scrollable {
      float: left !important;
      width: 100%;
      overflow-x: scroll !important ;
    
	  white-space: nowrap;
 
	  
   		
 
	
	</style>
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
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>   
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <!-- END THIS PAGE PLUGINS -->       
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->    
    <!-- END SCRIPTS -->                   
    </body>
</html>

