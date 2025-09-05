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
        <?php main_menu("remember"); ?>
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
    echo "<div class=\"titlebar\">RESETARE PAROLA</div>";
  else
    echo "<div class=\"titlebar\">RESET PASSWORD</div>";
?>
<br>
          <?php
          if($_POST["username"] && $_POST["email"])
          {
            $db_theend = new DataBase_theend;
            $db_theend->connect();

            $query="select id from users where username='".$_POST["username"]."' and email='".$_POST["email"]."'";
            $db_theend->query($query);
            if($db_theend->num_rows())
            {
              $acceptedChars = 'azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN0123456789';
              $max = strlen($acceptedChars)-1;
              $newpassword = null;
              for($i=0; $i < 14; $i++)
              {
                $newpassword .= $acceptedChars[mt_rand(0, $max)];
              }


            $db_theend->next_record();

            $query="update users set password='".md5($newpassword)."' where id=".$db_theend->Record["id"];
            $db_theend->query($query);

            $email_text="Your password for playing \"End of Us\" is ".$newpassword."";
            $email_header="From: endofus\n";
            mail($_POST["email"],"Your password at \"END OF US\" Online Game",$email_text,$email_header);
            if($_COOKIE["lang"]=="en")
            {
              echo "<br>";
              echo "<table width=\"350\" bgcolor=\"#600000\" cellspacing=\"2\" cellpadding=\"0\"><tr><td height=\"35\" bgcolor=\"#300000\" align=\"center\">";
              echo "<font color=\"#7FFF00\">"."A mail has been sent to ".$_POST["email"]." containing your password.</font>";
              echo "<br>"."When you receive tour password you can login in <a href=\"login.php\">here</a>.";
              echo "</td></tr></table>";
            }
            else
            {
              echo "<br>";
              echo "<table width=\"350\" bgcolor=\"#600000\" cellspacing=\"2\" cellpadding=\"0\"><tr><td height=\"35\" bgcolor=\"#300000\" align=\"center\">";
              echo "<font color=\"#7FFF00\">"."Un mesaj a fost trimis catre ".$_POST["email"]." cu parola solicitata.</font>";
              echo "<br>"."Dupa primirea parolei veti putea intra in joc <a href=\"login.php\">aici</a>.";
              echo "</td></tr></table>";
            }
            }
            else
            {
              if($site_language=="en")
              {
                echo "<br>";
                echo "<table width=\"350\" bgcolor=\"#600000\" cellspacing=\"2\" cellpadding=\"0\"><tr><td height=\"35\" bgcolor=\"#300000\" align=\"center\">";
                echo "<font color=\"#7FFF00\">"."The combination of username/e-mail you entered is not valid!</font>";
                echo "<br>"."Go <a href=\"remember.php\">here</a> if you want to enter them again.";
                echo "</td></tr></table>";
              }
              else
              {
                echo "<br>";
                echo "<table width=\"350\" bgcolor=\"#600000\" cellspacing=\"2\" cellpadding=\"0\"><tr><td height=\"35\" bgcolor=\"#300000\" align=\"center\">";
                echo "<font color=\"#7FFF00\">"."Combinatia nume cont/e-mail introdusa nu este valida!</font>";
                echo "<br>"."Mergi <a href=\"remember.php\">aici</a> pentru a incerca din nou.";
                echo "</td></tr></table>";
              }
            }
          }
          else
          {
?>

<div class="section">
<div class="section_black">
<div class="section_grey">
<div class="image1"><img class="avatar" src="pics/register_img.jpg" alt=\"\" /></div>
<div class="login">
<form action="remember.php" method="POST">
<p class="bigline">
<?php
if($site_language=="ro")
	echo "Cont: ";
else 
	echo "Username: ";
?>
<input class="input5" type="text" name="username"></input></p>
<p class="bigline">E-mail: <input class="input5" type="text" name="email"></input></p>
<p class="bigline"><input class="submit1" type="submit" value="Reset"></input></p>
</form>
</div>
</div>
</div>
</div>

<?php
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