<?php

require_once(LIB_PATH.DS.'database.php');


class Bill{ // extended because late static bindings (common database methods find_by_id,sql... )
	
	protected static $table_name="payment";
	protected static $db_fields = array('bill_id','cus_id', 'year_month', 'rate', 'total_weight','value','advanced','payble','loan');
	
	public $bill_id;
    public $cus_id;
	public $year_month;
	public $rate;
	public $total_weight;
    public $value;
    public $advanced;
    public $payble;
    public $loan;
    
  public function enter_ad_data(){
        global $database;
		$attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO `advanced` (";
		$sql .= "`id`,`cus_id`,`year_month`,`advance` ";
        $sql .= ") VALUES (NULL,'";
		$sql .= $database->escape_value($this->cus_id)."', '";
		$sql .= $database->escape_value($this->year_month)."', '";
		$sql .= $database->escape_value($this->advanced)."')";
        if($database->query($sql)) {
            $this->id = $database->insert_id();
            return true;
        } else {
            return false;
        }
	}
	
	public function cal_bill(){
		global $database;
		$result = mysql_query("SHOW TABLES LIKE '$this->year_month'");
		$tableExist = mysql_num_rows($result) > 0;
			if($tableExist){
				$sql4="SELECT * FROM user WHERE privilege='Customer'";
				$result4=$database->query($sql4);
				
				while($user = mysql_fetch_array($result4,MYSQL_ASSOC)){
                    $this->loan=$user['loan'];
					$sql1="SELECT total_weight FROM `{$this->year_month}` WHERE cus_id=$user[id]";
					$result1=$database->query($sql1);
					$total_weight=0;
                    $pay=0;
                    $ln=0;
					while($data= mysql_fetch_array($result1,MYSQL_ASSOC)){
						$total_weight+=$data['total_weight'];                       
					}
                    
                    $sql1="SELECT advance FROM `advanced` WHERE cus_id=$user[id] AND `year_month`={$this->year_month}";
					$result1=$database->query($sql1);
					$advance=0;
					while($data= mysql_fetch_array($result1,MYSQL_ASSOC)){
						$advance+=$data['advance'];
					}

					$this->value=$total_weight*$this->rate;
                    if($this->value > ($advance+$user['loan'])){
                        $pay=$this->value-$advance-$user['loan'];
                    }else{
                        $ln=($advance+$user['loan'])-$this->value;
                    }
                    
                    //echo $this->value."-".$advance."=".$pay." or ".$ln;
                    
					$sql5= "INSERT INTO payment (cus_id,`year_month`,rate, total_weight,value,advanced,payble,loan) VALUES(";
                    $sql5.= "$user[id],$this->year_month,$this->rate,$total_weight,$this->value,$advance,$pay,$ln)";
					$res=$database->query($sql5);
					
					$sql = "UPDATE user SET ";
					$sql .= "`loan` = $ln ";
					$sql .= " WHERE id=$user[id]";
					$database->query($sql);
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