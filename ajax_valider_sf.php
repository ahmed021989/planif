<?php
require_once("includes/initialiser.php");

$situation_f=Situation_f::trouve_par_id($_POST['id']);
$sql0=$bd->requete("update situation_f set last=0 where id_op=".$situation_f->id_op."");
$s=$situation_f->etat_operation;
if($situation_f->etat_operation=="Cloturee"){
$SQL = $bd->requete("update situation_f set valider=1,etat_gelee=-2,last=1  where id_situation_f =".$_POST['id']."");	
}
else {
$SQL = $bd->requete("update situation_f set valider=1,last=1  where id_situation_f =".$_POST['id']."");
}
if($SQL){
	if($s=="Cloturee"){
	echo " L'opération est clôturée ";	
	}
	else{
    echo "La situation financière est actualisée ";	
}
}

	


?>
