<?php
require_once("includes/initialiser.php");
$id_op=$_GET['id_op'];
$dat=date('Y-m-d H:i');
$sql=$bd->requete("update operation set date_valide='$dat',valider=1 where id_op='$id_op'");




readresser_a("liste_operation_non_valide.php");

?>