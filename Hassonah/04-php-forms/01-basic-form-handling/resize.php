<?php
// Form example
// tell browser this is an image
// Send header
header("Content-Type: image/jpeg");
// create the image from a file
$imgname = "{$_GET["file"]}.jpeg";
$img = imagecreatefromjpeg($imgname);
// resize the image to requested size
$w = $_GET["width"];
$newimg = imagescale($img, $w, $w);
// add some text to it
//$fontFile = realpath('font/Lato-Medium.ttf');
//$fontSize = 16;
//$textColor = imagecolorallocate($newimg,238,238,238);
// imagettftext($newimg,$fontSize,0,250,160,$textColor,
//$fontFile, $_GET['overlay']);
// now return it to requesting browser
imagejpeg($newimg);
?>
