<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
$project_path = dirname(__FILE__);
$project_path = str_replace('includes', '', $project_path);
defined('SITE_ROOT') ? null : 
	define('SITE_ROOT',$project_path);
	
defined('SITE_PATH') ? null : 
	define('SITE_PATH',dirname($_SERVER['PHP_SELF']));
    
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.'includes');

// charger fichier config  avant tout
require_once(LIB_PATH.DS.'config.php');

// charger fonctions
require_once(LIB_PATH.DS.'fonctions.php');

// charger core objects
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'bd.php');

// charger  classes
require_once(LIB_PATH.DS.'personne.php');
require_once(LIB_PATH.DS.'chapitre.php');
require_once(LIB_PATH.DS.'infrastructure.php');
require_once(LIB_PATH.DS.'localisation.php');
require_once(LIB_PATH.DS.'operation.php');
require_once(LIB_PATH.DS.'ordonnateur.php');
require_once(LIB_PATH.DS.'prog_geste.php');
require_once(LIB_PATH.DS.'projet.php');
require_once(LIB_PATH.DS.'rubrique.php');
require_once(LIB_PATH.DS.'secteur.php');
require_once(LIB_PATH.DS.'situation_f.php');
require_once(LIB_PATH.DS.'situation_ph.php');
require_once(LIB_PATH.DS.'sous_secteur.php');
require_once(LIB_PATH.DS.'structure.php');
require_once(LIB_PATH.DS.'type_programme.php');
require_once(LIB_PATH.DS.'wilayas.php');
require_once(LIB_PATH.DS.'operation_modification.php');
require_once(LIB_PATH.DS.'projet_supr.php');
require_once(LIB_PATH.DS.'actualite.php');
require_once(LIB_PATH.DS.'message.php');
require_once(LIB_PATH.DS.'operation_cloture.php');









//require_once(LIB_PATH.DS.'contact_us.php');




?>