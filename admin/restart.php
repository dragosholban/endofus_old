#!/usr/bin/php -q
<?php
/*
include 'database.php';

$db=new DataBase_theend;
$db->connect();
$db2=new DataBase_theend;
$db2->connect();
//$dbf=new DataBase_theend_first;
//$dbf->connect();


$query="select id, race from users order by id";
$db->query($query);
while($db->next_record())
{
  $query="update users set newmail=0, warned=0, best_rank=0 where id=".$db->Record["id"];
  $db2->query($query);

  $query="update armory set attack=0, elite_at=0, elite_df=0, units=10, untrained=10, level=0, exp=0, gold=0, turnlen=20, lastacct='".date("Y-m-d H:i:s")."', workers=0, spy=0, antispy=0, rank=0, rank_value=0, turn=10, attack_rank=0, defense_rank=0, spy_rank=0, sentry_rank=0, attack_rank_value=0, defense_rank_value=0, spy_rank_value=0, sentry_rank_value=0 where id=".$db->Record["id"];
  $db2->query($query);

  $query="update upgrades set attack=0, defense=0, spy=0, antispy=0, worker=0, wprec=0, population=0, elite=0 where id=".$db->Record["id"];
  $db2->query($query);

  $query="update semafor set armory=0, skey='' where id=".$db->Record["id"];
  $db2->query($query);

  $query="update online set online=-1, datetime='".date("Y-m-d H:i:s")."', inactivedate='".date("Y-m-d H:i:s")."'";
  $db2->query($query);

  $query="update user_profile set firstname='', lastname='', location='', avatar='' where id=".$db->Record["id"];
  $db2->query($query);

  $query="update seif set gold=20000, max_gold=10000000, date='' where uid=".$db->Record["id"];
  $db2->query($query);

  $query="update mastery set battle=0, battle_win=0 where id=".$db->Record["id"];
  $db2->query($query);

  $query="update top_active_users set week1=0, week2=0 where id=".$db->Record["id"];
  $db2->query($query);
}

$query="delete from al_finance_log";
$db2->query($query);

$query="delete from alliance_members";
$db2->query($query);

$query="delete from alliances";
$db2->query($query);

$query="delete from attack_log";
$db2->query($query);

$query="delete from superattack_log";
$db2->query($query);

$query="delete from login_log";
$db2->query($query);

$query="delete from mail";
$db2->query($query);

$query="delete from sentbox";
$db2->query($query);

$query="delete from online_statistic";
$db2->query($query);

$query="delete from spy_log";
$db2->query($query);

$query="delete from superattack_log";
$db2->query($query);

$query="delete from user_weapons";
$db2->query($query);

$query="delete from visitors";
$db2->query($query);

$query="delete from votes";
$db2->query($query);
*/
?>
