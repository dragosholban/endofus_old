<?php

function train($train_error)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  
  $site_language=site_language();

  $myrace=userrace($_COOKIE["uid"]);

  $train_cost_per_unit=1000;
  $unit_cost=300;
  
  $query="select armory.units, armory.level, armory.exp, armory.attack, armory.spy, armory.antispy, armory.elite_at, armory.elite_df, armory.workers, armory.untrained, armory.gold, upgrades.population, upgrades.elite from armory, upgrades where armory.id=".$_COOKIE["uid"]." and armory.id=upgrades.id";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();

  echo "<div class=\"titlebar\">";
  if($site_language=="ro")
    echo "ANTRENARE UNITATI";
  else 
    echo "TRAIN UNITS";
  echo "</div>";  
  echo "<br />";

  if($train_error==-1) // Error! Not enoght money for this training!
  {
    echo "<br>";
    echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\"><tr><td align=\"center\"><font color=\"#FF0000\"><b>";
    if($site_language=="ro")
      echo "Eroare! Nu ai destui bani pentru aceasta actiune!";
    else 
      echo "Error! Not enoght money for this training!";
    echo "</b></font></td></tr></table>";
    echo "<br>";
  }
  if($train_error==-2) // Error! Not enoght untrained units to be trained!
  {
    echo "<br>";
    echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\"><tr><td align=\"center\"><font color=\"#FF0000\"><b>";
    if($site_language=="ro")
      echo "Eroare! Nu ai destule unitati neantrenate pentru a fi antrenate!";
    else 
      echo "Error! Not enoght untrained units to be trained!";  
    echo "</b></font></td></tr></table>";
    echo "<br>";
  }
  if($train_error==-3) // Error! Elite level error!
  {
    echo "<br>";
    echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\"><tr><td align=\"center\"><font color=\"#FF0000\"><b>Error! Your elite level does not allow more elite units to be trained!<br>";
    if($db_theend->Record["elite"])
    {
      if($site_language=="ro")
    	echo "Poti antrena maxim ".($db_theend->Record["elite"]*10)."% din totalul unitatilor de lupta in unitati de elita.";
      else 
        echo "You can train max. ".($db_theend->Record["elite"]*10)."% of your total combat units to elite.";
    }
    else
    {
      if($site_language=="ro")
    	echo "Nu poti antrena unitati de elita.";
      else 
      	echo "You cannot train elite units.";
    }
    echo "</b></font></td></tr></table>";
    echo "<br>";
  }
  if($train_error==-4) // Error! Not enoght combat units to be trained!
  {
    echo "<br>";
    echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\"><tr><td align=\"center\"><font color=\"#FF0000\"><b>";
    if($site_language=="ro")
      echo "Eroare! Nu ai destule unitati neantrenate pentru a fi antrenate!";
    else 
      echo "Error! Not enoght combat units to be trained!";  
    echo "</b></font></td></tr></table>";
    echo "<br>";
  }

  echo "<div class=\"section\">";
  
  echo "<form name=\"form_train_units\" action=\"play.php\" method=\"post\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"train\" />";

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  echo "<tr>";
  echo "<td class=\"tr1\"><font color=\"#FFA500\">";
  if($site_language=="ro")
    echo "Unitati de atac de elita";
  else
    echo "Elite Attack Units";
  echo "</font></td>";
  echo "<td class=\"tr2\">".number_format($db_theend->Record["elite_at"])."</td>";
  echo "<td class=\"tr3\"><input size=\"10\" class=\"input4\" type=\"text\" name=\"eliteat\"></input></td>";
  echo "<td class=\"tr4\">".number_format($train_cost_per_unit*1.5)." ";
  if($site_language=="en")
    echo "EKR/unit";
  else
    echo "EKR/unitate";
  echo "</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<td class=\"tr1\"><font color=\"#FFA500\">";
  if($site_language=="ro")
    echo "Unitati de aparare de elita";
  else
    echo "Elite Defense Units";
  echo "</font></td>";
  echo "<td class=\"tr2\">".number_format($db_theend->Record["elite_df"])."</td>";
  echo "<td class=\"tr3\"><input size=\"10\" class=\"input4\" type=\"text\" name=\"elitedf\"></input></td>";
  echo "<td class=\"tr4\">".number_format($train_cost_per_unit*1.5)." ";
  if($site_language=="en")
    echo "EKR/unit";
  else
    echo "EKR/unitate";
  echo "</td>";
  echo "</tr>";
  
  echo "<tr>";  
  echo "<td class=\"tr1\">";
  if($site_language=="ro")
    echo "Unitati de lupta";
  else
    echo "Combat units";
  echo "</td>";
  echo "<td class=\"tr2\">".number_format($db_theend->Record["attack"])."</td>";
  echo "<td class=\"tr3\"><input size=\"10\" class=\"input4\" type=\"text\" name=\"atunit\"></input></td>";
  echo "<td class=\"tr4\">".number_format($train_cost_per_unit)." ";
  if($site_language=="en")
    echo "EKR/unit";
  else
    echo "EKR/unitate";
  echo "</td>";
  echo "</tr>";
  
  echo "<tr>"; 
  echo "<td class=\"tr1\">";
  if($site_language=="ro")
    echo "Spioni";
  else
    echo "Spies";
  echo "</td>";
  echo "<td class=\"tr2\">".number_format($db_theend->Record["spy"])."</td>";
  echo "<td class=\"tr3\"><input size=\"10\" class=\"input4\" type=\"text\" name=\"spy\"></input></td>";
  echo "<td class=\"tr4\">".number_format($train_cost_per_unit*2)." ";
  if($site_language=="en")
    echo "EKR/unit";
  else
    echo "EKR/unitate";
  echo "</td>";
  echo "</tr>";
  
  echo "<tr>"; 
  echo "<td class=\"tr1\">";
  if($site_language=="en")
    echo "Sentries";
  else
    echo "Contra-spioni";
  echo "</td>";
  echo "<td class=\"tr2\">".number_format($db_theend->Record["antispy"])."</td>";
  echo "<td class=\"tr3\"><input size=\"10\" class=\"input4\" type=\"text\" name=\"antispy\"></input></td>";
  echo "<td class=\"tr4\">".number_format($train_cost_per_unit*2)." ";
  if($site_language=="en")
    echo "EKR/unit";
  else
    echo "EKR/unitate";
  echo "</td>";
  echo "</tr>";
  
  echo "<tr>"; 
  if($myrace=='human')
  {
    echo "<td class=\"tr1\">";
    if($site_language=="en")
      echo "Workers";
    else
      echo "Muncitori";
    echo "</td>";
  }
  else
  {
    echo "<td class=\"tr1\">";
    if($site_language=="en")
      echo "Slaves";
    else
      echo "Sclavi";
    echo "</td>";
  }
  echo "<td class=\"tr2\">".number_format($db_theend->Record["workers"])."</td>";
  echo "<td class=\"tr3\"><input size=\"10\" class=\"input4\" type=\"text\" name=\"workers\"></input></td>";
  echo "<td class=\"tr4\">".number_format($train_cost_per_unit/5)." ";
  if($site_language=="en")
    echo "EKR/unit";
  else
    echo "EKR/unitate";
  echo "</td>";
  echo "</tr>";
  
  echo "<tr>"; 
  echo "<td class=\"tr1\">";
  if($site_language=="en")
    echo "Untrained units";
  else
    echo "Unitati neantrenate";
  echo "</td>";
  echo "<td class=\"tr2\">".number_format($db_theend->Record["untrained"])."</td>";
  echo "<td class=\"tr3_empty\">&nbsp;</td>";
  echo "<td class=\"tr4_empty\">&nbsp;</td>";
  echo "</tr>";
  
  echo "<tr>"; 
  echo "<td class=\"tr1\"><font color=\"#FFD700\">Total</font></td>";
  echo "<td class=\"tr2\"><font color=\"#FFD700\">".number_format($db_theend->Record["units"])."<font color=\"#FFD700\"></td>";
  echo "<td class=\"tr3_empty\">&nbsp;</td>";
  echo "<td class=\"tr4_empty\">&nbsp;</td>";
  echo "</tr>";
  
  echo "<tr><td class=\"tr5\" colspan=\"4\">";
  
  if($site_language=="ro")
    echo "<input id=\"form_train_units_submit_button\" class=\"submit4\" type=\"button\" onClick=\"document.getElementById('form_train_units_submit_button').disabled = true; form_train_units.submit();\" value=\"Antrenare\" />";  
  else 
    echo "<input id=\"form_train_units_submit_button\" class=\"submit4\" type=\"button\" onClick=\"document.getElementById('form_train_units_submit_button').disabled = true; form_train_units.submit();\" value=\"Train\" />";    
  
  echo "</td></tr>";
  
  echo "</table>";

  echo "</form>";
  
  echo "</div>";

  echo "<br />";

  echo "<div class=\"titlebar\">";
  if($site_language=="ro")
    echo "DEMOBILIZARE UNITATI";
  else   
    echo "DISBAND UNITS";
  echo "</div>";

  echo "<br />";

  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"disband\"></input>";
  
  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\"><tr>";
  echo "<td class=\"tr6\">";
  if($site_language=="en")
    echo "Combat units";
  else
    echo "Unitati de lupta";
  echo "</td><td class=\"tr7\">".number_format($db_theend->Record["attack"])."</td>";
  echo "<td class=\"tr8\"><input class=\"input4\" name=\"atunits\" type=\"text\" size=\"10\"></input></td>";
  echo "</tr>";
  
  echo "<tr>";
  echo "<td class=\"tr6\">";
  if($site_language=="en")
    echo "Spies";
  else
    echo "Spioni";
  echo "</td><td class=\"tr7\">".number_format($db_theend->Record["spy"])."</td>";
  echo "<td class=\"tr8\"><input class=\"input4\" name=\"spy\" type=\"text\" size=\"10\"></input></td>";
  echo "</tr>";  
  
  echo "<tr>";
  echo "<td class=\"tr6\">";
  if($site_language=="en")
    echo "Sentries";
  else
    echo "Contra-spioni";
  echo "</td><td class=\"tr7\">".number_format($db_theend->Record["antispy"])."</td>";
  echo "<td class=\"tr8\"><input class=\"input4\" name=\"antispy\" type=\"text\" size=\"10\"></input></td>";
  echo "</tr>";  
  
  echo "<tr>";
  if($myrace=='human')
  {
    echo "<td class=\"tr6\">";
    if($site_language=="en")
      echo "Workers";
    else
      echo "Muncitori";
    echo "</td>";
  }
  else
  {
    echo "<td class=\"tr6\">";
    if($site_language=="en")
      echo "Slaves";
    else
      echo "Sclavi";
    echo "</td>";
  }
  echo "<td class=\"tr7\">".number_format($db_theend->Record["workers"])."</td>";
  echo "<td class=\"tr8\"><input class=\"input4\" name=\"workers\" type=\"text\" size=\"10\"></input></td>";
  echo "</tr>";
  
  echo "<tr><td class=\"tr5\" colspan=\"3\">";  

  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Disband\"></input>";
  else 
    echo "<input class=\"submit4\" type=\"submit\" value=\"Demobilizare\"></input>";    

  echo "</td></tr>"; 
  
  echo "</table>";  
  
  echo "</div>";

  echo "</form>";

  echo "<br />";

  $available_units=round((pow(2,$db_theend->Record["level"])*1000+$db_theend->Record["exp"])*(1+$db_theend->Record["population"]*10/100)-$db_theend->Record["units"]);
  if($available_units<0) $available_units=0;

  echo "<div class=\"titlebar\">";
  if($site_language=="ro")
    echo "CUMPARARE UNITATI";
  else 
    echo "BUY UNITS";  
  echo "</div>";

  echo "<br />";
  
  echo "<div class=\"section\">";
  if($available_units)
  {

  echo "<form action=\"play.php\" method=\"POST\"><input type=\"hidden\" name=\"loc\" value=\"train\"></input>";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\"><tr>";
  echo "<td class=\"tr1\">";
  if($site_language=="ro")
    echo "Unitati:";
  else 
    echo "Units:";  
  echo "</td>";
  echo "<td class=\"tr3\"><input size=\"10\" class=\"input4\" type=\"text\" name=\"units\"></input></td>";
  echo "<td class=\"tr3\">".$unit_cost." ";
  if($site_language=="en")
    echo "EKR/unit";
  else
    echo "EKR/unitate";
  echo "</td>";

  echo "<td class=\"tr8\">";
  if($site_language=="en")
    echo "availlable units: ".number_format($available_units);
  else
    echo "unitati disponibile: ".number_format($available_units);
  echo "</td></tr>";
  if($site_language=="ro")
    echo "<tr><td class=\"tr5\" colspan=\"4\"><input class=\"submit4\" type=\"submit\" value=\"Cumpara\"></input></td></tr>";
  else   
    echo "<tr><td class=\"tr5\" colspan=\"4\"><input class=\"submit4\" type=\"submit\" value=\"Buy\"></input></td></tr>";
  echo "</form>";
  echo "</table>";
  }
  else
  {
    echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
    echo "<tr><td class=\"tr5\">";
    if($site_language=="en")
      echo "No units availlable.";
    else
      echo "Nu sunt unitati disponibile.";
    echo "</td></tr>";
    echo "</table>";
  }
  echo "</div>";
}

function train_units()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $myrace=userrace($_COOKIE["uid"]);

  semafor_on($_COOKIE["uid"]);

  $query="select armory.id, armory.units, armory.level, armory.elite_at, armory.elite_df, armory.spy, armory.antispy, armory.workers, armory.attack, armory.untrained, armory.gold, upgrades.elite from armory, upgrades where armory.id=".$_COOKIE["uid"]." and armory.id=upgrades.id";
  $db_theend->query($query);
  $db_theend->next_record();

  $train_cost_per_unit=1000;

  $unit_cost=300;

  $id=$db_theend->Record["id"];
  $units=$db_theend->Record["units"];
  $attack=$db_theend->Record["attack"];
  $elite_at=$db_theend->Record["elite_at"];
  $elite_df=$db_theend->Record["elite_df"];
  $spy=$db_theend->Record["spy"];
  $antispy=$db_theend->Record["antispy"];
  $workers=$db_theend->Record["workers"];
  $untrained=$db_theend->Record["untrained"];
  $gold=$db_theend->Record["gold"];
  $elite_level=$db_theend->Record["elite"];

  if(round($_POST["atunit"]) && round($_POST["atunit"])>0)
  {
    if(round($_POST["atunit"])<=$untrained)
    {
      if(round($_POST["atunit"])*$train_cost_per_unit>$gold)
      {
        semafor_off($_COOKIE["uid"]);
        return -1; // Error! Not enoght money for this training!
      }
      else
      {
        $gold=$gold-round($_POST["atunit"])*$train_cost_per_unit;
        $untrained=$untrained-round($_POST["atunit"]);
        $query="update armory set attack=".($attack+round($_POST["atunit"])).", untrained=".$untrained.", gold=".$gold." where id=".$id;
        $db_theend->query($query);
      }
    }
    else
    {
      semafor_off($_COOKIE["uid"]);
      return -2; // Error! Not enoght untrained units to be trained!
    }
  }

  if(round($_POST["eliteat"]) && round($_POST["eliteat"])>0)
  {
    if(($elite_at+$elite_df+round($_POST["eliteat"])+round($_POST["elitedf"]))<=($attack+$elite_at+$elite_df+round($_POST["eliteat"])+round($_POST["elitedf"]))*$elite_level/10)
    {
      if(round($_POST["eliteat"])<=$attack)
      {
        if(round($_POST["eliteat"])*$train_cost_per_unit*1.5>$gold)
        {
          semafor_off($_COOKIE["uid"]);
          return -1; // Error! Not enoght money for this training!
        }
        else
        {
          $gold=$gold-round($_POST["eliteat"])*$train_cost_per_unit*1.5;
          $attack=$attack-round($_POST["eliteat"]);
          $query="update armory set elite_at=".($elite_at+round($_POST["eliteat"])).", attack=".$attack.", gold=".$gold." where id=".$id;
          $db_theend->query($query);
        }
      }
      else
      {
        semafor_off($_COOKIE["uid"]);
        return -2; // Error! Not enoght combat units to be trained!
      }
    }
    else
    {
      semafor_off($_COOKIE["uid"]);
      return -3; // Error! Elite level error!
    }
  }

  if(round($_POST["elitedf"]) && round($_POST["elitedf"])>0)
  {
    if(($elite_at+$elite_df+round($_POST["elitedf"])+round($_POST["eliteat"]))<=($attack+$elite_at+$elite_df+round($_POST["eliteat"])+round($_POST["elitedf"]))*$elite_level/10)
    {
      if(round($_POST["elitedf"])<=$attack)
      {
        if(round($_POST["elitedf"])*$train_cost_per_unit*1.5>$gold)
        {
          semafor_off($_COOKIE["uid"]);
          return -1; // Error! Not enoght money for this training!
        }
        else
        {
          $gold=$gold-round($_POST["elitedf"])*$train_cost_per_unit*1.5;
          $attack=$attack-round($_POST["elitedf"]);
          $query="update armory set elite_df=".($elite_df+round($_POST["elitedf"])).", attack=".$attack.", gold=".$gold." where id=".$id;
          $db_theend->query($query);
        }
      }
      else
      {
        semafor_off($_COOKIE["uid"]);
        return -4; // Error! Not enoght combat units to be trained!
      }
    }
    else
    {
      semafor_off($_COOKIE["uid"]);
      return -3; // Error! Elite level error!
    }
  }

  if(round($_POST["spy"]) && round($_POST["spy"])>0)
  {
    if(round($_POST["spy"])<=$untrained)
    {
      if(round($_POST["spy"])*$train_cost_per_unit*2>$gold)
      {
        semafor_off($_COOKIE["uid"]);
        return -1; // Error! Not enoght money for this training!
      }
      else
      {
        $gold=$gold-round($_POST["spy"])*$train_cost_per_unit*2;
        $untrained=$untrained-round($_POST["spy"]);
        $query="update armory set spy=".($spy+round($_POST["spy"])).", untrained=".$untrained.", gold=".$gold." where id=".$id;
        $db_theend->query($query);
      }
    }
    else
    {
      semafor_off($_COOKIE["uid"]);
      return -2; // Error! Not enoght untrained units to be trained!
    }
  }

  if(round($_POST["antispy"]) && round($_POST["antispy"])>0)
  {
    if(round($_POST["antispy"])<=$untrained)
    {
      if(round($_POST["antispy"])*$train_cost_per_unit*2>$gold)
      {
        semafor_off($_COOKIE["uid"]);
        return -1; // Error! Not enoght money for this training!
      }
      else
      {
        $gold=$gold-round($_POST["antispy"])*$train_cost_per_unit*2;
        $untrained=$untrained-round($_POST["antispy"]);
        $query="update armory set antispy=".($antispy+round($_POST["antispy"])).", untrained=".$untrained.", gold=".$gold." where id=".$id;
        $db_theend->query($query);
      }
    }
    else
    {
      semafor_off($_COOKIE["uid"]);
      return -2; // Error! Not enoght untrained units to be trained!
    }
  }

  if(round($_POST["workers"]) && round($_POST["workers"])>0)
  {
    if(round($_POST["workers"])<=$untrained)
    {
      if(round($_POST["workers"])*$train_cost_per_unit/5>$gold)
      {
        semafor_off($_COOKIE["uid"]);
        return -1; // Error! Not enoght money for this training!
      }
      else
      {
        $gold=$gold-round($_POST["workers"])*$train_cost_per_unit/5;
        $untrained=$untrained-round($_POST["workers"]);
        $query="update armory set workers=".($workers+round($_POST["workers"])).", untrained=".$untrained.", gold=".$gold." where id=".$id;
        $db_theend->query($query);
      }
    }
    else
    {
      semafor_off($_COOKIE["uid"]);
      return -2; // Error! Not enoght untrained units to be trained!
    }
  }
  semafor_off($_COOKIE["uid"]);
  return 1;
}

function buy_units()
{
  semafor_on($_COOKIE["uid"]);

  if(round($_POST["units"])>0)
  {
    $db_theend = new DataBase_theend;
    $db_theend->connect();

    $myrace=userrace($_COOKIE["uid"]);

    $query="select armory.gold, armory.level, armory.exp, armory.id, armory.gold, armory.units, armory.untrained, upgrades.population from armory, upgrades where armory.id=".$_COOKIE["uid"]." and armory.id=upgrades.id";
    $db_theend->query($query);
    $db_theend->next_record();
    $id=$db_theend->Record["id"];
    $gold=$db_theend->Record["gold"];
    $units=$db_theend->Record["units"];
    $untrained=$db_theend->Record["untrained"];

    $unit_cost=300;


    if($units>=round((pow(2,$db_theend->Record["level"])*1000+$db_theend->Record["exp"])*(1+$db_theend->Record["population"]*10/100)))
    {
      semafor_off($_COOKIE["uid"]);
      return -1; // No more units available for this level!
    }
    else
    {
      if(round($_POST["units"])+$units>round((pow(2,$db_theend->Record["level"])*1000+$db_theend->Record["exp"])*(1+$db_theend->Record["population"]*10/100)))
        $buy=round((pow(2,$db_theend->Record["level"])*1000+$db_theend->Record["exp"])*(1+$db_theend->Record["population"]*10/100))-$units;
      else $buy=round($_POST["units"]);
        if(round($_POST["units"])*$unit_cost>$gold)
        {
          semafor_off($_COOKIE["uid"]);
          return -2; // Not enough gold!
        }
        else
        {
          $query="update armory set gold=".($gold-$buy*$unit_cost).", units=".($units+$buy).", untrained=".($untrained+$buy)." where id=".$id;
          $db_theend->query($query);
        }
    }
  }
  semafor_off($_COOKIE["uid"]);
  return 1;
}

function disband()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  semafor_on($_COOKIE["uid"]);

  if(round($_POST["atunits"])>0)
  {
     $query="select armory.attack, armory.untrained, armory.id from armory where armory.id=".$_COOKIE["uid"];
     $db_theend->query($query);
     $db_theend->next_record();
     $id=$db_theend->Record["id"];
     if(round($_POST["atunits"])<=$db_theend->Record["attack"])
     {
        $query="update armory set attack=".($db_theend->Record["attack"]-round($_POST["atunits"])).", untrained=".($db_theend->Record["untrained"]+round($_POST["atunits"]))." where id=".$id;
        $db_theend->query($query);
     }
  }

  if(round($_POST["dfunits"])>0)
  {
     $query="select armory.defense, armory.untrained, armory.id from armory where armory.id=".$_COOKIE["uid"];
     $db_theend->query($query);
     $db_theend->next_record();
     $id=$db_theend->Record["id"];
     if(round($_POST["dfunits"])<=$db_theend->Record["defense"])
     {
        $query="update armory set defense=".($db_theend->Record["defense"]-round($_POST["dfunits"])).", untrained=".($db_theend->Record["untrained"]+round($_POST["dfunits"]))." where id=".$id;
        $db_theend->query($query);
     }
  }

  if(round($_POST["spy"])>0)
  {
     $query="select spy, untrained, id from armory where id=".$_COOKIE["uid"];
     $db_theend->query($query);
     $db_theend->next_record();
     $id=$db_theend->Record["id"];
     if(round($_POST["spy"])<=$db_theend->Record["spy"])
     {
        $query="update armory set spy=".($db_theend->Record["spy"]-round($_POST["spy"])).", untrained=".($db_theend->Record["untrained"]+round($_POST["spy"]))." where id=".$id;
        $db_theend->query($query);
     }
  }

  if(round($_POST["antispy"])>0)
  {
     $query="select antispy, untrained, id from armory where id=".$_COOKIE["uid"];
     $db_theend->query($query);
     $db_theend->next_record();
     $id=$db_theend->Record["id"];
     if(round($_POST["antispy"])<=$db_theend->Record["antispy"])
     {
        $query="update armory set antispy=".($db_theend->Record["antispy"]-round($_POST["antispy"])).", untrained=".($db_theend->Record["untrained"]+round($_POST["antispy"]))." where id=".$id;
        $db_theend->query($query);
     }
  }

  if(round($_POST["workers"])>0)
  {
     $query="select workers, untrained, id from armory where id=".$_COOKIE["uid"];
     $db_theend->query($query);
     $db_theend->next_record();
     $id=$db_theend->Record["id"];
     if(round($_POST["workers"])<=$db_theend->Record["workers"])
     {
        $query="update armory set workers=".($db_theend->Record["workers"]-round($_POST["workers"])).", untrained=".($db_theend->Record["untrained"]+round($_POST["workers"]))." where id=".$id;
        $db_theend->query($query);
     }
  }

  semafor_off($_COOKIE["uid"]);
}
?>
