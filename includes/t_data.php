<?php

require_once(LIB_PATH.DS.'database.php');


class T_data{ // extended because late static bindings (common database methods find_by_id,sql... )
	
	protected static $table_name="t_data";
	protected static $db_fields = array('id','cus_id', 'year_month', 'date', 'weight','total_weight');
	
	public $id;
    public $cus_id;
	public $year_month;
	public $date;
	public $weight;
	public $total_weight;
 
  public function enter_t_data(){
        global $database;
		$attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO `t_data` (";
		$sql .= "`id`,`cus_id`,`year_month`,`date`,`weight` ";
        $sql .= ") VALUES (NULL,'";
		$sql .= $database->escape_value($this->cus_id)."', '";
		$sql .= $database->escape_value($this->year_month)."', '";
		$sql .= $database->escape_value($this->date)."', '";
		$sql .= $database->escape_value($this->weight)."')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
	}
  
    public function create_table() {
		global $database;
		$sql1="CREATE TABLE `$this->year_month` ( cus_id int(11),total_weight int(11) ,PRIMARY KEY(cus_id))";
        $result1=$database->query($sql1);
		if($result1){
			return true;
		}else{
			return false;
		}
	}
	
	public function cal_totals(){
		global $database;

		$result = mysql_query("SHOW TABLES LIKE '$this->year_month'");
		$tableExist = mysql_num_rows($result) > 0;
			if($tableExist){
				//echo '<script language="javascript">';
				//echo 'alert("Total already calculated!")';
				//echo '</script>';
			}else{
				$sql1="CREATE TABLE `$this->year_month` (cus_id int(11),total_weight int(11) ,PRIMARY KEY(cus_id))";
				$result1=$database->query($sql1);
				
				$sql4="SELECT id FROM `user` WHERE privilege='Customer'";
				$result4=$database->query($sql4);
				
				while($user = mysql_fetch_array($result4,MYSQL_ASSOC)){
					$sql1="SELECT weight FROM `t_data` WHERE cus_id=$user[id] AND `year_month`=$this->year_month";
					$result1=$database->query($sql1);
					$total_weight=0;
					while($data= mysql_fetch_array($result1,MYSQL_ASSOC)){
						$total_weight+=$data['weight'];
					}
					//echo $total_weight;
					
					$sql5= "INSERT INTO `$this->year_month` (cus_id,total_weight) VALUES('$user[id]','$total_weight') ";
					$res=$database->query($sql5);
				}
				return $res;
			}
	}
	
	public function get_totals(){
		global $database;
	    $sql = "SELECT * FROM `{$this->year_month}`";
		$arr=self::find_by_sql($sql);
		return $arr;
	}

	/////////////////////////////////////////////////////////////////////////////
	// Common Database Methods
    public static function find_all(){
		global $database;
	    $sql = "SELECT * FROM t_data";
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
		// Could check that $record exists and is an array
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