<?php
header("Content-type: image/png");

include 'database.php';

$db = new DataBase_theend;
$db->connect();

$code=$_GET["c"];

$query="select value from image_codes where id=".$code;
$db->query($query);
$db->next_record();
$string=$db->Record["value"];

$im    = imagecreatetruecolor (35,20);
$orange = imagecolorallocate($im, 220, 210, 60);
$black = imagecolorallocate($im, 0, 0, 0);
$white = imagecolorallocate($im, 180, 255, 180);
$blue = imagecolorallocate($im, 16, 32, 48);
imagefilledrectangle($im,0,0,34,19,$blue);
imagestring($im, 3, 0, 3, $string, $white);
imagepng($im);
imagedestroy($im);
?>