<?php
error_reporting(E_ALL ^ E_DEPRECATED);

//echo "weektop started on ".date("Y-m-d H:i:s");
include 'database.php';

$db=new DataBase_theend;
$db->connect();
$db2=new DataBase_theend;
$db2->connect();

/*
$query="select id from users order by last_votes desc limit 10";
$db->query($query);

while($db->next_record())
{
  $query="update armory set power_bonus=0 where id=".$db->Record["id"];
  $db->query($query);
}
*/

$query="update users set last_votes=votes, votes=0";
$db->query($query);

$query="update top_active_users set week2=week1, week1=0";
$db->query($query);

/*
$query="select id from users order by last_votes desc limit 10";
$db->query($query);

$i=0;
while($db->next_record())
{
  if($i==0)
  {
    $query="update armory set power_bonus=".(20-$i*2).", super_attack=super_attack+2 where id=".$db->Record["id"];
    $db->query($query);
  }
  if($i==1)
  {
    $query="update armory set power_bonus=".(20-$i*2).", super_attack=super_attack+1 where id=".$db->Record["id"];
    $db->query($query);
  }
  if($i>1)
  {
    $query="update armory set power_bonus=".(20-$i*2)." where id=".$db->Record["id"];
    $db->query($query);
  }
  $i++;
}
*/

/*
$query="select id from top_active_users order by week2 desc limit 5";
$db->query($query);
$i=0;
while($db->next_record())
{
  $i++;
  $query="update seif set gold=gold+".((6-$i)*2000)." where uid=".$db->Record["id"];
  $db2->query($query);
}
*/

?>
