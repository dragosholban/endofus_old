<?php

include 'database.php';
include 'functions.php';

$db_theend = new DataBase_theend;
$db_theend->connect();

$from=$_POST["from"];
$to=$_POST["to"];
$subject=safechar($_POST["subject"]);
$message=safechar($_POST["text"]);
$datetime=date("Y-m-d H:i:s");

$query="insert into mail values(DEFAULT,".$from.",".$to.",'".$datetime."','".$message."',1,'".$subject."')";
$db_theend->query($query);
if($to)
{
  $query="update users set newmail=newmail+1 where id=".$to;
  $db_theend->query($query);
}
$query="insert into sentbox values(DEFAULT,".$from.",".$to.",'".$datetime."','".$message."','".$subject."')";
$db_theend->query($query);

if($_POST["file"]=="play.php")
  header("Location:".$_POST["file"]."?loc=mail");
else
  header("Location:".$_POST["file"]."&m=1");
?>
