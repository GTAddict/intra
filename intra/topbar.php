<?php
// Create a 300x100 image
$im = imagecreatetruecolor(300, 100);
$red = imagecolorallocate($im, 0xFF, 0x00, 0x00);
$black = imagecolorallocate($im, 0x00, 0x00, 0x00);

// Make the background red
imagefilledrectangle($im, 0, 0, 299, 99, $red);

// Path to our ttf font file
putenv('GDFONTPATH=' . realpath('.'));
$font_file = 'segoeui.ttf';

// Draw the text 'PHP Manual' using font size 13
imagefttext($im, 13, 0, 105, 55, $black, $font_file, 'PHP Manual');

// Output image to the browser
header('Content-Type: image/png');

imagepng($im);
imagedestroy($im);
?>


<?php

	function make_root_topbar($user)
	{
		$im_weather = make_weather();
		$im_prayer = make_prayer();
		$im_bday = make_bday();
		$im_mail = make_mail();
	}
		

	function make_unable()
	{
		$im = imagecreatefrompng("../images/topbar/unable.png");
		return $im;
	}

	function make_weather()
	{
		// $weather = get_weather();			// associative array TODO: UNCOMMENT AND WRITE FUNCTION!
		$weather = array(
		"condition" => "thunderstorm",
		"temp_c" => 39,
		"humidity" => 86,
		"wind_condition" => "W at 9mph"
		);
		
		if (!$weather)
			return make_unable();
		
		/** FOR NUMERICAL DATA
		  * Font size: 100pt
		  * Font: Corbel, regular
		  * Color: 255, 255, 255
		  * X: 122 pixels from left align right
		  * Y: 75 pixels from top
		  */
		  
		 $im = imagecreatefrompng("../images/topbar/weather.png");
		 $font_file = "../fonts/corbel.ttf";
		 $font_size = 100;
		 $x = calculate
		 
		 imagefttext($im, $font_size, 0, 
			
		
		