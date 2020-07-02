<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'ministre_SG' or 'Admin_dsp' or 'dsp' or 'Admin_ehs'or 'Admin_chu' or 'Admin_est' or 'chu' or 'ehs' or 'est' or 'dfm');
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

if ( (isset($_GET['id_projet'])) ) {
	list($id0,$rubr,$prog)=explode("|",$_GET['id_projet']);
	
	$id = $id0;

	if($projet=Projet::trouve_par_id($id) and $id!=0){
		

		$operation=Operation::trouve_tous_projet($projet->id_projet);

		foreach($operation as $operation){
			$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
//	echo "<script>alert(".$ordonnateur->id_prog.")</script>";
			if(($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type=='ministre_SG' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42 ){


			}	
			else{


				if(($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type=='ministre_SG' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==41){


				}	
				else{
					readresser_a('index.php');	
				}

			}
		}


/*	if($projet->id_ord!=$user->id_ord and ($user->type !='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est')){
		readresser_a('index.php');
	}*/

	
}
else{
	if($id==0){
	}
	else{
		if($projet=Projet::trouve_par_id($id)==false){
			readresser_a('index.php');	
		}
	}

}
}


if(isset($_POST['submit'])){
	$errors = array();
	
	
	if (isset($_POST['id_rubrique']) and  !empty($_POST['id_rubrique'])){
		if ($_POST['id_rubrique'] == '-1'){
			$errors[] = '<p style= "font-size: 20px; ">  Sélectionner une rubrique !!??</p>';
		}
	}
	
	if (isset($_POST['code_type_prog']) and  !empty($_POST['code_type_prog'])){
		if ($_POST['code_type_prog'] == '-2'){
			$errors[] = '<p style= "font-size: 20px; ">  Sélectionner un type de Programme  !!??</p>';
		}
	}
	
	if (isset($_POST['id_ord']) and  !empty($_POST['id_ord'])){
		if ($_POST['id_ord'] == '-3'){
			$errors[] = '<p style= "font-size: 20px; "> Sélectionner un ordonnateur !!??</p>';
		}
	}
	if (isset($_POST['id_ss']) and  !empty($_POST['id_ss'])){
		if ($_POST['id_ss'] == '-4'){
			$errors[] = '<p style= "font-size: 20px; ">   Sélectionner un sous Secteur !!??</p>';
		}
	}
	
	
	
	
	

	
	list($id0,$rubr,$prog)=explode("|",$_GET['id_projet']);
	// new object document
	$operation = new  operation();
	
	$operation-> id_projet=($_GET['id_projet']);
	$operation-> libelle_op= htmlspecialchars(trim(addslashes($_POST['libelle_op'])));
	$operation-> num_op = htmlspecialchars(trim(addslashes($_POST['num_op'])));
	$operation-> num_dp = htmlspecialchars(trim(addslashes($_POST['num_dp'])));
	$operation-> ap_initial = htmlspecialchars(trim(addslashes($_POST['ap_initial'])));
	$operation-> date_inscription = htmlspecialchars(trim(addslashes($_POST['date_inscription'])));

	$operation-> code_rubrique = htmlspecialchars(trim(addslashes($_POST['code_rubrique'])));
	if($prog==42 or $prog==null){
		$operation-> topographie = htmlspecialchars(trim(addslashes($_POST['topographie'])));
	}
	$operation-> id_ss = ($_POST['id_ss']);
	$sous_secteur = Sous_secteur:: trouve_par_id($operation->id_ss);
	
	$operation-> id_ord = ($_POST['id_ord']);
	$ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord);
	
	if($user->type=="Admin_psc" or $user->type=="administrateur" or $user->type=="Admin_psd"){
		$operation->valider=1;
	}
	$operation-> user=$user->nom_compler();
	$operation-> date_demande=date("Y-m-d H:s");
	
	
	if (empty($errors)){

		
		$operation->save();
 		 // $msg_positif = '<p style= "font-size: 20px; ">   operation  "  ' .html_entity_decode($operation->num_op) . '"   est bien ajoutée  </p><br />';
		if($user->type=='Admin_dsp' or $user->type=='dsp'  or $user->type=="Admin_chu" or $user->type=="chu" or $user->type=="Admin_ehs" or $user->type=="ehs" or $user->type=="Admin_est" or $user->type=="est" or $user->type=="Admin_msprh"  or $user->type=="dfm"){
			echo "<script>alert('votre demande a été envoyé');window.location.replace('link.php?id_projet=".$_GET['id_projet']."');</script>";
		//readresser_a("link.php?id_projet=".$_GET['id_projet']."");
		}
		else{
			echo "<script>alert('opération ajoutée');window.location.replace('link.php?id_projet=".$_GET['id_projet']."');</script>";
			
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
$titre = "operations";
$active_menu = "index";
$header = array('operation');
if ($user->type =='administrateur'  or 'ministre_SG'  or 'Admin_dsp' or 'dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'chu' or 'ehs' or 'est' or 'dfm'){
	require_once("composit/header.php");
}
?>


<html lang="en">
<!-- START BREADCRUMB -->

<ul class="breadcrumb">
	<li><a href="index.php">Accueil</a></li>
	<li><a href="#"> Opération</a></li>
	<?php if($user->type=='administrateur' or $user->type=='ministre_SG' or $user->type=='Admin_psc' or $user->type=='Admin_psd' or $user->type=='Admin_dsp' or $user->type=='dsp' or $user->type=='Admin_chu' or $user->type=='Admin_ehs' or $user->type=='Admin_est' or $user->type=='chu' or $user->type=='ehs' or $user->type=='est' or $user->type=="Admin_msprh" or $user->type=='dfm' ){
		?>
		<li class="active">Liste des opérations 
		</li>
	<?php } ?>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<?php  

if($user->type=='administrateur' or $user->type=='ministre_SG' or $user->type=='Admin_psc' or $user->type=='Admin_psd' or $user->type=='Admin_dsp' or $user->type=='dsp' or $user->type=='Admin_chu' or $user->type=='Admin_ehs' or $user->type=='Admin_est' or $user->type=='chu' or $user->type=='ehs' or $user->type=='est' or $user->type=="Admin_msprh" or $user->type=='dfm' ){
	?>
	<div class="page-content-wrap">

		<div class="row">
			<div class="col-md-12">

				<form class="form-horizontal" name="ajouter_operation" id = "ajouter_operation" action="<?php echo $_SERVER['PHP_SELF'].'?id_projet='.$_GET['id_projet'];?>" method="post">
					<div class="row " >
						<div class="panel-heading">

							<h3 class="panel-title pull-right"><?php if($user->type!="ministre_SG"){ ?><button class="btn btn-info pull-right" type = "button" id="submit0" name = "submit0" onclick="ajouter();" >Nouvelle opération</button><?php } ?>
						</h3>


					</div>
					<div class="message-box animated fadeIn"  id="mb-ajouter">

						<div class="mb-container" style="background:#fff;margin-top:-100px" >
							<div class="mb-footer">

								<div class="pull-right">
									<div>

										<button class="btn btn-danger fa fa-times btn-lg mb-control-close"></button> 
									</div>
								</div>
							</div> 

							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><strong>Nouvelle opération <?php 
									$projet=Projet::trouve_par_id($id);
									if($id!=0){ echo " au Projet: <span style='color:#1caf9a'>   ".$projet->nom_projet."";}else {}

									?></strong></h3>

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
										<div class="row">

											<div class="col-md-6">


												<div class="form-group">
													<label class="col-md-4 control-label"> Numéro d'opération : </label>
													<div class="col-md-6">                                             
														<div class="input-group">
															<span class="input-group-addon">N°</span>
															<input type="text" class="form-control" name ="num_op" id ="num_op" required  >
														</div>                                            
													</div>

												</div> 

												<div class="form-group">
													<label class="col-md-4 control-label">Libellé d'opération : </label>
													<div class="col-md-6">                                             
														<div class="input-group">
															<span class="input-group-addon"><span class="fa fa-check"></span></span>
															<input type="text" class="form-control" name ="libelle_op" id ="libelle_op" required  >
														</div>                                            
													</div>

												</div>

												<div class="form-group">
													<label class="col-md-4 control-label">Numéro de loi de finance (DP) : </label>
													<div class="col-md-6">                                             
														<div class="input-group">
															<span class="input-group-addon">N°</span>
															<input type="text" class="form-control" name ="num_dp" id ="num_dp" required  >
														</div>                                            
													</div>

												</div>

												<div class="form-group">
													<label class="col-md-4 control-label">AP Initiale : </label>
													<div class="col-md-6">                                             
														<div class="input-group">
															<span class="input-group-addon">DZ</span>
															<input type="number" step="0.01" class="form-control" name ="ap_initial" id ="ap_initial" required  >
														</div>                                            
													</div>

												</div>


											</div>



											<div class="col-md-6">


												<div class="form-group">
													<label class="col-md-4 control-label">Date d'inscription :</label>
													<div class="col-md-6">                                           
														<div class="input-group">
															<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
															<input type="date" class="form-control" name ="date_inscription" id ="date_inscription" required >
														</div>                                            
													</div>

												</div>


												<div class="form-group">
													<label class="col-md-4 control-label">Rubrique:</label>
													<div class="col-md-6">                                         
														<select class="form-control select"   name="code_rubrique" id="code_rubrique" data-live-search="true" required />
														<option value="-1">Sélectionner la rubrique</option>
														<?php
														$SQL="";
														if($id==0 ){
															$SQL = $bd->requete("SELECT * FROM   rubrique where code_rubrique='".$rubr."'");
														}else{
															$SQL = $bd->requete("SELECT * FROM   rubrique ");

														}
														while ($rows = $bd->fetch_array($SQL))
														{
															if($id==0 and ($rows["code_rubrique"]=='r1' or $rows["code_rubrique"]=='r2')){
																echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["nom_rubrique"].'</option>';
															}
															if($id!=0 and ($rows["code_rubrique"]=='r1' or $rows["code_rubrique"]=='r2')){
																echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["nom_rubrique"].'</option>';
															}else{ if(($id==0) and ($user->type=='administrateur'  or $user->type=='Admin_psc')){

																echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["nom_rubrique"].'</option>';

															}
															else { if (($id==0) and ($user->type!='administrateur' )and ($rows["code_rubrique"]=='r3' or $rows["code_rubrique"]=='r4' or $rows["code_rubrique"]=='r5' or $rows["code_rubrique"]=='r6' )){

																echo '<option  value = "'.$rows["code_rubrique"].'" >'.$rows["nom_rubrique"].'</option>';
															}}}	}													?>														
														</select>   

													</div>

												</div>

												<?php
												if(($prog==42 or $prog==null)){
													?>
													<div class="form-group">
														<label class="col-md-4 control-label">Type de programme :</label>
														<div class="col-md-6 ">                                         
															<select class="form-control select"   name="topographie" id="topographie"  required />
															<option value="-2"> Sélectionner le type de programme</option>	
															<option value="PN"> Programme normal</option>	
															<option value="PHP"> Programme spécial hauts plateaux</option>
															<option value="PS"> Programme spécial sud</option>

														</select>   

													</div>

												</div>		  								

												<?php 
											}
											?>
											
											<div class="form-group">
												<label class="col-md-4 control-label"> Nom du gestionnaire:</label>
												<div class="col-md-6">                                         
													<select class="form-control select"   name="id_ord" id="id_ord"  required />
													<option value="-3"> Sélectionner  un  gestionnaire</option>	
													<?php 


													if ($id!=0){
															//echo "<script>alert(".$id.")</script>";
														$projet=Projet::trouve_par_id($id);
														$ordonnaateur=Ordonnateur::trouve_par_id($projet->id_ord);

														echo '<option  value = "'.$ordonnaateur->id_ord.'" >'.$ordonnaateur->nom_ord.'</option>';
														
													}
													else{
														if(($user->type=='Admin_psc' or $user->type=='administrateur') and ($rubr=='r7' or $rubr=='r8')){
															$ordi=Ordonnateur::trouve_par_id(85);
															echo '<option  value = "85" >'.$ordi->nom_ord.'</option>';

														}

														$SQL = $bd->requete("SELECT * FROM   ordonnateur where id_prog=".$prog."");
														while ($rows = $bd->fetch_array($SQL))
														{
															//echo "<script>alert(".$prog.");</script>";
															if(($user->type=='Admin_psc' or $user->type=='Admin_psd' or $user->type=='administrateur') ){

																if( $rows["id_ord"]!=1){
																	if(($user->type=='Admin_psc' or $user->type=='administrateur') and ($rubr=='r7' or $rubr=='r8')){


																	}
																	else{
																		echo '<option  value ="'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
																	}
																}
															}
															else{
																$SQL = $bd->requete("SELECT * FROM   ordonnateur where id_ord='".$user->id_ord."'");
																while ($rows = $bd->fetch_array($SQL))
																{

																	echo '<option  value ="'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';


																} 	 

															}
														}
													}

													
													?>

												</select>   

											</div>
										</div>

										<div class="form-group">
											<label class="col-md-4 control-label">Sous sucteur:</label>
											<div class="col-md-6">                                         
												<select class="form-control select"   name="id_ss" id="id_ss" data-live-search="true" required />
												<option value="-4"> Sélectionner un  sous sucteur</option>	
												<?php $SQL = $bd->requete("SELECT * FROM   sous_secteur ");
												while ($rows = $bd->fetch_array($SQL))
												{

													echo '<option  value = "'.$rows["id_ss"].'" >'.$rows["nom_ssecteur"].'</option>';
												} ?>														
											</select>   

										</div>
									</div>	</br>											
								</div>	 
							</div>

							<div class="panel-footer">
								<button class="btn btn-default"type = "reset">Vider les Champs</button>                                    
								<button <?php if($user->type=="Admin_dsp" or $user->type=="dsp" or $user->type=="Admin_chu" or $user->type=="chu" or $user->type=="Admin_ehs" or $user->type=="ehs" or $user->type=="Admin_est" or $user->type=="est" or $user->type=="Admin_msprh" or $user->type=="dfm"){ echo "class='btn btn-primary pull-right ' ";} else { echo "class='btn btn-primary pull-right '"; }?> type = "submit" name = "submit"><?php if($user->type=="Admin_dsp" or $user->type=="dsp" or $user->type=="Admin_chu" or $user->type=="chu" or $user->type=="Admin_ehs" or $user->type=="ehs" or $user->type=="Admin_est" or $user->type=="est" or $user->type=="Admin_msprh" or $user->type=="dfm"){ echo " Demande d'ajout<span class='btn btn-primary pull-right fa fa-send'></span>"; } else { echo "Ajouter"; } ?></button>
							</div>
						</div>
					</div>
				</div><!--fin panel body -->
			</div>
		</div> <!-- fin ms-box ajouter -->


	</br></br>	
	<h3 class="panel-title"><strong>Liste des opérations 
		<?php if($id!=0){ echo " du Projet: <span style='color:#1caf9a'>   ".$projet->nom_projet."";}
		else {
			$rubr=Rubrique::trouve_par_code($rubr);
			echo ": <span style='color:#1caf9a'>".$rubr->nom_rubrique."</span>";
		} ?>
	</strong></h3>


</div> 
</br>

<?php
if(($user->type=="administrateur"   or $user->type=="Admin_psd" or $user->type=="Admin_psc" or $user->type=="ministre_SG") and $id==0){
	?>
	<br><br><br><br>
	<div class="panel-footer">
		<div class="row ">


			<div class="col-md-8">
				<div class="form-group ">
					<label class="col-md-3 control-label pull-left" style="float:left">Nom de gestionnaire:</label>
					<div class="col-md-8">                                         
						<select class="form-control select"   name="id_ord1"  id="id_ord1" data-live-search="true" required />
						<option value="-3"> Sélectionner un gestionnaire</option>	
						<?php 

						list($id0,$rubr,$prog)=explode("|",$_GET['id_projet']);

						$id = $id0;			 
						if ($id!=0){
															//echo "<script>alert(".$id.")</script>";
							$projet=Projet::trouve_par_id($id);
							$ordonnaateur=Ordonnateur::trouve_par_id($projet->id_ord);

							echo '<option  value = "'.$ordonnaateur->id_ord.'" >'.$ordonnaateur->nom_ord.'</option>';

						}
						else{
							if(($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type=='ministre_SG') and ($rubr=='r7' or $rubr=='r8')){
								$ordi=Ordonnateur::trouve_par_id(85);
								echo '<option  value = "85" >'.$ordi->nom_ord.'</option>';


							}

							$SQL = $bd->requete("SELECT * FROM   ordonnateur where id_prog=".$prog."");
							while ($rows = $bd->fetch_array($SQL))
							{
															//echo "<script>alert(".$prog.");</script>";
								if(($user->type=='Admin_psc' or $user->type=='Admin_psd' or $user->type=='administrateur' or $user->type=='ministre_SG') ){

									if( $rows["id_ord"]!=1){
										if(($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type=='ministre_SG') and ($rubr=='r7' or $rubr=='r8')){


										}
										else{
											echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';
										}
									}
								}
								else{
									$SQL = $bd->requete("SELECT * FROM   ordonnateur where id_ord='".$user->id_ord."'");
									while ($rows = $bd->fetch_array($SQL))
									{

										echo '<option  value = "'.$rows["id_ord"].'" >'.$rows["nom_ord"].'</option>';


									} 	 

								}
							}
						}


						?>

					</select>   

				</div>
			</div>  
		</div>
		<div class="col-md-4">								  
			<button class="btn btn-primary pull-left" type = "submit" name = "submit2" id ="submit2">lister</button>
		</div>
	</div><!--fin row -->
</div>
<?php }?>




</form>
</div>


</div>  
</div>
<?php  } ?>

<?php 

?>				
<div class="page-content-wrap">                

	<div class="row">
		<div class="col-md-12">

			<!-- START DEFAULT DATATABLE -->
			<div class="panel panel-default">
				<div class="panel-heading">                                



					<ul class="panel-controls">
						<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
						<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
						<li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
					</ul>                                
				</div>
				<?php 
				function filtrer_operation($user,$ordonnateur,$id,$rubr,$prog){

					if($id==0){
						$operation =  operation:: trouve_tous_projet_rub($id,$rubr,$ordonnateur);	
					}
					else{
															//echo "<script>alert(".$id.")</script>";
						$operation =  operation:: trouve_tous_projet($id);	
					}
					global $bd;
					?>
					<div class="panel-body">

						<table  id="table0" class="table-bordered" >
							<thead>
								<tr style="background:#f1f5f9;">
									<th style="width:172px"><p>N° d'opération</p></th>
									<th><p>Lebellé d'opération</p></th>
									<th><p>Date d'inscription</p></th>
									<th><p>N° D-P</p></th>
									<?php 
									if($prog==42 or $prog==null){
										?>
										<th><p>Type programme</p>  </th>
										<?php 
									}
									?>
									<th><p>AP initiale</p></th>
									<th><p>AP actuelle</p></th>
									<th><p>Engagements</p></th>
									<th><p>Paiements</p></th>
									<th><p>PEC</p></th>
									<th><p>TAUX</p></th>
									<th><p>Etat d'opération</p></th>
									<th><p>Observation</p></th>		  
									<th><p>Action</p></th>
								</tr>
							</thead>
							<tbody>


								<?php
								foreach($operation as $operation){
									if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
										if($situation->etat_gelee!=-2){

											$sql=$bd->requete('select * from ordonnateur where id_ord='.$operation->id_ord.'');
											while($rows=$bd->fetch_array($sql)){

												if(($user->type=='Admin_psd' or $user->type=='administrateur'  or $user->type=="ministre_SG" or $user->id_ord==$operation->id_ord) and $rows['id_prog']==42 and $rows['id_prog']==$prog){


													?>

													<tr id ="<?php echo html_entity_decode($operation->id_op); ?>">


														<td><?php echo html_entity_decode($operation-> num_op); ?></td>
														<td><?php echo html_entity_decode($operation-> libelle_op); ?></td>
														<td class="btn"  onClick="change_date(<?php echo $operation->id_op;?>);"><?php echo html_entity_decode($operation-> date_inscription); ?><span class="btn fa fa-pencil"></span></td>
														<td><?php echo html_entity_decode($operation->num_dp); ?></td>
														<td>
															<select id="<?php echo "1".$operation->id_op;?>" onchange="change_programme(<?php echo $operation->id_op;?>);"><?php 
									// if($type_pro=Type_programme::trouve_par_code($operation->code_type_prog))
															$top="";
															if($operation->topographie=="PN") $top="Programme normal";
															if($operation->topographie=="PHP") $top="Programme spécial hauts plateaux";
															if($operation->topographie=="PS") $top="Programme spécial Sud";
															echo "<option value=".$operation->topographie.">".html_entity_decode($top)."</option>"; ?>
															<option value="PN">Programme normal</option>
															<option value="PHP">Programme spécial hauts plateaux</option>
															<option value="PS">Programme spécial Sud</option>
														</select></td>
														<td id="<?php echo "2".$operation->id_op;?>" onclick="change_ap_initial(<?php echo $operation->id_op;?>);"><?php echo html_entity_decode($operation->ap_initial); ?> <span class="fa fa-pencil"></span></td>
														<?php 
														if ($situation_f=Situation_f::trouve_par_operation2($operation->id_op)){
															$APacc=0;
									  //$operation=Operation::trouve_par_id($situation_f->id_op);
															$APacc=$APacc+$operation->ap_initial;
															$operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
															foreach($operation_modifs as $operation_modif){
																$APacc = $APacc+ $operation_modif->reev;
															}
															?>

															<td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
															<td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
															<td><?php echo html_entity_decode($situation_f->paiements); ?></td>
															<td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->

															<td><?php if($APacc==0){ } else { echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%'); }?></td><!-- taux-->
															<td>
																<?php
																if($situation_f->etat_operation=="Gelee"){ echo html_entity_decode("Gelée");}
																if($situation_f->etat_operation=="En cours"){ echo html_entity_decode("En cours");}
																if($situation_f->etat_operation=="Acheve"){ echo html_entity_decode("Achevée");}
																if($situation_f->etat_operation=="Cloturee"){ echo html_entity_decode("Cloturée");}
																?>
															</td>
															<td><?php echo html_entity_decode($situation_f->obs); ?></td>

														<?php } else { ?>
															<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
														<?php }?>


														<th style="background:#f1f5f9">
															<?php 
															if ($situation_f=Situation_f::trouve_par_operation2($operation->id_op)){
													//echo "<script>alert(".$situation_f->etat_gelee.");</script>";
																if($situation_f->etat_gelee==1 and ($user->type=='Admin_dsp' or $user->type=='dsp' or $user->type=='Admin_psd' or $user->type=='administrateur'  or $user->type=="ministre_SG") ){


																	$sql3=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");
																	if($situation_f->valider==0){
																		if($user->type=='dsp'){
																			?>
																			<button class="btn btn-success fa fa-ok-sign" onclick="valider_sf(<?php echo $situation_f->id_situation_f ;?>)">valider</button>
																		<?php }else { ?>
																			<button class="btn btn-warning"><span class=" fa fa-refresh fa-spin" data-toggle="tooltip" title="Situation en cours de validation"></span>	</button>  
																		<?php }	
																	}
																	else{
																		if (mysqli_num_rows($sql3)==0 ){
																			if($user->type=='Admin_dsp' or $user->type=='dsp'){
																				?>


																				<a href="demande_gele.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded fa fa-unlock btn-lg" data-toggle="tooltip" title="levée de gel">  </a>
																			<?php } ?>
																			<span class="btn btn-danger btn-sm" style="background:red;cursor: help;"> opération gelée </span>
																		<?php	} else { 
																			if($user->type=='Admin_dsp' or $user->type=='dsp'){
																				?>
																				<a  class="btn btn-warning  btn-sm">Levée de gel en cours de traitement</a>
																			<?php }
																		}
																	}
																}
																else{
																	?>
																	<?php if($user->type!="ministre_SG" ){ 
																		if($situation_f->valider==1){
																			?>
																			<a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-lg fa fa-pencil" data-toggle="tooltip" title="Situation financière"> </a>
																		<?php }
																		else{ 
																			if($user->type=='dsp'){
																				?>
																				<button class="btn btn-success fa fa-ok-sign" onclick="valider_sf(<?php echo $situation_f->id_situation_f ;?>)">valider</button>
																			<?php }else { ?>
																				<button class="btn btn-warning"><span class=" fa fa-refresh fa-spin" data-toggle="tooltip" title="Situation en cours de validation"></span>	</button> 
																			<?php }
																		}
																	}
																	?>

																	<?php
																}													
																if(($user->type=='Admin_dsp' or $user->type=='dsp' or $user->type=='Admin_psd' or $user->type=='administrateur'  or $user->type=="ministre_SG") ){
																	$sql2=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");
																	if (mysqli_num_rows($sql2)!=0 and ($user->type=='Admin_dsp' or $user->type=='dsp')){
																		while($row=mysqli_fetch_array($sql2)){
																			if($row['etat_operation']!="Gelee"){	
																				?>
																				<a  class="btn btn-warning btn-sm"> En cours de traitement </a> 
																			<?php }}}else{
																				if($situation_f->etat_gelee!=1 and ($user->type=='Admin_dsp' or $user->type=='dsp')){
																					?>
																					<a href="demande_modification.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm glyphicon glyphicon-send" data-toggle="tooltip" title="Modification des caractéristiques">  </a>
																					<a href="demande_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-primary btn-rounded btn-sm glyphicon glyphicon-send" data-toggle="tooltip" title="Réévaluation/Dévaluation">  </a>
																					<?php if($situation_f->valider==1){ ?>
																						<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="Clôture ">  </a>
																						<?php
																					}
																				}
																			}
																		}
																	}else{ 

																		?>
																		<?php if($user->type!="ministre_SG"){ ?><a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-lg fa fa-pencil" data-toggle="tooltip" title="Situation financière"></a><?php  } ?>
																		<?php 
																		if($user->type=="Admin_dsp" or $user->type=='dsp'){
																			?> 
																			<a href="demande_modification.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm glyphicon glyphicon-send" data-toggle="tooltip" title=" Modification des caractéristiques">  </a>
																			<a href="demande_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-primary btn-rounded btn-sm glyphicon glyphicon-send" data-toggle="tooltip" title="Réévaluation/Dévaluation">  </a>
																			<?php if($situation_f->valider==1){ ?>
																				<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="clôture">  </a>

																				<?php
																			}
																		}
																	}
																	?>
																</th>
															</tr>
															<?php


														}
														else{
															if(($user->type=='Admin_psc' or $user->type=='administrateur'  or $user->type=='ministre_SG' or $user->id_ord==$operation->id_ord) and $rows['id_prog']==41 and $rows['id_prog']==$prog){
																?>
																<tr id ="<?php echo html_entity_decode($operation->id_op); ?>">


																	<td><?php echo html_entity_decode($operation-> num_op); ?></td>
																	<td><?php echo html_entity_decode($operation-> libelle_op); ?></td>
																	<td class="btn"  onClick="change_date(<?php echo $operation->id_op;?>);"><?php echo html_entity_decode($operation-> date_inscription); ?><span class="btn fa fa-pencil"></span></td>
																	<td><?php echo html_entity_decode($operation->num_dp); ?></td>



																	<td  id="<?php echo "2".$operation->id_op;?>" onclick="change_ap_initial(<?php echo $operation->id_op;?>);"><?php echo html_entity_decode($operation->ap_initial); ?> <span class="fa fa-pencil"></span></td>

																	<?php 
																	if ($situation_f=Situation_f::trouve_par_operation2($operation->id_op)){
																		$APacc=0;
									  //$operation=Operation::trouve_par_id($situation_f->id_op);
																		$APacc=$APacc+$operation->ap_initial;
																		$operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
																		foreach($operation_modifs as $operation_modif){
																			$APacc = $APacc+ $operation_modif->reev;
																		}
																		?>

																		<td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
																		<td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
																		<td><?php echo html_entity_decode($situation_f->paiements); ?></td>
																		<td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->

																		<td><?php if($APacc==0){ } else { echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%'); }?></td><!-- taux-->
																		<td> <?php
																		if($situation_f->etat_operation=="Gelee"){ echo html_entity_decode("Gelée");}
																		if($situation_f->etat_operation=="En cours"){ echo html_entity_decode("En cours");}
																		if($situation_f->etat_operation=="Acheve"){ echo html_entity_decode("Achevée");}
																		if($situation_f->etat_operation=="Cloturee"){ echo html_entity_decode("Clôturée");}
																		?>
																	</td>
																	<td><?php echo html_entity_decode($situation_f->obs); ?></td>


																<?php } else { ?>
																	<td></td><td></td><td></td><td></td><td></td><td></td>
																<?php }?>


																<th style="background:#f1f5f9">
																	<?php
																	if($situation_f=Situation_f::trouve_par_operation2($operation->id_op)){
																		if($situation_f->etat_gelee==1 ) {
																			$sql3=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");
																			if (mysqli_num_rows($sql3)!=0 ){
																				echo '<a  class="btn btn-warning  btn-sm">Levée de gel en cours de traitement</a>';
																			}else{	
																				if($situation_f->valider==0){
																					if($user->type=='chu' or $user->type=='ehs' or $user->type=='est' or $user->type=='dfm'){
																						?>
																						<button class="btn btn-success fa fa-ok-sign" onclick="valider_sf(<?php echo $situation_f->id_situation_f ;?>)">valider</button>
																					<?php }else { ?>
																						<button class="btn btn-warning"><span class=" fa fa-refresh fa-spin" data-toggle="tooltip" title="Situation en cours de validation"></span>	</button> 	 
																					<?php }
																				}else{	
																					if($user->type=='Admin_psc' or $user->type=='administrateur'){
																						?>
																						<a href="confirme_gelee_psc.php?id_op=<?php echo $operation->id_op."|".$rubr."|".$prog;?>" class="btn btn-info btn-rounded btn-sm fa fa-unlock" data-toggle="tooltip" title="Levée de gel">  </a>	
																						<span class="btn btn-danger btn-sm" style="background:red;cursor: help;"> opération gelée </span>
																					<?php }
																					else{
																						if($user->type!='ministre_SG'){	
																							?>
																							<a href="demande_gele.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded btn-lg fa fa-unlock" data-toggle="tooltip" title="levée de gel">  </a>
																						<?php } ?>
																						<span class="btn btn-danger btn-sm" style="background:red;cursor: help;"> Opération gelée </span>
																						<?php 
																					}
																				}
																			}
																		}

																		else {
																			$sql2=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");
																			if (mysqli_num_rows($sql2)==0 ){
																				?>
																				<?php if($user->type!="ministre_SG"){ 
																					if($situation_f->valider==1){
																						?><a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-sm fa fa-pencil" data-toggle="tooltip" title="Situation financière"> </a>
																					<?php }else{
																						if($user->type=='chu' or $user->type=='ehs' or $user->type=='est' or $user->type=='dfm'){
																							?>
																							<button class="btn btn-success fa fa-ok-sign" onclick="valider_sf(<?php echo $situation_f->id_situation_f ;?>)">valider</button>
																						<?php }else { ?>
																							<button class="btn btn-warning"><span class=" fa fa-refresh fa-spin" data-toggle="tooltip" title="Situation en cours de validation"></span>	</button> 	 
																						<?php }
																					}	
																				}																									 
																			}

																			if($user->type=='Admin_psc' or $user->type=='administrateur'){
																				?>
																				<a href="ajouter_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded fa fa-plus" data-toggle="tooltip" title="Réévaluation/dévaluation">  </a>
																				<a href="demande_modification_psc.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-warning btn-rounded btn-lg fa fa-pencil" data-toggle="tooltip" title="modification des caractéristiques">  </a>
																				<a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo  $operation->id_op;?>');" class=" btn btn-danger btn-rounded btn-lg fa fa-trash-o"></a>
																				<?php if($situation_f->valider==1){ ?>
																					<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="cloture de l'opération">  </a>


																					<?php 
																				}
																			}
																			else{
																				$sql2=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");
																				if (mysqli_num_rows($sql2)!=0 ){
																					?>
																					<span class="btn btn-warning">En cours de traitement</span>

																					<?php
																				}	
																				else{	
																					if($user->type!='ministre_SG'){												
																						?>

																						<a href="demande_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded fa fa-send" data-toggle="tooltip" title="Réévaluation/Dévaluation">  </a>
																						<a href="demande_modification.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-warning btn-rounded btn-lg fa fa-send" data-toggle="tooltip" title="Modification des caractéristiques">  </a>
																						<?php if($situation_f->valider==1){ ?>
																							<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="Clôture">  </a>

																							<?php	
																						}
																					}
																				}
																			}
																		}
																	}
																	else{?>
																		<?php 
																		if($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type == 'ministre_SG'){
																			?>
																			<?php if($user->type!="ministre_SG"){ ?><a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-sm fa fa-pencil" data-toggle="tooltip" title="Situation financière"> </a><?php } ?>
																			<a href="ajouter_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded fa fa-plus" data-toggle="tooltip" title="Réévaluation/dévaluation">  </a>
																			<a href="demande_modification_psc.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-warning btn-rounded btn-lg fa fa-pencil" data-toggle="tooltip" title="Modification des caractéristiques">  </a>
																			<a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo  $operation->id_op;?>');" class=" btn btn-danger btn-rounded btn-lg fa fa-trash-o"></a>
																			<?php if($situation_f->valider==1){ ?>
																				<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="Clôture">  </a>

																				<?php 
																			}
																		}
																		else{ ?>
																			<?php if($user->type!="ministre_SG"){ 
																				if($situation_f->valider==1){
																					?><a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-sm fa fa-pencil" data-toggle="tooltip" title="Situation financière"> </a><?php
																				}
																				else{
																					if($user->type=='chu' or $user->type=='ehs' or $user->type=='est' or $user->type=='dfm'){
																						?>
																						<button class="btn btn-success fa fa-ok-sign" onclick="valider_sf(<?php echo $situation_f->id_situation_f ;?>)">valider</button>
																					<?php }else { ?>
																						<button class="btn btn-warning"><span class=" fa fa-refresh fa-spin" data-toggle="tooltip" title="Situation en cours de validation"></span>	</button> 
																					<?php }	
																				}
																			} ?>

																		<?php }
																	} ?>




																</th>

															</tr>
															<?php	

														}
													}
												}
											}

										}

									// operation sans situations
									//********************
									//*************
										else
										{
											$sql=$bd->requete('select * from ordonnateur where id_ord='.$operation->id_ord.'');
											while($rows=$bd->fetch_array($sql)){

												if(($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type=='ministre_SG' or $user->id_ord==$operation->id_ord) and $rows['id_prog']==42 and $rows['id_prog']==$prog){


													?>

													<tr id ="<?php echo html_entity_decode($operation->id_op); ?>">


														<td><?php echo html_entity_decode($operation-> num_op); ?></td>
														<td><?php echo html_entity_decode($operation-> libelle_op); ?></td>
														<td class="btn"  onClick="change_date(<?php echo $operation->id_op;?>);"><?php echo html_entity_decode($operation-> date_inscription); ?><span class="btn fa fa-pencil"></span></td>
														<td><?php echo html_entity_decode($operation->num_dp); ?></td>  
														<td>
															<select id="<?php echo "1".$operation->id_op;?>" onchange="change_programme(<?php echo $operation->id_op;?>);"><?php 
									// if($type_pro=Type_programme::trouve_par_code($operation->code_type_prog))
															$top="";
															if($operation->topographie=="PN") $top="Programme normal";
															if($operation->topographie=="PHP") $top="Programme spécial hauts plateaux";
															if($operation->topographie=="PS") $top="Programme spécial Sud";
															echo "<option value=".$operation->topographie.">".html_entity_decode($top)."</option>"; ?>
															<option value="PN">Programme normal</option>
															<option value="PHP">Programme spécial hauts plateaux</option>
															<option value="PS">Programme spécial Sud</option>
														</select></td>
														<td  id="<?php echo "2".$operation->id_op;?>" onclick="change_ap_initial(<?php echo $operation->id_op;?>);"><?php echo html_entity_decode($operation->ap_initial); ?> <span class="fa fa-pencil"></span></td>

														<?php 
														if ($situation_f=Situation_f::trouve_par_operation2($operation->id_op)){
															$APacc=0;
									  //$operation=Operation::trouve_par_id($situation_f->id_op);
															$APacc=$APacc+$operation->ap_initial;
															$operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
															foreach($operation_modifs as $operation_modif){
																$APacc = $APacc+ $operation_modif->reev;
															}
															?>

															<td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
															<td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
															<td><?php echo html_entity_decode($situation_f->paiements); ?></td>
															<td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->

															<td><?php if($APacc==0){ } else { echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%'); }?></td><!-- taux-->
															<td><?php 
															if($situation_f->etat_operation=="Gelee"){ echo html_entity_decode("Gelée");}
															if($situation_f->etat_operation=="En cours"){ echo html_entity_decode("En cours");}
															if($situation_f->etat_operation=="Acheve"){ echo html_entity_decode("Achevée");}
															if($situation_f->etat_operation=="Cloturee"){ echo html_entity_decode("Clôturée");}
															?></td>
															<td><?php echo html_entity_decode($situation_f->obs); ?></td>


														<?php } else { ?>
															<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
														<?php }?>



														<th style="background:#f1f5f9">
													<?php if($user->type!="ministre_SG"){ 

															if ($situation_f=Situation_f::trouve_par_operation2($operation->id_op)){
													//echo "<script>alert(".$situation_f->etat_gelee.");</script>";
																if($situation_f->etat_gelee==1 and ($user->type=='Admin_dsp' or $user->type=='Admin_psd' or $user->type=='administrateur') ){
																	$sql3=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");

																	if (mysqli_num_rows($sql3)==0 ){
																		if($user->type=='Admin_dsp'){
																			?>

																			<a href="demande_gele.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded btn-lg glyphicon glyphicon-send" data-toggle="tooltip" title="demande de levée de gel">  </a>
																		<?php } ?>
																		<a  class="btn btn-danger  btn-sm"> operation gelée </a>
																	<?php	} else { 
																		if($user->type=='Admin_dsp'){
																			?>
																			<a  class="btn btn-warning  btn-sm">Levée de gel en traitement </a>
																		<?php }
																	}
																}
																else{
																	?>
																	<?php if($user->type!="ministre_SG"){ ?><a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-lg fa fa-pencil" data-toggle="tooltip" title="Situation financière"></a><?php } ?>

																	<?php
																}													
																if(($user->type=='Admin_dsp' or $user->type=='dsp' or $user->type=='Admin_psd' or $user->type=='administrateur') ){
																	$sql2=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");
																	if (mysqli_num_rows($sql2)!=0 and ($user->type=='Admin_dsp' or $user->type=='dsp')){
																		?>
																		<a  class="btn btn-warning btn-sm">En cours de traitement </a> 
																	<?php }else{
																		if($situation_f->etat_gelee!=1 and ($user->type=='Admin_dsp' or $user->type=='dsp')){
																			?>
																			<a href="demande_modification.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm glyphicon glyphicon-send" data-toggle="tooltip" title="Modification des caractéristiques"></a>
																			<a href="demande_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-primary btn-rounded btn-sm glyphicon glyphicon-send" data-toggle="tooltip" title="Réévaluation/Dévaluation"></a>
																			<?php if($situation_f->valider==1){ ?>
																				<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="Clôture ">  </a>

																				<?php
																			}
																		}
																	}
																}
															}else{ 

																?>
																<?php if($user->type!="ministre_SG"){ ?><a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-lg fa fa-pencil" data-toggle="tooltip" title="Situation financiere">  </a><?php } ?>
																<?php 
																if($user->type=="Admin_dsp" or $user->type=='dsp'){
																	$sql2=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");
																	if (mysqli_num_rows($sql2)!=0 and $user->type=='Admin_dsp'){
																		?>
																		<a  class="btn btn-warning btn-sm">En cours de traitement </a> 
																	<?php }
																	else {
																		?> 
																		<a href="demande_modification.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm glyphicon glyphicon-send" data-toggle="tooltip" title="Modification des caractéristiques"> </a>
																		<a href="demande_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-primary btn-rounded btn-sm glyphicon glyphicon-send" data-toggle="tooltip" title="Réévaluation/Dévaluation"> </a>
																		<?php if($operation->valider==1){ ?>
																			<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="Clôture">  </a>

																			<?php
																		}
																	}
																}
															}
															}
															?>





														</th>

													</tr>
													<?php


												}

//////////////////###############################################################"/////////////////	
                                       //condition pour PSC							
												else{
													if(($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type=='ministre_SG' or $user->id_ord==$operation->id_ord) and $rows['id_prog']==41 and $rows['id_prog']==$prog){
														?>
														<tr id ="<?php echo html_entity_decode($operation->id_op); ?>">
															<td><?php echo html_entity_decode($operation->num_op); ?></td>
															<td><?php echo html_entity_decode($operation->libelle_op); ?></td>
															<td class="btn"  onClick="change_date(<?php echo $operation->id_op;?>);"><?php echo html_entity_decode($operation-> date_inscription); ?><span class="btn fa fa-pencil"></span></td>
															<td><?php echo html_entity_decode($operation->num_dp); ?></td>

															<td  id="<?php echo "2".$operation->id_op;?>" onclick="change_ap_initial(<?php echo $operation->id_op;?>);"><?php echo html_entity_decode($operation->ap_initial); ?> <span class="fa fa-pencil"></span></td>

															<?php 
															if ($situation_f=Situation_f::trouve_par_operation2($operation->id_op)){
																$APacc=0;
									  //$operation=Operation::trouve_par_id($situation_f->id_op);
																$APacc=$APacc+$operation->ap_initial;
																$operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
																foreach($operation_modifs as $operation_modif){
																	$APacc = $APacc+ $operation_modif->reev;
																}
																?>

																<td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
																<td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
																<td><?php echo html_entity_decode($situation_f->paiements); ?></td>
																<td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->
																<td><?php if($APacc==0){ } else { echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%'); }?></td><!-- taux-->
																<td><?php 
																if($situation_f->etat_operation=="Gelee"){ echo html_entity_decode("Gelée");}
																if($situation_f->etat_operation=="En cours"){ echo html_entity_decode("En cours");}
																if($situation_f->etat_operation=="Acheve"){ echo html_entity_decode("Achevée");}
																if($situation_f->etat_operation=="Cloturee"){ echo html_entity_decode("Clôturée");}
																?></td>
																<td><?php echo html_entity_decode($situation_f->obs); ?></td>

															<?php } else { ?>
																<td></td><td></td><td></td><td></td><td></td><td></td><td></td>
															<?php }?>

															<th style="background:#f1f5f9">
														<?php if($user->type!="ministre_SG"){ 
																if($situation_f=Situation_f::trouve_par_operation2($operation->id_op)){
																	if($situation_f->etat_gelee==1 ) {
																		if($user->type=='Admin_psc' or $user->type=='administrateur'){
																			?>
																			<a href="confirme_gelee_psc.php?id_op=<?php echo $operation->id_op;?>" class="btn btn-success btn-rounded btn-sm">Levée de gel</a>	
																		<?php }
																		else{ }
																	}

																else { ?>
																	<?php if($user->type!="ministre_SG"){ ?><a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-sm fa fa-pencil" data-toggle="tooltip" title="Situation financière"> </a><?php } ?>
																	<?php 
																	if($user->type=='Admin_psc' or $user->type=='administrateur'){
																		?>
																		<?php if($user->type!="ministre_SG"){ ?>
																			<a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-sm fa fa-pencil" data-toggle="tooltip" title="Situation financière"> </a><?php } ?>
																			<a href="ajouter_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded fa fa-plus" data-toggle="tooltip" title="Réévaluation/Dévaluation">  </a>
																			<a href="demande_modification_psc.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-warning btn-rounded btn-lg fa fa-pencil" data-toggle="tooltip" title="modification des caractéristiques" >  </a>
																			<a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo  $operation->id_op;?>');" class=" btn btn-danger btn-rounded btn-lg fa fa-trash-o"></a>
																			<?php if($situation_f->valider==1){ ?>
																				<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="Clôture ">  </a>

																				<?php 
																			}
																		}
																		else{

																			?>

																			<a href="demande_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded fa fa-send" data-toggle="tooltip" title="Réévaluation/Dévaluation">  </a>
																			<a href="demande_modification.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-warning btn-rounded btn-lg fa fa-send" data-toggle="tooltip" title="modification des caractéristiques">  </a>
																			<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="Clôture">  </a>

																			<?php
																		}
																	}
																}
																else{?>
																	<?php 
																	if($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type == 'ministre_SG'){

																		?>
																		<?php if($user->type != 'ministre_SG'){ ?>
																			<a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-sm fa fa-pencil" data-toggle="tooltip" title="Situation financière">  </a><?php } ?>
																			<?php 
																			$sql2=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");
																			if (mysqli_num_rows($sql2)!=0 ){
																				?>
																				<a  class="btn btn-warning btn-sm">En cours de traitement </a> 
																			<?php }
																			else{ ?>
																				<a href="ajouter_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded fa fa-plus" data-toggle="tooltip" title="Réévaluation/Dévaluation">  </a>
																				<a href="demande_modification_psc.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-warning btn-rounded btn-lg fa fa-pencil" data-toggle="tooltip" title="modification des caractéristiques">  </a>
																				<a style="color:#ff0000;font-size:20px" onClick="delete_row('<?php echo  $operation->id_op;?>');" class=" btn btn-danger btn-rounded btn-lg fa fa-trash-o"></a>
																				<?php if($operation->valider==1){ ?>
																					<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="Clôture">  </a>

																					<?php 
																				}
																			}
																		}
																		else{ ?>
																			<?php if($user->type!="ministre_SG"){ ?>
																				<a href="ajouter_sf.php?id_op=<?php echo $operation->id_op."&id_projet=".$_GET['id_projet'];?>" class="btn btn-success btn-rounded btn-sm fa fa-pencil" data-toggle="tooltip" title="Situation financière">  </a><?php } ?>
																				<?php 
																				$sql2=$bd->requete("select * from operation_modif where valide=0 and id_op=".$operation->id_op."");
																				if (mysqli_num_rows($sql2)!=0 ){
																					?>
																					<a  class="btn btn-warning btn-sm">En cours de traitement </a> 
																				<?php }
																				else{ ?>
																					<a href="demande_reevaluation.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-info btn-rounded fa fa-send" data-toggle="tooltip" title="Réévaluation/Dévaluation">  </a>
																					<a href="demande_modification.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-warning btn-rounded btn-lg fa fa-send" data-toggle="tooltip" title="modification des caractéristiques">  </a>
																					<?php if($operation->valider==1){ ?>
																						<a href="cloture.php?id_projet=<?php echo $_GET['id_projet']; ?>&id_op=<?php echo $operation->id_op;?>" class="btn btn-danger btn-rounded btn-sm fa fa-lock" data-toggle="tooltip" title="Clôture">  </a>


																						<?php 
																					}
																				}
																			}
																		}
																		} ?>




																	</th>

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
								<?php if(isset($_GET['code_struct'])){ ?><a href="ajouter_projet.php?code_struct=<?php echo $_GET['code_struct'];?>" class="btn btn-danger pull-right"   >Retour</a><?php } ?>
								<?php      
							}
							list($id0,$rubr,$prog)=explode("|",$_GET['id_projet']);	
							if(isset($_POST['submit2'])){
								
								$ordonnateur=$_POST['id_ord1'];	
								//echo "<script>alert(".$rubr.")</script>";
								?>
								<div class="panel-footer">
									<h3><?php $ord=Ordonnateur::trouve_par_id($_POST['id_ord1']); echo $ord->nom_ord; ?></h3>
								</div>
								<?php
								filtrer_operation($user,$ordonnateur,$id,$rubr,$prog);

							}
							else
								if(($user->type!="Admin_psc" and $user->type!="Admin_psd" and $user->type!="administrateur" and $user->type!="ministre_SG") and $id==0 ){
									
									filtrer_operation($user,$user->id_ord,$id,$rubr,$prog);	
								}else
								if($id!=0 and ($user->type!="Admin_dsp" or $user->type!="Admin_psd" or $user->type!="administrateur" ) ){
									$ordonnateur="tous";
									filtrer_operation($user,$ordonnateur,$id,$rubr,42);
								}
								?>
								
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


			<div class="message-box  animated fadeIn" data-sound="alert" id="mb-signout">
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

			<!--modification date -->
			<div class="message-box animated fadeIn" data-sound="alert" id="mb-change_date">
				<div class="mb-container" >
					<div class="mb-middle">
						<div class="mb-title"><span class="fa fa-pencil"></span> Changer la date d'inscription<strong>  </strong> ??!!</div>
						<div class="mb-content">
							<br>
							<div class="form-group" style ="dir:rtl;" >

								<label class="col-md-3 control-label" >Nouvelle date</label>	    
								<div class="col-md-6 col-xs-12">  

									<div class="input-group">
										<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
										<input type="date"  id="date_inscription0" name="date_inscription0" class="form-control change_date" class="form-control"  required  />
									</div>                                            
								</div>

							</div>    
						</div>
						<center><div class="mb-footer">
							<div class="valid_div">
								<button  class="btn btn-success btn-lg mb-control-yes" >changer</button>
								<button class="btn btn-default btn-lg mb-control-close">annuler</button>
							</div>
						</div>
					</center>
				</div>
			</div>
		</div>
		
		<!--modification date -->
		<div class="message-box animated fadeIn" data-sound="alert" id="mb-change_ap_initial">
			<div class="mb-container">
				<div class="mb-middle">
					<div class="mb-title"><span class="fa fa-pencil"></span> Correction d'AP initiale<strong>  </strong> ??!!</div>
					<div class="mb-content">
						<br>
						<div class="form-group" style ="dir:rtl;" >

							<label class="col-md-3 control-label" >Correcte AP initiale</label>	    
							<div class="col-md-6 col-xs-12">  

								<div class="input-group">
									<span class="input-group-addon"><span class="fa fa-money"></span></span>
									<input type="number" step="2"  id="ap_initial1" name="ap_initial1" class="form-control change_date" class="form-control"  required  />
								</div>                                            
							</div>

						</div>    
					</div>
					<center><div class="mb-footer">
						<div class="valid_div">
							<button  class="btn btn-success btn-lg mb-control-yes1" >Changer</button>
							<button class="btn btn-default btn-lg mb-control-close">Annuler</button>
						</div>
					</div>
				</center>
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
		$nbr2=0;
		$nbr3=0;
		$sql=$bd->requete("select * from operation_modif where id_ord=".$user->id_ord." and valide!=0");
		$sql1=$bd->requete("select * from operation_modif where id_ord=".$user->id_ord."");
		$sql2=$bd->requete("select * from situation_f,operation where situation_f.id_op=operation.id_op and operation.id_ord=".$user->id_ord." and situation_f.valider!=0");
		$sql3=$bd->requete("select * from situation_f,operation where  situation_f.id_op=operation.id_op and operation.id_ord=".$user->id_ord."");
		$nbr=mysqli_num_rows($sql);
		$nbr1=mysqli_num_rows($sql1);
		$nbr2=mysqli_num_rows($sql2);
		$nbr3=mysqli_num_rows($sql3);

		?>
		setInterval('actualiser(<?php echo $nbr.",".$nbr1.",".$nbr2.",".$nbr3;?>)',500);
				//setTimeout('load_connect()',500);
				function actualiser(nbr,nbr1,nbr2,nbr3){

					$.ajax({

						method:"post",
						url:"ajax_calcule_operation.php",
						data:{nbr:nbr,nbr1:nbr1,nbr2:nbr2,nbr3:nbr3 },
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

				function change_date(id){
					$('#mb-change_date').show();  

					$('.mb-control-yes').on('click',function(){
						var n_date=$('#date_inscription0').val();
	//alert(n_date.split('-').join(''));
	
	if(!n_date){
		alert('date incorrect');
		return false;
	}
	$.ajax({

		method:"post",
		url:"ajax_change_date.php",
		data:{ id: id,n_date:n_date },
		success:function(resultData){
			$('#mb-change_date').hide(); 	
			window.location.reload();

		}
	})

});
				}
//changer type_programme
function change_programme(id){

	var programme =$("#1"+id+" :selected").val();

	//alert(programme);
	
	$.ajax({

		method:"post",
		url:"ajax_change_programme.php",
		data:{ id:id,programme:programme },
		success:function(resultData){
			alert(resultData);



		}
	})


}
//changer ap_initial
function change_ap_initial(id){
	$('#mb-change_ap_initial').show();  

	$('.mb-control-yes1').on('click',function(){
		var ap_initial=$('#ap_initial1').val();
	//alert(n_date.split('-').join(''));
	

	$.ajax({

		method:"post",
		url:"ajax_change_ap_initial.php",
		data:{ id: id,ap_initial:ap_initial },
		success:function(resultData){
			$('#mb-change_dap_initial').hide(); 	
			window.location.reload();

		}
	})

});
}
//function valider_sf
function valider_sf(id){
	
	$.ajax({

		method:"post",
		url:"ajax_valider_sf.php",
		data:{ id: id},
		success:function(resultData){
			alert(resultData);
	//$('#mb-change_date').hide(); 	
	window.location.reload();

}
})

}


$('#submit2').on('click',function(){

	$('#num_op').removeAttr('required');
	$('#libelle_op').removeAttr('required');
	$('#num_dp').removeAttr('required');
	$('#ap_initial').removeAttr('required');
	
	$('#date_inscription').removeAttr('required');
	$('#code_type_prog').removeAttr('required');
	$('#code_rubrique').removeAttr('required');
	$('#id_ord').removeAttr('required');
	$('#id_ss').removeAttr('required');


});

function ajouter(){
	$('#mb-ajouter').show();    
}

$('.mb-control-close').on('click',function(){
	$('#mb-ajouter').hide(); 
	$('#mb-change_date').hide(); 	
	$('#mb-change_ap_initial').hide();	

})

$('#table0').dataTable( 
{
	"columnDefs": [
	<?php   
	if($prog==41){
		?>
		{ "width": "225px", "targets": 12 },

		<?php   
	}
	if($prog==42 or $prog==null){
		?>
		{ "width": "225px", "targets": 13 },
		{ "width": "100px", "targets": 5 },
		<?php   
	}
	?>

	],
	"searching": true,
	"paging":true,
	"ordering": false,
	"scrollX": "200%", 


} ); 
$(document).ready(function(){
	document.getElementById('table0').scrollIntoView({ inline:'end' });
});


</script> 
<style>
	table,tr,th,td{
		padding-left:3px;
		//border:1px solid black;	
	}
	tr:hover td {background:#999;color:#000;cursor: pointer;}

</style>		  
<!-- END TEMPLATE -->
<!-- END SCRIPTS -->                   
</body>
</html>






