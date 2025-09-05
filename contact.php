<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include "functions.php";
include "database.php";
include "monitors.php";

$db_theend = new DataBase_theend;
$db_theend->connect();

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
        <?php main_menu("contact"); ?>
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
        <div class="titlebar">CONTACT</div>
        <br />
        <div class="section">
        <div class="section_black">
        <div class="section_grey">
        <div class="image1"><img class="avatar" src="pics/contact_img.jpg" alt=\"\" /></div>
        <div class="text1">

<?php

if($_POST["name"] && $_POST["email"] && $_POST["subject"] && $_POST["message"])
{
  $name=$_POST["name"];
  $email=$_POST["email"];
  $subject=$_POST["subject"];
  $message=$_POST["message"];
  if(!$subject)
  {
  	 $subject="[none]";
  }
  
  mail("support@endofus.net","ENS Website: ".$subject,"Message from: ".$name."\n\n".$message,"From: ".$email."\n");

  echo "<br><font color=\"#FFD700\">Your message has been sent. Thank you.</font><br><br>";
}
else
{
  if($site_language=="ro")

    echo "<br><font color=\"#A0A0A0\">Contactati-ne prin intermediul acestui formular cu privire la orice probleme sau sugestii aveti sau daca doriti sa discutam despre modalitati de promovare in cadrul acestui site (inclusiv schimb de bannere sau linkuri).</font><br><font color=\"#FFD700\">Va rugam completati toate campurile.</font><br><br><img src=\"pics/warned.gif\"></img> <font color=\"#F0F0F0\">In caz ca jucati ENS va rugam introduceti numele dvs. de jucator in campul </font><font color=\"#FFA500\">Nume</font> <font color=\"#F0F0F0\">astfel incat sa va putem contacta mai usor.</font><br><br>";

  else

    echo "<br><font color=\"#A0A0A0\">Contact us using this form regarding any problem or suggestion or if you want to discuss about advertising on this site (including banner exchage or link exchange).</font><br><font color=\"#FFD700\">Please fill all fields.</font><br><br><img src=\"pics/warned.gif\"></img> <font color=\"#F0F0F0\">In case you are playing the game please type in your </font><font color=\"#FFA500\">ENS ID</font> <font color=\"#F0F0F0\"> in the </font><font color=\"#FFA500\">Name</font> <font color=\"#F0F0F0\">field so we can contact you better in the game.</font><br><br>";

  echo "<form action=\"contact.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"contact\"></input>";
  echo "<p class=\"bigline\">";
  if($site_language=="ro")
    echo "Numele dvs: ";
  else
    echo "Your name: ";
  echo "</p>";  
  echo "<input class=\"input3\" type=\"text\" size=\"50\" name=\"name\" value=\"".$_POST["name"]."\"></input>";
  echo "<p class=\"bigline\">";
  if($site_language=="ro")
    echo "Adresa e-mail: ";
  else
    echo "Your e-mail adress: ";
  echo "</p>";
  echo "<input class=\"input3\" type=\"text\" size=\"50\" name=\"email\" value=\"".$_POST["email"]."\"></input>";
  echo "<p class=\"bigline\">";
  if($site_language=="ro")
    echo "Subiect: ";
  else
    echo "Subject: ";
  echo "</p>";  
  echo "<input class=\"input3\" type=\"text\" size=\"50\" name=\"subject\" value=\"".$_POST["subject"]."\"></input>";
  echo "<p class=\"bigline\">";
  if($site_language=="ro")
    echo "Mesaj: ";
  else
    echo "Message: ";
  echo "</p>";
  echo "<textarea rows=\"10\" cols=\"50\" class=\"mail\" name=\"message\">".$_POST["message"]."</textarea>";
  echo "<br /><br />";
  echo "<input class=\"submit4\" type=\"submit\" value=\"";
  if($site_language=="ro")
    echo "Trimite mesaj";
  else
    echo "Send Message";
  echo "\"></input>";
  echo "</form>";
}
?>

		</div>
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
</body>

</html>
