<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'ministre_SG' or 'Admin_psc' or 'Admin_psd' or 'Admin_dsp' or 'dsp' or 'Admin_ehs' or 'Admin_chu' or 'Admin_est' or 'ehs' or 'chu' or 'est' or 'dfm' );
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
$titre = "Etat d'avancement";
$active_menu = "index";
$header = array('situation_f');
if ($user->type =='administrateur' or 'ministre_SG' or 'Admin_dsp' or 'dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'ehs' or 'chu' or 'est' or 'dfm'){
	require_once("composit/header.php");
}
?>
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                  
                    <li class="active">Etat d'avancement</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                  
				
<?php 

		
		?>	
                          <form class="form-horizontal" name="filtre" id = "filtre" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <div class="panel panel-info">
						    <div class="panel-body">                                                                        
                                     <div class="row">
									 
									    <div class="col-md-6">							
											
											<div class="form-group">
                                               <label class="col-md-4 control-label"> Nom Gestionnaire:</label>
                                               <div class="col-md-6">                                         
                                                    <select class="form-control select" data-live-search="true"  id="id_ord"  name="id_ord"   required />
														
                                                <?php 
												 	if($user->type=='administrateur' or $user->type == 'ministre_SG' ){
														?>
															<option value="-3"> Sélectionner  un  Gestionnaire</option>	
                                                       <?php															
														if ($id!=0){
															//echo "<script>alert(".$id.")</script>";
															$projet=Projet::trouve_par_id($id);
															$ordonnaateur=Ordonnateur::trouve_par_id($projet->id_ord);
															if($ordonnaateur->id_ord!=1){
														echo '<option  value = "'.$ordonnaateur->id_ord.'" >'.$ordonnaateur->nom_ord.'</option>';
															}
															
														 
														
														}else{
																
														}
														}
														
												 $SQL = $bd->requete("SELECT * FROM   ordonnateur ");
												 if($user->type=='Admin_psc' or $user->type=='Admin_psd'){
												 ?>
															<option value="-3"> Sélectionner  un  Gestionnaire</option>	
                                                       <?php
												 }
															while ($rows = $bd->fetch_array($SQL))
														{
														if($user->type=='Admin_psc' and $rows["id_prog"]==41 ){
															
															if( $rows["id_ord"]!=1){
													echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
															}
														}else{
															if($user->type=='Admin_psd' and $rows["id_prog"]==42){
															
														echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
														}
														
															if(($user->type=='administrateur' or $user->type == 'ministre_SG') and $id==0  and $rows["id_ord"]!=1){
															
													echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
	
															}
														//*****************
														
													   
														 
														
														//*************
														else{
															if($user->type=='Admin_dsp' or ($user->type=='dsp') or ($user->type=='Admin_chu') or ($user->type=='Admin_ehs') or ($user->type=='ehs') or ($user->type=='chu') or ($user->type=='est') or ($user->type=='Admin_est') or($user->type=='Admin_msprh') or ($user->type=='dfm')  ){
															$SQL = $bd->requete("SELECT * FROM   ordonnateur where id_ord='".$user->id_ord."'");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
														
														
														} 
									
															}
															}
															}} ?>
																											
														</select>   
                                                    												
                                                </div>
					 </div>
					<br>
					 </div>
									 
									 
									 
									 
                                       <div class="col-md-6">
						  <div class="form-group">
                                               <label class="col-md-4 control-label"> Rubrique:</label>
                                               <div class="col-md-6">                                         
                                                    <select class="form-control select"   name="code_rubrique" data-live-search="true" required />
															<option value="tous"> Sélectionner la Rubrique</option>
                                                                              <?php $SQL = $bd->requete("SELECT * FROM   rubrique ");
															while ($rows = $bd->fetch_array($SQL))
														{
														if($id!=0 and ($rows["code_rubrique"]=='r1' or $rows["code_rubrique"]=='r2')){
														echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["code_rubrique"].'  /  '.$rows["nom_rubrique"].'</option>';
														}else{if(($id==0) and ($user->type=='administrateur' or $user->type == 'ministre_SG' or $user->type=='Admin_psc')){

														echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["nom_rubrique"].'</option>';

														}
														else {if (($id==0) and ($user->type!='administrateur' or $user->type == 'ministre_SG')and ($rows["code_rubrique"]=='r1' or $rows["code_rubrique"]=='r2' or $rows["code_rubrique"]=='r3' or $rows["code_rubrique"]=='r4' or $rows["code_rubrique"]=='r5' )){
															
														echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["nom_rubrique"].'</option>';
														}}}	}													?>													
														</select>   
                                                    												
                                                </div>
										
                                            </div>
							</div>
							<br>
      </div>
                      
					  <div class="row">
					  
					  
					          <div class="col-md-6">
						  <div class="form-group">
                                               <label class="col-md-4 control-label"> Etat d'opération:</label>
                                               <div class="col-md-6">                                         
                                                    <select class="form-control select" id="etat_operation"   name="etat_operation" data-live-search="true" required />
															<option value="tous"> Sélectionner l'état d'opération</option>
															
															<option value="En cours"> En cours</option>
															<option value="Gelee"> Gelée</option>
														
                                                                              												
														</select>   
                                                    												
                                                </div>
										
                                            </div>
											<br>
							</div>
					  
					  
					      
                                   
					  
					  
					<div class="col-md-6">	
					  <div class="form-group">
                                               <label class="col-md-4  control-label">Au Date:</label>
                                               <div class="col-md-6 col-xs-12">                                           
                                                    <div class="input-group">
                                                       
                                                        <input type="date" class="form-control col-md-4" name ="date_s"  >
														 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    </div>                                            
                                                 </div>
											
                          </div>
						  <br>
						</div>
<br>
					
											
                                <div class="panel-footer">
                                                                       
                                    <button class="btn btn-primary pull-right" type ="submit" onclick="return valide();" id="submit" name ="submit">Filtrer</button>
                                </div>
								 </div><!-- FIN ROW -->
								 </div>
								  </div>
						  </form>
<?php 

function filtre($rubrique,$user,$ord,$date,$etat){
	echo "<script> alert(".$rubrique.");</script>";
	$rubri=Rubrique::trouve_par_code($rubrique);
	$ordonnateur=Ordonnateur::trouve_par_id($ord);
	$date_d="";
	if(!$date){
	$date_d=date('d-m-Y');	
	}
	else
	{
		$date_d=$date;
	}
	$e="";
	if($etat=="En cours"){
		$e=" des opérations en cours ";
	}
	if($etat=="Gelee"){
		$e=" des opérations gelées ";
	}
		
?>
               <div class="page-content-wrap"> 
<?php if($rubrique!="tous"){  ?>               
<span class="pull-left" style="font-size:14px;font-weight:bold;color:blue">|  Etat d'avancement    :<?php echo $e."  du :".$ordonnateur->nom_ord. " par Rubrique :".$rubri->nom_rubrique." Arreté au " .$date_d; ?>  </span>
		
<?php }else { ?>
<span class="pull-left" style="font-size:14px;font-weight:bold;color:blue">|  Etat d'avancement  :<?php echo $e."  du :".$ordonnateur->nom_ord ." Arrete au " .$date_d; ?>  </span>


<?php } ?>
		<a  href='sauvgarde/pdf/imprimer_filtrage.php?var=<?php echo $rubrique."|".$ord."|".$date."|".$etat; ?>' class='btn btn-info btn-rounded pull-right' target="_blank"><img width="20" src="img/icons/pdf.png"> imprimer</a>&nbsp;
		&nbsp;<a  href='export_excel_filtre.php?var=<?php echo $rubrique."|".$ord."|".$date."|".$etat;  ?>' class='btn btn-danger btn-rounded pull-right' ><img width="20" src="img/icons/xls.png"> Export excel</a>

                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Liste des situations  </strong></h3>
									
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>                                
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable table-striped">
                                        <thead>
                                            <tr>
										
											    <th>Numéro d'opération</th>
											    <th>Intitulé</th>
											   <?php 
											   if($ordonnateur->id_prog==42){
											   ?>
                                                <th>Type de programme</th>
											   <?php } ?>
                                                <th>Date d'inscription </th>
                                                <th style="width: 100px">AP initiale </th>
												<th style="width: 100px">AP actuelle </th>
												<th style="width: 100px">Engagements</th>
                                                <th style="width: 100px">Paiements</th>
												<th style="width: 100px">PEC</th>
												<th>Taux</th>
												
												<th>Observation</th>
											
													
												
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$i=1;$j=1;
									$operations=Operation::trouve_par_rubrique($rubrique,$ord);
foreach($operations as $operation){
	
			if($situation_f = Situation_f::trouve_par_operation3($operation->id_op,$date)){
			if($etat==$situation_f->etat_operation or $etat=="tous" ){
				//$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);

								if(($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type == 'ministre_SG' or $user->id_ord==$operation->id_ord)  and $ord==$operation->id_ord and $ordonnateur->id_prog==42){
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
										
											  <td><?php  echo html_entity_decode($operation->num_op);  ?></td>
											  <td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->libelle_op);  ?></td>
                                               <?php 
											   if($ordonnateur->id_prog==42){
											   ?>
											   <td>
											   <?php  //echo html_entity_decode($operation->code_type_prog);
										$top="";
									if($operation->topographie=="PN") $top="Programme normal";
									if($operation->topographie=="PHP") $top="Programme spécial hauts plateaux";
									if($operation->topographie=="PS") $top="Programme spécial Sud";
												echo "<option value=".$operation->topographie.">".html_entity_decode($top)."</option>"; ?>
																							   
											   
											   </td>
											   <?php } ?>
                                               <td><?php  echo html_entity_decode($operation->date_inscription);  ?></td>
											   <td><?php  echo number_format($operation->ap_initial,0,',',' ');  ?></td>
                                               <td><?php echo number_format($APacc,0,',',' '); ?></td> <!-- APACtuel-->
												 <td><?php  echo number_format($situation_f->ap_engag,0,',',' ');  ?></td>
												  <td><?php echo number_format($situation_f->paiements,0,',',' '); ?></td>
												     <td><?php echo number_format($APacc-$situation_f->paiements,0,',',' '); ?></td><!-- PEC-->
						
												   <td><?php  if ($APacc!=0){echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else echo 0.00; ?></td><!-- taux-->
												  
                                                 <td><?php echo html_entity_decode($situation_f->obs); ?></td>
											
                                              
                                              
                                            </tr>
                                  <?php
								  
}


if( ($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type == 'ministre_SG' or $user->id_ord==$operation->id_ord) and   $ord==$operation->id_ord and $ordonnateur->id_prog==41){
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
											
												     <td><?php  echo html_entity_decode($operation->num_op);  ?></td>
											  <td><?php  echo html_entity_decode($operation->libelle_op);  ?></td>
                                               
                                                <td><?php  echo html_entity_decode($operation->date_inscription);  ?></td>
												   <td><?php  echo number_format($operation->ap_initial,0,',',' ');  ?></td>
                                               <td><?php echo number_format($APacc,0,',',' '); ?></td> <!-- APACtuel-->
												 	 <td><?php  echo number_format($situation_f->ap_engag,0,',',' ');  ?></td>
												  <td><?php echo number_format($situation_f->paiements,0,',',' '); ?></td>
												     <td><?php echo number_format($APacc-$situation_f->paiements,0,',',' '); ?></td><!-- PEC-->
						
												   <td><?php  if ($APacc!=0){echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else echo 0.00; ?></td><!-- taux-->
												  
                                                 <td><?php echo html_entity_decode($situation_f->obs); ?></td>
								
                                              
                                             
                                            </tr>
                                  <?php
								 
}





			}
	}
else
	
{
	$ordonnateur=Ordonnateur::trouve_par_id($ord);
	//if($clot=Situation_f::is_clote($operation->id_op)==false){
	if(($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type == 'ministre_SG' or $user->id_ord==$operation->id_ord ) and   $ord==$operation->id_ord and $ordonnateur->id_prog==42){
	  $APacc=0;
									if(  $operation=Operation::trouve_par_id($operation->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									   $operation_modifs=Operation_modif::trouve_tous_reev($operation->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
	?>
	                              <tr id ="<?php echo html_entity_decode($operation->id_op); ?>">
										
												     <td><?php  echo html_entity_decode($operation->num_op);  ?></td>
											  <td><?php  echo html_entity_decode($operation->libelle_op);  ?></td>
                                                  <?php 
											   if($ordonnateur->id_prog==42){
											   ?>
											   <td>
											   <?php  //echo html_entity_decode($operation->code_type_prog);
										$top="";
									if($operation->topographie=="PN") $top="Programme normal";
									if($operation->topographie=="PHP") $top="Programme spécial hauts plateaux";
									if($operation->topographie=="PS") $top="Programme spécial Sud";
												echo "<option value=".$operation->topographie.">".html_entity_decode($top)."</option>"; ?>
																							   
											   
											   </td>
											   <?php } ?>
                                                <td><?php  echo html_entity_decode($operation->date_inscription);  ?></td>
												   <td><?php  echo number_format($operation->ap_initial,0,',',' ');  ?></td>
                                               <td><?php echo number_format($APacc,0,',',' '); ?></td> <!-- APACtuel-->
												 	 <td><?php  echo html_entity_decode(0);  ?></td>
												  <td><?php echo html_entity_decode(0); ?></td>
												     <td><?php echo number_format($APacc,0,',',' '); ?></td><!-- PEC-->
						
												   <td><?php   echo 0.00; ?></td><!-- taux-->
												  
                                                 <td><?php echo html_entity_decode(''); ?></td>
								
                                              
                                             
                                            </tr>
<?php	
	}
else 
if(($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type == 'ministre_SG' or $user->id_ord==$operation->id_ord) and   $ord==$operation->id_ord and $ordonnateur->id_prog==41){
	  $APacc=0;
									if(  $operation=Operation::trouve_par_id($operation->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									   $operation_modifs=Operation_modif::trouve_tous_reev($operation->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									   
	?>
	  <tr id ="<?php echo html_entity_decode($operation->id_op); ?>">
										
												     <td><?php  echo html_entity_decode($operation->num_op);  ?></td>
											  <td><?php  echo html_entity_decode($operation->libelle_op);  ?></td>
                                             
                                                <td><?php  echo html_entity_decode($operation->date_inscription);  ?></td>
												   <td><?php  echo number_format($operation->ap_initial,0,',',' ');  ?></td>
                                               <td><?php echo number_format($APacc,0,',',' '); ?></td> <!-- APACtuel-->
												 	 <td><?php  echo html_entity_decode(0);  ?></td>
												  <td><?php echo html_entity_decode(0); ?></td>
												     <td><?php echo number_format($APacc,0,',',' '); ?></td><!-- PEC-->
						
												   <td><?php   echo 0.00; ?></td><!-- taux-->
												  
                                                 <td><?php echo html_entity_decode(''); ?></td>
								
                                              
                                             
                                            </tr>
<?php
}
	
}

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
<?php  } ?>
<div>
<?php  
	if(isset($_POST['submit'])){
	$errors = array();

	$date=$_POST['date_s'];
	
	filtre($_POST['code_rubrique'],$user,$_POST['id_ord'],$date,$_POST['etat_operation']);
	
	

	
	  
									  
	}
 ?>
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
<script>
function valide(){
	
	var gestionnaire=document.getElementById("id_ord");
	gest=gestionnaire.options[gestionnaire.selectedIndex].value;
	if(gest=='-3'){
		alert('selectionner vous un gestionnaire');
		return false;
	}
	//alert(gest);
}
</script>		
        <!-- END TEMPLATE -->
		
    <!-- END SCRIPTS -->                   
    </body>
</html>






