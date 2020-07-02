<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
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
	
	
}






?>
<?php
$titre = "Etat physique";
$active_menu = "index";
$header = array('situation_f');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est'){
	require_once("composit/header.php");
}
?>
<html lang="en">
 <!-- START BREADCRUMB -->
                 
               <ul class="breadcrumb">
                    <li><a href="index.php">Accueil</a></li>
                  
                    <li class="active">Etat physique</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                  
				
<?php 

		
		?>	
                          <form class="form-horizontal" name="filtre" id = "filtre" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <div class="panel panel-success">
				
				 <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Etat physique du programme en cours </strong></h3>
									
                                                                   
                                </div>
						    <div class="panel-body">                                                                        
                                     <div class="row">
									 
							
      
                      
					<div class="col-md-2">	
					  <div class="form-group">
                                               <label class="col-md-6  control-label">Au Date:</label>
                                               <div class="col-md-4 col-xs-12">                                           
                                                    <div class="input-group">
                                                       
                                                        <input type="date" class="form-control" name ="date_s" required >
														 <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
                                                    </div>                                            
                                                 </div>
											
                          </div>
						  </br>
						</div>

					
											
                                <div class="panel-footer">
                                                                       
                                    <button class="btn btn-info pull-right"type = "submit" name = "submit">Filtrer</button>
                                </div>
								 </div><!-- FIN ROW -->
								 </div>
								  </div>
						  </form>
<?php 

function filtre($date){

	$infra=Infrastructure::trouve_tous();
//$projet=Projet::trouve_tous_infra($infra->id_infra);
?>
               <div class="page-content-wrap"> 
            
<span class="pull-left" style="font-size:15px;font-weight:bold;color:#1caf9a">|  Etat physique du programme en cours Arreté au : </span>  <span  style="font-size:14px;font-weight:bold;color:red" ><?php echo fr_date2($date); ?>  </span>
		

		<a  href='sauvgarde/pdf/imprimer_etat_physique.php?date=<?php echo $date;  ?>' class='btn btn-danger btn-rounded pull-right' target="_blank" ><img width="20" src="img/icons/pdf.png"> imprimer</a>&nbsp;
		     
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-info">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Etat physique  </strong></h3>
									
                                    <ul class="panel-controls">
                                        <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                        <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
                                        <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                    </ul>                                
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable table-striped">
                                        <thead>
                                            <tr>
											
											<th>Infrastructure</th>
											<th>Projets en étude</th>
                                                <th>Projets gelés</th>
                                              <th>Projets en cours </th>
                                                <th>Projets achevés </th>
												<th>Total </th>
											
												
											
											
													
												
                                            </tr>
                                        </thead>
										 <tbody>
								
								
								<?php 								$infra=Infrastructure::trouve_tous();
									
		$TOTAL1=0;	$TOTAL2=0;	$TOTAL3=0;	$TOTAL4=0;						
foreach($infra as $infra){
	$i=0;$j=0;$k=0;$a=0; $h=0; 
	
	$projet=Projet::trouve_tous_infra($infra->id_infra);
	
	foreach($projet as $projet){
		if($situation_phs=Situation_ph::trouve_par_projet2($projet->id_projet,$date)){
			foreach($situation_phs as $situation_ph){
		if($situation_ph->etat_projet=="En cours"){
			++$i;
		}else
		if($situation_ph->etat_projet=="Gele"){
			++$j;
		}else
		if($situation_ph->etat_projet=="Acheve"){
			++$a;
		}else
		
		if($situation_ph->etat_projet=="En etude"){
			++$h;
		}
			
		}
			}
		}
			if(($i!=0) or ($j!=0) or ($a!=0) or ($h!=0)){
	?>
								
								
								
								
                                   
                                            <tr >
											 <td  style="font-size:14px;font-weight:bold;color:black"><?php echo $infra->nom_infra; ?></td>
											  <td style="font-size:12px;font-weight:bold;color:black"><?php  echo html_entity_decode($h);  ?></td>
											  <td style="font-size:12px;font-weight:bold;color:black"><?php echo html_entity_decode($j);  ?></td>
                                               <td style="font-size:12px;font-weight:bold;color:black"><?php  echo html_entity_decode($i);  ?></td>
                                               <td style="font-size:12px;font-weight:bold;color:black"><?php  echo html_entity_decode($a);  ?></td>
											   <td  style="font-weight:bold;color:red"><?php  echo html_entity_decode($i+$j+$h+$a);  ?></td>
                                          
												
                                              
                                            </tr>
                                 



                                  <?php
			}
			
		


} 
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
<?php  } ?>
<div>
<?php  
	if(isset($_POST['submit'])){
	$errors = array();

	$date=$_POST['date_s'];
	
	filtre($date);
	
	

	
	  
									  
	}
 ?>
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






