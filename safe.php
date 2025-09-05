<?php

function safe()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  
  $site_language=site_language();

  if($_POST["upgrade"]==100000000)
  {
    semafor_on($_COOKIE["uid"]);

    $query="select id, gold from armory where id=".$_COOKIE["uid"];
    $db_theend->query($query);
    $db_theend->next_record();
    $myid=$db_theend->Record["id"];
    if($db_theend->Record["gold"]>=10000000)
    {
      $query="update armory set gold=gold-10000000 where id=".$myid;
      $db_theend->query($query);
      $query="update seif set max_gold=100000000 where uid=".$myid;
      $db_theend->query($query);
    }

    semafor_off($_COOKIE["uid"]);
  }

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "SAFE";
  else 
    echo "SEIF";  
  echo "</div>";
  
  echo "<br />";

  $query="select seif.gold as seif_gold, seif.max_gold as seif_max, seif.date as date, armory.gold as armory_gold from seif, armory where armory.id=".$_COOKIE["uid"]." and armory.id=seif.uid";
  $db_theend->query($query);
  $db_theend->next_record();
  
  echo "<div class=\"section\">";
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  echo "<tr>";
  echo "<td class=\"safe1\">";
  if($site_language=="en")
    echo "In safe:";
  else
    echo "In seif:";  
  echo "</td>";
  echo "<td class=\"safe2\">";
  echo "<span id=\"inSafeGold\">".number_format($db_theend->Record["seif_gold"])."</span> EKR";
  echo "</td>";
  echo "<td class=\"safe3\">";
  if($site_language=="en")
    echo "Last deposit was made on:";
  else 
    echo "Ultima depunere a fost facuta in:";  
  echo "</td>";
  echo "<td class=\"safe4\">";
  echo $db_theend->Record["date"];
  echo "</td>";  
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"safe1\">";
  if($site_language=="en")
    echo "Out of safe:";
  else
    echo "In afara seifului:"; 
  echo "</td>";
  echo "<td class=\"safe2\">";
  echo "<span id=\"outOfSafeGold\">".number_format($db_theend->Record["armory_gold"])."</span> EKR";
  echo "</td>";
  echo "<td class=\"safe3\">";
  if($site_language=="en")
    echo "Next deposit is possible on:";
  else 
    echo "Urmatoarea depunere este posibila in:";  
  echo "</td>";
  echo "<td class=\"safe4\">";
  if($db_theend->Record["date"]<date("Y-m-d H:i:s", mktime(0, 0, 0, date(m), date(d), date(Y))))
  {
    echo date('Y-m-d')." ";
    if($site_language=="en")
      echo "(today)";
    else
      echo "(astazi)";
  }
  else
  {
    echo date("Y-m-d", mktime(0, 0, 0, date(m), date(d)+1, date(Y)))." ";
    if($site_language=="en")
      echo "(tomorrow)";
    else
      echo "(maine)";
  }  
  echo "</td>";  
  echo "</tr>";  
  echo "<tr>";
  echo "<td class=\"safe1\">";
  echo "<font color=\"#FFD700\">";
  echo "Total:"; 
  echo "</font>";
  echo "</td>";
  echo "<td class=\"safe2\">";
  echo "<font color=\"#FFD700\">";
  echo "<span id=\"totalGold\">".number_format($db_theend->Record["armory_gold"]+$db_theend->Record["seif_gold"])."</span> EKR";
  echo "</font>";
  echo "</td>";
  echo "<td class=\"safe3_empty\">&nbsp;";
  echo "</td>";
  echo "<td class=\"safe4_empty\">&nbsp;";
  echo "</td>";  
  echo "</tr>";   
  echo "<tr>";
  echo "<td class=\"safe1\">";
  echo "<font color=\"#A0A0A0\">";
  if($site_language=="en")
    echo "Safe capacity:";
  else
    echo "Capacitatea seifului:"; 
  echo "</font>";  
  echo "</td>";
  echo "<td class=\"safe2\">";
  echo "<font color=\"#A0A0A0\">";
  echo number_format($db_theend->Record["seif_max"])." EKR";
  echo "</font>";
  echo "</td>";
  echo "<td class=\"safe3_empty\">&nbsp;";
  echo "</td>";
  echo "<td class=\"safe4_empty\">&nbsp;";
  echo "</td>";  
  echo "</tr>";  
  echo "<tr>";
  echo "<td class=\"safe5\">";
  echo "<div style=\"float: right;\"><input class=\"input4\" type=\"text\" id=\"inputDepositAmount\" /></div>";
  if($site_language=="en")
    echo "Deposit:";
  else 
    echo "Depune:";
  echo "</td>";
  echo "<td class=\"safe6\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"button\" value=\"Deposit\" onClick=\"depositSafe();\"></input>";
  else
    echo "<input class=\"submit4\" type=\"button\" value=\"Depune\" onClick=\"depositSafe();\"></input>";  
  echo "</td>";
  echo "<td class=\"safe7\">";
  echo "<div style=\"float: right;\"><input class=\"input4\" type=\"text\" id=\"inputRetractAmount\" /></div>";
  if($site_language=="en")
    echo "Retract:";
  else 
    echo "Retrage:";  
  echo "</td>";
  echo "<td class=\"safe8\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"button\" value=\"Retract\" onClick=\"retractSafe();\"></input>";
  else
    echo "<input class=\"submit4\" type=\"button\" value=\"Retrage\" onClick=\"retractSafe();\"></input>";  
  echo "</td>";  
  echo "</tr>";  
  echo "</table>";
  echo "</div>";
  
  if($db_theend->Record["seif_max"]==10000000)
  {
  
  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"upgrade_level\">";
  if($site_language=="en")
    echo "Safe current capacity: ".number_format($db_theend->Record["seif_max"])." EKR";
  else 
    echo "Capacitatea curenta a seifului: ".number_format($db_theend->Record["seif_max"])." EKR";  
  echo "</div>";
  
  echo "<div class=\"upgrades\">";
  
  echo "<font color=\"#FFA500\" style=\"font-size: 10px;\"><b>";
  if($site_language=="en")
    echo "Safe Upgrade";
  else 
    echo "Upgrade seif";  
  echo "</font></b>";
  
  echo "<br /><br />";
  
  if($site_language=="en")
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">This upgrade will increase your safe capacity to a total amount of 100,000,000 EKR.</font>";
  else
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Acest upgrade va mari capacitatea seifului la 100,000,000 EKR.</font>";
   
  echo "<br /><br />";

  echo "<div style=\"float: right; margin-right: 10px;\">";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"safe\"></input>";
  echo "<input type=\"hidden\" name=\"upgrade\" value=\"100000000\"></input>";
  echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
  echo "</form>";
  echo "</div>";   
  
  if($site_language=="en")
    echo "Upgrade cost: 10,000,000 EKR";
  else 
    echo "Cost upgrade: 10,000,000 EKR";  
  echo "<br /><br />";
  echo "</div>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
  }
}

?>
