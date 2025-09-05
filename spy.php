<?php

function spy($user)
{

}

function spy_user_now($user)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db2 = new DataBase_theend;
  $db2->connect();
  $db3 = new DataBase_theend;
  $db3->connect();  
  
  $site_language=site_language();

  // initializare informatii misiune 1 (attack info)

  $enemy_elite_attack_units=0;
  $enemy_combat_units=0;
  $enemy_untrained_units=0;
  $enemy_attack_level=0;
  $enemy_attack_power=0;
  $enemy_total_attack_power=0;
  $enemy_attack_w1=0;
  $enemy_attack_w1_power=0;
  $enemy_attack_w2=0;
  $enemy_attack_w2_power=0;
  $enemy_attack_w3=0;
  $enemy_attack_w3_power=0;
  $enemy_attack_w4=0;
  $enemy_attack_w4_power=0;
  $enemy_attack_w5=0;
  $enemy_attack_w5_power=0;
  $enemy_attack_w6=0;
  $enemy_attack_w6_power=0;
  $enemy_attack_w7=0;
  $enemy_attack_w7_power=0;
  $enemy_attack_w8=0;
  $enemy_attack_w8_power=0;
  $enemy_attack_w9=0;
  $enemy_attack_w9_power=0;
  $enemy_attack_w10=0;
  $enemy_attack_w10_power=0;

  // initializare informatii misiune 2 (defense info)

  $enemy_elite_defense_units=0;
  $enemy_combat_units=0;
  $enemy_untrained_units=0;
  $enemy_defense_level=0;
  $enemy_defense_power=0;
  $enemy_total_defense_power=0;

  // initializare informatii misiune 3 (units info)

  $enemy_elite_attack_units=0;
  $enemy_elite_defense_units=0;
  $enemy_combat_units=0;
  $enemy_spy_units=0;
  $enemy_sentry_units=0;
  $enemy_worker_units=0;
  $enemy_untrained_units=0;
  $enemy_total_units=0;

  // initializare informatii misiune 4 si 5 (sabotaj)  
  
  $damage_points=0;


  if($_POST["spy"]=="attack") $mission=1;
  if($_POST["spy"]=="defense") $mission=2;
  if($_POST["spy"]=="units") $mission=3;
  if($_POST["spy"]=="attack_weapons") $mission=4; 
  if($_POST["spy"]=="defense_weapons") $mission=5;

  $spies=round($_POST["spies"]);
  
  semafor_on($_COOKIE["uid"]);

  $query="select armory.spy as spies, armory.power_bonus, armory.turn, upgrades.spy as spy from upgrades, armory where armory.id=upgrades.id and upgrades.id=".$_COOKIE["uid"];
  $db_theend->query($query);
  $db_theend->next_record();
  $spy_level=$db_theend->Record["spy"];
  $spy_power_bonus=$db_theend->Record["power_bonus"];
  if($spies>$db_theend->Record["spies"])
    $spies=$db_theend->Record["spies"];
  $turns=$db_theend->Record["turn"];  
  if($mission==1 || $mission==2 || $mission==3)
  {
  	 $turns=$turns-1;
  }
  if($mission==4 || $mission==5)
  {
  	 $turns=$turns-10;
  }  
  if($spies<1)
  {
    echo "<div class=\"titlebar\">";
    if($site_language=="en")
      echo "SPY MISSION RESULT";
    else 
      echo "REZULTAT MISIUNE SPIONAJ";  
    echo "</div>";

    echo "<br />";
  
    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\">";
  
    if($site_language=="en")
      echo "<br>You must send at least one spy in mission! Mission aborted!<br>";
    else 
      echo "<br>Trebuie sa trimiti cel putin un spion in misiune! Misiune anulata!<br>";  
    
    echo "<br>";
    
    echo "</div>";
    echo "</div>";
    echo "</div>";
  	
  	semafor_off($_COOKIE["uid"]);
    
    return -1;
  }
  if($turns<0)
  {
    echo "<div class=\"titlebar\">";
    if($site_language=="en")
      echo "SPY MISSION RESULT";
    else 
      echo "REZULTAT MISIUNE SPIONAJ";  
    echo "</div>";

    echo "<br />";
  
    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\">";
  
    if($site_language=="en")
      echo "<br>You don't have enough Action Points! Mission aborted!<br>";
    else 
      echo "<br>Nu ai suficiente AP-uri! Misiune anulata!<br>";  
    
    echo "<br>";
    
    echo "</div>";
    echo "</div>";
    echo "</div>"; 	
  	
    semafor_off($_COOKIE["uid"]);
    
    return -1;
  }  

  $spy_power=power_spy($_COOKIE["uid"]);

  $query="select users.username, users.race, upgrades.antispy as sentry, armory.power_bonus, armory.antispy as antispy from upgrades, armory, users where armory.id=upgrades.id and upgrades.id=".$_POST["user"]." and users.id=upgrades.id";
  $db_theend->query($query);
  $db_theend->next_record();
  $sentry_level=$db_theend->Record["sentry"];
  $sentry_power_bonus=$db_theend->Record["power_bonus"];
  $sentries=$db_theend->Record["antispy"];
  $username=$db_theend->Record["username"];
  $userrace=$db_theend->Record["race"];
  
  $sentry_power=power_sentry($_POST["user"]);

  $atpp=$spy_power*100/($spy_power+$sentry_power);
  $dfpp=$sentry_power*100/($spy_power+$sentry_power);

  $succes=random_number(1,100);
  if($succes<=$atpp)
    $succes=1;
  else
    $succes=0;

  $killed_spies=round(random_number(0,100-$atpp)/100*$spies);
  if($mission==4 || $mission==5) // sabotaj, consuma 10 AP
  {
    $killed_sentries=round(random_number(0,100-$dfpp)/1000*$sentries);
  }
  else 
  {
  	$killed_sentries=round(random_number(0,100-$dfpp)/10000*$sentries);
  }  
  
  if($succes==0)
  {
    $killed_sentries=0;	
  }
  
  //weapons damage  
  //pt fiecare spion mort stricam 1 punct la arme
  
    $units=$killed_spies;
    $query2="select user_weapons.procw1, user_weapons.w1, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$_COOKIE["uid"]." and user_weapons.w1=weapons.id and weapons.type=3 order by weapons.power desc";
    $db2->query($query2);
    $no_queries+=1;
    while($db2->next_record())
    {
      if($units>0)
      {
        if($units>=$db2->Record["now1"])
        {
          $proc=$db2->Record["procw1"]-1*$db2->Record["now1"];
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$_COOKIE["uid"];
          $db3->query($query3);
          $no_queries+=1;
        }
        else
        {
          $proc=$db2->Record["procw1"]-1*$units;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$_COOKIE["uid"];
          $db3->query($query3);
          $no_queries+=1;
        }
        $units=$units-$db2->Record["now1"];
      }
    }  
  
  //pt. fiecare sentry mort stricam un punct la arme

    $units=$killed_sentries;
    $query2="select user_weapons.procw1, user_weapons.w1, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$_POST["user"]." and user_weapons.w1=weapons.id and weapons.type=4 order by weapons.power desc";
    $db2->query($query2);
    $no_queries+=1;
    while($db2->next_record())
    {
      if($units>0)
      {
        if($units>=$db2->Record["now1"])
        {
          $proc=$db2->Record["procw1"]-1*$db2->Record["now1"];
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$_POST["user"];
          $db3->query($query3);
          $no_queries+=1;
        }
        else
        {
          $proc=$db2->Record["procw1"]-1*$units;
          if($proc<0) $proc=0;
          $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$_POST["user"];
          $db3->query($query3);
          $no_queries+=1;
        }
        $units=$units-$db2->Record["now1"];
      }
    }  

  //weapons damage end
    
  if($succes)
  {
    if($mission==1)
    {
      $query="select armory.id, armory.elite_at, armory.attack as atunits, armory.untrained, upgrades.attack as atlevel from armory, upgrades where armory.id=upgrades.id and armory.id=".$_POST["user"];
      $db_theend->query($query);
      $db_theend->next_record();
      $enemy_id=$db_theend->Record["id"];
      $enemy_elite_attack_units=$db_theend->Record["elite_at"];
      $enemy_combat_units=$db_theend->Record["atunits"];
      $enemy_untrained_units=$db_theend->Record["untrained"];
      $enemy_attack_level=$db_theend->Record["atlevel"];

      $query2="select alliance_members.id_al, alliance_members.grade from alliance_members, users where alliance_members.id_member=users.id and alliance_members.grade>=0 and users.id=".$_POST["user"];
      $db2->query($query2);
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

      $enemy_attack_power=power_attack($enemy_id);
      $enemy_total_attack_power=$enemy_attack_power;

      if($al_grade==0) //membru
      {
        $enemy_total_attack_power=min(round($enemy_attack_power+0.006*$alliance_power),1.5*$enemy_attack_power);
      }
      if($al_grade==1) //comandant
      {
        $enemy_total_attack_power=min(round($enemy_attack_power+0.01*$alliance_power),1.5*$enemy_attack_power);
      }
      if($al_grade==2) //ofiter
      {
        $enemy_total_attack_power=min(round($enemy_attack_power+0.008*$alliance_power),1.5*$enemy_attack_power);
      }
    }
    if($mission==2)
    {
      $query="select armory.id, armory.elite_df, armory.attack as dfunits, armory.untrained, upgrades.defense as dflevel from armory, upgrades where armory.id=upgrades.id and armory.id=".$_POST["user"];
      $db_theend->query($query);
      $db_theend->next_record();
      $enemy_id=$db_theend->Record["id"];
      $enemy_elite_defense_units=$db_theend->Record["elite_df"];
      $enemy_combat_units=$db_theend->Record["dfunits"];
      $enemy_untrained_units=$db_theend->Record["untrained"];
      $enemy_defense_level=$db_theend->Record["dflevel"];

      $query2="select alliance_members.id_al, alliance_members.grade from alliance_members, users where alliance_members.id_member=users.id and alliance_members.grade>=0 and users.id=".$_POST["user"];
      $db2->query($query2);
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
      $enemy_defense_power=power_defense($_POST["user"]);
      $enemy_total_defense_power=$enemy_defense_power;

      if($al_grade==0) //membru
      {
        $enemy_total_defense_power=min(round($enemy_defense_power+0.006*$alliance_power),1.5*$enemy_defense_power);
      }
      if($al_grade==1) //comandant
      {
        $enemy_total_defense_power=min(round($enemy_defense_power+0.01*$alliance_power),1.5*$enemy_defense_power);
      }
      if($al_grade==2) //ofiter
      {
        $enemy_total_defense_power=min(round($enemy_defense_power+0.008*$alliance_power),1.5*$enemy_defense_power);
      }
    }
    if($mission==3)
    {
      $query="select elite_at, elite_df, attack, spy, antispy, workers, untrained, units from armory where id=".$_POST["user"];
      $db_theend->query($query);
      $db_theend->next_record();
      $enemy_elite_attack_units=$db_theend->Record["elite_at"];
      $enemy_elite_defense_units=$db_theend->Record["elite_df"];
      $enemy_combat_units=$db_theend->Record["attack"];
      $enemy_spy_units=$db_theend->Record["spy"];
      $enemy_sentry_units=$db_theend->Record["antispy"];
      $enemy_worker_units=$db_theend->Record["workers"];
      $enemy_untrained_units=$db_theend->Record["untrained"];
      $enemy_total_units=$db_theend->Record["units"];
    }
    if($mission==4) //sabotage attack weapons
    {
      $damage_points=0;
    	
      $query2="select user_weapons.procw1, user_weapons.w1, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$_POST["user"]." and user_weapons.w1=weapons.id and weapons.type=1 order by weapons.power desc";
      $db2->query($query2);
      while($db2->next_record())
      {        
      	$damage=round((random_number($atpp/2,$atpp)/100)*$db2->Record["now1"]);
      	$damage_points=$damage_points+$damage;
      	$proc=$db2->Record["procw1"]-$damage;
        if($proc<0) $proc=0;
        $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$_POST["user"];
        $db3->query($query3);
      }       	
    }
    if($mission==5) //sabotage defense weapons
    {
      $damage_points=0;
    	
      $query2="select user_weapons.procw1, user_weapons.w1, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$_POST["user"]." and user_weapons.w1=weapons.id and weapons.type=0 order by weapons.power desc";
      $db2->query($query2);
      while($db2->next_record())
      {
      	$damage=round((random_number($atpp/2,$atpp)/100)*$db2->Record["now1"]);
      	$damage_points=$damage_points+$damage;
      	$proc=$db2->Record["procw1"]-$damage;
        if($proc<0) $proc=0;
        $damage_points=$damage_points+1*$db2->Record["now1"];        
        $query3="update user_weapons set procw1=".$proc." where w1=".$db2->Record["w1"]." and id=".$_POST["user"];
        $db3->query($query3);
      }      	
    }    
  }

  // update attacker's armory

  $query="update armory set spy=spy-".$killed_spies.", units=units-".$killed_spies.", turn=".$turns." where id=".$_COOKIE["uid"];
  $db_theend->query($query);

  // update defender's armory

  $query="update armory set antispy=antispy-".$killed_sentries.", units=units-".$killed_sentries." where id=".$_POST["user"];
  $db_theend->query($query);

  // create spy log

  if($succes) $win_id=$_COOKIE["uid"];
  else $win_id=$_POST["user"];

  $query="insert into spy_log values(DEFAULT,'".date("Y-m-d H:i:s")."',".$_COOKIE["uid"].",".$_POST["user"].",".$win_id.",".$mission.",".$spies.",".$sentries.",".$spy_power.",".$sentry_power.",".$killed_spies.",".$killed_sentries.",".$enemy_elite_attack_units.",".$enemy_combat_units.",".$enemy_untrained_units.",".$enemy_attack_level.",".$enemy_attack_power.",".$enemy_total_attack_power.",".$enemy_elite_defense_units.",".$enemy_combat_units.",".$enemy_defense_level.",".$enemy_defense_power.",".$enemy_total_defense_power.",".$enemy_spy_units.",".$enemy_sentry_units.",".$enemy_worker_units.",".$enemy_total_units.",".$damage_points.")";
  $db_theend->query($query);

    echo "<div class=\"titlebar\">";
    if($site_language=="en")
      echo "SPY MISSION RESULT";
    else 
      echo "REZULTAT MISIUNE SPIONAJ";  
    echo "</div>";

    echo "<br />";
  
    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\" style=\"text-align: center;\">";
  
  if($site_language=="en")
    echo "<font style=\"font-size: 12px; font-weight: bold; color: #C0C0C0;\">Spy mission on <a class=\"".$userrace."\" style=\"font-size: 12px;\" href=\"user_profile.php?uid=".$_POST["user"]."\"><b>".$username."</b></a>.</font>";
  else 
    echo "<font style=\"font-size: 12px; font-weight: bold; color: #C0C0C0;\">Misiune de spionaj asupra lui <a class=\"".$userrace."\" style=\"font-size: 12px;\" href=\"user_profile.php?uid=".$_POST["user"]."\"><b>".$username."</b></a>.</font>";  
  echo "<br /><br />";

  if($succes)
  {
    if($site_language=="en")
  	  echo "<font color=\"#00FF00\" style=\"font-size: 14px; font-weight: bold;\"><b>Mission succeded.</b></font>";
  	else 
  	  echo "<font color=\"#00FF00\" style=\"font-size: 14px; font-weight: bold;\"><b>Misiune reusita.</b></font>";  
  }
  else
  {
    if($site_language=="en")
  	  echo "<font color=\"#FF0000\" style=\"font-size: 14px; font-weight: bold;\"><b>Mission failed.</b></font>";
    else 
      echo "<font color=\"#FF0000\" style=\"font-size: 14px; font-weight: bold;\"><b>Misiune esuata.</b></font>";
  }
  echo "<br /><br />";
  if($succes && $mission==1)
  {
    if($site_language=="en")
    {
  	echo "<table class=\"table3\" cellspacing=\"1\" cellpadding=\"0\">";
  	echo "<tr><td class=\"spyres1\">Elite attack units:</td><td class=\"spyres2\">".number_format($enemy_elite_attack_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Combat units:</td><td class=\"spyres2\">".number_format($enemy_combat_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Untrained units:</td><td class=\"spyres2\">".number_format($enemy_untrained_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Attack level:</td><td class=\"spyres2\">".number_format($enemy_attack_level)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Attack power:</td><td class=\"spyres2\">".number_format($enemy_attack_power)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Total attack power:</td><td class=\"spyres2\">".number_format($enemy_total_attack_power)."</td></tr>";
    echo "</table>";
    }
    else 
    {
  	echo "<table class=\"table3\" cellspacing=\"1\" cellpadding=\"0\">";
  	echo "<tr><td class=\"spyres1\">Unitati de atac de elita:</td><td class=\"spyres2\">".number_format($enemy_elite_attack_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Unitati de lupta:</td><td class=\"spyres2\">".number_format($enemy_combat_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Unitati neantrenante:</td><td class=\"spyres2\">".number_format($enemy_untrained_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Nivel de atac:</td><td class=\"spyres2\">".number_format($enemy_attack_level)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Putere de atac:</td><td class=\"spyres2\">".number_format($enemy_attack_power)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Putere de atac totala:</td><td class=\"spyres2\">".number_format($enemy_total_attack_power)."</td></tr>";
    echo "</table>";    	
    }
  }
  if($succes && $mission==2)
  {
    if($site_language=="en")
    {
  	echo "<table class=\"table3\" cellspacing=\"1\" cellpadding=\"0\">";
  	echo "<tr><td class=\"spyres1\">Elite defense units:</td><td class=\"spyres2\">".number_format($enemy_elite_defense_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Combat units:</td><td class=\"spyres2\">".number_format($enemy_combat_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Untrained units:</td><td class=\"spyres2\">".number_format($enemy_untrained_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Defense level:</td><td class=\"spyres2\">".number_format($enemy_defense_level)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Defense power:</td><td class=\"spyres2\">".number_format($enemy_defense_power)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Total defense power:</td><td class=\"spyres2\">".number_format($enemy_total_defense_power)."</td></tr>";
    echo "</table>";
    }
    else 
    {
  	echo "<table class=\"table3\" cellspacing=\"1\" cellpadding=\"0\">";
  	echo "<tr><td class=\"spyres1\">Unitati de aparare de elita:</td><td class=\"spyres2\">".number_format($enemy_elite_defense_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Unitati de lupta:</td><td class=\"spyres2\">".number_format($enemy_combat_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Unitati neantrenante:</td><td class=\"spyres2\">".number_format($enemy_untrained_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Nivel de aparare:</td><td class=\"spyres2\">".number_format($enemy_defense_level)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Putere de aparare:</td><td class=\"spyres2\">".number_format($enemy_defense_power)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Putare de aparare totala:</td><td class=\"spyres2\">".number_format($enemy_total_defense_power)."</td></tr>";
    echo "</table>";    	
    }
  }
  if($succes && $mission==3)
  {
    if($site_language=="en")
    {
  	echo "<table class=\"table3\" cellspacing=\"1\" cellpadding=\"0\">";
  	echo "<tr><td class=\"spyres1\">Elite attack units:</td><td class=\"spyres2\">".number_format($enemy_elite_attack_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Elite defense units:</td><td class=\"spyres2\">".number_format($enemy_elite_defense_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Combat units:</td><td class=\"spyres2\">".number_format($enemy_combat_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Spies:</td><td class=\"spyres2\">".number_format($enemy_spy_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Sentries:</td><td class=\"spyres2\">".number_format($enemy_sentry_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Untrained units:</td><td class=\"spyres2\">".number_format($enemy_untrained_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Workers/slaves:</td><td class=\"spyres2\">".number_format($enemy_worker_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Total units:</td><td class=\"spyres2\">".number_format($enemy_total_units)."</td></tr>";
    echo "</table>";
    }
    else 
    {
   	echo "<table class=\"table3\" cellspacing=\"1\" cellpadding=\"0\">";
  	echo "<tr><td class=\"spyres1\">Unitati de atac de elita:</td><td class=\"spyres2\">".number_format($enemy_elite_attack_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Unitati de aparare de elita:</td><td class=\"spyres2\">".number_format($enemy_elite_defense_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Unitati de lupta:</td><td class=\"spyres2\">".number_format($enemy_combat_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Spioni:</td><td class=\"spyres2\">".number_format($enemy_spy_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Contra-spioni:</td><td class=\"spyres2\">".number_format($enemy_sentry_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Unitati neantrenate:</td><td class=\"spyres2\">".number_format($enemy_untrained_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Muncitori/sclavi:</td><td class=\"spyres2\">".number_format($enemy_worker_units)."</td></tr>";
    echo "<tr><td class=\"spyres1\">Total unitati:</td><td class=\"spyres2\">".number_format($enemy_total_units)."</td></tr>";
    echo "</table>";   	
    }
  }
  if($succes && $mission==4)
  {
    if($site_language=="en")
  	  echo "Enemy's attack weapons were damaged by ".number_format($damage_points)." points.<br>";
  	else 
  	  echo "Puterea armelor de atac ale inamicului a fost redusa cu ".number_format($damage_points)." puncte.<br>";
  	  
  }
  if($succes && $mission==5)
  {
    if($site_language=="en")
  	  echo "Enemy's defense weapons were damaged by ".number_format($damage_points)." points.<br>";
  	else 
  	  echo "Puterea armelor de aparare ale inamicului a fost redusa cu ".number_format($damage_points)." puncte.<br>";  
  }  
    
  echo "<br><br>";
  if($site_language=="en")
    echo "<a href=\"user_profile.php?uid=".$_POST["user"]."\">[spy again]</a><br><br>";
  else 
    echo "<a href=\"user_profile.php?uid=".$_POST["user"]."\">[spioneaza din nou]</a><br><br>"; 
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  semafor_off($_COOKIE["uid"]);
}

function spy_logs()
{
  $db = new DataBase_theend;
  $db->connect();
  
  $site_language=site_language();

  if(!$_POST["who"] || $_POST["who"]=="you")
  {

    echo "<div class=\"titlebar\">";
    if($site_language=="en")
      echo "SPY MISSIONS - LOGS (your misions)";
    else 
      echo "ISTORIC SPIONAJ - MISIUNILE TALE";  
    echo "</div>";
    echo "<br />";

  $query="select spy_log.id, spy_log.at_id, spy_log.datetime, spy_log.df_id, users.username, users.race, spy_log.mission, spy_log.win_id from spy_log, users where at_id=".$_COOKIE["uid"]." and df_id=users.id order by spy_log.datetime";
  $db->query($query);
  
  $nr_inreg_cur=0;
  $nr_inreg_pag=30;
  $nr_inreg=$db->num_rows();
  
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
  echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
  echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
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
          echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";   
  
  echo "<div class=\"section\">";
  
  $i=0;
  while($db->next_record())
  {
  	$nr_inreg_cur++;
    if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
    {  	
  	echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  	echo "<tr>";
  	echo "<td class=\"spl1\">".$nr_inreg_cur."</td>";
    echo "<td class=\"spl2\"><a class=\"".$db->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["df_id"]."\">".$db->Record["username"]."</a></td>";
    echo "<td class=\"spl3\">";
    if($db->Record["win_id"]==$db->Record["at_id"])
      echo "<font color=\"#F0F0F0\">";
    if($db->Record["mission"]==1)
      if($site_language=="en")
        echo "attack info: ";
      else 
        echo "informatii atac: ";  
    if($db->Record["mission"]==2)
      if($site_language=="en")
        echo "defense info: ";
      else 
        echo "informatii aparare: ";  
    if($db->Record["mission"]==3)
      if($site_language=="en")
        echo "units info: ";
      else 
        echo "informatii unitati: ";  
    if($db->Record["mission"]==4)
      if($site_language=="en")
        echo "attack sabotage: "; 
      else 
        echo "sabotaj atac: ";   
    if($db->Record["mission"]==5)
      if($site_language=="en")
        echo "defense sabotage: ";
      else 
        echo "sabotaj aparare: ";       
    if($db->Record["win_id"]==$db->Record["at_id"])
      if($site_language=="en")
        echo "mission success";
      else 
        echo "misiune reusita";  
    else
      if($site_language=="en")
        echo "mission failed";
      else 
        echo "misiune esuata";  
    if($db->Record["win_id"]==$db->Record["at_id"])
      echo "</font>";        
    echo "</td>";
    echo "<td class=\"spl4\">".$db->Record["datetime"]."</td>";
    echo "<td class=\"spl5\">";
    echo "<span id=\"spy_details_button_span_".$db->Record["id"]."\"><input type=\"button\" class=\"submit4\" value=\"Details\" onClick=\"spyDetails(".$db->Record["id"]."); showhide('spy_details_".$db->Record["id"]."');\"></input></span>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<div style=\"margin: 10px; display: none;\" id=\"spy_details_".$db->Record["id"]."\">";
    echo "<div class=\"spy_details\">";
    echo "<span id=\"spy_details_span_".$db->Record["id"]."\"></span>";
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
  echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
  echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
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
          echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"you\"></input>";
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
  if($_POST["who"]=="others")
  {
    echo "<div class=\"titlebar\">";
    if($site_language=="en")
      echo "SPY MISSIONS - LOGS (misions on you)";
    else 
      echo "ISTORIC SPIONAJ - MISIUNI ASUPRA TA";  
    echo "</div>";
    echo "<br />";  	
  	
  $query="select spy_log.id, spy_log.datetime, spy_log.at_id, users.username, users.race, spy_log.mission, spy_log.win_id from spy_log, users where df_id=".$_COOKIE["uid"]." and at_id=users.id order by spy_log.datetime";
  $db->query($query);
  
  $nr_inreg_cur=0;
  $nr_inreg_pag=30;
  $nr_inreg=$db->num_rows();
  
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
  echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
  echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
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
          echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>"; 
  
  echo "<div class=\"section\">"; 
    
  while($db->next_record())
  {
  	$nr_inreg_cur++;
    if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
    {   	
  	echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  	echo "<tr>";
  	echo "<td class=\"spl1\">".$nr_inreg_cur."</td>";
    echo "<td class=\"spl2\"><a class=\"".$db->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["at_id"]."\">".$db->Record["username"]."</a></td>";
    echo "<td class=\"spl3\">";
    if($db->Record["win_id"]==$db->Record["at_id"])
      echo "<font color=\"#F0F0F0\">";    
    if($db->Record["mission"]==1)
      if($site_language=="en")
        echo "attack info: ";
      else 
        echo "informatii atac: ";  
    if($db->Record["mission"]==2)
      if($site_language=="en")
        echo "defense info: ";
      else 
        echo "informatii aparare: ";  
    if($db->Record["mission"]==3)
      if($site_language=="en")
        echo "units info: ";
      else 
        echo "informatii unitati: ";  
    if($db->Record["mission"]==4)
      if($site_language=="en")
        echo "attack sabotage: "; 
      else 
        echo "sabotaj atac: ";   
    if($db->Record["mission"]==5)
      if($site_language=="en")
        echo "defense sabotage: ";
      else 
        echo "sabotaj aparare: ";       
    if($db->Record["win_id"]==$db->Record["at_id"])
      if($site_language=="en")
        echo "mission success";
      else 
        echo "misiune reusita";  
    else
      if($site_language=="en")
        echo "mission failed";
      else 
        echo "misiune esuata"; 
    if($db->Record["win_id"]==$db->Record["at_id"])
      echo "</font>";        
    echo "</td>";
    echo "<td class=\"spl4\">".$db->Record["datetime"]."</td>";
    echo "<td class=\"spl5\">";
    echo "<span id=\"spy_details_button_span_".$db->Record["id"]."\"><input type=\"button\" class=\"submit4\" value=\"Details\" onClick=\"spyDetails(".$db->Record["id"]."); showhide('spy_details_".$db->Record["id"]."');\"></input></span>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<div style=\"margin: 10px; display: none;\" id=\"spy_details_".$db->Record["id"]."\">";
    echo "<div class=\"spy_details\">";
    echo "<span id=\"spy_details_span_".$db->Record["id"]."\"></span>";
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
  echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
  echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
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
          echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\"></input>";
          echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
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

function spy_details($msid)
{
  $db = new DataBase_theend;
  $db->connect();

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
  echo "<tr><td height=\"1\" bgcolor=\"#404040\"></td></tr>";
  echo "<tr><td height=\"18\" bgcolor=\"#101520\">&nbsp;&nbsp;&nbsp;&nbsp;<font color=\"#C0D0E0\" style=\"font-size: 7pt;\"><b>SPY MISSION DETAILS</b></font></td></tr>";
  echo "<tr><td height=\"1\" bgcolor=\"#404040\"></td></tr>";
  echo "</table>";

  $query="select spy_log.id, spy_log.datetime, users.username, users.race, spy_log.mission, spy_log.at_id, spy_log.df_id, spy_log.win_id, spy_log.spies, spy_log.killed_spies, spy_log.eeatu, spy_log.eatu, spy_log.euntu, spy_log.eatl, spy_log.eatp, spy_log.etatp, spy_log.eedfu, spy_log.edfu, spy_log.edfl, spy_log.edfp, spy_log.etdfp, spy_log.espu, spy_log.eseu, spy_log.ewou, spy_log.etou, spy_log.dmgp from spy_log, users where spy_log.id=".$msid." and df_id=users.id";
  $db->query($query);
  $db->next_record();

  echo "<br>";

  echo "<table class=\"dotted\" width=\"90%\" bgcolor=\"#000000\"><tr><td>";

  echo "<b>Spy mission on <a class=\"".$db->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["df_id"]."\"><b>".$db->Record["username"]."</b></a></b><br>";
  echo "<font color=\"#909090\">Date: ".$db->Record["datetime"]."</font><br>";
  echo "<font color=\"#909090\">Objective: </font>";
  if($db->Record["mission"]==1)
    echo "<font color=\"#FF0000\">find informations regarding enemy's attack capabilites</font>";
  if($db->Record["mission"]==2)
    echo "<font color=\"#FF0000\">find informations regarding enemy's defense capabilites</font>";
  if($db->Record["mission"]==3)
    echo "<font color=\"#FF0000\">find informations regarding enemy's units</font>";
  echo "<br>";
  echo "<font color=\"#909090\">Mission result: </font>";
  if($db->Record["win_id"]==$db->Record["at_id"])
    echo "<font color=\"#00FF00\">success</font>";
  else
    echo "<font color=\"#FF0000\">failed</font>";
  echo "<br>";
  echo "<font color=\"#909090\">Spies sent in mission: </font>".$db->Record["spies"]."<br>";
  echo "<font color=\"#909090\">Spies returned: </font>".($db->Record["spies"]-$db->Record["killed_spies"])."<br>";
  echo "<br>";
  if($db->Record["win_id"]==$db->Record["at_id"])
  {
    echo "Information retreived: <br>";
    if($db->Record["mission"]==1)
    {
    echo "<font color=\"#909090\">Enemy elite attack units: ".$db->Record["eeatu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy combat units: ".$db->Record["eatu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy untrained units: ".$db->Record["euntu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy attack level: ".$db->Record["eatl"]."</font><br>";
    echo "<font color=\"#909090\">Enemy attack power: ".$db->Record["eatp"]."</font><br>";
    echo "<font color=\"#909090\">Enemy total attack power: ".$db->Record["etatp"]."</font><br>";
    }
    if($db->Record["mission"]==2)
    {
    echo "<font color=\"#909090\">Enemy elite defense units: ".$db->Record["eedfu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy combat units: ".$db->Record["edfu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy untrained units: ".$db->Record["euntu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy defense level: ".$db->Record["edfl"]."</font><br>";
    echo "<font color=\"#909090\">Enemy defense power: ".$db->Record["edfp"]."</font><br>";
    echo "<font color=\"#909090\">Enemy total defense power: ".$db->Record["etdfp"]."</font><br>";
    }
    if($db->Record["mission"]==3)
    {
    echo "<font color=\"#909090\">Enemy elite attack units: ".$db->Record["eeatu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy elite defense units: ".$db->Record["eedfu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy combat units: ".$db->Record["eatu"]."</font><br>";
    //echo "Enemy combat units: ".$db->Record["edfu"]."<br>";
    echo "<font color=\"#909090\">Enemy spies: ".$db->Record["espu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy sentries: ".$db->Record["eseu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy untrained units: ".$db->Record["euntu"]."</font><br>";
    echo "<font color=\"#909090\">Enemy workers/slaves: ".$db->Record["ewou"]."</font><br>";
    echo "<font color=\"#909090\">Enemy total units: ".$db->Record["etou"]."</font><br>";
    }
    if($db->Record["mission"]==4)
    {
      echo "<font color=\"#909090\">Enemy's attack weapons were damaged by ".number_format($db->Record["dmgp"])." points.</font><br>";
    }
    if($db->Record["mission"]==5)
    {
      echo "<font color=\"#909090\">Enemy's defense weapons were damaged by ".number_format($db->Record["dmgp"])." points.</font><br>";
    }    
  }

  echo "</td></tr></table>";
}

?>
