<?php

require_once('bd.php');
require_once('fonctions.php');

class    Situation_f {
	
	protected static $nom_table="situation_f";
	protected static $champs = array('id_situation_f','date_situation_f','ap_engag','paiements','etat_operation','obs','id_op','situation','etat_gelee','valider','last');
	public $id_situation_f;
	public $date_situation_f;
	public $ap_engag;
	public $paiements;
	public $etat_operation;
	public $obs;
	public $id_op;
	public $situation;
	public $etat_gelee;
    public $valider;
	 public $last;



	
	
	
	
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
   // $sql .= "WHERE id_op = '".$this->id_op."' ";
	// $sql .= " AND pec = '".$this->pec."' ";

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
	
	
	
	
	
	
	
	// les fonction commun entre les classe
	public static function trouve_tous() {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table);
  }
  	public static function trouve_par_operation($id) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_op='".$id."' order by id_situation_f DESC limit 1");
  }
  	public static function is_trouve_par_operation($id) {
	
	  $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_op ={$id}    and  valider=1 LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;	
		}
			public static function is_clote($id) {
	
	  $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_op ={$id}  and etat_operation='Cloturee'  and  valider=1 LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;	
		}
			
  
  	public static function trouve_par_operation_tous($id) {
		return self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_op='".$id."' order by id_situation_f DESC  ");
  }
  
    public static function trouve_par_operation_tous_non_valide($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_op='".$id."' and valider=0 order by id_situation_f DESC limit 1 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function trouve_par_operation2($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_op='".$id."'  order by id_situation_f DESC limit 1 ");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
    public static function trouve_par_operation2_valider($id) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_op='".$id."' and valider=1  order by id_situation_f DESC limit 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
   public static function trouve_par_operation3($id,$date) {
	$d="";
	if(!$date){ $d="";}else{ $d=" and date_situation_f<='".$date."' ";}
	
		
	
	
	
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." where id_op='".$id."' ".$d." and etat_operation!='Cloturee'  and valider=1 order by id_situation_f DESC limit 1");
   
  
		return !empty($result_array) ? array_shift($result_array) : false;
		
  }
  
  public static function trouve_par_id($id=0) {
    $result_array = self::trouve_par_sql("SELECT * FROM ".self::$nom_table." WHERE id_situation_f ={$id} LIMIT 1");
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
	 return isset($this->id_situation_f)? $this->modifier() : $this->ajouter();
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
$sql .= " WHERE id_situation_f =". $bd->escape_value($this->id_situation_f) ;
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
$sql .= " WHERE id_situation_f =". $bd->escape_value($this->id_situation_f) ;
$sql .=" LIMIT 1";
$bd->requete($sql);
return($bd->affected_rows() == 1) ? true : false ;
	}

	}


?>