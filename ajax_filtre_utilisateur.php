<?php
require_once("includes/initialiser.php");
$type_admin=$_POST['util'];

if($type_admin=='administrateur' or $type_admin=='ministre_SG'){ $type="administration centrale";}
if($type_admin=='Admin_psd') {$type="administration centrale";} 
if($type_admin=='Admin_psc') {$type="administration centrale";} 
if($type_admin=='Admin_dsp' or $type_admin=='dsp') {$type="DSP";} 
if($type_admin=='Admin_chu' or $type_admin=='chu') {$type="CHU";} 
if($type_admin=='Admin_ehs' or $type_admin=='ehs')  {$type="EHS"; }
if($type_admin=='Admin_est' or $type_admin=='est') {$type="EST"; }
if($type_admin=='Admin_msprh' or $type_admin=='dfm') {$type="msprh"; }


$SQL = $bd->requete("select * from ordonnateur  where type_ord ='".$type."'");
while($row=$bd->fetch_array($SQL)){
	echo $row['id_ord'].",".$row['nom_ord']."|";
}

	


?>