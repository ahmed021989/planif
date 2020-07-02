<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'ministre_SG' or 'Admin_dsp' or 'dsp' or 'admin_psd');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
			$msg_system ="Accès non autorisé! <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 

$titre = "Liste  projets";
$active_menu = "index";
$header = array('projet');
if ($user->type =='administrateur'  or $user->type =='ministre_SG' or $user->type =='Admin_dsp' or $user->type=='dsp' or $user->type =='Admin_psd' or $user->type =='ministre'){
	require_once("composit/header.php");
}
else{
readresser_a("index.php");	
}
?>


<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#"> Projet</a></li>
                    <li class="active">Projets de réalisation</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_stru" id = "ajouter_stru" action="<?php echo $_SERVER['PHP_SELF']."?code_struct=".$_GET['code_struct']?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
								 
      <h3> <span class="panel-title pull-left"><?php $struct=Structure::trouve_par_code($_GET['code_struct']); echo "<b style='font-size:24px'>".$struct->nom_structure."</b>"; ?></span> <?php if($user->type!="ministre_SG"){?><button class="btn btn-info pull-right" type = "button" id="submit0" name = "submit0" onclick="ajouter();" >Nouveau Projet</button><?php } ?>
	   </h3>
                                    
                                </div>
                                
                               
						 <?php 
										if (!empty($msg_error)){
											echo error_message($msg_error); 
										}elseif(!empty($msg_positif)){ 
											echo positif_message($msg_positif);	
										}elseif(!empty($msg_system)){ 
											echo system_message($msg_system);
										} ?>		
                                                                                                       
               <div class="message-box animated fadeIn"  id="mb-ajouter">
			   
            <div class="mb-container" style="background:#1caf9a;margin-top:-100px" >
			<div class="mb-footer">
					 
                        <div class="pull-right">
						<div>
						
                           <button class="btn btn-danger fa fa-times btn-lg mb-control-close"></button> 
						   </div>
                        </div>
                    </div> 
			<div class="panel-body">
                                 
			
			<div class="panel-body"> 
			 <div class="panel panel-heading panel-success">
	   <h3 class="panel-title"><strong>Nouveau projet de réalisation</strong></h3>
	   </div>
  <div class="panel-heading">
                                  
                                    
                             					
					   
                       <!--***********************--> 
                                <div class="row"> 
                                   <div class="col-md-8">           
                                            
                                           <div class="form-group">
                                                <label class="col-md-4 control-label">Intitulé du projet : </label>
                                               <div class="col-md-6">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                        <input type="text" class="form-control" name ="nom_projet_a" id ="nom_projet_a" required / >
                                                    </div>                                            
                                                 </div>
												
                                            </div>
												<div class="form-group">
                                               <label class="col-md-4 control-label">Date de lancement :</label>
                                               <div class="col-md-6">                                           
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                        <input type="date" class="form-control" name ="date_lence_a" id ="date_lence_a" required >
                                                    </div>                                            
                                                 </div>
											
                                            </div>
											
											 <div class="form-group">   
                                              <label class="col-md-4  control-label"> Infrastructure :</label>											
                                              <div class="col-md-6">    
	                                                  <select class="form-control select" id="id_infra_a"  name="id_infra_a" data-live-search="true" required />
																			
                                                     	<option value="-1"> Sélectionner l'infrastructure</option>
															
															 <?php $SQL = $bd->requete("SELECT * FROM   infrastructure where code_structure='".$_GET['code_struct']."' ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
														echo '<option  value = "'.$rows["id_infra"].'" >'.$rows["nom_infra"].'</option>';
														} ?>		
                                                        																			
														</select>   
                                              </div>
                                            </div>
										
										
                                            <div class="form-group">   
                                              <label class="col-md-4 control-label"> Gestionnaire :</label>											
                                             <div class="col-md-6">    
	                                                  <select class="form-control select" id="id_ord_a"  name="id_ord_a" data-live-search="true" required />
																			
                                                     <option value="-2"> Sélectionner le gestionnaire</option>
															
															  <?php $SQL = $bd->requete("SELECT * FROM   ordonnateur ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
															if(($user->type=='Admin_psd' or $user->type=='administrateur'  or $user->type =='ministre_SG') and  $rows["id_prog"]==42){
																
														echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
														}
														
														}
															if($user->type=='Admin_dsp' or $user->type=='dsp'){
																$ordonnaateur=Ordonnateur::trouve_par_id($user->id_ord);
															
														echo '<option  value = "'.$ordonnaateur->id_ord.'" >'.$ordonnaateur->nom_ord.'</option>';
															
															}
														
														?>
														
                                                        																			
														</select>   
                                              </div>
                                            </div>
											
											
											 
                                            
                                    
											
											
											
											
											
											</div>
											<br><br>
											  
                                        </div>
										   
                                     
                      <div class="panel-footer">
                                    <button class="btn btn-default" type = "reset">Vider les Champs</button>                                    
                                    <button class="btn btn-primary pull-right"type = "submit" id = "submit" name = "submit">Ajouter</button>
                                </div>
                                </div>
								   </div>
                               
                            </div>

							</div></div>
								<!--/////////////////////// ms-box ajoute projet //////////////////////-->
							
							<!--/////////////////////// ms-box modifier projet //////////////////////-->
							 <div class="message-box animated fadeIn"  id="mb-id_projet">
							 <input type="text" id="id_proj" name="id_proj" value="" />
							 </div>
							
							 <div class="message-box animated fadeIn"  id="mb-modifier">
			   
            <div class="mb-container" style="background:#5486b9fc;margin-top:-150px" >
			<div class="mb-footer">
					 
                        <div class="pull-right">
						<div>
						
                           <button class="btn btn-danger fa fa-times btn-lg mb-control-close"></button> 
						   </div>
                        </div>
                    </div> 
			<div class="panel-body">
                                 
			
			<div class="panel-body"> 
			 <div class="panel panel-heading panel-success">
	   <h3 class="panel-title"><strong>Actualiser la situation physique du projet</strong></h3>
	   </div>
  <div class="panel-heading">
                                  
                                    
                             					
					   
                       <!--***********************--> 
                                <div class="row"> 
                                   <div class="col-md-6">           
                                            
                                           <div class="form-group">
                                                <label class="col-md-4 control-label">Intitulé du projet : </label>
                                               <div class="col-md-6">                                             
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name ="nom_projet" id ="nom_projet" required / >
                                                          <span class="input-group-addon"><span class="fa fa-pencil"></span></span>

												   </div>                                            
                                                 </div>
												
                                            </div>
											<?php if($user->type=="administrateur" or $user->type =='ministre_SG'){ ?>
												<div class="form-group">
                                               <label class="col-md-4 control-label">Date de lancement :</label>
                                               <div class="col-md-6">                                           
                                                    <div class="input-group">
                                                       
                                                        <input type="date" class="form-control" name ="date_lence" id ="date_lence"  >
														 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    </div>                                            
                                                 </div>
											
                                            </div>
											<?php } ?>
										
											
											<div class="form-group">   
                                              <label class="col-md-4  control-label"> Etudes :</label>										
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                 
                                                    <input type="text" name="etudes" id="etudes" class="form-control"     />   
											  <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											<div class="form-group">   
                                              <label class="col-md-4  control-label"> Construction	 :</label>
												<div class="col-md-6 ">	
												<table cellpadding="50" style="text-align:center;">
												<tr><td>GO</td><td>CES</td><td>VRD</td><td>&nbsp;&nbsp;&nbsp;  </td></tr>
                                              <tr>
											  <td>
											    <div class="input-group">
                                                   
                                                    <input type="number" name="cpo" id="cpo" step="0.01"  max="100" min="0" class="form-control"     />  
										
													
                                                </div>
                                             
											  </td>
											  <td>
											    <div class="input-group">
                                                   
                                                    <input type="number" name="ces" id="ces" step="0.01"  max="100" min="0" class="form-control"     /> 
									
													
                                                </div>
											  </td>
											  <td>
											    <div class="input-group">
                                                   
                                                    <input type="number" name="vrd" id="vrd" step="0.01" max="100"  min="0"  class="form-control"     />   
							
											
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
                                                  
                                                    <input type="text" name="eqt" id="eqt"   class="form-control"     />   
											<span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											</div><!-- fin col 6-->
											
											  <div class="col-md-6">
											
											
											
											   <div class="form-group">   
                                              <label class="col-md-4  control-label"> Date de réception :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                   
                                                    <input type="date" name="date_reception" id="date_reception" class="form-control"     />   
											 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                              </div>
                                            </div>
											
											
											 <div class="form-group">   
                                              <label class="col-md-4  control-label"> Réévaluation demandée:</label>											
                                              <div class="col-md-6 ">
											    
                                                <div class="input-group">
                                                 
                                                    <input type="text" name="reev_dem" id="reev_dem" class="form-control"     />   
											  <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              
                                              </div>
                                            </div>
											
											
											  <div class="form-group">   
                                              <label class="col-md-4  control-label"> Date de mise en service :</label>											
                                              <div class="col-md-6 ">
											    <div class="input-group">
                                                  
                                                    <input type="date" name="date_ser" id="date_ser" class="form-control"     />   
											 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                </div>
                                              </div>
                                            </div>

                                             <div class="form-group">   
                                              <label class="col-md-4  control-label"> Observation / Contraintes:</label>											
                                              <div class="col-md-6 ">
											    
                                                <div class="input-group">
                                                 
                                                    <input type="text" name="obs" id="obs" class="form-control"     />   
											  <span class="input-group-addon"><span class="fa fa-check-square"></span></span>
                                                </div>
                                              
                                              </div>
											  </div>
								<div class="form-group">   
                                              <label class="col-md-4  control-label"> Etat du projet :</label>											
                                   <div class="col-md-6"> 
																				  
	                                                  <select class="form-control select" id="etat_projet"  name="etat_projet" data-live-search="true"  />
																			
                                                     	<option value=""> Sélectionner l'état du projet</option>
														<option value="En etude">En étude</option>	
														<option value="En cours">En cours</option>
														<option value="Gele">Gelé</option>	
														<option value="Acheve">Achevé</option>															
                                                        																			
														</select> 
																						
                                  </div>
                                </div>
                                            
                                           </div>
                                        </div>
										   
                                     
                      <div class="panel-footer">
                                    <button class="btn btn-default" type = "reset">Vider les Champs</button>                                    
                                    <button class="btn btn-primary pull-right"type = "submit" id = "submit_modif" name = "submit_modif" >Actualiser</button>
                                </div>
                                </div>
								   </div>
                               
                            </div>

							</div></div>
							
							
							<!-- ///////////////////// fin ms-box modifier projet //////////////////-->
							

							 <?php   if($user->type!='Admin_dsp' and $user->type!='dsp'){ ?>
							   <div class="panel-footer">
							   <div class="row">
							   <div class="col-md-8">
                                      <div class="form-group">   
                                              <label class="col-md-3 col-xs-12  control-label"> Gestionnaire :</label>											
                                             <div class="col-md-4 col-xs-12">    
	                                                  <select class="form-control select" id="id_ord1"  name="id_ord1" data-live-search="true" required />
																			
                                                     <option value="-2"> Sélectionner le gestionnaire</option>
															
													  <?php $SQL = $bd->requete("SELECT * FROM   ordonnateur ");
															while ($rows = $bd->fetch_array($SQL))
														{
														
															if(($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type =='ministre_SG') and  $rows["id_prog"]==42){
																
														echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
														}
														
														}
															if($user->type=='Admin_dsp' or $user->type=='dsp'){
																$ordonnaateur=Ordonnateur::trouve_par_id($user->id_ord);
															
														echo '<option  value = "'.$ordonnaateur->id_ord.'" >'.$ordonnaateur->nom_ord.'</option>';
															
															}
														
														?>
														
                                                        																			
														</select>   
                                              </div>
                                            </div>   
								</div>
								<div class="col-md-4">											
                                    <button class="btn btn-primary pull-left" type ="submit" name ="submit2" id ="submit2">Lister</button>
								</div>
									</div><!--fin row -->
                                </div> 
							 <?php } else {} ?>
                        </form>
                            
                        </div>
                    </div>  
				
<?php 
function lister_projet($ordonnateur,$user){
	global $bd;
		
		?>				
              <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Liste des projets de réalisation de la :<?php $ord=Ordonnateur::trouve_par_id($ordonnateur); echo $ord->nom_ord;?></strong></h3>
									
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>                                
                                </div>
                                <div class="panel-body ">
                                   <table  id="table0" class="table-bordered" style="text-align:left;direction:rtl;">
                                        <thead >
                                            <tr style="background:#f1f5f9;text-align:center">
                                            <th rowspan="2" style="width:200px">Mise à jour<br><br></th>
											<th rowspan="2">Opérations planifiées<br><br></th>
											<th rowspan="2">Observation<br><br></th>
											<th rowspan="2">Etat du projet<br><br></th>
											<th rowspan="2">Réévaluation demandée<br><br></th>
											<th rowspan="2">Date de mise en service<br><br></th>
											<th rowspan="2">Date de réception<br><br></th>
											<th rowspan="2">Equipements<br><br></th>
											<th colspan="3">Construction</th>
											<th rowspan="2">Etudes<br><br></th>
											<th rowspan="2">Date de lancement<br><br></th>
											<th rowspan="2">Intitulé du projet<br><br></th>
											</tr>
											
											<tr style="background:#f1f5f9;text-align:center">
											    <th valign="top">GO</th>
												<th valign="top">CES</th>
												<th valign="top">VRD</th>
											</tr>
											</thead>
											<tbody>
                                       
									<?php
									$infras=Infrastructure::trouve_par_structure($_GET['code_struct']);
									
						foreach($infras as $infra){
	
							if($projet =  Projet:: trouve_filtre_ord($ordonnateur,$infra->id_infra)){
								foreach($projet as $projet){
									$sql=$bd->requete('select * from ordonnateur where id_ord='.$projet->id_ord.'');
									while($rows=$bd->fetch_array($sql)){
									
										if(($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type=='ministre_SG' or $user->id_ord==$projet->id_ord) and $rows['id_prog']==42){
									?>
                                      
                                            <tr id ="<?php echo html_entity_decode($projet->id_projet); ?>">
												<th style="background:#f1f5f9">
												<?php 
													$sql1=$bd->requete("select * from projet_supr where valide=0 and id_projet=".$projet->id_projet."");
															
													if (mysqli_num_rows($sql1)!=0 ){ 
													
													echo '<span  class="btn btn-warning  btn-sm"> suppression en cours de validation </span>';
													 } else{
														 if($user->type=="Admin_dsp" or $user->type=='dsp' or $user->type=="administrateur"  ){
															 if($situation_ph = Situation_ph::trouve_par_projet($projet->id_projet)){
																 $etat_oper='';
																 $operations=Operation::trouve_tous_projet($projet->id_projet);
																 foreach($operations as $operation){
																	 if($situation_f=Situation_f::trouve_par_operation2_valider($operation->id_op)){
																		if($situation_f->etat_gelee==1){
$etat_oper="gelee";
																		}																			
																	 }
																 }
															 if($situation_ph->etat_projet=="Gele" and $etat_oper=="gelee"){
															
														 ?>
														 <span style="background:red;color:white">Projet Gelé</span>
														  <?php }
															else{
																?>
										<a  class="btn btn-danger btn-rounded btn-sm fa fa-trash-o" data-toggle="tooltip" onclick="suprimer_projet(<?php echo $projet->id_projet; ?>)" title="Demande suppression">  </a>
										<a  onclick="modif_projet(<?php echo $projet->id_projet;?>)" data-toggle="tooltip" title="Situation physique" class=" btn btn-info btn-rounded fa fa-pencil"> </a>
										 				
																
															<?php
														 }}
														 else{
															?>
										<a  class="btn btn-danger btn-rounded btn-sm fa fa-trash-o" data-toggle="tooltip" onclick="suprimer_projet(<?php echo $projet->id_projet; ?>)" title="Demande suppression">  </a>
											<a  onclick="modif_projet(<?php echo $projet->id_projet;?>)" data-toggle="tooltip" title="Situation physique" class=" btn btn-info btn-rounded fa fa-pencil"> </a>
										 				
																
															<?php 
														 }
													 } }  ?>
												</th>
												<?php 
															if (mysqli_num_rows($sql1)==0 ){
															?>
											<th style="background:#f1f5f9"> <a href="ajouter_operation.php?id_projet=<?php echo $projet->id_projet."||"."&code_struct=".$_GET['code_struct'];?>" class="btn btn-success btn-rounded btn-lg fa fa-plus" data-toggle="tooltip" title="Détail">  </a> </th>
															<?php } else {?>
															<th style="background:#f1f5f9">
														
															</th>
															<?php } ?>
														 <td><?php echo html_entity_decode($projet->obs); ?></td>	
														  <?php 
															if($situation_ph = Situation_ph::trouve_par_projet($projet->id_projet)){
															 ?>
														     <td id="<?php echo $situation_ph->etat_projet;  ?>"><?php
															 if($situation_ph->etat_projet=="Gele"){ echo html_entity_decode("Gelé");}
															  if($situation_ph->etat_projet=="En cours"){ echo html_entity_decode("En cours");}
															   if($situation_ph->etat_projet=="Acheve"){ echo html_entity_decode("Achevé");}
															    if($situation_ph->etat_projet=="En etude"){ echo html_entity_decode("En étude");}
															 ?></td>
															 
															<?php } else { ?>
															<td></td> 
																<?php } ?>
																 <td><?php echo html_entity_decode($projet->reev_dem); ?></td>
																 <td><?php echo html_entity_decode($projet->date_ser); ?></td>
																 <td><?php echo html_entity_decode($projet->date_reception); ?></td>
																 <td><?php echo html_entity_decode($projet->eqt); ?></td>
																 <td><?php echo html_entity_decode($projet->vrd); ?></td>
																 <td><?php echo html_entity_decode($projet->ces); ?></td>
																 <td><?php echo html_entity_decode($projet->cpo); ?></td>
																 <td><?php echo html_entity_decode($projet->etudes); ?></td>
																 <td id='1'><?php 
																echo html_entity_decode($projet->date_lence);
																

																 ?></td>
																 <td  onclick=""><?php echo html_entity_decode($projet-> nom_projet); ?></td>
												   </tr>
                                  <?php
								
										}
								
									}
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
<?php }
 //fin fonction lister_projet 
//****************************************


if(isset($_POST['submit_modif'])){
	 $edit =  Projet::trouve_par_id($_POST['id_proj']);
	
	$edit->nom_projet = htmlspecialchars(trim($_POST['nom_projet']));
	if($user->type=="administrateur"){
	$edit->date_lence = htmlspecialchars(trim($_POST['date_lence']));
		}
	$edit->date_reception = htmlspecialchars(trim($_POST['date_reception']));
	$edit->date_ser = htmlspecialchars(trim($_POST['date_ser']));
	$edit->cpo = htmlspecialchars(trim($_POST['cpo']));
	$edit->ces = htmlspecialchars(trim($_POST['ces']));
	$edit->vrd = htmlspecialchars(trim($_POST['vrd']));
	$edit->obs = htmlspecialchars(trim($_POST['obs']));
	$edit->etudes = htmlspecialchars(trim($_POST['etudes']));	
	$edit->eqt = htmlspecialchars(trim($_POST['eqt']));
	$edit->reev_dem = htmlspecialchars(trim($_POST['reev_dem']));
		$edit->save();
		
		$situation_ph=new Situation_ph();
		$date=date("Y-m-d");
		$situation_ph->id_projet=$_POST['id_proj'];
		$situation_ph->date_ph =$date;
		$situation_ph->etat_projet = htmlspecialchars(trim($_POST['etat_projet']));
	    $situation_ph->save();
	echo "<script>alert('Situation physique actualisée!');</script>";
}


else{

	if(isset($_POST['submit'])){
	$errors = array();
	
	 if (isset($_POST['id_infra_a']) and  !empty($_POST['id_infra_a'])){
	if ($_POST['id_infra_a'] == '-1'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionner l\'infrastructure  !!??</p>';
	}
	}
	
	 if (isset($_POST['id_ord_a']) and  !empty($_POST['id_ord_a'])){
	if ($_POST['id_ord_a'] == '-2'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionner  l\'ordonnateur  !!??</p>';
	}
	}
	
	

	// new object document
	$projet = new  Projet();

	$projet-> nom_projet= htmlspecialchars(trim(addslashes($_POST['nom_projet_a'])));
	
	$projet->id_ord = ($_POST['id_ord_a']);
	$ordonnateur = Ordonnateur:: trouve_par_id($projet->id_ord);

	$projet->id_infra = ($_POST['id_infra_a']);
	$infrastructure = Infrastructure:: trouve_par_id($projet->id_infra);
	$projet->date_lence= htmlspecialchars(trim(addslashes($_POST['date_lence_a'])));
	

	
	if (empty($errors)){
   		
			$projet->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">    projet  "  ' .html_entity_decode($projet->nom_projet) . '"   est bien ajouté!  </p><br />';
		
				echo "<script>alert('Projet ajouté ! '); window.location.replace('link3.php?code_struct=".$_GET['code_struct']."');</script>";
 		 
 			}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
}

else{

if(isset($_POST['submit2'])){

$ordonnateur=$_POST['id_ord1'];
lister_projet($ordonnateur,$user);	
	
} else{

}

}

}
if($user->type!="administrateur" and $user->type!="Admin_psd"){
lister_projet($user->id_ord,$user);		
}
?>

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
                        <p>Appuyez sur Oui si vous êtes sûr</p>
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
			<div class="message-box message-box-danger animated fadeIn" id="mb-supr_projt" data-sound="mb-supr_projt" >
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="glyphicon glyphicon-trash"></span> Suppression <strong> du projet </strong> !!??</div>
                    <div class="mb-content">
                        <p>Etes-vous sûr de vouloir supprimer le projet?</p>                    
                        <p>Appuyez sur Oui si vous êtes sûr</p>
                    </div>
                    <div class="mb-footer">
                        <div class="pull-center">
                            <button class="btn btn-success btn-lg mb-control-yes" >Oui</button>
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
                        <p>Appuyez sur Non si vous souhaitez continuer à travailler. Appuyez sur Oui pour déconnecter </p>
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
		<script type="text/javascript" src="js/dataTables.fixedColumns.min.js"></script> 
		<!-- END THIS PAGE PLUGINS -->       
        
        <!-- START TEMPLATE -->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>     
  <script type="text/javascript" >
  <?php  
  $nbr=0;
  $nbr1=0;
  $sql=$bd->requete("select * from projet_supr where id_ord=".$user->id_ord." and valide!=0");
   $sql1=$bd->requete("select * from projet_supr where id_ord=".$user->id_ord."");
   $nbr=mysqli_num_rows($sql);
    $nbr1=mysqli_num_rows($sql1);
  
  ?>
 	setInterval('actualiser(<?php echo $nbr.",".$nbr1;?>)',500);
				//setTimeout('load_connect()',500);
		function actualiser(nbr,nbr1){
						
		$.ajax({
				
	         method:"post",
	         url:"ajax_calcule_projet.php",
             data:{ nbr: nbr,nbr1:nbr1 },
	         success:function(resultData){
		if(resultData=="actualiser"){
		location.reload();
		//alert("yees");	
		}
		else{
			//alert("erreur");
		}
	        }
		});
		}

  
   $('#submit2').on('click',function(){
	 $('#mb-ajouter').find('input, textarea,select').removeAttr('required');
	  $('#mb-modifier').find('input, textarea,select').removeAttr('required');
	// $('#nom_projet').removeAttr('required');
	// $('#date_lence').removeAttr('required');
	// $('#id_infra').removeAttr('required');
	// $('#id_ord').removeAttr('required');
	   
	   
   });
    $('#submit_modif').on('click',function(){
	 $('#mb-ajouter').find('input, textarea,select').removeAttr('required');
	
	
	   
	   
   });
   
    $('#submit').on('click',function(){
	   
	     $('#mb-modifier').find('input, textarea,select').removeAttr('required');
	   
   });
   
  $('#table0').dataTable( 
{
"columnDefs": [
      { "width": "100px", "targets": 0 },
	     { "width": "100px", "targets": 1 },  

    ],
	
"searching": true,
"paging":true,
"ordering": false,
"scrollCollapse": true,
"scrollX": "180%", 
 "fixedColumns":   {
    iLeftColumns: 2 ,
    iRightColumns: 0,
        },
} ); 
   function suprimer_projet(id){
	   $('#mb-supr_projt').show(); 
	  $('#mb-supr_projt').find ('.mb-control-yes').on('click',function(){
		window.location.href='demande_sup_proj.php?id_projet='+id+'';	
		  })   
   }
   
	function ajouter(){
			$('#mb-ajouter').show();    
		  }
		/////////////////////founction modifier projet  /////////////////
	function modif_projet(id){
		$('#id_proj').val(id);		
		$('#nom_projet').val($('#'+id).find('td:eq(11)').text());
		$('#date_lence').val($('#'+id).find('td:eq(10)').text());
	
		$('#etudes').val($('#'+id).find('td:eq(9)').text());
		$('#cpo').val($('#'+id).find('td:eq(8)').text());
		$('#ces').val($('#'+id).find('td:eq(7)').text());
		$('#vrd').val($('#'+id).find('td:eq(6)').text());
		$('#eqt').val($('#'+id).find('td:eq(5)').text());
		$('#date_reception').val($('#'+id).find('td:eq(4)').text());
		$('#date_ser').val($('#'+id).find('td:eq(3)').text());
		$('#reev_dem').val($('#'+id).find('td:eq(2)').text());
		$('#etat_projet').val($('#'+id).find('td:eq(1)').attr('id'));
		
		$('#etat_projet').selectpicker("refresh");
		$('#obs').val($('#'+id).find('td:eq(0)').text());
	
	    $('#mb-modifier').show();    
		  }
		  
		///////////////fin modification projet ///////////////////////
		
		
		
		  $('.mb-control-close').on('click',function(){
			 	$('#mb-ajouter').hide();  
					$('#mb-modifier').hide(); 
					$('#mb-supr_projt').hide(); 
		  })
		
		  </script> 

<style>
td,th{
padding-left:3px ;
}
tr:hover td {background:#999;color:#000;cursor: pointer;}
	</style>		  
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>






