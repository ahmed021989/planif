<?php
require_once("includes/initialiser.php");
if(isset($session->id_utilisateur) ){
global $bd;

$user = Personne::trouve_par_id($session->id_utilisateur);
  $nbr1=0;
    $nbr2=0;
  $nbr3=0;
  $sql=$bd->requete("select * from operation_modif where id_ord=".$user->id_ord." and valide!=0");
   $sql1=$bd->requete("select * from operation_modif where id_ord=".$user->id_ord."");
    $sql2=$bd->requete("select * from situation_f,operation where situation_f.id_op=operation.id_op and operation.id_ord=".$user->id_ord." and situation_f.valider!=0");
   $sql3=$bd->requete("select * from situation_f,operation where  situation_f.id_op=operation.id_op  and operation.id_ord=".$user->id_ord."");
   $nbr=mysqli_num_rows($sql);
    $nbr1=mysqli_num_rows($sql1);
	  $nbr2=mysqli_num_rows($sql2);
    $nbr3=mysqli_num_rows($sql3);
 
	if($nbr!=$_POST['nbr'] or $nbr1!=$_POST['nbr1'] or $nbr2!=$_POST['nbr2'] or $nbr3!=$_POST['nbr3']){
		echo "actualiser";
	}

}
	


?>