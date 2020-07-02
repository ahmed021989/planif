<?php
require_once("../../includes/initialiser.php");
if(!$session->is_logged_in()) {

	//readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' );
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page  ccsdcsdc";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
		exit();
	} 

}
?><?php 

$id = $_GET['id'];
	if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
	$id= $_GET['id'];}
		 $pers =  Personne::trouve_par_id($id); 
		 
	
	


if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
	$code= $_GET['id'];}	
		 if (!empty($code)){ 
 
$errors = array();
   // crearion de l'objet 


include_once('barcode/pi_barcode.php');
  
// instanciation
$bc = new pi_barcode();
$pcode = $code ;  
// Le code a générer
$bc->setCode($pcode);
// Type de code : EAN, UPC, C39...
$bc->setType('C128');
// taille de l'image (hauteur, largeur, zone calme)
//    Hauteur mini=15px
//    Largeur de l'image (ne peut être inférieure a
//        l'espace nécessaire au code barres
//    Zones Calmes (mini=10px) à gauche et à droite
//        des barres
$bc->setSize(30, 250, 30);
  
// Texte sous les barres :
//    'AUTO' : affiche la valeur du codes barres
//    '' : n'affiche pas de texte sous le code
//    'texte a afficher' : affiche un texte libre
//        sous les barres


$bc->setText('');
  
// Si elle est appelée, cette méthode désactive
// l'impression du Type de code (EAN, C128...)
$bc->hideCodeType();
  
// Couleurs des Barres, et du Fond au
// format '#rrggbb'
$bc->setColors('#123456', '#FFFFFF');
// Type de fichier : GIF ou PNG (par défaut)
$bc->setFiletype('PNG');
  
// envoie l'image dans un fichier
//$bc->writeBarcodeFile('barcode/'.sprintf('%08d', $patient->id).'.png');
$bc->writeBarcodeFile('barcode/'.$pcode.'.png');
// ou envoie l'image au navigateur
// $bc->showBarcodeImage();
  
/* ***************************************** */


 
 }else{
  $msg_error = "eroure d'accèes !!!";
 }
 
 	
		
?><?php 

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
$pdf->SetTitle('Compte');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, compte');





// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor



// set some language dependent data:


// ---------------------------------------------------------

// set font


// add a page
$pdf->AddPage();

$htmlpersian='<h4 style="text-align:center">REPUBLIQUE ALGERIENNE DEMOCRATIQUE ET POPULAIRE<br>';
$htmlpersian.='MINISTERE DE LA SANTE, DE LA POPULATION ET DE LA REFORME HOSPITALIERE
<br>';
$htmlpersian.='Direction des Etudes et de la Planification 
<br></h4>';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);
$htmlpersian='<br><h2 style="color:#e8222a;text-align:center">Informations d’accès à GSPI </h2><br><hr><br><br>';
$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

$id = $_GET['id'];
$htmlpersian="";
$SQL = $bd->requete("SELECT * FROM `personne` ,`ordonnateur` where personne.id_ord=ordonnateur.id_ord and personne.id=".$id."");
															while ($rows = $bd->fetch_array($SQL))
														{
														
													$htmlpersian.='<br><h1 style="color:rgb(255,255,255);background-color:#1caf9a;text-align:center"> '.$rows["nom_ord"].'  : '.$rows["wilaya"].' </h1><br><br>';
														}
														


$pdf->WriteHTML($htmlpersian, true, 0, true, 0);










$id = $_GET['id'];
$htmlpersian="";
$htmlpersian.='<br><br><h2 style=";float:right">Adresse URL: http://planif.sante.gov.dz </h2> ';
$SQL = $bd->requete("SELECT * FROM `personne` where id=".$id." ");
															while ($rows = $bd->fetch_array($SQL))
														{
													
													$htmlpersian.="<h2>Nom : ".$rows["nom"]." <br><br>Prénom: ".$rows["prenom"]."<br><br>Mobile: ".$rows["telephone"]."<br><br>";
													$htmlpersian.="Utilisateur: ".$rows["login"]."<br><br>";
													$htmlpersian.="Mot de passe : ".$rows["cpt"]." <br></h2>";
														}
														


$pdf->WriteHTML($htmlpersian, true, 0, true, 0);

 $img_file = 'barcode/'.$pcode.'.png';
$pdf->Image($img_file, '100', '100', '120', '10', '', '0', '0', false, '', '0', false, false, 0);

$htmlpersian11='<br><br><br><h3 style="text-align:right">LE Directeur <br>';
$pdf->WriteHTML($htmlpersian11, true, 0, true, 0);
// print newline
//$pdf->Ln();



 

// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('compte.pdf', 'I');



//============================================================+
// END OF FILE
//============================================================+
?>
