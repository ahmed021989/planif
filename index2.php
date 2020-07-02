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
$titre = "Accueil";
$active_menu = "index";
$header = array('employer');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_psc' or 'Admin_psd' or 'Admin_ehs' or 'Admin_chu' or 'Admin_est'){
	require_once("composit/header.php");
}

?>

 <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>                    
                    <li class="active">Tableau de bord > Statistique</li>
                </ul>
                <!-- END BREADCRUMB -->                       
             <?php if  ($user->type == 'administrateur' or $user->type == 'Admin_psc' or $user->type=="Admin_psd" or $user->type=="Admin_dsp" or $user->type=="Admin_ehs" or $user->type=="Admin_chu" or $user->type=="Admin_est")   {  ?>   
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                      <!-- START WIDGETS -->   
<?php if($user->type=="administrateur"){
?>	
                    <div class="row">
					
					 <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                              

  <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#037BA4;">
                                <div class="widget-item-left">
                                   <span class="fa fa-user"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong>
									<?php   
									$sql=$bd->requete('select * from personne');
									$nb=mysqli_num_rows($sql);
									echo $nb;
									?>
									</strong></div>
                                    <div class="widget-title">Utilisateurs</div>
                                   
                                </div>      
                            </div>  							
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
					
					
					
                        <div class="col-md-3">
                            
                            <!-- START WIDGET SLIDER -->
                          <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#B70309;">
                                <div class="widget-item-left" >
                                    <span class="fa fa-building-o"></span>

                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong>
									
									</strong></div>
                                    <div class="widget-title" > Structures </div>
                                    
                                </div>      
                               
                            </div>    
                            <!-- END WIDGET SLIDER -->
                            
                        </div>
                        <div class="col-md-3">

                            
                            <!-- START WIDGET MESSAGES -->
                        

                        <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#229954;" >
                                <div class="widget-item-left">
								<span class="fa fa-folder-open"></span> </div>

                                <div class="widget-data">
                                         <div class="widget-int num-count"><strong>
										 
										 
										 </strong></div>
                                    <div class="widget-title">opération</div>
                                   
                                </div>                         
                            </div>  


						
                            <!-- END WIDGET MESSAGES -->
                            
                        </div>
                       
                       <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                              <div class="widget  widget-item-icon"  style="background:#840344;" onmouseover="this.style.background='none'; Toolkit.getDefaultToolkit().beep();" onmouseout="this.style.background='#840344';">
							   <div class="widget-item-left">
                                  <span class="fa fa-tachometer"></span> 
								  </div>
								   <div class="widget-data">
                                <div class="widget-big-int plugin-clock">00:00</div>
								<div class="widget-title"></div>
                                 <div class="widget-title"></div>
								 
								
								</div>  </div>                             
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
                    </div>
					
			 <?php } ?>
					
					
					
					
					
					 <div class="col-md-3">

                             <div class="widget  btn-block widget-item-icon" style="background:#886A08;" onclick="location.href='#';" >
                                <div class="widget-item-left">
                                    <span class="fa fa-refresh"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">
								   <?php 
								 $operations=Operation::trouve_tous();
								 $i=0;
						foreach($operations as $operation){
	
								if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
								$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
				
								if($situation_f->etat_operation=='En cours' and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){
								++$i;
								}
								else{
								if($situation_f->etat_operation=='En cours' and($user->type=='Admin_psc' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==41){
								++$i;
								}
								}
								}
			
						}
									echo $i;
								   
								   ?>
								   </div>
                                    <div class="widget-title" style="font-size:12px">Opérations</br> en cours</div>
                                 
                                </div>
                                                       
                            </div>

                        </div>
						
						
						
                         <div class="col-md-3">

                           <div class="widget btn btn-warning btn-block widget-item-icon"  style="background:#B4045F;;border:none" onclick="location.href='#';" >
                                 <div class="widget-item-left">
                                <span class="fa fa-exclamation-circle"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">	<?php	  $operations=Operation::trouve_tous();
								 $i=0;
						foreach($operations as $operation){
	
								if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
								$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
				
								if($situation_f->etat_operation=='Gelee' and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){
								++$i;
								}
								else{
								if($situation_f->etat_operation=='Gelee' and($user->type=='Admin_psc' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==41){
								++$i;
								}
								}
								}
			
						}
									echo $i;
								    ?>
									</div>
                                    <div class="widget-title"style="font-size:12px">Operations</br> Gelee</div>
                                    
                                </div>
                                                        
                            </div>

                        </div>             

                      
                
						
						
						
						
						  <div class="col-md-3">

                             <div class="widget widget-primary widget-item-icon" style="background:#FE9A2E;" onmouseover="this.style.background='none" onclick="location.href='#';">
                                <div class="widget-item-left">
                               
                                <span class="fa fa-times-circle"></span>
                                </div>
                               <div class="widget-data">
                                   <div class="widget-int num-count">
								     <?php 
								 $operations=Operation::trouve_tous();
								 $i=0;
						foreach($operations as $operation){
	
								if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
								$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
				
								if($situation_f->etat_operation=='Annulées' and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){
								++$i;
								}
								else{
								if($situation_f->etat_operation=='Annulées' and($user->type=='Admin_psc' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==41){
								++$i;
								}
								}
								}
			
						}
									echo $i;
								   
								   ?>
								   </div>
                                    <div class="widget-title" style="font-size:12px">Opérations</br> annuler</div>
                                  
                                </div>
                                             
                                                       
                            </div>

                        </div>
				
				
				   
				
						
						
						
						 <div class="col-md-3">

                            <div class="widget widget-danger widget-padding-sm widget-item-icon" style="background:#5207CA;"  onclick="location.href='#';" >
                                <div class="widget-item-left">
                               <span class="fa fa-archive"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">
								    <?php 
								 $operations=Operation::trouve_tous();
								 $i=0;
						foreach($operations as $operation){
	
								if($situation_f = Situation_f::trouve_par_operation2($operation->id_op)){
								$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
				
								if($situation_f->etat_operation=='Cloturées' and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==42){
								++$i;
								}
								else{
								if($situation_f->etat_operation=='Cloturées' and($user->type=='Admin_psc' or $user->type=='administrateur' or $user->id_ord==$operation->id_ord) and $ordonnateur->id_prog==41){
								++$i;
								}
								}
								}
			
						}
									echo $i;
								   
								   ?>
								   </div>
                                  
                                    <div class="widget-title" style="font-size:12px">Operations<br> Cloturées</div>
                                </div>
                                                        
                            </div>

                        </div>
					
					

                    <!-- END WIDGETS -->                    

						
               <div class="page-content-wrap">                
                
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-default">
                                <div class="panel-heading">                                
                                    
									
							
                                    <ul class="panel-controls">

                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                    
										
                                    </ul>                                
                                </div>
                                <div class="panel-body">
								
								<?php 
							
								if($user->type=="administrateur" or $user->type=="Admin_psd"  ){
								
								?>
								 <h3 class="panel-title"><strong>RECAPITULATIF PSD</strong></h3>
								   <div class="panel-heading">
                                  
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> Export </button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="#" onClick ="$('#tablePSD').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#tablePSD').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                           </ul>
                                    </div>                                    
                                    
                                </div>
                                    <table id="tablePSD" class="table  table-striped">
                                        <thead>
                                            <tr>
                                         
                                                <th>nom_rubrique  </th>
                                                <th>nombre </th>
												<th>ap_initial </th>
													<th>ap actual</th>
													<th>%</th>
														<th>paiement</th>
														<th>PEC</th>
														<th>TAUX</th>
											

											
                                                
                                            </tr>
                                        </thead>
										 <tbody>
										 	 <?php 
											 
											
											 
											 
											 //calculer TOTAL ap_actual_tous les rubriques
											 $total_ap_actual=0;
                                    $rubriques =Rubrique::trouve_tous_psd();										 
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
										
											$ap_inital=0;
												
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
										
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='DSP'){
											
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
										
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
										}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										$total_ap_actual+=$ap_actual_rubrique;
										?>
										
										<?php } //fin foreach rubrque
										// fin calcule TOTAL ap_actual*************************
										 ?>
										 
										 
										 <?php 
										 $T_nombre=0;
										$T_ap_initial=0;
										$T_ap_actual_rubrique=0;
										$T_T0=0;
										$T_paiments=0;
										$T_PEC=0;
										$T_Taux=0;
                                    $rubriques =Rubrique::trouve_tous_psd();	
										$i=1;									
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
											$nombre=0;
											$ap_inital=0;
												$paiments=0;
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
												if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='DSP'){
											$nombre+=1;
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
											$paiments+=$situation->paiements;
										}
										
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
												}
												}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										if($total_ap_actual!=0){$T0=($ap_actual_rubrique/$total_ap_actual)*100;} else $T0=0.00;
										$T_nombre+=$nombre;
										$T_ap_initial+=$ap_inital;
										$T_ap_actual_rubrique+=$ap_actual_rubrique;
										$T_T0+=$T0;
										$T_paiments+=$paiments;
										$T_PEC+=($ap_actual_rubrique-$paiments);
										
										
										?>
										<tr>
										<td id='<?php echo "Rpsd".$i; ?>'><?php  echo $rubrique->nom_rubrique;  ?></td>
										<td><?php  echo $nombre;  ?></td>
										<td><?php  echo $ap_inital;  ?></td>
										<td><?php  echo $ap_actual_rubrique ; ?></td>
										<td  id='<?php echo "Tpsd".$i; ?>'><?php  echo number_format($T0,2,',','') ; ?></td>
										<td><?php  echo $paiments ;?></td>
										<td><?php  echo $ap_actual_rubrique-$paiments ;?></td>
										<td id='<?php echo "Tpsd2".$i; ?>'><?php if($ap_actual_rubrique!=0){  echo number_format(($paiments/$ap_actual_rubrique)*100,2,',','') ;}else echo '0,00';?></td>
										</tr>
										<?php ++$i;} //fin foreach rubrque
										?>
							           <tr style="font-weight:bold;">
									      <td>TOTAL</td>
									   <td><?php echo $T_nombre; ?></td>
									   <td><?php echo $T_ap_initial; ?></td>
									   <td><?php echo $T_ap_actual_rubrique; ?></td>
									   <td><?php echo number_format($T_T0,2,',',''); ?></td>
									   <td><?php echo $T_paiments; ?></td>
									   <td><?php echo $T_PEC; ?></td>
									    <td><?php if($T_ap_actual_rubrique){echo number_format(($T_paiments/$T_ap_actual_rubrique)*100,2,',','');} else echo 0,00; ?></td>
									   </tr>
                                        </tbody>
                                    </table>
									
									
									<div class='row'>
								  <div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Taux des projets par rubriques PSD</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-PSD" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
								<div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                              <h3 class="panel-title">Taux d'exécution financière PSD</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-PSD2" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
						    </div>
									
									
									
									<?php
									}//fin if type ordonnateur administrateur et PSD
								?>
                                </div>
								
								<!--******************************-->
								<!--******************************-->
								<!--******************************-->
								
						<!--******************************-->
								<!--******************************-->
								
								
								
								
								
								
								
								<div class="panel-body">
								
								<?php 
							if($user->type=="administrateur" or $user->type=="Admin_psc" ){
								
								?>
								 <h3 class="panel-title"><strong>RECAPITULATIF PSC</strong></h3>
								 <div class="panel-heading">
                                  
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> Export </button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="#" onClick ="$('#tablePSC').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#tablePSC').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                           </ul>
                                    </div>                                    
                                    
                                </div>
                                    <table id="tablePSC" class="table  table-striped">
                                        <thead>
                                            <tr>
                                         
                                                <th>nom_rubrique  </th>
                                                <th>nombre </th>
												<th>ap_initial </th>
													<th>ap actual</th>
													<th>%</th>
														<th>paiement</th>
														<th>PEC</th>
														<th>TAUX</th>
											

											
                                                
                                            </tr>
                                        </thead>
										 <tbody>
										 	 <?php 
											 
											
											 
											 
											 //calculer TOTAL ap_actual_tous les rubriques
											 $total_ap_actual=0;
											
                                    $rubriques =Rubrique::trouve_tous();										 
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
										
											$ap_inital=0;
												
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord!='DSP'){
											
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
										}
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										$total_ap_actual+=$ap_actual_rubrique;
										?>
										
										<?php } //fin foreach rubrque
										// fin calcule TOTAL ap_actual*************************
										 ?>
										 
										 
										 <?php 
										  $T_nombre=0;
										$T_ap_initial=0;
										$T_ap_actual_rubrique=0;
										$T_T0=0;
										$T_paiments=0;
										$T_PEC=0;
										$T_Taux=0;
										 $j=1; 
                                    $rubriques =Rubrique::trouve_tous();										 
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
											$nombre=0;
											$ap_inital=0;
												$paiments=0;
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord!='DSP'){
											$nombre+=1;
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
											$paiments+=$situation->paiements;
										}
										
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										if($total_ap_actual!=0){$T0=($ap_actual_rubrique/$total_ap_actual)*100;} else  $T0=0.00;
										$T_nombre+=$nombre;
										$T_ap_initial+=$ap_inital;
										$T_ap_actual_rubrique+=$ap_actual_rubrique;
										$T_T0+=$T0;
										$T_paiments+=$paiments;
										$T_PEC+=($ap_actual_rubrique-$paiments);
										if($ap_actual_rubrique!=0){$T_Taux+=($paiments/$ap_actual_rubrique)*100;} else $T_Taux=$T_Taux;
									
										?>
										<tr>
										<td id='<?php echo "Rpsc".$j; ?>'><?php  echo $rubrique->nom_rubrique;  ?></td>
										<td><?php  echo $nombre;  ?></td>
										<td><?php  echo $ap_inital;  ?></td>
										<td><?php  echo $ap_actual_rubrique ; ?></td>
										<td id='<?php echo "Tpsc".$j; ?>'><?php  echo number_format($T0,2,',','') ; ?></td>
										<td><?php  echo $paiments ;?></td>
										<td><?php  echo $ap_actual_rubrique-$paiments ;?></td>
										<td id='<?php echo "Tpsc2".$j; ?>'><?php if($ap_actual_rubrique!=0){  echo number_format(($paiments/$ap_actual_rubrique)*100,2,',','') ;}else echo '0,00';?></td>
										</tr>
										<?php ++$j;}//fin foreach rubrque
							
										?>
							   <tr style="font-weight:bold;">
									      <td>TOTAL</td>
									   <td><?php echo $T_nombre; ?></td>
									   <td><?php echo $T_ap_initial; ?></td>
									   <td><?php echo $T_ap_actual_rubrique; ?></td>
									   <td><?php echo number_format($T_T0,2,',',''); ?></td>
									   <td><?php echo $T_paiments; ?></td>
									   <td><?php echo $T_PEC; ?></td>
									    <td><?php if($T_ap_actual_rubrique){echo number_format(($T_paiments/$T_ap_actual_rubrique)*100,2,',','');}else echo 0,00; ?></td>
									   </tr>
                                        </tbody>
                                    </table>
									
									<div class='row'>
								  <div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Taux des projets par rubriques PSC</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-PSC" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
								<div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                              <h3 class="panel-title">Taux d'exécution financière PSC</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-PSC2" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
						    </div>
									<?php
									}//fin if type ordonnateur administrateur et PSD
								?>
                                </div>
								
								
								<!--**************************-->
								<!--*************************-->
								<!--******************************-->
								<!--******************************-->
								<!--******************************-->
								
								
								<div class="panel-body">
								
								<?php 
							if($user->type=="administrateur" or  $user->type=="Admin_psc"){
								
								?>
								 <h3 class="panel-title"><strong>RECAP CHU</strong></h3>
								 <div class="panel-heading">
                                  
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> Export </button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="#" onClick ="$('#tableCHU').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#tableCHU').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                           </ul>
                                    </div>                                    
                                    
                                </div>
                                    <table id="tableCHU" class="table  table-striped">
                                        <thead>
                                            <tr>
                                         
                                                <th>nom_rubrique  </th>
                                                <th>nombre </th>
												<th>ap_initial </th>
													<th>ap actual</th>
													<th>%</th>
														<th>paiement</th>
														<th>PEC</th>
														<th>TAUX</th>
											

											
                                                
                                            </tr>
                                        </thead>
										 <tbody>
										 	 <?php 
											 
											
											 
											 
											 //calculer TOTAL ap_actual_tous les rubriques
											 $total_ap_actual=0;
                                    $rubriques =Rubrique::trouve_tous_psd();										 
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
										
											$ap_inital=0;
												
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='CHU'){
											
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
										}
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										$total_ap_actual+=$ap_actual_rubrique;
										?>
										
										<?php } //fin foreach rubrque
										// fin calcule TOTAL ap_actual*************************
										 ?>
										 
										 
										 <?php 
										 
										  $T_nombre=0;
										$T_ap_initial=0;
										$T_ap_actual_rubrique=0;
										$T_T0=0;
										$T_paiments=0;
										$T_PEC=0;
										$T_Taux=0;
                                    $rubriques =Rubrique::trouve_tous_psd();
										$i=1;									
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
											$nombre=0;
											$ap_inital=0;
												$paiments=0;
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='CHU'){
											$nombre+=1;
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
											$paiments+=$situation->paiements;
										}
										
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										if($total_ap_actual!=0){$T0=($ap_actual_rubrique/$total_ap_actual)*100;} else $T0=0.00;
											$T_nombre+=$nombre;
										$T_ap_initial+=$ap_inital;
										$T_ap_actual_rubrique+=$ap_actual_rubrique;
										$T_T0+=$T0;
										$T_paiments+=$paiments;
										$T_PEC+=($ap_actual_rubrique-$paiments);
										
									
										?>
										<tr>
										<td id='<?php echo "Rchu".$i; ?>'><?php  echo $rubrique->nom_rubrique;  ?></td>
										<td><?php  echo $nombre;  ?></td>
										<td><?php  echo $ap_inital;  ?></td>
										<td><?php  echo $ap_actual_rubrique ; ?></td>
										<td id='<?php echo "Tchu".$i; ?>'><?php  echo number_format($T0,2,',','') ; ?></td>
										<td><?php  echo $paiments ;?></td>
										<td><?php  echo $ap_actual_rubrique-$paiments ;?></td>
										<td id='<?php echo "Tchu2".$i; ?>'><?php if($ap_actual_rubrique!=0){  echo number_format(($paiments/$ap_actual_rubrique)*100,2,',','') ;}else echo '0,00';?></td>
										</tr>
										<?php ++$i;
										
										}//fin foreach rubrque
							
										?>
							  <tr style="font-weight:bold;">
									      <td>TOTAL</td>
									   <td><?php echo $T_nombre; ?></td>
									   <td><?php echo $T_ap_initial; ?></td>
									   <td><?php echo $T_ap_actual_rubrique; ?></td>
									   <td><?php echo number_format($T_T0,2,',',''); ?></td>
									   <td><?php echo $T_paiments; ?></td>
									   <td><?php echo $T_PEC; ?></td>
									    <td><?php if($T_ap_actual_rubrique){echo number_format(($T_paiments/$T_ap_actual_rubrique)*100,2,',','');} else echo 0,0; ?></td>
									   </tr>
                                        </tbody>
                                    </table>
									
										<div class='row'>
								  <div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Taux des projets par rubriques CHU</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-CHU" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
								<div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                              <h3 class="panel-title">Taux d'exécution financière CHU</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-CHU2" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
						    </div>
									<?php
									}//fin if type ordonnateur administrateur et PSD
								?>
                                </div>
								<!--******************************-->
								<!--******************************-->
								<!--******************************-->
								
								
								<div class="panel-body">
								
								<?php 
							if($user->type=="administrateur" or $user->type=="Admin_psc" ){
								
								?>
								 <h3 class="panel-title"><strong>RECAP EHS</strong></h3>
								 <div class="panel-heading">
                                  
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> Export </button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="#" onClick ="$('#tableEHS').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#tableEHS').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                           </ul>
                                    </div>                                    
                                    
                                </div>
                                    <table id="tableEHS" class="table  table-striped">
                                        <thead>
                                            <tr>
                                         
                                                <th>nom_rubrique  </th>
                                                <th>nombre </th>
												<th>ap_initial </th>
													<th>ap actual</th>
													<th>%</th>
														<th>paiement</th>
														<th>PEC</th>
														<th>TAUX</th>
											

											
                                                
                                            </tr>
                                        </thead>
										 <tbody>
										 	 <?php 
											 
											
											 
											 
											 //calculer TOTAL ap_actual_tous les rubriques
											 $total_ap_actual=0;
                                    $rubriques =Rubrique::trouve_tous_psd();										 
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
										
											$ap_inital=0;
												
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='EHS'){
											
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
										}
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										$total_ap_actual+=$ap_actual_rubrique;
										?>
										
										<?php } //fin foreach rubrque
										// fin calcule TOTAL ap_actual*************************
										 ?>
										 
										 
										 <?php 
										 
										  $T_nombre=0;
										$T_ap_initial=0;
										$T_ap_actual_rubrique=0;
										$T_T0=0;
										$T_paiments=0;
										$T_PEC=0;
										$T_Taux=0;
                                    $rubriques =Rubrique::trouve_tous_psd();	
                                        $i=1;									
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
											$nombre=0;
											$ap_inital=0;
												$paiments=0;
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='EHS'){
											$nombre+=1;
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
											$paiments+=$situation->paiements;
										}
										
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										if($total_ap_actual!=0){$T0=($ap_actual_rubrique/$total_ap_actual)*100;}else $T0='0.00';
											$T_nombre+=$nombre;
										$T_ap_initial+=$ap_inital;
										$T_ap_actual_rubrique+=$ap_actual_rubrique;
										$T_T0+=$T0;
										$T_paiments+=$paiments;
										$T_PEC+=($ap_actual_rubrique-$paiments);
										if($ap_actual_rubrique!=0){$T_Taux+=$paiments/$ap_actual_rubrique;} else $T_Taux=$T_Taux;
									
										?>
										<tr>
										<td id='<?php echo "Rehs".$i; ?>'><?php  echo $rubrique->nom_rubrique;  ?></td>
										<td><?php  echo $nombre;  ?></td>
										<td><?php  echo $ap_inital;  ?></td>
										<td><?php  echo $ap_actual_rubrique ; ?></td>
										<td id='<?php echo "Tehs".$i; ?>'><?php  echo number_format($T0,2,',','') ; ?></td>
										<td><?php  echo $paiments ;?></td>
										<td><?php  echo $ap_actual_rubrique-$paiments ;?></td>
										<td id='<?php echo "Tehs2".$i; ?>'><?php if($ap_actual_rubrique!=0){  echo number_format(($paiments/$ap_actual_rubrique)*100,2,',','') ;}else echo '0,00';?></td>
										</tr>
										<?php ++$i; }//fin foreach rubrque
							
										?>
							   <tr style="font-weight:bold;">
									      <td>TOTAL</td>
									   <td><?php echo $T_nombre; ?></td>
									   <td><?php echo $T_ap_initial; ?></td>
									   <td><?php echo $T_ap_actual_rubrique; ?></td>
									   <td><?php echo number_format($T_T0,2,',',''); ?></td>
									   <td><?php echo $T_paiments; ?></td>
									   <td><?php echo $T_PEC; ?></td>
									    <td><?php if($T_ap_actual_rubrique){echo number_format(($T_paiments/$T_ap_actual_rubrique)*100,2,',','');} else echo 0,00; ?></td>
									   </tr>
                                        </tbody>
                                    </table>
										<div class='row'>
								  <div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Taux des projets par rubriques EHS</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-EHS" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
								<div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                              <h3 class="panel-title">Taux d'exécution financière EHS2</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-EHS2" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
						    </div>
									
									<?php
									}//fin if type ordonnateur administrateur et PSD
								?>
                                </div>
								
								<!--******************************-->
								<!--******************************-->
								<!--******************************-->
								
								
								<div class="panel-body">
								
								<?php 
							if($user->type=="administrateur"  or $user->type=="Admin_psc"  ){
								
								?>
								 <h3 class="panel-title"><strong>RECAP EST</strong></h3>
								 <div class="panel-heading">
                                  
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> Export </button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="#" onClick ="$('#tableEST').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#tableEST').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                           </ul>
                                    </div>                                    
                                    
                                </div>
                                    <table id="tableEST" class="table  table-striped">
                                        <thead>
                                            <tr>
                                         
                                                <th>nom_rubrique  </th>
                                                <th>nombre </th>
												<th>ap_initial </th>
													<th>ap actual</th>
													<th>%</th>
														<th>paiement</th>
														<th>PEC</th>
														<th>TAUX</th>
											

											
                                                
                                            </tr>
                                        </thead>
										 <tbody>
										 	 <?php 
											 
											
											 
											 
											 //calculer TOTAL ap_actual_tous les rubriques
											 $total_ap_actual=0;
                                    $rubriques =Rubrique::trouve_tous_psd();										 
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
										
											$ap_inital=0;
												
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='EST'){
											
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
											//	echo "<script>alert(".$ap_inital.")</script>";
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
										}
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										$total_ap_actual+=$ap_actual_rubrique;
								
										?>
										
										<?php } //fin foreach rubrque
										// fin calcule TOTAL ap_actual*************************
										 ?>
										 
										 
										 <?php 
										  $T_nombre=0;
										$T_ap_initial=0;
										$T_ap_actual_rubrique=0;
										$T_T0=0;
										$T_paiments=0;
										$T_PEC=0;
										$T_Taux=0;
                                    $rubriques =Rubrique::trouve_tous_psd();	
										$i=1;
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
											$nombre=0;
											$ap_inital=0;
												$paiments=0;
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='EST'){
											$nombre+=1;
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
											$paiments+=$situation->paiements;
										}
										
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										if($total_ap_actual!=0){$T0=($ap_actual_rubrique/$total_ap_actual)*100;}else $T0='0.00';
										
											$T_nombre+=$nombre;
										$T_ap_initial+=$ap_inital;
										$T_ap_actual_rubrique+=$ap_actual_rubrique;
										$T_T0+=$T0;
										$T_paiments+=$paiments;
										$T_PEC+=($ap_actual_rubrique-$paiments);
										if($ap_actual_rubrique!=0){$T_Taux+=$paiments/$ap_actual_rubrique;} else $T_Taux=$T_Taux;
									
										?>
										<tr>
										<td id='<?php echo "Rest".$i; ?>'><?php  echo $rubrique->nom_rubrique;  ?></td>
										<td><?php  echo $nombre;  ?></td>
										<td><?php  echo $ap_inital;  ?></td>
										<td><?php  echo $ap_actual_rubrique ; ?></td>
										<td id='<?php echo "Test".$i; ?>'><?php  echo number_format($T0,2,',','') ; ?></td>
										<td><?php  echo $paiments ;?></td>
										<td><?php  echo $ap_actual_rubrique-$paiments ;?></td>
										<td id='<?php echo "Test2".$i; ?>'><?php if($ap_actual_rubrique!=0){  echo number_format(($paiments/$ap_actual_rubrique)*100,2,',','') ;}else echo '0,00';?></td>
										</tr>
										<?php ++$i; }//fin foreach rubrque
							
										?>
							    <tr style="font-weight:bold;">
									      <td>TOTAL</td>
									   <td><?php echo $T_nombre; ?></td>
									   <td><?php echo $T_ap_initial; ?></td>
									   <td><?php echo $T_ap_actual_rubrique; ?></td>
									   <td><?php echo number_format($T_T0,2,',',''); ?></td>
									   <td><?php echo $T_paiments; ?></td>
									   <td><?php echo $T_PEC; ?></td>
									    <td><?php if($T_ap_actual_rubrique){echo number_format(($T_paiments/$T_ap_actual_rubrique)*100,2,',','');}else echo 0,00; ?></td>
									   </tr>
                                        </tbody>
                                    </table>
											<div class='row'>
								  <div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Taux des projets par rubriques EST</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-EST" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
								<div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                              <h3 class="panel-title">Taux d'exécution financière EST</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-EST2" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
						    </div>
									<?php
									}//fin if type ordonnateur administrateur et PSD
								?>
                                </div>
								<!--**********************-->
								<!--**********************-->
										
								<!--******************************-->
								<!--******************************-->
								<!--******************************-->
								
						<!--******************************-->
								<!--******************************-->
								
								
								
								
								
								
								
								<div class="panel-body">
								
								<?php 
							if($user->type=="administrateur" or $user->type=="Admin_psc" ){
								
								?>
								 <h3 class="panel-title"><strong>RECAPITULATIF MSPRH</strong></h3>
								 <div class="panel-heading">
                                  
                                    <div class="btn-group pull-right">
                                        <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown"><i class="fa fa-download"></i> Export </button>
                                        <ul class="dropdown-menu">
                                           
                                            <li><a href="#" onClick ="$('#tableMSPRH').tableExport({type:'excel',escape:'false'});"><img src='img/icons/xls.png' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#tableMSPRH').tableExport({type:'doc',escape:'false'});"><img src='img/icons/word.png' width="24"/> Word</a></li>
                                           </ul>
                                    </div>                                    
                                    
                                </div>
                                    <table id="tableMSPRH" class="table  table-striped">
                                        <thead>
                                            <tr>
                                         
                                                <th>nom_rubrique  </th>
                                                <th>nombre </th>
												<th>ap_initial </th>
													<th>ap actual</th>
													<th>%</th>
														<th>paiement</th>
														<th>PEC</th>
														<th>TAUX</th>
											

											
                                                
                                            </tr>
                                        </thead>
										 <tbody>
										 	 <?php 
											 
											
											 
											 
											 //calculer TOTAL ap_actual_tous les rubriques
											 $total_ap_actual=0;
											
                                    $rubriques =Rubrique::trouve_tous();										 
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
										
											$ap_inital=0;
												
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='msprh'){
											
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
										}
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										$total_ap_actual+=$ap_actual_rubrique;
										?>
										
										<?php } //fin foreach rubrque
										// fin calcule TOTAL ap_actual*************************
										 ?>
										 
										 
										 <?php 
										  $T_nombre=0;
										$T_ap_initial=0;
										$T_ap_actual_rubrique=0;
										$T_T0=0;
										$T_paiments=0;
										$T_PEC=0;
										$T_Taux=0;
										 $j=1; 
                                    $rubriques =Rubrique::trouve_tous();										 
										foreach($rubriques as $rubrique){
											$ap_actual_rubrique=0;
											$nombre=0;
											$ap_inital=0;
												$paiments=0;
										$operations=Operation::trouve_tous_rubrique($rubrique->code_rubrique);	
										$ap_actual=0;
										foreach($operations as $operation){
											if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
												if($situation->etat_gelee!=-2){
											$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);
										if($ordonnateur->type_ord=='msprh'){
											$nombre+=1;
											$ap_inital=$ap_inital+$operation->ap_initial;
											$ap_actual=$ap_actual+$operation->ap_initial;
										
											$reev=0;
												
										$operation_modif=Operation_modif::trouve_tous_reev($operation->id_op);
										     foreach($operation_modif as $operation_modif){
												 $reev=$reev+$operation_modif->reev;
											 }//fin foreach operation_midf
											 
										if($situation=Situation_f::trouve_par_operation2($operation->id_op)){
											$paiments+=$situation->paiements;
										}
										
											$ap_actual=$ap_actual+$reev;
											
										}//fin foreach operation
										}
											}
										}
										$ap_actual_rubrique+=$ap_actual;//actual tous les operation dans rubrique
										if($total_ap_actual!=0){$T0=($ap_actual_rubrique/$total_ap_actual)*100;} else  $T0=0.00;
										$T_nombre+=$nombre;
										$T_ap_initial+=$ap_inital;
										$T_ap_actual_rubrique+=$ap_actual_rubrique;
										$T_T0+=$T0;
										$T_paiments+=$paiments;
										$T_PEC+=($ap_actual_rubrique-$paiments);
										if($ap_actual_rubrique!=0){$T_Taux+=($paiments/$ap_actual_rubrique)*100;} else $T_Taux=$T_Taux;
									
										?>
										<tr>
										<td id='<?php echo "Rmsprh".$j; ?>'><?php  echo $rubrique->nom_rubrique;  ?></td>
										<td><?php  echo $nombre;  ?></td>
										<td><?php  echo $ap_inital;  ?></td>
										<td><?php  echo $ap_actual_rubrique ; ?></td>
										<td id='<?php echo "Tmsprh".$j; ?>'><?php  echo number_format($T0,2,',','') ; ?></td>
										<td><?php  echo $paiments ;?></td>
										<td><?php  echo $ap_actual_rubrique-$paiments ;?></td>
										<td id='<?php echo "Tmsprh2".$j; ?>'><?php if($ap_actual_rubrique!=0){  echo number_format(($paiments/$ap_actual_rubrique)*100,2,',','') ;}else echo '0,00';?></td>
										</tr>
										<?php ++$j;}//fin foreach rubrque
							
										?>
							   <tr style="font-weight:bold;">
									      <td>TOTAL</td>
									   <td><?php echo $T_nombre; ?></td>
									   <td><?php echo $T_ap_initial; ?></td>
									   <td><?php echo $T_ap_actual_rubrique; ?></td>
									   <td><?php echo number_format($T_T0,2,',',''); ?></td>
									   <td><?php echo $T_paiments; ?></td>
									   <td><?php echo $T_PEC; ?></td>
									    <td><?php if($T_ap_actual_rubrique){echo number_format(($T_paiments/$T_ap_actual_rubrique)*100,2,',','');}else echo 0,00; ?></td>
									   </tr>
                                        </tbody>
                                    </table>
									
									<div class='row'>
								  <div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Taux des projets par rubriques MSPRH</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-MSPRH" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
								<div class="col-md-6">

                            <!-- START REGULAR PIE CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                              <h3 class="panel-title">Taux d'exécution financière MSPRH</h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-MSPRH2" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
						    </div>
									<?php
									}//fin if type ordonnateur administrateur et PSC
								?>
                                </div>
								
								
								<!--**************************-->
								<!--*************************-->
								<!--******************************-->
								<!--******************************-->
								<!--******************************-->
								
                            </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
                </div>
				  
				  
                    				  
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
            <!-- END PAGE CONTENT -->
                <!-- END PAGE CONTENT WRAPPER -->                                                
          
	<?php }



		   ?>
		       
				                
                    
         				
         
                <!-- END PAGE CONTENT WRAPPER -->    
                  



		
         
     	
		       

                    
                    <!-- START DASHBOARD CHART -->
					<div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div>
					<div class="block-full-width">
                                                                       
                    </div>                    
                    <!-- END DASHBOARD CHART -->
                    
                </div>
                <!-- END PAGE CONTENT WRAPPER -->                                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

          
        <!-- MESSAGE BOX-->
			
			<script>
function change_message_per(){
        var message=document.getElementById('supr');
		message.innerHTML=" <b style='color:red'>Attention Procedure trés dangereuse et Irreversible</b><br><b style='color:red'> si vous supprimer cette employée toute les employées de cette structure seront supprimées</b>"
		}
		function change_message(){
        var message=document.getElementById('supr');
		message.innerText="Etes Vous Sure De Vouloir Supprimer Cette ligne";
		}
        </script>		
					
		
		<div class="message-box animated fadeIn" data-sound="alert" id="mb-remove-row">
            <div class="mb-container">
                <div class="mb-middle">
                    <div class="mb-title"><span class="fa fa-trash-o"></span> Supprimer <strong> les données </strong> ??!!</div>
                    <div class="mb-content">
                        <h3><div id="supr"></div> </h3>                   
                        <h3><p>Appuyez sur Oui si vous sûr</p></h3>
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
			  
      	<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="js/plugins/tableexport/tableExport.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jquery.base64.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/html2canvas.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jspdf/jspdf.js"></script>
	<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/base64.js"></script> 
	
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>   
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>                
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
		  <script type="text/javascript" src="js/plugins/nvd3/lib/d3.v3.js"></script>        
        <script type="text/javascript" src="js/plugins/nvd3/nv.d3.min.js"></script>
        <!-- END THIS PAGE PLUGINS -->       
        <!-- START TEMPLATE -->
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script> 
    

		<script>
	var nvd3Charts = function() {
	  var myColors = ["#33414E","#8DCA35","#00BFDD","#FF702A","#DA3610",
                        "#80CDC2","#A6D969","#D9EF8B","#FFFF99","#F7EC37","#F46D43",
                        "#E08215","#D73026","#A12235","#8C510A","#14514B","#4D9220",
                        "#542688", "#4575B4", "#74ACD1", "#B8E1DE", "#FEE0B6","#FDB863",                                                
                        "#C51B7D","#DE77AE","#EDD3F2"];
        d3.scale.myColors = function() {
            return d3.scale.ordinal().range(myColors);
        };
			var startChartPSD = function() {
			
		//Taux des projets par rubriques PSD
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-PSD svg").datum(exampleDataPSD()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataPSD() {
				var R1=document.getElementById ("Rpsd1").innerText;	
				var R2=document.getElementById ("Rpsd2").innerText;
				var R3=document.getElementById ("Rpsd3").innerText;	
				var R4=document.getElementById ("Rpsd4").innerText;	
				var R5=document.getElementById ("Rpsd5").innerText;	
				var R6=document.getElementById ("Rpsd6").innerText;	
				
				
	            var T1=document.getElementById ("Tpsd1").innerText.replace(',','.');	
				var T2=document.getElementById ("Tpsd2").innerText.replace(',','.');
				var T3=document.getElementById ("Tpsd3").innerText.replace(',','.');	
				var T4=document.getElementById ("Tpsd4").innerText.replace(',','.');	
				var T5=document.getElementById ("Tpsd5").innerText.replace(',','.');	
				var T6=document.getElementById ("Tpsd6").innerText.replace(',','.');	
								
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}];
		}

	};
//Fin Taux des projets par rubriques PSD

//************************
var startChartPSD2 = function() {
			
		//Taux des projets par rubriques PSD
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-PSD2 svg").datum(exampleDataPSD2()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataPSD2() {
				var R1=document.getElementById ("Rpsd1").innerText;	
				var R2=document.getElementById ("Rpsd2").innerText;
				var R3=document.getElementById ("Rpsd3").innerText;	
				var R4=document.getElementById ("Rpsd4").innerText;	
				var R5=document.getElementById ("Rpsd5").innerText;	
				var R6=document.getElementById ("Rpsd6").innerText;	
			
				
	            var T1=document.getElementById ("Tpsd21").innerText.replace(',','.');	
				var T2=document.getElementById ("Tpsd22").innerText.replace(',','.');
				var T3=document.getElementById ("Tpsd23").innerText.replace(',','.');	
				var T4=document.getElementById ("Tpsd24").innerText.replace(',','.');	
				var T5=document.getElementById ("Tpsd25").innerText.replace(',','.');	
				var T6=document.getElementById ("Tpsd26").innerText.replace(',','.');	
							
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}];
		}

	};
//Fin Taux des projets par rubriques PSD2
//***************************

//************************
var startChartPSC = function() {
			
		//Taux des projets par rubriques PSD
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-PSC svg").datum(exampleDataPSC()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataPSC() {
			
				var K1=document.getElementById ("Rpsc1").innerText;	
				var K2=document.getElementById ("Rpsc2").innerText;
				var K3=document.getElementById ("Rpsc3").innerText;	
				var K4=document.getElementById ("Rpsc4").innerText;	
				var K5=document.getElementById ("Rpsc5").innerText;	
				var K6=document.getElementById ("Rpsc6").innerText;	
				var K7=document.getElementById ("Rpsc7").innerText;	
				var K8=document.getElementById ("Rpsc8").innerText;
				
	            var T1=document.getElementById ("Tpsc1").innerText.replace(',','.');	
				var T2=document.getElementById ("Tpsc2").innerText.replace(',','.');
				var T3=document.getElementById ("Tpsc3").innerText.replace(',','.');	
				var T4=document.getElementById ("Tpsc4").innerText.replace(',','.');	
				var T5=document.getElementById ("Tpsc5").innerText.replace(',','.');	
				var T6=document.getElementById ("Tpsc6").innerText.replace(',','.');	
				var T7=document.getElementById ("Tpsc7").innerText.replace(',','.');	
				var T8=document.getElementById ("Tpsc8").innerText.replace(',','.');				
			
			return [
		
			{
			
				"label" : K1,
				"value" : parseFloat(T1)
			},
			{
				"label" : K2,
				"value" : parseFloat(T2)
			}, {
				"label" : K3,
				"value" : parseFloat(T3)
			}, {
				"label" : K4,
				"value" : parseFloat(T4)
			}, {
				"label" : K5,
				"value" : parseFloat(T5)
			}, {
				"label" : K6,
				"value" : parseFloat(T6)
			}, {
				"label" : K7,
				"value" : parseFloat(T7)
			}, {
				"label" : K8,
				"value" : parseFloat(T8)
			}];
		}

	};
//Fin Taux des projets par rubriques PSC
//***************************
//************************
var startChartPSC2 = function() {
			
		//Taux des projets par rubriques PSD
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-PSC2 svg").datum(exampleDataPSC2()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataPSC2() {
			
				var R1=document.getElementById ("Rpsc1").innerText;	
				var R2=document.getElementById ("Rpsc2").innerText;
				var R3=document.getElementById ("Rpsc3").innerText;	
				var R4=document.getElementById ("Rpsc4").innerText;	
				var R5=document.getElementById ("Rpsc5").innerText;	
				var R6=document.getElementById ("Rpsc6").innerText;	
				var R7=document.getElementById ("Rpsc7").innerText;	
				var R8=document.getElementById ("Rpsc8").innerText;
			
	            var T1=document.getElementById ("Tpsc21").innerText.replace(',','.');	
				var T2=document.getElementById ("Tpsc22").innerText.replace(',','.');
				var T3=document.getElementById ("Tpsc23").innerText.replace(',','.');	
				var T4=document.getElementById ("Tpsc24").innerText.replace(',','.');	
				var T5=document.getElementById ("Tpsc25").innerText.replace(',','.');	
				var T6=document.getElementById ("Tpsc26").innerText.replace(',','.');	
				var T7=document.getElementById ("Tpsc27").innerText.replace(',','.');	
				var T8=document.getElementById ("Tpsc28").innerText.replace(',','.');				
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}, {
				"label" : R7,
				"value" : parseFloat(T7)
			}, {
				"label" : R8,
				"value" : parseFloat(T8)
			}];
		}

	};
//Fin Taux des projets par rubriques PSC2


//********************
//#################

//************************
var startChartCHU = function() {
			
		//Taux des projets par rubriques CHU
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-CHU svg").datum(exampleDataCHU()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataCHU() {
		
				var R1=document.getElementById ("Rchu1").innerText;	
				
				var R2=document.getElementById ("Rchu2").innerText;	
				var R3=document.getElementById ("Rchu3").innerText;	
				var R4=document.getElementById ("Rchu4").innerText;	
				var R5=document.getElementById ("Rchu5").innerText;	
				var R6=document.getElementById ("Rchu6").innerText;	
			 
				
	            var T1=document.getElementById ("Tchu1").innerText.replace(',','.');	
				var T2=document.getElementById ("Tchu2").innerText.replace(',','.');
				var T3=document.getElementById ("Tchu3").innerText.replace(',','.');	
				var T4=document.getElementById ("Tchu4").innerText.replace(',','.');	
				var T5=document.getElementById ("Tchu5").innerText.replace(',','.');	
				var T6=document.getElementById ("Tchu6").innerText.replace(',','.');	
							
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}];
		}

	};
//Fin Taux des projets par rubriques CHU

//*************
//************************
var startChartCHU2 = function() {
			
		//Taux des projets par rubriques CHU2
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-CHU2 svg").datum(exampleDataCHU2()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataCHU2() {
		
				var R1=document.getElementById ("Rchu1").innerText;	
				
				var R2=document.getElementById ("Rchu2").innerText;	
				var R3=document.getElementById ("Rchu3").innerText;	
				var R4=document.getElementById ("Rchu4").innerText;	
				var R5=document.getElementById ("Rchu5").innerText;	
				var R6=document.getElementById ("Rchu6").innerText;	
			
				
	            var T1=document.getElementById ("Tchu21").innerText.replace(',','.');	
				var T2=document.getElementById ("Tchu22").innerText.replace(',','.');
				var T3=document.getElementById ("Tchu23").innerText.replace(',','.');	
				var T4=document.getElementById ("Tchu24").innerText.replace(',','.');	
				var T5=document.getElementById ("Tchu25").innerText.replace(',','.');	
				var T6=document.getElementById ("Tchu26").innerText.replace(',','.');	
							
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}];
		}

	};
//Fin Taux des projets par rubriques CHU

//#################

//************************
var startChartEHS = function() {
			
		//Taux des projets par rubriques EHS
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-EHS svg").datum(exampleDataEHS()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataEHS() {
		
				var R1=document.getElementById ("Rehs1").innerText;	
				
				var R2=document.getElementById ("Rehs2").innerText;	
				var R3=document.getElementById ("Rehs3").innerText;	
				var R4=document.getElementById ("Rehs4").innerText;	
				var R5=document.getElementById ("Rehs5").innerText;	
				var R6=document.getElementById ("Rehs6").innerText;	
			 
				
	            var T1=document.getElementById ("Tehs1").innerText.replace(',','.');	
				var T2=document.getElementById ("Tehs2").innerText.replace(',','.');
				var T3=document.getElementById ("Tehs3").innerText.replace(',','.');	
				var T4=document.getElementById ("Tehs4").innerText.replace(',','.');	
				var T5=document.getElementById ("Tehs5").innerText.replace(',','.');	
				var T6=document.getElementById ("Tehs6").innerText.replace(',','.');	
							
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}];
		}

	};
//Fin Taux des projets par rubriques EHS

//*************
//************************
var startChartEHS2 = function() {
			
		//Taux des projets par rubriques EHS2
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-EHS2 svg").datum(exampleDataEHS2()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataEHS2() {
		
				var R1=document.getElementById ("Rehs1").innerText;	
				
				var R2=document.getElementById ("Rehs2").innerText;	
				var R3=document.getElementById ("Rehs3").innerText;	
				var R4=document.getElementById ("Rehs4").innerText;	
				var R5=document.getElementById ("Rehs5").innerText;	
				var R6=document.getElementById ("Rehs6").innerText;	

				
	            var T1=document.getElementById ("Tehs21").innerText.replace(',','.');	
				var T2=document.getElementById ("Tehs22").innerText.replace(',','.');
				var T3=document.getElementById ("Tehs23").innerText.replace(',','.');	
				var T4=document.getElementById ("Tehs24").innerText.replace(',','.');	
				var T5=document.getElementById ("Tehs25").innerText.replace(',','.');	
				var T6=document.getElementById ("Tehs26").innerText.replace(',','.');	
							
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}];
		}

	};
//Fin Taux des projets par rubriques EHS2
//#################

//************************
var startChartEST = function() {
			
		//Taux des projets par rubriques EST
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-EST svg").datum(exampleDataEST()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataEST() {
		
				var R1=document.getElementById ("Rest1").innerText;	
				
				var R2=document.getElementById ("Rest2").innerText;	
				var R3=document.getElementById ("Rest3").innerText;	
				var R4=document.getElementById ("Rest4").innerText;	
				var R5=document.getElementById ("Rest5").innerText;	
				var R6=document.getElementById ("Rest6").innerText;	
			
				
	            var T1=document.getElementById ("Test1").innerText.replace(',','.');	
				var T2=document.getElementById ("Test2").innerText.replace(',','.');
				var T3=document.getElementById ("Test3").innerText.replace(',','.');	
				var T4=document.getElementById ("Test4").innerText.replace(',','.');	
				var T5=document.getElementById ("Test5").innerText.replace(',','.');	
				var T6=document.getElementById ("Test6").innerText.replace(',','.');	
							
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}];
		}

	};
//Fin Taux des projets par rubriques EST

//*************
//************************
var startChartEST2 = function() {
			
		//Taux des projets par rubriques EST2
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-EST2 svg").datum(exampleDataEST2()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataEST2() {
		
				var R1=document.getElementById ("Rest1").innerText;	
				
				var R2=document.getElementById ("Rest2").innerText;	
				var R3=document.getElementById ("Rest3").innerText;	
				var R4=document.getElementById ("Rest4").innerText;	
				var R5=document.getElementById ("Rest5").innerText;	
				var R6=document.getElementById ("Rest6").innerText;	
			
				
	            var T1=document.getElementById ("Test21").innerText.replace(',','.');	
				var T2=document.getElementById ("Test22").innerText.replace(',','.');
				var T3=document.getElementById ("Test23").innerText.replace(',','.');	
				var T4=document.getElementById ("Test24").innerText.replace(',','.');	
				var T5=document.getElementById ("Test25").innerText.replace(',','.');	
				var T6=document.getElementById ("Test26").innerText.replace(',','.');	
							
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}];
		}

	};
//Fin Taux des projets par rubriques EST2


//***************************

//************************
var startChartMSPRH = function() {
			
		//Taux des projets par rubriques MSPRH
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-MSPRH svg").datum(exampleDataMSPRH()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataMSPRH() {
			
				var K1=document.getElementById ("Rmsprh1").innerText;	
				var K2=document.getElementById ("Rmsprh2").innerText;
				var K3=document.getElementById ("Rmsprh3").innerText;	
				var K4=document.getElementById ("Rmsprh4").innerText;	
				var K5=document.getElementById ("Rmsprh5").innerText;	
				var K6=document.getElementById ("Rmsprh6").innerText;	
				var K7=document.getElementById ("Rmsprh7").innerText;	
				var K8=document.getElementById ("Rmsprh8").innerText;
				
	            var T1=document.getElementById ("Tmsprh1").innerText.replace(',','.');	
				var T2=document.getElementById ("Tmsprh2").innerText.replace(',','.');
				var T3=document.getElementById ("Tmsprh3").innerText.replace(',','.');	
				var T4=document.getElementById ("Tmsprh4").innerText.replace(',','.');	
				var T5=document.getElementById ("Tmsprh5").innerText.replace(',','.');	
				var T6=document.getElementById ("Tmsprh6").innerText.replace(',','.');	
				var T7=document.getElementById ("Tmsprh7").innerText.replace(',','.');	
				var T8=document.getElementById ("Tmsprh8").innerText.replace(',','.');				
			
			return [
		
			{
			
				"label" : K1,
				"value" : parseFloat(T1)
			},
			{
				"label" : K2,
				"value" : parseFloat(T2)
			}, {
				"label" : K3,
				"value" : parseFloat(T3)
			}, {
				"label" : K4,
				"value" : parseFloat(T4)
			}, {
				"label" : K5,
				"value" : parseFloat(T5)
			}, {
				"label" : K6,
				"value" : parseFloat(T6)
			}, {
				"label" : K7,
				"value" : parseFloat(T7)
			}, {
				"label" : K8,
				"value" : parseFloat(T8)
			}];
		}

	};
//Fin Taux des projets par rubriques MSPRH
//***************************
//************************
var startChartMSPRH2 = function() {
			
		//Taux des projets par rubriques MSPRH
		nv.addGraph(function() {
				
			var chart = nv.models.pieChart().x(function(d) {
				
				return d.label;
			}).y(function(d) {
				return d.value;
			}).showLabels(true).color(d3.scale.myColors().range());;

			d3.select("#chart-MSPRH2 svg").datum(exampleDataMSPRH2()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataMSPRH2() {
			
				var R1=document.getElementById ("Rmsprh1").innerText;	
				var R2=document.getElementById ("Rmsprh2").innerText;
				var R3=document.getElementById ("Rmsprh3").innerText;	
				var R4=document.getElementById ("Rmsprh4").innerText;	
				var R5=document.getElementById ("Rmsprh5").innerText;	
				var R6=document.getElementById ("Rmsprh6").innerText;	
				var R7=document.getElementById ("Rmsprh7").innerText;	
				var R8=document.getElementById ("Rmsprh8").innerText;
			
	            var T1=document.getElementById ("Tmsprh21").innerText.replace(',','.');	
				var T2=document.getElementById ("Tmsprh22").innerText.replace(',','.');
				var T3=document.getElementById ("Tmsprh23").innerText.replace(',','.');	
				var T4=document.getElementById ("Tmsprh24").innerText.replace(',','.');	
				var T5=document.getElementById ("Tmsprh25").innerText.replace(',','.');	
				var T6=document.getElementById ("Tmsprh26").innerText.replace(',','.');	
				var T7=document.getElementById ("Tmsprh27").innerText.replace(',','.');	
				var T8=document.getElementById ("Tmsprh28").innerText.replace(',','.');				
			
			return [
		
			{
			
				"label" : R1,
				"value" : parseFloat(T1)
			},
			{
				"label" : R2,
				"value" : parseFloat(T2)
			}, {
				"label" : R3,
				"value" : parseFloat(T3)
			}, {
				"label" : R4,
				"value" : parseFloat(T4)
			}, {
				"label" : R5,
				"value" : parseFloat(T5)
			}, {
				"label" : R6,
				"value" : parseFloat(T6)
			}, {
				"label" : R7,
				"value" : parseFloat(T7)
			}, {
				"label" : R8,
				"value" : parseFloat(T8)
			}];
		}

	};
//Fin Taux des projets par rubriques MSPRH2


//********************
//#################


	return {		
		init : function() {
			
		<?php if($user->type!="Admin_psd"){?>
		startChartPSC();
		startChartPSC2();
		startChartCHU();
		startChartCHU2();
		startChartEHS();
		startChartEHS2();
		startChartEST();
		startChartEST2();
		startChartMSPRH();
		startChartMSPRH2();
		startChartPSD();
		startChartPSD2();
		
		<?php }else{ ?>
		startChartPSD();
		startChartPSD2();
		<?php } ?>
		}
	}
	
	}()
	nvd3Charts.init();
		</script>
		
		<style>
	
    .scrollable {
      float: right;
      width: 100%;
      overflow: scroll !important;
      overflow-y: hidden;
    }
	
	</style>
    

        <!-- END TEMPLATE -->      
    <!-- END SCRIPTS -->                   
    </body>
</html>