<?php define("MY_NAME", "Login"); ?>

<?php require_once("../includes/navigation.php"); ?>

<?php

	if ($session->is_logged_in())
	{
		if (isset($session->lastVisitedPage))
			header("Location: {$lastVisitedPage}");
		else
			header("Location: ../");
		exit;
	}
	
	if (isset($_POST['submit']))
	{
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		$found_user = User::authenticate($username, $password);
		
		if ($found_user)
		{
			$user_permissions = User::get_permissions($found_user->userID);
			if (!$user_permissions)
			{
				if ($found_user->lowest_privileges())
				{
					$user_permissions = User::get_permissions($found_user->userID);
				}
				else
				{
					$message = "There seems to be a problem with your access permissions.<br/>
								Please contact an administrator to resolve the issue.<br/>";
					header("Location: ../");
					exit;
				}
			}
			
			$provide_access = User::resolve_permissions($user_permissions);
			
			if ($provide_access)
			{
				$session->login($found_user, $user_permissions->privilegeType);
				// TODO: log the action!
				if (isset($session->lastVisitedPage))
					header("Location: {$session->lastVisitedPage}");
				else
					header("Location: ../");
				exit;
			}
			
		}
		
		else
		{
			$message = "Invalid username/password. Please try again.<br/>";
		}
		
	}
	
?>



<?php
	echo make_header(MY_NAME);
	echo make_navigation();
?>

<?php /* This is the form area which displays form. */ ?>

	<div id="content">
	
	<div id="h1">
	<?php echo MY_NAME; ?>
	</div>
	
	<?php if (isset($message)) echo "<b>{$message}</b>"; ?>
	<br />
	<form action="./" method="post">
	Username:<input type="text" name="username" value="<?php echo isset($_POST['username'])? $_POST['username'] : null ?>"/><br />
	Password:<input type="password" name="password" value="<?php echo isset($_POST['password'])? $_POST['password'] : null ?>"/><br />
	<input type="submit" name="submit" value="Login" />
	</form>
	<br/>Don't have an account? Click <a href="../register">here</a> to create one.
	</div>
<?php echo end_body(); ?>
	

