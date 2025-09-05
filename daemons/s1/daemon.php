<?php

//echo "cron started on ".date("Y-m-d H:i:s");

//error_reporting(E_ERROR);
error_reporting(E_ALL ^ E_DEPRECATED);

include 'database.php';

$time = time() + 9 * 3600;

$datetime=getdate($time);



function semafor_on($uid)
{

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $semafor=0;
  $try=0;

  $acceptedChars = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789';
  $max = strlen($acceptedChars)-1;
  $semafor_key = null;
  for($i=0; $i < 64; $i++) {
   $semafor_key .= $acceptedChars[mt_rand(0, $max)];
  }

  while(!$semafor && $try<50)
  {
    $query="update semafor set armory=1, skey='".$semafor_key."' where id=".$uid." and armory=0";
    $db_theend->query($query);

    $query="select armory, skey from semafor where id=".$uid;
    $db_theend->query($query);
    $db_theend->next_record();

    if($db_theend->Record["armory"]==1 && $db_theend->Record["skey"]==$semafor_key)
      $semafor=1;
    if(!$semafor)
    {
      usleep(100000);
      $try++;
    }
  }
  if($try>=50)
  {
    echo "\n".date("Y-m-d H:i:s",$time)." daemon: Semafor error on user ".$uid;
  }
  return 1;
}

function semafor_off($uid)
{

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="update semafor set armory=0, skey='' where id=".$uid;
  $db_theend->query($query);

  return 1;
}

function date_difference($a,$b,$units)
{
        $dif=mktime($a["hours"],$a["minutes"],$a["seconds"],$a["mon"],$a["mday"],$a["year"])-strtotime($b);
        switch($units)
        {
        case "minutes":
                         return $dif/60;
                         break;
        }
}

function acct($id,$gold,$attack,$units,$workers,$level,$exp,$datetime,$goldupgrade,$turns)
{
        $db = new DataBase_theend;
        $db->connect();
        $db2 = new DataBase_theend;
        $db2->connect();        

        if($exp>=pow(2,$level)*1000)
        {
          $level=$level+1;
          $exp=$exp-pow(2,$level-1)*1000;
        }
        $turns++;
        $turns++;
        if($turns>1000) $turns=1000;

        $query="update armory set exp=".$exp.", level=".$level.", gold=gold+100+level*100+".floor($units+(10+$goldupgrade)*$workers).", lastacct='".$datetime["year"]."-".$datetime["mon"]."-".$datetime["mday"]." ".$datetime["hours"].":".$datetime["minutes"].":".$datetime["seconds"]."', turn=".$turns." where id=".$id;
        $db->query($query);
        
        // upgrades levels update
        
        $query="select attack_time, defense_time, spy_time, antispy_time, worker_time, wprec_time, population_time, elite_time from upgrades where id=".$id;
        $db->query($query);
        $db->next_record();
        if($db->Record["attack_time"]>0)
        {
           $attack_time=$db->Record["attack_time"]-1;
           if($attack_time==0)
           {
             $query="update upgrades set attack_time=".$attack_time.", attack=attack+1 where id=".$id;
             $db2->query($query);
           }
           else 
           {
           	 $query="update upgrades set attack_time=".$attack_time." where id=".$id;
           	 $db2->query($query);
           }
        }
        
        if($db->Record["defense_time"]>0)
        {
           $defense_time=$db->Record["defense_time"]-1;
           if($defense_time==0)
           {
             $query="update upgrades set defense_time=".$defense_time.", defense=defense+1 where id=".$id;
             $db2->query($query);
           }
           else 
           {
           	 $query="update upgrades set defense_time=".$defense_time." where id=".$id;
           	 $db2->query($query);
           }
        } 
        
        if($db->Record["spy_time"]>0)
        {
           $spy_time=$db->Record["spy_time"]-1;
           if($spy_time==0)
           {
             $query="update upgrades set spy_time=".$spy_time.", spy=spy+1 where id=".$id;
             $db2->query($query);
           }
           else 
           {
           	 $query="update upgrades set spy_time=".$spy_time." where id=".$id;
           	 $db2->query($query);
           }
        }
        
        if($db->Record["antispy_time"]>0)
        {
           $antispy_time=$db->Record["antispy_time"]-1;
           if($antispy_time==0)
           {
             $query="update upgrades set antispy_time=".$antispy_time.", antispy=antispy+1 where id=".$id;
             $db2->query($query);
           }
           else 
           {
           	 $query="update upgrades set antispy_time=".$antispy_time." where id=".$id;
           	 $db2->query($query);
           }
        } 
        
        if($db->Record["worker_time"]>0)
        {
           $worker_time=$db->Record["worker_time"]-1;
           if($worker_time==0)
           {
             $query="update upgrades set worker_time=".$worker_time.", worker=worker+1 where id=".$id;
             $db2->query($query);
           }
           else 
           {
           	 $query="update upgrades set worker_time=".$worker_time." where id=".$id;
           	 $db2->query($query);
           }
        }
        
        if($db->Record["wprec_time"]>0)
        {
           $wprec_time=$db->Record["wprec_time"]-1;
           if($wprec_time==0)
           {
             $query="update upgrades set wprec_time=".$wprec_time.", wprec=wprec+1 where id=".$id;
             $db2->query($query);
           }
           else 
           {
           	 $query="update upgrades set wprec_time=".$wprec_time." where id=".$id;
           	 $db2->query($query);
           }
        }   
        
        if($db->Record["population_time"]>0)
        {
           $population_time=$db->Record["population_time"]-1;
           if($population_time==0)
           {
             $query="update upgrades set population_time=".$population_time.", population=population+1 where id=".$id;
             $db2->query($query);
           }
           else 
           {
           	 $query="update upgrades set population_time=".$population_time." where id=".$id;
           	 $db2->query($query);
           }
        } 

        if($db->Record["elite_time"]>0)
        {
           $elite_time=$db->Record["elite_time"]-1;
           if($elite_time==0)
           {
             $query="update upgrades set elite_time=".$elite_time.", elite=elite+1 where id=".$id;
             $db2->query($query);
           }
           else 
           {
           	 $query="update upgrades set elite_time=".$elite_time." where id=".$id;
           	 $db2->query($query);
           }
        }                
}

function acct_newusers($datetime)
{
        $db = new DataBase_theend;
        $db->connect();
        $db2 = new DataBase_theend;
        $db2->connect();

        $query="select * from newusers";
        $db->query($query);
        while($db->next_record())
        {
              if(date_difference($datetime,$db->Record["data"],"minutes")>48*60)
              {
                     $query2="delete from newusers where id=".$db->Record["id"];
                     $db2->query($query2);
              }
        }
}

function acct_attacklog()
{
        $db = new DataBase_theend;
        $db->connect();

        $query="delete from attack_log where date<'".date("Y-m-d", mktime(0,0,0, date('m'), date('d')-7, date('Y')) + 9 * 3600)."'";
        $db->query($query);
}

function acct_spylog()
{
        $db = new DataBase_theend;
        $db->connect();

        $query="delete from spy_log where datetime<'".date("Y-m-d", mktime(0,0,0, date('m'), date('d')-7, date('Y')) + 9 * 3600)."'";
        $db->query($query);
}

function acct_loginlog()
{
        $db = new DataBase_theend;
        $db->connect();

        $query="delete from login_log where datetime<'".date("Y-m-d", mktime(0,0,0, date('m'), date('d')-30, date('Y')) + 9 * 3600)."'";
        $db->query($query);
}

function acct_active_users()
{
        $db = new DataBase_theend;
        $db->connect();
        $db2 = new DataBase_theend;
        $db2->connect();

        $query="select id from online where datetime<'".date("Y-m-d H:i:s", mktime(date('H'),date('i'),date('s'), date('m'), date('d')-3, date('Y')) + 9 * 3600)."'";
        $db->query($query);
        while($db->next_record())
        {
                $query2="update online set online=-1 where id=".$db->Record["id"];
                $db2->query($query2);
        }
}

function acct_visitors()
{
        $db = new DataBase_theend;
        $db->connect();
        $db2 = new DataBase_theend;
        $db2->connect();

        $query="delete from visitors where datetime<'".date("Y-m-d H:i:s", mktime(date('H'),date('i')-1,date('s'), date('m'), date('d'), date('Y')) + 9 * 3600)."'";
        $db->query($query);
}

function acct_mail()
{
        $db = new DataBase_theend;
        $db->connect();
        $db2 = new DataBase_theend;
        $db2->connect();

        $query="delete from mail where datetime<'".date("Y-m-d H:i:s", mktime(0,0,0, date('m'), date('d')-30, date('Y')) + 9 * 3600)."'";
        $db->query($query);

        $query="delete from sentbox where datetime<'".date("Y-m-d H:i:s", mktime(0,0,0, date('m'), date('d')-30, date('Y')) + 9 * 3600)."'";
        $db->query($query);
}


$db_theend = new DataBase_theend;
$db_theend->connect();
$db = new DataBase_theend;
$db->connect();
$db2 = new DataBase_theend;
$db2->connect();

$query="select armory.id, armory.gold, armory.attack, armory.untrained, armory.workers, armory.level, armory.exp, armory.lastacct, armory.turnlen, armory.turn, upgrades.worker as goldupgrade from armory, upgrades, online where armory.id=upgrades.id and armory.id=online.id and online.online>=0 order by armory.id";
$db_theend->query($query);
while($db_theend->next_record())
{
                semafor_on($db_theend->Record["id"]);
                acct($db_theend->Record["id"],$db_theend->Record["gold"],$db_theend->Record["attack"],$db_theend->Record["untrained"],$db_theend->Record["workers"],$db_theend->Record["level"],$db_theend->Record["exp"],$datetime,$db_theend->Record["goldupgrade"],$db_theend->Record["turn"]);
                semafor_off($db_theend->Record["id"]);
}


acct_visitors();

if($datetime["hours"]==0 && $datetime["minutes"]<10)
{
       acct_newusers($datetime);
       acct_attacklog();
       acct_spylog();
       acct_loginlog();
       acct_active_users();
       acct_mail();
}

$query="select id from online where online=1 and datetime<'".date("Y-m-d H:i:s", mktime(date('H'),date('i')-5,date('s'), date('m'), date('d'), date('Y')) + 9 * 3600)."'";
$db_theend->query($query);

while($db_theend->next_record())
{
      $query="update online set online=0, datetime='".date("Y-m-d H:i:s",$time)."', seconds_day=seconds_day+".$time."-login_time where id=".$db_theend->Record["id"];
      $db->query($query);
}
?>
