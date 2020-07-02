<?php
 // namespace Chirp;

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
$accestype = array('administrateur' or 'ministre_SG' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
	if( !in_array($user->type,$accestype)){ 
	
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="Accès non autorisé! <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 
 list($rubrique, $ord,$date,$etat) = explode("|",$_GET['var']);
 
	 $rub=Rubrique::trouve_par_code($rubrique);
	$ordonnateur=Ordonnateur::trouve_par_id($ord);
	
$excel = "";
   if($ordonnateur->id_prog==42){
$excel .=  utf8_decode("Ordonnateur\tN° Opération \tIntitulé\tType programme\tDate inscription\tAP initial\tAP actuelle\tEngagement\tPaiements\tPEC\tTaux\tObservation \n");
   }
   else{
$excel .=  utf8_decode("Ordonnateur\tN° Opération \tIntitulé\tDate inscription\tAP initial\tAP actuelle\tEngagement\tPaiements\tPEC\tTaux\tObservation \n");
 	   
   }
	

	 

	//$pdf->WriteHTML($html, true, 0, true, 0);
	
									$operations=Operation::trouve_par_rubrique($rubrique,$ord);
foreach($operations as $operation){
			if($situation_f = Situation_f::trouve_par_operation3($operation->id_op,$date)){
			if($etat==$situation_f->etat_operation or $etat=="tous" ){
				$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);

								if($situation_f->etat_operation!='Cloturee'   and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type=='ministre_SG' or $user->id_ord==$operation->id_ord)  and $ord==$operation->id_ord and $ordonnateur->id_prog==42){
								
									  $APacc=0;
									if(  $operation=Operation::trouve_par_id($situation_f->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									$type_pro="";
									   if($ordonnateur->id_prog==42){
											    //echo html_entity_decode($operation->code_type_prog);
										$top="";
									if($operation->topographie=="PN") $top="Programme normal";
									if($operation->topographie=="PHP") $top="Programme spécial hauts plateaux";
									if($operation->topographie=="PS") $top="Programme spécial Sud";
												 $type_pro=html_entity_decode($top); 
											 } 
									   $operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									   $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord);
									  // $operation = Operation:: trouve_par_id($situation_f->id_op);
									   	if ($APacc!=0){$taux =(number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else { $taux =0.00;}
	    $excel.=utf8_decode($ordonnateur->nom_ord."\t".$operation->num_op."\t".$operation->libelle_op."\t".$type_pro."\t".$operation->date_inscription."\t".$operation->ap_initial."\t".$APacc."\t".$situation_f->ap_engag."\t".$situation_f->paiements."\t".($APacc-$situation_f->paiements)."\t".$taux."\t".$situation_f->obs."\n");
								}
								
								if($situation_f->etat_operation!='Cloturee'   and($user->type=='Admin_psc'  or $user->type=='administrateur' or $user->type=='ministre_SG' or $user->id_ord==$operation->id_ord)  and $ord==$operation->id_ord and $ordonnateur->id_prog==41){
									
									  $APacc=0;
									if(  $operation=Operation::trouve_par_id($situation_f->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									
											
									
									// $type_pro=Type_programme::trouve_par_code($operation->code_type_prog);
									   $operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   
									   }
									   $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord);
									   //$operation = Operation:: trouve_par_id($situation_f->id_op);
									   if ($APacc!=0){$taux =(number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else $taux =0.00;
	    $excel.=utf8_decode($ordonnateur->nom_ord."\t".$operation->num_op."\t".$operation->libelle_op."\t".$operation->date_inscription."\t".$operation->ap_initial."\t".$APacc."\t".$situation_f->ap_engag."\t".$situation_f->paiements."\t".($APacc-$situation_f->paiements)."\t".$taux."\t".$situation_f->obs."\n");
								}
								
								
			}
}
			else{
		//	if(($have_sf=Situation_f::is_trouve_par_operation($operation->id_op)==false) and ($etat=="tous" or $etat=='En cours')){	
			if(($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type == 'ministre_SG' or $user->id_ord==$operation->id_ord) and   $ord==$operation->id_ord and $ordonnateur->id_prog==42){
                         $APacc=0;
									if(  $operation=Operation::trouve_par_id($operation->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									$type_pro="";
									   if($ordonnateur->id_prog==42){
											    //echo html_entity_decode($operation->code_type_prog);
										$top="";
									if($operation->topographie=="PN") $top="Programme normal";
									if($operation->topographie=="PHP") $top="Programme spécial hauts plateaux";
									if($operation->topographie=="PS") $top="Programme spécial Sud";
												 $type_pro=html_entity_decode($top); 
											 } 
									   $operation_modifs=Operation_modif::trouve_tous_reev($operation->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   
									   }
									   $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord);
									  
									  
	    $excel.=utf8_decode($ordonnateur->nom_ord."\t".$operation->num_op."\t".$operation->libelle_op."\t".$type_pro."\t".$operation->date_inscription."\t".$operation->ap_initial."\t".$APacc."\t0\t0\t".($APacc)."\t0.00%\t \n");
				
			}
            else 
				
			
				if(($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type == 'ministre_SG' or $user->id_ord==$operation->id_ord) and   $ord==$operation->id_ord and $ordonnateur->id_prog==41){
      $APacc=0;
									if(  $operation=Operation::trouve_par_id($operation->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									
									   $operation_modifs=Operation_modif::trouve_tous_reev($operation->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   
									   }
									   $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord);
									  
									  
	    $excel.=utf8_decode($ordonnateur->nom_ord."\t".$operation->num_op."\t".$operation->libelle_op."\t".$operation->date_inscription."\t".$operation->ap_initial."\t".$APacc."\t0\t0\t".($APacc)."\t0.00%\t \n");
		
                 }	
			
			}
}
$ordo=Ordonnateur::trouve_par_id($ord);
$date_d="";
	if(!$date){
	$date_d=date('d-m-Y');	
	}
	else
	{
		$date_d=$date;
	}
	$e="";
	if($etat=="En cours"){
		$e=" des opérations en cours ";
	}
	if($etat=="Gelee"){
		$e=" des opérations gelées ";
	}
	$rubr="";
	if($rubrique=="tous"){
		$rubr=" ";
	}
	else{
		$rubr=" par rubrique ".$rub->nom_rubrique;
	}
header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Transfer-Encoding: text/xls\n"); 
header("Content-disposition: attachment; filename=état d'avancement".$e.$rubr." de ".$ordo->nom_ord." arrête le ".$date_d.".xls");
header("Pragma: no-cache");
	header("Expires: 0");

print $excel;
exit;
?>
