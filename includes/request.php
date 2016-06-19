<?php
require_once(LIB_PATH.DS.'database.php');

class Request{
	protected static $table_name="fertilizer_req";
	protected static $db_fields = array('req_id', 'id', 'fer_type', 'name', 'quantity', 'date');

    public $req_id;
	public $cuz_id;
	public $fer_type;
	public $name;
	public $quantity;
    public $date;
	
    public function create() {
		global $database;
		
		$sql = "INSERT INTO ".self::$table_name." (";
		$sql .= "id, fer_type, name, quantity, date ";
		$sql .= ") VALUES ('";
		$sql .= $database->escape_value($this->cuz_id)."', '";
		$sql .= $database->escape_value($this->fer_type)."', '";
		$sql .= $database->escape_value($this->name)."', '";
		$sql .= $database->escape_value($this->quantity)."', '";
		$sql .= $database->escape_value($this->date)."')";
		
	if($database->query($sql)) {
	    return true;
	  } else {
	    return false;
	  }
	}
	
	public function update() {
	  global $database;

		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .="fer_type='{$this->fer_type}', ";
		$sql .="name='{$this->name}', ";
		$sql .="quantity='{$this->quantity}', ";
		$sql .="date='{$this->date}' ";
		$sql .= " WHERE req_id=".$this->req_id;
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
  public static function find_all(){
		global $database;
	    $sql = "SELECT * FROM fertilizer_req";
		$arr=self::find_by_sql($sql);
		return $arr;
	}
  public static function find_by_id($r_id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE req_id={$r_id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
  }
  
  public static function find_by_sql($sql="") {
    global $database;
    $result_set = $database->query($sql);
    $object_array = array();
    while ($row = $database->fetch_array($result_set)) {
      $object_array[] = self::instantiate($row);
    }
    return $object_array;
  }
  
  private static function instantiate($record) {
		// Could check that $record exists and is an array
    $object = new self;
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
	  // We don't care about the value, we just want to know if the key exists
	  // Will return true or false
	  return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
	  $attributes = array();
	  foreach(self::$db_fields as $field) {
	    if(property_exists($this, $field)) {
	      $attributes[$field] = $this->$field;
	    }
	  }
	  return $attributes;
	}
	
	public static function del_req($id){
	 global $database;

	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE req_id=". $id;
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
  }
	
}

