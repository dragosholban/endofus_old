<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include "functions.php";
include "database.php";
include "monitors.php";

function ranks()
{
  $db = new DataBase_theend;
  $db->connect();
  $db2 = new DataBase_theend;
  $db2->connect();

  $site_language=site_language();
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "GENERAL TOP";
  else 
    echo "TOP GENERAL";
  echo "</div>";
  
  echo "<br />";

  $query="select users.id, users.username, users.race, users.warned, armory.level, armory.exp, armory.units, mastery.battle, mastery.battle_win, online.online from users, armory, mastery, online where armory.id=users.id and mastery.id=users.id and online.id=users.id order by armory.rank=0, armory.rank, users.username";
  $db->query($query);
  $nr_inreg=$db->num_rows();
  $nr_inreg_pag=30;

  if(!$_POST["page"] || $_POST["page"]<0 || $_POST["page"]>ceil($nr_inreg/$nr_inreg_pag))
  {
    $page=1;
  }
  else
  {
    $page=$_POST["page"];
  }

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_general\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_general\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_general\"></input>";
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
  
  while($db->next_record())
  {
    $nr_inreg_cur++;

    if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
    {
       $alliance="";
       $query2="select alliances.name from alliances, alliance_members where alliance_members.id_member=".$db->Record["id"]." and alliance_members.grade>=0 and alliance_members.id_al=alliances.id";
       $db2->query($query2);
       $no_queries+=1;

       if($db2->num_rows())
       {
         $db2->next_record();
         $alliance=$db2->Record["name"];
       }

       echo "<tr>";
       echo "<td class=\"at1\">".number_format($nr_inreg_cur)."</td>";
       echo "<td class=\"at2\"><a class=\"".$db->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["id"]."\">".$db->Record["username"]."</a>";
       if($db->Record["warned"])
       {
         echo " <img src=\"pics/warned.gif\"></img>";
       }
       echo "<br><font color=\"#909090\">".$alliance."</font>";
       echo "</td>";
       echo "<td class=\"at3\">";
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
       echo "</td>";
       echo "<td class=\"at4\">";
       if($site_language=="en")
         echo "level ".$db->Record["level"]." ".$db->Record["race"];
       else 
       {  
       switch($db->Record["race"])
       {
       	case "human":
       		echo "om, nivel ".$db->Record["level"];
       		break;
       	case "machine":
       		echo "masina, nivel ".$db->Record["level"];
       		break;       		
       	case "alien":
       		echo "extrat., nivel ".$db->Record["level"];
       		break;
       }
       }
       echo "<br>";
       echo "<font color=\"#A0A0A0\">".number_format($db->Record["exp"])." exp.</font>";
       echo "</td>";
       echo "<td class=\"at5\">".number_format($db->Record["units"]);
       if($site_language=="en")
         echo " units</td>";
       else 
         echo " unitati</td>";  
       if($db->Record["online"]==1)
       {
         echo "<td class=\"at6\"><img src=\"pics/online.gif\"></img></td>";
       }
       if($db->Record["online"]==0)
       {
         echo "<td class=\"at6\"><img src=\"pics/offline.gif\"></img></td>";
       }
       if($db->Record["online"]==-1)
       {
         echo "<td class=\"at6\"><img src=\"pics/inactive.gif\"></img></td>";
       }
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
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_general\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_general\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_general\"></input>";
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



function week_top()

{
  $db = new DataBase_theend;
  $db->connect();
  $db2 = new DataBase_theend;
  $db2->connect();
  
  $site_language=site_language();

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "WEEK'S TOP";
  else 
    echo "TOPUL SAPTAMANII";  
  echo "</div>";
  echo "<br>";

  $query="select users.id, users.username, users.race, armory.level, armory.exp, armory.units, mastery.battle, mastery.battle_win, top_active_users.week1, online.online from users, armory, mastery, top_active_users, online where armory.id=users.id and mastery.id=users.id and top_active_users.id=users.id and online.id=users.id order by top_active_users.week1 desc, users.username";
  $db->query($query);
  $nr_inreg=$db->num_rows();
  $nr_inreg_pag=30;
  if(!$_POST["page"] || $_POST["page"]<0 || $_POST["page"]>ceil($nr_inreg/$nr_inreg_pag))
  {
    $page=1;
  }
  else
  {
    $page=$_POST["page"];
  }
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_week\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_week\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_week\"></input>";
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
  while($db->next_record())
  {
    $nr_inreg_cur++;

    if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
    {
       $alliance="";
       $query2="select alliances.name from alliances, alliance_members where alliance_members.id_member=".$db->Record["id"]." and alliance_members.grade>=0 and alliance_members.id_al=alliances.id";
       $db2->query($query2);
       $no_queries+=1;
       if($db2->num_rows())
       {
         $db2->next_record();
         $alliance=$db2->Record["name"];
       }
       echo "<tr>";
       echo "<td class=\"at1\">".number_format($nr_inreg_cur)."</td>";
       echo "<td class=\"at2\"><a class=\"".$db->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["id"]."\">".$db->Record["username"]."</a>";
       echo "<br><font color=\"#909090\">".$alliance."</font>";
       echo "</td>";
       echo "<td class=\"at3\">";

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

       echo "</td>";
       echo "<td  class=\"at4\">";
       echo "<font color=\"#909090\">".number_format($db->Record["week1"])." exp.</font>";
       echo "</td>";
       echo "<td class=\"at5\">".number_format($db->Record["units"]);
       if($site_language=="en")
         echo " units</td>";
       else 
         echo " unitati</td>";  
       if($db->Record["online"]==1)
       {
         echo "<td class=\"at6\"><img src=\"pics/online.gif\"></img></td>";
       }
       if($db->Record["online"]==0)
       {
         echo "<td class=\"at6\"><img src=\"pics/offline.gif\"></img></td>";
       }
       if($db->Record["online"]==-1)
       {
         echo "<td class=\"at6\"><img src=\"pics/inactive.gif\"></img></td>";
       }
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
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_week\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_week\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_week\"></input>";
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



function votes()
{
  $db = new DataBase_theend;
  $db->connect();
  $db2 = new DataBase_theend;
  $db2->connect();
  
  $site_language=site_language();

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "MOST POPULAR USERS";
  else 
    echo "CEI MAI POPULARI JUCATORI";  
  echo "</div>";
  
  echo "<br />";
  
  echo "<div class=\"titlebar2\">";
  if($site_language=="en")
    echo "LAST WEEK TOP 5 POPULAR USERS";
  else 
    echo "CEI MAI POPULARI 5 JUCATORI DE SAPTAMANA TRECUTA";  
  echo "</div>";

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $query="select users.id, users.username, users.race, users.last_votes, armory.level, armory.exp, armory.units, mastery.battle, mastery.battle_win, top_active_users.week1, online.online from users, armory, mastery, top_active_users, online where armory.id=users.id and mastery.id=users.id and top_active_users.id=users.id and online.id=users.id and online.online>=0 order by users.last_votes desc, users.username limit 0, 5";
  $db->query($query);
  $nr_inreg_cur=0;
  $i=1;
  while($db->next_record())
  {
    $nr_inreg_cur++;
       $alliance="";
       $query2="select alliances.name from alliances, alliance_members where alliance_members.id_member=".$db->Record["id"]." and alliance_members.grade>=0 and alliance_members.id_al=alliances.id";
       $db2->query($query2);
       $no_queries+=1;
       if($db2->num_rows())
       {
         $db2->next_record();
         $alliance=$db2->Record["name"];
       }
       echo "<tr>";
       echo "<td class=\"at1\">".$nr_inreg_cur."</td>";
       echo "<td class=\"at2\"><a class=\"".$db->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["id"]."\">".$db->Record["username"]."</a>";
       echo "<br><font color=\"#909090\">".$alliance."</font>";
       echo "</td>";
       echo "<td class=\"at3\">";
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
       echo "</td>";
       echo "<td class=\"at4\">";
       echo number_format($db->Record["last_votes"]);
       if($site_language=="en")
         echo " visits";
       else 
         echo " vizite";  
       echo "</td>";
       echo "<td class=\"at5\">".number_format($db->Record["units"]);
       if($site_language=="en")
         echo " units</td>";
       else 
         echo " unitati</td>";  
       if($db->Record["online"]==1)
       {
         echo "<td class=\"at6\"><img src=\"pics/online.gif\"></img></td>";
       }
       if($db->Record["online"]==0)
       {
         echo "<td class=\"at6\"><img src=\"pics/offline.gif\"></img></td>";
       }
       if($db->Record["online"]==-1)
       {
         echo "<td class=\"at6\"><img src=\"pics/inactive.gif\"></img></td>";
       }
       echo "</tr>";
       $i++;
  }
  echo "</table>";
  echo "</div>";
  echo "<br />";

  echo "<div class=\"titlebar2\">";
  if($site_language=="en")
    echo "THIS WEEK POPULAR USERS";
  else 
    echo "CEI MAI POPULARI JUCATORI DE SAPTAMNA ASTA";  
  echo "</div>";
  
  $query="select sum(users.votes) as total_votes from users, online where online.id=users.id and online.online>=0";
  $db->query($query);
  $db->next_record();
  $total_votes=$db->Record["total_votes"];

  $query="select users.id, users.username, users.race, users.votes, armory.level, armory.exp, armory.units, mastery.battle, mastery.battle_win, top_active_users.week1, online.online from users, armory, mastery, top_active_users, online where armory.id=users.id and mastery.id=users.id and top_active_users.id=users.id and online.id=users.id and online.online>=0 order by users.votes desc, users.username";
  $db->query($query);
  $nr_inreg=$db->num_rows();
  $nr_inreg_pag=30;
  if(!$_POST["page"] || $_POST["page"]<0 || $_POST["page"]>ceil($nr_inreg/$nr_inreg_pag))
  {
    $page=1;
  }
  else
  {
    $page=$_POST["page"];
  }
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_votes\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_votes\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_votes\"></input>";
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
  while($db->next_record())
  {
    $nr_inreg_cur++;

    if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
    {
       $alliance="";
       $query2="select alliances.name from alliances, alliance_members where alliance_members.id_member=".$db->Record["id"]." and alliance_members.grade>=0 and alliance_members.id_al=alliances.id";
       $db2->query($query2);
       $no_queries+=1;
       if($db2->num_rows())
       {
         $db2->next_record();
         $alliance=$db2->Record["name"];
       }
       echo "<tr>";
       echo "<td class=\"at1\">".number_format($nr_inreg_cur)."</td>";
       echo "<td class=\"at2\"><a class=\"".$db->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["id"]."\">".$db->Record["username"]."</a>";
       echo "<br><font color=\"#909090\">".$alliance."</font>";
       echo "</td>";
       echo "<td class=\"at3\">";

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

       echo "</td>";
       echo "<td class=\"at4\">";
       echo number_format($db->Record["votes"]);
       if($site_language=="en")
         echo " visits";
       else 
         echo " vizite"; 
       echo "</td>";
       echo "<td class=\"at5\">".number_format($db->Record["units"]);
       if($site_language=="en")
         echo " units</td>";
       else 
         echo " unitati</td>";
       if($db->Record["online"]==1)
       {
         echo "<td class=\"at6\"><img src=\"pics/online.gif\"></img></td>";
       }
       if($db->Record["online"]==0)
       {
         echo "<td class=\"at6\"><img src=\"pics/offline.gif\"></img></td>";
       }
       if($db->Record["online"]==-1)
       {
         echo "<td class=\"at6\"><img src=\"pics/inactive.gif\"></img></td>";
       }
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
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_votes\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_votes\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_votes\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";  

  echo "<br>";

  echo "<table class=\"dotted\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#000000\" width=\"90%\"><tr><td align=\"center\">";

  $wtoday=date("w");

  $week_end=mktime(0, 0, 0, date(m), date(d)-$wtoday+1+7, date(Y));

  echo "<br>";

  echo "<div style=\"overflow:hidden;font-size:10px;line-height:12px;color:#F0F0F0;font-family:verdana,arial,sans-serif;font-weight:normal;text-decoration:none;\">";

  echo "<font color=\"FFA500\">This top will reset in</font> <font color=\"#FFD700\">".round(($week_end-time())/3600)." hours</font><font color=\"FFA500\">.</font>";

  echo "<div>";

  echo "<br>";

  echo "</td></tr></table>";



  echo "<br>";

  echo "Total visits: ".number_format($total_votes);

  echo "<br>";

}



function alliances_top()
{
  $db = new DataBase_theend;
  $db->connect();
  $db2 = new DataBase_theend;
  $db2->connect();
  
  $site_language=site_language();
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "TOP ALLIANCES";
  else 
    echo "TOP ALIANTE";  
  echo "</div>";

  echo "<br>";

  $query="select alliances.id, alliances.name, alliances.commander, alliances.createdon, alliances.cost, alliances.avatar, users.race, (select count(id_member) from alliance_members where alliance_members.id_al=alliances.id and alliance_members.grade>=0) as nrmem, (select sum(armory.rank_value) from armory, alliance_members, online where alliance_members.id_al=alliances.id and alliance_members.grade>=0 and alliance_members.id_member=armory.id and alliance_members.id_member=online.id and online.online>=0) as value from alliances, users where alliances.commander=users.username order by value desc, nrmem desc";
  $db->query($query);
  $nr_inreg=$db->num_rows();
  $nr_inreg_pag=30;
  if(!$_POST["page"] || $_POST["page"]<0 || $_POST["page"]>ceil($nr_inreg/$nr_inreg_pag))
  {
    $page=1;
  }
  else
  {
    $page=$_POST["page"];
  }
  $nr_inreg_cur=0;
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_alliances\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_alliances\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_alliances\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";    

  echo "<div class=\"section\">";
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  
  while($db->next_record())
  {
    $nr_inreg_cur++;

    if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
    {
       echo "<tr>";
       echo "<td class=\"al1\">".$nr_inreg_cur."</td>";
       echo "<td class=\"al2\">";
       if($db->Record["avatar"])
       {
         echo "<img class=\"small_avatar\" src=\"".$db->Record["avatar"]."\" />";
       }
       else
       {
         echo "<img class=\"small_avatar\" src=\"pics/avatars/".$db->Record["race"]."s.jpg\" />";
       }
       echo "</td>";
       echo "<td class=\"al3\">";
       echo "<div style=\"overflow:hidden;width:150px;\">";
       echo "<a class=\"".$db->Record["race"]."\" href=\"#\">".$db->Record["name"]."</a>";
       echo "<br><font color=\"#A0A0A0\">Com. ".$db->Record["commander"]."</font>";
       echo "</div>";
       echo "</td>";

       echo "<td class=\"al4\">".$db->Record["nrmem"]." ";
       if($site_language=="en")
       {
         echo $db->Record["race"];
         if($db->Record["nrmem"]>1) echo "s";
       }
       else 
       {
       	 switch($db->Record["race"])
       	 {
       	 	case "human":
       	 		if($db->Record["nrmem"]>1) echo "oameni";
       	 		else echo "om";
       	 		break;	
       	 	case "machine":
       	 		if($db->Record["nrmem"]>1) echo "masini";
       	 		else  echo "masina";
       	 		break;	
       	 	case "alien":
       	 		if($db->Record["nrmem"]>1) echo "extraterestrii";
       	 		else echo "extraterestru";
       	 		break;
       	 }
       }
       echo "</td>";

       echo "<td class=\"al5\">";
       if($site_language=="en")
         echo "Created on ";
       else
         echo "Creata in ";
       echo $db->Record["createdon"]."</td>";
       echo "</tr>";
    }
  }

  echo "</table>";
  echo "</div>";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_alliances\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_alliances\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_alliances\"></input>";
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

function deleted_accounts()
{
  $db = new DataBase_theend;
  $db->connect();
  $db2 = new DataBase_theend;
  $db2->connect();

  $site_language=site_language();
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "HALL OF SHAME - List of deleted accounts for breaking the game rules";
  else 
    echo "Lista conturilor sterse pentru incalcarea regulilor jocului";  
  echo "</div>";
  echo "<br />";
  
  $query="select username, data from deleted_accounts  order by data desc, username";
  $db->query($query);
  $nr_inreg=$db->num_rows();
  $nr_inreg_pag=30;
  if(!$_POST["page"] || $_POST["page"]<0 || $_POST["page"]>ceil($nr_inreg/$nr_inreg_pag))
  {
    $page=1;
  }
  else
  {
    $page=$_POST["page"];
  }
  $i=1;
  $nr_inreg_cur=0;  

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\">";

  echo "<div class=\"page_go\">";
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_deleted\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_deleted\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_deleted\"></input>";
          echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
          echo "</form>";
  }
  echo "</div>";
  
  echo "</div>"; 
  echo "</div>"; 
  echo "</div>";   
  
  echo "<div class=\"section\">";
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  while($db->next_record())
  {
    $nr_inreg_cur++;
    if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
    {
       echo "<tr>";
       echo "<td class=\"hs1\">".$nr_inreg_cur."</td>";
       echo "<td class=\"hs2\">".$db->Record["username"]."</td>";
       echo "<td class=\"hs3\">".$db->Record["data"]."</td>";
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
  echo "<form action=\"ranks.php\" method=\"POST\">"; 
  if($site_language=="en")
    echo "Go to page:";
  else
    echo "Mergi la pag.:";
  echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_deleted\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_deleted\"></input>";
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
          echo "<form style=\"display: inline;\" action=\"ranks.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"ranks_deleted\"></input>";
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
?>


<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
  <meta name="description" content="Massive multiplayer online game. Adventure game. Browser based. Joc de strategie online." />
  <meta name="keywords" content="massive, multiplayer, free, online, game, mmorpg, strategie, razboi, war" />
  <link rel="stylesheet" type="text/css" href="css/new_style.css" />
  <title>End of us - massive multiplayer online game (joc online de strategie)</title>
  <script language="JavaScript" type="text/javascript" src="functions.js"></script>
</head>

<body>

  <table class="page_format" cellspacing="0" cellpadding="0">
    <tr>
      <td class="header_td" colspan="3">
        <?php top(); ?>
      </td>
    </tr>
    <tr>
      <td class="left_td">
        <div class="menu_bg">
		<?php
		  if($_POST["loc"]=="ranks_general") main_menu("ranks_general");
		  if($_POST["loc"]=="ranks_week") main_menu("ranks_week");
		  if($_POST["loc"]=="ranks_alliances") main_menu("ranks_alliances");
		  if($_POST["loc"]=="ranks_votes") main_menu("ranks_votes");
		  if($_POST["loc"]=="ranks_deleted") main_menu("ranks_deleted");
		?>        
        <?php game_menu(); ?>
        </div>
        <div class="left_box_white_spacer"></div>
        <br />
        <?php ad_left(); ?>
      </td>
      <td class="center_td">
        <object type="application/x-shockwave-flash" data="pics/clouds.swf" width="640" height="144">
        <param name="movie" value="pics/clouds.swf" />
        <param name="BGCOLOR" value="#000000" />
        <a title="You must install the Flash Plugin for your Browser in order to view this movie"  href="http://www.macromedia.com/shockwave/download/alternates/"><img src="needplugin.gif" width="431" height="68" alt="placeholder for flash movie" /></a>
        </object>

<?php

if($_POST["loc"]=="ranks_general") ranks();

if($_POST["loc"]=="ranks_week") week_top();

if($_POST["loc"]=="ranks_alliances") alliances_top();

if($_POST["loc"]=="ranks_votes") votes();

if($_POST["loc"]=="ranks_deleted") deleted_accounts();

?>

      </td>
      <td class="right_td">
        <?php latest_news_box(); ?>
        <?php counter_box(); ?>
        <div class="right_box_black_spacer"></div>
        <div class="right_box_white_spacer"></div>
        <?php ad_right(); ?>
        <br />
        <?php gazduiresite_box(); ?>
      </td>
    </tr>
  </table>
  <div class="footer">
      <?php bottom(); ?>
  </div>
</body>

</html>
