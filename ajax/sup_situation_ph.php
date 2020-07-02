<?php 
require_once("../includes/initialiser.php");

if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id'];
		 $situation_ph = Situation_ph::trouve_par_id($id);
		 
		$situation_ph->supprime();
		//$SQL = $bd->requete(" DELETE FROM `planification`.`sous_secteur` WHERE `sous_secteur`.`id_secteur` ='$id' ");
	 
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
?> 
 
