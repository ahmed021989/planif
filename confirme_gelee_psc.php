<?xml version="1.0" encoding="utf-8"?>
<?php
require_once("includes/initialiser.php");
list($id_op,$rub,$prog)=explode("|",$_GET['id_op']);

$sql=$bd->requete("update situation_f set etat_gelee=0 where id_op='".$id_op."'");



echo "<script>alert('operation dégelée'); location.replace('ajouter_operation.php?id_projet=0|".$rub."|".$prog."');</script>";
//readresser_a("ajouter_operation.php?id_projet=0|".$rub."|".$prog."");


?>