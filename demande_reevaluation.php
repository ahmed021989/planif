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
	$operation = new  Operation_modif();
	
     $operation-> id_op=($_GET['id_op']);
	$operation-> n_dec= htmlspecialchars(trim(addslashes($_POST['n_dec'])));
	if($_POST['rev']=="+"){
	$operation-> reev = htmlspecialchars(trim(addslashes($_POST['reev'])));
	}
	if($_POST['rev']=="-"){
	$operation-> reev = htmlspecialchars(trim(addslashes(-$_POST['reev'])));
	}

  $operation->user =$user->nom_compler();
	$operation-> date_modif = htmlspecialchars(trim(addslashes($_POST['date_modif'])));
	$operation-> valide =0;
	$dat=date('Y-m-d H:i');
	$operation-> date_demande =$dat;
	 $ancien_operation=Operation::trouve_par_id($_GET['id_op']);
	$operation-> id_ord = $ancien_operation->id_ord;
		$operation-> a_numero_op = $ancien_operation->num_op;
	$operation-> a_nom_oper = $ancien_operation->libelle_op;
	
	
	
	if (empty($errors)){
   		
			$operation->save();
			echo "<script>alert('Votre demande a été envoyé à la DEP ' );;window.location.replace('ajouter_operation.php?id_projet=".$_GET['id_projet']."'); </script>";
			//readresser_a('index.php');
 		  $msg_positif = '<p style= "font-size: 20px; ">    votre demande de  "  " est envoyée   </p><br />';
		
		
 		 
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
$titre = "Demande Réevaluation";
$active_menu = "index";
$header = array('operation');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est'){
	require_once("composit/header.php");
}
?>


<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="#"> opération</a></li>
                    <li class="active"> Réévaluation/Dévaluation</li>
                </ul>
                <!-- END BREADCRUMB -->
                	 
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
				
                 
                    <div class="row">
                        <div class="col-md-12">
                            
                          <form class="form-horizontal" name="ajouter_operation" id = "ajouter_operation" action="<?php echo $_SERVER['PHP_SELF'].'?id_projet='.$_GET['id_projet'].'&id_op='.$id;?>" method="post">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><strong> Réévaluation/Dévaluation</strong></h3>
                                    
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
                               
								<?php  $operation=Operation::trouve_par_id($_GET['id_op']);  ?>
                                <div class="panel-body">                                                                        
                                    <center>  <div class="form-group">
                                              <!--  <label class="col-md-3 control-label">Choisir entre réévaluation/dévaluation</label>-->
                                              <div class="col-md-10"> 

    <input type="radio" name="rev" id="rev" style="width:20px;height:20px;background-color:#399"  value="+" checked="checked" > Réévaluation
&nbsp;&nbsp;
    <input type="radio" name="rev" id="rev" style="width:20px;height:20px;background-color:#399"  value="-"   >Dévaluation
	                                   
									   </div>
										</div>
										</center>
										<br>
                                 
                                            <div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label">Date de la décision :</label>
                                               <div class="col-md-4 col-xs-12">                                           
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                        <input type="date" class="form-control" name ="date_modif" required >
                                                    </div>                                            
                                                 </div>
											
                                            </div>
                                    
                                    <div class="form-group" id="-3">
                                                <label class="col-md-3 col-xs-12 control-label"> Numéro de la décision : </label>
                                               <div class="col-md-4 col-xs-12">                                             
                                                    <div class="input-group">
                                                        <span class="input-group-addon">N°</span>
                                                        <input type="number" class="form-control" name ="n_dec" required  >
                                                    </div>                                            
                                                 </div>
												 
                                            </div> 
											
											 <div class="form-group">
                                               <label class="col-md-3 col-xs-12 control-label">Montant: </label>
                                               <div class="col-md-4 col-xs-12">                                           
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-money"></span ></span>
                                                        <input type="number" min="1" class="form-control" step="0.01" name ="reev" required >
                                                   <span class="input-group-addon"><span>DA</span></span>
                                                        
												   </div> 
                                           														
                                                 </div>
											
                                            </div>
                                           
                                         
											

                                </div>
								
                                <div class="panel-footer">
 <a class="btn btn-danger" href='ajouter_operation.php?id_projet=<?php echo $_GET['id_projet']; ?>'>Retour</a>   
                                    <button class="btn btn-primary pull-right"type = "submit" name = "submit">Envoyer </button>
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
				
		<!-- END THIS PAGE PLUGINS -->       
        
        <!-- START TEMPLATE -->
   
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>   
     <body onload="change();$('#-3').hide();">		
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->                   
    </body>
</html>





