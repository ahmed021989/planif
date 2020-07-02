<?php
 // namespace Chirp;

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
$accestype = array('administrateur' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
	if( !in_array($user->type,$accestype)){ 
	
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="Accès non autorisé! <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 
 list($date, $date1) = explode("|",$_GET['date']);
 
	// $excel='<p><h3 style="text-align:center"> Infrastructures réceptionnées Du : '. fr_date2($date).' Au :'.fr_date2($date1).' </h3></p>'; 
    
	 $excel = "";
	 $excel.='DSP Infrastructures ';
	$infra=Infrastructure::trouve_tous();
	foreach($infra as $infra){
											if($infra->existe_in_projet($infra->id_infra,$date,$date1)){
											$excel.="\t".utf8_decode($infra->nom_infra)."";
											}												
												
											}
	
$excel.= "\n";
//$excel .=  utf8_decode("Ordonnateur\tN° Operation \tintitulé\ttype programme\tdate inscription\tA P initial\tA P actuelle\tpaiements\tPEC\ttaux\tobservation \n");
	$wil=Wilayas::trouve_tous();
	
	foreach($wil as $wil){

											 $excel.=utf8_decode($wil->wilaya)."\t";
										
								 list($date,$date1)=explode('|',$_GET['date']);
											$infra=Infrastructure::trouve_tous();
											foreach($infra as $infra){
											if($infra->existe_in_projet($infra->id_infra,$date,$date1)){
										$sql=$bd->requete("select * from projet,infrastructure,ordonnateur where   ordonnateur.wilaya='".$wil->wilaya."' and projet.id_ord=ordonnateur.id_ord and infrastructure.id_infra=projet.id_infra and infrastructure.id_infra=".$infra->id_infra." and projet.date_reception>='".$date."' and projet.date_reception<='".$date1."' ");
										$nbr1=mysqli_num_rows($sql);
										$excel.=$nbr1."\t";
											}												
												
											}
		  $excel.="\n";
										
                     }
	

	 

	
								
								




 

	
 
 
header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Transfer-Encoding: text/xls\n"); 
header("Content-disposition: attachment; filename=infrastructures réceptionées.xls");
header("Pragma: no-cache");
	header("Expires: 0");

print $excel;
exit;
?>
