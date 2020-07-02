<?php
require_once("includes/initialiser.php");

$situation_f=Situation_f::trouve_par_id($_POST['id']);
//$sql0=$bd->requete("delete from situation_f set last=0 where id_op=".$situation_f->id_op."");
$s=$situation_f->etat_operation;

$SQL = $bd->requete("delete from situation_f  where id_situation_f =".$_POST['id']."");

if($SQL){
	if($s=='Cloturee'){
		echo "La clôture de l'opération est annulée ";
	}
	else{
echo "L\'actualisation de la situation financière est annulée";	
}
}

	


?>