<?php 
require_once("../includes/initialiser.php");

if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
		 $id = $_GET['id'];
		 
		 
		 
		 
		 $operation = Operation::trouve_par_id($id);
		$situation_f=Situation_f::trouve_par_operation_tous($operation->id_op);
		foreach ($situation_f as $situation_f) {
		
	$situation_f->supprime();	
	}
	
		
		$operation->supprime();
		
	 
	 } else { 
			$msg_error = '<p class="error">Cette page a été consultée par erreur</p>';
		} 
		
		
?> 
 
