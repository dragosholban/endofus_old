<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php

include "functions.php";
include "database.php";
include "monitors.php";

$db = new DataBase_theend;
$db->connect();

if($_GET["from"])
{
  $query="insert into referals values(DEFAULT,'".$_GET["from"]."','".getenv("REMOTE_ADDR")."','".date("Y-m-d H:i:s")."')";
  $db->query($query);
}
if($_GET["ref"] && (GregorianToJD(date("m"),date("d"),date("Y"))-GregorianToJD(8,12,2007)<=0) && is_numeric($_GET["ref"]))
{
	$ip=getenv("REMOTE_ADDR");
    $hostname = gethostbyaddr($ip);
    $forwarded_for=getenv("HTTP_X_FORWARDED_FOR");

    $new_cookie=0;
    if(!$_COOKIE["seid"])
    {
      $computer=md5(getenv('REMOTE_ADDR').microtime());
      setcookie("seid","".$computer,mktime(0,0,0,12,31,2020));
      $new_cookie=1;
    }
    else
    {
      $computer=$_COOKIE["seid"];
      $new_cookie=0;
    }
    if(strpos($hostname, "googlebot.com") === false)
    {
      $query="select ip from user_referals where user_id=".$_GET["ref"]." and ip='".$ip."' and data>='".date("Y-m-d 00:00:00")."'";
      $db->query($query);
      if(!$db->num_rows())
      {
        $query="insert into user_referals values(".$_GET["ref"].",'".$ip."','".$hostname."','".$forwarded_for."','".$computer."','".date("Y-m-d H:i:s")."')";
        $db->query($query);
      }
    }
}
$site_language=site_language();

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
        <?php main_menu(); ?>
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
        <div class="titlebar">END OF US</div>
        <br />
        <div class="section">
        <div class="section_black">
        <div class="section_grey">
<?php
  if($site_language=="ro")
  {
    echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/planet.jpg\" alt=\"\" /></div>";
    echo "<div class=\"text1\">";
    echo "<br>";
    echo "<font color=\"#FFA500\">Este anul 2878: 7 ani de cand PNSR s-a intors, 2 ani de cand extraterestrii au incercat sa preia controlul.</font>";
    echo "<br>";
    echo "<font color=\"#A0A0A0\">";
    echo "Pamantul este o planeta moarta, peste tot misunand masini, extraterestrii si oameni care incearca disperati sa supravietuiasca in mediul neprimitor. Un razboi lung care nu prevesteste nici un castigator, doar un drum lung pentru fiecare dintre parti.";
    echo "</font>";
    echo "<br><br>";
    echo "Cine va reusi sa triumfe doar timpul ne va spune, lasandu-ne doar 2 optiuni: <font color=\"#00FF00\">sa fim observatori impartiali sau sa luam parte in aceasta confruntare</font>.";
    echo "</div>";
   }
   else
   {
    echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/planet.jpg\" alt=\"\" /></div>";
    echo "<div class=\"text1\">";
    echo "<br>";
    echo "<font color=\"#FFA500\">Year is 2878: 7 years since FRSS returned, 2 years since the aliens tried to take control.</font>";
    echo "<br>";
    echo "<font color=\"#A0A0A0\">";
    echo "Earth is now a dead planet, everywhere lurking machines, aliens or humans that are trying so survive in the harsh environment. A long war that doesn't foresees any winners but only a long way for each of the sides.";
    echo "</font>";
    echo "<br><br>";
    echo "Which will prevail only time will tell, letting us 2 options: <font color=\"#00FF00\">to be observers or to take part in this great war</font>.";
    echo "</div>";
   }
?>          
        <div class="spacer"><!-- --></div>
		</div>
        </div>
        </div>
        <br />
<?php
        echo "<div class=\"titlebar\">";
        if($site_language=="ro")
          echo "OAMENI";
        else 
          echo "HUMANS";  
        echo "</div>";
?>        
        <br />
        <div class="section">
        <div class="section_black">
        <div class="section_grey">
<?php
  $query="select sum(armory.units) as units from users, armory, online where users.race='human' and users.id=armory.id and users.id=online.id and online.online>=0";
  $db->query($query);
  $db->next_record();
  $humans=$db->Record["units"];

  $query="select sum(armory.units) as units from armory, online where armory.id=online.id and online.online>=0";
  $db->query($query);
  $db->next_record();
  $total=$db->Record["units"];

  if($site_language=="ro")
  {
    echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/avatars/humans.jpg\" alt=\"\" /></div>";
    echo "<div class=\"text1\">";
    echo "<br>";    
    echo "Oamenii au curajul si scopul lor comun, fiind uniti in fata distrugerii totale.";
    echo "<br>";
    echo "<font color=\"#A0A0A0\">";
    echo "Oamenii inca controleaza ".number_format($humans*100/($total),2)."% din suprafata planetei.";
    echo "</font>";
    echo "<br><br>";
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"130\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\"><tr><td background=\"pics/bluebar.gif\" width=\"".($humans*130/($total))."\" height=\"10\"></td></tr></table></td></table>";
    echo "<br>";
    echo "<font color=\"#00FF00\">Bonus rasa: +10% atac, +10% aparare</font>";
    echo "<br><br>";
    echo "</div>";
   }
   else
   {
    echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/avatars/humans.jpg\" alt=\"\" /></div>";
    echo "<div class=\"text1\">";
    echo "<br>";    
    echo "The humans have their courage and common goal, being united in the face of total destruction.";
    echo "<br>";
    echo "<font color=\"#A0A0A0\">";
    echo "Humans are still having control of ".number_format($humans*100/($total),2)."% of the Earth.";
    echo "</font>";
    echo "<br><br>";
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"130\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\"><tr><td background=\"pics/bluebar.gif\" width=\"".($humans*130/($total))."\" height=\"10\"></td></tr></table></td></table>";
    echo "<br>";
    echo "<font color=\"#00FF00\">Race bonus: +10% attack, +10% defense</font>";
    echo "<br><br>";
    echo "</div>";
   }
?>         
        <div class="spacer"><!-- --></div>
		</div>
        </div>
        </div>
        <br />        
<?php
        echo "<div class=\"titlebar\">";
        if($site_language=="ro")
          echo "MASINI";
        else 
          echo "MACHINES";  
        echo "</div>";
?> 
        <br />
        <div class="section">
        <div class="section_black">
        <div class="section_grey">
<?php
  $query="select sum(armory.units) as units from users, armory, online where users.race='machine' and users.id=armory.id and users.id=online.id and online.online>=0";
  $db->query($query);
  $db->next_record();
  $machines=$db->Record["units"];

  if($site_language=="ro")
  {
    echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/avatars/machines.jpg\" alt=\"\" /></div>";
    echo "<div class=\"text1\">";
    echo "<br>";    
    echo "Masinile, cu actiunile rapide si precise, aduc moarte tuturor din jurul lor.";
    echo "<br>";
    echo "<font color=\"#A0A0A0\">";
    echo "Masinile au reusit sa cucereasca ".number_format($machines*100/($total),2)."% din Terra.";
    echo "</font>";
    echo "<br><br>";
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"130\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\"><tr><td background=\"pics/greenbar.gif\" width=\"".($machines*130/($total))."\" height=\"10\"></td></tr></table></td></table>";
    echo "<br>";
    echo "<font color=\"#00FF00\">Bonus rasa: +20% atac</font>";
    echo "<br><br>";
    echo "</div>";
   }
   else
   {
    echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/avatars/machines.jpg\" alt=\"\" /></div>";
    echo "<div class=\"text1\">";
    echo "<br>";    
    echo "The machines with their precise and quick actions bring death to anything around them.";
    echo "<br>";
    echo "<font color=\"#A0A0A0\">";
    echo "Machines managed to conquer ".number_format($machines*100/($total),2)."% of the Earth..";
    echo "</font>";
    echo "<br><br>";
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"130\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\"><tr><td background=\"pics/greenbar.gif\" width=\"".($machines*130/($total))."\" height=\"10\"></td></tr></table></td></table>";
    echo "<br>";
    echo "<font color=\"#00FF00\">Race bonus: +20% attack</font>";
    echo "<br><br>";
    echo "</div>";
   }
?>         
        <div class="spacer"><!-- --></div>
		</div>
        </div>
        </div>
        <br />        
<?php
        echo "<div class=\"titlebar\">";
        if($site_language=="ro")
          echo "EXTRATERESTRII";
        else 
          echo "ALIENS";  
        echo "</div>";
?> 
        <br />
        <div class="section">
        <div class="section_black">
        <div class="section_grey">
<?php
  $query="select sum(armory.units) as units from users, armory, online where users.race='alien' and users.id=armory.id and users.id=online.id and online.online>=0";
  $db->query($query);
  $db->next_record();
  $aliens=$db->Record["units"];

  if($site_language=="ro")
  {
    echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/avatars/aliens.jpg\" alt=\"\" /></div>";
    echo "<div class=\"text1\">";
    echo "<br>";    
    echo "Extraterestrii se tarasc prin intuneric, inselatori precum umbrele trecutului care se uita cu ochi lacomi spre victimele nebanuitoare.";
    echo "<br>";
    echo "<font color=\"#A0A0A0\">";
    echo "Extraterestrii sunt imprastiati pe ".number_format($aliens*100/($total),2)."% din Terra.";
    echo "</font>";
    echo "<br><br>";
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"130\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\"><tr><td background=\"pics/redbar.gif\" width=\"".($aliens*130/($total))."\" height=\"10\"></td></tr></table></td></table>";
    echo "<br>";
    echo "<font color=\"#00FF00\">Bonus rasa: +20% aparare</font>";
    echo "<br><br>";
    echo "</div>";
   }
   else
   {
    echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/avatars/aliens.jpg\" alt=\"\" /></div>";
    echo "<div class=\"text1\">";
    echo "<br>";    
    echo "The aliens lurk in the dark, cunning as the shadows of the past that prowl around the unsuspecting victims.";
    echo "<br>";
    echo "<font color=\"#A0A0A0\">";
    echo "Aliens are spread around on ".number_format($aliens*100/($total),2)."% of the Earth.";
    echo "</font>";
    echo "<br><br>";
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"130\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\"><tr><td background=\"pics/redbar.gif\" width=\"".($aliens*130/($total))."\" height=\"10\"></td></tr></table></td></table>";
    echo "<br>";
    echo "<font color=\"#00FF00\">Race bonus: +20% defense</font>";
    echo "<br><br>";
    echo "</div>";
   }
?>          
        <div class="spacer"><!-- --></div>
		</div>
        </div>
        </div>
        <br />        
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
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-7908737-1");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>

</html>
