<?php
require_once("includes/initialiser.php");


$SQL = $bd->requete("update projet set id_infra='".$_POST['programme']."'  where id_projet =".$_POST['id']."");
if($SQL){
echo "Infrastructure de projet mis à jour!";	
}
else{
echo "Erreur de modification";		
}

	


?>
