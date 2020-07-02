<?php
require_once("includes/initialiser.php");
if(!$session->is_logged_in()) {

	readresser_a("login.php");

}else{
	$user = Personne::trouve_par_id($session->id_utilisateur);
	$accestype = array('administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est');
	if( !in_array($user->type,$accestype)){ 
		//contenir_composition_template('simple_header.php'); 
		$msg_system ="vous n'avez pas le droit d'accéder a cette page <br/><img src='../images/AccessDenied.jpg' alt='Angry face' />";
		echo system_message($msg_system);
		// contenir_composition_template('simple_footer.php');
			exit();
	} 
	} 
?>
<?php

if ( (isset($_GET['id_projet'])) && (is_numeric($_GET['id_projet'])) ) {
$id = $_GET['id_projet'];
	
	
}



	
	$errors = array();
	
	
	
	
	
	

	
	
	// new object document
	$projet_supr = new  Projet_supr();
		$projet=Projet::trouve_par_id($_GET['id_projet']);
	
     $projet_supr-> id_projet=($_GET['id_projet']);
	$projet_supr-> nom_projet=  $projet->nom_projet;


	$projet_supr-> id_infra = $projet->id_infra;

	$projet_supr-> id_ord = $projet->id_ord;
 $projet_supr-> user =$user->nom_compler();

	$projet_supr-> valide =0;
	$dat=date('Y-m-d H:i');
	$projet_supr-> date_demande =$dat;
	
	$infra=Infrastructure::trouve_par_id($projet->id_infra);
	
	if (empty($errors)){
   		
			echo $projet_supr->save();
 		echo '<script>  alert(\'votre demande de suppression   a été envoyée\');  
window.location.replace("ajouter_projet.php?code_struct='.$infra->code_structure.'");		</script>';
		//readresser_a("ajouter_projet.php");
		
 		 
 		}else{
		// errors occurred
		$msg_error = '<h3>  Erreur  !!??? </h3>';
	    foreach ($errors as $msg) { // Print each error.
	    	$msg_error .= " $msg<br />\n";
	    }
	    $msg_error .= '</p>';	  
	}


?>
<?php
$titre = "Ajouter  projet_supr";
$active_menu = "index";
$header = array('projet_supr');
if ($user->type =='administrateur' or 'Admin_dsp' or 'Admin_ehs'or 'Admin_chu'or 'Admin_est'){
	require_once("composit/header.php");
}
?>







