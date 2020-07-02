<?php
require_once("includes/initialiser.php");
$id_modif=$_GET['id_modif'];
$dat=date('Y-m-d H:i');
$sql=$bd->requete("update operation_modif set date_valide='$dat',valide=1 where id_modif='$id_modif'");
$operation_modif=Operation_modif::trouve_par_id($id_modif);
//$situation_f=Situation_f::trouve_par_operation($operation_modif->id_op);
$sql=$bd->requete("update situation_f set etat_gelee=0 where id_op='".$operation_modif->id_op."'");




readresser_a("liste_demandes_gelee.php");


?>