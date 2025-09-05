<?php

include 'database.php';

  $db_theend = new DataBase_theend;
  $db_theend->connect();

   $datetime=getdate();

   if(!$_COOKIE["uid"])
     header("Location: index.php");
   else
   {
     $query="update online set online=-1, datetime='".$datetime["year"]."-".$datetime["mon"]."-".$datetime["mday"]." ".$datetime["hours"].":".$datetime["minutes"].":".$datetime["seconds"]."', inactivedate='".$datetime["year"]."-".$datetime["mon"]."-".$datetime["mday"]." ".$datetime["hours"].":".$datetime["minutes"].":".$datetime["seconds"]."' where id=".$_COOKIE["uid"];
     $db_theend->query($query);
   }

setcookie("user","",mktime(0,0,0,1,1,1980));
setcookie("uid","",mktime(0,0,0,1,1,1980));
setcookie("code1","",mktime(0,0,0,1,1,1980));
setcookie("code2","",mktime(0,0,0,1,1,1980));
setcookie("online","",mktime(0,0,0,1,1,1980));
header("Location: index.php");
?>