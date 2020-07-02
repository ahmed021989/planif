<?php 
require_once("../includes/initialiser.php");

if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id'];
		 $sous_secteur = Sous_secteur::trouve_par_id($id);
		 
		$sous_secteur->supprime();
	 
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
?> 
 
