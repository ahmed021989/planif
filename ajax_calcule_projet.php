<?php
require_once("includes/initialiser.php");
if(isset($session->id_utilisateur) ){
global $bd;

$user = Personne::trouve_par_id($session->id_utilisateur);
$sql=$bd->requete("select * from projet_supr where id_ord=".$user->id_ord." and valide!=0");
   $sql1=$bd->requete("select * from projet_supr where id_ord=".$user->id_ord."");
   $nbr=mysqli_num_rows($sql);
    $nbr1=mysqli_num_rows($sql1);
	if($nbr!=$_POST['nbr'] or $nbr1!=$_POST['nbr1']){
		echo "actualiser";
	}

}
	


?>