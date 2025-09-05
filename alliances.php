<?php

function alliance()
{

  global $login_expires;
  global $no_queries;
  
  $site_language=site_language();

  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db2 = new DataBase_theend;
  $db2->connect();

  if($_POST["what"]=="join" && $_POST["alname"])
  {
    if($_COOKIE["uid"]) join_alliance($_POST["alname"],$_COOKIE["uid"]);
  }

  if($_GET["what"]=="create" && $_GET["alname"])
  {
    create_alliance($_GET["alname"]);
  }

  if($_POST["what"]=="cancelwait" && $_POST["alid"] && $_POST["user"])
  {
    $query="update armory, alliance_members set armory.gold=armory.gold+alliance_members.gold where armory.id=alliance_members.id_member and alliance_members.id_member=".$_POST["user"]." and alliance_members.id_al=".$_POST["alid"]." and alliance_members.grade=-1";
    $db_theend->query($query);
    $query="delete from alliance_members where id_member=".$_POST["user"]." and id_al=".$_POST["alid"]." and grade=-1";
    $db_theend->query($query);
  }

  //echo "<br>";

  $my_alliance_status=0; // 0 - nu e membru nici comandant
  $my_alliance="";

  $query="select alliance_members.grade, alliance_members.id_member, alliance_members.id_al, alliance_members.datetime from alliance_members where alliance_members.id_member=".$_COOKIE["uid"]."";
  $db_theend->query($query);
  if($db_theend->num_rows())
  {
       $db_theend->next_record();
       if($db_theend->Record["grade"]==1) $my_alliance_status=1; // 1 - e comandant
       if($db_theend->Record["grade"]==0) $my_alliance_status=2; // 2 - e membru
       if($db_theend->Record["grade"]==2) $my_alliance_status=3; // 3 - e ofiter
       if($db_theend->Record["grade"]==-1) $my_alliance_status=4; // 4 - e in asteptare
       if($db_theend->Record["grade"]==-2) $my_alliance_status=5; // 5 - nu e membru dar a fost

       $my_id=$db_theend->Record["id_member"];
       $my_alliance_id=$db_theend->Record["id_al"];

    $query="select name from alliances where id=".$my_alliance_id;
    $db_theend->query($query);
    if($db_theend->num_rows())
    {
      $db_theend->next_record();
      $my_alliance=$db_theend->Record["name"];
    }
    else
    {
      $my_alliance="";
    }
  }

  if((!$_GET["what"] && !$_POST["what"]) || $_POST["what"]=="cancelwait")
  {

  echo "<div class=\"titlebar\">ALLIANCES</div>"; 
  	
  echo "<br />";

  if($my_alliance_status==1)
  {
       echo "<div class=\"section\">";
       echo "<div class=\"section_black\">";
       echo "<div class=\"section_grey\">";
       if($site_language=="en")
         echo "You are commander of <font color=\"#FFA700\">".$my_alliance."</font> alliance.";
       else
         echo "Esti comandantul aliantei <font color=\"#FFA700\">".$my_alliance."</font>.";
       echo "<br />";
       echo "</div>";
       echo "</div>";
       echo "</div>";
       echo "<br />";

       if($_GET["what"]!="details" && $_POST["what"]!="manage")
         alliance_details($my_alliance_id,1);
  }

       if($my_alliance_status==2)
       {
            echo "<div class=\"section\">";
            echo "<div class=\"section_black\">";
            echo "<div class=\"section_grey\">";
            if($site_language=="en")
              echo "You are a member of <font color=\"#FFA700\">".$my_alliance."</font> alliance.";
            else
              echo "Esti membru al aliantei <font color=\"#FFA700\">".$my_alliance."</font>.";
            echo "<br />";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<br />";

            if($_GET["what"]!="details" && $_POST["what"]!="manage")
              alliance_details($my_alliance_id,2);
       }

       if($my_alliance_status==3)
       {
            echo "<div class=\"section\">";
            echo "<div class=\"section_black\">";
            echo "<div class=\"section_grey\">";
            if($site_language=="en")
              echo "You are officer in <font color=\"#FFA700\">".$my_alliance."</font> alliance.";
            else
              echo "Esti ofiter in alianta <font color=\"#FFA700\">".$my_alliance."</font>.";
            echo "<br />";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<br />";

            if($_GET["what"]!="details" && $_POST["what"]!="manage")
              alliance_details($my_alliance_id,3);
       }

       if($my_alliance_status==4)
       {
            echo "<div class=\"section\">";
            echo "<div class=\"section_black\">";
            echo "<div class=\"section_grey\">";
            if($site_language=="en")
              echo "You are on the <font color=\"#FFA700\">".$my_alliance."</font> alliance's waiting list.";
            else
              echo "Esti pe lista de asteptare a aliantei <font color=\"#FFA700\">".$my_alliance."</font>.";

            echo "<br><br>";
            echo "<form action=\"play.php\" method=\"POST\">";
            echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
            echo "<input type=\"hidden\" name=\"what\" value=\"cancelwait\"></input>";
            echo "<input type=\"hidden\" name=\"alid\" value=\"".$my_alliance_id."\"></input>";
            echo "<input type=\"hidden\" name=\"user\" value=\"".$my_id."\"></input>";
            echo "<input class=\"input2\" type=\"submit\" value=\"Renunta\"></input>";
            echo "</form>";

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<br />";

            if($_GET["what"]!="details" && $_POST["what"]!="manage")
              alliance_details($my_alliance_id,4);
       }

       if($my_alliance_status==0)
       {
            echo "<div class=\"section\">";
            echo "<div class=\"section_black\">";
            echo "<div class=\"section_grey\">";

              if($site_language=="en")
              {
                echo "You do not belong to any alliance.<br><br>";
                echo "<font color=\"#A0A0A0\">To join an existing alliance visit the list of alliances or, to create a new one, use the form below.</font>";
              }
              else
              {
                echo "Nu faci parte din nici o alianta.<br><br>";
                echo "<font color=\"#A0A0A0\">Pentru a intra intr-o alianta mergi la lista aliantelor sau,<br>pentru a crea una noua, foloseste formularul de mai jos.</font>";
              }

            echo "</div>";
            echo "</div>";
            echo "</div>";

              echo "<br />";

              echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\">";
              echo "<tr><td background=\"pics/redbigbar.gif\" align=\"center\" height=\"22\">";
              if($site_language=="en")
                echo "<b>CREATE ALLIANCE</b>";
              else
                echo "<b>CREARE ALIANTA</b>";
              echo "</td></tr>";
              echo "</table>";

              echo "<table cellspacing=\"0\" cellpadding=\"0\" height=\"4\" width=\"470\"><tr><td></td></tr></table>";

              echo "<table class=\"dotted\" cellspacing=\"0\" cellpadding=\"0\" width=\"470\">";
              echo "<tr><td align=\"center\">";

              echo "<br>";

              echo "<form action=\"play.php\" method=\"GET\">";
              echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
              echo "<input type=\"hidden\" name=\"what\" value=\"create\"></input>";
              echo "<table cellspacing=\"0\" cellpadding=\"0\"><tr><td>";
              echo "<table><tr><td>";
              if($site_language=="en")
                echo "Create new alliance - costs 100,000 gold<br><br>";
              else
                echo "Creare alianta - costa 100,000 aur<br><br>";
              if($site_language=="en")
                echo "Alliance name:";
              else
                echo "Numele aliantei:";
              echo "&nbsp;&nbsp;&nbsp;</td><td><br><br><input class=\"input2\" type=\"text\" name=\"alname\"></input>";
              echo "</td><td><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              if($site_language=="en")
                echo "<input class=\"iblue2\" type=\"submit\" value=\"Create Alliance\"></input>";
              else
                echo "<input class=\"iblue2\" type=\"submit\" value=\"Creaza Alianta\"></input>";
              echo "</td></tr></table>";
              echo "</td></tr></table>";
              echo "</form>";

              echo "</td></tr>";
              echo "</table>";

              echo "<br>";
       }

       if($my_alliance_status==5)
       {
              $query="select datetime from alliance_members where id_member=".$my_id;
              $db_theend->query($query);
              $db_theend->next_record();

              if(time()-strtotime($db_theend->Record["datetime"])>2*24*3600)
              // if(1)
              {

              echo "<div class=\"section\">";
              echo "<div class=\"section_black\">";
              echo "<div class=\"section_grey\">";

              if($site_language=="en")
              {
                echo "You do not belong to any alliance.<br><br>";
                echo "<font color=\"#A0A0A0\">To join an existing alliance visit the list of alliances or, to create a new one, use the form below.</font>";
              }
              else
              {
                echo "Nu faci parte din nici o alianta.<br><br>";
                echo "<font color=\"#A0A0A0\">Pentru a intra intr-o alianta mergi la lista aliantelor sau,<br>pentru a crea una noua, foloseste formularul de mai jos.</font>";
              }

              echo "</div>";
              echo "</div>";
              echo "</div>";

              echo "<br>";

              echo "<table cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"#404040\" width=\"630\">";
              echo "<tr><td bgcolor=\"#000000\" align=\"center\" height=\"22\">";
              if($site_language=="en")
                echo "<b>CREATE ALLIANCE</b>";
              else
                echo "<b>CREARE ALIANTA</b>";
              echo "</td></tr>";
              echo "</table>";

              echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"627\">";
              echo "<tr><td align=\"center\">";

              echo "<br>";

              echo "<form action=\"play.php\" method=\"GET\">";
              echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
              echo "<input type=\"hidden\" name=\"what\" value=\"create\"></input>";
              echo "<table cellspacing=\"0\" cellpadding=\"0\"><tr><td>";
              echo "<table><tr><td>";
              if($site_language=="en")
                echo "Create new alliance - costs 100,000 gold<br><br>";
              else
                echo "Creare alianta - costa 100,000 aur<br><br>";
              if($site_language=="en")
                echo "Alliance name:";
              else
                echo "Numele aliantei:";
              echo "&nbsp;&nbsp;&nbsp;</td><td><br><br><input class=\"input2\" type=\"text\" name=\"alname\"></input>";
              echo "</td><td><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
              if($site_language=="en")
                echo "<input class=\"iblue2\" type=\"submit\" value=\"Create Alliance\"></input>";
              else
                echo "<input class=\"iblue2\" type=\"submit\" value=\"Creaza Alianta\"></input>";
              echo "</td></tr></table>";
              echo "</td></tr></table>";
              echo "</form>";

              echo "</td></tr>";
              echo "</table>";

              echo "<br>";

              echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"630\">";
              echo "<tr><td bgcolor=\"#404040\" height=\"1\"></td></tr>";
              echo "</table>";

              }
              else
              {

              echo "<div class=\"section\">";
              echo "<div class=\"section_black\">";
              echo "<div class=\"section_grey\">";

              if($site_language=="en")
              {
                echo "You do not belong to any alliance.<br><br>";
                echo "<font color=\"#A0A0A0\">You cannot join or create any alliance because you were member of one in the last 48 hours.</font>";
                echo "<br>You will be able to join or create another alliance in ".(49-ceil((time()-strtotime($db_theend->Record["datetime"]))/3600))." hour(s).";
              }
              else
              {
                echo "Nu faci parte din nici o alianta.<br><br>";
                echo "<font color=\"#A0A0A0\">Nu poti intra sau crea o alianta deoarece ai fost membrul uneia in ultimele 48 de ore.</font>";
                echo "<br>Vei putea intra sau crea o alta alianta peste aproximativ ".(49-ceil((time()-strtotime($db_theend->Record["datetime"]))/3600))." ore.";
              }

              echo "</div>";
              echo "</div>";
              echo "</div>";

              }
       }

  }

  if($_POST["what"]=="safe" && $_POST["alliance"])
  {
      alliance_safe($_POST["alliance"]);
  }

  if($_POST["what"]=="details" && $_POST["alname"])
  {
      if($_POST["alname"]==$my_alliance)
        alliance_details($_POST["alname"],$my_alliance_status);
      else
        alliance_details($_POST["alname"],0);
  }

  if($_POST["what"]=="users" && $_POST["alname"])
  {
      alliance_users($_POST["alname"]);
  }

  if($_POST["what"]=="manage" && $_POST["alname"])
  {
      alliance_manage($_POST["alname"],$my_alliance_status);
  }

  if($_POST["what"]=="waiting" && $_POST["alname"])
  {
      alliance_waiting($_POST["alname"],$my_alliance_status);
  }

  if($_POST["what"]=="listalliances")
  {
    list_alliances($my_alliance_status);
  }
}

function alliance_manage($al_name,$grade)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db = new DataBase_theend;
  $db->connect();  

  $site_language=site_language();

  $query="select name from alliances where id=".$al_name;
  $db_theend->query($query);
  $db_theend->next_record();
  $alname=$db_theend->Record["name"];

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "ALLIANCE ADMINISTRATION";
  else 
    echo "ADMINISTRARE ALIANTA";  
  echo "</div>";
  
  if($_POST["opt"]=="disbanduser" && $_POST["user"])
  {
    $query="update alliance_members set grade=-2, datetime='".date("Y-m-d H:i:s")."' where alliance_members.id_member=".$_POST["user"];
    $db_theend->query($query);
    $no_queries+=1;
  }

  if($_POST["opt"]=="promoteuser" && $_POST["user"])
  {
    $query="select count(alliance_members.id_member) as members from alliance_members, alliances where alliance_members.id_al=alliances.id and alliances.id=".$_POST["alname"]." and alliance_members.grade>=0";
    $db_theend->query($query);
    $no_queries+=1;
    $db_theend->next_record();
    $members=$db_theend->Record["members"];
    $query="select count(alliance_members.id_member) as officers from alliance_members, alliances where alliance_members.id_al=alliances.id and alliances.id=".$_POST["alname"]." and alliance_members.grade=2";
    $db_theend->query($query);
    $no_queries+=1;
    $db_theend->next_record();
    $officers=$db_theend->Record["officers"];
    if($officers<ceil($members/10))
    {
      $query="update alliance_members set grade=2 where id_member=".$_POST["user"];
      $db_theend->query($query);
      $no_queries+=1;
    }
  }

  if($_POST["opt"]=="relegateuser" && $_POST["user"])
  {
    $query="update alliance_members set grade=0 where id_member=".$_POST["user"];
    $db_theend->query($query);
    $no_queries+=1;
  }

  echo "<br>";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";

  if($site_language=="en")
    echo "Options: ";
  else 
    echo "Optiuni: ";  

  echo "<form style=\"display: inline;\" name=\"adminalmembers\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"members\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalmembers.submit();\">[members]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalmembers.submit();\">[membri]</a>";  
  echo "</form>";
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalwaitinglist\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"waiting\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalwaitinglist.submit();\">[waiting list]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalwaitinglist.submit();\">[lista de asteptare]</a>";  
  echo "</form>";
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalpowerinfo\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"powerinfo\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalpowerinfo.submit();\">[power info]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalpowerinfo.submit();\">[informatii putere]</a>";  
  echo "</form>";
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalfinancial\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"cost\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalfinancial.submit();\">[financial]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalfinancial.submit();\">[finante]</a>";  
  echo "</form>";
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalpersonalize\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"personalize\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalpersonalize.submit();\">[personalize]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalpersonalize.submit();\">[personalizare]</a>";  
  echo "</form>";  
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalchcom\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"chcom\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalchcom.submit();\">[change commander]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalchcom.submit();\">[schimbare comandant]</a>";  
  echo "</form>";   

  echo "</div>";
  echo "</div>";
  echo "</div>";

  echo "<br>";

  if($_POST["subopt"]=='members' || !$_POST["subopt"])
  {

  if($_POST["subopt2"]=='max_members')
  {
    $query="select max_members, gold from alliances where id=".$al_name;
    $db_theend->query($query);
    $db_theend->next_record();
    $max_members=$db_theend->Record["max_members"];
    $gold=$db_theend->Record["gold"];
    if($gold>=$max_members*10000000 && $max_members<50)
    {
      $query="update alliances set max_members=".($max_members+10).", gold=".($gold-$max_members*10000000)." where id=".$al_name;
      $db_theend->query($query);
    }
  }

  $query="select max_members, gold from alliances where id=".$al_name;
  $db_theend->query($query);
  $db_theend->next_record();
  $max_members=$db_theend->Record["max_members"];
  $gold=$db_theend->Record["gold"];
  
  echo "<div class=\"section\">";
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  echo "<tr><td class=\"almmup1\">";
  if($site_language=="ro")
    echo "Numarul maxim de membrii:";
  else
    echo "Max. number of members";
  echo "</td><td class=\"almmup2\">".$max_members;
  if($site_language=="ro")
    echo " membrii";
  else
    echo " members";
  echo "</td>";
  echo "<td class=\"almmup3\" rowspan=\"4\">";
  if($max_members<50)
  {
    if($gold>=10000000*$max_members)
    {
      echo "<form action=\"play.php\" method=\"POST\">";
      echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
      echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
      echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\"></input>";
      echo "<input type=\"hidden\" name=\"subopt\" value=\"members\"></input>";
      echo "<input type=\"hidden\" name=\"subopt2\" value=\"max_members\"></input>";
      echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
      echo "</form>";
    }
    else
      echo "<input class=\"submit4\" type=\"button\" value=\"Upgrade\"></input>";
  }
  else
  {
    echo "";
  }  
  echo "</td>";
  echo "</tr>";
  echo "<tr><td class=\"almmup1\">";
  if($site_language=="ro")
    echo "Urmatorul upgrade posibil:";
  else
    echo "Next possible upgrade:";
  echo "</td><td class=\"almmup2\">";
  if($max_members<50)
  {
    echo ($max_members+10);
    if($site_language=="ro")
      echo " membrii";
    else
      echo " members";
  }
  else
    echo " - ";
  echo "</td>";
  echo "</tr>";
  echo "<tr><td class=\"almmup1\">";
  if($site_language=="ro")
    echo "Cost upgrade:";
  else
    echo "Upgrade cost:";
  echo "</td><td class=\"almmup2\">";
  if($max_members<50)
    echo number_format(10000000*$max_members)." EKR";
  else
    echo " - ";
  echo "</td></tr>";
  echo "<tr><td class=\"almmup1\">";
  if($site_language=="ro")
    echo "Seif alianta:";
  else
    echo "Alliance's safe:";
  echo "</td><td class=\"almmup2\">".number_format($gold)." EKR</td></tr>";
  echo "</table>";
  echo "</div>";

  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";  

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $query="select users.username, users.id, users.race, armory.level, armory.exp, online.datetime, alliance_members.grade from users, alliances, alliance_members, armory, online where alliances.id=".$al_name." and alliances.id=alliance_members.id_al and alliance_members.id_member=users.id and users.id=armory.id and users.id=online.id and alliance_members.grade>=0 order by armory.level desc, armory.exp desc, users.username";
  $db_theend->query($query);
  $no_queries+=1;
  if($db_theend->num_rows())
  {
    while($db_theend->next_record())
    {
      echo "<tr>";
      echo "<td class=\"alm1\">";
      if($db_theend->Record["grade"]==1)
      {
        echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a>";
        if($site_language=="ro")
          echo "<br />Comandant";
        else 
          echo "<br />Commander";  
      }
      if($db_theend->Record["grade"]==2)
      {
        echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a>";
        if($site_language=="ro")
          echo "<br />Ofiter";
        else 
          echo "<br />Officer";       
      }
      if($db_theend->Record["grade"]==0)
      {
        echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a>";
        if($site_language=="ro")
          echo "<br />Membru";
        else 
          echo "<br />Member";          
      }
      echo "</td><td class=\"alm2\">".$db_theend->Record["level"]."<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">";
      if($site_language=="en")
        echo "level";
      else 
        echo "nivel";  
      echo "</font></td>";
      echo "<td class=\"alm3\">".number_format($db_theend->Record["exp"])."<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">exp.</font></td>";
      echo "<td class=\"alm4\">".number_format(power_attack($db_theend->Record["id"]))."<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">";
      if($site_language=="en")
        echo "attack";
      else 
        echo "atac";  
      echo "</font></td>";
      echo "<td class=\"alm5\">".number_format(power_defense($db_theend->Record["id"]))."<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">";
      if($site_language=="en")
        echo "defense";
      else 
        echo "aparare";  
      echo "</font></td>";
      echo "<td class=\"alm6\">".$db_theend->Record["datetime"]."<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">";
      if($site_language=="en")
        echo "last seen";
      else 
        echo "ultima data online";
      echo "</font></td>";
      echo "<td class=\"alm7\">";
      if($db_theend->Record["username"]!=$_COOKIE["user"])
      {
        if($db_theend->Record["grade"]==0 || ($db_theend->Record["grade"]==2 && $grade==1))
        {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
          echo "<input type=\"hidden\" name=\"alname\" value=\"".$al_name."\"></input>";
          echo "<input type=\"hidden\" name=\"opt\" value=\"disbanduser\"></input>";
          echo "<input type=\"hidden\" name=\"user\" value=\"".$db_theend->Record["id"]."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\"D\" onmouseover=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH=100; return escape('Disband user');\"></input>";
          echo "</form>";
        }
        echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
        echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
        echo "<input type=\"hidden\" name=\"what\" value=\"send\"></input>";
        echo "<input type=\"hidden\" name=\"user\" value=\"".$db_theend->Record["id"]."\"></input>";
        echo "<input class=\"submit4\" type=\"submit\" value=\"M\" onmouseover=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH=100; return escape('Send mail to user');\"></input>";
        echo "</form>";
        if($db_theend->Record["grade"]==0 && $grade==1)
        {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
          echo "<input type=\"hidden\" name=\"alname\" value=\"".$al_name."\"></input>";
          echo "<input type=\"hidden\" name=\"opt\" value=\"promoteuser\"></input>";
          echo "<input type=\"hidden\" name=\"user\" value=\"".$db_theend->Record["id"]."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\"P\" onmouseover=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH=100; return escape('Promote user');\"></input>";
          echo "</form>";
        }
        if($db_theend->Record["grade"]==2 && $grade==1)
        {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
          echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
          echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
          echo "<input type=\"hidden\" name=\"alname\" value=\"".$al_name."\"></input>";
          echo "<input type=\"hidden\" name=\"opt\" value=\"relegateuser\"></input>";
          echo "<input type=\"hidden\" name=\"user\" value=\"".$db_theend->Record["id"]."\"></input>";
          echo "<input class=\"submit4\" type=\"submit\" value=\"R\" onmouseover=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH=100; return escape('Relegate user');\"></input>";
          echo "</form>";
        }
      }
      echo "</td></tr>";
    }
  }
  echo "</table>";

  echo "<div style=\"text-align: right; padding: 5px;\">";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliancemail\"></input>";
  if($site_language=="ro")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Trimite mesaj la toti membrii\"></input>";
  else 
    echo "<input class=\"submit4\" type=\"submit\" value=\"Send mail to all members\"></input>";
  echo "</form>";  
  echo "</div>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";

  echo "<br>";
  }

  if($_POST["subopt"]=='powerinfo')
  {
  echo "<div class=\"section\">";
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $id_al=$al_name;

  echo "<tr>";
  echo "<td class=\"almp1\">";
  if($site_language=="ro")
    echo "Puterea de atac a aliantei:";
  else
    echo "Alliance attack power:";
  echo "</td>";
  echo "<td class=\"almp2\">";
  $power_at=power_attack_alliance($id_al);
  echo number_format($power_at);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp1\">";
  if($site_language=="ro")
    echo "Puterea de aparare a aliantei:";
  else
    echo "Alliance defense power:";
  echo "</td>";
  echo "<td class=\"almp2\">";
  $power_df=power_defense_alliance($id_al);
  echo number_format($power_df);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";  
  if($site_language=="ro")
    echo "Bonusul de putere de atac pentru comandant:";
  else
    echo "Attack power bonus for commander:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_at_com=round(0.01*$power_at);
  echo number_format($bonus_at_com);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";    
  if($site_language=="ro")
    echo "Bonusul de putere de aparare pentru comandant:";
  else
    echo "Defense power bonus for commander:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_df_com=round(0.01*$power_df);
  echo number_format($bonus_df_com);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";   
  if($site_language=="ro")
    echo "Bonusul de putere de atac pentru ofiteri:";
  else
    echo "Attack power bonus for officers:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_at_of=round(0.008*$power_at);
  echo number_format($bonus_at_of);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";   
  if($site_language=="ro")
    echo "Bonusul de putere de aparare pentru ofiteri:";
  else
    echo "Defense power bonus for officers:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_df_of=round(0.008*$power_df);
  echo number_format($bonus_df_of);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";  
  if($site_language=="ro")
    echo "Bonusul de putere de atac pentru membrii:";
  else
    echo "Attack power bonus for members:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_at_mem=round(0.006*$power_at);
  echo number_format($bonus_at_mem);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";  
  if($site_language=="ro")
    echo "Bonusul de putere de aparare pentru membrii:";
  else
    echo "Defense power bonus for members:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_df_mem=round(0.006*$power_df);
  echo number_format($bonus_df_mem);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp5\" colspan=\"2\">";  
  if($site_language=="ro")
    echo "* Bonusul primit de un membru al aliantei nu va depasi 50% din puterea sa proprie.";
  else
    echo "* Alliance's bonus received by any member will not exceed 50% from member's self power.";  
  echo "</td>";
  echo "</tr>";  
  echo "</table>";
  echo "</div>";
  }

  if($_POST["subopt"]=='cost')
  {
  	
    if($_POST["act"]=="update" && $_POST["cost"] && $_POST["cost"]>=0)
    {
      $query="update alliances set cost=".$_POST["cost"]." where id=".$al_name;
      $db_theend->query($query);
    }

    if($_POST["act"]=="transfer" && $_POST["user"] && $_POST["gold"]>0)
    {
      $today=getdate();
      if($today["wday"]==0) $wday=6;
      else $wday=$today["wday"]-1;
      $query="select datetime from al_finance_log where user2=".$_POST["user"]." and op=6 and datetime>='".date("Y-m-d H:i:s",mktime(0,0,0,$today["mon"],$today["mday"]-$wday,$today["year"]))."'";
      $db_theend->query($query);
      if($db_theend->num_rows())
      {
        // s-a transferat gold saptamana asta catre acest user, nu se mai poate face un nou transfer
        $transfer_error="This user allready received gold from alliance's safe this week.";
      }
      else
      {
      $query="select alliances.id, alliances.gold, alliances.max_members, count(alliance_members.id_member) as members from alliances, alliance_members where id=".$al_name." and alliances.id=alliance_members.id_al and alliance_members.grade>=0 group by alliance_members.id_al";
      $db_theend->query($query);
      $db_theend->next_record();
      $al_id=$db_theend->Record["id"];
      $al_gold=$db_theend->Record["gold"];
      $safe_max_gold=$db_theend->Record["members"]*10000000;
      if(round($_POST["gold"])>$al_gold)
      {
        $transfer=0;
        $transfer_error="Maximum amount of gold that can be transfered is ".number_format($al_gold).".";
      }
      else
      {
        if(round($_POST["gold"])>$safe_max_gold/10)
        {
          $transfer=0;
          $transfer_error="Maximum amount of gold that can be transfered is ".number_format(round($safe_max_gold/10)).".";
        }
        else
        {
          $transfer=round($_POST["gold"]);
        }
      }

      if($transfer)
      {
        $query="update armory set gold=gold+".$transfer." where id=".$_POST["user"];
        $db_theend->query($query);
        $al_gold=$al_gold-$transfer;
        $query="update alliances set gold=".$al_gold." where id=".$al_id;
        $db_theend->query($query);
        $datetime=date("Y-m-d H:i:s");
        $query="insert into al_finance_log values ('".$datetime."',".$al_id.",6,".userid($_COOKIE["user"]).",".$_POST["user"].",".$transfer.")";
        $db_theend->query($query);
      }
      }

    }

    $query="select id, cost, gold from alliances where id=".$al_name;
    $db_theend->query($query);
    $db_theend->next_record();
    $idal=$db_theend->Record["id"];
    $cost=$db_theend->Record["cost"];
    $gold=$db_theend->Record["gold"];
    
    if($grade==1)
    {
    echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
    echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\"></input>";
    echo "<input type=\"hidden\" name=\"subopt\" value=\"cost\"></input>";
    echo "<input type=\"hidden\" name=\"act\" value=\"update\"></input>";    
    
    echo "<div class=\"section\">";
    echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
    echo "<tr>";
    echo "<td class=\"almc1\" colspan=\"4\">";
    if($site_language=="ro")
      echo "TAXE";
    else
      echo "TAXE";
    echo "</td>";
    echo "</tr>";
	echo "<tr>";
	echo "<td class=\"almc2\">";
    if($site_language=="ro")
      echo "Taxa intrare:";
    else
      echo "Joining cost:";
    echo "</td>";
    echo "<td class=\"almc3\">";  
    echo "<input type=\"text\" name=\"cost\" class=\"input5\" size=\"10\"></input>";
	echo "</td>";
	echo "<td class=\"almc4\">";
    if($site_language=="ro")
      echo "<input type=\"submit\" class=\"submit4\" value=\"Actualizeaza\"></input>";
    else
      echo "<input type=\"submit\" class=\"submit4\" value=\"Update\"></input>";
    echo "</td>";
    echo "<td class=\"almc5\">";  
    if($site_language=="ro")
      echo "*Taxa de intrare curenta este de: ".number_format($cost)." EKR.";
    else
      echo "*Current joining cost is set to: ".number_format($cost)." EKR.";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "</form>";
    }    

    echo "<br>";
    
    echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
    echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\"></input>";
    echo "<input type=\"hidden\" name=\"subopt\" value=\"cost\"></input>";
    echo "<input type=\"hidden\" name=\"act\" value=\"transfer\"></input>";    
    
    echo "<div class=\"section\">";
    echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
	echo "<tr>";
	echo "<td class=\"almc1\" colspan=\"4\">";
    if($_COOKIE["lang"]=="en")
      echo "GOLD TRANSFERS";
    else
      echo "TRANSFER AUR";
    echo "</td>";
    echo "</tr>";
	echo "<tr>";
	echo "<td class=\"almc2\">";
	if($site_language=="ro")
	{
		echo "Seif alianta:";
	}
	else 
	{
		echo "Alliance's safe:";
	}
	echo "</td>";
	echo "<td class=\"almc3\">";
	echo number_format($gold)." EKR";
	echo "</td>";	
	echo "<td class=\"almc4\">";
	if($site_language=="ro")
	  echo "Trasfera EKR catre:";
	else 
	  echo "Transfer EKR to:";
	echo "</td>";
	echo "<td class=\"almc5\">";
    $query="select users.username, users.id from users, alliance_members where alliance_members.id_al=".$idal." and alliance_members.grade>=0 and alliance_members.id_member=users.id order by users.username";
    $db_theend->query($query);
	echo "<select class=\"select1\" name=\"user\">";
    while($db_theend->next_record())
    {
         echo "<option class=\"option1\" value=\"".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</option>";
    }
    echo "</select>";	
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td class=\"almc2\">";
	if($site_language=="ro")
	{
		echo "Capacitatea seifului:";
	}
	else 
	{
		echo "Safe capacity:";
	}
	echo "</td>";
	echo "<td class=\"almc3\">";
    $query="select count(id_member) as members from alliance_members where id_al=".$idal." and grade>=0";
    $db_theend->query($query);
    $db_theend->next_record();	
	echo number_format($db_theend->Record["members"]*10000000)." EKR";
	echo "</td>";	
	echo "<td class=\"almc4\">";
	if($site_language=="ro")
	  echo "Suma de EKR:";
	else 
	  echo "Amount of EKR:";  
	echo "</td>";
	echo "<td class=\"almc5\">";
	echo "<input class=\"input5\" type=\"text\" name=\"gold\" size=\"10\"></input>";
	echo "</td>";
	echo "</tr>";	
	echo "<tr>";
	echo "<td class=\"almc6\" colspan=\"4\">";
	if($site_language=="ro")
	  echo "<input class=\"submit4\" type=\"submit\" value=\"Transfera\"></input>";
	else 
	  echo "<input class=\"submit4\" type=\"submit\" value=\"Transfer\"></input>";
	echo "<br />";
    if($transfer_error)
    {
      echo "<font color=\"#FF0000\"><b>ERROR: ".$transfer_error."</font></b>";
      echo "<br />";
    }	
	if($site_language=="ro")
	{
		echo "* Este posibil doar un transfer pe saptamana catre acelasi jucator.";
	}
	else 
	{
		echo "* Only one transfer per week is allowed for the same user.";
	}
	echo "</td>";
	echo "</tr>";
    echo "</table>";
    echo "</div>";

    echo "</form>";

    echo "<br>";
    
    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\">";    

  echo "<font color=\"#FFA500\">";
  if($_COOKIE["lang"]=="en")
    echo "<b>FINANCIAL LOGS</b>";
  else
    echo "<b>ISTORIC FINANCIAR</b>";
  echo "</font>";
    
  echo "<br>";

  echo "<div align=\"center\">";
  
  echo "<span id=\"alliance_safe_deposit_logs_button_span\">";
  if($_COOKIE["lang"]=="en")
    echo "<input class=\"submit4\" type=\"button\" onClick=\"allianceSafeLogs(".$idal.",'deposit'); showhide('alliance_safe_deposit_logs_table'); hide('alliance_safe_transfer_logs_table');\" value=\"View Deposit Logs\"></input>";
  else
    echo "<input class=\"submit4\" type=\"button\" onClick=\"allianceSafeLogs(".$idal.",'deposit'); showhide('alliance_safe_deposit_logs_table'); hide('alliance_safe_transfer_logs_table');\" value=\"Vezi istoric depozite\"></input>";
  echo "</span>";
  
  echo " ";

  echo "<span id=\"alliance_safe_transfer_logs_button_span\">";
  if($_COOKIE["lang"]=="en")
    echo "<input class=\"submit4\" type=\"button\" onClick=\"allianceSafeLogs(".$idal.",'transfer'); showhide('alliance_safe_transfer_logs_table'); hide('alliance_safe_deposit_logs_table');\" value=\"View Transfer Logs\"></input>";
  else
    echo "<input class=\"submit4\" type=\"button\" onClick=\"allianceSafeLogs(".$idal.",'transfer'); showhide('alliance_safe_transfer_logs_table'); hide('alliance_safe_deposit_logs_table');\" value=\"Vezi istoric transferuri\"></input>";
  echo "</span>";
    
  echo "<br>";

  echo "<div id=\"alliance_safe_deposit_logs_table\" style=\"display: none;\">";
  echo "<span id=\"alliance_safe_deposit_logs_span\"></span>";
  echo "</div>";   
  
  echo "<div id=\"alliance_safe_transfer_logs_table\" style=\"display: none;\">";
  echo "<span id=\"alliance_safe_transfer_logs_span\"></span>";
  echo "</div>";
  
  echo "</div>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";

  } //if($_POST["subopt"]=='cost')

  if($_POST["subopt"]=='personalize')
  {

  	$id_al=$al_name;
  	
  if($grade==1)
  {  	
  	
  if($_POST["do"]=="change_message")
  {
    $message=sql_quote($_POST["message"]);

    $query="update alliances set message='".$message."' where id=".$id_al;
    $db->query($query);
  }

  if($_POST["do"]=="deleteimage")
  {
    $query="select avatar from alliances where id=".$id_al;
    $db->query($query);
    $db->next_record();
    if($db->Record["avatar"])
    {
      unlink($db->Record["avatar"]);
    }
    $query="update alliances set avatar='' where id=".$id_al;
    $db->query($query);
  }  
  
  if($_POST["MAX_FILE_SIZE"])
  {
    $uploaddir="pics/avatars";
    $uploadfile=$uploaddir."/avatar_alliance_".$id_al;

    $number=random_number(1,9999);

    $uploadfile=$uploadfile."_".$number;
    
    $valid_pic=1;

    if(move_uploaded_file($_FILES['avatar']['tmp_name'],$uploadfile))
    {
      $result_array = getimagesize($uploadfile);
      if($result_array)
      {
        $mime_type=$result_array['mime'];

        switch ($mime_type)
        {
          case "image/jpeg":
            /*echo "Tipul fisierului este 'jpeg'";*/
            rename($uploadfile,$uploadfile.".jpg");
            $uploadfile.=".jpg";
            break;
          case "image/gif":
            /*echo "Tipul fisierului este 'gif'";*/
            rename($uploadfile,$uploadfile.".gif");
            $uploadfile.=".gif";
            break;
          case "image/bmp":
            /*echo "Tipul fisierului este 'bmp'";*/
            rename($uploadfile,$uploadfile.".bmp");
            $uploadfile.=".bmp";
            break;
          case "image/png":
            /*echo "Tipul fisierului este 'png'";*/
            rename($uploadfile,$uploadfile.".png");
            $uploadfile.=".png";
            break;
          default:
            unlink($uploadfile);
            $uploadfile="";
            if($site_language=="en")
              echo "\n<script>alert('The uploaded file is not in the sepecified format.\\n Please follow those specifications.');</script>";
            else 
              echo "\n<script>alert('Fisierul upload-at nu este in formatul specificat.\\n Va rugam respectati specificatiile.');</script>";  
        }//switch

        $width = $result_array[0];
        $height = $result_array[1];
        if (($width>120)||($height>120))
        {
          $valid_pic=0;
          if($site_language=="en")
            echo "\n<script>alert('The uploaded image is over 120 x 120 pixels (width, height) and will not be used as your avatar.');</script>";
          else 
            echo "\n<script>alert('Imaginea upload-ata depaseste dimensiunile 120 x 120 pixeli (latime, inaltime) si nu va fi folosita ca avatar.');</script>";  
        }
      }
    }
    else
    {
      if($site_language=="en")
    	echo "\n<script>alert('Internal error (code ".$_FILES['avatar']['error'].").\\nPlease announce the administrators.');</script>";
      else 
        echo "\n<script>alert('Eroare interna (cod ".$_FILES['avatar']['error'].").\\nVa rugam anuntati administratorul.');</script>";
      $valid_pic=0;
    }

    if ($valid_pic==1)
    {
      $query="select avatar from alliances where id=".$id_al;
      $db->query($query);
      $db->next_record();
      if($db->Record["avatar"])
      {
        //echo "unlink(".$db->Record["avatar"].")";
        unlink($db->Record["avatar"]);
      }

      $avatar=$uploadfile;
    }
    else
      $avatar="";

    $query="update alliances set avatar='".$avatar."' where id=".$id_al;
    $db->query($query);
  }  
  
  $query="select commander, message, avatar from alliances where id=".$id_al;
  $db->query($query);
  $db->next_record();  
  $alrace=userrace(userid($db->Record["commander"]));
  
  echo "<div class=\"section\">";
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">"; 
  echo "<tr>";
  echo "<td class=\"almpers1\">";
  if($site_language=="en")
    echo "Alliance's message:";
  else 
    echo "Mesajul aliantei:";  
  echo "<div style=\"margin: 20px; text-align: left; color: #FFA500;\">";
  echo $db->Record["message"];
  echo "</div>";
  echo "</td>"; 
  echo "<td class=\"almpers2\" rowspan=\"2\">";
  if($db->Record["avatar"])
  {
    echo "<img class=\"avatar\" src=\"".$db->Record["avatar"]."\"></img>";
  }
  else
  {
    echo "<img class=\"avatar\" src=\"pics/avatars/".$alrace."s.jpg\"></img>";
  }
    echo "<br />"; 
    
    if($db->Record["avatar"])
    {
      echo "<form id=\"form_delete_image\" name=\"form_delete_image\" action=\"play.php\" method=\"POST\">";
      echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
      echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
      echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\"></input>";
      echo "<input type=\"hidden\" name=\"subopt\" value=\"personalize\"></input>";
      echo "<input type=\"hidden\" name=\"do\" value=\"deleteimage\"></input>";
      echo "</form>";
      if($site_language=="en")
       echo "<a class=\"light_blue\" style=\"cursor: pointer; cursor: hand;\" onclick=\"form_delete_image.submit();\">[delete image]</a>";
      else   
       echo "<a class=\"light_blue\" style=\"cursor: pointer; cursor: hand;\" onclick=\"form_delete_image.submit();\">[sterge imaginea]</a>";
      echo "<br />";  
    }    
     
    echo "<br />";
     
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "Change picture: ";
  else 
    echo "Schimba imaginea: ";  
  echo "</p>";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "<font color=\"#909090\">Max. file size: 100.000 bytes, 120 x 120 pixels.<br />File type: jpg, gif, bmp, png</font>";
  else 
    echo "<font color=\"#909090\">Dimensiuni max. fisier: 100.000 bytes, 120 x 120 pixels.<br />Tip fisier: jpg, gif, bmp, png</font>";  
  echo "</p>"; 
    echo "<form enctype=\"multipart/form-data\" action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000\"></input>";
    echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
    echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\"></input>";
    echo "<input type=\"hidden\" name=\"subopt\" value=\"personalize\"></input>";
    echo "<p class=\"bigline\">";
    echo "<input class=\"submit4\" name=\"avatar\" type=\"file\"></input>";
    echo "</p>";
    echo "<p class=\"bigline\">";
    echo "<input class=\"submit4\" type=\"submit\" value=\"Upload\"></input>";
    echo "</p>";
    echo "</form>";   
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almpers3\">";
    if($site_language=="en")
      echo "Change message:";
    else 
      echo "Schimba mesaj:";  
    echo "<div style=\"margin: 10px; text-align: center;\">";
    echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
    echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\"></input>";
    echo "<input type=\"hidden\" name=\"subopt\" value=\"personalize\"></input>";
    echo "<input type=\"hidden\" name=\"do\" value=\"change_message\"></input>";
    echo "<textarea class=\"al_message\" name=\"message\" rows=\"5\"></textarea>";
    echo "<p class=\"bigline\">";
    if($site_language=="en")
      echo "<input class=\"submit4\" type=\"submit\" value=\"Change\"></input>";
    else 
      echo "<input class=\"submit4\" type=\"submit\" value=\"Schimba\"></input>";  
    echo "</p>";
    echo "</form>";  
    echo "</div>";
  echo "</td>";  
  echo "</tr>";
  echo "</table>";
  echo "</div>";
  }
  else 
  {
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  if($site_language=="en")
    echo "Only the commander has access to this option.";
  else 
    echo "Numai comandantul are acces la aceasta optiune.";

  echo "</div>";
  echo "</div>";
  echo "</div>";  	
  }
  
  }
  
  if($_POST["subopt"]=='chcom')
  {

  	$id_al=$al_name;
  	
  	if($_POST["do"]=="changecommander" && $_POST["commander"])
    {
    	$query="update alliances set commander=(select username from users where id=".$_POST["commander"].") where id=".$id_al;
    	$db->query($query);
    	$query="update alliance_members set grade=2 where id_al=".$id_al." and grade=1";
    	$db->query($query);
    	$query="update alliance_members set grade=1 where id_member=".$_POST["commander"];
    	$db->query($query);
    	$grade=2;
    }
  	
  if($grade==1)
  {
  	
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"chcom\" />";
  echo "<input type=\"hidden\" name=\"do\" value=\"changecommander\"></input>";  
  
  if($site_language=="en")
    echo "Change alliance's commander to: ";
  else 
    echo "Schimba comandantul aliantei: ";  
  echo "<select class=\"select1\" name=\"commander\">";
  if($site_language=="en")
    echo "<option class=\"option1\" value=\"\" selected=\"selected\">Choose new commander</option>";
  else 
    echo "<option class=\"option1\" value=\"\" selected=\"selected\">Alege noul comandant</option>";  
  
  $query="select users.id, users.username from users, alliance_members where alliance_members.id_al=".$id_al." and alliance_members.grade=2 and alliance_members.id_member=users.id";
  $db->query($query); 
  while($db->next_record())
  {
   echo "<option class=\"option1\" value=\"".$db->Record["id"]."\">".$db->Record["username"]."</option>";
  }
  echo "</select>";
  if($site_language=="en")
    echo " <input class=\"submit4\" type=\"submit\" value=\"Change\" />";
  else   
    echo " <input class=\"submit4\" type=\"submit\" value=\"Schimba\" />";
  echo "</form>";
  echo "<br />";
  echo "<img src=\"pics/warned.gif\" alt=\"warning\"/> ";
  echo "<font color=\"#A0A0A0\">";
  if($site_language=="en")
    echo "If you change the commander you will become officer of this alliance and you can become commander again only if the new one will make that change.";
  else 
    echo "Daca schimbi comandantul vei deveni ofiter al acestei aliante si nu vei mai putea fi comandant decat daca noul comandant va face aceasta schimbare.";
  echo "</font>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  }
  else 
  {
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  if($site_language=="en")
    echo "Only the commander has access to this option.";
  else 
    echo "Numai comandantul are acces la aceasta optiune.";

  echo "</div>";
  echo "</div>";
  echo "</div>";  	
  }
  }  
}

function alliance_mail()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();
  
  $alname=useralliancename2($_COOKIE["uid"]);

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "ALLIANCE MAIL";
  else 
    echo "MESAJ ALIANTA";  
  echo "</div>";
  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";

  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "Send mail to all alliance members:";
  else 
    echo "Trimite mesaj catre toti membri aliantei:";  
  echo "</p>";

  echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"sendalliancemail\"></input>";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$alname."\"></input>";
  echo "<p class=\"bigline\">";
  echo "<textarea class=\"mail\" rows=\"15\" cols=\"100\" name=\"message\"></textarea><br>";
  echo "</p>";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Send Mail\"></input>";
  else 
    echo "<input class=\"submit4\" type=\"submit\" value=\"Trimite mesajul\"></input>";  
  echo "</form>";
  
  echo " ";
  
  echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Cancel\"></input>";
  else 
    echo "<input class=\"submit4\" type=\"submit\" value=\"Anuleaza\"></input>";  
  echo "</form>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

function sendalliancemail()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db2 = new DataBase_theend;
  $db2->connect();

  if($_COOKIE["lang"]=="en") $ppath="pics/en/";
  else $ppath="pics/";

  $alname=useralliancename2($_COOKIE["uid"]);
  $alid=useralliance2($_COOKIE["uid"]);

  echo "<table cellspacing=\"0\" cellpadding=\"0\" height=\"2\" width=\"470\"><tr><td></td></tr></table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\">";
  echo "<tr><td background=\"pics/redbigbar.gif\" align=\"center\" height=\"22\">";
  if($_COOKIE["lang"]=="en")
    echo "<b>ALLIANCES</b>";
  else
    echo "<b>ALIANTE</b>";
  echo "</td></tr>";
  echo "</table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" height=\"4\" width=\"470\"><tr><td></td></tr></table>";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"470\">";
  echo "<tr><td width=\"470\" align=\"center\">";

  echo "<br>";

  $message=safechar($_POST["message"]);
  $message=$message."<br><br>*** This mail was sent by ".$_COOKIE["user"]." to all alliance members. Please report to the commander if you consider this spam.";
  $datetime=date("Y-m-d H:i:s");
  $from=$_COOKIE["uid"];

  $query="select id_member as touser from alliance_members where id_al=".$alid." and grade>=0";
  $db_theend->query($query);
  while($db_theend->next_record())
  {
    if($from!=$db_theend->Record["touser"])
    {
      $query2="insert into mail values(DEFAULT,'".$from."','".$db_theend->Record["touser"]."','".$datetime."','".$message."',1,'Message to your alliance')";
      $db2->query($query2);
      $query2="update users set newmail=newmail+1 where username='".$db_theend->Record["touser"]."'";
      $db2->query($query2);
    }
  }

  echo "Message sent.<br><br>";

  echo "<br>";

  echo "</td></tr>";
  echo "</table>";
}

function list_alliances($my_alliance_status)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  
  $site_language=site_language();

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "ALLIANCE LIST";
  else 
    echo "LISTA ALIANTELOR";  
  echo "</div>";
  echo "<br />";
  
  $query="select alliances.id, alliances.name, alliances.commander, alliances.createdon, alliances.cost, alliances.avatar, users.race, (select count(id_member) from alliance_members where alliance_members.id_al=alliances.id and alliance_members.grade>=0) as nrmem, (select sum(armory.rank_value) from armory, alliance_members, online where alliance_members.id_al=alliances.id and alliance_members.grade>=0 and alliance_members.id_member=armory.id and alliance_members.id_member=online.id and online.online>=0) as value from alliances, users where alliances.commander=users.username order by value desc, nrmem desc";
  $db_theend->query($query);
  $nr_inreg=$db_theend->num_rows();
  $nr_inreg_pag=30;
  if(!$_POST["page"] || $_POST["page"]<0 || $_POST["page"]>ceil($nr_inreg/$nr_inreg_pag)) $page=1;
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
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"listalliances\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
  		  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
  		  echo "<input type=\"hidden\" name=\"what\" value=\"listalliances\"></input>";
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
  		  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
  		  echo "<input type=\"hidden\" name=\"what\" value=\"listalliances\"></input>";
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

  $nr_inreg_cur=0;
  while($db_theend->next_record())
  {
     $nr_inreg_cur++;
     if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
     {
       echo "<tr>";

           echo "<td class=\"al1\">".$nr_inreg_cur."</td>";

           echo "<td class=\"al2\">";
           if($db_theend->Record["avatar"])
           {
             echo "<img class=\"small_avatar\" src=\"".$db_theend->Record["avatar"]."\" />";
           }
           else
           {
             echo "<img class=\"small_avatar\" src=\"pics/avatars/".$db_theend->Record["race"]."s.jpg\" />";
           }
           echo "</td>";
           echo "<td class=\"al3\">";
           echo "<form name=\"form_alliance_".$db_theend->Record["id"]."_details\" action=\"play.php\" method=\"POST\">";
           echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
           echo "<input type=\"hidden\" name=\"what\" value=\"details\"></input>";
           echo "<input type=\"hidden\" name=\"alname\" value=\"".$db_theend->Record["id"]."\"></input>";
           echo "</form>";
           echo "<div style=\"overflow:hidden;width:150px;\">";
           echo "<a class=\"".$db_theend->Record["race"]."\" href=\"#\" onClick=\"form_alliance_".$db_theend->Record["id"]."_details.submit();\">".$db_theend->Record["name"]."</a><br><font color=\"#A0A0A0\">Com. ".$db_theend->Record["commander"]."</font>";
           echo "</div>";
           echo "</td>";

       echo "<td class=\"al4\">".$db_theend->Record["nrmem"]." ";
       if($site_language=="en")
       {
         echo $db_theend->Record["race"];
         if($db_theend->Record["nrmem"]>1) echo "s";
       }
       else 
       {
       	 switch($db_theend->Record["race"])
       	 {
       	 	case "human":
       	 		if($db_theend->Record["nrmem"]>1) echo "oameni";
       	 		else echo "om";
       	 		break;	
       	 	case "machine":
       	 		if($db_theend->Record["nrmem"]>1) echo "masini";
       	 		else  echo "masina";
       	 		break;	
       	 	case "alien":
       	 		if($db_theend->Record["nrmem"]>1) echo "extraterestrii";
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
       echo $db_theend->Record["createdon"]."</td>";
       echo "</tr>";
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
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"listalliances\"></input>";
  echo " <input type=\"text\" class=\"input6\" name=\"page\" size=\"5\"></input> <input class=\"submit4\" type=\"submit\" value=\"OK\"></input></form>";
  echo "</div>";  
  
  echo "<div class=\"page_nav\">";
  if ($page-1)
  {
          echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
  		  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
  		  echo "<input type=\"hidden\" name=\"what\" value=\"listalliances\"></input>";
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
  		  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
  		  echo "<input type=\"hidden\" name=\"what\" value=\"listalliances\"></input>";
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

function alliance_details($alid,$my_alliance_status)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db = new DataBase_theend;
  $db->connect();
  $db2 = new DataBase_theend;
  $db2->connect();

  $site_language=site_language();

  $userrace=userrace($_COOKIE["uid"]);

  $query="select name, commander, createdon, id, cost, gold, max_members, avatar, message from alliances where id=".$alid;
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();

  $alname=$db_theend->Record["name"];
  $alrace=userrace(userid($db_theend->Record["commander"]));
  $al_max_members=$db_theend->Record["max_members"];

  if($db_theend->Record["commander"]==$_COOKIE["user"]) $my_alliance_status=1;

  echo "<div class=\"titlebar\">".$alname."</div>";
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
  echo "<tr><td align=\"center\" width=\"50%\" valign=\"top\">";

  echo "<br>";
  if($db_theend->Record["avatar"])
  {
    echo "<img class=\"avatar\" src=\"".$db_theend->Record["avatar"]."\"></img>";
  }
  else
  {
    echo "<img class=\"avatar\" src=\"pics/avatars/".$alrace."s.jpg\"></img>";
  }
  echo "<br /><br />";

  echo "<div style=\"overflow:hidden;width:160px;font-size:10px;line-height:12px;color:#F0F0F0;font-family:verdana,arial,sans-serif;font-weight:normal;text-decoration:none;\">";
  echo "<font color=\"#FFA500\">".$db_theend->Record["message"]."</font>";
  echo "</div>";
  echo "<br>";

  echo "</td><td align=\"center\" width=\"50%\">";

  echo "<table cellspacing=\"0\" width=\"100%\">";

  echo "<tr><td width=\"50%\" height=\"20\" align=\"right\"><font color=\"#A0A0A0\">";
  if($site_language=="en")
    echo "Commander:";
  else
    echo "Comandant:";
  echo "</font></td><td width=\"50%\">".$db_theend->Record["commander"]."</td></tr>";
  echo "<tr><td height=\"20\" align=\"right\"><font color=\"#A0A0A0\">";
  if($site_language=="en")
    echo "Created on:";
  else
    echo "Creata in:";
  echo "</font></td><td>".$db_theend->Record["createdon"]."</td></tr>";
  $query="select count(id_member) as nr_members from alliance_members where id_al=".$db_theend->Record["id"]." and grade>=0";
  $db2->query($query);
  $no_queries+=1;
  $db2->next_record();
  $al_members=$db2->Record["nr_members"];
  echo "<tr><td height=\"20\" align=\"right\"><font color=\"#A0A0A0\">";
  if($site_language=="en")
    echo "No. of members:";
  else
    echo "Nr. de membrii:";
  echo "</font></td><td>".$db2->Record["nr_members"]." / ".$db_theend->Record["max_members"]."</td></tr>";
  echo "<tr><td height=\"20\" align=\"right\"><font color=\"#A0A0A0\">";
  if($site_language=="en")
    echo "Join cost:";
  else
    echo "Taxa intrare:";
  echo "</font></td><td>".number_format($db_theend->Record["cost"])."</td></tr>";
  if($my_alliance_status>=1 && $my_alliance_status<=3)
  {
    echo "<form action=\"play.php\" name=\"alliance_safe\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\">";
    echo "<input type=\"hidden\" name=\"what\" value=\"safe\">";
    echo "<input type=\"hidden\" name=\"alliance\" value=\"".$db_theend->Record["id"]."\">";
    echo "</form>";

    echo "<tr><td height=\"20\" align=\"right\"><font color=\"#A0A0A0\">";
    if($site_language=="en")
      echo "Safe:";
    else
      echo "Seif:";
    echo "</font></td><td>".number_format($db_theend->Record["gold"])." EKR</td></tr>";
    if($site_language=="en")
      echo "<tr><td></td><td><a class=\"light_blue\" href=\"#\" onClick=\"document.alliance_safe.submit();\">[go to safe]</a>";
    else
      echo "<tr><td></td><td><a class=\"light_blue\" href=\"#\" onClick=\"document.alliance_safe.submit();\">[mergi la seif]</a>";
    echo "</td></tr>";
  }

    if($my_alliance_status==1)
    {
       echo "<tr><td colspan=\"2\" align=\"right\"><br>";
       echo "<table><tr><td>";
       echo "<form action=\"play.php\" method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
       echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
       echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
       if($site_language=="en")
         echo "<input class=\"submit4\" type=\"submit\" value=\"Administration\"></input>";
       else
         echo "<input class=\"submit4\" type=\"submit\" value=\"Administrare\"></input>";
       echo "</form>";
       echo "</td><td> </td><td>";
       echo "<form name=\"disband_form\" action=\"play.php\" method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
       echo "<input type=\"hidden\" name=\"what\" value=\"disband\"></input>";
       echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
       if($site_language=="en")
         echo "<input class=\"submit4\" type=\"button\" value=\"Disband Alliance\" onClick=\"confirm_disband_form();\"></input>";
       else
         echo "<input class=\"submit4\" type=\"button\" value=\"Desfiintare Alianta\" onClick=\"confirm_disband_form();\"></input>";
       echo "</form>";
       echo "</td></tr></table>";
       echo "</td></tr>";
    }
    if($my_alliance_status==3)
    {
       echo "<tr><td colspan=\"2\" align=\"right\"><br>";
       echo "<table><tr><td>";
       echo "<form action=\"play.php\" method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
       echo "<input type=\"hidden\" name=\"what\" value=\"manage\"></input>";
       echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
       if($site_language=="en")
         echo "<input class=\"submit4\" type=\"submit\" value=\"Administration\"></input>";
       else
         echo "<input class=\"submit4\" type=\"submit\" value=\"Administrare\"></input>";
       echo "</form>";
       echo "</td><td>";
       echo "<form name=\"form_leave_alliance_1\" action=play.php method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
       echo "<input type=\"hidden\" name=\"what\" value=\"leave\"></input>";
       echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
       if($site_language=="en")
         echo "<input class=\"submit4\" type=\"button\" value=\"Leave Alliance\" onClick=\"confirm_form_leave_alliance_1();\"></input>";
       else
         echo "<input class=\"submit4\" type=\"button\" value=\"Parasire Alianta\" onClick=\"confirm_form_leave_alliance_1();\"></input>";
       echo "</form>";
       echo "</td></tr></table></td></tr>";
    }
    if($my_alliance_status==2)
    {
       echo "<tr><td colspan=\"2\" align=\"right\"><br>";
       echo "<table><tr><td>";
       echo "<form action=play.php method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
       echo "<input type=\"hidden\" name=\"what\" value=\"users\"></input>";
       echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
       if($site_language=="en")
         echo "<input class=\"submit4\" type=\"submit\" value=\"Alliance Users\"></input>";
       else
         echo "<input class=\"submit4\" type=\"submit\" value=\"Membrii Alianta\"></input>";
       echo "</form>";
       echo "</td><td>";
       echo "<form name=\"form_leave_alliance_2\" action=\"play.php\" method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
       echo "<input type=\"hidden\" name=\"what\" value=\"leave\"></input>";
       echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
       if($site_language=="en")
         echo "<input class=\"submit4\" type=\"button\" value=\"Leave Alliance\" onClick=\"confirm_form_leave_alliance_2();\"></input>";
       else
         echo "<input class=\"submit4\" type=\"button\" value=\"Parasire Alianta\" onClick=\"confirm_form_leave_alliance_2();\"></input>";
       echo "</form>";
       echo "</td></tr></table></td></tr>";
    }
    if($my_alliance_status==0 && $userrace==$alrace && $al_members<$al_max_members)
    {
       $query="select alliance_members.grade, alliance_members.datetime from alliance_members, users where users.username='".$_COOKIE["user"]."' and users.id=alliance_members.id_member";
       $db_theend->query($query);
       if(!$db_theend->num_rows())
       {
         echo "<tr><td height=\"50\" colspan=\"2\" align=\"right\" valign=\"bottom\"><br>";
         echo "<table><tr><td>";
         echo "<form action=play.php method=\"POST\">";
         echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
         echo "<input type=\"hidden\" name=\"what\" value=\"join\"></input>";
         echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
         if($site_language=="en")
           echo "<input class=\"submit4\" type=\"submit\" value=\"Join Alliance\"></input>";
         else
           echo "<input class=\"submit4\" type=\"submit\" value=\"Intrare in Alianta\"></input>";
         echo "</form>";
         echo "</td><td>";
         echo "</td></tr></table></td></tr>";
       }
       else
       {
         $db_theend->next_record();
         if($db_theend->Record["grade"]==-2 && time()-strtotime($db_theend->Record["datetime"])>2*24*3600)
         {
            // a fost membru al unei aliante dar a parasit acea alianta cu cel putin 2 zile in urma
            // poate intra in alta alianta
            echo "<tr><td height=\"50\" colspan=\"2\" align=\"right\" valign=\"bottom\"><br>";
            echo "<table><tr><td>";
            echo "<form action=play.php method=\"POST\">";
            echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
            echo "<input type=\"hidden\" name=\"what\" value=\"join\"></input>";
            echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
            if($site_language=="en")
              echo "<input class=\"submit4\" type=\"submit\" value=\"Join Alliance\"></input>";
            else
              echo "<input class=\"submit4\" type=\"submit\" value=\"Intrare in Alianta\"></input>";
            echo "</form>";
            echo "</td><td>";
            echo "</td></tr></table></td></tr>";
         }
       }
    }

    if($my_alliance_status==5 && $al_members<$al_max_members)
    {
       $query="select alliance_members.grade, alliance_members.datetime from alliance_members, users where users.username='".$_COOKIE["user"]."' and users.id=alliance_members.id_member";
       $db_theend->query($query);
       if(!$db_theend->num_rows())
       {
         echo "<tr><td height=\"50\" colspan=\"2\" align=\"right\" valign=\"bottom\"><br>";
         echo "<table><tr><td>";
         echo "<form action=play.php method=\"POST\">";
         echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
         echo "<input type=\"hidden\" name=\"what\" value=\"join\"></input>";
         echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
         if($site_language=="en")
           echo "<input class=\"submit4\" type=\"submit\" value=\"Join Alliance\"></input>";
         else
           echo "<input class=\"submit4\" type=\"submit\" value=\"Intrare in Alianta\"></input>";
         echo "</form>";
         echo "</td><td>";
         echo "</td></tr></table></td></tr>";
       }
       else
       {
         $db_theend->next_record();
         if($db_theend->Record["grade"]==-2 && time()-strtotime($db_theend->Record["datetime"])>2*24*3600)
         {
            // a fost membru al unei aliante dar a parasit acea alianta cu cel putin 7 zile in urma
            // poate intra in alta alianta
            echo "<tr><td height=\"50\" colspan=\"2\" align=\"right\" valign=\"bottom\"><br>";
            echo "<table><tr><td>";
            echo "<form action=play.php method=\"POST\">";
            echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
            echo "<input type=\"hidden\" name=\"what\" value=\"join\"></input>";
            echo "<input type=\"hidden\" name=\"alname\" value=\"".$alid."\"></input>";
            if($site_language=="en")
              echo "<input class=\"submit4\" type=\"submit\" value=\"Join Alliance\"></input>";
            else
              echo "<input class=\"submit4\" type=\"submit\" value=\"Intrare in Alianta\"></input>";
            echo "</form>";
            echo "</td><td>";
            echo "</td></tr></table></td></tr>";
         }
       }
    }

  echo "</table>";

  echo "</td></tr>";

  echo "</table>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  echo "<br />";
  
  echo "<div class=\"titlebar\">ALLIANCE MEMBERS</div>";
  echo "<br />";
  
  echo "<div class=\"section\">";

  $my_spy_power=power_spy($_COOKIE["uid"]);

  $query="select users.id, users.username, users.race, alliance_members.grade, armory.rank, armory.units, armory.antispy, armory.level, armory.exp, armory.gold, upgrades.antispy as sentrylevel, online.online, seif.gold as safe, mastery.battle, mastery.battle_win from users, alliances, alliance_members, armory, upgrades, online, seif, mastery where alliances.id=".$alid." and alliances.id=alliance_members.id_al and alliance_members.grade>=0 and alliance_members.id_member=users.id and alliance_members.id_member=armory.id and alliance_members.id_member=upgrades.id and alliance_members.id_member=online.id and alliance_members.id_member=seif.uid and alliance_members.id_member=mastery.id order by armory.rank=0, armory.rank";
  $db2->query($query);
  $no_queries+=1;
  echo "<table class=\"table1\" cellspacing=\"1\" celpadding=\"0\">";
  while($db2->next_record())
  {
    $sentry_power=power_sentry($db2->Record["id"]);

    if($db2->Record["grade"]==1)
    {
       echo "<tr>";
       echo "<td class=\"at1\">";
       if($db2->Record["rank"]>0)
         echo $db2->Record["rank"];
       else
         echo "-";
       echo "</td>";
       echo "<td class=\"at2\">";
       echo "<a class=\"".$db2->Record["race"]."\" href=\"user_profile.php?uid=".$db2->Record["id"]."\">".$db2->Record["username"]."</a>";
       echo "<br />";
       echo "<font color=\"#FFA500\">";
       if($site_language=="en")
         echo "Commander";
       else 
         echo "Comandant";  
       echo "</font>";
       echo "</td>";
       echo "<td class=\"at3\">";
       if($db2->Record["battle"]<100)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]<50)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=90)
         echo "<img src=\"pics/5stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=80)
         echo "<img src=\"pics/4stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=70)
         echo "<img src=\"pics/3stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=60)
         echo "<img src=\"pics/2stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=50)
         echo "<img src=\"pics/1stars.gif\">";
       echo "</td>";
       echo "<td class=\"at4\">".number_format($db2->Record["units"])." ".$db2->Record["race"]."s<br><font color=\"#909090\" style=\"font-size: 7pt;\">level ".$db2->Record["level"]." (".number_format($db2->Record["exp"])." exp)</font></td>";
       echo "<td class=\"at5\">";
       if($my_spy_power>$sentry_power*2 || $db2->Record["id"]==$_COOKIE["uid"])
         echo number_format($db2->Record["gold"]+$db2->Record["safe"]);
       else
         echo "???";
       echo " EKR</td>";
       echo "<td class=\"at6\">";
       if($db2->Record["online"]==1)
       {
         echo "<img src=\"pics/online.gif\"></img>";
       }
       if($db2->Record["online"]==0)
       {
         echo "<img src=\"pics/offline.gif\"></img>";
       }
       if($db2->Record["online"]==-1)
       {
         echo "<img src=\"pics/inactive.gif\"></img>";
       }
       echo "</td></tr>";
    }
    if($db2->Record["grade"]==2)
    {
       echo "<tr>";
       echo "<td class=\"at1\">";
       if($db2->Record["rank"]>0)
         echo $db2->Record["rank"];
       else
         echo "-";
       echo "</td>";
       echo "<td class=\"at2\">";
       echo "<a class=\"".$db2->Record["race"]."\" href=\"user_profile.php?uid=".$db2->Record["id"]."\">".$db2->Record["username"]."</a>";
       echo "<br />";
       if($site_language=="en")
         echo "<font color=\"#FFD700\">Officer</font>";
       else 
         echo "<font color=\"#FFD700\">Ofiter</font>";  
       echo "</td>";
       echo "<td class=\"at3\">";
       if($db2->Record["battle"]<100)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]<50)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=90)
         echo "<img src=\"pics/5stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=80)
         echo "<img src=\"pics/4stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=70)
         echo "<img src=\"pics/3stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=60)
         echo "<img src=\"pics/2stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=50)
         echo "<img src=\"pics/1stars.gif\">";
       echo "</td>";
       echo "<td class=\"at4\">".number_format($db2->Record["units"])." ".$db2->Record["race"]."s<br><font color=\"#909090\" style=\"font-size: 7pt;\">level ".$db2->Record["level"]." (".number_format($db2->Record["exp"])." exp)</font></td>";
       echo "<td class=\"at5\">";
       if($my_spy_power>$sentry_power*2 || $db2->Record["id"]==$_COOKIE["uid"])
         echo number_format($db2->Record["gold"]+$db2->Record["safe"]);
       else
         echo "???";
       echo " EKR</td>";
       echo "<td class=\"at6\">";
       if($db2->Record["online"]==1)
       {
         echo "<img src=\"pics/online.gif\"></img>";
       }
       if($db2->Record["online"]==0)
       {
         echo "<img src=\"pics/offline.gif\"></img>";
       }
       if($db2->Record["online"]==-1)
       {
         echo "<img src=\"pics/inactive.gif\"></img>";
       }
       echo "</td></tr>";
    }
    if($db2->Record["grade"]==0)
    {
       echo "<tr>";
       echo "<td class=\"at1\">";
       if($db2->Record["rank"]>0)
         echo $db2->Record["rank"];
       else
         echo "-";
       echo "</td>";
       echo "<td class=\"at2\">";
       echo "<a class=\"".$db2->Record["race"]."\" href=\"user_profile.php?uid=".$db2->Record["id"]."\">".$db2->Record["username"]."</a>";
       echo "<br />";
       echo "<font color=\"#909090\">";
       if($site_language=="en")
         echo "Member";
       else 
         echo "Membru";  
       echo "</font></div>";
       echo "</td>";
       echo "<td class=\"at3\">";
       if($db2->Record["battle"]<100)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]<50)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=90)
         echo "<img src=\"pics/5stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=80)
         echo "<img src=\"pics/4stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=70)
         echo "<img src=\"pics/3stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=60)
         echo "<img src=\"pics/2stars.gif\">";
       else
       if($db2->Record["battle"]>=100 && ($db2->Record["battle_win"]*100)/$db2->Record["battle"]>=50)
         echo "<img src=\"pics/1stars.gif\">";
       echo "</td>";
       echo "<td class=\"at4\">".number_format($db2->Record["units"])." ".$db2->Record["race"]."s<br><font color=\"#909090\" style=\"font-size: 7pt;\">level ".$db2->Record["level"]." (".number_format($db2->Record["exp"])." exp)</font></td>";
       echo "<td class=\"at5\">";
       if($my_spy_power>$sentry_power*2 || $db2->Record["id"]==$_COOKIE["uid"])
         echo number_format($db2->Record["gold"]+$db2->Record["safe"]);
       else
         echo "???";
       echo " EKR</td>";
       echo "<td class=\"at6\">";
       if($db2->Record["online"]==1)
       {
         echo "<img src=\"pics/online.gif\"></img>";
       }
       if($db2->Record["online"]==0)
       {
         echo "<img src=\"pics/offline.gif\"></img>";
       }
       if($db2->Record["online"]==-1)
       {
         echo "<img src=\"pics/inactive.gif\"></img>";
       }
       echo "</td></tr>";
    }
  }
  echo "</table>";
  
  echo "</div>";
}

function join_alliance($alname,$user)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  if($_COOKIE["lang"]=="en") $ppath="pics/en/";
  else $ppath="pics/";

  $userrace=userrace($user);

  $query="select id, name, commander, cost from alliances where id=".$alname;
  $db_theend->query($query);
  $db_theend->next_record();
  $al_name=$db_theend->Record["name"];
  $commander=$db_theend->Record["commander"];
  $id_al=$db_theend->Record["id"];
  $cost=$db_theend->Record["cost"];

  $query="select users.username, armory.gold, armory.id from armory, users where armory.id=users.id and users.id=".$user;
  $db_theend->query($query);
  $db_theend->next_record();
  $username=$db_theend->Record["username"];
  $gold=$db_theend->Record["gold"];
  $uid=$db_theend->Record["id"];

  if($gold>=$cost)
  {

  $from=$user;
  $to=userid($commander);
  switch($userrace)
  {
  case "human":
    $message="User ".$username." would like to join your alliance.\n Please check your alliance\'s waiting list.";
    break;
  case "machine":
    $message="User ".$username." would like to join your alliance.\n Please check your alliance\'s waiting list";
    break;
  case "alien":
    $message="User ".$username." would like to join your alliance.\n Please check your alliance\'s waiting list";
    break;
  }

  $datetime=date("Y-m-d H:i:s");

  $gold=$gold-$cost;
  if($gold<0) $gold=0;

  $query="update armory set gold=".$gold." where id=".$uid;
  $db_theend->query($query);

  $query="select grade from alliance_members where id_member=".$uid;
  $db_theend->query($query);
  if($db_theend->num_rows())
  {
    $query="update alliance_members set grade=-1, id_al=".$id_al.", datetime='".$datetime."', gold=".$cost." where id_member=".$uid;
    $db_theend->query($query);
  }
  else
  {
    $query="insert into alliance_members values(".$id_al.",".$uid.",-1,'".$datetime."',".$cost.")";
    $db_theend->query($query);
  }

  $query="insert into mail values(DEFAULT,".$from.",".$to.",'".$datetime."','".$message."',1,'Alliance request')";
  $db_theend->query($query);

  $query="update users set newmail=newmail+1 where id='".$to."'";
  $db_theend->query($query);

  echo "<font color=\"#909090\">A mail has be sent to the commander of alliance \"<b>".$al_name."\"</b>.<br>Hopefully he will answer you in short time.</font><br><br>";

  }
  else
  {
    echo "<font color=\"#909090\">You do not have enoght gold to join alliance \"<b>".$al_name."\"</b>.<br><br>";
  }
}

function create_alliance($alname)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  if($_COOKIE["lang"]=="en") $ppath="pics/en/";
  else $ppath="pics/";

  $alname=trim($alname);
  if(!alphanum_field($alname) || strlen($alname)<3 || strlen($alname)>50)
  {
    echo "Alliance name must be between 3 and 50 chars and contain only alphanumeric characters!";
  }
  else
  {
  $query="select name from alliances where name='".$alname."'";
  $db_theend->query($query);
  if($db_theend->num_rows())
  {
    echo "Alliance named ".$alname." already exists!";
  }
  else
  {
    $query="select name from alliances where commander='".$_COOKIE["user"]."'";
    $db_theend->query($query);
    if($db_theend->num_rows())
    {
      $db_theend->next_record();
      echo "You are allready commander of aliance ".$db_theend->Record["name"].". You cannot create a new alliance!";
    }
    else
    {
      $query="select alliances.name from alliances, alliance_members, users where users.username='".$_COOKIE["user"]."' and users.id=alliance_members.id_member and alliance_members.grade>=0 and alliance_members.id_al=alliances.id";
      $db_theend->query($query);
      if($db_theend->num_rows())
      {
        $db_theend->next_record();
        echo "You are a member of aliance ".$db_theend->Record["name"].". You cannot create an alliance!";
      }
      else
      {
        $query="select users.id, armory.gold from users, armory where users.id=".$_COOKIE["uid"]." and users.id=armory.id";
        $db_theend->query($query);
        $db_theend->next_record();
        $uid=$db_theend->Record["id"];
        $ugold=$db_theend->Record["gold"];
        if($ugold<100000) echo "Not enogh gold!";
        else
        {
          $datetime=date("Y-m-d H:i:s");

          $query="insert into alliances values(DEFAULT,'".$alname."','".$_COOKIE["user"]."','".date("Y-m-d")."',10000,100000,10,DEFAULT,DEFAULT)";
          $db_theend->query($query);
          $query="select LAST_INSERT_ID() as id from alliances";
          $db_theend->query($query);
          $db_theend->next_record();
          $id=$db_theend->Record["id"];
          $query="select id_member from alliance_members where id_member=".$uid;
          $db_theend->query($query);
          if($db_theend->num_rows())
          {
            $query="update alliance_members set id_al=".$id.", grade=1, datetime='".$datetime."', gold=0 where id_member=".$uid;
            $db_theend->query($query);
          }
          else
          {
            $query="insert into alliance_members values(".$id.",".$uid.",1,'".$datetime."',0)";
            $db_theend->query($query);
          }
          $query="update armory set gold=gold-100000 where id=".$uid;
          $db_theend->query($query);
        }
      }
    }
  }
  }
}

function leave_alliance($user,$idal)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $id_member=$user;
  $id_al=$idal;
  $query="update alliance_members set grade=-2, datetime='".date("Y-m-d H:i:s")."' where id_al=".$id_al." and id_member=".$id_member;
  $db_theend->query($query);
  
  $username=username($id_member);
  $message="User ".$username." left your alliance.\n";
  
  $query="select id_member from alliance_members where id_al=".$id_al." and grade=1";
  $db_theend->query($query);
  $db_theend->next_record();
  
  $from=$id_member;
  $to=$db_theend->Record["id_member"];
  $datetime=date("Y-m-d H:i:s");
  
  $query="insert into mail values(DEFAULT,".$from.",".$to.",'".$datetime."','".$message."',1,'User left your alliance')";
  $db_theend->query($query);

  $query="update users set newmail=newmail+1 where id='".$to."'";
  $db_theend->query($query);  
}

function disband_alliance($alname)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="delete from alliance_members where id_al=".$alname." and grade=-1";
  $db_theend->query($query);
  $query="update alliance_members set grade=-2, datetime='".date("Y-m-d H:i:s")."' where id_al=".$alname." and grade>=0";
  $db_theend->query($query);
  $query="delete from alliances where id=".$alname;
  $db_theend->query($query);
}

function alliance_users($al_name)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "ALLIANCE MEMBERS";
  else 
    echo "MEMBRI ALIANTA";  
  echo "</div>";
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $query="select users.username, users.id, users.race, armory.level, armory.exp, online.datetime, alliance_members.grade from users, alliances, alliance_members, armory, online where alliances.id=".$al_name." and alliances.id=alliance_members.id_al and alliance_members.id_member=users.id and users.id=armory.id and users.id=online.id and alliance_members.grade>=0 order by armory.level desc, armory.exp desc, users.username";
  $db_theend->query($query);
  if($db_theend->num_rows())
  {
    while($db_theend->next_record())
    {
      echo "<tr>";
      echo "<td class=\"alm1\">";
      if($db_theend->Record["grade"]==1)
      {
        echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a>";
        if($site_language=="en")
          echo "<br />Commander";
        else 
          echo "<br />Comandant";  
      }
      if($db_theend->Record["grade"]==2)
      {
        echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a>";
        if($site_language=="en")
          echo "<br />Officer";
        else 
          echo "<br />Ofiter";  
      }  
      if($db_theend->Record["grade"]==0)
      {
        echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a>";
        if($site_language=="en")
          echo "<br />Member";
        else 
          echo "<br />Membru";  
      }
      echo "</td><td class=\"alm2\">".$db_theend->Record["level"];
      if($_COOKIE["lang"]=="en")
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">level</font>";
      else
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">nivel</font>";
      echo "</td><td class=\"alm3\">".number_format($db_theend->Record["exp"])."<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">exp.</font></td><td class=\"alm4\">".number_format(power_attack($db_theend->Record["id"]));
      if($_COOKIE["lang"]=="en")
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">attack</font>";
      else
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">atac</font>";
      echo "</td><td class=\"alm5\">".number_format(power_defense($db_theend->Record["id"]));
      if($_COOKIE["lang"]=="en")
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">defense</font>";
      else
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">aparare</font>";
      echo "</td><td class=\"alm6\">".$db_theend->Record["datetime"];
      if($_COOKIE["lang"]=="en")
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">last seen</font>";
      else
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">ultima data online</font>";
      echo "</td><td class=\"alm7\">";
      echo "<form action=\"play.php\" method=\"POST\">";
      echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
      echo "<input type=\"hidden\" name=\"what\" value=\"send\"></input>";
      echo "<input type=\"hidden\" name=\"user\" value=\"".$db_theend->Record["id"]."\"></input>";
      if($_COOKIE["lang"]=="en")
        echo "<input class=\"submit4\" type=\"submit\" value=\"Mail\"></input>&nbsp;";
      else
        echo "<input class=\"submit4\" type=\"submit\" value=\"Mesaj\"></input>&nbsp;";
      echo "</form>";
      echo "</td></tr>";
    }
    echo "</table>";
  }

  echo "<br>";

  echo "<div style=\"float: right;\">";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliancemail\"></input>";
  if($_COOKIE["lang"]=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Send mail to all\"></input>";
  else
    echo "<input class=\"submit4\" type=\"submit\" value=\"Mesaj catre toti\"></input>";
  echo "</form>";
  echo "</div>";
  echo "<br />";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";

  echo "<br>";

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "POWER BONUSES";
  else 
    echo "BONUSURI DE PUTERE";  
  echo "</div>";
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $id_al=$al_name;

  echo "<tr>";
  echo "<td class=\"almp1\">";
  if($site_language=="ro")
    echo "Puterea de atac a aliantei:";
  else
    echo "Alliance attack power:";
  echo "</td>";
  echo "<td class=\"almp2\">";
  $power_at=power_attack_alliance($id_al);
  echo number_format($power_at);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp1\">";
  if($site_language=="ro")
    echo "Puterea de aparare a aliantei:";
  else
    echo "Alliance defense power:";
  echo "</td>";
  echo "<td class=\"almp2\">";
  $power_df=power_defense_alliance($id_al);
  echo number_format($power_df);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";  
  if($site_language=="ro")
    echo "Bonusul de putere de atac pentru comandant:";
  else
    echo "Attack power bonus for commander:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_at_com=round(0.01*$power_at);
  echo number_format($bonus_at_com);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";    
  if($site_language=="ro")
    echo "Bonusul de putere de aparare pentru comandant:";
  else
    echo "Defense power bonus for commander:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_df_com=round(0.01*$power_df);
  echo number_format($bonus_df_com);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";   
  if($site_language=="ro")
    echo "Bonusul de putere de atac pentru ofiteri:";
  else
    echo "Attack power bonus for officers:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_at_of=round(0.008*$power_at);
  echo number_format($bonus_at_of);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";   
  if($site_language=="ro")
    echo "Bonusul de putere de aparare pentru ofiteri:";
  else
    echo "Defense power bonus for officers:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_df_of=round(0.008*$power_df);
  echo number_format($bonus_df_of);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";  
  if($site_language=="ro")
    echo "Bonusul de putere de atac pentru membrii:";
  else
    echo "Attack power bonus for members:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_at_mem=round(0.006*$power_at);
  echo number_format($bonus_at_mem);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp3\">";  
  if($site_language=="ro")
    echo "Bonusul de putere de aparare pentru membrii:";
  else
    echo "Defense power bonus for members:";
  echo "</td>";
  echo "<td class=\"almp4\">";
  $bonus_df_mem=round(0.006*$power_df);
  echo number_format($bonus_df_mem);
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"almp5\" colspan=\"2\">";  
  if($site_language=="ro")
    echo "* Bonusul primit de un membru al aliantei nu va depasi 50% din puterea sa proprie.";
  else
    echo "* Alliance's bonus received by any member will not exceed 50% from member's self power.";  
  echo "</td>";
  echo "</tr>";  
  echo "</table>";
  echo "</div>";
}

function alliance_waiting($al_name,$grade)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();

  $datetime=date("Y-m-d H:i:s");

  $query="select name from alliances where id=".$al_name;
  $db_theend->query($query);
  $db_theend->next_record();
  $alname=$db_theend->Record["name"];
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "ALLIANCE ADMINISTRATION";
  else 
    echo "ADMINISTRARE ALIANTA";  
  echo "</div>";

  if($_POST["opt"]=="rejectuser" && $_POST["user"])
  {
    $query="select id from alliances where id=".$al_name;
    $db_theend->query($query);
    $db_theend->next_record();
    $id_al=$db_theend->Record["id"];
    $query="update armory set gold=gold+(select gold from alliance_members where id_member=".$_POST["user"]." and id_al=".$id_al.") where id=".$_POST["user"];
    $db_theend->query($query);
    $query="delete from alliance_members where alliance_members.id_member=".$_POST["user"]." and alliance_members.id_al=".$al_name;
    $db_theend->query($query);
    $no_queries+=1;
  }

  if($_POST["opt"]=="acceptuser" && $_POST["user"])
  {
    $query="select alliances.id, alliances.gold, alliances.max_members, count(id_member) as members from alliances, alliance_members where alliances.id=".$al_name." and alliances.id=alliance_members.id_al and alliance_members.grade>=0 group by alliance_members.id_al";
    $db_theend->query($query);
    $db_theend->next_record();
    $id_al=$db_theend->Record["id"];
    $gold=$db_theend->Record["gold"];
    $max_gold=$db_theend->Record["members"]*10000000;
    $al_members=$db_theend->Record["members"];
    $al_max_members=$db_theend->Record["max_members"];

    if($al_members<$al_max_members)
    {

    $query="update alliance_members set grade=0, datetime='".$datetime."' where alliance_members.id_member=".$_POST["user"]." and alliance_members.id_al=".$al_name;
    $db_theend->query($query);
    $max_gold=$max_gold+10000000;

    $query="select gold from alliance_members where id_member=".$_POST["user"]." and id_al=".$id_al;
    $db_theend->query($query);
    $db_theend->next_record();
    $user_gold=$db_theend->Record["gold"];
    $gold=$gold+$user_gold;
    if($gold>$max_gold) $gold=$max_gold;

    $query="update alliances set gold=".$gold." where id=".$al_name;
    $db_theend->query($query);

    $query="insert into al_finance_log values('".$datetime."',".$id_al.",2,".$_POST["user"].",NULL,".$user_gold.")";
    $db_theend->query($query);
    $no_queries+=1;
    }
    else
    {
      // userul nu poate fi acceptat deoarece se depaseste numarul maxim de membrii ai unei aliante
      if($site_language=="en")
        $accept_error="You cannot accept this user.<br>Your do not have more availlable places in your alliance.";
      else
        $accept_error="Nu poti accepta acest jucator.<br>Nu mai ai locuri libere in alianta.";
    }
  }

  echo "<br>";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";

  if($site_language=="en")
    echo "Options: ";
  else 
    echo "Optiuni: ";  

  echo "<form style=\"display: inline;\" name=\"adminalmembers\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"members\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalmembers.submit();\">[members]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalmembers.submit();\">[membri]</a>";  
  echo "</form>";
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalwaitinglist\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"waiting\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalwaitinglist.submit();\">[waiting list]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalwaitinglist.submit();\">[lista de asteptare]</a>";  
  echo "</form>";
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalpowerinfo\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"powerinfo\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalpowerinfo.submit();\">[power info]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalpowerinfo.submit();\">[informatii putere]</a>";  
  echo "</form>";
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalfinancial\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"cost\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalfinancial.submit();\">[financial]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalfinancial.submit();\">[finante]</a>";  
  echo "</form>";
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalpersonalize\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"personalize\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalpersonalize.submit();\">[personalize]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalpersonalize.submit();\">[personalizare]</a>";  
  echo "</form>";  
  echo " ";
  echo "<form style=\"display: inline;\" name=\"adminalchcom\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\" />";
  echo "<input type=\"hidden\" name=\"what\" value=\"manage\" />";
  echo "<input type=\"hidden\" name=\"alname\" value=\"".$_POST["alname"]."\" />";
  echo "<input type=\"hidden\" name=\"subopt\" value=\"chcom\" />";
  if($site_language=="en")
    echo "<a class=\"light_blue\" onClick=\"document.adminalchcom.submit();\">[change commander]</a>";
  else 
    echo "<a class=\"light_blue\" onClick=\"document.adminalchcom.submit();\">[schimbare comandant]</a>";  
  echo "</form>"; 
  
  echo "</div>";
  echo "</div>";
  echo "</div>";

  if($accept_error)
    echo "<br /><font color=\"#FF0000\">".$accept_error."</font><br />";

  echo "<br />";
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";  
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $query="select users.username, users.id, users.race, armory.level, armory.exp, online.datetime, alliance_members.grade from users, alliances, alliance_members, armory, online where alliances.id=".$al_name." and alliances.id=alliance_members.id_al and alliance_members.id_member=users.id and users.id=armory.id and users.id=online.id and alliance_members.grade=-1 order by armory.level desc, armory.exp desc, users.username";
  $db_theend->query($query);
  $no_queries+=1;
  if($db_theend->num_rows())
  {
    while($db_theend->next_record())
    {
      echo "<tr>";
      echo "<td class=\"alm1\">";
      echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?user=".$db_theend->Record["username"]."\">".$db_theend->Record["username"]."</a>";
      echo "</td><td class=\"alm2\">".$db_theend->Record["level"];
      if($site_language=="en")
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">level</font>";
      else
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">nivel</font>";
      echo "</td>";
      echo "<td class=\"alm3\">".number_format($db_theend->Record["exp"]);
      if($site_language=="en")
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">exp.</font>";
      else
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">exp.</font>";
      echo "</td>";
      echo "<td class=\"alm4\">".number_format(power_attack($db_theend->Record["id"]));
      if($site_language=="en")
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">attack</font>";
      else
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">atac</font>";
      echo "</td>";
      echo "<td class=\"alm5\">".number_format(power_defense($db_theend->Record["id"]));
      if($site_language=="en")
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">defense</font>";
      else
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">aparare</font>";
      echo "</td>";
      echo "<td class=\"alm6\">".$db_theend->Record["datetime"];
      if($site_language=="en")
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">last seen</font>";
      else
        echo "<br><font color=\"#A0A0A0\" style=\"font-size: 7pt;\">ultima data online</font>";
      echo "</td>";
      echo "<td class=\"alm7\">";
      if($db_theend->Record["username"]!=$_COOKIE["user"])
      {
        echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
        echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
        echo "<input type=\"hidden\" name=\"user\" value=\"".$db_theend->Record["id"]."\"></input>";
        echo "<input class=\"submit4\" type=\"submit\" value=\"M\" onmouseover=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH=100; return escape('Send mail to user');\"></input>";
        echo "</form>";

        echo "<form style=\"display: inline;\" action=\"play.php\" name=\"form_accept_user_".$db_theend->Record["id"]."\" method=\"POST\">";
        echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
        echo "<input type=\"hidden\" name=\"what\" value=\"waiting\"></input>";
        echo "<input type=\"hidden\" name=\"alname\" value=\"".$al_name."\"></input>";
        echo "<input type=\"hidden\" name=\"opt\" value=\"acceptuser\"></input>";
        echo "<input type=\"hidden\" name=\"user\" value=\"".$db_theend->Record["id"]."\"></input>";
        echo "<input class=\"submit4\" type=\"button\" id=\"form_accept_user_".$db_theend->Record["id"]."_button\" onClick=\"document.getElementById('form_accept_user_".$db_theend->Record["id"]."_button').disabled = true; form_accept_user_".$db_theend->Record["id"].".submit();\" value=\"A\" onmouseover=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH=100; return escape('Accept user');\"></input>";
        echo "</form>";

        echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
        echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
        echo "<input type=\"hidden\" name=\"what\" value=\"waiting\"></input>";
        echo "<input type=\"hidden\" name=\"alname\" value=\"".$al_name."\"></input>";
        echo "<input type=\"hidden\" name=\"opt\" value=\"rejectuser\"></input>";
        echo "<input type=\"hidden\" name=\"user\" value=\"".$db_theend->Record["id"]."\"></input>";
        echo "<input class=\"submit4\" type=\"submit\" value=\"R\" onmouseover=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH=100; return escape('Reject user');\"></input>";
        echo "</form>";
      }
      echo "</td></tr>";
    }
  }
  echo "</table>";

  echo "</div>";
  echo "</div>";
  echo "</div>";
}

function alliance_safe($al_id)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  
  $site_language=site_language();

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "ALLIANCE'S SAFE";
  else 
    echo "SEIFUL ALIANTEI";  
  echo "</div>";
  echo "<br />";

  $golddeposit=0;
  if($_POST["gold"])
  {
    $golddeposit=round($_POST["gold"]);
  }

  if($golddeposit>0)
  {
    $user_id=userid($_COOKIE["user"]);
    $today=getdate();
    if($today["wday"]==0) $wday=6;
    else $wday=$today["wday"]-1;
    $query="select datetime from al_finance_log where id_al=".$al_id." and user=".$user_id." and op=1 and datetime>='".date("Y-m-d H:i:s",mktime(0,0,0,$today["mon"],$today["mday"]-$wday,$today["year"]))."'";
    $db_theend->query($query);
    if($db_theend->num_rows())
    {
      // s-a depus saptamana asta in seif, nu se mai poate face o noua depunere
      if($site_language=="en")
        $deposit_error="You allready made a deposit this week.<br>You can deposit gold in the alliance's safe only once per week.";
      else
        $deposit_error="Ai depus aur in seif saptamana asta.<br>Poti depune aur in seiful aliantei doar odata pe saptamana.";
    }
    else
    {
      $query="select gold from armory where id=".$user_id;
      $db_theend->query($query);
      $db_theend->next_record();
      if($db_theend->Record["gold"]>=$golddeposit)
      {
        $gold=$db_theend->Record["gold"]-$golddeposit;
        $query="select alliances.gold, count(alliance_members.id_member) as members from alliances, alliance_members where alliances.id=".$al_id." and alliances.id=alliance_members.id_al and alliance_members.grade>=0 group by alliance_members.id_al;";
        $db_theend->query($query);
        $db_theend->next_record();
        $safe_max_gold=$db_theend->Record["members"]*10000000;
        $safe_gold=$db_theend->Record["gold"];
        if($safe_max_gold>=$safe_gold+$golddeposit)
        {
           $query="update alliances set gold=".($safe_gold+$golddeposit)." where id=".$al_id."";
           $db_theend->query($query);
           $query="insert into al_finance_log values ('".date("Y-m-d H:i:s")."',".$al_id.",1,".$user_id.",NULL,".$golddeposit.")";
           $db_theend->query($query);
           $query="update armory set gold=".$gold." where id=".$user_id;
           $db_theend->query($query);
        }
        else
        {
           // prea mult gold, depaseste limita seifului aliantei
           if($site_language=="en")
             $deposit_error="Your deposit is too big.";
           else
             $deposit_error="Suma introdusa de tine este prea mare, depaseste capacitatea seifului.";
        }
      }
      else
      {
        // nu are destul gold
        if($site_language=="en")
          $deposit_error="You do not have enoght gold.";
        else
          $deposit_error="Nu ai destul aur.";
      }
      }
    }

  if($deposit_error)
  {
    echo "<br>";
    echo "<font color=\"#FF0000\">".$deposit_error."</font>";
    echo "<br>";
  }

  echo "<div class=\"section\">";
    
  $query="select alliances.gold, count(alliance_members.id_member) as members from alliances, alliance_members where alliances.id=".$al_id." and alliance_members.id_al=".$al_id." and alliance_members.grade>=0 group by alliance_members.id_al";
  $db_theend->query($query);
  $db_theend->next_record();

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  echo "<tr>";
  echo "<td class=\"alsafe1\">";
  if($site_language=="en")
    echo "Alliance's safe:";
  else 
    echo "Seiful aliantei:";  
  echo "</td>";
  echo "<td class=\"alsafe2\">".number_format($db_theend->Record["gold"])." EKR</td>";
  echo "<td class=\"alsafe3\" rowspan=\"3\">";
  if($site_language=="ro")
  {
  	echo "* Poti depune aur in seiful aliantei doar odata pe saptamana.<br>Comandantul si ofiterii aliantei pot transfera aur catre orice membru.";
  }
  else
  {
  	echo "* You can deposit gold in the alliance's safe only once per week.<br>The commander and the officers of the alliance can transfer gold to any user.";
  }
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"alsafe1\">";
  if($site_language=="en")
    echo "Safe capacity:";
  else 
    echo "Capacitatea seifului:";  
  echo "</td>";
  echo "<td class=\"alsafe2\">".number_format($db_theend->Record["members"]*10000000)." EKR</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"alliance\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"safe\"></input>";
  echo "<input type=\"hidden\" name=\"alliance\" value=\"".$al_id."\"></input>";
  echo "<td class=\"alsafe4\"><div style=\"float: right;\"><input class=\"input4\" type=\"text\" name=\"gold\"></input></div>";
  if($site_language=="en")
    echo "Deposit:";
  else 
    echo "Depune:";  
  echo "</td>";
  echo "<td class=\"alsafe5\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Deposit\" />";
  else 
    echo "<input class=\"submit4\" type=\"submit\" value=\"Depune\" />";  
  echo "</td>";
  echo "</form>";
  echo "</tr>";
  echo "</table>";
  
  echo "</div>";

  echo "<br />";

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "SAFE LOGS";
  else 
    echo "ISTORIC OPERATIUNI SEIF";  
  echo "</div>";
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";

  echo "<div align=\"center\">";
  
  echo "<span id=\"alliance_safe_deposit_logs_button_span\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"button\" onClick=\"allianceSafeLogs(".$al_id.",'deposit'); showhide('alliance_safe_deposit_logs_table'); hide('alliance_safe_transfer_logs_table');\" value=\"View Deposit Logs\"></input>";
  else
    echo "<input class=\"submit4\" type=\"button\" onClick=\"allianceSafeLogs(".$al_id.",'deposit'); showhide('alliance_safe_deposit_logs_table'); hide('alliance_safe_transfer_logs_table');\" value=\"Vezi istoric depozite\"></input>";
  echo "</span>";
  
  echo " ";

  echo "<span id=\"alliance_safe_transfer_logs_button_span\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"button\" onClick=\"allianceSafeLogs(".$al_id.",'transfer'); showhide('alliance_safe_transfer_logs_table'); hide('alliance_safe_deposit_logs_table');\" value=\"View Transfer Logs\"></input>";
  else
    echo "<input class=\"submit4\" type=\"button\" onClick=\"allianceSafeLogs(".$al_id.",'transfer'); showhide('alliance_safe_transfer_logs_table'); hide('alliance_safe_deposit_logs_table');\" value=\"Vezi istoric transferuri\"></input>";
  echo "</span>";
  
  echo "<br>";

  echo "<div id=\"alliance_safe_deposit_logs_table\" style=\"display: none;\">";
  echo "<span id=\"alliance_safe_deposit_logs_span\"></span>";
  echo "</div>";   
  
  echo "<div id=\"alliance_safe_transfer_logs_table\" style=\"display: none;\">";
  echo "<span id=\"alliance_safe_transfer_logs_span\"></span>";
  echo "</div>";  
    
  echo "</div>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

?>
