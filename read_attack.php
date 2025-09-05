<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 

include 'database.php';

$db = new DataBase_theend;
$db->connect();

$query="select attack_log.id, attack_log.date, attack_log.at_id, attack_log.df_id, attack_log.win_id, a.username as at, b.username as df, attack_log.turns from attack_log, users a, users b where attack_log.at_id=a.id and attack_log.df_id=b.id order by attack_log.id desc limit 1";
$db->query($query);
$db->next_record();

if($db->Record["id"]!=$_GET["last_attack"])
{
  echo "1&".$db->Record["id"]."&".$db->Record["date"]."&<b>".$db->Record["at"]."</b>&<b>".$db->Record["df"]."</b>";
  echo "&".$db->Record["turns"];
  if($db->Record["win_id"]==$db->Record["at_id"])
  {
  	echo "&<b>".$db->Record["at"]."</b>";
  }
  if($db->Record["win_id"]==$db->Record["df_id"])
  {
  	echo "&<b>".$db->Record["df"]."</b>";
  } 
  if($db->Record["win_id"]==0)
  {
  	echo "&draw";
  }
}
else 
{
  echo "0&".$db->Record["id"];
}

?>