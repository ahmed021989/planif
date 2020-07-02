<?php
require_once("includes/initialiser.php");
$id=$_GET['id'];
$dat=date('Y-m-d H:i');
$sql=$bd->requete("update projet_supr set date_valide='$dat',valide=1 where id_projet='$id'");
$projet=Projet::trouve_par_id($id);
$operation=Operation::trouve_tous_projet($id);
foreach ($operation as $operation) {
	
	$situation_f=Situation_f::trouve_par_operation_tous($operation->id_op);
	
	foreach ($situation_f as $situation_f) {
		
	$situation_f->supprime();	
	}
	
}
$projet->supprime();
$sql2=$bd->requete("delete  from operation  where id_projet='$id'");
$sql3=$bd->requete("delete  from situation_ph  where id_projet='$id'");

readresser_a("liste_projet_supr.php");


?>