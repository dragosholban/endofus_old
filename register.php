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
        <?php main_menu("register"); ?>
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
          echo "INREGISTRARE";
        else 
          echo "REGISTER";  
        echo "</div>";
?> 
        <br />
        <div class="section">
        <div class="section_black">
        <div class="section_grey">
        
        <div class="image1"><img class="avatar" src="pics/register_img.jpg" alt=\"\" /></div>
        <div class="text1">

<?php
    if($_GET["error"])
    {
      echo "<br>";
      echo "<b>";
      if($_GET["error"]==1)
      {
        echo "Username must be between 4 and 15 alphenumeric chars!";
      }
      if($_GET["error"]==2)
      {
        echo "Username cannot begin with \" \", \"-\" or \".\"!";
      }
      if($_GET["error"]==3)
      {
        echo "Password must contain at least 6 alphenumeric chars!";
      }
      if($_GET["error"]==4)
      {
        echo "The two passwords enetered do not match!";
      }
      if($_GET["error"]==5)
      {
        echo "Your username is allready used by another player!";
      }
      if($_GET["error"]==6)
      {
        echo "Your e-mail account is allready used by another player!";
      }
      if($_GET["error"]==7)
      {
        echo "Your username is allready used by another player!";
      }
      if($_GET["error"]==8)
      {
        echo "Your e-mail account is allready used by another player!";
      }
      if($_GET["error"]==9)
      {
        echo "Activation mail could not be sent!";
      }
      if($_GET["error"]==10)
      {
        echo "Activation mail was sent to your e-mail adress. Use the link we provided in it to activate your user and then you will be able to login into the game.";
      }
      if($_GET["error"]==11)
      {
        echo "You have to choose your race!";
      }
      if($_GET["error"]==12)
      {
        echo "Please enter a valid e-mail adress!";
      }
      if($_GET["error"]==13)
      {
        echo "This e-mail adress has been banned! You cannot create an account using it!";
      }
      echo "</b>";
      echo "<br><br>";
    }
?>

<form action="enrol.php" method="post">
<div class="register">
<p class="bigline">
<?php
if($site_language=="ro")
	echo "Nume: ";
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
<?php
if($site_language=="ro")
	echo "Parola din nou: ";
else 
	echo "Retype Pass: ";
?>
<input class="input5" type="password" name="repassword"></input></p>
<p class="bigline">E-mail: <input class="input5" type="text" name="email"></input></p>
</div>
<p class="bigline"><font color="#909090" style="font-size: 9px;">
<?php
if($site_language=="ro")
	echo "Te rugam sa folosesti o adresa de e-mail valida pentru ca vei primi un mesaj de activare a contului;<br>nu pierde sau instraina aceasta adresa pentru ca iti va folosi la recuperearea parolei.";
else 
	echo "You will receive a activation link, so please use a valid e-mail adress;<br>don't lose it because you will need it for recovering your game password.";
?>
</font></p>
<div class="register">
<p class="bigline">
<?php
if($site_language=="ro")
	echo "Rasa: ";
else 
	echo "Race: ";
?>
<?php
if($site_language=="ro")
	echo "<select class=\"select1\" name=\"race\"><option class=\"option1\" value=\"none\" selected=\"selected\">Alege-ti rasa</option><option class=\"option1\" value=\"human\">om</option><option class=\"option1\" value=\"machine\">masina</option><option class=\"option1\" value=\"alien\">extraterestru</option></select>";
else 
	echo "<select class=\"select1\" name=\"race\"><option class=\"option1\" value=\"none\" selected=\"selected\">Choose your race</option><option class=\"option1\" value=\"human\">human</option><option class=\"option1\" value=\"machine\">machine</option><option class=\"option1\" value=\"alien\">alien</option></select>";
?>
</p>
</div>
<br /><br />
<font color="#FFA500">

<?php
  if($site_language=="ro")
    echo "Reguli pe care TREBUIE sa le respecti daca vei juca acest joc:";
  else
    echo "Rules that you MUST follow in order to play this game:";
?>
</font>
<br><font color="#909090" style="font-size: 9px;">

<?php
  if($site_language=="ro")
    echo "Ignorarea lor va duce la stergerea sau blocarea contului.";
  else
    echo "Ignoring them will lead to canceling your game account.";
?>

</font>
<br /><br />

<?php
if($site_language=="ro")

{
  echo "<b>&middot;</b> Nu folositi in denumirea contului si in cadrul jocului cuvinte sau imagini obscene sau care pot jigni in orice fel ceilalti jucatori.";
  echo "<br><br>";
  echo "<b>&middot;</b> Fiecare jucator poate beneficia de UN SINGUR CONT si numai unul. Logarea cu mai mult de un cont atrage dupa sine desfiintarea TUTUROR conturilor implicate.";
  echo "<br><br>";
  echo "<b>&middot;</b> In cazul in care impartiti acelasi calculator cu un membrul al familiei acest lucru va fi declarat in rubrica corespunzatoare. Orice interactiune intre aceste doua conturi este interzisa.";
  echo "<br><br>";
  echo "<b>&middot;</b> Folosirea unor conturi suplimentare in vederea exploatarii resurselor jocului si pentru beneficiul propriu este interzisa si atrage dupa sine desfiintarea conturilor.";
  echo "<br><br>";
  echo "<b>&middot;</b> Utilizarea unui cont in comun de doua sau mai multe persoane este interzisa. Cedarea unui cont catre alta persoana este deasemenea interzisa.";
  echo "<br><br>";
  echo "<b>&middot;</b> Sacrificarea contului si cedarea sumei obtinuta din vinderea resurselor unui alt cont este interzisa.";
  echo "<br><br>";
  echo "<b>&middot;</b> Neraportarea eventualelor erori de programare sau scapari ale jocului si exploatarea lor in interes propriu va duce la desfiintarea contului.";
  echo "<br><br>";
  echo "<b>&middot;</b> Aducerea de injurii sau lezarea verbala sau scrisa prin referire la religie, rasa, provenienta (si nu numai) este interzisa. Astfel de comportament va duce la pedepsirea imediata a celui implicat!";
  echo "<br><br>";
  echo "<b>&middot;</b> Nu ne asumam responsabilitatea pentru conturile \"pierdute\" datorita ghicirii parolei sau cedarii acesteia unei terte persoane. Parolele NU POT FI SPARTE. Va rugam nu insistati pe linga echipa ENS cu privire la acest subiect.";
  echo "<br><br>";
  echo "<b>&middot;</b> Orice alta situatie care poate afecta experienta celorlalti jucatori intr-un mod neplacut nu va fi tolerata.";
  echo "<br><br>";
  echo "<b>&middot;</b> Jocul End of Us este oferit FARA NICI O GARANTIE. Echipa ENS nu va fi considerata responsabila pentru orice fel de intrerupere a serviciului, pierdere de date, functionare defectuasa a jocului, sau alte evenimente ce sunt neplacute pentru utilizator. Echipa ENS nu ofera garantii privind calitatea sau consistenta servicilui si nu se obliga in oferirea acestui serviciu. Ne rezervam dreptul de a bana, suspenda, sterge sau modifica conturi in orice moment din orice motiv sau chiar fara nici un motiv.";
  echo "<br><br>";
  echo "<b>&middot;</b> <b>Un cont odata desfiintat NU POATE FI RECUPERAT. Administratorii nu se vor justifica in actiunile lor fata de nimeni si vor face tot posibilul pentru a oferi un mediu de joc placut si corect pentru toti.</b>";
  echo "<br>";
}
else
{
  echo "<b>&middot;</b> Do not use any obscene, racist, threathening (in other way than the game concepts) words or images inside the game.";
  echo "<br><br>";
  echo "<b>&middot;</b> Every user may have ONLY ONE ACCOUNT. Logging in with more than one account will lead to cancellation of ALL ACCOUNTS INVOLVED.";
  echo "<br><br>";
  echo "<b>&middot;</b> In case of sharing one computer between two members of the family you must specify this in the game. Any interraction between these two accounts is forbidden.";
  echo "<br><br>";
  echo "<b>&middot;</b> Using more accounts in order to exploit the game resources and/or for own benefit is forbidden and will lead to all accounts cancellation.";
  echo "<br><br>";
  echo "<b>&middot;</b> Using an accont by two or more individuals is forbidden. Account transfers between two or more individuals are forbidden.";
  echo "<br><br>";
  echo "<b>&middot;</b> Self destroing your account and giving the amount of gold obtained by selling you resouces to another account/player is forbidden.";
  echo "<br><br>";
  echo "<b>&middot;</b> Programm errors (also called bugs) have to be reported to an administrator immediately and may not be used to one's benefit. Abuse can lead to a punishment of the account.";
  echo "<br><br>";
  echo "<b>&middot;</b> Insults or verbal/written attacks of another player including but not limited to refering to religion, race, provenience is forbidden. Any behavior like this will lead to imediatly punishment of the player involved.";
  echo "<br><br>";
  echo "<b>&middot;</b> We do not take any resposability for \"lost\" accounts due to guessing your password or sharing it with another person. The passwords cannot be stolen from our database. Plese do not insist regarding this subject.";
  echo "<br><br>";
  echo "<b>&middot;</b> Any other situation that can affect in a negative way others players game experience will not be tolarated.";
  echo "<br><br>";
  echo "<b>&middot;</b> The End of Us game comes with ABSOLUTELY NO WARRANTY. End of Us Team may not be held responsible for any disruption of service, loss of data, game play malfunction, or other events or conditions that are undesirable to the user, under any circumstances. ENS Team makes no guarantees of the quality or consistency of service and is under no obligation to deliver such service. We reserve the right to ban, suspend, delete, or modify accounts at any time for any or no reason.";
  echo "<br><br>";
  echo "<b>&middot;</b> <b>A cancelled account CANNOT BE RECOVERED. The administrators will not justify their actions to anyone and will make everything posible to offer a pleasant and fair game enviroment for all.</b>";
  echo "<br>";
}
?>
<br /><br />
<input type="checkbox" name="rules" onClick=" if (this.checked) { document.getElementById('register_button').disabled = false; } else { document.getElementById('register_button').disabled = true; }"></input>
<font color="#FFA500">
<?php
  if($site_language=="ro")
    echo " Am citit si voi respecta aceste reguli";
  else
    echo " I have read and I will follow these rules";
?>
</font>
<br /><br />
<p class="bigline"><input disabled id="register_button" class="submit4" type="submit" value="Register" style="disabled"></input></p>
</form>

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
