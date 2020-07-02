<?php

require_once('bd.php');
require_once('fonctions.php');

class  Operation {
	
	protected static $nom_table="operation";
	protected static $champs = array('id_op','libelle_op','num_op','num_dp','ap_initial','date_inscription','code_rubrique','code_type_prog','topographie','id_ord','id_ss','id_projet','valider','user','date_demande','date_valide');
	public $id_op;
	public $libelle_op;
	public $num_op;
	public $num_dp;
	public $ap_initial;
	public $date_inscription;
	public $code_rubrique;
	public $code_type_prog;
	public $topographie;
	public $id_ord;
	public $id_ss;
	public $id_projet;
	public $valider;
	public $user;
	public $date_demande;
	public $date_valide;
	
	
   


	
	
	
	
  public function nom_compler() {
    if(isset($this->nom) && isset($this->prenom)) {
      return $this->nom . " " . $this->prenom;
    } else {
      return "";
    }
  }
	public static function count_util(){
		global $bd;
		$q =  "SELECT count(*) FROM ".self::$nom_table;
		$q .= " WHERE type !='administrateur' "; 
		
		$result_array = $bd->requete($q);
		return !empty($result_array) ? $bd->num_rows($result_array): false;
	}
	
	public static function valider($login="", $mot_passe="") {
    global $bd;

    $sql  = "SELECT * FROM ".self::$nom_table." ";
    $sql .= "WHERE login = '{$login}' ";
    $sql .= "AND mot_passe = '".SHA1($mot_passe)."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public function date_der(){
	global $bd;
     $sql  = "UPDATE ".self::$nom_table." SET ";
     $sql .= "date_der  = '".mysql_datetime()."' ";
	 $sql .= " WHERE id =".$this->id." ";
	 $sql .= "LIMIT 1 ";
	
	 $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public  function  existe(){
	 global $bd;
	 $sql  = "SELECT * FROM ".self::$nom_table." ";
   // $sql .= "WHERE num_op = '".$this->num_op."' ";
	//$sql .= "OR email = '".$this->email."' ";
    $sql .= "LIMIT 1";
    $result_array = self::trouve_par_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	

	public static function count(){
	
	$users = self::not_admin();
	return count($users);
	}
	
	public static function not_sup_admin(){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type !='super_administrateur'";
    return  self::trouve_par_sql($q);
	}
	public static function ens(){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type ='Enseignant'";
    return  self::trouve_par_sql($q);
	}
	public static function eleve(){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type ='eleve'";
    return  self::trouve_par_sql($q);
	}
	
	
	public static function select_par_ordre1($order,$crois,$start,$display){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type !='administrateur'";
	$q .= " ORDER BY {$order} {$crois} ";
	$q .= " LIMIT {$start}, {$display} "; 
	return  self::trouve_par_sql($q);
	}
	
	public static function not_admin(){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type !='administrateur'";
    return  self::trouve_par_sql($q);
	}
	
	public static function trouve_par_type($type){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type ='{$type}'";
    return  self::trouve_par_sql($q);
	}
	
	
	public static function select_par_ordre($order,$crois,$start,$display){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type !='administrateur'";
	$q .= " AND type !='super_administrateur'";
	$q .= " ORDER BY {$order} {$crois} ";
	$q .= " LIMIT {$start}, {$display} "; 
	return  self::trouve_par_sql($q);
	}
	
	public static function select_par_ordre_type($order,$crois,$start,$display,$type){
	$q =  "SELECT * FROM ".self::$nom_table;
	$q .= " WHERE type ='{$type}'";
	$q .= " ORDER BY {$order} {$crois} ";
	$q .= " LIMIT {$start}, {$display} "; 
	return  self::trouve_par_sql($q);
	}
	
	
	
	// les fonction commun entre les classe
	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table);
  }
  public static function trouve_tous_valider() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where valider=0");
  }
   public static function trouve_tous_valider_ok($ord) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where valider=1 and id_ord=".$ord."");
  }
  public static function trouve_tous_op_refuse() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where valider=3");
  }
  public static function trouve_filtre_ord($ordre) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_ord=".$ordre." and valider=1 order by code_rubrique");
  }
  
  public static function trouve_tous_projet($id_projet) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_projet=".$id_projet." and valider=1");
  }
   public static function trouve_tous_projet_rub($id_projet,$rub,$ord) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_projet=".$id_projet." and code_rubrique='".$rub."' and id_ord=".$ord." and valider=1");
  }
  
   public static function trouve_tous_projet2($id_projet) {
		return self::trouve_par_sql("SELECT * FROM operation,situation_f where operation.id_projet=".$id_projet." and situation_f.id_op=operation.id_op and situation_f.etat_gelee!=-2 and operation.valider=1");
  }
  
    public static function trouve_par_rubrique($code_rubrique,$id_ord) {
		if($code_rubrique=='tous'){
					return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where  id_ord={$id_ord} and valider=1");
		}
else{
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where code_rubrique='".$code_rubrique."' and id_ord={$id_ord} and valider=1 ");
}
  }
    public static function trouve_tous_rubrique2($code_rubrique,$id) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where code_rubrique='".$code_rubrique."' AND id_ord=".$id." and valider=1 ");
  }
    public static function trouve_tous_rubrique($code_rubrique) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where code_rubrique='".$code_rubrique."' and valider=1 ");
  }
  
  public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE valider=1 and id_op ={$id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function trouve_par_num_op($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE valider=1 and num_op ='{$id}' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
 
 
 
 
 
 
 
 
 
  
  // pour que ne tompa dans des erreurs foux qu'on selection tous "SELECT * FROM" 
  public static function trouve_par_sql($sql="") {
    global $bd;
    $result_set = $bd->requete($sql);
    $object_array = array();
    while ($row = $bd->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
	/* // on peu utiliser la fonction predefinit mysqli_fetch_object
	   // mais dans le cas où il y a de jointure dans la requete.... 
	while ($object = $bd->fetch_object($result_set)){
	  $object_array[] = $object;
	}
	*/
    return $object_array;
  }

	private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// Simple, long-form approach:
		// $object->id 				= $record['id'];
		// $object->login 	= $record['login'];
		// $object->mot_passe 	= $record['mot_passe'];
		// $object->nom = $record['nom'];
		// $object->prenom 	= $record['prenom'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // get_object_vars returns an associative array with all attributes 
	  // (incl. private ones!) as the keys and their current values as the value
	  $object_vars = $this ->attributes();
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $object_vars);
	}

	public function save(){
	 // A new record won't have an id yet.
	 return isset($this->id_op)? $this->modifier() : $this->ajouter();
	}
	
	protected function attributes(){
	// return an array of attribute keys and their values
	 $attributes = array();
	 foreach(self::$champs as $field){
	     if(property_exists($this, $field)){
		     $attributes[$field] = $this->$field; 
		 }
	 }
	 return $attributes;
	}
	
	protected function sanitized_attributes(){
	 global $bd;
	 $clean_attributes = array();
	 // sanitize the values before submitting
	 // note : does not alter the actual value of each attribute
	 foreach($this->attributes() as $key => $value){
	   $clean_attributes[$key] = $bd->escape_value($value);
	 }
	  return $clean_attributes;
	}
	
	public function ajouter(){
	 global $bd;
	 $attributes = $this->sanitized_attributes();
	 $sql = "INSERT INTO ".self::$nom_table."(";
	 $sql .= join(", ", array_keys($attributes));
	 $sql .= ") VALUES (' ";
	 $sql .= join("', '", array_values($attributes));
	 $sql .= "')";
	 if($bd->requete($sql)){
	     $this->id = $bd->insert_id();
		 return true;
	 }else{
	     return false;
	 }
	}
	
    public function modifier(){
global $bd;
$attributes = $this->sanitized_attributes();
$attribute_pairs = array();
foreach($attributes as $key => $value){
 $attribute_pairs[] = "{$key}='{$value}'";
}
$sql = "update ".self::$nom_table." SET ";
$sql .= join(", ", $attribute_pairs);
$sql .= " WHERE id_op =". $bd->escape_value($this->id_op) ;
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
}
	    public function modifier_num(){
global $bd;
$attributes = $this->sanitized_attributes();
$attribute_pairs = array();
foreach($attributes as $key => $value){
 $attribute_pairs[] = "{$key}='{$value}'";
}
$sql = "update ".self::$nom_table." SET ";
$sql .= " num_cnas_etab = '".$this-> num_cnas_etab."' ";
$sql .= " WHERE id =". $bd->escape_value($this->id) ;
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
}
	
public function supprime(){
global $bd;
$sql = "DELETE FROM ".self::$nom_table;
$sql .= " WHERE id_op =". $bd->escape_value($this->id_op) ;
$sql .=" LIMIT 1";
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
	}

	}
	


?>