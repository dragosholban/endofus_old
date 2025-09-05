<?php

include 'database.php';
$time = time() + 9 * 3600;
$datetime=getdate($time);

function delete_user($uid)
{
$db_theend = new DataBase_theend;

$query="select id, username, email from users where id='".$uid."'";
$db_theend->query($query);
if($db_theend->num_rows())
{
        $db_theend->next_record();
        $id=$db_theend->Record["id"];
        $username=$db_theend->Record["username"];
        $email=$db_theend->Record["email"];

        $query="delete from users where id=".$id;
        $db_theend->query($query);
        $query="delete from armory where id=".$id;
        $db_theend->query($query);
        $query="delete from semafor where id=".$id;
        $db_theend->query($query);
        $query="delete from seif where uid=".$id;
        $db_theend->query($query);
        $query="delete from online where id=".$id;
        $db_theend->query($query);
        $query="delete from upgrades where id=".$id;
        $db_theend->query($query);
        $query="delete from mastery where id=".$id;
        $db_theend->query($query);
        $query="delete from user_weapons where id=".$id;
        $db_theend->query($query);
        $query="delete from user_profile where id=".$id;
        $db_theend->query($query);
        $query="delete from top_active_users where id=".$id;
        $db_theend->query($query);
        $query="delete from attack_log where at_id=".$id;
        $db_theend->query($query);
        $query="delete from attack_log where df_id=".$id;
        $db_theend->query($query);
        $query="delete from spy_log where df_id=".$id;
        $db_theend->query($query);
        $query="delete from spy_log where at_id=".$id;
        $db_theend->query($query);
        $query="delete from mail where fromuser=".$id;
        $db_theend->query($query);
        $query="delete from mail where touser=".$id;
        $db_theend->query($query);
        $query="delete from sentbox where touser=".$id;
        $db_theend->query($query);
        $query="delete from sentbox where fromuser=".$id;
        $db_theend->query($query);
        $query="select id from alliances where commander='".$user."'";
        $db_theend->query($query);
        if($db_theend->num_rows())
        {
        $db_theend->next_record();
        $idal=$db_theend->Record["id"];
        $query="delete from alliances where id=".$idal;
        $db_theend->query($query);
        $query="delete from alliance_members where id_al=".$idal;
        $db_theend->query($query);
        $query="delete from superattack_log where at_id=".$idal;
        $db_theend->query($query);
        $query="delete from al_finance_log where id_al=".$idal;
        $db_theend->query($query);
        }
        $query="delete from alliance_members where id_member=".$id;
        $db_theend->query($query);
        $query="delete from votes where user_id=".$id;
        $db_theend->query($query);

        echo "User ".$user." deleted!<br>";
  }      	
}

function power_sentry($id)
{  
  $db = new DataBase_theend;
  $db->connect();
  
  $query="select armory.antispy as sentries, upgrades.antispy as sentrylevel from armory, upgrades where armory.id=".$id." and upgrades.id=armory.id";
  $db->query($query);
  $db->next_record();
  $sentries=$db->Record["sentries"];
  $sentrylevel=$db->Record["sentrylevel"];
  
  $unitsentrypower=5;
  
  $power=0;
  
  $power=$power+$sentries*$unitsentrypower;
  
  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$id." and user_weapons.w1=weapons.id and weapons.type=4 order by weapons.power desc";
  $db->query($query); 
  while($db->next_record())
  {
    if($sentries>0)
    {
      if($sentries>=$db->Record["no"])
      {
        $power=$power+$db->Record["proc"]*$unitsentrypower;
        $sentries=$sentries-$db->Record["no"];      	
      }
      else
      {
      	$power=$power+$db->Record["proc"]/$db->Record["no"]*$sentries*$unitsentrypower;
      	$sentries=0;
      }
    }
  }
  
  $power=round($power+(($sentrylevel*10)/100)*$power);
  	
  return $power;
}

function power_spy($id)
{
  $db = new DataBase_theend;
  $db->connect();
  
  $query="select armory.spy as spies, upgrades.spy as spylevel from armory, upgrades where armory.id=".$id." and upgrades.id=armory.id";
  $db->query($query);
  $db->next_record();
  $spies=$db->Record["spies"];
  $spylevel=$db->Record["spylevel"];
  
  $unitspypower=5;
  
  $power=0;
  
  $power=$power+$spies*$unitspypower;
  
  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$id." and user_weapons.w1=weapons.id and weapons.type=3 order by weapons.power desc";
  $db->query($query); 
  while($db->next_record())
  {
    if($spies>0)
    {
      if($spies>=$db->Record["no"])
      {
        $power=$power+$db->Record["proc"]*$unitspypower;
        $spies=$spies-$db->Record["no"];      	
      }
      else
      {
      	$power=$power+$db->Record["proc"]/$db->Record["no"]*$spies*$unitspypower;
      	$spies=0;
      }
    }
  }
  
  $power=round($power+(($spylevel*10)/100)*$power);
  	
  return $power;	
}

$db=new DataBase_theend;
$db->connect();

$db2=new DataBase_theend;
$db2->connect();

$query="select users.id, users.race, armory.units, armory.untrained, armory.attack as atunits, armory.elite_at as eliteat, armory.elite_df as elitedf, armory.workers as workunits, armory.spy as spies, armory.antispy as sentries, armory.units, upgrades.attack as atlevel, upgrades.defense as dflevel, upgrades.spy, upgrades.antispy, upgrades.worker from armory, users, upgrades, online where users.id=armory.id and users.id=upgrades.id and users.id=online.id and online.online>=0";
$db->query($query);
while($db->next_record())
{
  $unitattackpower=5;
  $unitdefensepower=5;
  $eliteattackpower=10;
  $elitedefensepower=10;
  $untrainedattackpower=1;
  $untraineddefensepower=1;

  $atlevel=$db->Record["atlevel"];
  $atunits=$db->Record["atunits"];
  $eliteat=$db->Record["eliteat"];
  $untrainedunits=$db->Record["untrained"];
  $power=0;
  $power=$power+$eliteat*$eliteattackpower+$atunits*$unitattackpower+$untrainedunits*$untrainedattackpower;
  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$db->Record["id"]." and user_weapons.w1=weapons.id and weapons.type=1 order by weapons.power desc";
  $db2->query($query);

//  echo "atunits=".$atunits." eliteat=".$eliteat." ";
//  echo $db->Record["id"]." : ".$power." (attack)\n";

  while($db2->next_record())
  {
      if($eliteat>0)
      {
          if($eliteat>=$db2->Record["no"])
          {
              $power=$power+$db2->Record["proc"]*$eliteattackpower;
              $eliteat=$eliteat-$db2->Record["no"];
          }
          else
          {
              $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$eliteat*$eliteattackpower;
              if($atunits>=$db2->Record["no"]-$eliteat)
              {
                $power=$power+$db2->Record["proc"]/$db2->Record["no"]*($db2->Record["no"]-$eliteat)*$unitattackpower;
                $atunits=$atunits-($db2->Record["no"]-$eliteat);
              }
              else
              {
                $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$atunits*$unitattackpower;
                if($untrainedunits>=$db2->Record["no"]-$eliteat-$atunits)
                {
                  $power=$power+$db2->Record["proc"]/$db2->Record["no"]*($db2->Record["no"]-$eliteat-$atunits)*$untrainedattackpower;
                  $untrainedunits=$untrainedunits-($db2->Record["no"]-$eliteat-$atunits);
                }
                else
                {
                  $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$untrainedunits*$untrainedattackpower;
                  $untrainedunits=0;
                }
                $atunits=0;
              }
              $eliteat=0;
          }
      }
      else
      {
      if($atunits>0)
      {
          if($atunits>=$db2->Record["no"])
          {
              $power=$power+$db2->Record["proc"]*$unitattackpower;
              $atunits=$atunits-$db2->Record["no"];
          }
          else
          {
              $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$atunits*$unitattackpower;
              if($untrainedunits>=$db2->Record["no"]-$atunits)
              {
                $power=$power+$db2->Record["proc"]/$db2->Record["no"]*($db2->Record["no"]-$atunits)*$untrainedattackpower;
                $untrainedunits=$untrainedunits-($db2->Record["no"]-$atunits);
              }
              else
              {
                $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$untrainedunits*$untrainedattackpower;
                $untrainedunits=0;
              }
              $atunits=0;
          }
      }
      else
      {
      if($untrainedunits>0)
      {
          if($untrainedunits>=$db2->Record["no"])
          {
              $power=$power+$db2->Record["proc"]*$untrainedattackpower;
              $untrainedunits=$untrainedunits-$db2->Record["no"];
              if($untrainedunits<0)
              {
                $untrainedunits=0;
              }
          }
          else
          {
              $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$untrainedunits*$untrainedattackpower;
              $untrainedunits=0;
          }
      }
      else
      {
        $untrainedunits=0;
      }
      }
      }
  }

  $attack_rank_value=round($power+(($atlevel*10)/100)*$power);

  $dflevel=$db->Record["dflevel"];
  $dfunits=$db->Record["atunits"];
  $elitedf=$db->Record["elitedf"];
  $untrainedunits=$db->Record["untrained"];
  $power=0;
  $power=$power+$elitedf*$elitedefensepower+$dfunits*$unitdefensepower+$untrainedunits*$untraineddefensepower;
  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$db->Record["id"]." and user_weapons.w1=weapons.id and weapons.type=0 order by weapons.power desc";
  $db2->query($query);

//  echo $db->Record["id"]." : ".$power." (defense)\n";

  while($db2->next_record())
  {
      if($elitedf>0)
      {
          if($elitedf>=$db2->Record["no"])
          {
              $power=$power+$db2->Record["proc"]*$elitedefensepower;
              $elitedf=$elitedf-$db2->Record["no"];
          }
          else
          {
              $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$elitedf*$elitedefensepower;
              if($dfunits>=$db2->Record["no"]-$elitedf)
              {
                $power=$power+$db2->Record["proc"]/$db2->Record["no"]*($db2->Record["no"]-$elitedf)*$unitdefensepower;
                $dfunits=$dfunits-($db2->Record["no"]-$elitedf);
              }
              else
              {
                $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$dfunits*$unitdefensepower;
                if($untrainedunits>=$db2->Record["no"]-$elitedf-$dfunits)
                {
                  $power=$power+$db2->Record["proc"]/$db2->Record["no"]*($db2->Record["no"]-$elitedf-$dfunits)*$untraineddefensepower;
                  $untrainedunits=$untrainedunits-($db2->Record["no"]-$elitedf-$dfunits);
                }
                else
                {
                  $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$untrainedunits*$untraineddefensepower;
                  $untrainedunits=0;
                }
                $dfunits=0;
              }
              $elitedf=0;
          }
      }
      else
      {
      if($dfunits>0)
      {
          if($dfunits>=$db2->Record["no"])
          {
              $power=$power+$db2->Record["proc"]*$unitdefensepower;
              $dfunits=$dfunits-$db2->Record["no"];
          }
          else
          {
              $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$dfunits*$unitdefensepower;
              if($untrainedunits>=$db2->Record["no"]-$dfunits)
              {
                $power=$power+$db2->Record["proc"]/$db2->Record["no"]*($db2->Record["no"]-$dfunits)*$untraineddefensepower;
                $untrainedunits=$untrainedunits-($db2->Record["no"]-$dfunits);
              }
              else
              {
                $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$untrainedunits*$untraineddefensepower;
                $untrainedunits=0;
              }
              $dfunits=0;
          }
      }
      else
      {
      if($untrainedunits>0)
      {
          if($untrainedunits>=$db2->Record["no"])
          {
              $power=$power+$db2->Record["proc"]*$untraineddefensepower;
              $untrainedunits=$untrainedunits-$db2->Record["no"];
              if($untrainedunits<0)
              {
                $untrainedunits=0;
              }
          }
          else
          {
              $power=$power+$db2->Record["proc"]/$db2->Record["no"]*$untrainedunits*$untraineddefensepower;
              $untrainedunits=0;
          }
      }
      else
      {
        $untrainedunits=0;
      }
      }
      }
  }

  $defense_rank_value=round($power+(($dflevel*10)/100)*$power);

  $spy_rank_value=power_spy($db->Record["id"]);
  $sentry_rank_value=power_sentry($db->Record["id"]);

  $rank_value=$attack_rank_value+$defense_rank_value+$spy_rank_value+$sentry_rank_value;

  $query2="update armory set rank_value=".$rank_value.", attack_rank_value=".$attack_rank_value.", defense_rank_value=".$defense_rank_value.", spy_rank_value=".$spy_rank_value.", sentry_rank_value=".$sentry_rank_value." where id=".$db->Record["id"];
  $db2->query($query2);
}

$rank=0;

$query="select armory.id from armory, online where online.online>=0 and armory.id=online.id order by attack_rank_value desc";
$db->query($query);
while($db->next_record())
{
  $rank++;
  $query2="update armory set attack_rank=".$rank." where id=".$db->Record["id"];
  $db2->query($query2);
}

$rank=0;

$query="select armory.id from armory, online where online.online>=0 and armory.id=online.id order by defense_rank_value desc";
$db->query($query);
while($db->next_record())
{
  $rank++;
  $query2="update armory set defense_rank=".$rank." where id=".$db->Record["id"];
  $db2->query($query2);
}

$rank=0;

$query="select armory.id from armory, online where online.online>=0 and armory.id=online.id order by spy_rank_value desc";
$db->query($query);
while($db->next_record())
{
  $rank++;
  $query2="update armory set spy_rank=".$rank." where id=".$db->Record["id"];
  $db2->query($query2);
}

$rank=0;

$query="select armory.id from armory, online where online.online>=0 and armory.id=online.id order by sentry_rank_value desc";
$db->query($query);
while($db->next_record())
{
  $rank++;
  $query2="update armory set sentry_rank=".$rank." where id=".$db->Record["id"];
  $db2->query($query2);
}

$rank=0;

$query="select armory.id, users.best_rank from armory, online, users where online.online>=0 and armory.id=online.id and armory.id=users.id order by armory.rank_value desc, armory.level desc, armory.exp desc";
$db->query($query);
while($db->next_record())
{
  $rank++;
  $query2="update armory set rank=".$rank." where id=".$db->Record["id"];
  $db2->query($query2);
  if($db->Record["best_rank"]==0 || $rank<$db->Record["best_rank"])
  {
    $query2="update users set best_rank=".$rank." where id=".$db->Record["id"];
    $db2->query($query2);
  }
}

$query2="update armory, online set armory.attack_rank=0, armory.defense_rank=0, armory.spy_rank=0, armory.sentry_rank=0, armory.rank=0 where online.online=-1 and online.id=armory.id";
$db2->query($query2);

  //echo $datetime["hours"]." hours, ".$datetime["minutes"]." minutes";

if($datetime["hours"]==0 && $datetime["minutes"]<10)
{
  $query="update online set seconds_day=0";
  //echo $query;
  $db->query($query);
  $query="update online set login_time=".$time;
  //echo $query;
  $db->query($query);
  $query="delete from votes";
  //echo $query;
  $db->query($query);
  
  //trimite mail userilor care nu au mai intrat de 60 de zile
  
  $query="select online.id, online.datetime, users.username, users.email from online, users where online.datetime<'".date("Y-m-d H:i:S", mktime(0, 0, 0, date(m), date(d)-60, date(Y)) + 9 * 3600)."' and online.datetime>='".date("Y-m-d H:i:S", mktime(0, 0, 0, date(m), date(d)-61, date(Y)) + 9 * 3600)."' and online.id=users.id";
  $db->query($query);
  
  while($db->next_record())
  {
    $subject="END OF US Is Missing You";
  	
    $email_header="From: noreply@endofus.net\n";
    
  	$text="Greetings,\n\n";
  	$text=$text."You haven't been on End of Us for 60 days and we miss you. Come back and play with us!\n\n";
  	$text=$text."Your login details has been attached to refresh your memory.\n\n";  	
  	$text=$text."URL: http://www.endofus.net/s2 \n\n";
  	$text=$text."Username: ".$db->Record["username"]."\n\n";
  	$text=$text."We hope to see you soon!\n\n\n";
  	
  	$text=$text."PS: If you do not wish to come back your account and all related data will be removed from our database 10 days from now.\n";
    
  	if(mail($db->Record["email"],$subject,$text,$email_header))
  	{
  	  echo $text."\nMail sent to user ".$db->Record["id"]."(".$db->Record["username"].") at ".$db->Record["email"].". User last seen: ".$db->Record["datetime"]."\n\n";	
  	}
  	else 
  	{
  	  echo "\n Mail error!\n";	
  	}
  }
  
  //sterge userii care nu au intrat de 70 de zile
  
  $query="select online.id, online.datetime, users.username from online, users where online.datetime<'".date("Y-m-d H:i:S", mktime(0, 0, 0, date(m), date(d)-70, date(Y)) + 9 * 3600)."' and online.id=users.id";
  $db->query($query); 
  
  while($db->next_record())
  {
    echo "\nDelete user ".$db->Record["id"]."(".$db->Record["username"]."). User last seen: ".$db->Record["datetime"]."\n";	
    delete_user($db->Record["id"]);
  }   
}

?>
