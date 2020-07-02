<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_psd' or 'Admin_psc');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder à cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 
?>
<?php

if ( (isset($_GET['id_op'])) && (is_numeric($_GET['id_op'])) ) {
$id = $_GET['id_op'];

if($operation=Operation::trouve_par_id($id)){
	$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
//	echo "<script>alert(".$ordonnateur->id_prog.")</script>";
	if(($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){

		
	}	
	else{

	
	if(($user->type=='Admin_psc' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==41){

		
	}	
	else{
	readresser_a('index.php');	
	}
	
}
}
else{
	readresser_a('index.php');
}
	
	
}



	if(isset($_POST['submit'])){
	$errors = array();
	
	
	
	
	
	

	
	
	// new object document
	$situation_f = new Situation_f();
	$situation_f->id_op =  ($_GET['id_op']); 
	$situation_f->date_situation_f = htmlspecialchars(trim($_POST['date_cloture']));
	

	$situation_f->obs = htmlspecialchars(trim($_POST['numero_decesion']));
	if($user->type=="administrateur" or $user->type=="Admin_psd" or $user->type=="Admin_psc" or $user->type=="dsp" or $user->type=="chu" or $user->type=="ehs" or  $user->type=="est"){
	$situation_f->etat_operation = 'Cloturee';
	
$situation_f->etat_gelee =-2 ;
$sql=$bd->requete("update situation_f set last=0 where id_op=".$_GET['id_op']."");
	$situation_f->valider=1; 
	
	$situation_f->last=1;
	}
	else{
		$situation_f->etat_operation = 'Cloturee';	
	}
	
	
	if (empty($errors)){
   		
		 $situation_f->save();
 		  $msg_positif = '<p style= "font-size: 20px; ">    opération clôturée   </p><br />';
		if($user->type=="administrateur" or $user->type=="Admin_psd" or $user->type=="Admin_psc" or $user->type=="dsp" or $user->type=="chu" or $user->type=="ehs" or  $user->type=="est"){
	echo "<script>alert('opération clôturée '); window.location.replace('ajouter_operation.php?id_projet=".$_GET['id_projet']."');</script>";
		}
		else {
		echo "<script>alert('Attente de validation du Directeur ');window.location.replace('ajouter_operation.php?id_projet=".$_GET['id_projet']."');</script>";
			
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
$titre = "Demande modification";
$active_menu = "index";
$header = array('operation');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_psd' or 'Admin_psc'){
	require_once("composit/header.php");
}
?>


<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#"> Opération</a></li>
                    <li class="active">Clôture d'opération</li>
                </ul>
                <!-- END BREADCRUMB -->
                	 
                <!-- PAGE CONTENT WRAPPER -->
				
                <div class="page-content-wrap">
				
                 <br><br><br><br><br><br>
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_operation" id = "ajouter_operation" action="<?php echo $_SERVER['PHP_SELF'].'?id_projet='.$_GET['id_projet'].'&id_op='.$id;?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong>Clôture de l'opération  
									<?php echo " Numéro :<span style='color:#1caf9a'>".$operation->num_op."</span> et libellé :<span style='color:#1caf9a'>".$operation->libelle_op."</sapn>" ?></strong></h3>
                                    
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
                               
								<?php  $operation=Operation::trouve_par_id($_GET['id_op']); 
								 $APacc=0;
                                  if($situation_f=Situation_f::trouve_par_operation2($operation->id_op)){
									  $APacc=$APacc+$operation->ap_initial;
									   $operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }  
								  }
								?>
                                <div class="panel-body">                                                                        
                           
                                           <div class="form-group" >
                                                <label class="col-md-3 col-xs-12 control-label">Numéro de décission : </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon">N°</span>
                                                        <input type="number" class="form-control" name ="numero_decesion" required  >
                                                    </div>                                            
                                                 </div>
												 
                                            </div> 
											 <div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label">Date de clôture :</label>
                                               <div class="col-md-4 col-xs-12">                                           
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                        <input type="date" class="form-control" id ="date_cloture" name ="date_cloture" required >
                                                    </div>                                            
                                                 </div>
											
                                            </div>
                                           
											<div class="form-group" >
                                                <label class="col-md-3 col-xs-12 control-label">Montant de clôture: </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-check"></span></span>
                                                        <input style="color:#666" type="text" class="form-control" id="montant" name="montant" value="<?php echo $APacc; ?>" readonly  >
                                                    </div>                                            
                                                 </div>
												
                                            </div>
										
                                </div>
								
                                <div class="panel-footer">
                                    <a class="btn btn-danger" href='ajouter_operation.php?id_projet=<?php echo $_GET['id_projet']; ?>'>Retour</a>                                     
                                    <button class="btn btn-primary pull-right"type = "submit" name = "submit">Clôturer </button>
                                </div>
                            </div>
							 </div>
                        </form>
                            
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
				   <script>
				 
				  
				   </script>
		<!-- END THIS PAGE PLUGINS -->       
        
        <!-- START TEMPLATE -->
   
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>   
     <body onload="change();$('#-3').hide();">		
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>






