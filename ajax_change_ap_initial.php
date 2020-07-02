<?php
require_once("includes/initialiser.php");


$SQL = $bd->requete("update operation set ap_initial=".$_POST['ap_initial']."  where id_op =".$_POST['id']."");
if($SQL){
echo " L'AP initiale est mise à jour!";	
}

	


?>
