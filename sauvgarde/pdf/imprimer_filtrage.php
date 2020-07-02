<?php
 // namespace Chirp;

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.
require_once("../../includes/initialiser.php");

	$user = Personne::trouve_par_id($session->id_utilisateur);
$accestype = array('administrateur' or 'ministre_SG' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
	if( !in_array($user->type,$accestype)){ 
	
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	 
	ob_start();
	
	
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).




require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('author');
$pdf->SetTitle('imprime_par rubrique');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, compte');





// set header and footer fonts
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont('');
$pdf->SetPrintHeader(false);
// set margins
$pdf->SetMargins(1, '5', 1);
$pdf->SetMargins(PDF_MARGIN_LEFT, '', PDF_MARGIN_RIGHT);

//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetFont('times', '', 10,'', 'false');
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor



// set some language dependent data:


// ---------------------------------------------------------

// set font


// add a page

$pdf->AddPage('L', 'A4');
//$pdf->Cell(0, 0, 'A5 LANDSCAPE', 1, 1, 'C');



	 list($rubrique,$ord,$date,$etat) = explode("|",$_GET['var']);
	 $rub=Rubrique::trouve_par_code($rubrique);
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
	
	
	 $html='<p><h3 style="text-align:center">Etat d\'avancement '.$e.'  '.$rubr.'  arrete au :'. $date_d.'</h3></p>'; 
	 $ordonnateur=Ordonnateur::trouve_par_id($ord);
	$html.='<span style="font-weight:bold;font-size:14px">'.$ordonnateur->nom_ord.'</span><br>';
	$pdf->WriteHTML($html, true, 0, true, 0);
	 
	 $html='<br><table border="1"  style="border:1px solid black;text-align:left">
	 <tr><td style="width:115px">N° Operation </td><td>Intitulé</td>';
	  if($ordonnateur->id_prog==42){
	  $html.='<td>Type programme</td>';
	  }
	  $html.='<td>Date d\'inscription</td><td>AP initiale</td><td>AP actuelle</td><td>Engagements</td><td>Paiements</td><td>PEC</td><td style="width:45px">Taux</td><td>Observation</td></tr>';
	
	//$pdf->WriteHTML($html, true, 0, true, 0);
	
			$operations=Operation::trouve_par_rubrique($rubrique,$ord);
            foreach($operations as $operation){
			if($situation_f = Situation_f::trouve_par_operation3($operation->id_op,$date)){
			if($etat==$situation_f->etat_operation or $etat=="tous" ){
				$ordonnateur=Ordonnateur::trouve_par_id($operation->id_ord);

								if($situation_f->etat_operation!='Cloturee'  and($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type=='ministre_SG' or $user->id_ord==$operation->id_ord)  and $ord==$operation->id_ord and $ordonnateur->id_prog==42){
								
									  $APacc=0;
									if(  $operation=Operation::trouve_par_id($situation_f->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									   $operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									   $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord);
									$type_pro="";
									   if($ordonnateur->id_prog==42){
											    //echo html_entity_decode($operation->code_type_prog);
										$top="";
									if($operation->topographie=="PN") $top="Programme normal";
									if($operation->topographie=="PHP") $top="Programme spécial hauts plateaux";
									if($operation->topographie=="PS") $top="Programme spécial Sud";
												 $type_pro=html_entity_decode($top); 
											 } 
									   $operation = Operation:: trouve_par_id($situation_f->id_op);
									   	if ($APacc!=0){$taux =(number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else $taux =0.00;
	$html.='<tr><td> '.$operation->num_op.' </td> <td> '.$operation->libelle_op.' </td><td> '.$type_pro.' </td><td> '.$operation->date_inscription.' </td><td> '.$operation->ap_initial.' </td><td> '.$APacc.' </td><td> '.$situation_f->ap_engag.' </td><td> '.$situation_f->paiements.' </td><td> '.($APacc-$situation_f->paiements).' </td><td> '.$taux.' </td><td> '.$situation_f->obs.' </td></tr>';										 
	//  $html='<tr><td>'.$ordonnateur->nom_ord.'</td> <td>'.$operation->libelle_op.'</td><td>'.$operation->code_type_prog.'</td><td>'.$operation->date_inscription.'</td><td>'.$operation->ap_initial.'</td><td>'.$APacc.'</td><td>'.$situation_f->paiements.'</td><td>'.($APacc-$situation_f->paiements).'</td><td>'.$taux.'</td><td>'.$situation_f->obs.'</tr>';

                              
}


if($situation_f->etat_operation!='Cloturee'  and($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type=='ministre_SG' or $user->id_ord==$operation->id_ord) and   $ord==$operation->id_ord and $ordonnateur->id_prog==41){
									
									  $APacc=0;
									if(  $operation=Operation::trouve_par_id($situation_f->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									
									   $operation_modifs=Operation_modif::trouve_tous_reev($situation_f->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   }
									 
																		   $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord);
									   $operation = Operation:: trouve_par_id($situation_f->id_op);
									   									   if ($APacc!=0){$taux =(number_format($situation_f->paiements/$APacc*100,2,'.','').'%');}else $taux =0.00;
	$html.='<tr> <td> '.$operation->num_op.' </td> <td> '.$operation->libelle_op.' </td><td> '.$operation->date_inscription.' </td><td> '.$operation->ap_initial.' </td><td> '.$APacc.' </td><td> '.$situation_f->ap_engag.' </td><td> '.$situation_f->paiements.' </td><td> '.($APacc-$situation_f->paiements).' </td><td> '.$taux.' </td><td> '.$situation_f->obs.' </td></tr>';										 

                                
}




			}
}
else {
	//if($have_sf=Situation_f::is_trouve_par_operation($operation->id_op)==false){
				if($user->type=='Admin_psd' or $user->type=='administrateur' or $user->type == 'ministre_SG' or $user->id_ord==$operation->id_ord and   $ord==$operation->id_ord and $ordonnateur->id_prog==42){
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
									  
									  
	  		$html.='<tr> <td> '.$operation->num_op.' </td> <td> '.$operation->libelle_op.' </td><td> '.$type_pro.' </td><td> '.$operation->date_inscription.' </td><td> '.$operation->ap_initial.' </td><td> '.$APacc.' </td><td> 0 </td><td> 0 </td><td> '.($APacc).' </td><td> 0.00% </td><td> 0 </td></tr>';										 

			}
            else 
				
			
				if($user->type=='Admin_psc' or $user->type=='administrateur' or $user->type == 'ministre_SG' or $user->id_ord==$operation->id_ord and   $ord==$operation->id_ord and $ordonnateur->id_prog==41){
      $APacc=0;
									if(  $operation=Operation::trouve_par_id($operation->id_op)){
									  $APacc=$APacc+$operation->ap_initial  ;
									}
									
								
									   $operation_modifs=Operation_modif::trouve_tous_reev($operation->id_op);
									   foreach($operation_modifs as $operation_modif){
										$APacc = $APacc+ $operation_modif->reev;
									   
									   }
									   $ordonnateur = Ordonnateur:: trouve_par_id($operation->id_ord);
									  
									  
	   $html.='<tr> <td> '.$operation->num_op.' </td> <td> '.$operation->libelle_op.' </td><td> '.$operation->date_inscription.' </td><td> '.$operation->ap_initial.' </td><td> '.$APacc.' </td><td> 0 </td><td> 0 </td><td> '.($APacc).' </td><td> 0.00% </td><td> 0 </td></tr>';										 

             //    }	
}
}
}
$html.='</table>';
$pdf->WriteHTML($html, true, 0, true, 0);
// print newline
//$pdf->Ln();



 

// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('imprime_par_rubrique.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+
?>
