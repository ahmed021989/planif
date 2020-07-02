<?php
require_once("includes/initialiser.php");

if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'ministre_SG' or 'Admin_dsp' or 'dsp' or 'Admin_ehs' or 'ehs' or 'Admin_chu' or 'chu' or 'Admin_est' or 'est' or 'dfm' or 'Admin_msprh' );
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="  Accès non autorisé!  ccsdcsdc";
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
if ($user->type == 'administrateur' or $user->type=='ministre_SG' or $user->type == 'Admin_msprh' or $user->type == 'Admin_psc' or $user->type=="Admin_psd" or $user->type=="Admin_dsp" or $user->type=="dsp" or $user->type=="Admin_ehs" or $user->type=="Admin_chu" or $user->type=="Admin_est" or $user->type=="ehs" or $user->type=="chu" or $user->type=="est" or $user->type=="dfm")   {
	require_once("composit/header.php");
}

?>

 <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>                    
                    <li class="active">Tableau de bord > Statistiques</li>
                </ul>
                <!-- END BREADCRUMB -->                       
             <?php if  ($user->type == 'administrateur' or $user->type=='ministre_SG'  or $user->type == 'Admin_msprh' or $user->type == 'Admin_psc' or $user->type=="Admin_psd" or $user->type=="Admin_dsp" or $user->type=="dsp" or $user->type=="Admin_ehs" or $user->type=="Admin_chu" or $user->type=="Admin_est" or $user->type=="ehs" or $user->type=="chu" or $user->type=="est" or $user->type=="dfm")   {  ?>   
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
				
				 <div class="row">
                        <div class="col-md-12">
                            <div class="alert   push-down-20" style="background:#fff;border:1px solid green">
							<span style="color:red;font-size:18px;text-align:center"><u>ACTUALITE</u></span></br></br>
							  <button type="button" class="close" data-dismiss="alert">×</button>
                                <?php    $SQL = $bd->requete("SELECT * FROM  `actualite` where `publier` = '1'") ;
										while ($rows = $bd->fetch_array($SQL))
														{
														echo '<strong><h3><span style="font-weight:bold;font-size:14px"> '.stripslashes($rows["nom_act"]).'  </span></strong> : <span style="font-size:14px">" '.stripslashes($rows["contenu"]).'"</h3>';
														} ?>
                              
                            </div>
                        </div>
                    </div>
				
				
				
				
                      <!-- START WIDGETS -->   
	
                    <div class="row">
					<?php if($user->type=='dsp' or $user->type=='ehs' or $user->type=="chu" or $user->type=='est' or $user->type=='dfm'){
?>
					 <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                              

						<div class="widget btn btn-info widget-danger widget-padding-sm widget-item-icon" style="background:#037BA4;" onclick="afficher_situations();"   >
                                <div class="widget-item-left">
								<?php   
									$sql=$bd->requete('select * from operation,situation_f where operation.id_ord='.$user->id_ord.' and operation.id_op=situation_f.id_op and situation_f.valider=0');
									$nb=mysqli_num_rows($sql);
									
									?>
                                  <?php if($nb==0){ ?> <span class="fa fa-refresh"></span><?php } else { ?> <span class="fa fa-refresh  fa-spin"></span><?php } ?>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong>
									   <?php if($nb==0){ echo $nb; } else { echo "<span style='color:red'>".$nb."</span>"; }		?>
									
									</strong></div>
                                    <div class="widget-title">Attentes  <br>de validation</div>
                                   
                                </div>      
                            </div>  							
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
					<?php } ?>
						<?php if($user->type=='Admin_dsp' or $user->type=='Admin_ehs' or $user->type=="Admin_chu" or $user->type=='Admin_est' or $user->type=='dsp' or $user->type=='ehs' or $user->type=="chu" or $user->type=='est' or $user->type=='dfm'  or $user->type=='Admin_msprh'){
?>
					 <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                              

						<div class="widget btn btn-info widget-danger widget-padding-sm widget-item-icon" style="background:indianred;" onclick="afficher_operations();" >
                                <div class="widget-item-left">
                                   <span class="fa fa-file-text-o"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong>
									<?php   
									
									?>
									<br>
									</strong></div>
                                    <div class="widget-title">Opérations  <br>planifiées</div>
                                   
                                </div>      
                            </div>  							
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
					<?php } ?>
					
					<!---------->
					
					<?php if($user->type=="administrateur" or $user->type=='ministre_SG'){
?>
					 <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                              

						<div class="widget btn btn-info widget-danger widget-padding-sm widget-item-icon" style="background:#037BA4;" onclick="location.href='liste_util.php';" >
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
                          <div class="widget btn btn-info widget-danger widget-padding-sm widget-item-icon" onclick="location.href='suivi_structure.php';" style="background:#B70309;"   >
                                <div class="widget-item-left" >
                                    <span class="fa fa-building-o"></span>

                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong>
									
									</strong></div>
									<br><br>
                                    <div class="widget-title" >Infrastructures </div>
                                    
                                </div>      
                               
                            </div>    
                            <!-- END WIDGET SLIDER -->
                            
                        </div>
						 <?php } ?>
						 <?php if ($user->type=='Admin_psd' or $user->type=='Admin_psc'  ) {?>
					
					
						 <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                              

						<div class="widget btn btn-info widget-danger widget-padding-sm widget-item-icon" style="background:indianred;" onclick="afficher_operations();" >
                                <div class="widget-item-left">
                                   <span class="fa fa-file-text-o"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong>
									<?php   
									
									?>
									<br>
									</strong></div>
                                    <div class="widget-title">Opérations  <br>planifiées</div>
                                   
                                </div>      
                            </div>  							
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
						
						
                                   

                     
		     <div class="col-md-3">

                           <div class="widget  btn btn-info btn-block widget-item-icon"  style="background:#FE9A2E;;border:none" onclick="<?php if($user->type=="administrateur" or $user->type=="ministre_SG"){  ?>location.href='programme_sectoriel.php'<?php } if($user->type=="Admin_psd"){  ?>location.href='topographie_psd.php'<?php }  if($user->type=="Admin_psc"){  ?>location.href='topographie_psc.php' <?php } ?> ;" >
                                 <div class="widget-item-left">
                                <span class="glyphicon glyphicon-map-marker"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">	
									</div>
                                    <div class="widget-title"style="font-size:12px">&nbsp;<br>Programmes <br> sectoriels</br> d'investissement</div>
                                    
                                </div>
                                                        
                            </div>

                        </div>  		
				   
				
					
					  <!-- END WIDGETS -->                    
<?php } ?>
						 
                        <div class="col-md-3">

                            
                            <!-- START WIDGET MESSAGES -->
                        

                        <a href="recap.php"><div class="widget btn btn-info widget-danger widget-padding-sm widget-item-icon" style="background:#229954;" >
                                <div class="widget-item-left">
								<span class="fa fa-bar-chart-o"></span> </div>

                                <div class="widget-data">
                                         <div class="widget-int num-count"><strong>
										 
										 
										 </strong></div>
										 <br><br>
                                    <div class="widget-title">Récapitulatif</div>
                                   
                                </div>                         
                            </div>  </a>


						
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
					
					
			
					
				
					
					<?php if ($user->type=='administrateur' or $user->type=='ministre_SG'   ) {?>
					
					
						 <div class="col-md-3">
                            
                            <!-- START WIDGET REGISTRED -->
                              

						<div class="widget btn btn-info widget-danger widget-padding-sm widget-item-icon" style="background:indianred;" onclick="afficher_operations();" >
                                <div class="widget-item-left">
                                   <span class="fa fa-file-text-o"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count"><strong>
									<?php   
									
									?>
									<br>
									</strong></div>
                                    <div class="widget-title">Opérations  <br>planifiées</div>
                                   
                                </div>      
                            </div>  							
                            <!-- END WIDGET REGISTRED -->
                            
                        </div>
						
						
                                   

                     
		     <div class="col-md-3">

                           <div class="widget  btn btn-info btn-block widget-item-icon"  style="background:#FE9A2E;;border:none" onclick="<?php if($user->type=="administrateur" or $user->type=="ministre_SG"){  ?>location.href='programme_sectoriel.php'<?php } if($user->type=="Admin_psd"){  ?>location.href='topographie_psd.php'<?php }  if($user->type=="Admin_psc"){  ?>location.href='topographie_psc.php' <?php } ?> ;" >
                                 <div class="widget-item-left">
                                <span class="glyphicon glyphicon-map-marker"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">	
									</div>
                                    <div class="widget-title"style="font-size:12px">&nbsp;<br>Programmes <br> sectoriels</br> d'investissement</div>
                                    
                                </div>
                                                        
                            </div>

                        </div>  		
				   
				
					
					  <!-- END WIDGETS -->                    
<?php } ?>

					<!-- END WIDGETS -->  
			
				  
				  
                    				  
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
		<!--     situations     -->
			<div class="message-box animated fadeIn" data-sound="alert" id="mb-situations">
			<div class="mb-container" style="margin-top:-50px;background:aliceblue" >
			<button class="btn btn-danger btn-lg mb-control-close pull-right">X</button>
			<center><h2>Attentes de validation</h2></center>
			 
            
			 <div class="mb-container" style="margin-top:50px;background:aliceblue">
             			
			
					<div class="row">
					<div class="col-md-8 col-sm-offset-2">
					 <div class="col-md-6">

                             <div class="widget btn btn-info btn-block widget-item-icon" style="background:#037BA4;" onclick="location.href='liste_situation_non_valide.php';" >
                                <div class="widget-item-left">
                                    <span class="fa  fa-bar-chart-o"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">
								   <?php 
								 $sql_s=$bd->requete('select * from operation,situation_f where operation.id_ord='.$user->id_ord.' and situation_f.etat_operation!="Cloturee" and operation.id_op=situation_f.id_op and situation_f.valider=0');
									echo mysqli_num_rows($sql_s);
						
								 ?>
								   </div>
                                    <div class="widget-title" style="font-size:12px">Situations</br> financières</div>
                                 
                                </div>
                                                       
                            </div>

                        </div>
					
					   <div class="col-md-6">

                           <div class="widget btn btn-info btn-block widget-item-icon"  style="background:#037BA4;border:none" onclick="location.href='liste_cloture_non_valide.php';" >
                                 <div class="widget-item-left">
                                <span class="fa fa-archive"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">	<?php
         $sql_c=$bd->requete('select * from operation,situation_f where operation.id_ord='.$user->id_ord.' and situation_f.etat_operation="Cloturee" and operation.id_op=situation_f.id_op and situation_f.valider=0');
									echo mysqli_num_rows($sql_c);
								
								    ?>
									</div>
                                    <div class="widget-title"style="font-size:12px">Opérations</br> Clôturées</div>
                                    
                                </div>
                                                        
                            </div>

                        </div> 
						
						
					
				
			 
             </div>
			  </div>
			   </div>
			 
        </div>
		</div>
		
			<!--     operations planifiers    -->
			<div class="message-box animated fadeIn" data-sound="alert" id="mb-operations">
			<div class="mb-container" style="margin-top:-50px;background:aliceblue" >
			<button class="btn btn-danger btn-lg mb-control-close pull-right">X</button>
			<center><h2>Opérations planifiées</h2></center>
			 
            
			 <div class="mb-container" style="margin-top:50px;background:aliceblue">
             			
					<?php if ($user->type=='administrateur' or $user->type=='ministre_SG' or $user->type=='Admin_psd' or $user->type=='Admin_psc'  ) {?>
					
					 <div class="col-md-4">

                             <div class="widget btn btn-info btn-block widget-item-icon" style="background:#886A08;" onclick="location.href='operation_encours.php';" >
                                <div class="widget-item-left">
                                    <span class="fa fa-refresh"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">
								   <?php 
								    if($user->type=="Admin_psc"){
										$sql0=$bd->requete("select * from operation where id_op not in(select id_op from situation_f) and id_ord in(select id_ord from ordonnateur where id_prog=41) and valider=1");
								 	$sql=$bd->requete("select * from operation where id_op in(select id_op from situation_f where (etat_operation='En cours' and last=1 and valider=1 )) and id_ord in(select id_ord from ordonnateur where id_prog=41) and valider=1");
								  $sql1=$bd->requete("select * from operation where id_op in(select id_op from situation_f where (  valider=0 ) group by id_op having count(id_op)=1) and id_ord in(select id_ord from ordonnateur where id_prog=41) and valider=1");
								  
								   }
								   if($user->type=="Admin_psd"){
									   $sql0=$bd->requete("select * from operation where id_op not in(select id_op from situation_f) and id_ord in(select id_ord from ordonnateur where id_prog=42) and valider=1");
								 	$sql=$bd->requete("select * from operation where id_op in(select id_op from situation_f where (etat_operation='En cours' and last=1 and valider=1)) and id_ord in(select id_ord from ordonnateur where id_prog=42) and valider=1");
								 $sql1=$bd->requete("select * from operation where id_op in(select id_op from situation_f where ( valider=0) group by id_op having count(id_op)=1) and id_ord in(select id_ord from ordonnateur where id_prog=42) and valider=1");
								
								 }
								   
									 if($user->type=="administrateur" or $user->type=='ministre_SG'){
										$sql0=$bd->requete("select * from operation where id_op not in(select id_op from situation_f) and valider=1");
								 	$sql=$bd->requete("select * from operation where id_op in(select id_op from situation_f where (etat_operation='En cours' and last=1 and valider=1 )) and valider=1");
                                    $sql1=$bd->requete("select * from operation where id_op in(select id_op from situation_f where (  valider=0 ) group by id_op having count(id_op)=1) and valider=1");
															 
								 }
									echo mysqli_num_rows($sql1)+mysqli_num_rows($sql)+mysqli_num_rows($sql0);
							       ?>
								   </div>
                                    <div class="widget-title" style="font-size:12px">Opérations</br> en cours</div>
                                 
                                </div>
                                                       
                            </div>

                        </div>
						
						
						
                         <div class="col-md-4">

                           <div class="widget  btn btn-info btn-block widget-item-icon"  style="background:#B4045F;;border:none" onclick="location.href='operation_gelee.php';" >
                                 <div class="widget-item-left">
                                <span class="fa fa-exclamation-circle"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">	<?php
								 if($user->type=="Admin_psd"){
								 	$sql1=$bd->requete("select * from operation where id_op in(select id_op from situation_f where etat_operation='Gelee' and last=1 and valider=1) and id_ord in(select id_ord from ordonnateur where id_prog=42) and valider=1");
								   }
								    if($user->type=="Admin_psc"){
								 	$sql1=$bd->requete("select * from operation where id_op in(select id_op from situation_f where etat_operation='Gelee' and last=1 and valider=1) and id_ord in(select id_ord from ordonnateur where id_prog=41) and valider=1");
								   }
									 if($user->type=="administrateur" or $user->type=='ministre_SG'){
								 	$sql1=$bd->requete("select * from operation where id_op in(select id_op from situation_f where etat_operation='Gelee' and last=1 and valider=1) and valider=1");
								   }
									echo mysqli_num_rows($sql1);

								    ?>
									</div>
                                    <div class="widget-title"style="font-size:12px">Opérations</br> Gelée</div>
                                    
                                </div>
                                                        
                            </div>

                        </div>        


						
						 <div class="col-md-4">

                            <div class="widget btn btn-info widget-danger widget-padding-sm widget-item-icon" style="background:#5207CA;"  onclick="location.href='operation_cloturee.php';" >
                                <div class="widget-item-left">
                               <span class="fa fa-archive"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">
								    <?php 
									 if($user->type=="Admin_psd"){
								 	$sql3=$bd->requete("select * from operation where id_op in(select id_op from situation_f where etat_operation='Cloturee' and last=1 and valider=1) and id_ord in(select id_ord from ordonnateur where id_prog=42) and valider=1");
								   }
								    if($user->type=="Admin_psc"){
								 	$sql3=$bd->requete("select * from operation where id_op in(select id_op from situation_f where etat_operation='Cloturee' and last=1 and valider=1) and id_ord in(select id_ord from ordonnateur where id_prog=41) and valider=1");
								   }
									 if($user->type=="administrateur" or $user->type=='ministre_SG'){
								 	$sql3=$bd->requete("select * from operation where id_op in(select id_op from situation_f where etat_operation='Cloturee' and last=1 and valider=1) and valider=1");
								   }
									 	echo mysqli_num_rows($sql3);
							
								   
								   ?>
								   </div>
                                  
                                    <div class="widget-title" style="font-size:12px">Opérations<br> Clôturées</div>
                                </div>
                                                        
                            </div>

                        </div>						

                     
		  		
				   
				
					
					  <!-- END WIDGETS -->                    
<?php }  else if ($user->type=='Admin_chu' or $user->type=='Admin_est' or $user->type=='Admin_ehs' or $user->type=="ehs" or $user->type=="chu" or $user->type=="est" or $user->type=="dfm" or $user->type=='Admin_msprh' or $user->type=='Admin_psd' or $user->type=='Admin_dsp' or $user->type=="dsp") { ?>
                  
					
					 <div class="col-md-4">

                             <div class="widget btn btn-info btn-block widget-item-icon" style="background:#886A08;" onclick="location.href='situation_f_encours.php';" >
                                <div class="widget-item-left">
                                    <span class="fa fa-refresh"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">
								   <?php 
								 	$sql0=$bd->requete("select * from operation where id_op not in(select id_op from situation_f ) and  id_ord=".$user->id_ord." and  valider=1");
									$sql=$bd->requete("select * from operation where   id_ord=".$user->id_ord." and id_op in(select  id_op from situation_f where (etat_operation='En cours' or etat_operation='Acheve' ) and last=1 and valider=1  ) and valider=1");
									$sql1=$bd->requete("select * from operation where   id_ord=".$user->id_ord." and id_op in(select  id_op from situation_f where    valider=0  group by id_op having count(id_op)=1 ) and valider=1");

						echo mysqli_num_rows($sql1)+mysqli_num_rows($sql)+ mysqli_num_rows($sql0);
								 ?>
								   </div>
                                    <div class="widget-title" style="font-size:12px">Opérations</br> en cours</div>
                                 
                                </div>
                                                       
                            </div>

                        </div>
					
					   <div class="col-md-4">

                           <div class="widget btn btn-info btn-block widget-item-icon"  style="background:#B4045F;border:none" onclick="location.href='situation_f_gelee.php';" >
                                 <div class="widget-item-left">
                                <span class="fa fa-exclamation-circle"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">	<?php
                      $sql1=$bd->requete("select * from operation where id_op in(select id_op from situation_f where etat_operation='Gelee'and last=1 and valider=1) and id_ord in(select id_ord from ordonnateur where id_ord=".$user->id_ord.")");
						echo mysqli_num_rows($sql1);
								
								    ?>
									</div>
                                    <div class="widget-title"style="font-size:12px">Opérations</br> Gelées</div>
                                    
                                </div>
                                                        
                            </div>

                        </div> 
						
						 <div class="col-md-4">

                            <div class="widget widget-danger btn btn-warning widget-padding-sm widget-item-icon" style="background:#5207CA;"  onclick="location.href='situation_f_cloturee.php';" >
                                <div class="widget-item-left">
                               <span class="fa fa-archive"></span>
                                </div>
                                <div class="widget-data">
                                   <div class="widget-int num-count">
								    <?php 
									$sql3=$bd->requete("select * from operation where id_op in(select id_op from situation_f where etat_operation='Cloturee' and last=1 and valider=1) and id_ord in(select id_ord from ordonnateur where id_ord=".$user->id_ord.")");
						            echo mysqli_num_rows($sql3);
								    ?>
								   </div>
                                  
                                    <div class="widget-title" style="font-size:12px">Opérations<br> Cloturées</div>
                                </div>
                                                        
                            </div>

                        </div>
						
				
			 <?php } ?>
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
		
		
		  function afficher_situations(){
			$('#mb-situations').show();    
		  }
		   function afficher_operations(){
			$('#mb-operations').show();    
		  }
		
		  $('.mb-control-close').on('click',function(){
			 	
                $('#mb-operations').hide();		
  $('#mb-situations').hide();					
		  })
		
		
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
