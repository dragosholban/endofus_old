<?php

function search()
{
  $site_language=site_language();	

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "SEARCH RESULTS";
  else 
    echo "REZULTATE CAUTARE";  
  echo "</div>";	
  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  if($site_language=="en")
    echo "Search results for <font color=\"#FFA700\">".$_POST["searchstr"]."</font>:";
  else 
    echo "Rezultatele cautarii dupa <font color=\"#FFA700\">".$_POST["searchstr"]."</font>:";  
  echo "<br />";

  if(strlen($_POST["searchstr"])<3)
  {
    if($site_language=="en")
  	  echo "<font color=\"#909090\">Please enter a minimum 3 characters search string.</font>";
  	else 
  	  echo "<font color=\"#909090\">Te rugam introdu un sir de minim 3 caractere pentru cautare.</font>";  
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
  else
  {
  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  $my_spy_power=power_spy($_COOKIE["uid"]);
  
  echo "<div class=\"section\">";
  
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db2 = new DataBase_theend;
  $db2->connect();
  $query="select users.id, users.username, users.race, armory.rank, armory.units, armory.level, armory.exp, armory.gold, seif.gold as safe, mastery.battle, mastery.battle_win, online.online from users, armory, mastery, online, seif where users.username like '%".$_POST["searchstr"]."%' and users.id=armory.id and users.id=mastery.id and users.id=online.id and users.id=seif.uid order by users.username";
  $db_theend->query($query);
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  while($db_theend->next_record())
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
      echo "<td class=\"at2\">";
      echo "<div style=\"overflow:hidden;width:150px;\">";
      echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a>&nbsp;";

      echo "<br><font color=\"#909090\" style=\"font-size: 7pt;\">".$alliance."</font>";
      echo "</div>";

      echo "</td>";

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
      echo "<td class=\"at5\">";
        if($my_spy_power>$sentry_power*2 || $db_theend->Record["id"]==$_COOKIE["uid"])
          echo number_format($db_theend->Record["gold"]+$db_theend->Record["safe"]);
        else
          echo "???";
        echo " EKR</td>";      
      
       if($db_theend->Record["online"]==1)
       {
         echo "<td class=\"at6\"><img src=\"pics/online.gif\"></img></td>";
       }
       if($db_theend->Record["online"]==0)
       {
         echo "<td class=\"at6\"><img src=\"pics/offline.gif\"></img></td>";
       }
       if($db_theend->Record["online"]==-1)
       {
         echo "<td class=\"at6\"><img src=\"pics/inactive.gif\"></img></td>";
       }

    echo "</tr>";
  }
  echo "</table>";
  
  echo "</div>";
  } //if, else

  echo "<br />";

  echo "<div class=\"search\">";
  echo "<form action=\"play.php\" method=\"POST\">";
  if($site_language=="en")
    echo "<font color=\"#909090\"> Search user: </font>";
  else 
    echo "<font color=\"#909090\"> Cauta jucator: </font>"; 
  echo "<input type=\"hidden\" name=\"loc\" value=\"search\"></input>";
  echo "<input class=\"input4\" size=\"10\" type=\"text\" name=\"searchstr\"></input>";
  echo "&nbsp;&nbsp;&nbsp;";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Search\"></input>";
  else 
    echo "<input class=\"submit4\" type=\"submit\" value=\"Cauta\"></input>";  
  echo "</form>";
  echo "</div>";
}

?>