<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

include '../database.php';
include '../functions.php';
 
$db = new DataBase_theend;
$db->connect();

if($_COOKIE["uid"])
{

semafor_on($_COOKIE["uid"]);

$query="select armory.gold as gold, seif.gold as sgold, seif.max_gold as maxgold, seif.date as date from armory, seif where armory.id=seif.uid and armory.id=".$_COOKIE["uid"];
$db->query($query);
$db->next_record();
$gold=$db->Record["gold"];
$current_deposit=$db->Record["sgold"];
$max_deposit=$db->Record["maxgold"];

$amount=round($_GET["amount"]);

if($_GET["act"]=="deposit" && $amount>0 && $amount<=$gold && $amount+$current_deposit<=$max_deposit && $db->Record["date"]<date("Y-m-d H:i:s", mktime(0, 0, 0, date(m), date(d), date(Y))))
{
     $query="update seif set gold=".($current_deposit+$amount).", date='".date('Y-m-d H:i:s')."' where uid=".$_COOKIE["uid"];
     $db->query($query);
     $query="update armory set gold=".($gold-$amount)." where id=".$_COOKIE["uid"];
     $db->query($query);
     
     echo "1&".number_format($gold-$amount)."&".number_format($current_deposit+$amount)."&".number_format($gold-$amount+$current_deposit+$amount);
}  

if($_GET["act"]=="retract" && $amount>0 && $amount<=$current_deposit)
{
     $query="update seif set gold=".($current_deposit-$amount)." where uid=".$_COOKIE["uid"];
     $db->query($query);
     $query="update armory set gold=".($gold+$amount)." where id=".$_COOKIE["uid"];
     $db->query($query);
     
     echo "1&".number_format($gold+$amount)."&".number_format($current_deposit-$amount)."&".number_format($gold+$amount+$current_deposit-$amount);
}  

semafor_off($_COOKIE["uid"]);

}
?>
