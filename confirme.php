<?php
require_once("includes/initialiser.php");
$id_modif=$_GET['id_modif'];
$dat=date('Y-m-d H:i');
$sql=$bd->requete("update operation_modif set date_valide='$dat',valide=1 where id_modif='$id_modif'");
$operation_modif=Operation_modif::trouve_par_id($id_modif);
//echo $operation_modif->a_numero_op;
$operation=Operation::trouve_par_num_op($operation_modif->a_numero_op);
if($operation_modif->numero_op!=''){
$sql2=$bd->requete("update operation set num_op='".$operation_modif->numero_op."' where id_op=".$operation->id_op."");
}
if($operation_modif->nom_oper!=''){
$sql2=$bd->requete("update operation set libelle_op='".$operation_modif->nom_oper."' where id_op=".$operation->id_op."");
}
if($operation_modif->reev!=''){
$sql2=$bd->requete("update operation_modif set reev='".$operation_modif->reev."'  where id_modif='$id_modif'");
}
readresser_a("liste_demandes.php");


?>