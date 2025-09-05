<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

include '../database.php';
 
$db = new DataBase_theend;
$db->connect();

if($_COOKIE["uid"] && $_GET["t"])
{
  $uid=$_COOKIE["uid"];

  $query="update actions set act".$_GET["t"]."=".$_GET["act"].", datetime_act".$_GET["t"]."='".date("Y-m-d H:i:s")."', datetime_of_act".$_GET["t"]."='".$_GET["y"]."-".$_GET["m"]."-".$_GET["d"]." ".$_GET["h"].":".$_GET["min"].":00'";
  $db->query($query);

  echo "ok. task ".$_GET["t"]." saved. y=".$_GET["y"].". m=".$_GET["m"].". d=".$_GET["d"].". h=".$_GET["h"].". min=".$_GET["min"].". act=".$_GET["act"];
}  
?>
