<?php

require_once("databaseObject.php");

class BuyAndSell extends DatabaseObject {

	protected static $uniqueID = "productID";

	protected static $db_fields = array(
		"userID", "uploadIP", "uploadTimestamp",
		"subject", "description", "price", "contactPhone",
		"contactEmail", "status"
		);

	protected static $cond_field = "status";
	protected static $cond_value = "O";				// Only "open" values for display
	
	public $productID;
	public $userID;
	public $uploadTimestamp;
	public $subject;
	public $description;
	public $price;
	public $uploadIP;
	public $contactPhone;
	public $contactEmail;
	public $lastModified;
		
	public function id_exists()
	{
		if (isset($productID))
			return true;
		else
			return false;
	}
	
	public static function process($record)
	{
		$record = self::instantiate($record);
		
		// TODO: GET USER ID!!!!!!!!!!!
		// $record->userID = USERID!!
		$record->userID = 5;	// TESTING ONLY!! TESTING ONLY!!!
		
		$record->uploadTimestamp = $_SERVER['REQUEST_TIME'];
		$record->uploadIP = $_SERVER['REMOTE_ADDR'];
		return $record;
	}
		
	
	public static function verify_data($record)
	{
		/* 
			- Check if subject is empty
			- Check if description is empty
			- Check if price is not a number
			- Check if contact phone is not a number
			- Check if e-mail is valid
		*/
		
		$errors = "";
		
		if (!isset($record['subject']))
			$errors .= "Subject is compulsory.<br />";
		if (!isset($record['description']))
			$errors .= "Description is compulsory.<br />";
		if (isset($record['price']))
			if (!is_numeric($record['price']))
				$errors .= "Price must be a number.<br />";
		if (isset($record['contactPhone']))
			if (!is_numeric($record['contactPhone']))
				$errors .= "Contact phone must be a number.<br />";
		if (isset($record['contactEmail']))
			if (!filter_var($record['contactEmail'], FILTER_VALIDATE_EMAIL))
				$errors .= "E-mail address is invalid.<br />";
		
		if ($errors)
				return $errors;
		else
				return self::process($record);
	}
	
}

class Buy extends BuyAndSell {
	protected static $table_name = "to_buy";
}

class Sell extends BuyAndSell {
	protected static $table_name = "to_sell";
}