<?php
include "functions.php";
include "database.php";

  $db = new DataBase_theend;
  $db->connect();

if($_POST["uid"])
{
  $ip=getenv("REMOTE_ADDR");
	
  $query="select id from twgreward where uid=".$_POST["uid"]." and ip='".$ip."' and date='".date("Y-m-d")."'";
  $db->query($query);
  if(!$db->num_rows())
  {
  	$query="insert into twgreward values(DEFAULT,".$_POST["uid"].",'".$ip."','".date("Y-m-d")."')";
  	$db->query($query);
    $query="update users set votes=votes+10 where id=".$_POST["uid"];
    $db->query($query);  	
  }
}
?>