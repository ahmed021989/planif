<?php 
require_once("../includes/initialiser.php");

if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id'];
		 $prog_geste = Prog_geste::trouve_par_id($id);
		 
		$prog_geste->supprime();
		$SQL = $bd->requete(" DELETE FROM `planification`.`structure` WHERE `structure`.`id_prog` ='$id' ");
	 
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
?> 
 
