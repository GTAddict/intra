<?php define("MY_NAME", "Welcome to Intra"); ?>

<?php require_once("includes/navigation.php"); ?>


<?php
	echo make_root_header(MY_NAME);
	echo make_root_navigation();
?>
	<ul id="topbar">
<?php
	$user; //TESTING PURPOSES ONLY!!! ASSIGN@@ ASSIGN!! CHANGE@@@
	//echo make_root_topbar(/*$user*/); ?>
	<li><a class="one" href="sam.php"></a></li>
	<li><a class="two" href="sam1.php"></a></li>
	</ul>
	<?php
	echo end_body();
?>