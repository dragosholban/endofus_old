<?php
date_default_timezone_set('Europe/Bucharest');

function alphanum_field($field)
{
          $field=strtolower($field);
          if (!strlen($field))
          {
                  return 0;
          }
           else
               {
                       $strOK=" abcdefghijklmnopqrstuvwxyz0123456789._-";
                       $i=0;
                       $ok=1;
                       while (($i<strlen($field))&&($ok))
                       {
                               $j=0;
                               $gasit=0;
                               while (($j<strlen($strOK))&&(!$gasit))
                               {
                                       if ($field[$i]==$strOK[$j])
                                           $gasit=1;
                                       $j++;
                               }
                               if (!$gasit)
                                    $ok=0;
                               $i++;
                       }
                       if ($ok)
                           return 1;
                          else
                              return 0;
               }

}

function email_field($field)
{
    // validate email using regex
    if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $field)) {
        return 1;
    } else {
        return 0;
    }
}

function js_alert($message)
{
  echo "<script>alert(\"".$message."\");</script>";
}

function js_redirect($adresa)
{
  echo "<script>window.location='".$adresa."'</script>";
}

function date_difference($a,$b,$units)
{
        $dif=mktime($a["hours"],$a["minutes"],$a["seconds"],$a["mon"],$a["mday"],$a["year"])-strtotime($b);
        switch($units)
        {
        case "minutes":
                         return $dif/60;
                         break;
        case "seconds":
                         return $dif;
                         break;
        }
}

function site_language()
{
  $site_language="en";
  if(isset($_COOKIE["lang"]) && $_COOKIE["lang"]=="ro")
  {
    $site_language="ro";
  }
  if(isset($_COOKIE["lang"]) && $_COOKIE["lang"]=="en")
  {
    $site_language="en";
  }
  return $site_language;
}

function mail_status()
{
  $site_language=site_language();

     $db_theend = new DataBase_theend;
     $db_theend->connect();

     $query="select newmail as nr from users where id=".$_COOKIE["uid"];
     $db_theend->query($query);
     if ($db_theend->num_rows())
     {
         $db_theend->next_record();
         if($db_theend->Record["nr"]>0)
         {
            $text=" <font color=\"#FFA500\">(".$db_theend->Record["nr"];
            if($site_language=="ro")
            {
              if($db_theend->Record["nr"]>1) 
                $text.=" noi";
              else
                $text.=" nou";
            }
            else
              $text.=" new";    
            $text.=")</font>";
            return $text;
         }
         else
            return "";
     }
     else
         return "";
}

function userrace($user)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select race from users where id=".$user;
  $db_theend->query($query);
  $no_queries+=1;
  if($db_theend->num_rows())
  {
    $db_theend->next_record();
    return $db_theend->Record["race"];
  }
  return 0; // user does not exists
}

function top()
{
  $site_language=site_language();
  echo "<div class=\"invisible_box\">";
  echo "</div>";
  
  if(check_login())
  {
    echo "<div class=\"login_box2\">";
  	echo "<font color=\"#FFA500\">";
  	if($site_language=="en")
  	  echo "Logged in as:";
  	else 
  	  echo "Autentificat ca:";  
  	echo "</font>";
    echo "<br />";
    echo "<b>".username($_COOKIE["uid"])."</b>";
    echo "<br /><br />";
    echo "<form action=\"logout.php\" method=\"post\">";
    if($site_language=="en")
      echo "<input type=\"submit\" class=\"submit2\" value=\"Logout\" />";
    else 
      echo "<input type=\"submit\" class=\"submit2\" value=\"Iesire\" />";  
    echo "</form>";
    echo "</div>";
  }
  else 
  {
    /*
  	$acceptedChars = '0123456789';
    $max = strlen($acceptedChars)-1;
    $code = null;
    for($i=0; $i < 5; $i++)
    {
      $code .= $acceptedChars{mt_rand(0, $max)};
    } 
    */
    $code=random_number(1,1000);
    echo "<div class=\"login_box1\">";   
  	echo "<form class=\"top_login_form\" action=\"dologin.php\" method=\"post\">";
  	echo "<input type=\"hidden\" name=\"sendcode\" value=\"".$code."\">";
    echo "<p class=\"bigline\">";
    if($site_language=="en")
      echo "User:";
    else 
      echo "Cont:";  
    echo "<input type=\"text\" class=\"input1\" name=\"username\" /></p>";
    echo "<p class=\"bigline\">";
    if($site_language=="en")
      echo "Pass:";
    else 
      echo "Parola:";  
    echo "<input type=\"password\" class=\"input1\" name=\"password\" /></p>";  
    echo "<p class=\"bigline\"><img class=\"middleval\" src=\"image_code2.php?c=".$code."\" alt=\"image code\" /><input type=\"text\" class=\"input2\" name=\"code\" /><input type=\"submit\" class=\"submit1\" value=\"Login\" /></p>";
    echo "</form>";
    echo "</div>";
  }  
  
  echo "<div class=\"top_ad\" style=\"width: 472px; padding: 0px; height: 64px;\">";
  echo '<a href="http://reduceri-cadouri.ro" title="Reduceri & Cadouri" target="_blank"><img src="pics/banners/reduceri.png" alt="Reduceri & Cadouri" /></a>';
  echo "</div>";
  echo "<div class=\"language_and_date\">";
  echo "Select preferred language: ";
  echo "<a href=\"ch_lang.php?lang_sel=en\"><img class=\"flag\" src=\"pics/usa.gif\" /></a> ";
  echo "<a href=\"ch_lang.php?lang_sel=ro\"><img class=\"flag\" src=\"pics/romania.gif\" /></a>";
  echo "&nbsp;&nbsp;&nbsp;&middot;&nbsp;&nbsp;&nbsp;";
  if($site_language=="ro")
  {
    echo "<font color=\"#FFA500\">Ziua ".(gregoriantojd(date("m"),date("d"),date("Y"))-gregoriantojd(2,9,2007)).":</font> ".date("M d, Y H:i")." <font color=\"#FFA500\"></font>";
  }
  else
  {
    echo "<font color=\"#FFA500\">Day ".(gregoriantojd(date("m"),date("d"),date("Y"))-gregoriantojd(2,9,2007)).":</font> ".date("M d, Y H:i")." <font color=\"#FFA500\"></font>";
  }
  echo "</div>";
  
  echo "<div class=\"header_bottom_bar\">";

  ?>  
<script type="text/javascript"><!--
google_ad_client = "pub-7634296240444560";
google_alternate_color = "102030";
google_ad_width = 728;
google_ad_height = 15;
google_ad_format = "728x15_0ads_al";
google_ad_channel = "";
google_color_border = "102030";
google_color_bg = "102030";
google_color_link = "FFD700";
google_color_text = "000000";
google_color_url = "008000";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>  
<?php  

  echo "</div>";

}

function bottom()
{
  echo "<br>";
  echo "<a class=\"machine\" style=\"font-size:10px;line-height:12px;font-family:verdana,arial,sans-serif;font-weight:normal;\" href=\"contact.php\"><b>Link exchage / Schimb de linkuri</b></a>";
  echo "<br><br>";
  echo "<a href=\"http://www.jocuri-gratis.ro\" title=\"Jocuri\" target=\"_blank\">Jocuri</a>";
  echo "&nbsp;&nbsp;<font color=\"#FFFFFF\" style=\"font-size: 10pt;\"><b>&middot;</b></font>&nbsp;&nbsp;";
  echo "<a href=\"http://jocuri.triburi.com\" title=\"Jocuri\" target=\"_blank\">Jocuri</a>";
  echo "&nbsp;&nbsp;<font color=\"#FFFFFF\" style=\"font-size: 10pt;\"><b>&middot;</b></font>&nbsp;&nbsp;";
  echo "<a href=\"http://www.ijocuri.ro\" target=\"_blank\" title=\"Jocuri Multiplayer\">Jocuri Multiplayer</a>";
  echo "&nbsp;&nbsp;<font color=\"#FFFFFF\" style=\"font-size: 10pt;\"><b>&middot;</b></font>&nbsp;&nbsp;";
  echo "<a href=\"http://www.whitenight.ro?endofus.net\" target=\"_blank\">www.whitenight.ro</a>";
  echo "&nbsp;&nbsp;<font color=\"#FFFFFF\" style=\"font-size: 10pt;\"><b>&middot;</b></font>&nbsp;&nbsp;";
  echo "<a href=\"http://www.mmorg.ro\" target=\"_blank\" title=\"mmorg.ro - primul site romanesc dedicat mmorpg-urilor\">www.mmorg.ro - primul site romanesc dedicat mmorpg-urilor</a>";
?>
<br /><br />
<div style="display: inline; width:100px; text-align: center;">

<!-- MONITOR NEOGEN CODE - BEGIN -->
<script type="text/javascript">
archiweb_monitor_w7xtcy2k504 = "";
</script>
<script src="http://monitor.neogen.ro/32751_icon" type="text/javascript">
</script>
<script type="text/javascript">
document.write(archiweb_monitor_w7xtcy2k504);
</script>
<script type="text/javascript">
<!-- 
s="-";c="-";je=0;js=1;
ref=escape(parent.document.referrer);
u=escape(document.location.href);
app="-";ver="-"; 
//--> 
</script>
<script type="text/javascript">
<!-- 
app=escape(navigator.appName);
ver=escape(navigator.appVersion);
s=screen.width;
if(navigator.javaEnabled()){je=1}
if(app!="Netscape") {c=screen.colorDepth}
else {c=screen.pixelDepth} 
//--> 
</script>
<script type="text/javascript">
<!-- 
r="&screen="+s+"&colors="+c+"&referrer="+ref+"&doc="+u+"&app="+app+"&ver="+ver+"&java="+je+"&js="+js;

url = "http://monitor.neogen.ro/transparent.php?clientID=32751"+r; 
document.write("<IMG BORDER=0 SRC=\""+url+"\" WIDTH=0 HEIGHT=0>"); 
// --> 
</script>
<!--  MONITOR NEOGEN CODE - END -->

</div>
<div style="display: inline; width:100px; text-align: center;">

<div id="eXTReMe" style="display: inline;"><a href="http://extremetracking.com/open?login=endofus" target="_blank">
<img src="http://t1.extreme-dm.com/i.gif" style="border: 0;" height="38" width="41" id="EXim" alt="eXTReMe Tracker" /></a>
<script type="text/javascript"><!--
var EXlogin='endofus' // Login
var EXvsrv='s10' // VServer
EXs=screen;EXw=EXs.width;navigator.appName!="Netscape"?
EXb=EXs.colorDepth:EXb=EXs.pixelDepth;
navigator.javaEnabled()==1?EXjv="y":EXjv="n";
EXd=document;EXw?"":EXw="na";EXb?"":EXb="na";
EXd.write("<img src=http://e1.extreme-dm.com",
"/"+EXvsrv+".g?login="+EXlogin+"&amp;",
"jv="+EXjv+"&amp;j=y&amp;srw="+EXw+"&amp;srb="+EXb+"&amp;",
"l="+escape(parent.document.referrer)+" height=1 width=1>");//-->
</script><noscript><div id="neXTReMe"><img height="1" width="1" alt=""
src="http://e1.extreme-dm.com/s10.g?login=endofus&amp;j=n&amp;jv=n" />
</div></noscript></div>

</div>
<div style="display: inline; width:100px; text-align: center;">
<!--/Start Trafic.ro/-->
<script type="text/javascript">t_rid="endofusnet";</script>
<script type="text/javascript" src="http://storage.trafic.ro/js/trafic.js"
></script><noscript><a href="http://www.trafic.ro/top/?rid=endofusnet"
 target="_blank"><img border="0" alt="trafic ranking"
 src="http://log.trafic.ro/cgi-bin/pl.dll?rid=endofusnet"/></a>
</noscript>
<!--/End Trafic.ro/-->

</div>

<?php
}

function main_menu($where = null)
{
  $site_language=site_language();

  echo "<div class=\"left_box_title\">";
  
  if($site_language=="ro")
    echo "<img style=\"cursor: pointer; cursor: hand;\" alt=\"Meniu Principal\" onclick=\"showhide('main_menu');\" border=\"0\" width=\"180\" height=\"20\" src=\"pics/top_menu2.gif\" />";
  else
    echo "<img style=\"cursor: pointer; cursor: hand;\" alt=\"Main Menu\" onclick=\"showhide('main_menu');\" border=\"0\" width=\"180\" height=\"20\" src=\"pics/top_menu1.gif\" />";

  echo "</div>"; 
  
  echo "<div id=\"main_menu\"";
  if($where=="play.php")
    echo " style=\"display:none\">";
  else  
    echo ">"; 
 
  if(!$where)
  {
    echo "<a class=\"nav_selected\" href=\"index.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Prima Pagina";
    else
      echo "Home Page";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" href=\"index.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Prima Pagina";
    else
      echo "Home Page";
    echo "</a>";
  }
  
  if($where=="login")
  {
    echo "<a class=\"nav_selected\" href=\"login.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Autentificare";
    else
      echo "Login";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" href=\"login.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Autentificare";
    else
      echo "Login";
    echo "</a>";
  }

  if($where=="register")
  {
    echo "<a class=\"nav_selected\" href=\"register.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Inregistrare";
    else
      echo "Register";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" href=\"register.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Inregistrare";
    else
      echo "Register";
    echo "</a>";
  }
  
  echo "<a class=\"nav\" href=\"http://www.endofus.net/forum/\" target=\"_blank\"><b>&middot;</b>&nbsp;&nbsp;Forum</a>";

  echo "<a class=\"nav\" href=\"http://www.endofus.net/webchat/\" target=\"_blank\"><b>&middot;</b>&nbsp;&nbsp;Chat</a>";

  echo "<form name=\"menu_ranks\" action=\"ranks.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"ranks_general\" /></form>";
  if($where=="ranks_general" || $where=="ranks_week" || $where=="ranks_alliances")
  {
    echo "<a class=\"nav_selected\" onclick=\"showhide('ranks_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Clasament";
    else
      echo "Ranks";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"showhide('ranks_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Clasament";
    else
      echo "Ranks";
    echo "</a>";
  }
  
  echo "<div id=\"ranks_submenu\"";
  if($where=="ranks_general" || $where=="ranks_week" || $where=="ranks_alliances" || $where=="ranks_votes" || $where=="ranks_deleted")
    echo " style=\"display:block\">";
  else  
    echo " style=\"display:none\">";  
  
    echo "<form name=\"menu_ranks_general\" action=\"ranks.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"ranks_general\" /></form>";
    if($where=="ranks_general")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_ranks_general.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Top General";
      else 
        echo "General Top";  
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_ranks_general.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Top General";
      else 
        echo "General Top"; 
      echo "</a>";
    }
    echo "<form name=\"menu_ranks_week\" action=\"ranks.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"ranks_week\" /></form>";
    if($where=="ranks_week")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_ranks_week.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Topul Saptamanii";
      else 
        echo "Week's Top";      
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_ranks_week.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Topul Saptamanii";
      else 
        echo "Week's Top";
      echo "</a>";
    }
    echo "<form name=\"menu_ranks_alliances\" action=\"ranks.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"ranks_alliances\" /></form>";
    if($where=="ranks_alliances")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_ranks_alliances.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Top Aliante";
      else 
        echo "Top Alliances";      
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_ranks_alliances.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Top Aliante";
      else 
        echo "Top Alliances";
      echo "</a>";
    }
    echo "<form name=\"menu_ranks_votes\" action=\"ranks.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"ranks_votes\" /></form>";
    if($where=="ranks_votes")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_ranks_votes.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Jucatori Populari";
      else 
        echo "Most Popular Users";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_ranks_votes.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Jucatori Populari";
      else 
        echo "Most Popular Users";
      echo "</a>";
    }
    echo "<form name=\"menu_ranks_deleted\" action=\"ranks.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"ranks_deleted\" /></form>";
    if($where=="ranks_deleted")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_ranks_deleted.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Conturi Sterse";
      else 
        echo "Hall of Shame";      
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_ranks_deleted.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Conturi Sterse";
      else 
        echo "Hall of Shame";
      echo "</a>";
    }
  
  echo "</div>";

  if($where=="rules")
  {
    echo "<a class=\"nav_selected\" href=\"rules.php\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Manual";
      else
        echo "Manual";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" href=\"rules.php\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Manual";
      else
        echo "Manual";
    echo "</a>";
  }

  if($where=="story")
  {
    echo "<a class=\"nav_selected\" href=\"story.php\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Povestea";
      else
        echo "The Story";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" href=\"story.php\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Povestea";
      else
        echo "The Story";
    echo "</a>";
  }   

  if($where=="worldmap")
  {
    echo "<a class=\"nav_selected\" href=\"worldmap.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Statistici";
    else
      echo "Statistics";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" href=\"worldmap.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Statistici";
    else
      echo "Statistics";
    echo "</a>";
  }

  echo "<a class=\"nav\" href=\"live.php\" target=\"_blank\"><b>&middot;</b>&nbsp;&nbsp;Live</a>";

  if($where=="contact")
  {
    echo "<a class=\"nav_selected\" href=\"contact.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Contact";
    else
      echo "Contact";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" href=\"contact.php\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Contact";
    else
      echo "Contact";
    echo "</a>";
  }
  
  echo "</div>";
}

function game_menu($where = null)
{
  $site_language=site_language();
  
  echo "<div class=\"left_box_title\">";
  
  if($site_language=="ro")
    echo "<img style=\"cursor: pointer; cursor: hand;\" alt=\"Meniu Joc\" onclick=\"showhide('game_menu');\" border=\"0\" width=\"180\" height=\"20\" src=\"pics/top_menu4.gif\" />";
  else
    echo "<img style=\"cursor: pointer; cursor: hand;\" alt=\"Game Menu\" onclick=\"showhide('game_menu');\" border=\"0\" width=\"180\" height=\"20\" src=\"pics/top_menu3.gif\" />";

  echo "</div>";   

  echo "<div id=\"game_menu\"";
  if($where!="play.php")
    echo " style=\"display:none\">";
  else  
    echo ">";  
  
  echo "<form name=\"menu_cc\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"cc\" /></form>";
  if($_POST["loc"]=="cc")
  {
    echo "<a class=\"nav_selected\" onclick=\"menu_cc.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Comandament";
    else
      echo "Command Center";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"menu_cc.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Comandament";
    else
      echo "Command Center";
    echo "</a>";
  }

  echo "<form name=\"menu_train\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"train\" /></form>";
  if($_POST["loc"]=="train")
  {
    echo "<a class=\"nav_selected\" onclick=\"menu_train.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Antrenare Unitati";
    else
      echo "Train Units";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"menu_train.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Antrenare Unitati";
    else
      echo "Train Units";
    echo "</a>";
  }

  echo "<form name=\"menu_armory\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"armory\" /><input type=\"hidden\" name=\"what\" value=\"attack\" /></form>";
  if($_POST["loc"]=="armory" || $_POST["loc"]=="sell_armory")
  {
    echo "<a class=\"nav_selected\" onclick=\"showhide('armory_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Armament";
    else
      echo "Armory";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"showhide('armory_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Armament";
    else
      echo "Armory";
    echo "</a>";
  }
  
  echo "<div id=\"armory_submenu\"";
  if($_POST["loc"]=="armory" || $_POST["loc"]=="sell_armory")
    echo " style=\"display:block\">";
  else  
    echo " style=\"display:none\">"; 
  
    echo "<form name=\"menu_armory_attack\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"armory\" /><input type=\"hidden\" name=\"what\" value=\"attack\" /></form>";
    if($_POST["what"]=="attack")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_armory_attack.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Atac";
      else
        echo "Attack Weapons";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_armory_attack.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Atac";
      else
        echo "Attack Weapons";
      echo "</a>";
    }
    echo "<form name=\"menu_armory_defense\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"armory\" /><input type=\"hidden\" name=\"what\" value=\"defense\" /></form>";
    if($_POST["what"]=="defense")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_armory_defense.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Aparare";
      else      
        echo "Defense Weapons";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_armory_defense.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Aparare";
      else      
        echo "Defense Weapons";
      echo "</a>";
    }
    echo "<form name=\"menu_armory_spy\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"armory\" /><input type=\"hidden\" name=\"what\" value=\"spy\" /></form>";
    if($_POST["what"]=="spy")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_armory_spy.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Spionaj";
      else      
        echo "Spy Tools";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_armory_spy.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Spionaj";
      else      
        echo "Spy Tools";
      echo "</a>";
    } 
    echo "<form name=\"menu_armory_sentry\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"armory\" /><input type=\"hidden\" name=\"what\" value=\"sentry\" /></form>";
    if($_POST["what"]=="sentry")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_armory_sentry.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Contra-spionaj";
      else      
        echo "Sentry Tools";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_armory_sentry.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Contra-spionaj";
      else      
        echo "Sentry Tools";
      echo "</a>";
    }       

  echo "</div>";  
  
  echo "<form name=\"menu_upgrades\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"upgrades\" /></form>";
  if($_POST["loc"]=="upgrades")
  {
    echo "<a class=\"nav_selected\" onclick=\"menu_upgrades.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Imbunatatiri";
    else
      echo "Upgrades";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"menu_upgrades.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Imbunatatiri";
    else
      echo "Upgrades";
    echo "</a>";
  }

  echo "<form name=\"menu_attack\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"attack\" /></form>";
  if($_POST["loc"]=="attack")
  {
    echo "<a class=\"nav_selected\" onclick=\"menu_attack.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Atac";
    else
      echo "Attack";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"menu_attack.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Atac";
    else
      echo "Attack";
    echo "</a>";
  }

  echo "<form name=\"menu_attack_log\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"attack_log\" /><input type=\"hidden\" name=\"who\" value=\"you\" /></form>";
  if($_POST["loc"]=="attack_log")
  {
    echo "<a class=\"nav_selected\" onclick=\"showhide('attacklog_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Istoric Atacuri";
    else
      echo "Attack Logs";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"showhide('attacklog_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Istoric Atacuri";
    else
      echo "Attack Logs";
    echo "</a>";
  }

  echo "<div id=\"attacklog_submenu\"";
  if($_POST["loc"]=="attack_log")
    echo " style=\"display:block\">";
  else  
    echo " style=\"display:none\">";  
  
    echo "<form name=\"menu_attack_log_on_others\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"attack_log\" /><input type=\"hidden\" name=\"who\" value=\"you\" /></form>";
    if($_POST["loc"]=="attack_log" && $_POST["who"]=="you")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_attack_log_on_others.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Atacurile tale";
      else      
        echo "Attacks on others";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_attack_log_on_others.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Atacurile tale";
      else      
        echo "Attacks on others";
      echo "</a>";
    }
    echo "<form name=\"menu_attack_log_on_you\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"attack_log\" /><input type=\"hidden\" name=\"who\" value=\"others\" /></form>";
    if($_POST["loc"]=="attack_log" && $_POST["who"]=="others")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_attack_log_on_you.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Atacuri asupra ta";
      else      
        echo "Attacks on you";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_attack_log_on_you.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Atacuri asupra ta";
      else      
        echo "Attacks on you";
      echo "</a>";
    }

    echo "</div>";

  echo "<form name=\"menu_spy_log\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"spy_log\" /><input type=\"hidden\" name=\"who\" value=\"you\" /></form>";
  if($_POST["loc"]=="spy_log")
  {
    echo "<a class=\"nav_selected\" onclick=\"showhide('spylog_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Istoric Spionaj";
    else
      echo "Spy Logs";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"showhide('spylog_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Istoric Spionaj";
    else
      echo "Spy Logs";
    echo "</a>";
  }

  echo "<div id=\"spylog_submenu\"";
  if($_POST["loc"]=="spy_log")
    echo " style=\"display:block\">";
  else  
    echo " style=\"display:none\">"; 
      
    echo "<form name=\"menu_spy_log_on_others\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"spy_log\" /><input type=\"hidden\" name=\"who\" value=\"you\" /></form>";
    if($_POST["loc"]=="spy_log" && $_POST["who"]=="you")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_spy_log_on_others.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Misiunile tale";
      else      
        echo "Spy on others";      
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_spy_log_on_others.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Misiunile tale";
      else      
        echo "Spy on others";      
      echo "</a>";
    }
    echo "<form name=\"menu_spy_log_on_you\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"spy_log\" /><input type=\"hidden\" name=\"who\" value=\"others\" /></form>";
    if($_POST["loc"]=="spy_log" && $_POST["who"]=="others")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_spy_log_on_you.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Misiuni asupra ta";
      else      
        echo "Spy on you";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_spy_log_on_you.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Misiuni asupra ta";
      else      
        echo "Spy on you";
      echo "</a>";
    }

  echo "</div>";
    
  echo "<form name=\"menu_alliance\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"alliance\" /></form>";
  if($_POST["loc"]=="alliance")
  {
    echo "<a class=\"nav_selected\" onclick=\"showhide('alliance_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Aliante";
    else
      echo "Aliances";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"showhide('alliance_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Aliante";
    else
      echo "Aliances";
    echo "</a>";
  }
  
  echo "<div id=\"alliance_submenu\"";
  if($_POST["loc"]=="alliance")
    echo " style=\"display:block\">";
  else  
    echo " style=\"display:none\">";
    
    echo "<form name=\"menu_alliance_my\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"alliance\" /></form>";
    echo "<a class=\"subnav\" onclick=\"menu_alliance_my.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Alianta Ta";
    else 
      echo "Your Alliance";
    echo "</a>";
    echo "<form name=\"menu_alliance_list\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"alliance\" /><input type=\"hidden\" name=\"what\" value=\"listalliances\" /></form>";
    echo "<a class=\"subnav\" onclick=\"menu_alliance_list.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Lista Aliantelor";
    else 
      echo "Alliance List";
    echo "</a>";

  echo "</div>";
    
  echo "<form name=\"menu_safe\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"safe\" /></form>";
  if($_POST["loc"]=="safe")
  {
    echo "<a class=\"nav_selected\" onclick=\"menu_safe.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Seif";
    else
      echo "Safe";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"menu_safe.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Seif";
    else
      echo "Safe";
    echo "</a>";
  }

  echo "<form name=\"menu_mail\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"mail\" /></form>";
  if($_POST["loc"]=="mail")
  {
    echo "<a class=\"nav_selected\" onclick=\"showhide('mail_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Mesaje";
    else
      echo "Mail";
    if($_COOKIE["uid"])
    {
      echo mail_status();
    }
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"showhide('mail_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Mesaje";
    else
      echo "Mail";
    if($_COOKIE["uid"])
    {
      echo mail_status();
    }
    echo "</a>";
  }
  
  echo "<div id=\"mail_submenu\"";
  if($_POST["loc"]=="mail")
    echo " style=\"display:block\">";
  else  
    echo " style=\"display:none\">";

    echo "<form name=\"menu_mail_inbox\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"mail\" /><input type=\"hidden\" name=\"what\" value=\"inbox\" /></form>";
    echo "<a class=\"subnav\" onclick=\"menu_mail_inbox.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Primite";
    else 
      echo "Inbox";
    echo "</a>";
    echo "<form name=\"menu_mail_sentbox\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"mail\" /><input type=\"hidden\" name=\"what\" value=\"sentbox\" /></form>";
    echo "<a class=\"subnav\" onclick=\"menu_mail_sentbox.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Trimise";
    else 
      echo "Sentbox";
    echo "</a>";
  
  echo "</div>";

  echo "<form name=\"menu_account\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"account\" /></form>";
  if($_POST["loc"]=="account" || $_POST["loc"]=="editprofile" || $_POST["loc"]=="chpsswd" || $_POST["loc"]=="rstac")
  {
    echo "<a class=\"nav_selected\" onclick=\"showhide('account_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Contul Tau";
    else
      echo "Your Account";
    echo "</a>";
  }
  else
  {
    echo "<a class=\"nav\" onclick=\"showhide('account_submenu');\"><b>&middot;</b>&nbsp;&nbsp;";
    if($site_language=="ro")
      echo "Contul Tau";
    else
      echo "Your Account";
    echo "</a>";
  }
  	
  echo "<div id=\"account_submenu\"";
  if($_POST["loc"]=="account" || $_POST["loc"]=="editprofile" || $_POST["loc"]=="chpsswd" || $_POST["loc"]=="rstac")
    echo " style=\"display:block\">";
  else  
    echo " style=\"display:none\">";  	

    echo "<form name=\"menu_account_info\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"account\" /></form>";
    if($_POST["loc"]=="account")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_account_info.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Informatii Cont";
      else 
        echo "Account Info";      
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\"  onclick=\"menu_account_info.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Informatii Cont";
      else 
        echo "Account Info";
      echo "</a>";
    }
    echo "<form name=\"menu_account_edit\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"editprofile\" /></form>";
    if($_POST["loc"]=="editprofile")
    {
      echo "<a class=\"subnav_selected\" onclick=\"menu_account_edit.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Editare Profil";
      else 
        echo "Edit Profile";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\"  onclick=\"menu_account_edit.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Editare Profil";
      else 
        echo "Edit Profile";
      echo "</a>";
    }
    echo "<form name=\"menu_account_passwd\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"chpsswd\" /></form>";
    if($_POST["loc"]=="chpsswd")
    {
      echo "<a class=\"subnav_selected\"  onclick=\"menu_account_passwd.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Schimbare Parola";
      else 
        echo "Change Password";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\" onclick=\"menu_account_passwd.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Schimbare Parola";
      else 
        echo "Change Password";
      echo "</a>";
    }
    echo "<form name=\"menu_account_reset\" action=\"play.php\" method=\"post\"><input type=\"hidden\" name=\"loc\" value=\"rstac\" /></form>";
    if($_POST["loc"]=="rstac")
    {
      echo "<a class=\"subnav_selected\"  onclick=\"menu_account_reset.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Resetare Cont";
      else 
        echo "Reset Account";
      echo "</a>";
    }
    else
    {
      echo "<a class=\"subnav\"  onclick=\"menu_account_reset.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
      if($site_language=="ro")
        echo "Resetare Cont";
      else 
        echo "Reset Account";
      echo "</a>";
    }
  
  echo "</div>";

  echo "<form name=\"menu_logout\" action=\"logout.php\" method=\"post\"></form>";
  echo "<a class=\"nav\" onclick=\"menu_logout.submit();\"><b>&middot;</b>&nbsp;&nbsp;";
  if($site_language=="ro")
    echo "Iesire Cont";
  else
    echo "Logout";
  echo "</a>";
  
  echo "</div>";
}

function latest_news_box()
{
  $site_language=site_language();
  
  echo "<div class=\"right_box_title\">";

  if($site_language=="ro")
    echo "<a href=\"news.php\"><img border=\"0\" alt=\"stiri\" src=\"pics/top_news2.gif\" /></a>";
  else
    echo "<a href=\"news.php\"><img border=\"0\" alt=\"news\" src=\"pics/top_news1.gif\" /></a>";
  
  echo "</div>";  
  
  echo "<div class=\"right_box_white_spacer\"></div>";
    
  $db = new DataBase_theend;
  $db->connect();

  $query="select datetime, ro, en from news order by id desc limit 1";
  $db->query($query);
  
  echo "<div class=\"right_box\">";

  if($db->num_rows())
  {
    $db->next_record();
    echo "<font color=\"#FFA500\">".$db->Record["datetime"]."</font>";
    echo "<br />";
    if($site_language=="ro")
      echo "".substr($db->Record["ro"],0,150)."...";
    else
      echo "".substr($db->Record["en"],0,150)."...";
  }
  else
  {
    echo " No news available for the moment.";
  }

  echo "<br />";
  echo "<a href=\"news.php\">";
  if($site_language=="ro")
    echo "[toate stirile]";
  else
    echo "[read all news]";
  echo "</a>";
  
  echo "</div>";
}

function last_attack_box()
{
  $site_language=site_language();
	
  echo "<div class=\"right_box_black_spacer\"></div>";
  
  echo "<form name=\"form_last_attack\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"attack_log\"></input>";
  echo "<input type=\"hidden\" name=\"who\" value=\"others\"></input>";
  echo "</form>";
    
  echo "<div class=\"right_box_title\">";
  
  if($site_language=="ro")
    echo "<a href=\"#\" onClick=\"form_last_attack.submit();\"><img border=\"0\" alt=\"ultimul atac asupra ta\" src=\"pics/top_last_attack2.gif\" /></a>";
  else
    echo "<a href=\"#\" onClick=\"form_last_attack.submit();\"><img border=\"0\" alt=\"last attack on you\" src=\"pics/top_last_attack1.gif\" /></a>";  

  echo "</div>";  
  
  echo "<div class=\"right_box_white_spacer\"></div>";
  
  echo "<div class=\"right_box\">";
  
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select attack_log.date, b.username, b.race, attack_log.win_id, attack_log.at_id, attack_log.df_id from attack_log, users b  where attack_log.df_id=".$_COOKIE["uid"]." and attack_log.at_id=b.id order by attack_log.date desc limit 1";
  $db_theend->query($query);
  $no_queries+=1;

  if($db_theend->num_rows())
  {
      $db_theend->next_record();
      echo "<font color=\"#FFA500\">".$db_theend->Record["date"]."</font><br> ";
      if($site_language=="en")
        echo "from";
      else
        echo "de la";
      echo " <a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["at_id"]."\"><b>".$db_theend->Record["username"]."</b></a><br>";

      if($db_theend->Record["win_id"]==$db_theend->Record["df_id"])
      {
        echo "<font color=\"#A0A0A0\">";
        if($site_language=="en")
          echo "You won.";
        else
          echo "Ai castigat.";
        echo "</font>";
      }
      else
      {
        echo "<font color=\"#A0A0A0\">";
        if($site_language=="en")
          echo "You lost.";
        else
          echo "Ai pierdut.";
        echo "</font>";
      }
  }
  else
    if($site_language=="en")
      echo "No attacks on you.";
    else 
      echo "Nici un atac.";   

  echo "</div>";
}

function last_spy_box()
{
  $site_language=site_language();	

  echo "<div class=\"right_box_black_spacer\"></div>";
  
  echo "<form name=\"form_last_spy\" action=\"play.php\" method=\"post\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"spy_log\" />";
  echo "<input type=\"hidden\" name=\"who\" value=\"others\" />";
  echo "</form>";
    
  echo "<div class=\"right_box_title\">";
  
  if($site_language=="ro")
    echo "<a href=\"#\" onClick=\"form_last_spy.submit();\"><img border=\"0\" alt=\"ultimul spionaj asupra ta\" src=\"pics/top_last_spy2.gif\" /></a>";
  else
    echo "<a href=\"#\" onClick=\"form_last_spy.submit();\"><img border=\"0\" alt=\"last spy on you\" src=\"pics/top_last_spy1.gif\" /></a>";  

  echo "</div>";  
  
  echo "<div class=\"right_box_white_spacer\"></div>";  
  
  echo "<div class=\"right_box\">";
  
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select spy_log.datetime, b.username, b.race, spy_log.at_id, spy_log.df_id, spy_log.win_id from spy_log, users b  where spy_log.df_id=".$_COOKIE["uid"]." and spy_log.at_id=b.id order by spy_log.datetime desc limit 1";
  $db_theend->query($query);
  $no_queries+=1;

  if($db_theend->num_rows())
  {
      $db_theend->next_record();
      echo "<font color=\"#FFA500\">".$db_theend->Record["datetime"]."</font><br> ";
      if($site_language=="en")
        echo "from";
      else
        echo "de la";
      echo " <a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["at_id"]."\"><b>".$db_theend->Record["username"]."</b></a><br>";

      if($db_theend->Record["win_id"]==$db_theend->Record["df_id"])
      {
        echo "<font color=\"#A0A0A0\">";
        if($site_language=="en")
          echo "Mission failed.";
        else
          echo "Misiune esuata.";
        echo "</font>";
      }
      else
      {
        echo "<font color=\"#A0A0A0\">";
        if($site_language=="en")
          echo "Mission succes.";
        else
          echo "Misiune reusita.";
        echo "</font>";
      }
  }
  else
    if($site_language=="en")
      echo "No spys on you.";
    else 
      echo "Nici un spionaj.";  

  echo "</div>";
}

function gazduiresite_box()
{
  echo "<a href=\"http://www.gazduiresite.ro\" target=\"_blank\" title=\"Gazduire oferita de gazduireSite.ro\"><img border=\"0\" width=\"120\" height=\"57\" src=\"pics/banners/gs.gif\" alt=\"Gazduire oferita de gazduireSite.ro\" /></a>";
}

function counter_box()
{
  $site_language=site_language();

  echo "<div class=\"right_box_black_spacer\"></div>";
  
  echo "<div class=\"right_box_title\">";
  
  if($site_language=="ro")
    echo "<img border=\"0\" alt=\"Jucatori\" src=\"pics/top_users2.gif\" />";
  else
    echo "<img border=\"0\" alt=\"Users\" src=\"pics/top_users1.gif\" />";  

  echo "</div>";  
  
  echo "<div class=\"right_box_white_spacer\"></div>";

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select a.users, b.online from (select count(id) as users from users) a, (select count(id) as online from online where online=1 and datetime>='".date("Y-m-d H:i:s", mktime(date(H), date(i)-10, date(s), date(m), date(d), date(Y)))."') b";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();
  $registered=$db_theend->Record["users"];
  $online=$db_theend->Record["online"];
  $visitors=$db_theend->Record["visitors"];
  
  echo "<div class=\"right_box\">";  

  if($site_language=="en")
    echo "<font color=\"#F0F0F0\">Registered: </font>";
  else
    echo "<font color=\"#F0F0F0\">Inregistrati: </font>";
    
  echo "<font color=\"#F0F0F0\">".number_format($registered)."</font>";
  echo "<br />";
  echo "<font color=\"#FFD700\">Online: </font><font color=\"#FFD700\">".$online."</font>";

  echo "</div>";
}

function ad_right()
{
  echo "<br />";
	
  $i=random_number(1,100);

  if($i<0) 
  {  
?>
<div class="adcontainer_120_640">
<!-- Game Advertising Online Skyscraper -->
<iframe marginheight="0" marginwidth="0" scrolling="no" frameborder="0" width="122" height="614" src="http://www.game-advertising-online.com/index.php?section=serve&id=223&output=html" target="_blank"></iframe><noframes><a href="http://www.game-advertising-online.com/" target="_blank">Game Advertising Online</a><br /> banner requires iframes</noframes>
<!-- END -->
</div>
<?php 
  } 
  if($i>0) 
  {
?>

<script type="text/javascript"><!--
google_ad_client = "pub-7634296240444560";
google_ad_width = 120;
google_ad_height = 600;
google_ad_format = "120x600_as";
google_ad_type = "text_image";
google_ad_channel = "";
google_color_border = "203040";
google_color_bg = "203040";
google_color_link = "FFD700";
google_color_text = "EEEEEE";
google_color_url = "F0F0F0";
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<?php  	
  }
?>
<br /><br />
<div class="adcontainer_125_125">
<!-- START ADTOLL.COM CODE V1.0 -->
<STYLE>
/* Style of "Your link" text link */
A.at_adv_here_350, A.at_pow_by_350 {font-family: Arial,Sans-Serif; font-size: 10px; font-style: normal; font-weight: normal; font-variant: normal; text-transform: none; color: #000099; text-decoration: none; }
/* Style of "Your link" text hover link */
A.at_adv_here_350:hover, A.at_pow_by_350:hover { color: #0000FF; text-decoration: underline; }
</STYLE>
<SCRIPT type="text/javascript">
/* Show "Your link"   [1]-Visible [0]-Not visible */
adtoll_see_your_ad_here = 1;
/* "Your link" text */
adtoll_your_text = "Advertise here";
/* Show "Powered by" link   [1]-Visible [0]-Not visible */
adtoll_show_powered_by = 1;
</SCRIPT>
<SCRIPT src="http://adserve.adtoll.com/js/at_ag_350.js" type="text/javascript"></SCRIPT>
<!-- END ADTOLL.COM CODE V1.0 -->
</div>
<?php
}

function ad_left()
{
?>
<script type="text/javascript"><!--
google_ad_client = "pub-7634296240444560";
google_ad_width = 120;
google_ad_height = 600;
google_ad_format = "120x600_as";
google_ad_type = "text_image";
google_ad_channel = "";
google_color_border = "203040";
google_color_bg = "203040";
google_color_link = "FFD700";
google_color_text = "EEEEEE";
google_color_url = "F0F0F0";
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<?php
}

function useralliancename2($uid)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select alliances.name, alliance_members.id_al from alliance_members, alliances where alliance_members.id_member=".$uid." and alliance_members.id_al=alliances.id and alliance_members.grade>=0";
  $db_theend->query($query);
  $no_queries+=1;
  if($db_theend->num_rows())
  {
    $db_theend->next_record();
    return $db_theend->Record["name"];
  }

  return ""; // nici o alianta
}

function useravatar2($uid,$race)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  global $no_queries;

  $query="select avatar from user_profile where id=".$uid;
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();
  if($db_theend->Record["avatar"]) return $db_theend->Record["avatar"];
  else return "pics/avatars/".$race."s.jpg";
}

function allianceavatar($alid,$race)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  global $no_queries;

  $query="select avatar from alliances where id=".$uid;
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();
  if($db_theend->Record["avatar"]) return $db_theend->Record["avatar"];
  else return "pics/avatars/".$race."s.jpg";
}

function random_number($li,$ls)
{
        srand ((float) microtime( )*1000000);
        $random_number = rand($li,$ls);
        return $random_number;
}

function power_attack($id)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select armory.attack, armory.elite_at, armory.untrained, armory.exp, armory.level, upgrades.attack as atlevel, users.race from armory, upgrades, users where armory.id=".$id." and armory.id=upgrades.id and armory.id=users.id";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();
  $atlevel=$db_theend->Record["atlevel"];
  $power=0;
  $atunits=$db_theend->Record["attack"];
  $eliteat=$db_theend->Record["elite_at"];
  $untrainedunits=$db_theend->Record["untrained"];

  if($db_theend->Record["race"]=="human")
  {
    $unitattackpower=5.5;
    $unitdefensepower=5.5;
    $eliteattackpower=11;
    $elitedefensepower=11;
    $untrainedattackpower=1.1;
    $untraineddefensepower=1.1;
  }
  if($db_theend->Record["race"]=="machine")
  {
    $unitattackpower=6;
    $unitdefensepower=5;
    $eliteattackpower=12;
    $elitedefensepower=10;
    $untrainedattackpower=1.2;
    $untraineddefensepower=1;
  }
  if($db_theend->Record["race"]=="alien")
  {
    $unitattackpower=5;
    $unitdefensepower=6;
    $eliteattackpower=10;
    $elitedefensepower=12;
    $untrainedattackpower=1;
    $untraineddefensepower=1.2;
  }

  $power=$power+$eliteat*$eliteattackpower+$atunits*$unitattackpower+$untrainedunits*$untrainedattackpower;

  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$id." and user_weapons.w1=weapons.id and weapons.type=1 order by weapons.power desc";
  $db_theend->query($query);
  $no_queries+=1;

  while($db_theend->next_record())
  {
      if($eliteat>0)
      {
          if($eliteat>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$eliteattackpower;
              $eliteat=$eliteat-$db_theend->Record["no"];
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$eliteat*$eliteattackpower;
              if($atunits>=$db_theend->Record["no"]-$eliteat)
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$eliteat)*$unitattackpower;
                $atunits=$atunits-($db_theend->Record["no"]-$eliteat);
              }
              else
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$atunits*$unitattackpower;
                if($untrainedunits>=$db_theend->Record["no"]-$eliteat-$atunits)
                {
                  $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$eliteat-$atunits)*$untrainedattackpower;
                  $untrainedunits=$untrainedunits-($db_theend->Record["no"]-$eliteat-$atunits);
                }
                else
                {
                  $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untrainedattackpower;
                  $untrainedunits=0;
                }
                $atunits=0;
              }
              $eliteat=0;
          }
      }
      else
      {
      if($atunits>0)
      {
          if($atunits>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$unitattackpower;
              $atunits=$atunits-$db_theend->Record["no"];
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$atunits*$unitattackpower;
              if($untrainedunits>=$db_theend->Record["no"]-$atunits)
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$atunits)*$untrainedattackpower;
                $untrainedunits=$untrainedunits-($db_theend->Record["no"]-$atunits);
              }
              else
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untrainedattackpower;
                $untrainedunits=0;
              }
              $atunits=0;
          }
      }
      else
      {
      if($untrainedunits>0)
      {
          if($untrainedunits>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$untrainedattackpower;
              $untrainedunits=$untrainedunits-$db_theend->Record["no"];
              if($untrainedunits<0)
              {
                $untrainedunits=0;
              }
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untrainedattackpower;
              $untrainedunits=0;
          }
      }
      else
      {
        $untrainedunits=0;
      }
      }
      }
  }

  return round($power+(($atlevel*10)/100)*$power);
}

function power_attack_with_precision($id)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select armory.attack, armory.elite_at, armory.untrained, armory.exp, armory.level, upgrades.attack as atlevel, upgrades.wprec, users.race from armory, upgrades, users where armory.id=".$id." and armory.id=upgrades.id and armory.id=users.id";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();
  $atlevel=$db_theend->Record["atlevel"];
  $power=0;
  $atunits=$db_theend->Record["attack"];
  $eliteat=$db_theend->Record["elite_at"];
  $untrainedunits=$db_theend->Record["untrained"];

  $wprecision=random_number(60+$db_theend->Record["wprec"]*4,100)/100;

  if($db_theend->Record["race"]=="human")
  {
    $unitattackpower=5.5;
    $unitdefensepower=5.5;
    $eliteattackpower=11;
    $elitedefensepower=11;
    $untrainedattackpower=1.1;
    $untraineddefensepower=1.1;
  }
  if($db_theend->Record["race"]=="machine")
  {
    $unitattackpower=6;
    $unitdefensepower=5;
    $eliteattackpower=12;
    $elitedefensepower=10;
    $untrainedattackpower=1.2;
    $untraineddefensepower=1;
  }
  if($db_theend->Record["race"]=="alien")
  {
    $unitattackpower=5;
    $unitdefensepower=6;
    $eliteattackpower=10;
    $elitedefensepower=12;
    $untrainedattackpower=1;
    $untraineddefensepower=1.2;
  }

  $power=$power+$eliteat*$eliteattackpower+$atunits*$unitattackpower+$untrainedunits*$untrainedattackpower;

  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$id." and user_weapons.w1=weapons.id and weapons.type=1 order by weapons.power desc";
  $db_theend->query($query);
  $no_queries+=1;

  $has_weapons=1;
  if(!$db_theend->num_rows())
  {
    $has_weapons=0;
  }

  while($db_theend->next_record())
  {
      if($eliteat>0)
      {
          if($eliteat>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$eliteattackpower*$wprecision;
              $eliteat=$eliteat-$db_theend->Record["no"];
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$eliteat*$eliteattackpower*$wprecision;
              if($atunits>=$db_theend->Record["no"]-$eliteat)
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$eliteat)*$unitattackpower*$wprecision;
                $atunits=$atunits-($db_theend->Record["no"]-$eliteat);
              }
              else
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$atunits*$unitattackpower*$wprecision;
                if($untrainedunits>=$db_theend->Record["no"]-$eliteat-$atunits)
                {
                  $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$eliteat-$atunits)*$untrainedattackpower*$wprecision;
                  $untrainedunits=$untrainedunits-($db_theend->Record["no"]-$eliteat-$atunits);
                }
                else
                {
                  $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untrainedattackpower*$wprecision;
                  $untrainedunits=0;
                }
                $atunits=0;
              }
              $eliteat=0;
          }
      }
      else
      {
      if($atunits>0)
      {
          if($atunits>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$unitattackpower*$wprecision;
              $atunits=$atunits-$db_theend->Record["no"];
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$atunits*$unitattackpower*$wprecision;
              if($untrainedunits>=$db_theend->Record["no"]-$atunits)
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$atunits)*$untrainedattackpower*$wprecision;
                $untrainedunits=$untrainedunits-($db_theend->Record["no"]-$atunits);
              }
              else
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untrainedattackpower*$wprecision;
                $untrainedunits=0;
              }
              $atunits=0;
          }
      }
      else
      {
      if($untrainedunits>0)
      {
          if($untrainedunits>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$untrainedattackpower*$wprecision;
              $untrainedunits=$untrainedunits-$db_theend->Record["no"];
              if($untrainedunits<0)
              {
                $untrainedunits=0;
              }
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untrainedattackpower*$wprecision;
              $untrainedunits=0;
          }
      }
      else
      {
        $untrainedunits=0;
      }
      }
      }
  }

  $result["power"]=round($power+(($atlevel*10)/100)*$power);
  if($has_weapons)
  {
    $result["precision"]=$wprecision*100;
  }
  else
  {
    $result["precision"]=0;
  }

  return $result;
}

function power_defense($id)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select armory.untrained, armory.attack, armory.elite_df, armory.untrained, armory.exp, armory.level, upgrades.defense as dflevel, users.race from armory, upgrades, users where armory.id=".$id." and armory.id=upgrades.id and armory.id=users.id";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();
  $dflevel=$db_theend->Record["dflevel"];
  $power=0;
  $dfunits=$db_theend->Record["attack"];
  $elitedf=$db_theend->Record["elite_df"];
  $untrainedunits=$db_theend->Record["untrained"];

  if($db_theend->Record["race"]=="human")
  {
    $unitattackpower=5.5;
    $unitdefensepower=5.5;
    $eliteattackpower=11;
    $elitedefensepower=11;
    $untrainedattackpower=1.1;
    $untraineddefensepower=1.1;
  }
  if($db_theend->Record["race"]=="machine")
  {
    $unitattackpower=6;
    $unitdefensepower=5;
    $eliteattackpower=12;
    $elitedefensepower=10;
    $untrainedattackpower=1.2;
    $untraineddefensepower=1;
  }
  if($db_theend->Record["race"]=="alien")
  {
    $unitattackpower=5;
    $unitdefensepower=6;
    $eliteattackpower=10;
    $elitedefensepower=12;
    $untrainedattackpower=1;
    $untraineddefensepower=1.2;
  }

  $power=$power+$elitedf*$elitedefensepower+$dfunits*$unitdefensepower+$untrainedunits*$untraineddefensepower;

  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$id." and user_weapons.w1=weapons.id and weapons.type=0 order by weapons.power desc";
  $db_theend->query($query);
  $no_queries+=1;

  while($db_theend->next_record())
  {
      if($elitedf>0)
      {
          if($elitedf>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$elitedefensepower;
              $elitedf=$elitedf-$db_theend->Record["no"];
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$elitedf*$elitedefensepower;
              if($dfunits>=$db_theend->Record["no"]-$elitedf)
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$elitedf)*$unitdefensepower;
                $dfunits=$dfunits-($db_theend->Record["no"]-$elitedf);
              }
              else
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$dfunits*$unitdefensepower;
                if($untrainedunits>=$db_theend->Record["no"]-$elitedf-$dfunits)
                {
                  $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$elitedf-$dfunits)*$untraineddefensepower;
                  $untrainedunits=$untrainedunits-($db_theend->Record["no"]-$elitedf-$dfunits);
                }
                else
                {
                  $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untraineddefensepower;
                  $untrainedunits=0;
                }
                $dfunits=0;
              }
              $elitedf=0;
          }
      }
      else
      {
      if($dfunits>0)
      {
          if($dfunits>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$unitdefensepower;
              $dfunits=$dfunits-$db_theend->Record["no"];
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$dfunits*$unitdefensepower;
              if($untrainedunits>=$db_theend->Record["no"]-$dfunits)
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$dfunits)*$untraineddefensepower;
                $untrainedunits=$untrainedunits-($db_theend->Record["no"]-$dfunits);
              }
              else
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untraineddefensepower;
                $untrainedunits=0;
              }
              $dfunits=0;
          }
      }
      else
      {
      if($untrainedunits>0)
      {
          if($untrainedunits>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$untraineddefensepower;
              $untrainedunits=$untrainedunits-$db_theend->Record["no"];
              if($untrainedunits<0)
              {
                $untrainedunits=0;
              }
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untraineddefensepower;
              $untrainedunits=0;
          }
      }
      else
      {
        $untrainedunits=0;
      }
      }
      }
  }

  return round($power+(($dflevel*10)/100)*$power);
}

function power_defense_with_precision($id)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select armory.untrained, armory.attack, armory.elite_df, armory.untrained, armory.exp, armory.level, upgrades.defense as dflevel, upgrades.wprec, users.race from armory, upgrades, users where armory.id=".$id." and armory.id=upgrades.id and armory.id=users.id";
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();
  $dflevel=$db_theend->Record["dflevel"];
  $power=0;
  $dfunits=$db_theend->Record["attack"];
  $elitedf=$db_theend->Record["elite_df"];
  $untrainedunits=$db_theend->Record["untrained"];

  $wprecision=random_number(60+$db_theend->Record["wprec"]*4,100)/100;

  if($db_theend->Record["race"]=="human")
  {
    $unitattackpower=5.5;
    $unitdefensepower=5.5;
    $eliteattackpower=11;
    $elitedefensepower=11;
    $untrainedattackpower=1.1;
    $untraineddefensepower=1.1;
  }
  if($db_theend->Record["race"]=="machine")
  {
    $unitattackpower=6;
    $unitdefensepower=5;
    $eliteattackpower=12;
    $elitedefensepower=10;
    $untrainedattackpower=1.2;
    $untraineddefensepower=1;
  }
  if($db_theend->Record["race"]=="alien")
  {
    $unitattackpower=5;
    $unitdefensepower=6;
    $eliteattackpower=10;
    $elitedefensepower=12;
    $untrainedattackpower=1;
    $untraineddefensepower=1.2;
  }

  $power=$power+$elitedf*$elitedefensepower+$dfunits*$unitdefensepower+$untrainedunits*$untraineddefensepower;

  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$id." and user_weapons.w1=weapons.id and weapons.type=0 order by weapons.power desc";
  $db_theend->query($query);
  $no_queries+=1;

  $has_weapons=1;
  if(!$db_theend->num_rows())
  {
    $has_weapons=0;
  }

  while($db_theend->next_record())
  {
      if($elitedf>0)
      {
          if($elitedf>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$elitedefensepower*$wprecision;
              $elitedf=$elitedf-$db_theend->Record["no"];
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$elitedf*$elitedefensepower*$wprecision;
              if($dfunits>=$db_theend->Record["no"]-$elitedf)
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$elitedf)*$unitdefensepower*$wprecision;
                $dfunits=$dfunits-($db_theend->Record["no"]-$elitedf);
              }
              else
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$dfunits*$unitdefensepower*$wprecision;
                if($untrainedunits>=$db_theend->Record["no"]-$elitedf-$dfunits)
                {
                  $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$elitedf-$dfunits)*$untraineddefensepower*$wprecision;
                  $untrainedunits=$untrainedunits-($db_theend->Record["no"]-$elitedf-$dfunits);
                }
                else
                {
                  $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untraineddefensepower*$wprecision;
                  $untrainedunits=0;
                }
                $dfunits=0;
              }
              $elitedf=0;
          }
      }
      else
      {
      if($dfunits>0)
      {
          if($dfunits>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$unitdefensepower*$wprecision;
              $dfunits=$dfunits-$db_theend->Record["no"];
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$dfunits*$unitdefensepower*$wprecision;
              if($untrainedunits>=$db_theend->Record["no"]-$dfunits)
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*($db_theend->Record["no"]-$dfunits)*$untraineddefensepower*$wprecision;
                $untrainedunits=$untrainedunits-($db_theend->Record["no"]-$dfunits);
              }
              else
              {
                $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untraineddefensepower*$wprecision;
                $untrainedunits=0;
              }
              $dfunits=0;
          }
      }
      else
      {
      if($untrainedunits>0)
      {
          if($untrainedunits>=$db_theend->Record["no"])
          {
              $power=$power+$db_theend->Record["proc"]*$untraineddefensepower*$wprecision;
              $untrainedunits=$untrainedunits-$db_theend->Record["no"];
              if($untrainedunits<0)
              {
                $untrainedunits=0;
              }
          }
          else
          {
              $power=$power+$db_theend->Record["proc"]/$db_theend->Record["no"]*$untrainedunits*$untraineddefensepower*$wprecision;
              $untrainedunits=0;
          }
      }
      else
      {
        $untrainedunits=0;
      }
      }
      }
  }

  $result["power"]=round($power+(($dflevel*10)/100)*$power);

  if($has_weapons==1)
  {
    $result["precision"]=$wprecision*100;
  }
  else
  {
    $result["precision"]=0;
  }

  return $result;
}

function power_spy($id)
{
  $db = new DataBase_theend;
  $db->connect();
  
  $query="select armory.spy as spies, upgrades.spy as spylevel from armory, upgrades where armory.id=".$id." and upgrades.id=armory.id";
  $db->query($query);
  $db->next_record();
  $spies=$db->Record["spies"];
  $spylevel=$db->Record["spylevel"];
  
  $unitspypower=5;
  
  $power=0;
  
  $power=$power+$spies*$unitspypower;
  
  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$id." and user_weapons.w1=weapons.id and weapons.type=3 order by weapons.power desc";
  $db->query($query); 
  while($db->next_record())
  {
    if($spies>0)
    {
      if($spies>=$db->Record["no"])
      {
        $power=$power+$db->Record["proc"]*$unitspypower;
        $spies=$spies-$db->Record["no"];      	
      }
      else
      {
      	$power=$power+$db->Record["proc"]/$db->Record["no"]*$spies*$unitspypower;
      	$spies=0;
      }
    }
  }
  
  $power=round($power+(($spylevel*10)/100)*$power);
  	
  return $power;	
}

function power_sentry($id)
{  
  $db = new DataBase_theend;
  $db->connect();
  
  $query="select armory.antispy as sentries, upgrades.antispy as sentrylevel from armory, upgrades where armory.id=".$id." and upgrades.id=armory.id";
  $db->query($query);
  $db->next_record();
  $sentries=$db->Record["sentries"];
  $sentrylevel=$db->Record["sentrylevel"];
  
  $unitsentrypower=5;
  
  $power=0;
  
  $power=$power+$sentries*$unitsentrypower;
  
  $query="select weapons.power as power, user_weapons.now1 as no, user_weapons.procw1 as proc from weapons, user_weapons where user_weapons.id=".$id." and user_weapons.w1=weapons.id and weapons.type=4 order by weapons.power desc";
  $db->query($query); 
  while($db->next_record())
  {
    if($sentries>0)
    {
      if($sentries>=$db->Record["no"])
      {
        $power=$power+$db->Record["proc"]*$unitsentrypower;
        $sentries=$sentries-$db->Record["no"];      	
      }
      else
      {
      	$power=$power+$db->Record["proc"]/$db->Record["no"]*$sentries*$unitsentrypower;
      	$sentries=0;
      }
    }
  }
  
  $power=round($power+(($sentrylevel*10)/100)*$power);
  	
  return $power;
}

function power_attack_alliance($id)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $power=0;
  $i=0;

  $query="select alliance_members.id_member from alliance_members, online where alliance_members.id_al=".$id." and alliance_members.grade>=0 and alliance_members.id_member=online.id and online.online>=0";
  $db_theend->query($query);
  $no_queries+=1;
  if(!$db_theend->num_rows()) return 0;
  while($db_theend->next_record())
  {
          $power=$power+power_attack($db_theend->Record["id_member"]);
          $i++;
  }

  return $power;
}

function power_defense_alliance($id)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $power=0;
  $i=0;

  $query="select alliance_members.id_member from alliance_members, online where alliance_members.id_al=".$id." and alliance_members.grade>=0 and alliance_members.id_member=online.id and online.online>=0";
  $db_theend->query($query);
  $no_queries+=1;
  if(!$db_theend->num_rows()) return 0;
  while($db_theend->next_record())
  {
          $power=$power+power_defense($db_theend->Record["id_member"]);
          $i++;
  }

  return $power;
}

function useralliance2($uid)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select id_al from alliance_members where id_member=".$uid." and grade>=0";
  $db_theend->query($query);
  $no_queries+=1;
  if($db_theend->num_rows())
  {
    $db_theend->next_record();
    return $db_theend->Record["id_al"];
  }

  return -1; // nici o alianta
}

function userid($user)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select id from users where username='".$user."'";
  $db_theend->query($query);
  $no_queries+=1;
  if($db_theend->num_rows())
  {
    $db_theend->next_record();
    return $db_theend->Record["id"];
  }
  return 0; // user does not exists
}

function username($id)
{
  global $no_queries;

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select username from users where id='".$id."'";
  $db_theend->query($query);
  $no_queries+=1;
  if($db_theend->num_rows())
  {
    $db_theend->next_record();
    return $db_theend->Record["username"];
  }
  return 0; // user does not exists
}

function ad_zones()
{
  echo "<script type=\"text/javascript\" language=\"JavaScript\">";
  echo "document.getElementById('bottom_ad').innerHTML=\"<!-- Begin: AdBrite --><script type=\\\"text/javascript\\\">   var AdBrite_Title_Color = 'F00000';   var AdBrite_Text_Color = 'FFD700';   var AdBrite_Background_Color = '200000';   var AdBrite_Border_Color = '200000';</script><span style=\\\"white-space:nowrap;\\\"><script src=\\\"http://ads.adbrite.com/mb/text_group.php?sid=182601&zs=3732385f3930\\\" type=\\\"text/javascript\\\"></script><!-- --><a target=\\\"_top\\\" href=\\\"http://www.adbrite.com/mb/commerce/purchase_form.php?opid=182601&afsid=1\\\"><img src=\\\"http://files.adbrite.com/mb/images/adbrite-your-ad-here-leaderboard-w.gif\\\" style=\\\"background-color:#102030\\\" alt=\\\"Your Ad Here\\\" width=\\\"14\\\" height=\\\"90\\\" border=\\\"0\\\"></a></span><!-- End: AdBrite -->\";";
  echo "</script>";
}

function semafor_on($uid)
{

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $semafor=0;
  $try=0;

  $acceptedChars = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789';
  $max = strlen($acceptedChars)-1;
  $semafor_key = null;
  for($i=0; $i < 64; $i++) {
   $semafor_key .= $acceptedChars[mt_rand(0, $max)];
  }

  while(!$semafor && $try<50)
  {
    $query="update semafor set armory=1, skey='".$semafor_key."' where id=".$uid." and armory=0";
    $db_theend->query($query);

    $query="select armory, skey from semafor where id=".$uid;
    $db_theend->query($query);
    $db_theend->next_record();

    if($db_theend->Record["armory"]==1 && $db_theend->Record["skey"]==$semafor_key)
      $semafor=1;
    if(!$semafor)
    {
      usleep(100000);
      $try++;
    }
  }
  if($try>=50)
  {
    $handler=fopen("semafor.log","a");
    fwrite($handler,"\n".date("Y-m-d H:i:s")." Semafor error on user ".$uid);
    fclose($handler);
  }
  return 1;
}

function semafor_off($uid)
{

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="update semafor set armory=0, skey='' where id=".$uid;
  $db_theend->query($query);

  return 1;
}

function rank_value($id)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $query="select armory.spy as spies, armory.antispy as sentries, upgrades.spy, upgrades.antispy from armory, upgrades where armory.id=".$id." and armory.id=upgrades.id";
  $db_theend->query($query);
  $db_theend->next_record();

  $attack_rank_value=power_attack($id);
  $defense_rank_value=power_defense($id);
  $spy_rank_value=round($db->Record["spies"]+$db->Record["spies"]*$db->Record["spy"]/10);
  $sentry_rank_value=round($db->Record["sentries"]+$db->Record["sentries"]*$db->Record["antispy"]/10);

  $rank_value=$attack_rank_value+$defense_rank_value+$spy_rank_value+$sentry_rank_value;

  return $rank_value;
}

function safechar($string)
{
   return str_replace ( array ( '&', '"', "'", '<', '>', '?' ), array ( '&amp;' , '&quot;', '&#39;' , '&lt;' , '&gt;', '?' ), $string );
}

function ad_left_small()
{
  $number=random_number(1,100);
  if($number<=25)
  {
    echo "<div align=\"center\"><table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\"><tr><td bgcolor=\"102030\"><a href=\"pics/banners/Poster_1_493.jpg\" target=\"_blank\"><img border=\"0\" width=\"120\" src=\"pics/banners/Poster_1_493_sm.jpg\"></img></a></td></tr></table></div>";
  }
  else
  if($number<=50)
  {
    echo "<div align=\"center\"><table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\"><tr><td bgcolor=\"102030\"><a href=\"pics/banners/Poster_2_494.jpg\" target=\"_blank\"><img border=\"0\" width=\"120\" src=\"pics/banners/Poster_2_494_sm.jpg\"></img></a></td></tr></table></div>";

  }
  else
  if($number<=75)
  {
    echo "<div align=\"center\"><table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\"><tr><td bgcolor=\"102030\"><a href=\"pics/banners/Poster_3_495.jpg\" target=\"_blank\"><img border=\"0\" width=\"120\" src=\"pics/banners/Poster_3_495_sm.jpg\"></img></a></td></tr></table></div>";

  }
  else
  if($number<=100)
  {
    echo "<div align=\"center\"><table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\"><tr><td bgcolor=\"102030\"><a href=\"pics/banners/Poster_4_496.jpg\" target=\"_blank\"><img border=\"0\" width=\"120\" src=\"pics/banners/Poster_4_496_sm.jpg\"></img></a></td></tr></table></div>";

  }
}

function check_login()
{
  error_reporting(0);
  $db = new DataBase_theend;
  $db->connect();

  $datetime=getdate();

  $login=1;
  if(!$_COOKIE["uid"])
  {
  	return 0;
  }

  if(time()>$_COOKIE["svtime"]+15*60)
  {
    setcookie("user","",mktime(0,0,0,1,1,1980));
    setcookie("uid","",mktime(0,0,0,1,1,1980));
    setcookie("code1","",mktime(0,0,0,1,1,1980));
    setcookie("code2","",mktime(0,0,0,1,1,1980));
    $login=0;
    $query="update online set online=0, datetime='".date("Y-m-d H:i:s")."', seconds_day=seconds_day+".time()."-login_time where id=".$_COOKIE["uid"]." and online=1";
    $db->query($query);
    return 0;
  }
  else
  {
    $query="select users.id, users.username, users.password, users.race, armory.lastacct from users, armory where users.id=".$_COOKIE["uid"]." and users.id=armory.id";
    $db->query($query);
    $db->next_record();
    $lastacct=$db->Record["lastacct"];
    $race=$db->Record["race"];
    $userid=$db->Record["id"];
    $username=$db->Record["username"];
    $password=$db->Record["password"];

    if($_COOKIE["code1"]!=md5($username) || $_COOKIE["code2"]!=md5($password))
    {
      setcookie("user","",mktime(0,0,0,1,1,1980));
      setcookie("uid","",mktime(0,0,0,1,1,1980));
      setcookie("code1","",mktime(0,0,0,1,1,1980));
      setcookie("code2","",mktime(0,0,0,1,1,1980));
      $login=0;
      //$query="update online set online=0, datetime='".date("Y-m-d H:i:s")."', seconds_day=seconds_day+".time()."-login_time where id=".$_COOKIE["uid"];
      //$db->query($query);
      return 0;
    }

    if(time()>$_COOKIE["online"]+3600)
    {
      setcookie("user","",mktime(0,0,0,1,1,1980));
      setcookie("uid","",mktime(0,0,0,1,1,1980));
      setcookie("code1","",mktime(0,0,0,1,1,1980));
      setcookie("code2","",mktime(0,0,0,1,1,1980));
      $login=0;
      $query="update online set online=0, datetime='".date("Y-m-d H:i:s")."', seconds_day=seconds_day+".time()."-login_time where id=".$_COOKIE["uid"]." and online=1";
      $db->query($query);
      return 0;
    }
    else
    {
      $login_expires=$_COOKIE["online"]-3600-time();
    }

    setcookie("svtime","".time());
    $query="update online set online=1, datetime='".date("Y-m-d H:i:s")."' where id=".$_COOKIE["uid"];
    $db->query($query);
    return 1;
  }
}

?>
