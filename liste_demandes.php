<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_psd' or 'Admin_psc');
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
$titre = "Liste utilisateur";
$active_menu = "index";
$header = array('operation');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_psd' or 'Admin_psc'  ){
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
                    <h2><span class="fa fa-arrow-circle-o-left"></span>Demandes de modification</h2>
					
                </div>
                <!-- END PAGE TITLE -->
                		<?php 
			$operations = Operation_modif::trouve_tous_modif();
			
		?>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                                
      
                
                    <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    <h3 class="panel-title"> Liste des demandes  </h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                           
                                    </ul>                                
                                </div>
                                <div class="panel-body">
                                    <div class="scrollable">
                                    <table  id="table0" class="table-bordered">
                                        <thead>
                                            <tr>
											    <th>Date de la demande</th>
											    <th>Ordonnateur</th>
											    <th>Date de décision </th>
											    <th>Numéro de decision </th>
											    <th>Ancien Numéro d'opération</th>
											    <th>Nouveau Numéro d'opération</th>
												<th>Ancien intitulé d'opération</th>
                                                <th>Nouveau intitulé opération</th>
												<th>Réévaluation  </th>
												<th>dévaluation  </th>
                                              	<th>User</th>
                                              	<th>Confirmation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
								foreach($operations as $operation){
									$ord=Ordonnateur::trouve_par_id($operation->id_ord);
									
									if($ord->id_prog==41 and ($user->type=="Admin_psc" or $user->type=="administrateur")){
										
									
								?>
                                             <tr  style=" font-weight:" id="<?php echo $operation->id_modif; ?>">
										 <td><span class=""><?php echo $operation->date_demande; ?></span></td>
										  <td><?php $ordonnateur = Ordonnateur:: trouve_par_id($operation-> id_ord); echo html_entity_decode($ordonnateur->nom_ord); ?></td>
											<td style="color:black;font-weight:bold" ><?php echo html_entity_decode($operation->date_modif); ?></td>
										<td style="color:black;font-weight:bold"><span class=""><?php echo html_entity_decode($operation->n_dec); ?></a></td>
										<td style="<?php if($operation->numero_op!="") { ?> color:red <?php } ?>"><span class=""><?php echo html_entity_decode($operation->a_numero_op); ?></a></td>
											<td style="color:green;font-weight:bold"><span class=""><?php echo html_entity_decode($operation->numero_op); ?></a></td>
											<td style="<?php if($operation->nom_oper!="") { ?> color:red <?php } ?>"><span class=""><?php  echo html_entity_decode($operation->a_nom_oper); ?></a></td>
											<td style="color:green;font-weight:bold"><span class=""><?php echo stripslashes($operation->nom_oper)."zzz"; ?></a></td>
											<td style="color:green;font-weight:bold"><span class=""><?php if($operation->reev>0) echo html_entity_decode(abs($operation->reev)); ?></a></td>
										   <td style="color:green;font-weight:bold"><span class=""><?php if($operation->reev<0) echo html_entity_decode(abs($operation->reev)); ?></a></td>
										   
									       
											<td><?php echo html_entity_decode($operation->user); ?></td>
										  <td>
										  <a href="confirme.php?id_modif=<?php echo $operation->id_modif;?>" ><button class="btn btn-info btn-rounded " style = "text-align: right;"><span>oui</span></button><a>
										 	  <a href="annule.php?id_modif=<?php echo $operation->id_modif;?>"><button class="btn btn-danger btn-rounded " style = "text-align: right;"><span>non</span></button><a>
              
										   
                                        </td>
                                    </tr>
                                   <?php
								}
								if($ord->id_prog==42 and ($user->type=="Admin_psd" or $user->type=="administrateur")){
										
									
								?>
                                             <tr  style=" font-weight:" id="<?php echo $operation->id_modif; ?>">
										
										
								  	<td><span class=""><?php echo $operation->date_demande; ?></span></td>
									        <td><?php $ordonnateur = Ordonnateur:: trouve_par_id($operation-> id_ord); echo html_entity_decode($ordonnateur->nom_ord); ?></td>
											<td style="color:black;font-weight:bold" ><?php echo html_entity_decode($operation->date_modif); ?></td>
										<td style="color:black;font-weight:bold"><span class=""><?php echo html_entity_decode($operation->n_dec); ?></a></td>
										<td style="<?php if($operation->numero_op!="") { ?> color:red <?php } ?>"><span class=""><?php echo html_entity_decode($operation->a_numero_op); ?></a></td>
											<td style="color:green;font-weight:bold"><span class=""><?php echo html_entity_decode($operation->numero_op); ?></a></td>
											<td style="<?php if($operation->nom_oper!="") { ?> color:red <?php } ?>"><span class=""><?php  echo html_entity_decode($operation->a_nom_oper); ?></a></td>
											<td style="color:green;font-weight:bold"><span class=""><?php echo stripslashes($operation->nom_oper); ?></a></td>
											<td style="color:green;font-weight:bold"><span class=""><?php if($operation->reev>0) echo html_entity_decode(abs($operation->reev)); ?></a></td>
										   <td style="color:green;font-weight:bold"><span class=""><?php if($operation->reev<0) echo html_entity_decode(abs($operation->reev)); ?></a></td>
										    
											<td><?php echo html_entity_decode($operation->user); ?></td>
										  <td>
										  <a href="confirme.php?id_modif=<?php echo $operation->id_modif;?>" ><button class="btn btn-info btn-rounded " style = "text-align: right;"><span>oui</span></button><a>
										 	  <a href="annule.php?id_modif=<?php echo $operation->id_modif;?>"><button class="btn btn-danger btn-rounded " style = "text-align: right;"><span>non</span></button><a>
              
										   
                                        </td>
                                    </tr>
                                   <?php
								}
								}
                                 ?>       </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
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
		<div class="message-box message-box-danger animated fadeIn" id="message-box-danger" data-sound="fail" >
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
      <script type="text/javascript">
        $('#table0').dataTable( 
{
    "columnDefs": [
 
        { "width": "100px", "targets": 11 },
        { "width": "130px", "targets": 0 },
         { "width": "70px", "targets": 2 },

       
       
    

    ],
    "searching": true,
    "paging":true,
    "ordering": false,
    "scrollX": "170%", 


} ); 
$(document).ready(function(){
    document.getElementById('table0').scrollIntoView({ inline:'end' });
});
         </script>
    <!-- END SCRIPTS -->                   
    </body>
</html>

