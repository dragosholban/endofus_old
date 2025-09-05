<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include "functions.php";
include "database.php";
include "monitors.php";

$site_language=site_language();

function show_population()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();

  $query="select sum(armory.units) as units from users, armory, online where users.race='human' and users.id=armory.id and users.id=online.id and online.online>=0";
  $db_theend->query($query);
  $db_theend->next_record();
  $humans=$db_theend->Record["units"];

  $query="select sum(armory.units) as units from users, armory, online where users.race='machine' and users.id=armory.id and users.id=online.id and online.online>=0";
  $db_theend->query($query);
  $db_theend->next_record();
  $machines=$db_theend->Record["units"];

  $query="select sum(armory.units) as units from users, armory, online where users.race='alien' and users.id=armory.id and users.id=online.id and online.online>=0";
  $db_theend->query($query);
  $db_theend->next_record();
  $aliens=$db_theend->Record["units"];

  $query="select sum(armory.workers) as workers from users, armory, online where users.race='human' and users.id=armory.id and users.id=online.id and online.online>=0";
  $db_theend->query($query);
  $db_theend->next_record();
  $workers=$db_theend->Record["workers"];

  $query="select sum(armory.workers) as workers from users, armory, online where users.race='alien' and users.id=armory.id and users.id=online.id and online.online>=0";
  $db_theend->query($query);
  $db_theend->next_record();
  $slavesalien=$db_theend->Record["workers"];

  $query="select sum(armory.workers) as workers from users, armory, online where users.race='machine' and users.id=armory.id and users.id=online.id and online.online>=0";
  $db_theend->query($query);
  $db_theend->next_record();
  $slavesmachine=$db_theend->Record["workers"];

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Humans:";
  else
    echo "Oameni:";
  echo "</div>";  
  echo "<div class=\"st2\">";
  echo number_format($humans);
  if($site_language=="en")
    echo " units";
  else
    echo " unitati";
  echo "</div>";
    
  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($humans*100/($humans+$machines+$aliens))."%\"><tr><td background=\"pics/bluebar.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Machines:";
  else
    echo "Masini:";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo number_format($machines);
  if($site_language=="en")
    echo " units";
  else
    echo " unitati";
  echo "</div>";  

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($machines*100/($humans+$machines+$aliens))."%\"><tr><td background=\"pics/greenbar.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Aliens:";
  else
    echo "Extraterestrii:";
  echo "</div>";  
  echo "<div class=\"st2\">";
  echo number_format($aliens);
  if($site_language=="en")
    echo " units";
  else
    echo " unitati";
  echo "</div>";  

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($aliens*100/($humans+$machines+$aliens))."%\"><tr><td background=\"pics/redbar.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  echo "<font color=\"#FFD700\">Total:</font>";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo "<font color=\"#FFD700\">".number_format(($humans+$machines+$aliens));
  if($site_language=="en")
    echo " units";
  else
    echo " unitati";
  echo "</font>";
  echo "</div>";
        
  echo "</div>";
  echo "</div>";
  echo "</div>";
         
  echo "<br />";
}

function show_gold()
{
$db_theend = new DataBase_theend;
$db_theend->connect();

$site_language=site_language();

        $query="select sum(armory.gold + seif.gold) as gold from users, armory, seif, online where users.race='human' and users.id=armory.id and users.id=seif.uid and users.id=online.id and online.online>=0";
        $db_theend->query($query);
        $db_theend->next_record();
        $humans=$db_theend->Record["gold"];

        $query="select sum(armory.gold + seif.gold) as gold from users, armory, seif, online where users.race='machine' and users.id=armory.id and users.id=seif.uid and users.id=online.id and online.online>=0";
        $db_theend->query($query);
        $db_theend->next_record();
        $machines=$db_theend->Record["gold"];

        $query="select sum(armory.gold + seif.gold) as gold from users, armory, seif, online where users.race='alien' and users.id=armory.id and users.id=seif.uid and users.id=online.id and online.online>=0";
        $db_theend->query($query);
        $db_theend->next_record();
        $aliens=$db_theend->Record["gold"];

  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";  
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Humans:";
  else
    echo "Oameni:";
  echo "</div>";  
  echo "<div class=\"st2\">";
  echo number_format($humans);
  if($site_language=="en")
    echo " EKR";
  else
    echo " EKR";
  echo "</div>";

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($humans*100/($humans+$machines+$aliens))."%\"><tr><td background=\"pics/bluebar.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Machines:";
  else
    echo "Masini:";
  echo "</div>";  
  echo "<div class=\"st2\">";
  echo number_format($machines);
  if($site_language=="en")
    echo " EKR";
  else
    echo " EKR";
  echo "</div>";

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($machines*100/($humans+$machines+$aliens))."%\"><tr><td background=\"pics/greenbar.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Aliens:";
  else
    echo "Extraterestrii:";
  echo "</div>";  
  echo "<div class=\"st2\">";
  echo number_format($aliens);
  if($site_language=="en")
    echo " EKR";
  else
    echo " EKR";
  echo "</div>";
  
  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($aliens*100/($humans+$machines+$aliens))."%\"><tr><td background=\"pics/redbar.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  echo "<font color=\"#FFD700\">Total:</font>";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo "<font color=\"#FFD700\">".number_format(($humans+$machines+$aliens));
  if($site_language=="en")
    echo " EKR";
  else
    echo " EKR";
  echo "</font>";  
  echo "</div>";
        
  echo "</div>";
  echo "</div>";
  echo "</div>";
        
  echo "<br />";
}

function show_attacks()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();

  $query="select count(attack_log.date) as humans from attack_log, users where attack_log.date>='".date("Y-m-d", mktime(0,0,0, date(m), date(d), date(Y)))."' and attack_log.at_id=users.id and users.race='human'";
  $db_theend->query($query);
  $db_theend->next_record();
  $humans=$db_theend->Record["humans"];

  $query="select count(attack_log.date) as machines from attack_log, users where attack_log.date>='".date("Y-m-d", mktime(0,0,0, date(m), date(d), date(Y)))."' and attack_log.at_id=users.id and users.race='machine'";
  $db_theend->query($query);
  $db_theend->next_record();
  $machines=$db_theend->Record["machines"];

  $query="select count(attack_log.date) as aliens from attack_log, users where attack_log.date>='".date("Y-m-d", mktime(0,0,0, date(m), date(d), date(Y)))."' and attack_log.at_id=users.id and users.race='alien'";
  $db_theend->query($query);
  $db_theend->next_record();
  $aliens=$db_theend->Record["aliens"];

  $query="select count(attack_log.date) as total from attack_log where attack_log.date>='".date("Y-m-d", mktime(0,0,0, date(m), date(d), date(Y)))."'";
  $db_theend->query($query);
  $db_theend->next_record();
  $total=$db_theend->Record["total"];

  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Humans:";
  else
    echo "Oameni:";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo number_format($humans);
  echo "</div>";

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($humans*100/($humans+$machines+$aliens))."%\"><tr><td background=\"pics/bluebar.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Machines:";
  else
    echo "Masini:";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo number_format($machines);
  echo "</div>";

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($machines*100/($humans+$machines+$aliens))."%\"><tr><td background=\"pics/greenbar.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Aliens:";
  else
    echo "Extraterestrii:";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo number_format($aliens);
  echo "</div>";

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($aliens*100/($humans+$machines+$aliens))."%\"><tr><td background=\"pics/redbar.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  echo "<font color=\"#FFD700\">Total:</font>";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo "<font color=\"#FFD700\">".number_format(($humans+$machines+$aliens));
  echo "</font>";
  echo "</div>";
        
  echo "</div>";
  echo "</div>";
  echo "</div>";      
        
  echo "<br />";
}

function show_active_users()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();

  $query="select count(distinct user) as today from online_statistic where data='".date("Y-m-d")."'";
  $db_theend->query($query);
  $db_theend->next_record();
  $today=$db_theend->Record["today"];

  $query="select count(distinct user) as yesterday from online_statistic where data='".date("Y-m-d", mktime(0,0,0, date(m), date(d)-1, date(Y)))."'";
  $db_theend->query($query);
  $db_theend->next_record();
  $yesterday=$db_theend->Record["yesterday"];

  $query="select count(distinct user) as lastweek from online_statistic where data>='".date("Y-m-d", mktime(0,0,0, date(m), date(d)-7, date(Y)))."' and data <'".date("Y-m-d", mktime(0,0,0, date(m), date(d), date(Y)))."'";
  $db_theend->query($query);
  $db_theend->next_record();
  $lastweek=$db_theend->Record["lastweek"];

  $query="select count(distinct user) as lastmon from online_statistic where data>='".date("Y-m-d", mktime(0,0,0, date(m)-1, date(d), date(Y)))."' and data <'".date("Y-m-d", mktime(0,0,0, date(m), date(d), date(Y)))."'";
  $db_theend->query($query);
  $db_theend->next_record();
  $lastmon=$db_theend->Record["lastmon"];

  $query="select count(id) as total from armory";
  $db_theend->query($query);
  $db_theend->next_record();
  $total_users=$db_theend->Record["total"];

  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";  
  echo "<div class=\"section_grey\">"; 
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Today:";
  else
    echo "Astazi:";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo number_format($today);
  echo "</div>";

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($today*100/($lastmon))."%\"><tr><td background=\"pics/greybar1.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Yesterday:";
  else
    echo "Ieri:";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo number_format($yesterday);
  echo "</div>";

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($yesterday*100/($lastmon))."%\"><tr><td background=\"pics/greybar2.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Last week:";
  else
    echo "Ultima saptamana:";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo number_format($lastweek);
  echo "</div>";

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($lastweek*100/($lastmon))."%\"><tr><td background=\"pics/greybar3.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "<br />";
  
  echo "<div class=\"st1\">";
  if($site_language=="en")
    echo "Last month:";
  else
    echo "Ultima luna:";
  echo "</div>";
  echo "<div class=\"st2\">";
  echo number_format($lastmon);
  echo "</div>";

  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" height=\"15\" width=\"100%\"><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"".round($lastmon*100/($lastmon))."%\"><tr><td background=\"pics/greybar3.gif\" height=\"10\"></td></tr></table></td></table>";

  echo "</div>";
  echo "</div>";      
  echo "</div>";
          
  echo "<br />";
}

function show_online_time()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();

  $query="select users.username, online.seconds_day from users, online where users.id=online.id order by online.seconds_day desc limit 0, 5";
  $db_theend->query($query);
  echo "<br>";
  echo "<table class=\"dotted\" bgcolor=\"#000000\" width=\"90%\" cellspacing=\"0\" cellpadding=\"5\">";
  while($db_theend->next_record())
  {
    echo "<tr><td>".$db_theend->Record["username"]."</td><td>".floor($db_theend->Record["seconds_day"]/3600)." hour(s), ".floor(($db_theend->Record["seconds_day"]-floor($db_theend->Record["seconds_day"]/3600)*3600)/60)." min.</td></tr>";
  }
  echo "</table>";
  echo "<br>";
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
        <?php main_menu("worldmap"); ?>
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
        echo "<div class=\"titlebar\">";
        if($site_language=="ro")
          echo "POPULATIE";
        else 
          echo "POPULATION";  
        echo "</div>";
?>        
        <br />

<?php
  show_population();
?>

        <div class="titlebar">EKR</div>

<?php
  show_gold();
?>

<?php
        echo "<div class=\"titlebar\">";
        if($site_language=="ro")
          echo "ATACURI DE AZI";
        else 
          echo "TODAY ATTACKS";  
        echo "</div>";
?>        

<?php
  show_attacks();
?>

<?php
        echo "<div class=\"titlebar\">";
        if($site_language=="ro")
          echo "UTILIZATORI ACTIVI";
        else 
          echo "ACTIVE USERS";  
        echo "</div>";
?>

<?php
  show_active_users();
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
