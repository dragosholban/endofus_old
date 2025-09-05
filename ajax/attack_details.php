<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

include '../database.php';
include '../functions.php';
 
$db = new DataBase_theend;
$db->connect();

$site_language=site_language();

echo "<div class=\"section\">";
echo "<div class=\"section_black\">";
echo "<div class=\"section_grey\">";

if($_COOKIE["uid"] && $_GET["at"])
{
  $query="select at_id, df_id, date, win_id, units_killed, units_captured, exp, gold, atp, dfp, at_units, df_units, exp_lost, turns, at_prec, df_prec from attack_log where id=".$_GET["at"];
  $db->query($query);
  $db->next_record();
  
  if($_COOKIE["uid"]==$db->Record["at_id"] || $_COOKIE["uid"]==$db->Record["df_id"])
  {
  
  $attacker_name=username($db->Record["at_id"]);
  $attacker_race=userrace($db->Record["at_id"]);
  $defender_name=username($db->Record["df_id"]);
  $defender_race=userrace($db->Record["df_id"]);
  $winner_name=username($db->Record["win_id"]);
  $winner_race=userrace($db->Record["win_id"]);

  echo "<font color=\"#A0A0A0\">";
  if($site_language=="en")
    echo "[battle report - ".$db->Record["date"]."]";
  else
    echo "[raport lupta - ".$db->Record["date"]."]";
  echo "</font>";

  echo "<br /><br />";
  echo "<div>";
  echo "<a class=\"".$attacker_race."\" href=\"user_profile.php?uid=".$db->Record["at_id"]."\">".$attacker_name."</a> ";
  if($site_language=="en")
    echo "<font color=\"#A0A0A0\">attacked</font> ";
  else 
    echo "<font color=\"#A0A0A0\">a atacat pe</font> ";  
  echo "<a class=\"".$defender_race."\" href=\"user_profile.php?uid=".$db->Record["df_id"]."\">".$defender_name."</a> ";
  if($site_language=="en")
    echo "<font color=\"#A0A0A0\">at</font> ";
  else 
    echo "<font color=\"#A0A0A0\">la</font> ";  
  echo $db->Record["date"];
  if($site_language=="en")
    echo " <font color=\"#A0A0A0\">using</font> ";
  else 
    echo " <font color=\"#A0A0A0\">folosind</font> ";  
  echo "<font color=\"#F0F0F0\">".$db->Record["turns"]." AP</font>.";

  echo "<br />";
  
  if($db->Record["win_id"])
  {
    if($site_language=="en")
      echo " <a class=\"".$winner_race."\" href=\"user_profile.php?uid=".$db->Record["win_id"]."\">".$winner_name."</a> won the battle.";
    else
      echo " <a class=\"".$winner_race."\" href=\"user_profile.php?uid=".$db->Record["win_id"]."\">".$winner_name."</a> a castigat lupta.";
  }
  else
  {
    if($site_language=="en")
      echo "<br>The two armies were equal in force and have resolved the conflict in diplomatic ways. Nobody won, nobody lost.";
    else
      echo "<br>Cele doua armate au fost egale in putere si conflictul s-a rezolvat pe cai diplomatice. Nimeni nu a pierdut.";
  }
  echo "</div>";
  echo "<br />";
  
  echo "<table><tr><td>";
  echo "<img width=\"40\" class=\"avatar\" src=\"".useravatar2($db->Record["at_id"],$attacker_race)."\"></img>";
  echo "</td><td>";
  echo "<a class=\"".$attacker_race."\" href=\"user_profile.php?uid=".$db->Record["at_id"]."\" style=\"font-size: 12px; font-weight: bold;\">".$attacker_name."</a>";
  echo "<br />";
  echo "<font color=\"#A0A0A0\">";
  if($site_language=="en")
    echo "The army, formed by ".number_format($db->Record["at_units"])." units, had an attack power of ".number_format($db->Record["atp"]).".";
  else 
    echo "Armata, formata din ".number_format($db->Record["at_units"])." unitati, a avut o putere de atac de ".number_format($db->Record["atp"]).".";    
  echo "<br />";
  if($_COOKIE["uid"]==$db->Record["at_id"] && $db->Record["at_prec"])
  {
  	if($site_language=="en")
  	  echo "The weapons' precision was ".$db->Record["at_prec"]."%. ";
  	else 
  	  echo "Precizia armelor a fost de ".$db->Record["at_prec"]."%. ";  
  }
  
  if($db->Record["win_id"]==$db->Record["at_id"])
  {  
  if($db->Record["exp"]>=0)
    if($site_language=="en")
      echo " Experience gained: ".number_format($db->Record["exp"]).".";
    else 
      echo " Experienta castigata: ".number_format($db->Record["exp"]).".";  
  else   
    if($site_language=="en")
      echo " Experience lost: ".number_format(abs($db->Record["exp"])).".";
    else   
      echo " Experienta pierduta: ".number_format(abs($db->Record["exp"])).".";
  }
  if($db->Record["win_id"]==$db->Record["df_id"])
  {  
  if($db->Record["exp_lost"]>=0)
    if($site_language=="en")
      echo " Experience lost: ".number_format($db->Record["exp_lost"]).".";
    else 
      echo " Experienta pierduta: ".number_format($db->Record["exp_lost"]).".";  
  else   
    if($site_language=="en")
      echo " Experience gained: ".number_format($db->Record["exp_lost"]).".";
    else 
      echo " Experienta castigata: ".number_format($db->Record["exp_lost"]).".";  
  }
  if($db->Record["win_id"]==$db->Record["at_id"])
  {  
    if($db->Record["gold"]>0)
      if($site_language=="en")
        echo " EKR captured: ".number_format($db->Record["gold"]).".";
      else 
        echo " EKR capturat: ".number_format($db->Record["gold"]).".";  
  }  
  if($db->Record["win_id"]==$db->Record["df_id"])
  {  
    if($db->Record["units_killed"]>0)
      if($site_language=="en")
        echo " Units lost: ".number_format($db->Record["units_killed"]).".";
      else 
        echo " Unitati pierdute: ".number_format($db->Record["units_killed"]).".";  
  } 
  if($db->Record["win_id"]==$db->Record["at_id"])
  {  
    if($db->Record["units_killed"]>0)
      if($site_language=="en")
        echo " Units killed: ".number_format($db->Record["units_killed"]).".";
      else 
        echo " Unitati omorate: ".number_format($db->Record["units_killed"]).".";  
    if($db->Record["units_captured"]>0)
      if($site_language=="en")
        echo " Units captured: ".number_format($db->Record["units_captured"]).".";      
      else 
        echo " Unitati capturate: ".number_format($db->Record["units_captured"]).".";  
  }
  echo "</font>"; 
  echo "</td></tr></table>";
  
  echo "<br />";
  
  echo "<table><tr><td>";
  echo "<img width=\"40\" class=\"avatar\" src=\"".useravatar2($db->Record["df_id"],$defender_race)."\"></img>";
  echo "</td><td>";  

  echo "<a class=\"".$defender_race."\" href=\"user_profile.php?uid=".$db->Record["df_id"]."\" style=\"font-size: 12px; font-weight: bold;\">".$defender_name."</a>";
  echo "<br />";
  echo "<font color=\"#A0A0A0\">";
  if($site_language=="en")
    echo "The army, formed by ".number_format($db->Record["df_units"])." units, had ".number_format($db->Record["dfp"])." defense power.";  
  else 
    echo "Armata, formata din ".number_format($db->Record["df_units"])." unitati, a avut ".number_format($db->Record["dfp"])." putere de aparare.";    
  echo "<br />";
  if($_COOKIE["uid"]==$db->Record["df_id"] && $db->Record["df_prec"])
  {
  	if($site_language=="en")
  	  echo " Weapons' precision was ".$db->Record["df_prec"]."%.";
  	else 
  	  echo " Precizia armelor a fost de ".$db->Record["df_prec"]."%.";  
  }
  if($db->Record["win_id"]==$db->Record["df_id"])
  {  
  if($db->Record["exp"]>=0)
    if($site_language=="en")
      echo " Experience gained: ".number_format($db->Record["exp"]).".";
    else 
      echo " Experienta castigata: ".number_format($db->Record["exp"]).".";  
  else   
    if($site_language=="en")  
      echo " Experience lost: ".number_format($db->Record["exp"]).".";
    else 
      echo " Experienta pierduta: ".number_format($db->Record["exp"]).".";  
  }  
  if($db->Record["win_id"]==$db->Record["at_id"])
  {  
  if($db->Record["exp_lost"]>=0)
    if($site_language=="en")
      echo " Experience lost: ".number_format($db->Record["exp_lost"]).".";
    else 
      echo " Experienta pierduta: ".number_format($db->Record["exp_lost"]).".";  
  else   
    if($site_language=="en")
      echo " Experience gained: ".number_format($db->Record["exp_lost"]).".";
    else 
      echo " Experienta castigata: ".number_format($db->Record["exp_lost"]).".";  
  }  
  if($db->Record["win_id"]==$db->Record["at_id"])
  {  
    if(($db->Record["units_killed"]+$db->Record["units_captured"])>0)
      if($site_language=="en")
        echo " Units lost: ".number_format(($db->Record["units_killed"]+$db->Record["units_captured"])).".";
      else 
        echo " Unitati pierdute: ".number_format(($db->Record["units_killed"]+$db->Record["units_captured"])).".";  
  }  
  if($db->Record["win_id"]==$db->Record["df_id"])
  {  
    if($db->Record["units_killed"]>0)
      if($site_language=="en")
        echo " Units killed: ".number_format($db->Record["units_killed"]).".";
      else 
        echo " Unitati omorate: ".number_format($db->Record["units_killed"]).".";  
    if($db->Record["units_captured"]>0)
      if($site_language=="en")  
        echo " Units captured: ".number_format($db->Record["units_captured"]).".";      
      else  
        echo " Unitati capturate: ".number_format($db->Record["units_captured"]).".";      
  }  
  echo "</font>";
  echo "</td></tr></table>";  
  }

}  

echo "</div>";
echo "</div>";
echo "</div>";
?>
