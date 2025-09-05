<?php
function command_center()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $db = new DataBase_theend;
  $db->connect();

  $db2 = new DataBase_theend;
  $db2->connect();

  $site_language=site_language();

  echo "<div class=\"titlebar\">";
  if($site_language=="ro")
    echo "CENTRUL DE COMANDA";
  else 
    echo "COMMAND CENTER";  
  echo "</div>";

  $query="select armory.id, users.race, units, attack, untrained, workers, level, exp, gold, turnlen, lastacct, `rank`, attack_rank, defense_rank, spy_rank, sentry_rank, power_bonus, users.best_rank, users.votes from armory, users where armory.id=".$_COOKIE["uid"]." and armory.id=users.id";
  $db_theend->query($query);

  $no_queries+=1;
  $db_theend->next_record();
  $myid=$db_theend->Record["id"];
  $race=$db_theend->Record["race"];
  $units=$db_theend->Record["units"];
  $attack=$db_theend->Record["attack"];
  $untrained=$db_theend->Record["untrained"];
  $workers=$db_theend->Record["workers"];
  $level=$db_theend->Record["level"];
  $exp=$db_theend->Record["exp"];
  $gold=$db_theend->Record["gold"];
  $turnlen=$db_theend->Record["turnlen"];
  $lastacct=$db_theend->Record["lastacct"];
  $rank=$db_theend->Record["rank"];
  $best_rank=$db_theend->Record["best_rank"];
  $attack_rank=$db_theend->Record["attack_rank"];
  $defense_rank=$db_theend->Record["defense_rank"];
  $spy_rank=$db_theend->Record["spy_rank"];
  $sentry_rank=$db_theend->Record["sentry_rank"];
  $votes=$db_theend->Record["votes"];
  $power_bonus=$db_theend->Record["power_bonus"];

  $query="select gold from seif where uid=".$myid;
  $db_theend->query($query);
  $db_theend->next_record();
  $safe_gold=$db_theend->Record["gold"];

  $query="select worker from upgrades where id=".$myid;
  $db_theend->query($query);
  $db_theend->next_record();
  $goldupgrade=$db_theend->Record["worker"];
  
    if(date("i")>=0 && date("i")<5)
      $timeleft=5-date("i");
  	if(date("i")>=5 && date("i")<25)
      $timeleft=25-date("i");
    if(date("i")>=25 && date("i")<45)
      $timeleft=45-date("i");
    if(date("i")>=45 && date("i")<60)
      $timeleft=60+5-date("i"); 
  
  echo "<br />";
  
  echo "<div class=\"section\">";  

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  echo "<tr><td class=\"cell6\">";
  if($site_language=="ro")
    echo "Nume:";
  else 
    echo "Username:";
  echo "</td><td class=\"cell7\">".$_COOKIE["user"]."</td>";

  echo "<td rowspan=\"9\" class=\"cell8\">";
  echo "<img class=\"avatar\" src=\"".useravatar2($_COOKIE["uid"],$race)."\"></img>";
  
  echo "<br /><br />";

  $query="select battle, battle_win from mastery where id=".$_COOKIE["uid"];
  $db->query($query);
  $db->next_record();

       if($db->Record["battle"]<100)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]<50)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=90)
         echo "<img src=\"pics/5stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=80)
         echo "<img src=\"pics/4stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=70)
         echo "<img src=\"pics/3stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=60)
         echo "<img src=\"pics/2stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=50)
         echo "<img src=\"pics/1stars.gif\">";

  echo "<br><br>";

  $query="select alliances.name, alliance_members.grade from alliances, alliance_members where alliance_members.id_member=".$_COOKIE["uid"]." and alliance_members.id_al=alliances.id and alliance_members.grade>=0";
  $db->query($query);
  if($db->num_rows())
  {
    $db->next_record();
    if($site_language=="ro")
    {
    if($db->Record["grade"]==0)
      echo "Membru ";
    if($db->Record["grade"]==1)
      echo "Comandant ";
    if($db->Record["grade"]==2)
      echo "Ofiter ";
    echo " al aliantei <font color=\"#FFA500\"><b>".$db->Record["name"]."</b></font>";
    }
    else
    {
    if($db->Record["grade"]==0)
      echo "Member ";
    if($db->Record["grade"]==1)
      echo "Commander ";
    if($db->Record["grade"]==2)
      echo "Officer ";
    echo " of alliance <font color=\"#FFA500\"><b>".$db->Record["name"]."</b></font>";    	
    }
  }
  else
  {
    if($site_language=="ro")
  	  echo "<font color=\"#909090\">Nu faci parte din nici o alianta.<br>Ar fi o idee buna sa intri in una.</font>";
  	else 
  	  echo "<font color=\"#909090\">You do not belong to any alliance.<br>Maybe it will be a good idea to join one.</font>";  
  }

  $query="select warned from users where id=".$_COOKIE["uid"];
  $db->query($query);
  $db->next_record();
  if($db->Record["warned"])
  {
    if($site_language=="ro")
  	  echo "<br><br><img src=\"pics/warned.gif\"></img> <font color=\"#FF0000\"><b>Administratorii ENS au avertizat acest cont pentru incalcarea repetata a regulilor jocului. Daca continui in acest mod acest cont va fi sters!</b></font>";
  	else 
  	  echo "<br><br><img src=\"pics/warned.gif\"></img> <font color=\"#FF0000\"><b>The ENS administrators have warned this account for repeatedly breaking the game rules. If you continue doing so this account will be permanently banned!</b></font>";  
  }

  echo "<br><br>";

  echo "</td>";
  echo "</tr>";  

  echo "<tr><td class=\"cell6\">";
  if($site_language=="ro")
    echo "Rasa:";
  else 
    echo "Race:";  
  echo "</td><td class=\"cell7\">";
  if($site_language=="ro")
  {
  switch($race)
  {
  	case "human":
  		echo "om";
  		break;
  	case "machine":
  		echo "masina";
  		break;
  	case "alien":
  		echo "extraterestru";
  		break;  		
  }
  }
  else 
    echo $race;
  echo "</td></tr>";
  echo "<tr><td class=\"cell6\">";
  if($site_language=="ro")
    echo "Loc:";
  else 
    echo "Rank:";  
  echo "</td><td class=\"cell7\">";
  if($rank)
    echo number_format($rank);
  else
  {
    if($site_language=="ro")
  	  echo "necalculat";
  	else 
  	  echo "unranked";  
  }
  echo "</td></tr>";
  echo "<tr><td class=\"cell6\">";
  if($site_language=="ro")
    echo "Cel mai bun loc obtinut:";
  else 
    echo "Best rank ever:";  
  echo "</td><td class=\"cell7\">";
  if($best_rank)
    echo number_format($best_rank);
  else
    echo "<font color=\"#909090\">none</font>";
  echo "</td></tr>";
  echo "<tr><td class=\"cell6\">";
  if($site_language=="ro")
    echo "Nivel:";
  else
    echo "Level:";
  echo "</td><td class=\"cell7\">".number_format($level)."</td></tr>";
  echo "<tr><td class=\"cell6\">";
  if($site_language=="ro")
    echo "Experienta:";
  else
    echo "Experience:";
  echo "</td><td class=\"cell7\">".number_format($exp)." / ".number_format(pow(2,$level)*1000)."</td></tr>";
  echo "<tr><td class=\"cell6\">";
  echo "EKR:";
  echo "</td><td class=\"cell7\">".number_format($gold+$safe_gold)."<br><font color=\"#909090\">".number_format($safe_gold);
  if($site_language=="ro")
    echo " in seif";
  else 
    echo " in safe";  
  echo "</font></td></tr>";
  echo "<tr><td class=\"cell6\">";
  if($site_language=="ro")
    echo "Productie EKR:";
  else 
    echo "EKR production:";  
  echo "</td><td class=\"cell7\">".number_format(100+$level*100+floor($untrained+(10+$goldupgrade)*$workers))." (in ".$timeleft." min.)</td></tr>";
  echo "<tr><td class=\"cell6\">";
  if($site_language=="ro")
    echo "Popularitate:";
  else 
    echo "Popularity:";
  echo "</td><td class=\"cell7\">".number_format($votes)." <span onMouseOver=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH='250px'; return escape('Send your profile link to friends to gain popularity.<br><a href=#>http://www.endofus.net/user_profile.php?uid=".$_COOKIE["uid"]."</a>')\"\"><font color=\"#FFD700\" style=\"font-size:10px;line-height:12px;font-family:verdana,arial,sans-serif;font-weight:normal;text-decoration:none;\">(?)</font></span></td></tr>";

  echo "</table>";
  
  echo "</div>";
  
  echo "<br />";
  
  echo "<div class=\"titlebar\">";
  if($site_language=="ro")
    echo "UNITATI";
  else 
    echo "UNITS";  
  echo "</div>";  

  $query="select armory.id, armory.units, armory.attack, armory.elite_at, armory.elite_df, armory.spy, armory.antispy, armory.workers, armory.untrained, armory.level, armory.exp from armory where armory.id=".$myid;
  $db->query($query);
  $no_queries+=1;
  $db->next_record();
  $id=$db->Record["id"];

  echo "<br />";

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";   
  echo "<tr><td class=\"cell4\"><font color=\"#FFA500\">";
  if($site_language=="ro")
    echo "Unitati de atac de elita:";
  else 
    echo "Elite Attack Units:";  
  echo "</font></td><td class=\"cell5\"><font color=\"#FFA500\">".number_format($db->Record["elite_at"])."</font></td>";
  echo "<tr><td class=\"cell4\"><font color=\"#FFA500\">";
  if($site_language=="ro")
    echo "Unitati de aparare de elita:";
  else 
    echo "Elite Defense Units:";  
  echo "</font></td><td class=\"cell5\"><font color=\"#FFA500\">".number_format($db->Record["elite_df"])."</font></td>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Unitati de lupta:";
  else 
    echo "Combat Units:";
  echo "</td><td class=\"cell5\">".number_format($db->Record["attack"])."</td>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Spioni:";
  else 
    echo "Spies:";  
  echo "</td><td class=\"cell5\">".number_format($db->Record["spy"])."</td>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Contra-spioni:";
  else 
    echo "Sentries:";
  echo "</td><td class=\"cell5\">".number_format($db->Record["antispy"])."</td>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
  {
  if($race=="human")
    echo "Muncitori:";
  else
    echo "Sclavi:";
  }
  else 
  {
  if($race=="human")
    echo "Workers:";
  else
    echo "Slaves:";  	
  }
  echo "</td><td class=\"cell5\">".number_format($db->Record["workers"])."</td>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Unitati neantrenate:";
  else 
    echo "Untrained Units:";
  echo "</td><td class=\"cell5\">".number_format($db->Record["untrained"])."</td>";
  echo "<tr><td class=\"cell4\"><font color=\"#FFD700\">Total:</font></td><td class=\"cell5\"><font color=\"#FFD700\">".number_format($db->Record["units"])."</font></td>";
  echo "</table>";
  
  echo "</div>";

  echo "<br />";
  
  echo "<div class=\"titlebar\">";
  if($site_language=="ro")
    echo "PUTERE";
  else 
    echo "POWER";  
  echo "</div>";  

  $query2="select id_al, grade from alliance_members where id_member=".$myid." and grade>=0";
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

  $myatpower=power_attack($myid);
  $mytotalatpower=$myatpower;

  if($al_grade==0) //membru
  {
    $mytotalatpower=min(round($myatpower+0.006*$alliance_power),round(1.5*$myatpower));
  }
  if($al_grade==1) //comandant
  {
    $mytotalatpower=min(round($myatpower+0.01*$alliance_power),round(1.5*$myatpower));
  }
  if($al_grade==2) //ofiter
  {
    $mytotalatpower=min(round($myatpower+0.008*$alliance_power),round(1.5*$myatpower));
  }

  $query2="select id_al, grade from alliance_members where id_member=".$myid." and grade>=0";
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

  $mydfpower=power_defense($myid);
  $mytotaldfpower=$mydfpower;

  if($al_grade==0) // membru
  {
    $mytotaldfpower=min(round($mydfpower+0.006*$alliance_power),round(1.5*$mydfpower));
  }
  if($al_grade==1) // comandant
  {
    $mytotaldfpower=min(round($mydfpower+0.01*$alliance_power),round(1.5*$mydfpower));
  }
  if($al_grade==2) // ofiter
  {
    $mytotaldfpower=min(round($mydfpower+0.008*$alliance_power),round(1.5*$mydfpower));
  }
  
  $myspypower=power_spy($myid);
  $mysentrypower=power_sentry($myid);

  echo "<br />";

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";  
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Atac";
  else 
    echo "Attack";
  echo "<font color=\"#909090\">";
  if($site_language=="ro")
    echo " (loc ";
  else 
    echo " (rank ";  
  echo number_format($attack_rank).")</font>";
  echo ":</td><td class=\"cell5\">".number_format($mytotalatpower)." <font color=\"#909090\">(".number_format($myatpower).")</font></td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Aparare";
  else 
    echo "Defense";  
  echo "<font color=\"#909090\">";
  if($site_language=="ro")
    echo " (loc ";
  else 
    echo " (rank ";
  echo number_format($defense_rank).")</font>";
  echo ":</td><td class=\"cell5\">".number_format($mytotaldfpower)." <font color=\"#909090\">(".number_format($mydfpower).")</font></td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Spionaj";
  else 
    echo "Spy";
  echo "<font color=\"#909090\">";
  if($site_language=="ro")
    echo " (loc ";
  else 
    echo " (rank ";
  echo number_format($spy_rank).")</font>";
  echo ":</td><td class=\"cell5\">".number_format($myspypower)."</td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Contra-spionaj";
  else 
    echo "Sentry";
  echo "<font color=\"#909090\">";
  if($site_language=="ro")
    echo " (loc ";
  else 
    echo " (rank ";
  echo number_format($sentry_rank).")</font>";
  echo ":</td><td class=\"cell5\">".number_format($mysentrypower)."</td></tr>";
  echo "</table>";
  
  echo "<div style=\"font-size:10px;line-height:12px;color:#F0F0F0;font-family:verdana,arial,sans-serif;font-weight:normal;text-decoration:none;\">";
  if($site_language=="ro")
    echo "<font color=\"#FFA500\"><b>(!)</b></font> <font color=\"#909090\">Valorile puterilor afisate vor varia destul de mult in functie de conditiile de lupta si de adversar. Valorile prezentate sunt orientative.</font>";
  else
    echo "<font color=\"#FFA500\"><b>(!)</b></font> <font color=\"#909090\">Power values will vary a lot depending on the fighting conditions and the enemy. Values presented in here are for orientative purpose only.</font>";
  echo "</div>";

  echo "</div>";
  
  echo "<br />";

  echo "<div class=\"titlebar\">";
  if($site_language=="ro")
    echo "UPGRADE";
  else 
    echo "UPGRADES";
  echo "</div>";

  $query2="select upgrades.attack, upgrades.defense, upgrades.spy, upgrades.antispy, upgrades.worker, upgrades.wprec, upgrades.population, upgrades.elite from upgrades where upgrades.id=".$myid;
  $db2->query($query2);
  $no_queries+=1;
  $db2->next_record();

  echo "<br />";

  echo "<div class=\"section\">";  
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">"; 
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Nivel atac:";
  else 
    echo "Attack Level:";
  echo "</td><td class=\"cell5\">".$db2->Record["attack"]."</td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Nivel aparare:";
  else
    echo "Defense Level:";
  echo "</td><td class=\"cell5\">".$db2->Record["defense"]."</td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Nivel spionaj:";
  else 
    echo "Spy Level:";
  echo "</td><td class=\"cell5\">".$db2->Record["spy"]."</td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Nivel contra-spionaj:";
  else 
    echo "Sentry Level:";
  echo "</td><td class=\"cell5\">".$db2->Record["antispy"]."</td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Nivel unitati de elita:";
  else 
    echo "Elite Level:";
  echo "</td><td class=\"cell5\">".$db2->Record["elite"]."</td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Nivel venit:";
  else 
    echo "Income Level:";
  echo "</td><td class=\"cell5\">".$db2->Record["worker"]."</td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Nivel precizie arme:";
  else 
    echo "Weapon Precision Level:";
  echo "</td><td class=\"cell5\">".$db2->Record["wprec"]."</td></tr>";
  echo "<tr><td class=\"cell4\">";
  if($site_language=="ro")
    echo "Nivel populatie:";
  else 
    echo "Population Level:";
  echo "</td><td class=\"cell5\">".$db2->Record["population"]."</td></tr>";
  echo "</table>";
  
  echo "</div>";

  echo "<br />";

  echo "<div class=\"titlebar\">";
  if($site_language=="ro")
    echo "ULTIMELE LOGARI";
  else   
    echo "LAST LOGINS";  
  echo "</div>";
  
  echo "<br />";
  
  echo "<div class=\"section\">";

  $query="select datetime, ip from login_log where cont=".$_COOKIE["uid"]." order by datetime desc limit 5";
  $db->query($query);

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  while($db->next_record())
  {
    $i++;
    echo "<tr><td class=\"cell2\">";
    echo "<font color=\"#909090\">".$i.".&nbsp;".$db->Record["datetime"]."&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "de la";
    else 
      echo "from";  
    echo "&nbsp;&nbsp;".$db->Record["ip"]."</font></td></tr>";
  }
  echo "</table>";
  
  echo "</div>";
  
}
?>
