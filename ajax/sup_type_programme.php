<?php 
require_once("../includes/initialiser.php");

if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id'];
		 $type_programme = Type_programme::trouve_par_id($id);
		 
		$type_programme->supprime();
		//$SQL = $bd->requete(" DELETE FROM `planification`.`sous_secteur` WHERE `sous_secteur`.`id_secteur` ='$id' ");
	 
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
?> 
 
