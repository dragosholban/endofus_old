<?php

function attack2()
{

  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db2 = new DataBase_theend;
  $db2->connect();
  $db3 = new DataBase_theend;
  $db3->connect();

  global $no_queries;
  
  $site_language=site_language();

  $now=getdate();

  $dfid=$_POST["user"];
  
  if($_POST["superattack"]=="superattack")
  {
  	$superattack=1;
  }
  else 
  {
  	$superattack=0;
  }
  
  semafor_on($_COOKIE["uid"]);
  semafor_on($dfid);

  $query="select users.race, armory.turn, armory.rank_value, armory.rank, armory.attack, armory.elite_at, armory.level, armory.exp, armory.gold, armory.id, armory.units, armory.untrained, armory.power_bonus, armory.super_attack from users, armory where users.id='".$_COOKIE["uid"]."' and users.id=armory.id";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();

  $attack_id=$db_theend->Record["id"];
  
  $last_super_attack=strtotime($db_theend->Record["super_attack"]);
  if(time()-$last_super_attack<86400)
    $superattack=0;

  $attack_turns=floor($_POST["turns"]);
  if($attack_turns>10)
  {
    semafor_off($_COOKIE["uid"]);
    semafor_off($dfid);    
  	
  	return -1;
  }
  if($attack_turns<1)
  {
    semafor_off($_COOKIE["uid"]);
    semafor_off($dfid);    
  	
  	return -2;
  }
  if($db_theend->Record["turn"]<1)
  {
    semafor_off($_COOKIE["uid"]);
    semafor_off($dfid);    
  	
  	return -4;
  }
  if($attack_turns>$db_theend->Record["turn"])
  {
    semafor_off($_COOKIE["uid"]);
    semafor_off($dfid);    
  	
  	return -3;
  }


  $attack_elite_units=$db_theend->Record["elite_at"];
  $attack_units_trained=$db_theend->Record["attack"];
  $attack_level=$db_theend->Record["level"];
  $attack_exp=$db_theend->Record["exp"];
  $attack_rank=$db_theend->Record["rank"];
  $attack_rank_value=rank_value($_COOKIE["uid"]);
  $attack_gold=$db_theend->Record["gold"];
  $attack_untrained_units=$db_theend->Record["untrained"];
  $attack_total_units=$db_theend->Record["units"];
  $attack_units=$attack_elite_units+$attack_units_trained+$attack_untrained_units;
  $attack_power_bonus=$db_theend->Record["power_bonus"];

  $query2="select id_al, grade from alliance_members where id_member=".$_COOKIE["uid"]." and grade>=0";
  $db2->query($query2);
  $no_queries+=1;
  if($db2->num_rows())
  {
       $db2->next_record();
       $al_grade=$db2->Record["grade"];
       $alliance_power=power_attack_alliance($db2->Record["id_al"]);
  }
  else
  {
       $al_grade=-1;
       $alliance_power=0;
  }

  $self_attack_power=power_attack($attack_id);
  $attack_power_result=power_attack_with_precision($attack_id);
  $self_attack_power_with_precision=$attack_power_result["power"];
  $attack_power=$self_attack_power;
  $attack_power_with_precision=$self_attack_power_with_precision;
  $attack_precision=$attack_power_result["precision"];

  if($al_grade==0) // membru
  {
    $attack_power=min(round($self_attack_power+0.006*$alliance_power),1.5*$self_attack_power);
    $attack_power_with_precision=min(round($self_attack_power_with_precision+0.006*$alliance_power),1.5*$self_attack_power_with_precision);
  }
  if($al_grade==1) // comandant
  {
    $attack_power=min(round($self_attack_power+0.01*$alliance_power),1.5*$self_attack_power);
    $attack_power_with_precision=min(round($self_attack_power_with_precision+0.01*$alliance_power),1.5*$self_attack_power_with_precision);
  }
  if($al_grade==2) // ofiter
  {
    $attack_power=min(round($self_attack_power+0.008*$alliance_power),1.5*$self_attack_power);
    $attack_power_with_precision=min(round($self_attack_power_with_precision+0.008*$alliance_power),1.5*$self_attack_power_with_precision);
  }

  $attack_power_without_precision=$attack_power;
  if($superattack==1) $attack_power_without_precision=$attack_power_without_precision*2;
  $attack_power=$attack_power_with_precision;
  if($superattack==1) $attack_power=$attack_power*2;

  if($attack_power<=0)
  {
    semafor_off($_COOKIE["uid"]);
    semafor_off($dfid);    
  	
  	return -5;
  }

  $query="select armory.rank_value, armory.rank, armory.elite_df, armory.attack, armory.level, armory.exp, armory.gold, armory.id, armory.units, armory.untrained, armory.workers, armory.spy, armory.antispy, armory.power_bonus from users, armory where users.id=".$_POST["user"]." and users.id=armory.id";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();
  $defense_id=$db_theend->Record["id"];
  $defense_elite_units=$db_theend->Record["elite_df"];
  $defense_units=$db_theend->Record["attack"];
  $defense_elite_attack_units=$db_theend->Record["elite_at"];
  $defense_level=$db_theend->Record["level"];
  $defense_exp=$db_theend->Record["exp"];
  $defense_gold=$db_theend->Record["gold"];
  $defense_total_units=$db_theend->Record["units"];
  $defense_untrained_units=$db_theend->Record["untrained"];
  $defense_workers=$db_theend->Record["workers"];
  $defense_spy=$db_theend->Record["spy"];
  $defense_antispy=$db_theend->Record["antispy"];
  $defense_rank=$db_theend->Record["rank"];
  $defense_rank_value=rank_value($_POST["user"]);
  $defense_power_bonus=$db_theend->Record["power_bonus"];

  $query2="select alliance_members.id_al, alliance_members.grade from alliance_members where id_member=".$defense_id." and alliance_members.grade>=0";
  $db2->query($query2);
  $no_queries+=1;
  if($db2->num_rows())
  {
       $db2->next_record();
       $al_grade=$db2->Record["grade"];
       $alliance_power=power_defense_alliance($db2->Record["id_al"]);
  }
  else
  {
       $al_grade=-1;
       $alliance_power=0;
  }

    //$self_defense_power=power_defense($defense_id);
    $defense_power_result=power_defense_with_precision($defense_id);
    $self_defense_power_with_precision=$defense_power_result["power"];
    //$defense_power=$self_defense_power;
    $defense_power_with_precision=$self_defense_power_with_precision;
    $defense_precision=$defense_power_result["precision"];

  if($al_grade==0) // membru
  {
    //$defense_power=min(round($self_defense_power+0.006*$alliance_power),1.5*$self_defense_power);
    $defense_power_with_precision=min(round($self_defense_power_with_precision+0.006*$alliance_power),1.5*$self_defense_power_with_precision);
  }
  if($al_grade==1) // comandant
  {
    //$defense_power=min(round($self_defense_power+0.01*$alliance_power),1.5*$self_defense_power);
    $defense_power_with_precision=min(round($self_defense_power_with_precision+0.01*$alliance_power),1.5*$self_defense_power_with_precision);
  }
  if($al_grade==2) // ofiter
  {
    //$defense_power=min(round($self_defense_power+0.008*$alliance_power),1.5*$self_defense_power);
    $defense_power_with_precision=min(round($self_defense_power_with_precision+0.008*$alliance_power),1.5*$self_defense_power_with_precision);
  }


  $densitatea=pow($attack_total_units/$defense_total_units,1/3);
  //if($densitatea<0.5) $densitatea=0.5;
  //if($densitatea>1.5) $densitatea=1.5;
  if($attack_level>=$defense_level && $densitatea<1)
  {
  	$densitatea=1;
  }
  $defense_power=round($densitatea*$defense_power_with_precision);

  /*power bonuses*/

  //$attack_power=round($attack_power*(100+$attack_power_bonus)/100);
  
  //$defense_power=round($defense_power*(100+$defense_power_bonus)/100);

  $atpp=$attack_power*100/($attack_power+$defense_power);
  $dfpp=$defense_power*100/($attack_power+$defense_power);

  $query="select count(id) as attacks from attack_log where at_id=".$_COOKIE["uid"]." and df_id=".$defense_id." and date>'".date("Y-m-d H:i:s", mktime(date(H), date(i), date(s), date(m), date(d)-1, date(Y)))."'";
  $db_theend->query($query);
  $db_theend->next_record();
  $yours_attacks=$db_theend->Record["attacks"];

  $query="select count(id) as attacks from attack_log where df_id=".$defense_id." and win_id=at_id and date>'".date("Y-m-d H:i:s", mktime(date(H), date(i), date(s), date(m), date(d)-1, date(Y)))."'";
  $db_theend->query($query);
  $db_theend->next_record();
  $attacks=$db_theend->Record["attacks"]; // nr. de atacuri primite si pierdute in ultimile 24 de ore

  $query="select dfp, date from attack_log where df_id=".$defense_id." and at_id=".$attack_id." and date>'".date("Y-m-d H:i:s", mktime(date(H)-3, date(i), date(s), date(m), date(d), date(Y)))."' order by date desc limit 1";
  $db_theend->query($query);
  if($db_theend->num_rows())
  {
    $db_theend->next_record();
    $last_attack_date=$db_theend->Record["date"];
    $last_attack_dfp=$db_theend->Record["dfp"];

    if($attack_power_without_precision<=$last_attack_dfp)
    {
      semafor_off($_COOKIE["uid"]);
      semafor_off($dfid);      
    	
      return -6;
    }
  }

  /*
  echo "<br>Attacks on this user in the last 24 hours: ".$attacks."<br>";

  echo "<br>Attack power: ".$attack_power." (".$atpp."%)<br>";
  echo "<br>Attack power with precision: ".$attack_power_with_precision." (".$atpp."%)<br>";
  echo "<br>Self attack power: ".$self_attack_power." (".$atpp."%)<br>";
  echo "<br>Self attack power with precision: ".$self_attack_power_with_precision." (".$atpp."%)<br>";
  echo "<br>Defense power: ".$defense_power." (".$dfpp."%)<br>";
  echo "<br>Defense power with precision: ".$defense_power_with_precision." (".$dfpp."%)<br>";
  echo "<br>Self defense power: ".$self_defense_power." (".$atpp."%)<br>";
  echo "<br>Self defense power with precision: ".$self_defense_power_with_precision." (".$atpp."%)<br>";
  echo "<br>Attack rank value: ".$attack_rank_value."<br>";
  echo "<br>Defense rank value: ".$defense_rank_value."<br>";

  echo "<br>Coeficient densitate: ".pow($attack_total_units/$defense_total_units,1/3)."<br>";
  echo "Defense power: ".round(pow($attack_total_units/$defense_total_units,1/3)*$defense_power)." (".$dfpp."%)<br>";
  */

  
  if($attack_power>$defense_power)
  {
    $proc_gold_stolen=(6/50*$atpp-6)*$attack_turns;  // max 60% atunci cand atpp=100% si se ataca cu maximum de 10 turnuri
    $gold_stolen=floor(($proc_gold_stolen/100)*$defense_gold);

    if($densitatea<1) $gold_stolen=floor($gold_stolen*$densitatea);
    
    if($gold_stolen<0) $gold_stolen=0;
    
    $proc_elite_defense_units_killed=(0.5/50*$atpp-0.5)*$attack_turns; // max 5% atunci cand atpp=100% si se ataca cu maximum de 10 turnuri
    $defense_elite_units_killed=floor(($proc_elite_defense_units_killed/100)*$defense_elite_units); // 3/4 din unitatile omorate chiar mor
    if(100-$attacks*10>0)
    {
      $defense_elite_units_killed=floor($defense_elite_units_killed*(100-$attacks*10)/100); // pt. fiecare atac primit in ultimile 24 de ore pierderile de unitati se diminueaza cu 10%
    }
    else
    {
      $defense_elite_units_killed=0;
    }

    $proc_defense_units_killed=(1/50*$atpp-1)*$attack_turns; // max 10% atunci cand atpp=100% si se ataca cu maximum de 10 turnuri
    $defense_units_killed=floor((($proc_defense_units_killed/100)*$defense_units)*(3/4)); // 3/4 din unitatile omorate chiar mor
    if(100-$attacks*10>0)
    {
      $defense_units_killed=floor($defense_units_killed*(100-$attacks*10)/100); // pt. fiecare atac primit in ultimile 24 de ore pierderile de unitati se diminueaza cu 10%
    }
    else
    {
      $defense_units_killed=0;
    }
    $defense_units_captured=floor((($proc_defense_units_killed/100)*$defense_units)*(1/4)); // 1/4 din unitatile omorate sunt capturate
    if(100-$attacks*10>0)
    {
      $defense_units_captured=floor($defense_units_captured*(100-$attacks*10)/100); // pt. fiecare atac primit in ultimile 24 de ore pierderile de unitati se diminueaza cu 10%
    }
    else
    {
      $defense_units_captured=0;
    }

    $proc_defense_untrained_killed=(2/50*$atpp-2)*$attack_turns; // max 20% atunci cand atpp=100% si se ataca cu maximum de 10 turnuri
    $defense_untrained_killed=floor(($proc_defense_untrained_killed/100)*$defense_untrained_units);
    if(100-$attacks*10>0)
    {
      $defense_untrained_killed=floor($defense_untrained_killed*(100-$attacks*10)/100); // pt. fiecare atac primit in ultimile 24 de ore pierderile de unitati se diminueaza cu 10%
    }
    else
    {
      $defense_untrained_killed=0;
    }

    $proc_defense_workers_killed=(0.5/50*$atpp-0.5)*$attack_turns; // max 5% atunci cand atpp=100% si se ataca cu maximum de 10 turnuri
    $defense_workers_killed=floor(($proc_defense_workers_killed/100)*$defense_workers);
    if(100-$attacks*10>0)
    {
      $defense_workers_killed=floor($defense_workers_killed*(100-$attacks*10)/100); // pt. fiecare atac primit in ultimile 24 de ore pierderile de unitati se diminueaza cu 10%
    }
    else
    {
      $defense_workers_killed=0;
    }

      //Experienta castigata de atacator

      if($defense_rank_value>$attack_rank_value*1.5)
      {
        $experience_gained=100;
      }
      if($defense_rank_value<=$attack_rank_value*1.5 && $defense_rank_value>$attack_rank_value/1.5)
      {
        $experience_gained=75;
      }
      if($defense_rank_value<=$attack_rank_value/1.5 && $defense_rank_value>$attack_rank_value/4)
      {
        $experience_gained=50;
      }
      if($defense_rank_value<=$attack_rank_value/4)
      {
        $experience_gained=-10;
      }

      $experience_gained=round($experience_gained/10*$attack_turns);

      if($attack_level-1>$defense_level && $experience_gained>0)
        $experience_gained=0;
      if($attack_level>$defense_level && $experience_gained>0)
        $experience_gained=round($experience_gained/2);

      if($experience_gained>0)
      {
        $experience_gained=floor($experience_gained*(100-$yours_attacks*30)/100);  // pt. fiecare atac dat aceluiasi jucator in ultimile 24 de ore exp. castigata se diminueaza cu 30%
        if($experience_gained<0) $experience_gained=0;
      }

      //Experienta pierduta de cel atacat

      if($attack_rank_value>$defense_rank_value)
      {
        $df_exp_lost=10;
      }
      if($attack_rank_value<=$defense_rank_value && $attack_rank_value>$defense_rank_value/4)
      {
        $df_exp_lost=50;
      }
      if($attack_rank_value<=$defense_rank_value/4)
      {
        $df_exp_lost=100;
      }

      $df_exp_lost=round($df_exp_lost/10*$attack_turns);
      
      $df_exp_lost=floor($df_exp_lost*(100-$yours_attacks*30)/100); // pt. fiecare atac dat aceluiasi jucator in ultimile 24 de ore exp. pierduta de acesta se diminueaza cu 30%

      if($df_exp_lost<0) $df_exp_lost=0;

    $query="update top_active_users set week1=week1+".$experience_gained." where id=".$attack_id;
    $db_theend->query($query);
    $query="update top_active_users set week1=week1-".$df_exp_lost." where id=".$defense_id;
    $db_theend->query($query);

    $real_experience_gained=$experience_gained;
    $real_df_exp_lost=$df_exp_lost;
    
    if($attack_exp+$experience_gained>=pow(2,$attack_level)*1000)
    {
      $attack_exp=$attack_exp+$experience_gained-pow(2,$attack_level)*1000;
      $attack_level=$attack_level+1;
    }
    else
    {
      $attack_exp=$attack_exp+$experience_gained;
      if($attack_exp<0)
      {
        $attack_exp=0;
      }
    }

    if($experience_gained<0)
    {
      if($attack_exp+$experience_gained<0)
      {
        if($attack_level>0)
        {
          $attack_level=$attack_level-1;
          $attack_exp=$attack_exp+pow(2,$attack_level)*1000+$experience_gained;
        }
      }
    }

    if($defense_exp-$df_exp_lost<0 && $defense_level>0)
    {
      $defense_level=$defense_level-1;
      $df_exp_lost=$df_exp_lost-$defense_exp;
      $defense_exp=pow(2,$defense_level)*1000;
      $defense_exp=$defense_exp-$df_exp_lost;
    }
    else
    {
      if($defense_exp-$df_exp_lost<0 && $defense_level==0)
      {
        $defense_exp=0;
      }
      else
      {
        if($defense_exp-$df_exp_lost>=0)
        {
          $defense_exp=$defense_exp-$df_exp_lost;
        }
      }
    }

    if($superattack)
    {
      $query="update armory set gold=".($attack_gold+$gold_stolen).", untrained=".($attack_untrained_units+$defense_units_captured).", units=".($attack_total_units+$defense_units_captured).", exp=".$attack_exp.", level=".$attack_level.", turn=turn-".$attack_turns.", super_attack='".date("Y-m-d H:i:s")."' where id=".$attack_id;
    }
    else 
    {
      $query="update armory set gold=".($attack_gold+$gold_stolen).", untrained=".($attack_untrained_units+$defense_units_captured).", units=".($attack_total_units+$defense_units_captured).", exp=".$attack_exp.", level=".$attack_level.", turn=turn-".$attack_turns." where id=".$attack_id;
    }
    $db_theend->query($query);
    $no_queries+=1;
    $query="update armory set units=".($defense_total_units-$defense_elite_units_killed-($defense_units_killed+$defense_units_captured)-$defense_untrained_killed-$defense_workers_killed).",elite_df=".($defense_elite_units-$defense_elite_units_killed).", attack=".($defense_units-($defense_units_killed+$defense_units_captured)).", untrained=".($defense_untrained_units-$defense_untrained_killed).", workers=".($defense_workers-$defense_workers_killed).", gold=gold-".$gold_stolen.", exp=".$defense_exp.", level=".$defense_level." where id=".$defense_id;
    $db_theend->query($query);
    $no_queries+=1;

    $query="insert into attack_log values(DEFAULT,".$attack_id.",".$defense_id.",'".date("Y-m-d H:i:s")."',".$attack_id.",".($defense_elite_units_killed+$defense_units_killed+$defense_untrained_killed+$defense_workers_killed).",".$defense_units_captured.",".$real_experience_gained.",".$gold_stolen.",".$attack_power.",".$defense_power.",".$attack_units.",".($defense_units+$defense_elite_units+$defense_untrained_units).",".$real_df_exp_lost.",".$attack_turns.",".$attack_total_units.",".$defense_total_units.",".$densitatea.",".$attack_precision.",".$defense_precision.",".$superattack.")";
    $db_theend->query($query);
    $query="select LAST_INSERT_ID() as id from attack_log";
    $db_theend->query($query);
    $db_theend->next_record();
    $attack_log_id=$db_theend->Record["id"];
    $no_queries+=1;

    // mastery

    $query="update mastery set battle=battle+1, battle_win=battle_win+1 where id=".$attack_id;
    $db_theend->query($query);
    $no_queries+=1;
    $query="update mastery set battle=battle+1 where id=".$defense_id;
    $db_theend->query($query);
    $no_queries+=1;

    // armory damage

    $atunits=$attack_units;
    $query2="select user_weapons.procw1, user_weapons.w1, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$attack_id." and user_weapons.w1=weapons.id and weapons.type=1 order by weapons.power desc";
    $db2->query($query2);
    $no_queries+=1;
    while($db2->next_record())
    {
      if($atunits>0)
      {
        if($atunits>=$db2->Record["now1"])
        {
          $proc=$db2->Record["procw1"]-0.1*$db2->Record["now1"]*$attack_turns;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$attack_id;
          $db3->query($query3);
          $no_queries+=1;
        }
        else
        {
          $proc=$db2->Record["procw1"]-0.1*$atunits*$attack_turns;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$attack_id;
          $db3->query($query3);
          $no_queries+=1;
        }
        $atunits=$atunits-$db2->Record["now1"];
      }
    }

    if($yours_attacks<=3)
    {
    
    $dfunits=$defense_units+$defense_untrained_units+$defense_elite_units;
    $query2="select user_weapons.procw1, user_weapons.w1, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$defense_id." and user_weapons.w1=weapons.id and weapons.type=0 order by weapons.power desc";
    $db2->query($query2);
    $no_queries+=1;
    while($db2->next_record())
    {
      if($dfunits>0)
      {
        if($dfunits>=$db2->Record["no"])
        {
          $proc=$db2->Record["procw1"]-0.1*$db2->Record["now1"]*$attack_turns;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$defense_id;
          $db3->query($query3);
          $no_queries+=1;
        }
        else
        {
          $proc=$db2->Record["procw1"]-0.1*$dfunits*$attack_turns;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$defense_id;
          $db3->query($query3);
          $no_queries+=1;
        }
        $dfunits=$dfunits-$db2->Record["now1"];
      }
    }
    
    }

    semafor_off($_COOKIE["uid"]);
    semafor_off($dfid);

    return $attack_log_id;
  }

  if($attack_power<$defense_power)
  {
    $proc_attack_units_killed=(1/50*$dfpp-1)*$attack_turns; // max 10% atunci cand atpp=100% si se ataca cu maximum de 10 turnuri
    $attack_elite_units_killed=floor($proc_attack_units_killed/100*$attack_elite_units);
    $attack_units_killed=floor($proc_attack_units_killed/100*$attack_units_trained);
    $untrained_units_killed=floor($proc_attack_units_killed/100*$attack_untrained_units);

    $units_captured=0;

    //Experienta pierduta de atacator

     if($defense_rank_value>$attack_rank_value)
     {
       $at_exp_lost=10;
     }
     if($defense_rank_value<=$attack_rank_value && $defense_rank_value>$attack_rank_value/4)
     {
       $at_exp_lost=50;
     }
     if($defense_rank_value<=$attack_rank_value/4)
     {
       $at_exp_lost=100;
     }

      $at_exp_lost=round($at_exp_lost/10*$attack_turns);

    //Experienta castigata de cel atacat = $experience_gained/2

    if($attack_rank_value>$defense_rank_value)
    {
      $dfexp_gained=50;
    }
    if($attack_rank_value<=$defense_rank_value && $attack_rank_value>$defense_rank_value/4)
    {
      $dfexp_gained=50;
    }
    if($attack_rank_value<=$defense_rank_value/4)
    {
      $dfexp_gained=0;
    }

      $dfexp_gained=round($dfexp_gained/10*$attack_turns);
      
      $dfexp_gained=floor($dfexp_gained*(100-$yours_attacks*30)/100); // pt. fiecare atac primit de la acelasi jucator in ultimile 24 de ore exp. castigata se diminueaza cu 30%
      
      if($dfexp_gained<0)
        $dfexp_gained=0;

      if($defense_level-1>$attack_level)
        $dfexp_gained=0;
      if($defense_level>$attack_level)
        $dfexp_gained=round($dfexp_gained/2);

    $query="update top_active_users set week1=week1-".$at_exp_lost." where id=".$attack_id;
    $db_theend->query($query);
    $query="update top_active_users set week1=week1+".$dfexp_gained." where id=".$defense_id;
    $db_theend->query($query);
    
    $real_dfexp_gained=$dfexp_gained;
    $real_at_exp_lost=$at_exp_lost;

    if($defense_exp+$dfexp_gained>=pow(2,$defense_level)*1000)
    {
      $defense_exp=$defense_exp+$dfexp_gained-pow(2,$defense_level)*1000;
      $defense_level=$defense_level+1;
    }
    else
    {
      $defense_exp=$defense_exp+$dfexp_gained;
    }

    if($attack_exp-$at_exp_lost<0 && $attack_level>0)
    {
      $attack_level=$attack_level-1;
      $at_exp_lost=$at_exp_lost-$attack_exp;
      $attack_exp=pow(2,$attack_level)*1000;
      $attack_exp=$attack_exp-$at_exp_lost;
    }
    else
    {
      if($attack_exp-$at_exp_lost<0 && $attack_level==0)
      {
        $attack_exp=0;
      }
      else
      {
        if($attack_exp-$at_exp_lost>=0)
        {
          $attack_exp=$attack_exp-$at_exp_lost;
        }
      }
    }


    // echo $attack_turns."!";
    if($superattack)
    {
      $query="update armory set units=".($attack_total_units-$attack_elite_units_killed-$attack_units_killed-$untrained_units_killed-$units_captured).", elite_at=".($attack_elite_units-$attack_elite_units_killed).", attack=".($attack_units_trained-$attack_units_killed-$units_captured).", untrained=".($attack_untrained_units-$untrained_units_killed).", exp=".$attack_exp.", level=".$attack_level.", turn=turn-".$attack_turns.", super_attack='".date("Y-m-d H:i:s")."' where id=".$attack_id;
    }
    else 
    {
      $query="update armory set units=".($attack_total_units-$attack_elite_units_killed-$attack_units_killed-$untrained_units_killed-$units_captured).", elite_at=".($attack_elite_units-$attack_elite_units_killed).", attack=".($attack_units_trained-$attack_units_killed-$units_captured).", untrained=".($attack_untrained_units-$untrained_units_killed).", exp=".$attack_exp.", level=".$attack_level.", turn=turn-".$attack_turns." where id=".$attack_id;
    }    
    $db_theend->query($query);
    $no_queries+=1;
    $query="update armory set units=".($defense_total_units+$units_captured).", untrained=".($defense_untrained_units+$units_captured).", exp=".$defense_exp.", level=".$defense_level." where id=".$defense_id;
    $db_theend->query($query);
    $no_queries+=1;


    $query="insert into attack_log values(DEFAULT,".$attack_id.",".$defense_id.",'".date("Y-m-d H:i:s")."',".$defense_id.",".($untrained_units_killed+$attack_units_killed+$attack_elite_units_killed).",".$units_captured.",".$real_dfexp_gained.",0,".$attack_power.",".$defense_power.",".$attack_units.",".($defense_units+$defense_elite_units+$defense_untrained_units).",".$real_at_exp_lost.",".$attack_turns.",".$attack_total_units.",".$defense_total_units.",".$densitatea.",".$attack_precision.",".$defense_precision.",".$superattack.")";
    $db_theend->query($query);
    $query="select LAST_INSERT_ID() as id from attack_log";
    $db_theend->query($query);
    $db_theend->next_record();
    $attack_log_id=$db_theend->Record["id"];
    $no_queries+=1;

    // mastery

    $query="update mastery set battle=battle+1 where id=".$attack_id;
    $db_theend->query($query);
    $no_queries+=1;
    $query="update mastery set battle=battle+1, battle_win=battle_win+1 where id=".$defense_id;
    $db_theend->query($query);
    $no_queries+=1;

    // armory damage

    $atunits=$attack_units;
    $query2="select user_weapons.procw1, user_weapons.w1, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$attack_id." and user_weapons.w1=weapons.id and weapons.type=1 order by weapons.power desc";
    $db2->query($query2);
    $no_queries+=1;
    while($db2->next_record())
    {
      if($atunits>0)
      {
        if($atunits>=$db2->Record["now1"])
        {
          $proc=$db2->Record["procw1"]-0.1*$db2->Record["now1"]*$attack_turns;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and user_weapons.id=".$attack_id;
          $db3->query($query3);
          $no_queries+=1;
        }
        else
        {
          $proc=$db2->Record["procw1"]-0.1*$atunits*$attack_turns;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$attack_id;
          $db3->query($query3);
          $no_queries+=1;
        }
        $atunits=$atunits-$db2->Record["now1"];
      }
    }
    
    if($yours_attacks<1 && $attack_power>=$defense_power/2)
    {
    
    $dfunits=$defense_units+$defense_untrained_units+$defense_elite_units;
    $query2="select user_weapons.procw1, user_weapons.w1, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$defense_id." and user_weapons.w1=weapons.id and weapons.type=0 order by weapons.power desc";
    $db2->query($query2);
    $no_queries+=1;
    while($db2->next_record())
    {
      if($dfunits>0)
      {
        if($dfunits>=$db2->Record["no"])
        {
          $proc=$db2->Record["procw1"]-0.1*$db2->Record["now1"]*$attack_turns;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$defense_id;
          $db3->query($query3);
          $no_queries+=1;
        }
        else
        {
          $proc=$db2->Record["procw1"]-0.1*$dfunits*$attack_turns;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$defense_id;
          $db3->query($query3);
          $no_queries+=1;
        }
        $dfunits=$dfunits-$db2->Record["now1"];
      }
    }
    
    }    

    semafor_off($_COOKIE["uid"]);
    semafor_off($dfid);

    return $attack_log_id;
  }

  if($attack_power==$defense_power)
  {
    if($superattack)
    {
      $query="update armory set turn=turn-".$attack_turns.", super_attack='".date("Y-m-d H:i:s")."' where id=".$attack_id;
    }
    else 
    {
      $query="update armory set turn=turn-".$attack_turns." where id=".$attack_id;
    }    
  	
    $db_theend->query($query);
    $no_queries+=1;

    $query="insert into attack_log values(DEFAULT,".$attack_id.",".$defense_id.",'".$now["year"]."-".$now["mon"]."-".$now["mday"]." ".$now["hours"].":".$now["minutes"].":".$now["seconds"]."',0,0,0,0,0,".$attack_power.",".$defense_power.",".$attack_power.",".($defense_units+$defense_elite_units+$defense_untrained_units).",0,".$attack_turns.",".$attack_total_units.",".$defense_total_units.",".$densitatea.",".$attack_precision.",".$defense_precision.",".$superattack.")";
    $db_theend->query($query);
    $query="select LAST_INSERT_ID() as id from attack_log";
    $db_theend->query($query);
    $db_theend->next_record();
    $attack_log_id=$db_theend->Record["id"];
    $no_queries+=1;

    //mastery

    $query="update mastery set battle=battle+1 where id=".$attack_id;
    $db_theend->query($query);
    $no_queries+=1;
    $query="update mastery set battle=battle+1 where id=".$defense_id;
    $db_theend->query($query);
    $no_queries+=1;

    // echo "<font color=\"#909090\">Total queries: ".$no_queries."</font><br>";

    semafor_off($_COOKIE["uid"]);
    semafor_off($dfid);

    return $attack_log_id;
  }
}

function attack()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db2 = new DataBase_theend;
  $db2->connect();
  
  $site_language=site_language();

  $today=getdate();
  $myalliance=useralliance2($_COOKIE["uid"]);
  
  echo "<div class=\"titlebar\">";
  if($site_language=="ro")
    echo "ATAC";
  else 
    echo "ATTACK";  
  echo "</div>";
  echo "<br />";

  $nr_inreg_pag=30;
  $query="select armory.id, armory.rank_value, armory.spy, upgrades.spy as spylevel from armory, online, upgrades where armory.id=online.id and armory.id=upgrades.id and online.online>=0 order by armory.rank=0, armory.rank";
  $db_theend->query($query);
  $no_queries+=1;
  $i=0;
  $gasit=0;
  while($db_theend->next_record())
  {
    if($db_theend->Record["id"]==$_COOKIE["uid"])
    {
       $gasit=1;
       $myid=$db_theend->Record["id"];
       $my_rank_value=$db_theend->Record["rank_value"];
       $my_spy_power=power_spy($myid);
    }
    else if(!$gasit) $i++;
  }
  $page=ceil(($i+1)/$nr_inreg_pag);

  $query="select users.id, users.username, users.race, users.warned, armory.units, armory.gold, seif.gold as safe, armory.level, armory.exp, armory.rank, armory.rank_value, armory.antispy, upgrades.antispy as sentrylevel, online.online, mastery.battle, mastery.battle_win from users, armory, upgrades, online, mastery, seif where users.id=armory.id and users.id=upgrades.id and users.id=online.id and users.id=mastery.id and users.id=seif.uid and online.online>=0 order by  armory.rank=0, armory.rank";
  $db_theend->query($query);
  $no_queries+=1;
  $nr_inreg=$db_theend->num_rows();
  if($_POST["page"])
       if($_POST["page"]<0 || $_POST["page"]>ceil($nr_inreg/$nr_inreg_pag)) $page=1;
       else $page=$_POST["page"];

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"play.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo " <input type=\"hidden\" name=\"loc\" value=\"attack\"></input> <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page-1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" < \"></input>";
          echo "</form>";
  }
  if($site_language=="en")
    echo "&nbsp;Page ".$page." from ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  else
    echo "&nbsp;Pagina ".$page." din ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  if ($page<ceil($nr_inreg/$nr_inreg_pag))
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";

  $i=1;
  $nr_inreg_cur=0;

  echo "<div class=\"section\">";

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  
  while($db_theend->next_record())
  {
  $nr_inreg_cur++;

  if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
  {
          $alliance="";
          $idalliance=-1;

          $query2="select alliances.id, alliances.name from alliances, alliance_members where alliance_members.id_member=".$db_theend->Record["id"]." and alliance_members.grade>=0 and alliance_members.id_al=alliances.id";
          $db2->query($query2);
          $no_queries+=1;
          if($db2->num_rows())
          {
             $db2->next_record();
             $alliance=$db2->Record["name"];
             $idalliance=$db2->Record["id"];
          }


      $sentry_power=power_sentry($db_theend->Record["id"]);

      echo "<tr>";
      if($_COOKIE["uid"]==$db_theend->Record["id"])
        echo "<td class=\"atsel1\">";
      else 
        echo "<td class=\"at1\">";  
      if($db_theend->Record["rank"]>0)
      {
        echo $db_theend->Record["rank"];
      }
      else
      {
        echo "-";
      }
      echo "</td>";
      if($_COOKIE["uid"]==$db_theend->Record["id"])
        echo "<td class=\"atsel2\">";
      else 
        echo "<td class=\"at2\">";

      echo "<div style=\"overflow:hidden; width:100%; height: 24px;\">";
      echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a>&nbsp;";

      if($db_theend->Record["warned"])
      {
         echo "<img src=\"pics/warned.gif\"></img>";
      }

      echo "<br><font color=\"#909090\" style=\"font-size: 7pt;\">".$alliance."</font>";
      echo "</div>";

      echo "</td>";

      if($_COOKIE["uid"]==$db_theend->Record["id"])
        echo "<td class=\"atsel3\">";
      else 
        echo "<td class=\"at3\">";
          
       if($db_theend->Record["battle"]<100)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db_theend->Record["battle"]>=100 && ($db_theend->Record["battle_win"]*100)/$db_theend->Record["battle"]<50)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db_theend->Record["battle"]>=100 && ($db_theend->Record["battle_win"]*100)/$db_theend->Record["battle"]>=90)
         echo "<img src=\"pics/5stars.gif\">";
       else
       if($db_theend->Record["battle"]>=100 && ($db_theend->Record["battle_win"]*100)/$db_theend->Record["battle"]>=80)
         echo "<img src=\"pics/4stars.gif\">";
       else
       if($db_theend->Record["battle"]>=100 && ($db_theend->Record["battle_win"]*100)/$db_theend->Record["battle"]>=70)
         echo "<img src=\"pics/3stars.gif\">";
       else
       if($db_theend->Record["battle"]>=100 && ($db_theend->Record["battle_win"]*100)/$db_theend->Record["battle"]>=60)
         echo "<img src=\"pics/2stars.gif\">";
       else
       if($db_theend->Record["battle"]>=100 && ($db_theend->Record["battle_win"]*100)/$db_theend->Record["battle"]>=50)
         echo "<img src=\"pics/1stars.gif\">";
      echo "</td>";

      if($_COOKIE["uid"]==$db_theend->Record["id"])
        echo "<td class=\"atsel4\">";
      else 
        echo "<td class=\"at4\">";
      if($site_language=="en")  
        echo number_format($db_theend->Record["units"])." ".$db_theend->Record["race"]."s";
      else 
      {
       switch($db_theend->Record["race"])
       {
       	case "human":
       		echo number_format($db_theend->Record["units"]). " oameni";
       		break;
       	case "machine":
       		echo number_format($db_theend->Record["units"])." masini";
       		break;       		
       	case "alien":
       		echo number_format($db_theend->Record["units"])." extrat.";
       		break;
       }      	
      }
      echo "<br />";

      if($site_language=="en")
        echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">level ".$db_theend->Record["level"]." (".number_format($db_theend->Record["exp"])." exp.)</font>";
      else 
        echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">nivel ".$db_theend->Record["level"]." (".number_format($db_theend->Record["exp"])." exp.)</font>";  
	  echo "</td>";
      if($_COOKIE["uid"]==$db_theend->Record["id"])
        echo "<td class=\"atsel5\">";
      else 
        echo "<td class=\"at5\">";
        
        if($my_spy_power>$sentry_power*2 || $db_theend->Record["id"]==$myid)
          echo number_format($db_theend->Record["gold"]+$db_theend->Record["safe"]);
        else
          echo "???";
        echo " EKR</td>";


       if($_COOKIE["uid"]==$db_theend->Record["id"])
         echo "<td class=\"atsel6\">";
       else 
         echo "<td class=\"at6\">";
        
       if($db_theend->Record["online"]==1)
       {
         echo "<img src=\"pics/online.gif\"></img>";
       }
       if($db_theend->Record["online"]==0)
       {
         echo "<img src=\"pics/offline.gif\"></img>";
       }
       if($db_theend->Record["online"]==-1)
       {
         echo "<img src=\"pics/inactive.gif\"></img>";
       }
       
       echo "</td>";

    echo "</tr>";

    $i++;

  }

  }

  echo "</table>";
  
  echo "</div>";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"play.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo " <input type=\"hidden\" name=\"loc\" value=\"attack\"></input> <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page-1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" < \"></input>";
          echo "</form>";
  }
  if($site_language=="en")
    echo "&nbsp;Page ".$page." from ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  else
    echo "&nbsp;Pagina ".$page." din ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  if ($page<ceil($nr_inreg/$nr_inreg_pag))
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";

  
  echo "<div class=\"search\">";
  echo "<br />";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<font color=\"#909090\"> ";
  if($site_language=="en")
    echo "Search user: ";
  else
    echo "Cautare jucator: ";
  echo "</font>";
  echo "<input type=\"hidden\" name=\"loc\" value=\"search\"></input>";
  echo "<input class=\"input4\" size=\"10\" type=\"text\" name=\"searchstr\"></input>";
  echo "&nbsp;&nbsp;&nbsp;";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Search\"></input>";
  else
    echo "<input class=\"submit4\" type=\"submit\" value=\"Cauta\"></input>";
  echo "</form>";
  echo "<br/ >";
  $rank_update_min=60-date("i");
  if($rank_update_min>30) $rank_update_min=30-date("i");
  if($site_language=="en")
    echo "<font color=\"#909090\">Ranks will be updated in ".$rank_update_min." minute(s).</font><br>";
  else 
    echo "<font color=\"#909090\">Clasamentul va fi recalculat in ".$rank_update_min." minute.</font><br>";  
  echo "</div>";
}

function attack_user()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db = new DataBase_theend;
  $db->connect();
 
  $site_language=site_language();

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
  echo "<tr><td height=\"1\" bgcolor=\"#404040\"></td></tr>";
  echo "<tr><td height=\"18\" bgcolor=\"#101520\">&nbsp;&nbsp;&nbsp;&nbsp;<font color=\"#C0D0E0\" style=\"font-size: 7pt;\"><b>LAUNCH ATTACK</b></font></td></tr>";
  echo "<tr><td height=\"1\" bgcolor=\"#404040\"></td></tr>";
  echo "</table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" height=\"4\" width=\"470\"><tr><td></td></tr></table>";

  $no_attacks=0;


  $query="select count(at_id) as attacks from attack_log where at_id=".$_COOKIE["uid"]." and date>'".date("Y-m-d H:i:s", mktime(date(H)-1,date(i),date(s), date(m), date(d), date(Y)))."'";
  $db_theend->query($query);
  if($db_theend->num_rows())
  {
    $db_theend->next_record();
    $no_attacks=$db_theend->Record["attacks"];
  }

  $query="select armory.rank_value, armory.gold, armory.attack, armory.level, users.race from armory, users where users.id=".$_COOKIE["uid"]." and users.id=armory.id";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();

  if($db_theend->Record["race"]=="human") $attack_value_per_unit=60;
  if($db_theend->Record["race"]=="alien") $attack_value_per_unit=50;
  if($db_theend->Record["race"]=="machine") $attack_value_per_unit=75;

  $attack_value_per_unit=round($attack_value_per_unit+$no_attacks*0.1*$attack_value_per_unit);

  $attack_units=$db_theend->Record["attack"];
  $attack_rank_value=$db_theend->Record["rank_value"];
  $gold=$db_theend->Record["gold"];

  echo "<table class=\"dotted\" cellspacing=\"0\" cellpadding=\"0\" width=\"470\">";
  echo "<tr><td valign=\"center\" align=\"center\" width=\"270\">";

  $query="select users.id, users.username, users.race, armory.level, armory.exp, armory.units from users, armory where users.id=".$_POST["user"]." and users.id=armory.id";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();

  $opname=$db_theend->Record["username"];
  $oprace=$db_theend->Record["race"];
  $iduser=$db_theend->Record["id"];
  $opunits=$db_theend->Record["units"];
  $oplevel=$db_theend->Record["level"];
  $opexp=$db_theend->Record["exp"];

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"270\">";
  echo "<tr><td width=\"120\" align=\"center\">";

       echo "<table cellspacing=\"1\" cellpadding=\"1\" bgcolor=\"#909090\"><tr><td bgcolor=\"#000000\"><img width=\"100\" src=\"".useravatar2($iduser,$oprace)."\"></img></td></tr></table>";

  echo "</td><td>";

       echo "<a class=\"".$oprace."\" href=\"#\">".$opname."</a><br>";

    $query="select alliances.name, alliance_members.grade from alliance_members, alliances where alliance_members.id_member=".$iduser." and alliance_members.id_al=alliances.id";
    $db->query($query);
    if($db->num_rows())
    {
      $db->next_record();
      if($db->Record["grade"]>=0)
      {
        echo "<font color=\"#909090\"style=\"font-size: 7pt;\">";
        if($db->Record["grade"]==0)
        {
          echo "Member ";
        }
        if($db->Record["grade"]==1)
        {
          echo "Commander ";
        }
        if($db->Record["grade"]==2)
        {
          echo "Officer ";
        }
        echo "of alliance</font> <font color=\"#00F000\"style=\"font-size: 7pt;\">".$db->Record["name"];
        echo "</font>";
      }
    }

       echo "<br>";
       echo number_format($opunits)." units<br>";
       echo "level ".number_format($oplevel)."<br>";
       echo number_format($opexp)." exp.<br>";

  echo "</td></tr>";
  echo "</table>";

  echo "</td></tr></table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" height=\"4\" width=\"470\"><tr><td></td></tr></table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\" height=\"25\" bgcolor=\"#400000\">";
  echo "<form action=\"play.php\" method=\"POST\" id=\"attack_form\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"attack\"></input>";
  echo "<input type=\"hidden\" name=\"user\" value=\"".$_POST["user"]."\"></input>";
  echo "<tr><td align=\"center\">Attack turns: <input class=\"input1\" type=\"text\" name=\"turns\"></input> / 10 <input id=\"attack_button\" class=\"submit1\" type=\"submit\" value=\"Attack!\" onClick=\"document.getElementById('attack_button').disabled = true; document.getElementById('attack_form').submit();\"></input></td></tr>";
  echo "</form>";
  echo "</table>";

  echo "<br>";
}

function attack_user_now($attack_data)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "ATTACK RESULTS";
  else 
    echo "REZULTATE ATAC";  
  echo "</div>";
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\" style=\"text-align: center;\">";

  switch($attack_data)
  {
  case -1:
    echo "<font color=\"#909090\">";
    if($site_language=="en")
      echo "You can use maximum 10 APs in an attack!";
    else
      echo "Poti folosi cel mult 10 AP-uri pentru un atac!";
    echo "</font><br><br>";
    break;
  case -2:
    echo "<font color=\"#909090\">";
    if($site_language=="en")
      echo "You must use at least 1 AP in an attack!";
    else
      echo "Trebuie sa folosesti cel putin 1 AP pentru a ataca!";
    echo "</font><br><br>";
    break;
  case -3:
    echo "<font color=\"#909090\">";
    if($site_language=="en")
      echo "You don't have so much APs to use!";
    else
      echo "Nu ai atat de multe AP-uri!";
    echo "</font><br><br>";
    break;
  case -4:
    echo "<font color=\"#909090\">";
    if($site_language=="en")
      echo "You don't have any APs to use!";
    else
      echo "Nu ai AP-uri!";
    echo "</font><br><br>";
    break;
  case -5:
    echo "<font color=\"#909090\">";
    if($site_language=="en")
      echo "You don't have any attack power!";
    else
      echo "Nu ai putere de atac!";
    echo "</font><br><br>";
    break;
  case -6:
    echo "<font color=\"#909090\">";
    if($site_language=="en")
      echo "The army is not ready to fight against such a powerful defense. We should wait...";
    else
      echo "Armata nu este pregatita pentru a lupta impotriva unei aparari atat de mari. Ar trebui sa asteptam...";
    echo "</font><br><br>";
    break;
  default:
    $atid=$_COOKIE["uid"];
    $dfid=$_POST["user"];
    $query="select at_id, a.username as at_name, a.race as at_race, attack_log.df_id, b.username as df_name, b.race as df_race, attack_log.date, attack_log.win_id, attack_log.turns, attack_log.units_killed, attack_log.units_captured, attack_log.exp, attack_log.gold, attack_log.atp, attack_log.dfp, attack_log.at_units, attack_log.df_units, attack_log.exp_lost, attack_log.at_prec, attack_log.df_prec, armory.level, armory.exp as experience from attack_log, users a, users b, armory where attack_log.id=$attack_data and attack_log.at_id=armory.id and a.id=at_id and b.id=df_id";
    $db_theend->query($query);
    if($db_theend->num_rows())
    {
      $db_theend->next_record();

      if($site_language=="en")
        echo "<font style=\"font-size: 12px; font-weight: bold; color: #C0C0C0;\"><a style=\"font-size: 12px;\" class=\"".$db_theend->Record["at_race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["at_id"]."\">".$db_theend->Record["at_name"]."</a>, your army formed by ".number_format($db_theend->Record["at_units"])." units attacked <a style=\"font-size: 12px;\" class=\"".$db_theend->Record["df_race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["df_id"]."\">".$db_theend->Record["df_name"]."</a> with ".number_format($db_theend->Record["atp"])." power using ".$db_theend->Record["turns"]." AP.</font>";
      else 
        echo "<font style=\"font-size: 12px; font-weight: bold; color: #C0C0C0;\"><a style=\"font-size: 12px;\" class=\"".$db_theend->Record["at_race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["at_id"]."\">".$db_theend->Record["at_name"]."</a>, armata ta formata din ".number_format($db_theend->Record["at_units"])." unitati a atacat pe <a style=\"font-size: 12px;\" class=\"".$db_theend->Record["df_race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["df_id"]."\">".$db_theend->Record["df_name"]."</a> cu o putere de ".number_format($db_theend->Record["atp"])." folosind ".$db_theend->Record["turns"]." AP.</font>";
      echo "<br /><br />";
      echo "<font color=\"#A0A0A0\">";
      if($db_theend->Record["at_prec"]>0)
      {
        if($site_language=="en")
      	  echo "Yours weapons precision was: ".$db_theend->Record["at_prec"]."%.";
      	else 
      	  echo "Precizia armelor tale a fost de ".$db_theend->Record["at_prec"]."%.";  
      }
      echo "<br>";
      echo "<a class=\"".$db_theend->Record["df_race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["df_id"]."\">".$db_theend->Record["df_name"]."</a>";
      if($site_language=="en")
        echo " was defended by ";
      else 
        echo " a fost aparat de ";  
      if($db_theend->Record["df_units"]>=0)
        echo number_format($db_theend->Record["df_units"]);
      else
        echo "<font color=\"#909090\">???</font>";
      if($site_language=="en")  
        echo " units with ";
      else 
        echo " unitati cu o putere de ";  
      if($db_theend->Record["dfp"]>=0)
        echo number_format($db_theend->Record["dfp"]);
      else
        echo "<font color=\"#909090\">???</font>";
      if($site_language=="en")  
        echo " power.";
      else 
        echo ".";  
      echo "</font>";
      echo "<br>";
      echo "<br>";
      if($db_theend->Record["win_id"]==$atid)
      {
        if($site_language=="en")
      	  echo "<font color=\"#00FF00\" style=\"font-size: 14px; font-weight: bold;\"><b>You won!</b></font>";
      	else 
      	  echo "<font color=\"#00FF00\" style=\"font-size: 14px; font-weight: bold;\"><b>Ai castigat!</b></font>";  
        echo "<br /><br />";
        if($site_language=="en")
          echo "In the fight your army killed ".$db_theend->Record["units_killed"]." enemy units and capured ".$db_theend->Record["units_captured"].".";
        else 
          echo "In timpul luptei armata ta a ucis ".$db_theend->Record["units_killed"]." unitati inamice si a capturat ".$db_theend->Record["units_captured"].".";  
        echo "<br>";
        if($site_language=="en")
          echo "You have stolen ".number_format($db_theend->Record["gold"])." EKR from enemy's vistery.";
        else 
          echo "Ai luat ".number_format($db_theend->Record["gold"])." EKR de la inamic.";  
        echo "<br>";
        if($db_theend->Record["exp"]<0)
        {
          if($site_language=="en")
        	echo "You have lost ".abs($db_theend->Record["exp"])." experience.";
          else 
          	echo "Ai pierdut ".abs($db_theend->Record["exp"])." experienta.";
        }
        if($db_theend->Record["exp"]>0)
        {
          if($site_language=="en")
        	echo "You have won ".abs($db_theend->Record["exp"])." experience.";
          else 
            echo "Ai castigat ".abs($db_theend->Record["exp"])." experienta.";
        }
        if($site_language=="en")
          echo " Now you have level ".$db_theend->Record["level"]." with ".$db_theend->Record["experience"]." experience.";
        else 
          echo " Acum ai nivelul ".$db_theend->Record["level"]." si ".$db_theend->Record["experience"]." experienta.";  
        echo "<br>";
        if($site_language=="en")
          echo "Your enemy lost ".$db_theend->Record["exp_lost"]." experience.";
        else 
        {
          echo "Inamicul tau a pierdut ".$db_theend->Record["exp_lost"]." experienta.";	
        }
      }
      if($db_theend->Record["win_id"]==$dfid)
      {
        if($site_language=="en")
      	  echo "<font color=\"#FF0000\" style=\"font-size: 14px; font-weight: bold;\"><b>You lost!</b></font>";
      	else 
      	  echo "<font color=\"#FF0000\" style=\"font-size: 14px; font-weight: bold;\"><b>Ai pierdut!</b></font>";
        echo "<br /><br />";
        if($site_language=="en")
          echo "In the fight you lost ".($db_theend->Record["units_killed"]+$db_theend->Record["units_captured"])." units, ".$db_theend->Record["units_killed"]." were killed and ".$db_theend->Record["units_captured"]." were captured by enemy.";
        else 
          echo "In timpul luptei ai pierdut ".($db_theend->Record["units_killed"]+$db_theend->Record["units_captured"])." unitati, ".$db_theend->Record["units_killed"]." au fost omorate si ".$db_theend->Record["units_captured"]." capturate de inamic.";  
        echo "<br>";
        if($site_language=="en")
          echo "Your experience was decreased by ".$db_theend->Record["exp_lost"]." and now you have level ".$db_theend->Record["level"]." with ".$db_theend->Record["experience"]." experience. Your enemy gained ".$db_theend->Record["exp"]." experience.";
        else 
          echo "Experienta ta a scazut cu ".$db_theend->Record["exp_lost"]." puncte si acum ai nivelul ".$db_theend->Record["level"]." si ".$db_theend->Record["experience"]." experienta.<br />Inamicul tau a castigat ".$db_theend->Record["exp"]." experienta.";  
      }
      if($db_theend->Record["win_id"]==0)
      {
        if($site_language=="en")
      	  echo "The two armes were equal in force so nobody won.";
      	else 
      	  echo "Cele doua armate au fost egale ca fosrta. Nimeni nu a castigat.";  
        echo "<br>";
      }
    }
  }
  echo "<br><br>";
  if($site_language=="en")
    echo "<a href=\"user_profile.php?uid=".$_POST["user"]."\">[attack again]</a>";
  else 
    echo "<a href=\"user_profile.php?uid=".$_POST["user"]."\">[ataca din nou]</a>";  
  echo "<br>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

function attack_log()
{
  $site_language=site_language();

  $db_theend = new DataBase_theend;
  $db2 = new DataBase_theend;
  $db_theend->connect();
  $db2->connect();

  $my_id=$_COOKIE["uid"];
  
  if($_POST["who"]=="you" || (!$_POST["who"] && !$_GET["who"]))
  {
    echo "<div class=\"titlebar\">";
    if($site_language=="en")
      echo "YOURS ATTACKS ON OTHERS";
    else 
      echo "ATACURILE TALE";  
    echo "</div>";
    echo "<br />";
    

  $query="select id, at_id, df_id, date, win_id from attack_log where at_id=".$my_id." order by date";
  $db_theend->query($query);
  $nr_inreg=$db_theend->num_rows();
  $nr_inreg_pag=30;
  if(!$_POST["page"] || $_POST["page"]<0 || $_POST["page"]>ceil($nr_inreg/$nr_inreg_pag)) $page=ceil($nr_inreg/$nr_inreg_pag);
  else $page=$_POST["page"];    
    
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"play.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
  echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page-1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" < \"></input>";
          echo "</form>";
  }
  if($site_language=="en")
    echo "&nbsp;Page ".$page." from ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  else
    echo "&nbsp;Pagina ".$page." din ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  if ($page<ceil($nr_inreg/$nr_inreg_pag))
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";    

    echo "<div class=\"section\">";

  $nr_inreg_cur=0;
  $i=0;
  
  while($db_theend->next_record())
  {
	$nr_inreg_cur++;
    $query="select username, race from users where id=".$db_theend->Record["df_id"];
    $db2->query($query);
    $db2->next_record();
    if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
    {
	echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
    echo "<tr>";
    echo "<td class=\"atl1\"><font color=\"#A0A0A0\">&nbsp;".$nr_inreg_cur."&nbsp;</font></td>";
    echo "<td class=\"atl2\"><a class=\"".$db2->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["df_id"]."\">".$db2->Record["username"]."</a></td>";
    echo "<td class=\"atl3\">";
    if ($db_theend->Record["win_id"]==$my_id)
    {
      if($site_language=="en")
        echo "<font color=\"#F0F0F0\">you won</font>";
      else
        echo "<font color=\"#F0F0F0\">ai castigat</font>";
    }
    if ($db_theend->Record["win_id"]==$db_theend->Record["df_id"])
    {
      if($site_language=="en")
        echo "<font color=\"#A0A0A0\">you lost</font>";
      else
        echo "<font color=\"#A0A0A0\">ai pierdut</font>";
    }
    if ($db_theend->Record["win_id"]==0)
    {
      if($site_language=="en")
        echo "draw";
      else
        echo "egalitate";
    }
    echo "</td>";
    echo "<td class=\"atl4\">".$db_theend->Record["date"]."</td>";    
    echo "<td class=\"atl5\">";
    echo "<span id=\"attack_details_button_span_".$db_theend->Record["id"]."\"><input class=\"submit4\" type=\"button\" value=\"details\" onClick=\"attackDetails(".$db_theend->Record["id"]."); showhide('attack_details_".$db_theend->Record["id"]."');\"></input></span>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<div style=\"margin: 10px; display:none;\" id=\"attack_details_".$db_theend->Record["id"]."\">";
    
    echo "<div class=\"attack_details\">";
    echo "<span id=\"attack_details_span_".$db_theend->Record["id"]."\"></span>";
    echo "</div>";
    
    echo "</div>";    
    }
  }

  echo "</div>";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"play.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
  echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page-1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" < \"></input>";
          echo "</form>";
  }
  if($site_language=="en")
    echo "&nbsp;Page ".$page." from ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  else
    echo "&nbsp;Pagina ".$page." din ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  if ($page<ceil($nr_inreg/$nr_inreg_pag))
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";  

    echo "<br />";
  }



  if($_POST["who"]=="others" || $_GET["who"]=="others")
  {
    echo "<div class=\"titlebar\">";
    if($site_language=="en")
      echo "OTHERS ATTACKS ON YOU";
    else 
      echo "ATACURI ASUPRA TA";
    echo "</div>";
    echo "<br />";
    
  $query="select id, at_id, df_id, date, win_id from attack_log where df_id=".$my_id." order by date";
  $db_theend->query($query);
  $nr_inreg=$db_theend->num_rows();
  $nr_inreg_pag=30;
  if(!$_POST["page"] || $_POST["page"]<0 || $_POST["page"]>ceil($nr_inreg/$nr_inreg_pag)) $page=ceil($nr_inreg/$nr_inreg_pag);
  else $page=$_POST["page"];    
    
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"play.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
  echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page-1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" < \"></input>";
          echo "</form>";
  }
  if($site_language=="en")
    echo "&nbsp;Page ".$page." from ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  else
    echo "&nbsp;Pagina ".$page." din ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  if ($page<ceil($nr_inreg/$nr_inreg_pag))
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";       

    echo "<div class=\"section\">";

  $nr_inreg_cur=0;
  $i=0;

  while($db_theend->next_record())
  {
    $nr_inreg_cur++;
    $query="select username, race from users where id=".$db_theend->Record["at_id"];
    $db2->query($query);
    $db2->next_record();
    if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
    {
    echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";	
    echo "<tr>";
    echo "<td class=\"atl1\"><font color=\"#A0A0A0\">&nbsp;".$nr_inreg_cur."&nbsp;</font></td>";
    echo "<td class=\"atl2\"><a class=\"".$db2->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["at_id"]."\">".$db2->Record["username"]."</a></td>";
    echo "<td class=\"atl3\">";
    if ($db_theend->Record["win_id"]==$my_id)
    {
      if($site_language=="en")
        echo "<font color=\"#F0F0F0\">you won</font>";
      else
        echo "<font color=\"#F0F0F0\">ai castigat</font>";
    }
    if ($db_theend->Record["win_id"]==$db_theend->Record["at_id"])
    {
      if($site_language=="en")
        echo "<font color=\"#A0A0A0\">you lost</font>";
      else
        echo "<font color=\"#A0A0A0\">ai pierdut</font>";
    }
    if ($db_theend->Record["win_id"]==0)
    {
      if($site_language=="en")
        echo "draw";
      else
        echo "egalitate";
    }
    echo "</td>";
    echo "<td class=\"atl4\">".$db_theend->Record["date"]."</td>";
    echo "<td class=\"atl5\">";
    echo "<span id=\"attack_details_button_span_".$db_theend->Record["id"]."\"><input class=\"submit4\" type=\"button\" value=\"details\" onClick=\"attackDetails(".$db_theend->Record["id"]."); showhide('attack_details_".$db_theend->Record["id"]."');\"></input></span>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<div style=\"margin: 10px; display:none;\" id=\"attack_details_".$db_theend->Record["id"]."\">";
    
    echo "<div class=\"attack_details\">";
    echo "<span id=\"attack_details_span_".$db_theend->Record["id"]."\"></span>";
    echo "</div>";
    
    echo "</div>";
    }
  }
  
  echo "</div>";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"play.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
  echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page-1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" < \"></input>";
          echo "</form>";
  }
  if($site_language=="en")
    echo "&nbsp;Page ".$page." from ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  else
    echo "&nbsp;Pagina ".$page." din ".ceil($nr_inreg/$nr_inreg_pag)."&nbsp;";
  if ($page<ceil($nr_inreg/$nr_inreg_pag))
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"win\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";    

  echo "<br>";
  }
}


function attack_details($date,$at_id,$df_id)
{
  global $login_expires;
  
  $site_language=site_language();

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
  echo "<tr><td height=\"1\" bgcolor=\"#404040\"></td></tr>";
  echo "<tr><td height=\"18\" bgcolor=\"#101520\">&nbsp;&nbsp;&nbsp;&nbsp;<font color=\"#C0D0E0\" style=\"font-size: 7pt;\"><b>ATTACK DETAILS</b></font></td></tr>";
  echo "<tr><td height=\"1\" bgcolor=\"#404040\"></td></tr>";
  echo "</table>";

  echo "<br>";

  echo "<table class=\"dotted\" bgcolor=\"#000000\" width=\"90%\"><tr><td align=\"center\">";

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select at_id, df_id, date, win_id, units_killed, units_captured, exp, gold, atp, dfp, at_units, df_units, exp_lost, turns, at_prec, df_prec from attack_log where date='".$date."' and at_id=".$at_id." and df_id=".$df_id;
  $db_theend->query($query);
  $db_theend->next_record();

  $attacker_name=username($db_theend->Record["at_id"]);
  $defender_name=username($db_theend->Record["df_id"]);
  $winner_name=username($db_theend->Record["win_id"]);

  echo "<br>";

  echo "<font color=\"#FFD700\">";
  if($site_language=="en")
    echo "[battle report - ".$db_theend->Record["date"]."]";
  else
    echo "[raport lupta - ".$db_theend->Record["date"]."]";
  echo "</font>";

  echo "<br>";

  echo "<b>".$attacker_name."</b> attacked <b>".$defender_name."</b> at ".$db_theend->Record["date"]." using ".$db_theend->Record["turns"]." AP.";

  if($db_theend->Record["win_id"])
  {
    if($site_language=="en")
      echo "<br><b>".$winner_name."</b> won the battle.";
    else
      echo "<br><b>".$winner_name."</b> a castigat lupta.";
  }
  else
  {
    if($site_language=="en")
      echo "<br>The two armies were equal in force and have resolved the conflict in diplomatic ways. Nobody won, nobody lost.";
    else
      echo "<br>Cele doua armate au fost egale in putere si conflictul s-a rezolvat pe cai diplomatice. Nimeni nu a pierdut.";
  }

  echo "<br><br>";

  echo "<table width=\"100%\" bgcolor=\"#202020\">";
  echo "<tr>";
  echo "<td colspan=\"2\" width=\"50%\" height=\"1\" bgcolor=\"#909090\"></td>";
  echo "<td colspan=\"2\" width=\"50%\" height=\"1\" bgcolor=\"#909090\"></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td colspan=\"2\" width=\"50%\" bgcolor=\"#102030\">&nbsp;&nbsp;ATTACKER</td>";
  echo "<td colspan=\"2\" width=\"50%\" bgcolor=\"#102030\">&nbsp;&nbsp;DEFENDER</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td colspan=\"2\" width=\"50%\" height=\"1\" bgcolor=\"#909090\"></td>";
  echo "<td colspan=\"2\" width=\"50%\" height=\"1\" bgcolor=\"#909090\"></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td rowspan=\"9\" align=\"center\" bgcolor=\"#000000\"><table cellspacing=\"1\" cellpadding=\"1\" bgcolor=\"#606060\"><tr><td bgcolor=\"#000000\"><img border=\"0\" src=\"".useravatar2($db_theend->Record["at_id"],userrace($db_theend->Record["at_id"]))."\" width=\"50\" height=\"60\"></img></td></tr></table></td>";
  echo "<td bgcolor=\"#000000\"><a class=\"\" href=\"user_profile.php?uid=".$db_theend->Record["at_id"]."\"><b>".$attacker_name."</b></a></td>";
  echo "<td rowspan=\"9\" align=\"center\" bgcolor=\"#000000\"><table cellspacing=\"1\" cellpadding=\"1\" bgcolor=\"#606060\"><tr><td bgcolor=\"#000000\"><img border=\"0\" src=\"".useravatar2($db_theend->Record["df_id"],userrace($db_theend->Record["df_id"]))."\" width=\"50\" height=\"60\"></img></td></tr></table></td>";
  echo "<td bgcolor=\"#000000\"><a class=\"\" href=\"user_profile.php?uid=".$db_theend->Record["df_id"]."\"><b>".$defender_name."</b></a></td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td bgcolor=\"#000000\">Units: ".number_format($db_theend->Record["at_units"])."</td>";
  echo "<td bgcolor=\"#000000\">Units: ".number_format($db_theend->Record["df_units"])."</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td bgcolor=\"#000000\">Power: ".number_format($db_theend->Record["atp"])."</td>";
  echo "<td bgcolor=\"#000000\">Power: ".number_format($db_theend->Record["dfp"])."</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td bgcolor=\"#000000\">Weapons' Precision: ";
  if($_COOKIE["uid"]==$db_theend->Record["at_id"] && $db_theend->Record["at_prec"])
    echo $db_theend->Record["at_prec"]."%";
  else
    echo "unknown";
  echo "</td>";
  echo "<td bgcolor=\"#000000\">Weapons' Precision: ";
  if($_COOKIE["uid"]==$db_theend->Record["df_id"] && $db_theend->Record["df_prec"])
    echo $db_theend->Record["df_prec"]."%";
  else
    echo "unknown";
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td bgcolor=\"#000000\">Experience gained: ";
  if($db_theend->Record["win_id"]==$db_theend->Record["at_id"])
  {
    echo number_format($db_theend->Record["exp"]);
  }
  else
  {
    echo " - ";
  }
  echo "</td>";
  echo "<td bgcolor=\"#000000\">Experience gained: ";
  if($db_theend->Record["win_id"]==$db_theend->Record["df_id"])
  {
    echo number_format($db_theend->Record["exp"]);
  }
  else
  {
    echo " - ";
  }
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td bgcolor=\"#000000\">Experience lost: ";
  if($db_theend->Record["win_id"]==$db_theend->Record["df_id"])
  {
    echo number_format($db_theend->Record["exp_lost"]);
  }
  else
  {
    echo " - ";
  }
  echo "</td>";
  echo "<td bgcolor=\"#000000\">Experience lost: ";
  if($db_theend->Record["win_id"]==$db_theend->Record["at_id"])
  {
    echo number_format($db_theend->Record["exp_lost"]);
  }
  else
  {
    echo " - ";
  }
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td bgcolor=\"#000000\">Gold: ".number_format($db_theend->Record["gold"])."</td>";
  echo "<td bgcolor=\"#000000\">Gold:  - </td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td bgcolor=\"#000000\">Units lost: ";
  if($db_theend->Record["win_id"]==$db_theend->Record["df_id"])
  {
    echo number_format($db_theend->Record["units_killed"]);
  }
  else
  {
    echo " - ";
  }
  echo "</td>";
  echo "<td bgcolor=\"#000000\">Units lost: ";
  if($db_theend->Record["win_id"]==$db_theend->Record["at_id"])
  {
    echo number_format($db_theend->Record["units_killed"]);
  }
  else
  {
    echo " - ";
  }
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td bgcolor=\"#000000\">Units captured: ";
  if($db_theend->Record["win_id"]==$db_theend->Record["at_id"])
  {
    echo number_format($db_theend->Record["units_captured"]);
  }
  else
  {
    echo " - ";
  }
  echo "</td>";
  echo "<td bgcolor=\"#000000\">Units captured: ";
  if($db_theend->Record["win_id"]==$db_theend->Record["df_id"])
  {
    echo number_format($db_theend->Record["units_captured"]);
  }
  else
  {
    echo " - ";
  }
  echo "</td>";
  echo "</tr>";
  echo "</table>";

  echo "<br>";

  echo "</td></tr></table>";

  echo "<br>";
}


function superattack()
{
/*
  $db_theend = new DataBase_theend;
  $db2 = new DataBase_theend;
  $db3 = new DataBase_theend;
  $db_theend->connect();
  $db2->connect();
  $db3->connect();
  
  $site_language=site_language();

  $myrace=userrace($_COOKIE["uid"]);

  global $login_expires;

  if($site_language=="en") $ppath="pics/en/";
  else $ppath="pics/";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" height=\"2\" width=\"470\"><tr><td></td></tr></table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\">";
  echo "<tr><td background=\"pics/redbigbar.gif\" align=\"center\" height=\"22\">";
  if($site_language=="en")
    echo "<b>ALLIANCE ATTACK</b>";
  else
    echo "<b>ATAC ALIANTA</b>";
  echo "</td></tr>";
  echo "</table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\">";
  echo "<tr><td align=\"center\">";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" height=\"4\" width=\"470\"><tr><td></td></tr></table>";

  $query="select alliances.id, alliances.name from alliances, users where alliances.commander=users.username and users.id=".$_COOKIE["uid"];
  $db_theend->query($query);
  $db_theend->next_record();
  $alliance=$db_theend->Record["name"];
  $idal=$db_theend->Record["id"];

  $power=0;
  $i=0;

  $query="select id_member from alliance_members where id_al=".$idal." and grade>=0";
  $db_theend->query($query);
  while($db_theend->next_record())
  {
          $power=$power+power_attack($db_theend->Record["id_member"]);
          $i++;
  }

  $query="select users.id from alliances, users where alliances.id=".$idal." and users.username=alliances.commander";
  $db_theend->query($query);
  $db_theend->next_record();
  $idcom=$db_theend->Record["id"];
  // $power=$power+power_attack($idcom);

  $power_attack=round($power);

  $query="select data from superattack_log where at_id=".$idal." and data>'".date("Y-m-d", mktime(0,0,0, date(m), date(d)-6, date(Y)))."'";
  $db_theend->query($query);
  if($db_theend->num_rows())
  {
      $db_theend->next_record();
      if($site_language=="en")
        echo "<font color=\"#909090\">You cannot launch a super-attack now. Your last super-attack was on ".$db_theend->Record["data"].".<br>You can launch it only once per 7 days.</font>";
      else
        echo "<font color=\"#909090\">Nu poti lansa un super-atac acum. Ultimul super-atac lansat a fost in data de ".$db_theend->Record["data"].".<br>Poti lansa numai un super-atac odata la 7 zile.</font>";
      $a=explode("-",$db_theend->Record["data"]);
      if($site_language=="en")
        echo "<br><br><font color=\"#F0F0F0\"><b>You can launch a super-attack on ";
      else
        echo "<br><br><font color=\"#F0F0F0\"><b>Poti lansa un super-atac in data de ";
      echo date("M-d-Y", mktime(0, 0, 0,$a[1],$a[2]+7,$a[0])).".</b></font>";
      echo "<br><br>";
  }
  else
  {
  $query="select id from users where username='".$_POST["user"]."'";
  $db_theend->query($query);
  if(!$db_theend->num_rows())
  {
      echo "User ".$_POST["user"]." does not exists! Plese <a href=\"play.php?loc=alliance&what=manage&alname=".$alliance."\">go back</a> and try again.<br>";
  }
  else
  {
      $db_theend->next_record();
      $defense_id=$db_theend->Record["id"];

  $query2="select alliance_members.id_al, alliance_members.grade from alliance_members where id_member=".$defense_id." and alliance_members.grade>=0";
  $db2->query($query2);
  $no_queries+=1;
  if($db2->num_rows())
  {
       $db2->next_record();
       $al_grade=$db2->Record["grade"];
       $alliance_power=power_defense_alliance($db2->Record["id_al"]);
  }
  else
  {
       $al_grade=-1;
       $alliance_power=0;
  }

    $self_defense_power=power_defense($defense_id);
    $power_defense=$self_defense_power;

  if($al_grade==0) // membru
  {
    $power_defense=min(round($self_defense_power+0.006*$alliance_power),1.5*$self_defense_power);
  }
  if($al_grade==1) // comandant
  {
    $power_defense=min(round($self_defense_power+0.01*$alliance_power),1.5*$self_defense_power);
  }
  if($al_grade==2) // ofiter
  {
    $power_defense=min(round($self_defense_power+0.008*$alliance_power),1.5*$self_defense_power);
  }

      if($power_attack>$power_defense)
      {
          $atpp=round($power_attack*100/($power_attack+$power_defense));
          $dfpp=round($power_defense*100/($power_attack+$power_defense));

          if($site_language=="en")
          {
            echo "<font color=\"#F0F0F0\">Your alliance attack power: ".$power_attack." (".$atpp."%)";
            echo "<br>".$_POST["user"]." has ".$power_defense." defense power. (".$dfpp."%)";
          }
          else
          {
            echo "<font color=\"#F0F0F0\">Puterea de atac a aliantei: ".$power_attack." (".$atpp."%)";
            echo "<br>".$_POST["user"]." are ".$power_defense." putere de aparare. (".$dfpp."%)";
          }

          $query2="select * from armory where id=".$defense_id;
          $db2->query($query2);
          $db2->next_record();
          $defense_units=$db2->Record["defense"];
          $defense_untrained=$db2->Record["untrained"];
          $defense_workers=$db2->Record["workers"];
          $defense_total_units=$db2->Record["units"];
          $defense_gold=$db2->Record["gold"];

          $gold_stolen=floor(($atpp-50)/100*$defense_gold);
          $units_killed=floor((((($atpp-50)/5)*2)/100*$defense_units)*(3/4));
          $units_captured=floor((((($atpp-50)/5)*2)/100*$defense_units)*(1/4));
          $untrained_killed=floor((($atpp-50)/5)/100*$defense_untrained);
          $workers_killed=floor((($atpp-50)/10)/100*$defense_workers);

          echo "<br>";
          if($site_language=="en")
            echo "Gold stolen: ";
          else
            echo "Aur capturat: ";
          echo $gold_stolen;
          echo "<br>";
          if($site_language=="en")
            echo "Units killed: ";
          else
            echo "Unitati omorate: ";
          echo ($units_killed+$untrained_killed+$workers_killed);
          echo "<br>";
          if($site_language=="en")
            echo "Units captured: ";
          else
            echo "Unitati capturate: ";
          echo $units_captured;

          $query2="update armory set gold=gold-".$gold_stolen.", defense=defense-".($units_killed+$units_captured).", untrained=untrained-".$untrained_killed.", workers=workers-".$workers_killed.", units=units-".($units_killed+$units_captured+$untrained_killed+$workers_killed)." where id=".$defense_id;
          $db2->query($query2);

          // armory damage

          $dfunits=$defense_units;
          $query2="select user_weapons.procw1, user_weapons.w1, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$defense_id." and user_weapons.w1=weapons.id and weapons.type=0 order by weapons.power desc";
          $db2->query($query2);
          while($db2->next_record())
          {
            if($dfunits>0)
            {
              if($dfunits>=$db2->Record["no"])
              {
                $proc=$db2->Record["procw1"]-5*$db2->Record["now1"];
                if($proc<0) $proc=0;
                $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$defense_id;
                $db3->query($query3);
              }
              else
              {
                $proc=$db2->Record["procw1"]-5*$dfunits;;
                if($proc<0) $proc=0;
                $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$defense_id;
                $db3->query($query3);
              }
              $dfunits=$dfunits-$db2->Record["now1"];
            }
          }

          $query2="select count(armory.id) as nr, sum(armory.attack) as attack from armory, alliance_members where armory.id=alliance_members.id_member and alliance_members.id_al=".$idal." and alliance_members.grade>=0";
          $db2->query($query2);
          $db2->next_record();
          $attack_units=$db2->Record["attack"];
          $nr_members=$db2->Record["nr"];

          $query="select users.username, armory.id, armory.attack from armory, alliance_members, users where armory.id=alliance_members.id_member and alliance_members.id_al=".$idal." and alliance_members.grade>=0 and armory.id=users.id";
          $db_theend->query($query);
          while($db_theend->next_record())
          {
               $gold_win=floor($gold_stolen*($db_theend->Record["attack"]*100/$attack_units)/100);
               $units_win=floor($units_captured*($db_theend->Record["attack"]*100/$attack_units)/100);
               echo "<br>";
               if($site_language=="en")
                 echo "Gold earned by ";
               else
                 echo "Aur castigat de ";
               echo $db_theend->Record["username"].": ".$gold_win;
               if($site_language=="en")
                 echo " Units earned: ";
               else
                 echo " Unitati castigate: ";
               echo $units_win;
               $total_gold_win+=$gold_win;
               $total_units_win+=$units_win;
               $query2="update armory set gold=gold+".$gold_win.", untrained=untrained+".$units_win.", units=units+".$units_win." where id=".$db_theend->Record["id"];
               $db2->query($query2);
          }

          echo "<br><br>";
          if($site_language=="en")
            echo "Total gold captured: ";
          else
            echo "Aur capturat in total: ";
          echo $total_gold_win;
          echo "</font>";
          $winid=$idal;
      }
      if($power_attack<$power_defense)
      {
          $atpp=round($power_attack*100/($power_attack+$power_defense));
          $dfpp=round($power_defense*100/($power_attack+$power_defense));

          if($site_language=="en")
          {
            echo "<font color=\"#F0F0F0\">Your alliance attack power: ".$power_attack." (".$atpp."%)";
            echo "<br>".$_GET["user"]." has ".$power_defense." defense power. (".$dfpp."%)";
          }
          else
          {
            echo "<font color=\"#F0F0F0\">Puterea de atac a aliantei: ".$power_attack." (".$atpp."%)";
            echo "<br>".$_GET["user"]." are ".$power_defense." putere de aparare. (".$dfpp."%)";
          }

          $query2="select count(armory.id) as nr, sum(armory.attack) as attack from armory, alliance_members where armory.id=alliance_members.id_member and alliance_members.id_al=".$idal." and alliance_members.grade>=0";
          $db2->query($query2);
          $db2->next_record();
          $attack_units=$db2->Record["attack"];
          $nr_members=$db2->Record["nr"];

          if($site_language=="en")
            echo "<br>Your alliance total attack units: ".$attack_units." (".$nr_members." members)";
          else
            echo "<br>Unitatile de atac ale aliantei: ".$attack_units." (".$nr_members." membrii)";

          $units_killed=floor((($dfpp-50)/2/100*$attack_units)*(3/4));
          $units_captured=floor((($dfpp-50)/2/100*$attack_units)*(1/4));

          $query2="select exp, level from armory where id=".$defense_id;
          $db2->query($query2);
          $db2->next_record();
          $exp=$db2->Record["exp"];
          $dflevel=$db2->Record["level"];

          $exp_gained=100-$dfpp;

          if($exp_gained<0) $exp_gained=0;

          $query2="update armory set untrained=untrained+".$units_captured.", units=units+".$units_captured.", exp=exp+".$exp_gained." where id=".$defense_id;
          $db2->query($query2);

          $total_lost=0;
          $query="select users.username, armory.id, armory.attack from armory, alliance_members, users where armory.id=alliance_members.id_member and alliance_members.id_al=".$idal." and armory.id=users.id";
          $db_theend->query($query);
          while($db_theend->next_record())
          {
               $attack_lost=floor($db_theend->Record["attack"]*($db_theend->Record["attack"]*100/$attack_units)/100);
               if($attack_lost>$db_theend->Record["attack"]) $attack_lost=$db_theend->Record["attack"];
               echo "<br>";
               if($site_language=="en")
                 echo "Attack units lost by ";
               else
                 echo "Unitati de atac pierdute de ";
               echo $db_theend->Record["username"].": ".$attack_lost;
               $total_lost+=$attack_lost;
               $query2="update armory set attack=attack-".$attack_lost.", units=units-".$attack_lost." where id=".$db_theend->Record["id"];
               $db2->query($query);
          }

          if($site_language=="en")
            echo "<br><br>Total units lost: ";
          else
            echo "<br><br>Unitati pierdute in total: ";
          echo ($total_lost+$attack_lost);
          echo "</font>";
          $winid=$defense_id;
      }
      if($power_attack==$power_defense)
      {
          if($site_language=="en")
            echo "<font color=\"#F0F0F0\">Nobody wins.</font>";
          else
            echo "<font color=\"#F0F0F0\">Nimeni nu a castigat.</font>";
          $winid=-1;
      }

      $query="insert into superattack_log values (DEFAULT,'".date("Y-m-d")."',".$idal.",".$defense_id.",".$winid.",".$power_attack.",".$power_defense.")";
      $db_theend->query($query);
  }
  }
  echo "<br>";

  echo "</td></tr>";
  echo "</table>";
}

function superattack_details($id)
{
  global $login_expires;
  
  $site_language=site_language();

  if($site_language=="en") $ppath="pics/en/";
  else $ppath="pics/";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" height=\"2\" width=\"470\"><tr><td></td></tr></table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\">";
  echo "<tr><td background=\"pics/redbigbar.gif\" align=\"center\" height=\"22\"><b>ALLIANCE ATTACK DETAILS</b></td></tr>";
  echo "</table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" height=\"4\" width=\"470\"><tr><td></td></tr></table>";

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select superattack_log.data, superattack_log.at_id, superattack_log.df_id, superattack_log.win_id, superattack_log.atp, superattack_log.dfp, alliances.name from superattack_log, alliances where superattack_log.id=".$id." and superattack_log.at_id=alliances.id";
  $db_theend->query($query);
  $db_theend->next_record();

  echo "Alliance ".$db_theend->Record["name"]." attacked your army on ".$db_theend->Record["date"]." with ".$db_theend->Record["atp"]." power.";
  echo "<br>";
  echo "Your army defended with ".$db_theend->Record["dfp"]." power.";
  echo "<br>";
  if($db_theend->Record["win_id"]==$db_theend->Record["at_id"])
  {
    echo "You lost.";
  }
  if($db_theend->Record["win_id"]==$db_theend->Record["df_id"])
  {
    echo "You won.";
  }
  if($db_theend->Record["win_id"]==-1)
  {
    echo "The two forces were equal.";
  }
*/
}
?>
