<?php define("MY_NAME", "Registration"); ?>

<?php require_once("../includes/navigation.php"); ?>

<?php /* This area checks the form and if valid, adds to DB */

	$record = array();
		
	if (isset($_POST['submit']))
	{
		$variable_list = get_class_vars("user");
		foreach ($variable_list as $name=>$value)
		{
			if (!empty($_POST[$name]))
			{
				$record[$name] = $_POST[$name];
			}
		}
		
		$user = User::verify_data($record);
		
		if (gettype($user) == "string")
		{
			$message = "Please correct the following errors:<br>";
			$message .= $user; // Error messages;
		}
		else
		{	
			if (!$user->save())
				$message = "An error occurred. Please try again later.<br />";
			else
			{
				if ($user->lowest_privileges())
				{
					header('Location: ../'); // redirected to home page
					exit;
				}
			}
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
	
	<div id="">
	<br/>Already have an account? Click <a href="../login">here</a> to login.<br/>
	<?php if (isset($message)) echo "<b>{$message}</b>"; ?>
	<br />
	<form action="./" method="post">
	Username:<input type="text" name="username" value="<?php echo isset($record['username'])? $record['username'] : null ?>"/><br />
	Password:<input type="password" name="password" value="<?php echo isset($record['password'])? $record['password'] : null ?>"/><br />
	Re-type Password: <input type="password" name="password2" value="<?php echo isset($record['password2'])? $record['password2'] : null ?>"/><br />
	Real Name: (Optional)<input type="text" name="realName" value="<?php echo isset($record['realName'])? $record['realName'] : null ?>"/><br />
	Sex (Optional):
	<input type="radio" name="sex" value="M"  <?php if (isset($record['sex']))  if ($record['sex'] == "male") echo "checked=\"yes\"";?>/>Male<br />
	<input type="radio" name="sex" value="F" <?php if (isset($record['sex'])) if ($record['sex'] == "female") echo "checked=\"yes\""; ?>/>Female</br />
	<input type="radio" name="sex" value="O" <?php if (isset($record['sex'])) if ($record['sex'] == "other") echo "checked=\"yes\""; ?>/>Other<br />
	Date of Birth: (Optional)
	<select name="dobmonth"><?php for ($i = 1; $i <= 12; $i++){echo "<option value=\"{$i}\""; if (isset($record['dobmonth'])) if ($record['dobmonth'] == $i) echo "selected=\"selected\"";echo ">{$i}</option>";}?></select>
	<select name="dobday"><?php for ($i = 1; $i <= 31; $i++){echo "<option value=\"{$i}\""; if (isset($record['dobday'])) if ($record['dobday'] == $i) echo "selected=\"selected\"";echo ">{$i}</option>";}?></select>
	<select name="dobyear"><?php for ($i = 1980; $i <= 2000; $i++){echo "<option value=\"{$i}\""; if (isset($record['dobyear'])) if ($record['dobyear'] == $i) echo "selected=\"selected\"";echo ">{$i}</option>";}?></select>
	Contact phone (Optional): <input type="text" name="contactPhone" value="<?php echo isset($record['contactPhone'])? $record['contactPhone'] : null ?>"/><br />
	Contact E-mail (Optional): <input type="text" name="contactEmail" value="<?php echo isset($record['contactEmail'])? $record['contactEmail'] : null ?>"/><br />
	Hostel: <select name="hostel"><?php $i=1;foreach ($hostels as $h){echo "<option value=\"".$i++."\"";if (isset($record['hostel'])) if ($record['hostel'] == $i-1) echo "selected=\"selected\"";echo ">{$h}</option>";}?></select><br />
	Room No (Optional): <input type="text" name="roomNo" value="<?php echo isset($record['roomNo'])? $record['roomNo'] : null ?>"/><br />
	Course: <input type="radio" name="course" value="bt" <?php if (isset($record['course'])) if ($record['course'] == "bt") echo "checked=\"yes\""; ?>/>B. Tech<br />
	<input type="radio" name="course" value="mt" <?php if (isset($record['course'])) if ($record['course'] == "mt") echo "checked=\"yes\""; ?>/>M. Tech or M. Sc<br />
	<input type="radio" name="course" value="mba" <?php if (isset($record['course'])) if ($record['course'] == "mba") echo "checked=\"yes\""; ?>/>MBA<br />
	<input type="radio" name="course" value="phd" <?php if (isset($record['course'])) if ($record['course'] == "phd") echo "checked=\"yes\""; ?>/>Ph.D<br />
	Year: <select name="year"><?php for ($i = 1; $i <= 4; $i++){echo "<option value=\"{$i}\"";if (isset($record["year"])) if ($record["year"] == $i) echo "selected=\"selected\"";echo ">{$i}</option>";} ?></select><br />
	Section: <input type="text" name="section" maxlength="1" size="1" value="<?php echo isset($record['section'])? $record['section'] : null ?>"/><br />
	Branch:	<select name="branch"><?php $i=1;foreach ($branches as $br){echo "<option value=\"" . $i++ . "\"";if (isset($record['branch'])) if ($record['branch'] == $i-1) echo "selected=\"selected\"";echo ">{$br}</option>";}?></select><br />
	<input type="submit" name="submit" value="Submit" />
	
	</form>
	</div>
<?php echo end_body(); ?>
	