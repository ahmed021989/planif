<?php
 // namespace Chirp;

  // Original PHP code by Chirp Internet: www.chirp.com.au
  // Please acknowledge use of this code by including this header.
require_once("../../includes/initialiser.php");

	$user = Personne::trouve_par_id($session->id_utilisateur);
$accestype = array('administrateur' or 'Admin_psc' or 'Admin_psd' or'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
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
$pdf->SetTitle('Etat physique');
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

 $date = ($_GET['date']);

	 $html='<p><h3 style="text-align:center"> Etat physique du programme en cours arrete au :'.fr_date2($date).'</h3></p>'; 
     $pdf->WriteHTML($html, true, 0, true, 0);
	 
	 $html='<br><table border="1"  style="border:1px solid black;text-align:left">
	 <tr><td>Infrastructures </td><td>Projets en étude</td><td>Projets gelés</td><td>Projets en cours</td><td>Projets achevés</td><td >Total</td></tr>';
	
	//$pdf->WriteHTML($html, true, 0, true, 0);
	
								$infra=Infrastructure::trouve_tous();
									
		$TOTAL1=0;	$TOTAL2=0;	$TOTAL3=0;	$TOTAL4=0;						
foreach($infra as $infra){
	$i=0; $j=0;  $k=0; $a=0; $h=0; 
	
	$projet=Projet::trouve_tous_infra($infra->id_infra);
	
	foreach($projet as $projet){
		if($situation_phs=Situation_ph::trouve_par_projet2($projet->id_projet,$date)){
			foreach($situation_phs as $situation_ph){
		if($situation_ph->etat_projet=="en_cours"){
		
			++$i;
		}else
		if($situation_ph->etat_projet=="gelee"){
			++$j;
		}else
		if($situation_ph->etat_projet=="acheve"){
			++$a;
		}else
		
		if($situation_ph->etat_projet=="etude"){
			++$h;
		}
			
		}
		}
		
		
		
		
		

	}
	if(($i!=0) or ($j!=0) or ($a!=0) or ($h!=0)){
		$TOTAL1=$TOTAL1+$h; $TOTAL2=$TOTAL2+$j; $TOTAL3=$TOTAL3+$i; $TOTAL4=$TOTAL4+$a; 
				$html.='<tr><td> '.$infra->nom_infra.' </td> <td> '.$h.' </td><td> '.$j.' </td><td> '.$i.'  </td><td> '.$a.'  </td><td> '.($h+$j+$i+$a).' </td></tr>';										 
	}
}
	$html.='<tr><td> '.TOTAL.' </td> <td> '.$TOTAL1.' </td><td> '.$TOTAL2.' </td><td> '.$TOTAL3.'  </td><td> '.$TOTAL4.'  </td><td> '.($TOTAL1+$TOTAL2+$TOTAL3+$TOTAL4).' </td></tr>';										 

	
	
	
						
	
                              




$html.='</table>';
$pdf->WriteHTML($html, true, 0, true, 0);
// print newline
//$pdf->Ln();



 

// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('Etat physique.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+
?>
