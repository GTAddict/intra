<?php define("MY_NAME", "Buy and Sell"); ?>

<?php require_once("../includes/navigation.php"); ?>
<?php require_once("../includes/buyandsell.php"); ?>

<?php
	echo make_header(MY_NAME);
	echo make_navigation();
?>

<div id="content">
<a href="add_item.php">Click here to add an item.</a>
<br/>
<br/>

<?php /* This is the area which displays all items. */ ?>

<b> Items being sold</b><br/><br/>
<?php
	$s = Sell::find_all_cond();
	foreach($s as $sell)
	{
		echo "<b>{$sell->subject}</b><br />";
		echo $sell->description . "<br />";
		echo isset($sell->price) ? "Rs. ".$sell->price : "Price not specified";
		echo "<br />";
		$user = User::find_by_id($sell->userID);
		echo "By {$user->username} on {$sell->lastModified}<br />";
		echo "<hr/>";
	}
			
?>
<br/>
<b> Items people are looking for</b><br/><br/>
<?php
	$b = Buy::find_all_cond();
	foreach($b as $buy)
	{
		echo "<b>{$buy->subject}</b><br />";
		echo $buy->description . "<br />";
		echo isset($buy->price) ? "Rs. ".$buy->price : "Price not specified";
		echo "<br />";
		$user = User::find_by_id($buy->userID);
		echo "By {$user->username} on {$buy->lastModified}<br />";
		echo "<hr/>";
	}
?>
<br/>
	
</div>

	
<?php echo end_body(); ?>
	