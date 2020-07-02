<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' );
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page  ccsdcsdc";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 

}
?>
<?php 
$titre = "Les opérations";
$active_menu = "index";
$header = array('personne');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' ){
	require_once("composit/header.php");
    
}
?>

             
                   <ul class="breadcrumb">
                  <li><a href="index.php">Acceuil</a></li>  
					  <li class="active"><?php echo $titre ?></li>  
                </ul>
                <!-- END BREADCRUMB -->
                <!-- PAGE TITLE -->
                <div class="page-title">                    
                    <h2><span class="fa fa-folder-open"></span> Les opérations PSD</h2>
					
                </div>
                <!-- END PAGE TITLE -->
          
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                                
      
                
                    <!-- START DEFAULT DATATABLE -->
                          
								
								
								<div class="col-md-12">                        
                            <!-- START JUSTIFIED TABS -->
                            <div class="panel panel-default tabs">
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="active"><a href="#tab8" data-toggle="tab"><span class="fa fa-folder-open" style="font-size:20px" ></span> Opération en cours</a></li>
                                    <li><a href="#tab9" data-toggle="tab"><span class="fa fa-retweet" style="font-size:20px" > </span> Operations Clôturées</a></li>
                                    <li><a href="#tab10" data-toggle="tab"><span class="fa fa-check-square " style="font-size:20px" > </span>Operations  Gelées </a></li>
									  <li><a href="#tab11" data-toggle="tab"><span class="fa fa-times-circle" style="font-size:20px" > </span>Operations Annulées</a></li>
									  
                                </ul>
                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="tab8">
                                          <div class="page-content-wrap">
       			
               <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Listes Situations En cours </strong></h3>
									
                                                                   
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
											<th>Ordonnateur</th>
											<th>Operation</th>
                                                <th>date_situation_f</th>
                                              <th>ap_Actuel </th>
                                                <th>ap_engag </th>
                                                <th>paiements</th>
												 <th>PEC</th>
												 <th>taux</th>
												
												  <th>etat operation</th> 
												   <th>obs</th>
												    <th>situation</th>
													
												
                                                <th>Mise à jour </th>
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$operations=Operation::trouve_tous();
foreach($operations as $operation){
			if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
				$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
				
			


if($situation_f->etat_operation=='En cours' and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){
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
											
												 <td><?php $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord); echo html_entity_decode($ordonnateur->nom_ord);  ?></td>
                                           
											  <td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->libelle_op);  ?></td>
                                               
                                                <td><?php echo html_entity_decode($situation_f->date_situation_f); ?></td>
                                               <td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
												 <td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
												  <td><?php echo html_entity_decode($situation_f->paiements); ?></td>
												     <td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->
						
												   <td><?php  if ($APacc!=0){echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else echo 0.00; ?></td><!-- taux-->
												    <td><?php echo html_entity_decode($situation_f->etat_operation); ?></td>
                                                 <td><?php echo html_entity_decode($situation_f->obs); ?></td>
												 <td><?php echo html_entity_decode($situation_f->situation); ?></td>
                                              
                                               <td>
												<?php 
												if($situation_f->etat_operation =='En cours' or $situation_f->etat_operation =='Annulées'){
												?>
												  <a href="edit_sf.php?id=<?php echo $situation_f->id_situation_f;?>"><button class="btn btn-info btn-rounded " style = "text-align: right;"><span class="fa fa-pencil"></span></button><a>
											
												  <button class="btn btn-danger btn-rounded " onClick="delete_row('<?php echo $situation_f->id_situation_f;?>');"><span class="glyphicon glyphicon-trash"></span></button>
												<?php } else {?>
												
												
													<?php  }?>
													</td>
                                            </tr>
                                  <?php
}





}}

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
                <!-- END PAGE CONTENT WRAPPER -->                                                
                     
            <!-- END PAGE CONTENT -->
        </div>   </div>
                                    <div class="tab-pane" id="tab9">
                                           <div class="page-content-wrap">
       			
               <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Listes Situations Cloturées </strong></h3>
									
                                                                   
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
											<th>Ordonnateur</th>
											<th>Operation</th>
                                                <th>date_situation_f</th>
                                              <th>ap_Actuel </th>
                                                <th>ap_engag </th>
                                                <th>paiements</th>
												 <th>PEC</th>
												 <th>taux</th>
												
												  <th>etat operation</th> 
												   <th>obs</th>
												    <th>situation</th>
													
												
                                                <th>Mise à jour </th>
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$operations=Operation::trouve_tous();
foreach($operations as $operation){
			if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
				$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
				
								


if($situation_f->etat_operation=='Cloturées' and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){
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
											
												 <td><?php $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord); echo html_entity_decode($ordonnateur->nom_ord);  ?></td>
                                           
											  <td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->libelle_op);  ?></td>
                                               
                                                <td><?php echo html_entity_decode($situation_f->date_situation_f); ?></td>
                                               <td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
												 <td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
												  <td><?php echo html_entity_decode($situation_f->paiements); ?></td>
												     <td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->
						
												   <td><?php  if ($APacc!=0){echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else echo 0.00; ?></td><!-- taux-->
												    <td><?php echo html_entity_decode($situation_f->etat_operation); ?></td>
                                                 <td><?php echo html_entity_decode($situation_f->obs); ?></td>
												 <td><?php echo html_entity_decode($situation_f->situation); ?></td>
                                              
                                               <td>
												<?php 
												if($situation_f->etat_operation =='En cours' or $situation_f->etat_operation =='Annulées'){
												?>
												  <a href="edit_sf.php?id=<?php echo $situation_f->id_situation_f;?>"><button class="btn btn-info btn-rounded " style = "text-align: right;"><span class="fa fa-pencil"></span></button><a>
											
												  <button class="btn btn-danger btn-rounded " onClick="delete_row('<?php echo $situation_f->id_situation_f;?>');"><span class="glyphicon glyphicon-trash"></span></button>
												<?php } else {?>
												
												
													<?php  }?>
													</td>
                                            </tr>
                                  <?php
}





}}

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
                <!-- END PAGE CONTENT WRAPPER -->                                                
                     
            <!-- END PAGE CONTENT -->
        </div> 
		</div>
                                    <div class="tab-pane" id="tab10">
                                        <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Listes Situations Gelée </strong></h3>
									
                                                                    
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
											<th>Ordonnateur</th>
											<th>Operation</th>
                                                <th>date_situation_f</th>
                                              <th>ap_Actuel </th>
                                                <th>ap_engag </th>
                                                <th>paiements</th>
												 <th>PEC</th>
												 <th>taux</th>
												
												  <th>etat operation</th> 
												   <th>obs</th>
												    <th>situation</th>
													
												
                                                <th>Mise à jour </th>
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$operations=Operation::trouve_tous();
foreach($operations as $operation){
			if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
				$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
				
							


if($situation_f->etat_operation=='Gelee' and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){
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
											
												 <td><?php $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord); echo html_entity_decode($ordonnateur->nom_ord);  ?></td>
                                           
											  <td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->libelle_op);  ?></td>
                                               
                                                <td><?php echo html_entity_decode($situation_f->date_situation_f); ?></td>
                                               <td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
												 <td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
												  <td><?php echo html_entity_decode($situation_f->paiements); ?></td>
												     <td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->
						
												   <td><?php  if ($APacc!=0){echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else echo 0.00; ?></td><!-- taux-->
												    <td><?php echo html_entity_decode($situation_f->etat_operation); ?></td>
                                                 <td><?php echo html_entity_decode($situation_f->obs); ?></td>
												 <td><?php echo html_entity_decode($situation_f->situation); ?></td>
                                              
                                               <td>
												<?php 
												if($situation_f->etat_operation =='En cours' or $situation_f->etat_operation =='Annulées'){
												?>
												  <a href="edit_sf.php?id=<?php echo $situation_f->id_situation_f;?>"><button class="btn btn-info btn-rounded " style = "text-align: right;"><span class="fa fa-pencil"></span></button><a>
											
												  <button class="btn btn-danger btn-rounded " onClick="delete_row('<?php echo $situation_f->id_situation_f;?>');"><span class="glyphicon glyphicon-trash"></span></button>
												<?php } else {?>
												
												
													<?php  }?>
													</td>
                                            </tr>
                                  <?php
}





}}

                                 ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>     </div>   
                                     <div class="tab-pane" id="tab11">
                                        <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Listes Situations Annulées </strong></h3>
									
                                                                   
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
											<th>Ordonnateur</th>
											<th>Operation</th>
                                                <th>date_situation_f</th>
                                              <th>ap_Actuel </th>
                                                <th>ap_engag </th>
                                                <th>paiements</th>
												 <th>PEC</th>
												 <th>taux</th>
												
												  <th>etat operation</th> 
												   <th>obs</th>
												    <th>situation</th>
													
												
                                                <th>Mise à jour </th>
                                            </tr>
                                        </thead>
										 <tbody>
									<?php
									$operations=Operation::trouve_tous();
foreach($operations as $operation){
			if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
				$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
				

if($situation_f->etat_operation=='Annulées' and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){
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
											
												 <td><?php $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord); echo html_entity_decode($ordonnateur->nom_ord);  ?></td>
                                           
											  <td><?php $operation = Operation:: trouve_par_id($situation_f->id_op); echo html_entity_decode($operation->libelle_op);  ?></td>
                                               
                                                <td><?php echo html_entity_decode($situation_f->date_situation_f); ?></td>
                                               <td><?php echo html_entity_decode($APacc); ?></td> <!-- APACtuel-->
												 <td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
												  <td><?php echo html_entity_decode($situation_f->paiements); ?></td>
												     <td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->
						
												   <td><?php  if ($APacc!=0){echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else echo 0.00; ?></td><!-- taux-->
												    <td><?php echo html_entity_decode($situation_f->etat_operation); ?></td>
                                                 <td><?php echo html_entity_decode($situation_f->obs); ?></td>
												 <td><?php echo html_entity_decode($situation_f->situation); ?></td>
                                              
                                               <td>
												<?php 
												if($situation_f->etat_operation =='En cours' or $situation_f->etat_operation =='Annulées'){
												?>
												  <a href="edit_sf.php?id=<?php echo $situation_f->id_situation_f;?>"><button class="btn btn-info btn-rounded " style = "text-align: right;"><span class="fa fa-pencil"></span></button><a>
											
												  <button class="btn btn-danger btn-rounded " onClick="delete_row('<?php echo $situation_f->id_situation_f;?>');"><span class="glyphicon glyphicon-trash"></span></button>
												<?php } else {?>
												
												
													<?php  }?>
													</td>
                                            </tr>
                                  <?php
}





}}

                                 ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>    </div> 
                                     								
                                </div>
                            </div>                                         
                            <!-- END JUSTIFIED TABS -->
                        </div>
                                   
                           
            <!-- END PAGE CONTENT -->
        </div>
								 
        <!-- MESSAGE BOX-->
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

