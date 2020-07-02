<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title><?php echo $titre; ?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
	          <link rel="icon" href="photo/Image11.png" type="image/png" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-blue.css"/>
		 
        <!-- EOF CSS INCLUDE -->   
          <script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
  <script>
  webshims.setOptions('waitReady', false);
  webshims.setOptions('forms-ext', {types: 'date'});
  webshims.polyfill('forms forms-ext');
</script>

<script language="javascript" type="text/javascript">
		function getXMLHTTP() { //fuction to return the xml http object
				var xmlhttp=false;	
				try{
					xmlhttp=new XMLHttpRequest();
				}
				catch(e)	{		
					try{			
						xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
					}
					catch(e){
						try{
						xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
						}
						catch(e1){
							xmlhttp=false;
						}
					}
				}
					
				return xmlhttp;
			}
	</script>
	
	
	
	

	
	<?php if (in_array('voiture',$header)){?>	
	<script language="javascript" type="text/javascript">
		function getdiag(organe_id,divdiag) {		
				
				var strURL="ajax/trouvevoiture.php?organe="+organe_id+"&diag="+divdiag;
				var req = getXMLHTTP();
				
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
								document.getElementById(divdiag).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}		
			}
			
	</script>
	<?php }?>	

	

		
	
	<?php if (in_array('personne',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_util.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>	
		

	
<?php if (in_array('structure',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_structure.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>

	
	
		
	<?php if (in_array('prog_geste',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_prog_geste.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
	<?php if (in_array('secteur',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_secteur.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
	<?php if (in_array('sous_secteur',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_sous_secteur.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
		<?php if (in_array('infrastructure',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_infra.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
		<?php if (in_array('rubrique',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_rubrique.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
		<?php if (in_array('type_programme',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_type_programme.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
	
		<?php if (in_array('ordonnateur',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_ordonnateur.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
		<?php if (in_array('situation_f',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_situation_f.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
		<?php if (in_array('situation_ph',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_situation_ph.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>

	
		<?php if (in_array('operation',$header)){?>	
		
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_operation.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
	
	
	<?php if (in_array('actualite',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/listeactualite.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
		<?php if (in_array('projet',$header)){?>	
	<script language="javascript" type="text/javascript">
		function supplanif(id,divlist) {		
				
				var strURL="ajax/sup_projet.php?id="+id+"&list="+divlist;
				var req = getXMLHTTP();
				if (req) {
					
					req.onreadystatechange = function() {
						if (req.readyState == 4) {
							// only if "OK"
							if (req.status == 200) {						
							//	document.getElementById(divlist).innerHTML=req.responseText;
														
							} else {
								alert("Problem while using XMLHTTP:\n" + req.statusText);
							}
						}				
					}			
					req.open("GET", strURL, true);
					req.send(null);
				}
			}
			
	</script>
	<?php }?>
	
    </head>
    <body >
        <!-- START PAGE CONTAINER -->
        <div class="page-container">
          
            <!-- START PAGE SIDEBAR -->
          <div class="page-sidebar mCustomScrollbar _mCS_1 mCS-autoHide mCS_no_scrollbar page-sidebar-fixed scroll" >
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                 <li class="xn-logo">
                       <a href="index.php">  <strong>GSPI</strong></a>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="assets/images/users/Image11.png" />
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                               <a href="index.php" > <img src="assets/images/users/Image11.png" /></a>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name"><?php echo $user->nom_compler() ?></div>
					
                              
                            </div>
                            <div class="profile-controls">
                                <a href="edit_pass.php" class="profile-control-left"><span class="fa fa-unlock-alt"></span></a>
                                <a href="#" target="_blank" class="profile-control-right"><span class="fa fa-pencil"></span></a>
                            </div>
                        </div>                                                                        
                    </li>
                   
                    
					
					 <li>
                        <a href="index.php"><span class="fa fa-desktop"></span> <span class="xn-text" <?php echo $user->type; ?>   >Tableau de bord</span></a>                        
                    </li> 
					
					
					   <!-- /////////////////////  ADMINISTRATEUR ///////////////////-->
						  
					
					 <?php  if( $user->type == 'administrateur' or $user->type == 'ministre_SG')  { ?>     
					
                    
						
					
						
			           <?php if($user->type != 'ministre_SG' and $user->poste != '' ){ ?><li><a href="ajouter_act.php"><span class="fa fa-bell-o" style="font-size:22px"> </span>  Actualité</a></li>
					
					 <li class="xn-openable">
                        <a href="#"><span class="fa fa-group" style="font-size:20px"></span> <span class="xn-text"> Utilisateurs </span></a>
                         <ul>
                            <li><a href="ajouter_util.php"><span class="fa fa-user"></span> Nouveau Utilisateur</a></li>
                            <li><a href="liste_util.php"><span class="fa fa-list"></span>  Liste des utilisateurs</a></li>
						
						
                          </ul>
                        </li>	
					
					 <li class="xn-openable">
                        <a href="#"><span class="fa fa-cogs" style="font-size:22px"></span> <span class= "xn-text"> Parmètres </span></a>
                        <ul>
						
						<li><a href="ajouter_structure.php"><span   class="fa fa-hospital-o"  style="font-size:15px"> </span>  Structures </a></li>
						<li><a href="ajouter_infra.php"><span class="fa  fa-institution" style="font-size:15px"> </span> Infrastructures </a></li>
						<li><a href="ajouter_secteur.php"><span class="fa  fa-home" style="font-size:15px"> </span> Secteurs </a></li>
						<li><a href="ajouter_sous_secteur.php"><span class="fa fa-building"  style="font-size:15px"> </span> Sous Secteurs </a></li>
						
						
                     
						<li><a href="ajouter_ordonnateur.php"><span class="fa  fa-check-square-o" style="font-size:15px"> </span>Ordonnateurs </a></li>
					
						<li><a href="ajouter_type_programme.php"><span class="fa fa-sitemap" style="font-size:15px"> </span> Type de programme </a></li>
						
                 
                                               
                        </ul>
                    </li>
					
					   <?php } ?>
					
					
					 <li >
					  
					  
					  <li class="xn-openable">
					  <a href="#" style="font-size:14px"><span class="fa  fa-folder-open" style="font-size:15px" > </span><span class= "xn-text"> Programme déconcentré </span> </a>
					  <ul>
					  
					 
					 
					<li class="xn-openable">
					<a href="#"><span class="fa  fa-briefcase" style="font-size:15px"> </span> Projets de réalisation </a>
					<ul>
					<li><a href="ajouter_projet.php?code_struct=st104"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Hopitaux géneraux </a></li>
					<li><a href="ajouter_projet.php?code_struct=st105"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Hopitaux Spésialisés </a></li>
					<li><a href="ajouter_projet.php?code_struct=st106"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Structures de proximité </a></li>
					<li><a href="ajouter_projet.php?code_struct=st107"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Formations </a></li>
					<li><a href="ajouter_projet.php?code_struct=st108"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Infrastructures administratives </a></li>

					</ul>
					</li>
					
				
                  
				  
				  
				    <li class="xn-openable">
					  <a href="#" style="font-size:13px"><span class="fa  fa-retweet" > </span>Acquisition d'équipements  </a>
					<ul>
					
					<li><a href="ajouter_operation.php?id_projet=0|r3|42">Equipements médicaux </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r4|42">Equipements collectifs </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r6|42">Parc roulant </a></li>
	
					</ul>
                  </li>
				  
				  
				  <li>
					  <a href="ajouter_operation.php?id_projet=0|r5|42" style="font-size:13px"><span class="fa  fa-gear" > </span>Réhabilitation/Aménagement </a>
				
                  </li>
				  
				  
				  
				  
</ul></li>

	  <li class="xn-openable">
					  <a href="#" style="font-size:14px"><span class="fa  fa-folder-open" style="font-size:15px" > </span><span class= "xn-text"> Programme centralisé </span> </a>
					  <ul>
					   <li><a href="ajouter_operation.php?id_projet=0|r8|41" style="font-size:12px"><span class="fa  fa-globe" > </span>Recherche </a></li>
					  <li><a href="ajouter_operation.php?id_projet=0|r7|41" style="font-size:12px"><span class="fa  fa-laptop" > </span>Informatique </a></li>
					<li class="xn-openable">
					<a href="#"><span class="fa  fa-briefcase" style="font-size:15px"> </span> Réalisation </a>
					<ul>
					<li><a href="ajouter_operation.php?id_projet=0|r1|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Etude </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r2|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Réalisation </a></li>

					</ul>
					</li>
					
					
				  
				  
				    <li class="xn-openable">
					  <a href="#" style="font-size:13px"><span class="fa  fa-tasks" > </span>Acquisition d'équipements  </a>
					<ul>
					
					<li><a href="ajouter_operation.php?id_projet=0|r3|41">Equipements médicaux </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r4|41">Equipements collectifs </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r6|41">Parc roulant </a></li>
	
					</ul>
                  </li>
				  
				  
				  <li>
					  <a href="ajouter_operation.php?id_projet=0|r5|41" style="font-size:13px"><span class="fa  fa-gear" > </span>Réhabilitation/Aménagement  </a>
				
                  </li>
				  
				  
				  
</ul></li>
				
<li class="xn-openable">
					  <a href="#"><span class="fa fa-print" style="font-size:15px"> </span><span class= "xn-text"> Etats de sortie </span></a>
					  <ul>
                          
                  <li><a href="filtrage.php"><span class="fa fa-file" style="font-size:15px"> </span> Etat d'avancement</a></li>        
					<li><a href="etat_physique_date.php"><span class="fa fa-list-alt" style="font-size:15px"> </span> Etat physique</a></li>
				<li><a href="taux_physique.php"><span class="fa fa-th" style="font-size:15px"> </span> taux physique </a></li>
				<li><a href="infra_reception.php"><span class="fa fa-columns" style="font-size:15px"> </span> infrastructures receptionées </a></li>
                    <li><a href="recap.php"><span class="fa fa-bar-chart-o" style="font-size:15px"> </span> Récapitulatif</a>      
                          </li>

					</ul>
					  </li>
					  
				
                 	
					
					
					
					
					<?php if($user->type!='ministre_SG'){  ?>
					 <li class="xn-openable">
					 <a href="#"><span class="fa fa-indent" style="font-size:18px"></span> <span class= "xn-text">Historique </span></a>
                        <ul>
                       <li> <a href="historique_modif.php"><span class="fa fa-list-alt" style="font-size:15px"></span>Modification</a></li>
					
                        <li><a href="historique_supr.php"><span class="fa fa-list-alt" style="font-size:15px"></span>Suppression</a></li>
					
                       <li> <a href="historique_gelee.php"><span class="fa fa-file-text-o" style="font-size:15px"></span>Levée de gel</a></li>
					   <?php if($user->type=='administrateur' or $user->type=='psd' ){ ?>
					<li >
					 <a href="liste_operation_refuse.php"><span class="fa fa-minus-circle" style="font-size:18px"></span>  Opérations refusées </a>
                       
                    </li>
					<?php } ?>
					</ul>
                    </li>
					
						
                          <li >
                        <a href="backup.php"><span class="fa fa-database" style="font-size:20px"></span> <span class="xn-text">Sauvegarde /Backup </span></a>
                       
                        </li>
													
					<?php  } ?>
								 <!-- /////////////////////   psc  ///////////////////-->			
						
						    <?php } else if ($user->type == 'Admin_psc') { ?>
					
				  <li class="xn-openable">
					  <a href="#" style="font-size:15px"><span class="fa  fa-folder-open" style="font-size:17px" > </span><span class= "xn-text"> Opérations planifiées  </span></a>
					  <ul>
					   <li><a href="ajouter_operation.php?id_projet=0|r8|41" style="font-size:12px"><span class="fa  fa-globe" > </span>Recherche </a></li>
					  <li><a href="ajouter_operation.php?id_projet=0|r7|41" style="font-size:12px"><span class="fa  fa-laptop" > </span>Informatique </a></li>
					<li class="xn-openable">
					<a href="#"><span class="fa  fa-briefcase" style="font-size:15px"> </span> Réalisation </a>
					<ul>
					<li><a href="ajouter_operation.php?id_projet=0|r1|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Etude </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r2|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Réalisation </a></li>

					</ul>
					</li>
					
					
				  
				  
				    <li class="xn-openable">
					  <a href="#" style="font-size:13px"><span class="fa  fa-tasks" > </span>Acquisition d'équipements  </a>
					<ul>
					
					<li><a href="ajouter_operation.php?id_projet=0|r3|41">Equipements médicaux </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r4|41">Equipements collectifs </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r6|41">Parc roulant </a></li>
	
					</ul>
                  </li>
				  
				  
				  <li>
					  <a href="ajouter_operation.php?id_projet=0|r5|41" style="font-size:13px"><span class="fa  fa-gear" > </span>Réhabilitation/Aménagement </a>
				
                  </li>
				  
				  
				  
</ul></li>
				
				
						<li class="xn-openable">
					  <a href="#"><span class="fa fa-print" style="font-size:18px"> </span><span class= "xn-text"> Etats de sortie</span> </a>
					  <ul>
                          
                 <li><a href="filtrage.php"><span class="fa fa-file" style="font-size:15px"> </span> Etat d'avancement</a></li>        
				<li><a href="recap.php"><span class="fa fa-bar-chart-o" style="font-size:15px"> </span> Récapitulatif</a></li>
				
				
					</ul>
					  </li>
					
				
					     <li class="xn-openable">
					 <a href="#"><span class="fa fa-indent" style="font-size:18px"></span> <span class= "xn-text"> Historique </span></a>
                        <ul>
                       <li> <a href="historique_modif.php"><span class="fa fa-list-alt" style="font-size:15px"></span>  Réevaluation/ Dévaluation </a></li>
				
                         <li> <a href="historique_gelee.php"><span class="fa fa-list-alt" style="font-size:15px"></span>  Levée de gel </a></li>
								</ul>
                    </li>      
						  
						  
						            <!-- /////////////////////   DSP  ///////////////////-->
						  
                    <?php } else if ($user->type == 'Admin_psd') { ?>
					
				
					
					  	  <li class="xn-openable">
					  <a href="#" style="font-size:15px"><span class="fa  fa-folder-open" style="font-size:17px" > </span><span class= "xn-text"> Opérations planifiées </span> </a>
					  <ul>
					  
					 
					<li class="xn-openable">r
					<a href="#"><span class="fa  fa-briefcase" style="font-size:15px"> </span> Projets de réalisation </a>
					<ul>
					<li><a href="ajouter_projet.php?code_struct=st104"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Hopitaux géneraux </a></li>
					<li><a href="ajouter_projet.php?code_struct=st105"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Hopitaux Spésialisés </a></li>
					<li><a href="ajouter_projet.php?code_struct=st106"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Structures de proximité </a></li>
					<li><a href="ajouter_projet.php?code_struct=st107"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Formations </a></li>
					<li><a href="ajouter_projet.php?code_struct=st108"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Infrastructures administratives </a></li>

					</ul>
					</li>
					
					
				  
				  
				    <li class="xn-openable">
					  <a href="#" style="font-size:13px"><span class="fa  fa-retweet" > </span>Acquisition d'équipements  </a>
					<ul>
					
					<li><a href="ajouter_operation.php?id_projet=0|r3|42">Equipements médicaux </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r4|42">Equipements collectifs </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r6|42">Parc roulant </a></li>
	
					</ul>
                  </li>
				  
				  
				  <li>
					  <a href="ajouter_operation.php?id_projet=0|r5|42" style="font-size:13px"><span class="fa  fa-gear" > </span>Réhabilitation/Aménagement  </a>
				
                  </li>
				  
				  
				  
</ul></li>                  
                    
					
					 <li class="xn-openable">
					  <a href="#"><span class="fa fa-print" style="font-size:18px"> </span><span class= "xn-text"> Etats de sortie </span></a>
					  <ul>
				
				<li><a href="filtrage.php"><span class="fa fa-file" style="font-size:15px"> </span> Etat d'avancement</a></li>
				<li><a href="etat_physique_date.php"><span class="fa fa-list-alt" style="font-size:15px"> </span> Etat physique</a></li>
				<li><a href="taux_physique.php"><span class="fa fa-th" style="font-size:15px"> </span> taux physique </a></li>
				<li><a href="infra_reception.php"><span class="fa fa-columns" style="font-size:15px"> </span> infrastructures receptionées </a></li>
                  <li><a href="recap.php"><span class="fa fa-bar-chart-o" style="font-size:15px"> </span> Récapitulatif</a>        
                          
                       </li>

					</ul>
					  </li>
					
					 <li class="xn-openable">
					 <a href="#"><span class="fa fa-indent" style="font-size:18px"></span> <span class= "xn-text"> Historique </span></a>
                        <ul>
                       <li> <a href="historique_modif.php"><span class="fa fa-list-alt" style="font-size:15px"></span> <span class= "xn-text">  Modification </span></a></li>
					
                        <li><a href="historique_supr.php"><span class="fa fa-list-alt" style="font-size:15px"></span> <span class= "xn-text"> Suppression</span></a></li>
					
                      	<li> <a href="historique_gelee.php"><span class="fa fa-file-text-o" style="font-size:15px"></span> <span class= "xn-text">levée de gel</span></a></li>
					<li >
					 <a href="liste_operation_refuse.php"><span class="fa fa-minus-circle" style="font-size:18px"></span> <span class= "xn-text">Opérations refusées </span></a>   
                    </li>
					</ul>
                    </li>
					
					
				
             
						      <!-- /////////////////////   dsp  ///////////////////-->
						  
                    <?php } else if ($user->type == 'Admin_dsp' or $user->type == 'dsp') { ?>
					
				
									

         	 
					  
					  
					<li class="xn-openable">
					<a href="#"><span class="fa  fa-briefcase" style="font-size:15px"> </span> <span class= "xn-text"> Projets de Réalisation </span> </a> 
					<ul>
					<li><a href="ajouter_projet.php?code_struct=st104"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Hopitaux géneraux </a></li>
					<li><a href="ajouter_projet.php?code_struct=st105"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Hopitaux Spésialisés </a></li>
					<li><a href="ajouter_projet.php?code_struct=st106"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Structures de proximité </a></li>
					<li><a href="ajouter_projet.php?code_struct=st107"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Formations </a></li>
					<li><a href="ajouter_projet.php?code_struct=st108"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Infrastructures administratives </a></li>

					</ul>
					</li>
					
					
                 	
				  
				  
				    <li class="xn-openable">
					  <a href="#" style="font-size:13px"><span class="fa  fa-retweet" > </span><span class= "xn-text">Acquisition d'équipements </span> </a>
					<ul>
					
					<li><a href="ajouter_operation.php?id_projet=0|r3|42">Equipements médicaux </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r4|42">Equipements collectifs </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r6|42">Parc roulant </a></li>
	
					</ul>
                  </li>
				  
				  
				  <li>
					  <a href="ajouter_operation.php?id_projet=0|r5|42" style="font-size:13px"><span class="fa  fa-gear" > </span><span class= "xn-text">Réhabilitation/Aménagement  </span></a>
				
                  </li>
				  
				  
		<!-- 		  
  <li class="xn-openable"   >
                        <a href="#"><span class="fa fa-file-text-o" style="font-size:18px"></span> <span class= "xn-text"> Opérations planifées </span></a>
						 
                        <ul>
						<li><a href="situation_f_encours.php"><span class="fa fa-refresh" style="font-size:15px"> </span>  Opérations en cours </a></li>
						<li><a href="situation_f_gelee.php"><span class="fa fa-exclamation-circle"  style="font-size:15px"> </span> Operations Gelées</a></li>
						<li><a href="situation_f_cloturee.php"><span   class="fa fa-check-square"  style="font-size:15px"> </span>   Operations Clôturées</a></li>
						
                       
					                        
                        </ul>
                    </li>-->

						<li class="xn-openable">
					  <a href="#"><span class="fa fa-print" style="font-size:18px"> </span><span class= "xn-text"> Etats de sortie</span> </a>
					  <ul>
                          
                 <li><a href="filtrage.php"><span class="fa fa-file" style="font-size:15px"> </span> Etat d'avancement</a></li>        
				<li><a href="recap.php"><span class="fa fa-bar-chart-o" style="font-size:15px"> </span> Récapitulatif</a></li>
				
				
					</ul>
					  </li>
					
					 	            <!-- /////////////////////   CHU  ///////////////////-->
						  
                    <?php } else if ($user->type == 'Admin_chu' or $user->type == 'chu') { ?>
					
				
									

					 
					 
					<li class="xn-openable">
					<a href="#"><span class="fa  fa-briefcase" style="font-size:15px"> </span><span class= "xn-text"> Réalisation </span></a>
					<ul>
					<li><a href="ajouter_operation.php?id_projet=0|r1|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Etude </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r2|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Réalisation </a></li>

					</ul>
					</li>
					
					
				  
				  
				    <li class="xn-openable">
					  <a href="#" style="font-size:12px"><span class="fa  fa-tasks" > </span><span class= "xn-text">Acquisition d'équipements </span> </a>
					<ul>
					
					<li><a href="ajouter_operation.php?id_projet=0|r3|41">Equipements médicaux </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r4|41">Equipements collectifs </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r6|41">Parc roulant </a></li>
	
					</ul>
                  </li>
				  
				  
				  <li>
					  <a href="ajouter_operation.php?id_projet=0|r5|41" style="font-size:12px"><span class="fa  fa-gear" > </span><span class= "xn-text">Réhabilitation/Aménagement </span> </a>
				
                  </li>
				  
				  
				  

						
                     <!--   <li class="xn-openable"   >
                        <a href="#"><span class="fa fa-file-text-o" style="font-size:18px"></span> <span class= "xn-text">  Opérations planifées </span></a>
						 
                        <ul>
						<li><a href="situation_f_encours.php"><span class="fa fa-refresh" style="font-size:15px"> </span>  Opérations en cours </a></li>
						<li><a href="situation_f_gelee.php"><span class="fa fa-exclamation-circle"  style="font-size:15px"> </span> Operations Gelées</a></li>
						<li><a href="situation_f_cloturee.php"><span   class="fa fa-check-square"  style="font-size:15px"> </span>   Operations Clôturées</a></li>
						
                       
					                        
                        </ul>
                    </li>-->
					
						<li class="xn-openable">
					  <a href="#"><span class="fa fa-print" style="font-size:18px"> </span><span class= "xn-text"> Etats de sortie</span> </a>
					  <ul>
                          
                 <li><a href="filtrage.php"><span class="fa fa-file" style="font-size:15px"> </span> Etat d'avancement</a></li>        
				<li><a href="recap.php"><span class="fa fa-bar-chart-o" style="font-size:15px"> </span> Récapitulatif</a></li>
				
				
					</ul>
					  </li>
					
					
							            <!-- /////////////////////   EST  ///////////////////-->
						  
                    <?php } else if ($user->type == 'Admin_est' or $user->type == 'est') { ?>
					
				
						
					<li class="xn-openable">
					<a href="#"><span class="fa  fa-briefcase" style="font-size:15px"> </span> <span class= "xn-text">Réalisation </span></a>
					<ul>
					<li><a href="ajouter_operation.php?id_projet=0|r1|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Etude </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r2|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Réalisation </a></li>

					</ul>
					</li>
					
					
				  
				  
				    <li class="xn-openable">
					  <a href="#" style="font-size:12px"><span class="fa  fa-tasks" > </span><span class= "xn-text">Acquisition d'équipements </span> </a>
					<ul>
					
					<li><a href="ajouter_operation.php?id_projet=0|r3|41">Equipements médicaux </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r4|41">Equipements collectifs </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r6|41">Parc roulant </a></li>
	
					</ul>
                  </li>
				  
				  
				  <li>
					  <a href="ajouter_operation.php?id_projet=0|r5|41" style="font-size:12px"><span class="fa  fa-gear" > </span><span class= "xn-text">Réhabilitation/Aménagement  </span></a>
				
                  </li>			

                     
						<!--	
                       <li class="xn-openable"   >
                        <a href="#"><span class="fa fa-file-text-o" style="font-size:18px"></span> <span class= "xn-text">  Opérations planifées </span></a>
						 
                        <ul>
						<li><a href="situation_f_encours.php"><span class="fa fa-refresh" style="font-size:15px"> </span>  Opérations en cours </a></li>
						<li><a href="situation_f_gelee.php"><span class="fa fa-exclamation-circle"  style="font-size:15px"> </span> Operations Gelées</a></li>
						<li><a href="situation_f_cloturee.php"><span   class="fa fa-check-square"  style="font-size:15px"> </span>   Operations Clôturées</a></li>
						
                       
					                        
                        </ul>
                    </li>--->
					
					<li class="xn-openable">
					  <a href="#"><span class="fa fa-print" style="font-size:18px"> </span><span class= "xn-text"> Etats de sortie</span> </a>
					  <ul>
                          
                 <li><a href="filtrage.php"><span class="fa fa-file" style="font-size:15px"> </span> Etat d'avancement</a></li>        
				<li><a href="recap.php"><span class="fa fa-bar-chart-o" style="font-size:15px"> </span> Récapitulatif</a></li>
				
				
					</ul>
					  </li>
					
						            <!-- /////////////////////   Ehs  ///////////////////-->
						  
                    <?php } else if ($user->type == 'Admin_ehs' or $user->type == 'ehs') { ?>
					
				
					<li class="xn-openable">
					<a href="#"><span class="fa  fa-briefcase" style="font-size:15px"> </span><span class= "xn-text"> Réalisation </span></a>
					<ul>
					<li><a href="ajouter_operation.php?id_projet=0|r1|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Etude </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r2|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Réalisation </a></li>

					</ul>
					</li>
					
					
				  
				  
				    <li class="xn-openable">
					  <a href="#" style="font-size:12px"><span class="fa  fa-tasks" > </span><span class= "xn-text">Acquisition d'équipements </span> </a>
					<ul>
					
					<li><a href="ajouter_operation.php?id_projet=0|r3|41">Equipements médicaux </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r4|41">Equipements collectifs </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r6|41">Parc roulant </a></li>
	
					</ul>
                  </li>
				  
				  
				  <li>
					  <a href="ajouter_operation.php?id_projet=0|r5|41" style="font-size:12px"><span class="fa  fa-gear" > </span><span class= "xn-text">Réhabilitation/Aménagement </span> </a>
				
                  </li>
						
                    
					
				<li class="xn-openable">
					  <a href="#"><span class="fa fa-print" style="font-size:18px"> </span><span class= "xn-text"> Etats de sortie</span> </a>
					  <ul>
                          
                 <li><a href="filtrage.php"><span class="fa fa-file" style="font-size:15px"> </span> Etat d'avancement</a></li>        
				<li><a href="recap.php"><span class="fa fa-bar-chart-o" style="font-size:15px"> </span> Récapitulatif</a></li>
				
				
					</ul>
					  </li>
					
						
						
								            <!-- /////////////////////   administrateur MSPRH  ///////////////////-->
						  
                    <?php } else if ($user->type == 'Admin_msprh' or $user->type == 'dfm') { ?>
					
				
					
					   <li><a href="ajouter_operation.php?id_projet=0|r8|41" style="font-size:12px"><span class="fa  fa-globe" > </span><span class= "xn-text">Recherche </span></a></li>
					  <li><a href="ajouter_operation.php?id_projet=0|r7|41" style="font-size:12px"><span class="fa  fa-laptop" > </span><span class= "xn-text">Informatique </span></a></li>
					<li class="xn-openable">
					<a href="#"><span class="fa  fa-briefcase" style="font-size:15px"> </span><span class= "xn-text"> Réalisation </span></a>
					<ul>
					<li><a href="ajouter_operation.php?id_projet=0|r1|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Etude </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r2|41"><span class="fa fa-hospital-o" style="font-size:15px"> </span> Réalisation </a></li>

					</ul>
					</li>
					
					
				  
				  
				    <li class="xn-openable">
					  <a href="#" style="font-size:12px"><span class="fa  fa-tasks" > </span><span class= "xn-text">Acquisition d'équipements </span> </a>
					<ul>
					
					<li><a href="ajouter_operation.php?id_projet=0|r3|41">Equipements médicaux </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r4|41">Equipements collectifs </a></li>
					<li><a href="ajouter_operation.php?id_projet=0|r6|41">Parc roulant </a></li>
	
					</ul>
                  </li>
				  
				  
				  <li>
					  <a href="ajouter_operation.php?id_projet=0|r5|41" style="font-size:12px"><span class="fa  fa-gear" > </span><span class= "xn-text">Réhabilitation/Aménagement </span> </a>
				
                  </li>
						<!--<li class="xn-openable"   >
                        <a href="#"><span class="fa fa-file-text-o" style="font-size:18px"></span> <span class= "xn-text"> Opérations planifées </span></a>
						 
                        <ul>
						<li><a href="situation_f_encours.php"><span class="fa fa-refresh" style="font-size:15px"> </span>  Opérations en cours </a></li>
						<li><a href="situation_f_gelee.php"><span class="fa fa-exclamation-circle"  style="font-size:15px"> </span> Operations Gelées</a></li>
						<li><a href="situation_f_cloturee.php"><span   class="fa fa-check-square"  style="font-size:15px"> </span>   Operations Clôturées</a></li>
						
                       
					                        
                        </ul>
                    </li> -->
						
					<li class="xn-openable">
					  <a href="#"><span class="fa fa-print" style="font-size:18px"> </span><span class= "xn-text"> Etats de sortie</span> </a>
					  <ul>
                          
                 <li><a href="filtrage.php"><span class="fa fa-file" style="font-size:15px"> </span> Etat d'avancement</a></li>        
				<li><a href="recap.php"><span class="fa fa-bar-chart-o" style="font-size:15px"> </span> Récapitulatif</a></li>
				
				
					</ul>
					  </li>
					
                        
						      <!-- ////////////////// fin if    //////////////////////-->>
                     <?php        } ?>
               
                      
			   
			    
			   
			    
			   
			   </ul> 

                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->
			
             
                

            
            <!-- PAGE CONTENT -->
            <div class="page-content ">
              
            	
                <!-- START X-NAVIGATION VERTICAL -->
               <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
				
                    <!-- TOGGLE NAVIGATION -->
					
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
               
                    <!-- END TOGGLE NAVIGATION -->
                    <!-- SEARCH -->
                  					
                    <!-- END SEARCH -->
                    <!-- SIGN OUT -->
                      <li class="xn-icon-button pull-right">
				
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-power-off" style="font-size:22px;color:red"> </span></a>                        
                    </li> 
					<li class="xn-icon-button pull"> 
                        	
																			
																			                    
                    </li>
					
							
					
										 <!-- MESSAGES -->
										  <?php if ($user->type=='administrateur' or $user->type=='Admin_psd' or $user->type=='Admin_psc'){ ?>
					   <li class="xn-icon-button pull-right">
                        <a href="liste_operation_non_valide.php"><span class="fa fa-bell-o" data-placement="bottom" data-toggle="tooltip" title="Opération en cours de validation "></span></a>
                        <div class="informer informer-danger"><?php 
						$SQL="";
						if($user->type=='Admin_psd'){
						$SQL = $bd->requete("SELECT * FROM  operation,ordonnateur  WHERE operation.valider=0 and operation.id_ord=ordonnateur.id_ord and ordonnateur.id_prog=42 ") ;
						}
						if($user->type=='Admin_psc'){
						$SQL = $bd->requete("SELECT * FROM  operation,ordonnateur  WHERE operation.valider=0 and operation.id_ord=ordonnateur.id_ord and ordonnateur.id_prog=41 ") ;
						}
						if($user->type=='administrateur'){
						$SQL = $bd->requete("SELECT * FROM  operation  WHERE valider=0  ") ;
						}
																			$nbr = mysqli_num_rows($SQL);
																		if($nbr!=0) { echo $nbr;}
																			?></div>
                                              
                    </li>
					 <?php } ?>
										 
					 <?php if ($user->type=='administrateur' or $user->type=='Admin_psd'){ ?>
                    <li class="xn-icon-button pull-right">
                        <a href="liste_projet_supr.php"><span class="fa fa-trash-o" data-placement="bottom" data-toggle="tooltip" title="demande de suppression de projet"></span></a>
                        <div class="informer informer-danger"><?php  $SQL = $bd->requete("SELECT * FROM  projet_supr  WHERE valide=0 ") ;
																			$nbr = mysqli_num_rows($SQL);
																		if($nbr!=0) { echo $nbr;}
																			?></div>
                                              
                    </li>
					 <?php } if ($user->type=='administrateur' or $user->type=='Admin_psd' or $user->type=='Admin_psc'){ ?>
                    <!-- END MESSAGES -->
                    <!-- TASKS -->
                    <li class="xn-icon-button pull-right">
                        <a href="liste_demandes.php" data-toggle="tooltip" data-placement="bottom" title="demande de modification/réevaluation"><span class="fa fa-comments-o"></span></a>
                        <div class="informer informer-danger"><?php  if($user->type=='Admin_psc') $SQL = $bd->requete("SELECT * FROM  operation_modif,ordonnateur  WHERE operation_modif.valide=0 AND  operation_modif.etat_operation!='Gelee' and operation_modif.id_ord=ordonnateur.id_ord and ordonnateur.id_prog=41") ;
																		 if($user->type=='Admin_psd')	$SQL = $bd->requete("SELECT * FROM  operation_modif,ordonnateur  WHERE operation_modif.valide=0 AND  operation_modif.etat_operation!='Gelee' and operation_modif.id_ord=ordonnateur.id_ord and ordonnateur.id_prog=42") ;
																			 if($user->type=='administrateur') $SQL = $bd->requete("SELECT * FROM  operation_modif,ordonnateur  WHERE operation_modif.valide=0 AND  operation_modif.etat_operation!='Gelee' and operation_modif.id_ord=ordonnateur.id_ord and (ordonnateur.id_prog=41 or  ordonnateur.id_prog=42) ") ;
																			
																			$nbr = mysqli_num_rows($SQL);
																			if($nbr!=0) { echo $nbr;}
																			?></div>
                                               
                    </li>
					
					
					 <!-- TASKS -->
                    <li class="xn-icon-button pull-right">
                        <a href="liste_demandes_gelee.php" data-toggle="tooltip" data-placement="bottom" title="demande de levée de gel"><span class="fa fa-bookmark-o"></span></a>
                        <div class="informer informer-danger"><?php  if($user->type=='Admin_psc') $SQL = $bd->requete("SELECT * FROM  operation_modif,ordonnateur  WHERE operation_modif.valide=0 AND  operation_modif.etat_operation='Gelee' and operation_modif.id_ord=ordonnateur.id_ord and ordonnateur.id_prog=41") ;
																		 if($user->type=='Admin_psd')	$SQL = $bd->requete("SELECT * FROM  operation_modif,ordonnateur  WHERE operation_modif.valide=0 AND  operation_modif.etat_operation='Gelee' and operation_modif.id_ord=ordonnateur.id_ord and ordonnateur.id_prog=42") ;
																			 if($user->type=='administrateur') $SQL = $bd->requete("SELECT * FROM  operation_modif,ordonnateur  WHERE operation_modif.valide=0 AND  operation_modif.etat_operation='Gelee' and operation_modif.id_ord=ordonnateur.id_ord and (ordonnateur.id_prog=41 or  ordonnateur.id_prog=42) ") ;
																				
																			$nbr = mysqli_num_rows($SQL);
																			if($nbr!=0) { echo $nbr;}
																			?>
																			</div>
                                               
                    </li>
					
					
					<?php 
					 }
					?>
					
					
					
						<?php if  ($user->type == 'administrateur'  or $user->type == 'Admin_msprh' or $user->type == 'Admin_psc' or $user->type=="Admin_psd" or $user->type=="Admin_dsp" or $user->type=="dsp" or $user->type=="Admin_ehs" or $user->type == 'ehs' or $user->type=="Admin_chu" or $user->type == 'chu' or $user->type=="Admin_est" or $user->type == 'est' or $user->type == 'dfm')   {  ?>
								
								 <li class="xn-icon-button pull-right">
                        <a href="message.php" data-toggle="tooltip" data-placement="bottom" title="messagerie"><span class="fa fa-envelope-o"></span></a>
                        <div class="informer informer-danger"><?php  $SQL = $bd->requete("SELECT * FROM personne,message where   message.id_destinataire=personne.id and personne.id=".$user->id." and lire_mess=0 ") ;
																			
																			$nbr = mysqli_num_rows($SQL);
																			if($nbr!=0) { echo $nbr;}
																			?> </div>
                                    
                    </li>
					<?php }?>
					
					
					
					
				 <!-- END SIGN OUT -->
                    <!-- MESSAGES 
                    <li class="xn-icon-button pull-right">
                        <a href="liste_prod.php"><span class="fa fa-comments"></span></a>
                        <div class="informer informer-danger"></div>
                                             
                    </li>
                    <!-- END MESSAGES -->
                    <!-- TASKS -->
                    
                    <!-- END TASKS -->
					<br>
					<h3 style  = "color:#FFFFFF;  "  > Gestion et suivi des programmes d'investissement :   &nbsp <?php $sql=$bd->requete("select * from ordonnateur,personne where ordonnateur.id_ord=personne.id_ord and personne.id_ord=".$user->id_ord.""); while($row=mysqli_fetch_array($sql)){ echo  $row['nom_ord']; break;} ?></h3> 

                </ul>
			
				
              
            	
                <!-- START X-NAVIGATION VERTICAL -->
           

                <!-- END X-NAVIGATION VERTICAL -->                     
