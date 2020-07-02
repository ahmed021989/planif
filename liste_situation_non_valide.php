<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est' or 'Admin_psd' or 'Admin_psc' );
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
$titre = "Situations financières en attente de validation";
$active_menu = "index";
$header = array('projet_supr');
if ($user->type =='administrateur' or 'dsp' or 'ehs'or 'chu'or 'est' or 'psd' or 'psc'  ){
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
                    <h2><span class="fa fa-arrow-circle-o-left"></span>Situations financières en attente de validation </h2>
					
                </div>
                <!-- END PAGE TITLE -->
                		<?php 
			$operation = Operation::trouve_tous_valider_ok($user->id_ord);
			
		?>
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                                
      
                
                    <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    <h3 class="panel-title"> Situations financières  </h3>
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                           
                                    </ul>                                
                                </div>
                                <div class="panel-body">
                                    <table  id="table0" class="table  table-bordered" >
                                        <thead>
                                            <tr>
										    <th>N°ordre</th>
											<th>Rubrique </th>
											<th style="width:172px">N°Opération </th>
											<th>Libellé d'opération </th>

											<th>Ap Actuelle </th>
											<th>Date de situation financière</th>
                                            <th>Ap engagée </th>
                                            <th>Paiements</th>
											<th>PEC</th>
											<th>Taux</th>	
											<th>Etat d'opération</th> 
											<th>Observation</th> 
											<th style="width:200px ">Validation</th>
											
                                            </tr>
                                  
                                     
										<?php
										$i=1;
								foreach($operation as $operation){
									
									if($situation_f=Situation_f::trouve_par_operation_tous_non_valide($operation->id_op)){
										if($situation_f->etat_operation!="Cloturee"){		
									
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
                                        
										<td><?php echo html_entity_decode($situation_f->ap_engag); ?></td>
										<td><?php echo html_entity_decode($situation_f->paiements); ?></td>
										<td><?php echo html_entity_decode($APacc-$situation_f->paiements); ?></td><!-- PEC-->
						
										<td><?php echo html_entity_decode (number_format($situation_f->paiements/$APacc*100,2,'.','').'%'); ?></td><!-- taux-->
										<td><?php 
										                    if($situation_f->etat_operation=="Gelee"){ echo html_entity_decode("Gelée");}
															if($situation_f->etat_operation=="En cours"){ echo html_entity_decode("En cours");}
															if($situation_f->etat_operation=="Achevee"){ echo html_entity_decode("Achevée");}
															if($situation_f->etat_operation=="Cloturee"){ echo html_entity_decode("Cloturée");}
                                      ?></td>
                                         <td><?php echo html_entity_decode($situation_f->obs); ?></td>
											
										
										  <td  style="background:#f1f5f9;" >
										  <button class="btn btn-success btn-rounded fa fa-ok-sign" onclick="valider_sf(<?php echo $situation_f->id_situation_f ;?> )" > Valider</button>
										   <button class="btn btn-danger btn-rounded fa fa-ok-sign" onclick="annuler_sf(<?php echo $situation_f->id_situation_f ;?> )" > Annuler</button>
										  
										  </td>
                                    </tr>
                                   <?php
								   $i++;
								}
									}
								}
                                 ?>           </thead>
								 <!--<tbody id="tbody"></tbody>	-->
                                    </table>
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
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>   
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
        <!-- END THIS PAGE PLUGINS -->       
        <!-- START TEMPLATE -->
		 <script type="text/javascript" src="js/dataTables.fixedColumns.min.js"></script> 
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>   


<script>
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
 // anuuler la situation_financiere //
 function annuler_sf(id){
	
	$.ajax({
				
	method:"post",
	url:"ajax_annuler_sf.php",
    data:{ id: id},
	success:function(resultData){
		alert(resultData);
	//$('#mb-change_date').hide(); 	
	window.location.reload();

}
})
	 
 }
 
  $('#table0').dataTable( 
{
  "columnDefs": [
      { "width": "172px", "targets": 11 },
	     { "width": "172px", "targets": 0 },  

    ],
    "searching": true,
   "paging":false,
    "ordering": false,
	"info": false,
	"scrollCollapse": true,
    "scrollX": "180%", 
    "fixedColumns":   {
            leftColumns: 1,
            rightColumns: 1,
        },
		

} ); 
$("tbody").hide();
</script>		
        <!-- END TEMPLATE -->    
    <!-- END SCRIPTS -->                   
    </body>
</html>

