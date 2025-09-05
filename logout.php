<?php

  include 'database.php';

  $db_theend = new DataBase_theend;
  $db_theend->connect();

   $datetime=getdate();

   if(!$_COOKIE["user"])
     header("Location: index.php");
   else
   {
     $query="select id, login_time from online where id=".$_COOKIE["uid"];
     $db_theend->query($query);
     if($db_theend->num_rows())
     {
             $db_theend->next_record();
             $query="update online set online=0, datetime='".date("Y-m-d H:i:s")."', seconds_day=seconds_day+".time()."-login_time where id=".$db_theend->Record["id"];
             $db_theend->query($query);
     }
   }

setcookie("user","",mktime(0,0,0,1,1,1980));
setcookie("uid","",mktime(0,0,0,1,1,1980));
setcookie("code1","",mktime(0,0,0,1,1,1980));
setcookie("code2","",mktime(0,0,0,1,1,1980));
setcookie("online","",mktime(0,0,0,1,1,1980));
header("Location: index.php");
?>
