<?php

header("Content-type: image/png");
$data = "1";
$weather_condition = "Cloudy";
$font_file = 'fonts/corbel.ttf';
$im     = imagecreatefrompng("images/topbar/weather.png");

$white = imagecolorallocate($im, 255, 255, 255);
$px     = (imagesx($im) - 63 * strlen($data)) / 2;
imagefttext($im, 75, 0, $px, 75, $white, $font_file, $data);

$px = (imagesx($im) - 28 * strlen($weather_condition)) / 2;
$yellow = imagecolorallocate($im, 237, 239, 46);
imagefttext($im, 40.5, 0, $px, 193, $yellow, $font_file, $weather_condition);

imagepng($im);
imagedestroy($im);

?>