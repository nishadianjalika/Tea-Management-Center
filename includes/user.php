<?php

require_once(LIB_PATH.DS.'database.php');


class User { // extended because late static bindings (common database methods find_by_id,sql... )
	
	protected static $table_name="user";
	protected static $db_fields = array('id', 'f_name', 'l_name', 'nic', 'username' ,'password','privilege','contact_no','email','loan');
	
	public $id;
	public $f_name;
	public $l_name;
	public $nic;
	public $username;
	public $password;
    public $privilege;
    public $contact_no;
	public $email;
	public $loan;
	
  public function full_name() {
    if(isset($this->f_name) && isset($this->l_name)) {
      return $this->first_name . " " . $this->last_name;
    } else {
      return "";
    }
  }
  

  
	public static function authenticate($username="", $password="") {
    global $database;
    $username = $database->escape_value($username);
    $password = $database->escape_value($password);

    $sql  = "SELECT * FROM users ";
    $sql .= "WHERE username = '{$username}' ";
    $sql .= "AND hashed_password = '{$password}' ";
    $sql .= "LIMIT 1";
    $result_array = self::find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function change_pw($new_pw,$staff_id){
		 global $database;

		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .="hashed_password='{$new_pw}' ";
		$sql .= " WHERE staff_id= '{$staff_id}' ";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
	
	public static function view_users(){
		global $database;
		$sql = "SELECT * FROM user ";
		$result_array = self::find_by_sql($sql);
			return !empty($result_array) ? $result_array : false;
	}

	/////////////////////////////////////////////////////////////////////////////
	// Common Database Methods
    public static function find_all(){
		global $database;
	    $sql = "SELECT * FROM user";
		$arr=self::find_by_sql($sql);
		return $arr;
	}
		public static function find_customers(){
		global $database;
	    $sql = "SELECT * FROM user WHERE privilege='Customer' ";
		$arr=self::find_by_sql($sql);
		return $arr;
	}
  
  public static function find_by_id($id=0) {
    $result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE id={$id} LIMIT 1");
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

	public static function count_all() {
	  global $database;
	  $sql = "SELECT COUNT(*) FROM ".self::$table_name;
    $result_set = $database->query($sql);
	  $row = $database->fetch_array($result_set);
    return array_shift($row);
	}

	private static function instantiate($record) {
    $object = new self;
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	
	private function has_attribute($attribute) {
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
	
	
	protected function sanitized_attributes() {
	  global $database;
	  $clean_attributes = array();
	  // sanitize the values before submitting
	  // Note: does not alter the actual value of each attribute
	  foreach($this->attributes() as $key => $value){
	    $clean_attributes[$key] = $database->escape_value($value);
	  }
	  return $clean_attributes;
	}
	
	
	public function save() {
	  // A new record won't have an id yet.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;

		$attributes = $this->sanitized_attributes();
	  $sql = "INSERT INTO ".self::$table_name." (";
		$sql .= "username, hashed_password, name, full_name, email, staff_id, privilege";
	  $sql .= ") VALUES ('";
		$sql .= $database->escape_value($this->username)."', '";
		$sql .= $database->escape_value($this->password)."', '";
		$sql .= $database->escape_value($this->name)."', '";
		$sql .= $database->escape_value($this->full_name)."', '";
		$sql .= $database->escape_value($this->email)."', '";
		$sql .= $database->escape_value($this->staff_id)."', '";
		$sql .= $database->escape_value($this->privilege)."')";
	  if($database->query($sql)) {
	    $this->id = $database->insert_id();
	    return true;
	  } else {
	    return false;
	  }
	}

	public function update() {
	  global $database;

		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
	
	

	public function delete() {
		global $database;
	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE id=". $database->escape_value($this->id);
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;

	}
	
	public static function del_user($id){
	global $database;

	  $sql = "DELETE FROM ".self::$table_name;
	  $sql .= " WHERE staff_id= '{$id}' ";
	  $sql .= " LIMIT 1";
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
  }

}

?>