<?php
require_once("includes/initialiser.php");


$SQL = $bd->requete("update operation set date_inscription='".$_POST['n_date']."'  where id_op =".$_POST['id']."");
if($SQL){
echo "La date est mise à jour! ";	
}

	


?>
