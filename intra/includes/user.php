<?php

// HAVE ALL THE INCLUDES
require_once("databaseObject.php");
// Add the database->escape() value method
// Add the database->passhash() method

$branches = array(
		"Electrical",
		"Mechanical",
		"Electronics",
		"Chemical",
		"Computer Science",
		"Biotechnology",
		"Mathematics",
		"Physics",
		"Chemistry",
		"Humanities",
		"Management"
	);
	

	// Hostels removed for internet upload
	$hostels = array(
	);

class User extends DatabaseObject {

	protected static $uniqueID = "userID";
	protected static $table_name = "users";
	protected static $db_fields = array(
		"username", "hashedpass", "registerIP", "registerTimestamp",
		"regBrowserInfo", "realName", "sex", "dob", "contactPhone",
		"contactEmail", "hostel", "roomNo", "course",
		"year", "section", "branch", "activationKey"
		);
		
	public $userID;
	public $username;
	public $hashedpass;
	public $registerTimestamp;
	public $registerIP;
	public $regBrowserInfo;
	public $realName;
	public $sex;
	public $dob;
	public $contactPhone;
	public $contactEmail;
	public $hostel;
	public $roomNo;
	public $course;
	public $year;
	public $section;
	public $branch;
	public $activationKey;
	public $password;
	public $password2;
	public $dobmonth;
	public $dobday;
	public $dobyear;
	public $lastModified;
		
	public function id_exists()
	{
		if (isset($userID))
			return true;
		else
			return false;
	}
	
	public function lowest_privileges()
	{
	
		global $database;
		
		$sql = "INSERT INTO permissions (userID, privilegeType) VALUES ('";
		$sql .= $database->insert_id();
		$sql .= "', 'N')";
		
		return self::execute_sql($sql);
	}
	
	public static function authenticate($username = "", $password = "")
	{
		global $database;
		
		$username = $database->escape_value($username);
		$hashedpass = sha1($password);

		$sql = "SELECT * FROM users 
				WHERE username = '{$username}' 
				AND hashedpass = '{$hashedpass}' 
				LIMIT 1";

		$result_array = self::find_by_sql($sql);

		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public static function get_permissions($userID)
	{
		global $database;
		
		$sql = "SELECT * FROM permissions WHERE userID={$userID} LIMIT 1";
		$result_array = self::find_by_sql($sql);
		
		return !empty($result_array) ? array_shift($result_array) : false;
		
	}
	
	public static function resolve_permissions($permissions)
	{
		if (isset($permissions->banStart))
		{
			$message = "You have been banned from this site for the following reason:<br/>" . $permissions->banReason;
			
			if (isset($permissions->banEnd))
			{
				$message .= "You can return to this site on {$permissions->banEnd}, when your ban will expire.<br/>";
				$message .= "If you repeat this, you might be banned permanently.<br/>";
			}
			else
			{
				$message .= "This is a permanent ban and you cannot enter this site.<br/>";
			}
			
			$message .= "If you feel an error has been made, please contact an administrator.<br/>";
			
			echo $message;
			
			return false;
		
		}
		
		else
		
			return true;
			
	}		
	
	public static function process($record)
	{
		$record = self::instantiate($record);
		
		$record->registerTimestamp = $_SERVER['REQUEST_TIME'];
		$record->dob = $record->dobyear . "-" . $record->dobmonth . "-" . $record->dobday;
		$record->hashedpass = sha1($record->password);
		$record->registerIP = $_SERVER['REMOTE_ADDR'];
		$record->regBrowserInfo = $_SERVER['HTTP_USER_AGENT'];
		return $record;
	}
		
	
	public static function verify_data($record)
	{
		/* Compulsory ones are username, password, password2, hostel, course
			year, section, branch
			*/
			$errors = "";
			
			if (!isset($record['username']))
				$errors .= "Username is compulsary.<br/>";
			else
			{
				if (self::find_by_sql("SELECT * FROM ". static::$table_name." WHERE username=\"{$record['username']}\" LIMIT 1;"))
				{
					$errors .= "That username is already taken. Please try something else.<br />";
				}
			}
			if (!isset($record['password']))
				$errors .= "Password is compulsary.<br/>";
			if (!isset($record['password2']))
				$errors .= "Password has to be re-typed.<br/>";
			if (!isset($record['hostel']))
				$errors .= "Hostel name is compulsary.<br/>";
			if (!isset($record['course']))
				$errors .= "Course is compulsary.<br/>";
			if (!isset($record['year']))
				$errors .= "Year is compulsary.<br/>";
			if (!isset($record['section']))
				$errors .= "Section is compulsary.<br/>";
			if (!isset($record['branch']))
				$errors .= "Branch is compulsary.<br/>";
			if (isset($record['dobmonth'])
				&& isset($record['dobday'])
				&& isset($record['dobyear'])
				)
				if (!checkdate($record['dobmonth'], $record['dobday'],$record['dobyear']))
					$errors .= "Invalid date of birth specified. Please check again.<br />";
			if (isset($record['password']) && isset($record['password2'])
				&& ($record['password'] != $record['password2']))
				$errors .= "Passwords do not match.<br/>";
			if (isset($record['contactPhone']))
				if (!is_numeric($record['contactPhone']))
					$errors .= "Contact phone must be a number.<br />";
			if (isset($record['contactEmail']))
				if (!filter_var($record['contactEmail'], FILTER_VALIDATE_EMAIL))
					$errors .= "E-mail address is invalid.<br />";
			if (isset($record['section']))
				if (is_numeric($record['section']))
					$errors .= "Invalid section specified.<br />";
		
			if ($errors)
				return $errors;
			else
				return self::process($record);
	}
	
}