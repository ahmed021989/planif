<?php
require_once("includes/initialiser.php");
$id_modif=$_GET['id_modif'];
$dat=date('Y-m-d H:i');
$sql=$bd->requete("update operation_modif set date_valide='$dat',valide=-1 where id_modif='$id_modif'");
readresser_a("liste_demandes.php");


?>