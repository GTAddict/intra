<?php

// ADD CONFIGURATION FILE
require_once("database.php");

/** This is the super parent. This has all the object methods: Looking through the database (though
* that would still called the Database class), instantiation of the specified object, checking
* for a specified attribute, sanitizing attributes, and creation, updation and deletion of records.
*/

/*
			IMPORTANT !! ********** ! ********** !! IMPORTANT !! ********** ! ********** !! IMPORTANT
		   	=========================================================================================
*/

		/** If you replace an inherited method in a child class, a call to "static::function()" INSIDE
		* that function IN the PARENT class WON'T WORK if function is a member of the CHILD class because
	 	* the scope will be of the PARENT class!! Use the $this->function() modifier instead, because it
	 	* is the class instance in this case, that is making the request, so to have same scope, we use $this.
	 	*/
		



class DatabaseObject {

	public static function find_all_cond()
	{
		$sql = "SELECT * FROM " . static::$table_name;
		$sql .= " WHERE " . static::$cond_field . "='". static::$cond_value . "'";
		return static::find_by_sql($sql);
	}

	/* Finds all records in table */
	public static function find_all()
	{
		return static::find_by_sql("SELECT * FROM " . static::$table_name);
	}


	/* Finds a record given it's identifier and id number */
	public static function find_by_id($id=0)
	{
		$record = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE ". static::$uniqueID . "= {$id} LIMIT 1");
		return $record[0];
	}

	public static function execute_sql($sql="")
	{
		global $database;
		return $database->query($sql);
	}

	/* Custom SQL query to get whatever you want */
	public static function find_by_sql($sql = "")
	{
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result_set))
		{
			$object_array[] = static::instantiate($row);
		}

		return $object_array;
	}


	/* Counts all records in table */
	public static function count_all()
	{
		global $database;
		$sql = "SELECT COUNT(*) FROM " . static::$table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}


	/* Instantiates a record once it is found. Data is pulled into new
		instance of called class from database and instance is returned */
	protected static function instantiate($record)
	{
		$class_name = get_called_class();
		$object = new $class_name;
		$variables = get_class_vars($class_name);
		
		foreach ($record as $attribute => $value)
		{
			if (array_key_exists($attribute, $variables))
			{
				$object->$attribute = $value;
			}
		}
		return $object;
	}

	/* Wrapper */
	private function has_attribute($attribute)
	{
		return array_key_exists($attribute, $this->attributes());
	}


	/* TODO: Revise this function */
	protected function attributes()
	{
		return get_object_vars($this);
	}


	/* Escapes all the attributes so that malicious things cannot happen */
	/* WARNING: Returns ONLY those that are defined in the db_fields array	*/
	protected function sanitized_attributes()
	{
		global $database;
		$clean_attributes = array();
		$Attributes = $this->attributes();
		
		foreach ($Attributes as $key=>$value)
		{
			if (in_array($key, static::$db_fields) && isset($value))
			{
				$clean_attributes[$key] = $database->escape_value($value);
			}
		}

		return $clean_attributes;
	}

	/* If ID is set then update record, else create it */
	public function save()
	{
		return $this->id_exists() ? $this->update : $this->create();
	}

	/* Creates a new record in the database */
	public function create()
	{
		global $database;

		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO " . static::$table_name . " (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";

		if ($database->query($sql))
		{
			$this->id = $database->insert_id();
			return true;
		}
		else
			return false;

	}


	/* Updates a record present in the database */
	public function update()
	{
		global $database;

		$attributes = sanitized_attributes();
		$attribute_pairs = array();
		foreach ($attributes as $key => $value)
		{
			$attribute_pairs[] = "{key}='{value}'";
		}

		$sql = "UPDATE " . static::$table_name . " SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=" . $database->escape_value($this->id);

		$database->query($sql);

		return ($database->affected_rows() == 1) ? true : false;
	}


	/* Deletes a record present in the database */
	public function delete()
	{
		global $database;

		$sql = "DELETE FROM " . static::$table_name . "WHERE id=";
		$sql .= $database.escape_value($this->id) . " LIMIT 1";

		$database->query($sql);

		return ($database->affected_rows() == 1) ? true : false;
	}


	/* $message can be displayed to user $restricted SHOULD NOT. */
	public function error_logger($message = "", $restricted = "")
	{
		$contents = time();		/* TODO: CONVERT TIME TO READABLE FORMAT */
		die($message);
		$contents .= $message . $restricted . "\r\n";
		
		// TODO: LOG MESSAGE TO FILE
	}

}