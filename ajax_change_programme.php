<?php
require_once("includes/initialiser.php");


$SQL = $bd->requete("update operation set topographie='".$_POST['programme']."'  where id_op =".$_POST['id']."");
if($SQL){
echo "Type de programme mis à jour!";	
}
else{
echo "Erreur de modification";		
}

	


?>
