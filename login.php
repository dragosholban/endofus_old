<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include "functions.php";
include "database.php";
include "monitors.php";

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
        <?php main_menu("login"); ?>
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
  if($site_language=="ro")
    echo "<div class=\"titlebar\">AUTENTIFICARE</div>";
  else
    echo "<div class=\"titlebar\">LOGIN</div>";
?>

<br>
<div class="section">
<div class="section_black">
<div class="section_grey">
<div class="image1"><img class="avatar" src="pics/login_img.jpg" alt=\"\" /></div>
<div class="login">
<br />
<form action="dologin.php" method="post">
<p class="bigline">
<?php
if($site_language=="ro")
	echo "Cont: ";
else 
	echo "Username: ";
?> 
<input class="input5" type="text" name="username"></input></p>
<p class="bigline">
<?php
if($site_language=="ro")
	echo "Parola: ";
else 
	echo "Password: ";
?>
<input class="input5" type="password" name="password"></input></p>
<p class="bigline">
<?
  /*
  $acceptedChars = '0123456789';
  $max = strlen($acceptedChars)-1;
  $newpassword = null;
  for($i=0; $i < 5; $i++)
  {
    $code .= $acceptedChars{mt_rand(0, $max)};
  }
  */
  $code=random_number(1,1000);
  echo "<input type=\"hidden\" name=\"sendcode\" value=\"".$code."\"></input>";
  echo "<img class=\"middleval\" src=\"image_code.php?c=".$code."\" /> <input class=\"input5\" type=\"text\" name=\"code\"></input>";
?>
</p>
<p class="bigline"><input class="submit1" type="submit" value="Login"></input></p>
<p class="bigline"><a href="remember.php">
<?php
if($site_language=="ro")
	echo "[reseteaza parola]";
else 
	echo "[reset password]";
?>
</a></p>
</form>
</div>
</div>
</div>
</div>
<br />
<?php
  if($_GET["loginerr"]==1)
  {
    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\">";
    if($site_language=="ro")
    {
    echo "<font color=\"#FF0000\"><b>Autentificare esuata!</b></font>";
    echo "<br>";
    echo "Motive posibile:";
    echo "<ul>";
    echo "<li>Numele sau parola introduse sunt gresite</li>";
    echo "<li>Contul a fost sters din cauza nerespectarii regulilor jocului.</li>";
    echo "<li>Numarul anti-robot nu a fost introdus corect</li>";
    echo "</ul>";
    echo "<font color=\"#909090\">Foloseste optiunea <font color=\"#F0F0F0\"><b>reseteaza parola</b></font> daca nu iti amintesti parola.<br>Verifica lista <font color=\"#F0F0F0\"><b>Conturi sterse</b></font> din meniul <font color=\"#F0F0F0\"><b>Clasament</b></font> pentru a afla daca contul tau apare acolo.</font>";    	
    }
    else 
    {
    echo "<font color=\"#FF0000\"><b>Login failed!</b></font>";
    echo "<br>";
    echo "Posible reasons:";
    echo "<ul>";
    echo "<li>Invalid username or password</li>";
    echo "<li>Account cancelled for breaking the game rules</li>";
    echo "<li>Anti-boot number was not typed correctly</li>";
    echo "</ul>";
    echo "<font color=\"#909090\">Use the <font color=\"#F0F0F0\"><b>reset password</b></font> option if you don't remember your password.<br>Check the <font color=\"#F0F0F0\"><b>Hall of Shame</b></font> list under the <font color=\"#F0F0F0\"><b>Ranks</b></font> menu to find if your account is listed there.</font>";    	
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
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
