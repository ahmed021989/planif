<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_msprh');
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

if ( (isset($_GET['id_op'])) && (is_numeric($_GET['id_op'])) ) {
$id = $_GET['id_op'];
	
	
}




	if(isset($_POST['submit'])){
	$errors = array();

	
	
	
	
	
    if (isset($_POST['etat_operation']) and  !empty($_POST['etat_operation'])){
	if ($_POST['etat_operation'] == '-2'){
		$errors[] = '<p style= "font-size: 20px; ">  Sélectionner un etat de l`opération  !!??</p>';
	}
	}
	
	  
									  $APacc=0;
									  $operation=Operation::trouve_par_id($_GET['id_op']);
									  $APacc=$APacc+$operation->ap_initial;
									   $operation_modifs=Operation_modif::trouve_tous_reev($_GET['id_op']);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									  
	
	// new object document
	$situation_f = new Situation_f();

	
	

	$situation_f->id_op =  ($_GET['id_op']); 
	$situation_f->date_situation_f = htmlspecialchars(trim($_POST['date_situation_f']));
	$situation_f->ap_engag = htmlspecialchars(trim($_POST['ap_engag']));
	$situation_f->paiements = htmlspecialchars(trim($_POST['paiements']));
	$situation_f->etat_operation = htmlspecialchars(trim($_POST['etat_operation']));
	$situation_f->obs = htmlspecialchars(trim($_POST['obs']));
	$situation_f->situation = htmlspecialchars(trim($_POST['situation']));
	
		if($_POST['etat_operation']=="Clôturées"){
		$situation_f->etat_gelee =-2 ;
		}else{
			if($_POST['etat_operation']!="Clôturées"){
		//$situation_f->etat_operation = htmlspecialchars(trim($_POST['etat_operation']));
        $situation_f->etat_gelee =0	;	
			
		}
		}
		
	if($APacc<$_POST['ap_engag']){
			$msg_error = "<h3> AP actuel ".$APacc." est inferieur à l'AP engagée ".$_POST['ap_engag']." </h3>";
		//echo "<script>alert('');</script>";
	}else{
	if($_POST['paiements']>$_POST['ap_engag']){
			$msg_error = "<h3> Paiement: ".$_POST['paiements']." est superieur à l'AP engagée : ".$_POST['ap_engag']." </h3>";
		//echo "<script>alert('');</script>";
	}	
	
	else{
	
	
	

$operation= Operation :: trouve_par_id($id);
	if (empty($errors)){
   		
			$situation_f->save();
 		$msg_positif = '<p style= "font-size: 20px; ">   La situation financière  du   " ' .  html_entity_decode($situation_f->date_situation_f).  '" de l`opération  "' .  html_entity_decode($operation->libelle_op).  '" est bien ajouter  </p><br />';
		
		
 		 
 		}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " - $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}
	
}
	}
	}

?>
<?php
$titre = "Liste des opérations clôturées";
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
                  
                    <li class="active">Liste des opérations clôturées</li>
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
                                    
									 <h3 class="panel-title"><strong>| Liste des opérations planifiées <span style="color:red;font-weight:bold"> &nbsp; Cloturées </span>&nbsp; du  :&nbsp; <span style="color:#1caf9a;font-weight:bold"><?php if ( $ord=Ordonnateur::trouve_par_id($user->id_ord)){ echo $ord->nom_ord;}else{}?> </span></strong></h3>
								
                                                                  
                                </div>
                                <div class="panel-body">
								 <div class="scrollable">
                                    <table class="table datatable table-striped">
                                      <thead>
                                       <tr>
										    <th>N°ordre</th>
											<th>Rubrique </th>
											<th style="width:172px">N°Opération </th>
											<th>Libellé d'opération </th>
											
											
                                           
											<th>Montant de la clôture </th>
											<th>Date de la clôture</th>
											<th>N° decision de la clôture</th>
                                            	
											<th>Etat d'opération</th> 
											
										
											
                                            </tr>
                                      </thead>
										 <tbody>
									<?php
									$i=1;
									$operations=Operation::trouve_filtre_ord($user->id_ord);
foreach($operations as $operation){
	$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
			if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
				if($situation_f->etat_operation=='Cloturee' and $situation_f->valider==1 ){
								
								?>
								 <?php 
									  $APacc=0;
									  $operation=Operation::trouve_par_id($situation_f->id_op);
									  $APacc=$APacc+$operation->ap_initial;
									   $operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									  ?>
                                             <tr style=" "  id="<?php echo $operation->id_op; ?>">
										<td style="background:#f1f5f9"><?php echo $i; ?></td>
										<td><?php $rubrique = Rubrique:: trouve_par_code($operation-> code_rubrique); echo html_entity_decode($rubrique->nom_rubrique); ?></td>
                                        
										<td><?php echo html_entity_decode($operation->num_op); ?></td>
										<td ><?php echo html_entity_decode($operation->libelle_op); ?></td>
										
										
										
										<td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
										<td><?php echo html_entity_decode($situation_f->date_situation_f); ?></td>
                                       <td><?php echo html_entity_decode($situation_f->obs); ?></td>
						
											<td><?php 
										                    if($situation_f->etat_operation=="Gelee"){ echo html_entity_decode("Gelée");}
															if($situation_f->etat_operation=="En cours"){ echo html_entity_decode("En cours");}
															if($situation_f->etat_operation=="Achevee"){ echo html_entity_decode("Achevée");}
															if($situation_f->etat_operation=="Cloturee"){ echo html_entity_decode("Cloturée");}
                                      ?></td>
                                       
											
										
										
                                    </tr>
                                   <?php
								   $i++;
}

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






