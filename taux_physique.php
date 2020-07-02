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
$titre = "Taux d'exécution Physique";
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
                  
                    <li class="active">Taux d'exécution Physique  du programme en cours de réalisation</li>
                </ul>
                <!-- END BREADCRUMB -->
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
                 
                  
				
<?php 

		
		?>	
                          <form class="form-horizontal" name="filtre" id = "filtre" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                <div class="panel panel-success">
				 <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>Taux d'exécution physique </strong></h3>
									
                                                                   
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


		<a  href='sauvgarde/pdf/imprimer_taux_physique.php?date=<?php echo $date;  ?>' class='btn btn-info  pull-right' target="_blank" ><img width="20" src="img/icons/pdf.png"> imprimer</a>
		    
                    <div class="row">
                        <div class="col-md-12">

                            <!-- START DEFAULT DATATABLE -->
                            <div class="panel panel-info">
                                <div class="panel-heading">                                
                                    
									 <h3 class="panel-title"><strong>| Taux d'exécution physique  du programme en cours de réalisation arreté au : </span>  <span  style="font-size:14px;font-weight:bold;color:red" ><?php echo $date; ?> </strong></h3>
									
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
											
											<th>Nombre d'Infrastructures</th>
											<th>Projets en étude</th>
											<th>Taux %</th>
                                                <th>Projets gelés</th>
													<th>Taux %</th>
                                              <th>Projets en cours </th>
											 	<th>Taux %</th>
                                                <th>Projets achevés </th>
													<th>Taux %</th>
											
												
											
											
													
												
                                            </tr>
                                        </thead>
										 <tbody>
								
								
								<?php 								//$infra=Infrastructure::trouve_tous();
									
	$T=0;					

	$i=0;$j=0;$k=0;$a=0; $h=0; 
	
	$projet=Projet::trouve_tous();
	
	foreach($projet as $projet){
		if($situation_phs=Situation_ph::trouve_par_projet2($projet->id_projet,$date)){
			foreach($situation_phs as $situation_ph){
				
				
				
				
		if($situation_ph->etat_projet=="en_cours"){
		
			++$i;
		}else
		if($situation_ph->etat_projet=="gelee"){
			++$j;
		}else
		if($situation_ph->etat_projet=="acheve"){
			++$a;
		}else
		
		if($situation_ph->etat_projet=="etude"){
			++$h;
		}
			
		}
			}
		}
			if(($i!=0) or ($j!=0) or ($a!=0) or ($h!=0)){
				$T=($i+$j+$h+$a);
	?>
								
								
								
								
                                   
                                            <tr >
											 <td  style="font-size:14px;font-weight:bold;color:black"><?php echo ($i+$j+$h+$a); ?></td>
											  <td style="font-size:12px;font-weight:bold;color:black"><?php  echo ($h);  ?></td>
											    <td  id="TX1" style="font-size:12px;font-weight:bold;color:#1040ec"><?php  echo ($h/$T)*100;  ?></td>
											  <td style="font-size:12px;font-weight:bold;color:black"><?php echo ($j);  ?></td>
											  <td id="TX2" style="font-size:12px;font-weight:bold;color:#1040ec"><?php  echo ($j/$T)*100;  ?></td>
                                               <td style="font-size:12px;font-weight:bold;color:black"><?php  echo ($i);  ?></td>
											   <td  id="TX3" style="font-size:12px;font-weight:bold;color:#1040ec"><?php  echo ($i/$T)*100;  ?></td>
                                               <td style="font-size:12px;font-weight:bold;color:black"><?php  echo ($a);  ?></td>
											  <td  id="TX4" style="font-size:12px;font-weight:bold;color:#1040ec"><?php  echo ($a/$T)*100;  ?></td>
                                          
												
                                              
                                            </tr>
                                 



                                  <?php
			}
			
		



                                 ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                <!-- END PAGE CONTENT WRAPPER -->                                                
            </div>            
			    <!-- START REGULAR PIE CHART -->
                          <?php 
						  if($T!=0){
						  ?>
						
						 
								<div class="col-md-12">
								  <input type="button" onclick="printDiv('printableArea')" value="Imprimer Graphe "  class='btn btn-success  pull-right '/>
								 <div id="printableArea">
     




                            <!-- START REGULAR PIE CHART -->
							
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                              <h3 class="panel-title">Taux d'exécution physique  du programme en cours de réalisation arreté au :<span  style="font-size:14px;font-weight:bold;color:red" ><?php echo $date; ?></span></h3>

                                </div>
                                <div class="panel-body">
                                    <div id="chart-PSD" style="height: 400px;"><svg></svg></div>
                                </div>
                            </div>
                            <!-- END REGULAR PIE CHART -->

                                </div> 
								</div>
						  <?php } ?>
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
	
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
	
	
	
	
	//************************************/
	
	
	
	
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
			}).showLabels(true).labelType('percent').color(d3.scale.myColors().range());;

			d3.select("#chart-PSD svg").datum(exampleDataPSD()).transition().duration(350).call(chart);

			return chart;
		});

	

		//Pie chart example data. Note how there is only a single array of key-value pairs.
		function exampleDataPSD() {
				var R1="Etude";	
				var R2="Gelé";	
				var R3="Encours";	
				var R4="Achevé";	
			
				
				
	            var T1=document.getElementById ("TX1").innerText.replace(',','.');	
				var T2=document.getElementById ("TX2").innerText.replace(',','.');
				var T3=document.getElementById ("TX3").innerText.replace(',','.');	
				var T4=document.getElementById ("TX4").innerText.replace(',','.');	
			
								
			
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
			}];
		}

	};
//Fin Taux des projets par rubriques PSD


//***************************
	
return {		
		init : function() {
		startChartPSD();
		}
	}
	
	}()
	nvd3Charts.init();	
		</script>
    <!-- END SCRIPTS -->                   
    </body>
</html>






