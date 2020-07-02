<?php
require_once("includes/initialiser.php");
$id=$_GET['id'];
$dat=date('Y-m-d H:i');
$sql=$bd->requete("update projet_supr set date_valide='$dat',valide=-1 where id_projet='$id'");
readresser_a("liste_projet_supr.php");


?>