<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

include '../database.php';
include '../functions.php';

$site_language=site_language();
 
$db = new DataBase_theend;
$db->connect();

if($_COOKIE["uid"] && $_GET["al_id"])
{
  if($_GET["log"]=="deposit")
  {
	echo "<br/>";
	if($site_language=="en")
  	  echo "<div class=\"titlebar3\">DEPOSIT LOGS</div>";
  	else 
  	  echo "<div class=\"titlebar3\">ISTORIC DEPUNERI</div>";  
  	echo "<br/>";
	
	  $query="select al_finance_log.datetime, al_finance_log.op, users.username, al_finance_log.gold from al_finance_log, users where al_finance_log.id_al=".$_GET["al_id"]." and (al_finance_log.op=1 or al_finance_log.op=2 or al_finance_log.op=3) and al_finance_log.user=users.id order by datetime desc";
      $db->query($query);

      echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

      while($db->next_record())
      {
        echo "<tr><td class=\"alsl1\">".$db->Record["datetime"]."</td>";
        echo "<td class=\"alsl2\">".$db->Record["username"]."</td>";
        if($db->Record["op"]==1)
        {
          if($site_language=="en")
          {
        	echo "<td class=\"alsl3\">safe deposit</td>";
          }
          else 
          {
          	echo "<td class=\"alsl3\">depunere in seif</td>";
          }
        }
        if($db->Record["op"]==2)
        {
          if($site_language=="en")
          {
        	echo "<td class=\"alsl3\">join tax paid</td>";
          }
          else 
          {
          	echo "<td class=\"alsl3\">plata taxa intrare</td>";
          }
        }
        if($db->Record["op"]==3)
        {
          if($site_language=="en")
          {
        	echo "<td class=\"alsl3\">tax returned</td>";
          }
          else 
          {
          	echo "<td class=\"alsl3\">returnare taxa</td>";
          }
        }
        echo "<td class=\"alsl4\">";
        if($db->Record["op"]==1)
        {
          echo "+";
        }
        if($db->Record["op"]==2)
        {
          echo "+";
        }
        if($db->Record["op"]==3)
        {
          echo "-";
        }
        echo number_format($db->Record["gold"])." EKR</td></tr>";
      }

      echo "</table>";
  }   
  if($_GET["log"]=="transfer")
  {
      echo "<br/>";
      if($site_language=="en")
  	    echo "<div class=\"titlebar3\">TRANSFER LOGS</div>";
  	  else 
  	    echo "<div class=\"titlebar3\">ISTORIC TRANSFERURI</div>";  
  	  echo "<br/>";

      $query="select al_finance_log.datetime, a.username as user1, b.username as user2, al_finance_log.gold from al_finance_log, users a, users b where al_finance_log.id_al=".$_GET["al_id"]." and al_finance_log.op=6 and al_finance_log.user=a.id and al_finance_log.user2=b.id order by datetime desc";
      $db->query($query);

      echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

      while($db->next_record())
      {
        echo "<tr>";
        echo "<td class=\"alsl1\">".$db->Record["datetime"]."</td>";
        echo "<td class=\"alsl2\">".$db->Record["user1"]."</td>";
        echo "<td class=\"alsl3\">".$db->Record["user2"]."</td>";
        echo "<td class=\"alsl4\">".number_format($db->Record["gold"])." EKR</td>";
        echo "</tr>";
      }

      echo "</table>";  	
  }
}  
?>
