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



require_once('tcpdf_include.php');


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('author');
$pdf->SetTitle('Infrastructures réceptionnées');
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




// ---------------------------------------------------------


// add a page

$pdf->AddPage('L', 'A4');
//$pdf->Cell(0, 0, 'A5 LANDSCAPE', 1, 1, 'C');

 //$date = ($_GET['date']);
 list($date,$date1)=explode('|',$_GET['date']);

	 $html='<p><h3 style="text-align:center"> Infrastructures réceptionnées Du : '. fr_date2($date).' Au :'.fr_date2($date1).' </h3></p>'; 
     $pdf->WriteHTML($html, true, 0, true, 0);
	 
	 $html='<br><table border="1"  style="border:1px solid black;text-align:left">
	 <tr><td> DSP/Infrastructures </td>';
	$infra=Infrastructure::trouve_tous();
											foreach($infra as $infra){
											if($infra->existe_in_projet($infra->id_infra,$date,$date1)){
											$html.="<td>".$infra->nom_infra."</td>";
											}												
												
											}
		$html.='</tr>';									

	$wil=Wilayas::trouve_tous();
	
	foreach($wil as $wil){
    $html.='<tr>';
											 $html.='<td  style="font-size:12px;color:black">'.$wil->wilaya.'</td>';
										
								 list($date,$date1)=explode('|',$_GET['date']);
											$infra=Infrastructure::trouve_tous();
											foreach($infra as $infra){
											if($infra->existe_in_projet($infra->id_infra,$date,$date1)){
										$sql=$bd->requete("select * from projet,infrastructure,ordonnateur where   ordonnateur.wilaya='".$wil->wilaya."' and projet.id_ord=ordonnateur.id_ord and infrastructure.id_infra=projet.id_infra and infrastructure.id_infra=".$infra->id_infra." and projet.date_reception>='".$date."' and projet.date_reception<='".$date1."' ");
										$nbr1=mysqli_num_rows($sql);
										$html.='<td>'.$nbr1.'</td>';
											}												
												
											}
		  $html.='</tr>';
										
                     } 
	
$html.='</table>';
$pdf->WriteHTML($html, true, 0, true, 0);
// print newline
//$pdf->Ln();



 

// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('Infrastructures réceptionnées.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+
?>
