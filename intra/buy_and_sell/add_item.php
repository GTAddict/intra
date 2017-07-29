<?php define("MY_NAME", "Buy and Sell - Add item"); ?>

<?php require_once("../includes/navigation.php"); ?>
<?php require_once("../includes/buyandsell.php"); ?>

<?php /* This area checks the form and if valid, adds to DB */

	$record = array();
	$message = "";	
	if (isset($_POST['submit']))
	{
		$variable_list = get_class_vars("BuyAndSell");
		foreach ($variable_list as $name=>$value)
		{
			if (!empty($_POST[$name]))
			{
				$record[$name] = $_POST[$name];
			}
		}
		
		if (isset($_POST['type']))
		{
			if ($_POST['type'] == 'B')
				$bs = Buy::verify_data($record);
			else if ($_POST['type'] == 'S')
				$bs = Sell::verify_data($record);
			else
				$message .= "An error occurred. Please try again later.<br/>";
		}
		else
			$message .= "Buy/Sell option not set!<br />";
		
		if (isset($bs))
		{
			if (gettype($bs) == "string")
			{
				$message .= "Please correct the following errors:<br>";
				$message .= $bs; // Error messages;
			}
			else
			{	
				if (!$bs->save())
					$message = "An error occurred. Please try again later.<br />";
				else
				{
					header('Location: index.php');		// Redirect to index (listing of all items)
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
	
	<a href="index.php">Click here to view all products</a><br/>
	<?php if (isset($message)) echo "<b>{$message}</b>"; ?>
	<br />
	<form action="add_item.php" method="post">
	Subject:<input type="text" name="subject" value="<?php echo isset($record['subject'])? $record['subject'] : null; ?>"/><br />
	Enter your description here:<br />
	<textarea name="description" rows="4" cols="25"><?php echo isset($record['description'])? $record['description'] : null; ?></textarea><br />
	If you are buying, enter the price you are willing to pay. If you are selling, enter the price you are willing to sell for:<br />
	<input type="text" name="price" value="<?php echo isset($record['price'])? $record['price'] : null ?>"/><br />
	Are you buying this product, or selling it?<br />
	<input type="radio" name="type" value="B"  <?php if (isset($_POST['type']))  if ($_POST['type'] == "B") echo "checked=\"yes\"";?>/>Buying<br />
	<input type="radio" name="type" value="S" <?php if (isset($_POST['type'])) if ($_POST['type'] == "S") echo "checked=\"yes\""; ?>/>Selling</br />
	Contact phone: <input type="text" name="contactPhone" value="<?php echo isset($record['contactPhone'])? $record['contactPhone'] : null ?>"/><br />
	Contact E-mail: <input type="text" name="contactEmail" value="<?php echo isset($record['contactEmail'])? $record['contactEmail'] : null ?>"/><br />
	<input type="submit" name="submit" value="Submit" />
	</form>
	</div>
<?php echo end_body(); ?>
	