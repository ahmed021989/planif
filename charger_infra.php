<?php
require_once("includes/initialiser.php");

global $bd;
$infra=Infrastructure::trouve_par_code($_GET['infra']);
echo "<center><h2>".$infra->nom_infra."</h2></center>";
?>

   <table class="table " id="table2">
                                        <thead>
                                            <tr>
											 <th>Gestionnaire</th>
                                              <th>Numéro d'opération</th>
                                              <th>Libellé d'opération </th>
											  <th>AP Actuelle</th>
											  <th>Etat d'opération</th>
											 
												
                                            </tr>
                                        </thead>
										 <tbody>
									<?php  
									
		$projets=Projet::trouve_tous_infra($infra->id_infra);
		foreach($projets as $projet){
			
									if($operations=Operation::trouve_tous_projet2($projet->id_projet)){
									foreach($operations as $operation){
									        if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
										        if($situation->etat_gelee!=-2){
													?>
													  <tr id ="<?php echo html_entity_decode($operation->id_op); ?>" style="background:
													   <?php if($operation->topographie=="PHP") { echo "#1caf9a";} 
                                                             if($operation->topographie=="PS") { echo "#FE9A2E";} 
													   ?>">
											<?php
											$ord=Ordonnateur::trouve_par_id($operation->id_ord);
											?>
                                                <td><?php echo html_entity_decode($ord-> nom_ord); ?></td>
											      <td><?php echo html_entity_decode($operation-> num_op); ?></td>
												   <td><?php echo html_entity_decode($operation-> libelle_op); ?></td>
												
													 <?php 
									// if($type_pro=Type_programme::trouve_par_code($operation->code_type_prog))
													 //echo html_entity_decode($type_pro->nom_type_prog); ?>
													 
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
									   <td style="font-weight:bold;text-align:right"><?php echo html_entity_decode(number_format($APacc,2)); ?></td> <!-- APACtuel-->
									   <td><?php     if($situation_f->etat_operation=="Gelee"){ echo html_entity_decode("Gelée");}
															  if($situation_f->etat_operation=="En cours"){ echo html_entity_decode("En cours");}
															   if($situation_f->etat_operation=="Acheve"){ echo html_entity_decode("Achevée");}
															    if($situation_f->etat_operation=="Cloturee"){ echo html_entity_decode("Cloturée");} ?></td>
									   </tr>
												 
												 <?php
													 }
												}
										      }		
else{
//operation sans situations
								?>
													   <tr id ="<?php echo html_entity_decode($operation->id_op); ?>" style="background:
													   <?php if($operation->topographie=="PHP") { echo "#1caf9a";} 
                                                             if($operation->topographie=="PS") { echo "#FE9A2E";} 
													   ?>">
											<?php
											
											?>
                                                
											      <td><?php echo html_entity_decode($operation-> num_op); ?></td>
												   <td><?php echo html_entity_decode($operation-> libelle_op); ?></td>
												    <td><?php
													$rub=Rubrique::trouve_par_code($operation-> code_rubrique);
													echo html_entity_decode($rub-> nom_rubrique); ?>
													</td>
												
													
													 
													  <?php 
										
									  $APacc=0;
									  //$operation=Operation::trouve_par_id($situation_f->id_op);
									  $APacc=$APacc+$operation->ap_initial;
									   $operation_modifs=Operation_modif::trouve_tous_reev($operation->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									  ?>
									   <td style="font-weight:bold;text-align:right"><?php echo html_entity_decode(number_format($APacc,2)); ?></td> <!-- APACtuel-->
									   <td><?php echo "En cours" ?></td>
									  
									   </tr>
												 
												 <?php
													
											

}	
									}
									}
		}
									?>
                                        </tbody>
                                    </table>
						<?php echo "<script>$('#charge').hide();</script>";  ?>				
<script>			              
$('#table2').dataTable( 
{
    "searching": true,
	"paging":true,
	"ordering": false,
} ); 
</script>