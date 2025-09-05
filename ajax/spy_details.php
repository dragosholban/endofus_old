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

if($_COOKIE["uid"] && $_GET["sp"])
{
  $query="select spy_log.id, spy_log.datetime, users.username, users.race, spy_log.mission, spy_log.at_id, spy_log.df_id, spy_log.win_id, spy_log.spies, spy_log.killed_spies, spy_log.eeatu, spy_log.eatu, spy_log.euntu, spy_log.eatl, spy_log.eatp, spy_log.etatp, spy_log.eedfu, spy_log.edfu, spy_log.edfl, spy_log.edfp, spy_log.etdfp, spy_log.espu, spy_log.eseu, spy_log.ewou, spy_log.etou, spy_log.dmgp from spy_log, users where spy_log.id=".$_GET["sp"]." and df_id=users.id";
  $db->query($query);
  $db->next_record();
  
  if($_COOKIE["uid"]==$db->Record["at_id"] || $_COOKIE["uid"]==$db->Record["df_id"])
  {
    echo "<font style=\"color: #C0C0C0; font-size: 12px;\">";
  	if($site_language=="en")
      echo "<b>Spy mission on <a style=\"font-size: 12px;\" class=\"".$db->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["df_id"]."\"><b>".$db->Record["username"]."</b></a></b><br>";
    else 
      echo "<b>Misiune de spionaj asupra lui <a style=\"font-size: 12px;\" class=\"".$db->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["df_id"]."\"><b>".$db->Record["username"]."</b></a></b><br>";
    echo "</font>";
  if($site_language=="en")  
    echo "<font color=\"#909090\">Mission date: ".$db->Record["datetime"]."</font><br>";
  else 
    echo "<font color=\"#909090\">Data misiunii: ".$db->Record["datetime"]."</font><br>";  
    if($site_language=="en")
      echo "<font color=\"#909090\">Objective: </font>";
    else 
      echo "<font color=\"#909090\">Obiectiv: </font>";  
  if($db->Record["mission"]==1)
    if($site_language=="en")
      echo "<font color=\"#F0F0F0\">find informations regarding enemy's attack capabilites</font>";
    else 
      echo "<font color=\"#F0F0F0\">afla informatii despre capacitatile de atac ale inamicului</font>";  
  if($db->Record["mission"]==2)
    if($site_language=="en")
      echo "<font color=\"#F0F0F0\">find informations regarding enemy's defense capabilites</font>";
    else 
      echo "<font color=\"#F0F0F0\">afla informatii despre capacitatile de aparare ale inamicului</font>";  
  if($db->Record["mission"]==3)
    if($site_language=="en")
      echo "<font color=\"#F0F0F0\">find informations regarding enemy's units</font>";
    else 
      echo "<font color=\"#F0F0F0\">afla informatii referitoare la unitatile inamicului</font>";  
  if($db->Record["mission"]==4)
    if($site_language=="en")
      echo "<font color=\"#F0F0F0\">sabotage enemy's attack weapons</font>";
    else 
      echo "<font color=\"#F0F0F0\">saboteaza armele de atac ale inamicului</font>";  
  if($db->Record["mission"]==5)
    if($site_language=="en")
      echo "<font color=\"#F0F0F0\">sabotage enemy's defense weapons</font>";
    else 
      echo "<font color=\"#F0F0F0\">saboteaza armele de aparare ale inamicului</font>";  
  echo "<br>";
  if($site_language=="en")
    echo "<font color=\"#909090\">Mission result: </font>";
  else 
    echo "<font color=\"#909090\">Rezultat misiune: </font>";  
  if($db->Record["win_id"]==$db->Record["at_id"])
    if($site_language=="en")
      echo "<font color=\"#F0F0F0\">success</font>";
    else 
      echo "<font color=\"#F0F0F0\">succes</font>";  
  else
    if($site_language=="en")
      echo "<font color=\"#F0F0F0\">failed</font>";
    else 
      echo "<font color=\"#F0F0F0\">esec</font>";  
  echo "<br>";
  if($site_language=="en")
    echo "<font color=\"#909090\">Spies sent in mission: </font>".$db->Record["spies"]."<br>";
  else 
    echo "<font color=\"#909090\">Spioni trimisi in misiune: </font>".$db->Record["spies"]."<br>";  
  if($site_language=="en")  
    echo "<font color=\"#909090\">Spies returned: </font>".($db->Record["spies"]-$db->Record["killed_spies"])."<br>";
  else 
    echo "<font color=\"#909090\">Spioni intorsi: </font>".($db->Record["spies"]-$db->Record["killed_spies"])."<br>";
  if($db->Record["win_id"]==$db->Record["at_id"])
  {
    echo "<br />";
    if($site_language=="en")
  	  echo "Information retreived: <br>";
  	else 
  	  echo "Informatii primite: <br>";  
    if($db->Record["mission"]==1)
    {
      if($site_language=="en")
      {
        echo "<font color=\"#909090\">Elite attack units: ".number_format($db->Record["eeatu"])."</font><br>";
        echo "<font color=\"#909090\">Combat units: ".number_format($db->Record["eatu"])."</font><br>";
        echo "<font color=\"#909090\">Untrained units: ".number_format($db->Record["euntu"])."</font><br>";
        echo "<font color=\"#909090\">Attack level: ".number_format($db->Record["eatl"])."</font><br>";
        echo "<font color=\"#909090\">Attack power: ".number_format($db->Record["eatp"])."</font><br>";
        echo "<font color=\"#909090\">Total attack power: ".number_format($db->Record["etatp"])."</font><br>";      	
      }
      else 
      {
        echo "<font color=\"#909090\">Unitati de atac de elita: ".number_format($db->Record["eeatu"])."</font><br>";
        echo "<font color=\"#909090\">Unitati de lupta: ".number_format($db->Record["eatu"])."</font><br>";
        echo "<font color=\"#909090\">Unitati neantrenate: ".number_format($db->Record["euntu"])."</font><br>";
        echo "<font color=\"#909090\">Nivel de atac: ".number_format($db->Record["eatl"])."</font><br>";
        echo "<font color=\"#909090\">Putere de atac: ".number_format($db->Record["eatp"])."</font><br>";
        echo "<font color=\"#909090\">Putere de atac totala: ".number_format($db->Record["etatp"])."</font><br>";       	
      }
    }
    if($db->Record["mission"]==2)
    {
      if($site_language=="en")
      {
        echo "<font color=\"#909090\">Elite defense units: ".number_format($db->Record["eedfu"])."</font><br>";
        echo "<font color=\"#909090\">Combat units: ".number_format($db->Record["edfu"])."</font><br>";
        echo "<font color=\"#909090\">Untrained units: ".number_format($db->Record["euntu"])."</font><br>";
        echo "<font color=\"#909090\">Defense level: ".number_format($db->Record["edfl"])."</font><br>";
        echo "<font color=\"#909090\">Defense power: ".number_format($db->Record["edfp"])."</font><br>";
        echo "<font color=\"#909090\">Total defense power: ".number_format($db->Record["etdfp"])."</font><br>";      	
      }
      else 
      {
        echo "<font color=\"#909090\">Unitati de aparare de elita: ".number_format($db->Record["eedfu"])."</font><br>";
        echo "<font color=\"#909090\">Unitati de lupta: ".number_format($db->Record["edfu"])."</font><br>";
        echo "<font color=\"#909090\">Unitati neantrenate: ".number_format($db->Record["euntu"])."</font><br>";
        echo "<font color=\"#909090\">Nivel de aparare: ".number_format($db->Record["edfl"])."</font><br>";
        echo "<font color=\"#909090\">Putere de aparare: ".number_format($db->Record["edfp"])."</font><br>";
        echo "<font color=\"#909090\">Putere de aparare totala: ".number_format($db->Record["etdfp"])."</font><br>";       	
      }
    }
    if($db->Record["mission"]==3)
    {
      if($site_language=="en")
      {	
        echo "<font color=\"#909090\">Elite attack units: ".number_format($db->Record["eeatu"])."</font><br>";
        echo "<font color=\"#909090\">Elite defense units: ".number_format($db->Record["eedfu"])."</font><br>";
        echo "<font color=\"#909090\">Combat units: ".number_format($db->Record["eatu"])."</font><br>";
        echo "<font color=\"#909090\">Spies: ".number_format($db->Record["espu"])."</font><br>";
        echo "<font color=\"#909090\">Sentries: ".number_format($db->Record["eseu"])."</font><br>";
        echo "<font color=\"#909090\">Untrained units: ".number_format($db->Record["euntu"])."</font><br>";
        echo "<font color=\"#909090\">Workers/slaves: ".number_format($db->Record["ewou"])."</font><br>";
        echo "<font color=\"#909090\">Total units: ".number_format($db->Record["etou"])."</font><br>";
      }
      else 
      {
        echo "<font color=\"#909090\">Unitati de atac de elita: ".number_format($db->Record["eeatu"])."</font><br>";
        echo "<font color=\"#909090\">Unitati de aparare de elita: ".number_format($db->Record["eedfu"])."</font><br>";
        echo "<font color=\"#909090\">Unitati de lupta: ".number_format($db->Record["eatu"])."</font><br>";
        echo "<font color=\"#909090\">Spioni: ".number_format($db->Record["espu"])."</font><br>";
        echo "<font color=\"#909090\">Contra-spioni: ".number_format($db->Record["eseu"])."</font><br>";
        echo "<font color=\"#909090\">Unitati neantrenate: ".number_format($db->Record["euntu"])."</font><br>";
        echo "<font color=\"#909090\">Muncitori/sclavi: ".number_format($db->Record["ewou"])."</font><br>";
        echo "<font color=\"#909090\">Total unitati: ".number_format($db->Record["etou"])."</font><br>";      	
      }
    }
    if($db->Record["mission"]==4)
    {
      if($site_language=="en")
      {
    	echo "<font color=\"#909090\">Enemy's attack weapons were damaged by ".number_format($db->Record["dmgp"])." points.</font><br>";
      }
      else 
      {
    	echo "<font color=\"#909090\">Puterea armelor de atac ale inamicului a fost redusa cu ".number_format($db->Record["dmgp"])." puncte.</font><br>";
      }      	
    }
    if($db->Record["mission"]==5)
    {
      if($site_language=="en")
      {
    	echo "<font color=\"#909090\">Enemy's defense weapons were damaged by ".number_format($db->Record["dmgp"])." points.</font><br>";
      }
      else 
      {
      	echo "<font color=\"#909090\">Puterea armelor de aparare ale inamicului a fost redusa cu ".number_format($db->Record["dmgp"])." puncte.</font><br>";
      }
    }    
  }
  }
}  

echo "</div>";
echo "</div>";
echo "</div>";
?>
