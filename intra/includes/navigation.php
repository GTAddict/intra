<?php
require_once("initialize.php");

function make_header($title="Welcome to Intra", $headtext="")
{
	$header=<<<HEADER
	<html>
	<head>
	<link rel="stylesheet" type="text/css" href="../stylesheets/style.css" />
HEADER;
	$header .= "<title>{$title}</title>";
	$header .= "</head>";
	
	return $header;
}

function make_navigation()
{
	$content =<<<CONTENT
	<body>
	<div id="nav">
	<ul id="navigation">
		<li><a class="lostfound" href="../lost_and_found"></a></li>
		<li><a class="timetables" href="../time_tables"></a></li>
		<li><a class="desk" href="../owners_desk"></a></li>
		<li><a class="dating" href="../dating"></a></li>
		<li><a class="buysell" href="../buy_and_sell"></a></li>
		<li><a class="study" href="../study_material"></a></li>
		<li><a class="buzz" href="../the_latest_buzz"></a></li>
		<li><a class="gamesquizzes" href="../games_and_quizzes"></a></li>
		<li><a class="radio" href="../radio"></a></li>
	</ul>
	</div>
CONTENT;

	return $content;
}

function make_root_header($title="Welcome to Intra", $headtext="")
{
	$header=<<<HEADER
	<html>
	<head>
	<link rel="stylesheet" type="text/css" href="stylesheets/style.css" />
HEADER;
	$header .= "<title>{$title}</title>";
	$header .= "</head>";
	
	return $header;
}

function make_root_navigation()
{
	$content =<<<CONTENT
	<body>
	<div id="nav">
	<ul id="navigation">
		<li><a class="lostfound" href="lost_and_found"></a></li>
		<li><a class="timetables" href="time_tables"></a></li>
		<li><a class="desk" href="owners_desk"></a></li>
		<li><a class="dating" href="dating"></a></li>
		<li><a class="buysell" href="buy_and_sell"></a></li>
		<li><a class="study" href="study_material"></a></li>
		<li><a class="buzz" href="the_latest_buzz"></a></li>
		<li><a class="gamesquizzes" href="games_and_quizzes"></a></li>
		<li><a class="radio" href="radio"></a></li>
	</ul>
	</div>
CONTENT;

	return $content;
}

function end_body()
{

	$content =<<<CONTENT
	</body>
	</html> 
CONTENT;

	return $content;
}



?>