<?php

/* Session class. Starts user session in browser. If already present user is marked as logged in. */

class Session {

	private $logged_in = false;
	public $userID;
	public $message;
	public $lastVisitedPage;
	private $pType;

	function __construct()
	{
		session_start();
		$this->check_message();
		$this->check_login();
		if ($this->logged_in)
		{
			// actions to take right away if the user is logged in
		}
		else
		{
			// actions to take right away if the user is not logged in
		}
	}

	public function is_logged_in()
	{
		return $this->logged_in;
	}

	public function login($user, $p)
	{
		if ($user)
		{
			$this->userID = $_SESSION['userID'] = $user->userID;
			$this->logged_in = true;
			$this->pType = $p;
		}
	}

	public function logout()
	{
		unset($_SESSION['user_id']);
		unset($this->userID);
		$this->logged_in = false;
		unset($this->pType);
	}

	public function message($msg = "")
	{
		if (!empty($msg))
		{
			$_SESSION['message'] = $msg;
		}
		else
		{
			return $this->message;
		}
	}

	public function get_pType()
	{
		return $this->pType;
	}
	
	private function check_login()
	{
		if (isset($_SESSION['userID']))
		{
			$this->userID = $_SESSION['userID'];
			$this->logged_in = true;
		}
		else
		{
			unset($this->userID);
			$this->logged_in = false;
		}
	}

	private function check_message()
	{
		if (isset($_SESSION['message']))
		{
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		}
		else
		{
			$this->message = "";
		}
	}
}

$session = new Session();
$message = $session->message();

?>