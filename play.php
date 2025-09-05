<?php
error_reporting(0);

include 'database.php';
include 'functions.php';
include 'command_center.php';
include 'train.php';
include 'armory.php';
include 'upgrades.php';
include 'attack.php';
include 'spy.php';
include 'alliances.php';
include 'safe.php';
include 'mail.php';
include 'aactions.php';
include 'myaccount.php';
include 'monitors.php';
include 'search.php';

$site_language=site_language();

$db_theend = new DataBase_theend;
$db_theend->connect();

$login=check_login();

if(!$login)
{
  header("Location: login.php");
}
else 
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <title>End of us - multiplayer free on-line game</title>
  <meta name="description" content="On-line multiplayer web game. Adventure game.">
  <meta name="keywords" content="massive, multiplayer, free, online, game">
  <link rel="stylesheet" type="text/css" href="css/new_style.css">
  <script language="JavaScript" type="text/javascript" src="functions.js"></script>
</head>

<?php
$turntime=1200;
?>

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
        <?php main_menu("play.php"); ?>
        <?php game_menu("play.php"); ?>
        </div> 
        <div class="left_box_white_spacer"></div>
        <br />
        <?php ad_left(); ?>
      </td>
      <td class="center_td">

<div class="account_status_bar">

<table cellspacing="2" cellpadding="1" class="account_status_table">
<tr>
<?php
  if($site_language=="ro")
  {
    echo "<td align=\"center\">EKR: <span id=\"goldspan\"></span></td>";
    echo "<td align=\"center\">AP: <span id=\"turnsspan\"></span></td>";
    echo "<td align=\"center\">Nivel: <span id=\"levelspan\"></span></td>";
    echo "<td align=\"center\">Exp.: <span id=\"expspan\"></span></td>";
    echo "<td align=\"center\">Unitati: <span id=\"unitsspan\"></span></td>";
    echo "<td align=\"center\">Urmatorul tur in: <span id=\"timespan\"></span></td>";
  }
  else
  {
    echo "<td align=\"center\">EKR: <span id=\"goldspan\"></span></td>";
    echo "<td align=\"center\">AP: <span id=\"turnsspan\"></span></td>";
    echo "<td align=\"center\">Level: <span id=\"levelspan\"></span></td>";
    echo "<td align=\"center\">Exp.: <span id=\"expspan\"></span></td>";
    echo "<td align=\"center\">Units: <span id=\"unitsspan\"></span></td>";
    echo "<td align=\"center\">Next turn in: <span id=\"timespan\"></span></td>";
  }
?>
</tr>
</table>

</div>

<div class="640px_horiz"><img src="pics/640px_horiz.gif" /></div>

<?php


    if ($_POST["loc"]=="train" && ($_POST["dfunit"] || $_POST["atunit"] || $_POST["eliteat"] || $_POST["elitedf"] || $_POST["spy"] || $_POST["antispy"] || $_POST["workers"]))
    {
      $train_error=train_units();
    }
    if ($_POST["loc"]=="train" && $_POST["units"])
    {
      buy_units();
    }
    if ($_POST["loc"]=="disband")
    {
      disband();
    }
    if ($_POST["loc"]=="armory" && $_POST["act"]=="buy")
    {
      buy_armory();
    }
    if ($_POST["loc"]=="armory" && $_POST["act"]=="repair")
    {
      repair_armory();
    }
    if ($_POST["loc"]=="sell_armory")
    {
      sell_armory();
    }
    if ($_POST["loc"]=="upgrade")
    {
      upgrade_armory();
    }
    if ($_POST["loc"]=="attack" && $_POST["user"] && $_POST["turns"])
    {
      $attack_data=attack2();
    }
    if ($_POST["loc"]=="alliance" && $_POST["what"]=="leave" && $_POST["alname"])
    {
      leave_alliance($_COOKIE["uid"],$_POST["alname"]);
    }
    if ($_POST["loc"]=="safe" && ($_POST["deposit"] || $_POST["retract"]))
    {
      update_safe($_COOKIE["uid"],round($_POST["deposit"]),round($_POST["retract"]));
    }
    if ($_POST["loc"]=="alliance" && $_POST["what"]=="disband" && $_POST["alname"])
    {
      disband_alliance($_POST["alname"]);
    }



    if($_GET["loc"]=="cc" || $_POST["loc"]=="cc")
    {
      command_center();
    }
    if ($_GET["loc"]=="train" || $_POST["loc"]=="train")
    {
      train($train_error);
    }
    if ($_POST["loc"]=="disband")
    {
      train($train_error);
    }
    if ($_POST["loc"]=="armory")
    {
      armory();
    }
    if ($_POST["loc"]=="sell_armory")
    {
      armory();
    }
    if ($_POST["loc"]=="upgrade")
    {
      upgrades();
    }
    if ($_POST["loc"]=="upgrades")
    {
      upgrades();
    }
    if ($_POST["loc"]=="attack" && !($_POST["user"]))
    {
      attack();
    }
    if ($_POST["loc"]=="attack" && $_POST["user"] && !($_POST["turns"]))
    {
      attack_user();
    }
    if ($_POST["loc"]=="attack" && $_POST["user"] && $_POST["turns"])
    {
      attack_user_now($attack_data);
    }
    if ($_POST["loc"]=="superattack")
    {
      superattack();
    }
    if ($_POST["loc"]=="spy" && $_POST["user"])
    {
      spy($_POST["user"]);
    }
    if ($_POST["loc"]=="spy_user" && $_POST["user"])
    {
      spy_user_now($_POST["user"]);
    }
    if ($_POST["loc"]=="attack_log" || $_GET["loc"]=="attack_log")
    {
      attack_log();
    }
    if ($_POST["loc"]=="attack_details" && $_POST["date"] && $_POST["at_id"] && $_POST["df_id"])
    {
      attack_details($_POST["date"],$_POST["at_id"],$_POST["df_id"]);
    }
    if ($_POST["loc"]=="superattack_details" && $_POST["id"])
    {
      superattack_details($_POST["id"]);
    }
    if ($_POST["loc"]=="spy_log")
    {
      spy_logs();
    }
    if ($_POST["loc"]=="spy_details" && $_POST["msid"])
    {
      spy_details($_POST["msid"]);
    }
    if ($_POST["loc"]=="alliance" | $_GET["loc"]=="alliance")
    {
      alliance();
    }
    if ($_POST["loc"]=="alliancemail")
    {
      alliance_mail();
    }
    if ($_POST["loc"]=="sendalliancemail")
    {
      sendalliancemail();
    }
    if ($_POST["loc"]=="safe")
    {
      safe();
    }
    if ($_POST["loc"]=="mail" || $_GET["loc"]=="mail")
    {
      usermail();
    }
    if ($_POST["loc"]=="aactions")
    {
      aactions();
    }
    if ($_POST["loc"]=="account")
    {
      account();
    }
    if ($_GET["loc"]=="editprofile" || $_POST["loc"]=="editprofile")
    {
      edit_profile();
    }
    if ($_POST["loc"]=="chpsswd")
    {
      chpsswd();
    }
    if ($_POST["loc"]=="rstac")
    {
      resetac();
    }
    if ($_POST["loc"]=="search")
    {
      search();
    }
    ?>
    
    <br />
    
    <div class="middle_ad">
      <iframe width="479" height="60" src="ad_middle.php" frameborder="0" scrolling="no"></iframe>
    </div>
    
    <br />

      </td>
      <td class="right_td">
        <?php latest_news_box(); ?>
        <?php last_attack_box(); ?>
        <?php last_spy_box(); ?>
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

<?php

$query="select gold, turn, level, exp, units, turnlen, lastacct from armory where id=".$_COOKIE["uid"];
$db_theend->query($query);
$db_theend->next_record();
$usergold=$db_theend->Record["gold"];
$userturns=$db_theend->Record["turn"];
$userlevel=$db_theend->Record["level"];
$userexp=$db_theend->Record["exp"];
$userunits=$db_theend->Record["units"];

$turnlen=$db_theend->Record["turnlen"];
$lastacct=$db_theend->Record["lastacct"];
//$timeleft=ceil($turnlen-date_difference(getdate(),$lastacct,"minutes"));
//if($timeleft<0) $timeleft=0;

    if(date("i")>=0 && date("i")<5)
      $timeleft=5-date("i");
  	if(date("i")>=5 && date("i")<25)
      $timeleft=25-date("i");
    if(date("i")>=25 && date("i")<45)
      $timeleft=45-date("i");
    if(date("i")>=45 && date("i")<60)
      $timeleft=60+5-date("i");  
      
?>
<script language="JavaScript">
document.getElementById('goldspan').innerHTML="<?php echo '<font color=\"#FFA500\">'.number_format($usergold).'</font>'; ?>";
document.getElementById('turnsspan').innerHTML="<?php echo '<font color=\"#FFA500\">'.number_format($userturns).'</font>'; ?>";
document.getElementById('levelspan').innerHTML="<?php echo '<font color=\"#FFA500\">'.number_format($userlevel).'</font>'; ?>";
document.getElementById('expspan').innerHTML="<?php echo '<font color=\"#FFA500\">'.number_format($userexp).'</font>'; ?>";
document.getElementById('unitsspan').innerHTML="<?php echo '<font color=\"#FFA500\">'.number_format($userunits).'</font>'; ?>";
document.getElementById('timespan').innerHTML="<?php echo '<font color=\"#FFA500\">'.number_format($timeleft).' min.</font>'; ?>";
</script>
<script language="JavaScript" type="text/javascript" src="wz_tooltip.js"></script>

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

<?php
   }
?>