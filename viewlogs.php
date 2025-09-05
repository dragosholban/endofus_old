<html>
<head>
  <meta name="description" content="On-line multiplayer web game. Adventure game.">
  <meta name="keywords" content="game, money, internet">
  <title>End of us - multiplayer free on-line game</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<?php

include 'database.php';
include 'functions.php';

if($_COOKIE["lang"]=="en") $ppath="pics/en/";
else $ppath="pics/";

   $no_queries=0;

function registered_users_details()
{
global $no_queries;

$db_theend = new DataBase_theend;
$db_theend->connect();

        $query="select count(id) from users where race='human'";
        $db_theend->query($query);
        $no_queries+=1;
        $db_theend->next_record();
        $humans=$db_theend->Record["count(id)"];

        $query="select count(id) from users where race='machine'";
        $db_theend->query($query);
        $no_queries+=1;
        $db_theend->next_record();
        $machines=$db_theend->Record["count(id)"];

        $query="select count(id) from users where race='alien'";
        $db_theend->query($query);
        $no_queries+=1;
        $db_theend->next_record();
        $aliens=$db_theend->Record["count(id)"];

        echo "<table width=\"140\" cellspacing=\"0\">";
        echo "<tr><td colspan=\"2\" height=\"20\">&nbsp;<font color=\"#FFD700\">";
        if($_COOKIE["lang"]=="en") echo "Our users:";
        else echo "Jucatori:";
        echo "</font></td></tr>";
        echo "<tr><td height=\"20\">";
        if($_COOKIE["lang"]=="en") echo "&nbsp;Humans:";
        else echo "&nbsp;Oameni:";
        echo "</td><td align=\"right\">".$humans."</td></tr>";

        echo "<tr><td height=\"20\">";
        if($_COOKIE["lang"]=="en") echo "&nbsp;Machines:";
        else echo "&nbsp;Masini:";
        echo "</td><td align=\"right\">".$machines."</td></tr>";

        echo "<tr><td height=\"20\">";
        if($_COOKIE["lang"]=="en") echo "&nbsp;Aliens:";
        else echo "&nbsp;Extraterestrii:";
        echo "</td><td align=\"right\">".$aliens."</td></tr>";

        echo "<tr><td bgcolor=\"#000510\">&nbsp;<font color=\"#FFD700\">Total:</font></td><td bgcolor=\"#000510\" align=\"right\"><font color=\"#FFD700\">".($humans+$machines+$aliens)."</font></td></tr>";
        echo "</table>";
        }

function top_5()
{
global $no_queries;

$db_theend = new DataBase_theend;
$db_theend->connect();

$query="select users.username, armory.exp, armory.level from users, armory where users.id=armory.id order by armory.level desc, armory.exp desc, armory.units desc, username asc";
$db_theend->query($query);
$no_queries+=1;

echo "<table width=\"140\" cellspacing=\"0\">";
echo "<tr><td colspan=\"3\" height=\"20\">&nbsp;<font color=\"#FFD700\">";
if($_COOKIE["lang"]=="en") echo "Top 5 users:";
else echo "Top 5 jucatori:";
echo "</font></td></tr>";

echo "<tr><td height=\"20\"><font color=\"#808080\">";
if($_COOKIE["lang"]=="en") echo "&nbsp;Username";
else echo "&nbsp;Nume";
echo "</font></td><td align=\"right\"><font color=\"#808080\">";
if($_COOKIE["lang"]=="en") echo "Lvl.";
else echo "Nivel";
echo "</font></td><td align=\"right\"><font color=\"#808080\">";
if($_COOKIE["lang"]=="en") echo "Exp.";
else echo "Exp.";
echo "</font></td></tr>";
$db_theend->next_record();

echo "<tr><td height=\"20\"><font color=\"#FFD700\">&nbsp;".$db_theend->Record["username"]."</font></td><td align=\"right\"><font color=\"#FFD700\">".$db_theend->Record["level"]."</font></td><td align=\"right\"><font color=\"#FFD700\">".number_format($db_theend->Record["exp"])."</font></td></tr>";
$db_theend->next_record();

echo "<tr><td height=\"20\">&nbsp;".$db_theend->Record["username"]."</td><td align=\"right\">".$db_theend->Record["level"]."</td><td align=\"right\">".number_format($db_theend->Record["exp"])."</td></tr>";
$db_theend->next_record();

echo "<tr><td height=\"20\">&nbsp;".$db_theend->Record["username"]."</td><td align=\"right\">".$db_theend->Record["level"]."</td><td align=\"right\">".number_format($db_theend->Record["exp"])."</td></tr>";
$db_theend->next_record();

echo "<tr><td height=\"20\">&nbsp;".$db_theend->Record["username"]."</td><td align=\"right\">".$db_theend->Record["level"]."</td><td align=\"right\">".number_format($db_theend->Record["exp"])."</td></tr>";
$db_theend->next_record();

echo "<tr><td height=\"20\">&nbsp;".$db_theend->Record["username"]."</td><td align=\"right\">".$db_theend->Record["level"]."</td><td align=\"right\">".number_format($db_theend->Record["exp"])."</td></tr>";

echo "</table>";
}

function users_list()
{
$db_theend = new DataBase_theend;
$db_theend->connect();
$db2 = new DataBase_theend;
$db2->connect();

global $no_queries;

  echo "<form action=\"viewlogs.php\" method=\"GET\">";

  echo "Select date: ";
  echo "<select name=\"data\">";
  $query="select datetime from login_log order by datetime desc";
  $db_theend->query($query);
  $data_ant="";
  while($db_theend->next_record())
  {
      $day=explode("-",$db_theend->Record["datetime"],3);
      $year=$day[0];
      $month=$day[1];
      $day=explode(" ",$day[2],2);
      $data=date("Y-m-d", mktime(0,0,0, $month, $day[0], $year));
//      echo $data;
      if($data_ant!=$data)
      {
        if($_GET["data"]==$data)
          echo "<option value=\"".$data."\" selected=\"selected\">".$data;
        else
          echo "<option value=\"".$data."\">".$data;
      }
      $data_ant=$data;
  }
  echo "</select>";

  echo " group users by ";

  echo "<select name=\"criterio\">";
  if($_GET["criterio"]=="ip")
  {
    echo "<option value=\"computer\">computer";
    echo "<option value=\"ip\" selected=\"selected\">IP";
  }
  else
  {
    echo "<option value=\"computer\" selected=\"selected\">computer";
    echo "<option value=\"ip\">IP";
  }
  echo "</select>";

  echo " <input type=\"submit\" value=\"OK\"></input>";

  echo "</form>";

  if($_GET["criterio"]=="ip")
    $criterio="ip";
  else
    $criterio="computer";

  if($_GET["data"])
    $data=$_GET["data"];
  else
    $data=date("Y-m-d");

  $data2=explode("-",$data);

  $data_urm=date("Y-m-d", mktime(0,0,0, $data2[1], $data2[2]+1, $data2[0]));

  $query="select count(distinct cont) as nocont, ".$criterio." from login_log where datetime>='".$data." 00:00:00"."' and datetime<'".$data_urm." 00:00:00"."' group by ".$criterio." order by nocont desc";
  $db_theend->query($query);
  $no_queries+=1;
  $nr_inreg=$db_theend->num_rows();
  $nr_inreg_pag=30;
  if(!$_GET["page"] || $_GET["page"]<0 || $_GET["page"]>ceil($nr_inreg/$nr_inreg_pag)) $page=1;
  else $page=$_GET["page"];

  echo "<table width=\"630\" cellspacing=\"0\" cellpadding=\"0\">";
  echo "<tr><td align=\"center\">";

  echo "<table cellspacing=\"1\" cellpadding=\"3\">";
  echo "<tr>";
  echo "<td width=\"50\"><font color=\"#909090\"><b>";
  if($_COOKIE["lang"]=="en") echo "Accounts";
  else echo "Nr. conturi";
  echo "</b></font></td><td width=\"500\"><font color=\"#909090\"><b>";
  if($_COOKIE["lang"]=="en") echo "Users (login times)";
  else echo "Utilizatori (nr. autentificari)";
  echo "</b></font></td>";
  echo "</tr>";
  echo "</table>";
  $nr_inreg_cur=0;
  while($db_theend->next_record())
  {
      $nr_inreg_cur++;

      if($nr_inreg_cur<=$nr_inreg_pag*$page && $nr_inreg_cur>$nr_inreg_pag*($page-1))
      {

          echo "<table cellspacing=\"1\" cellpadding=\"3\" bgcolor=\"#404040\">";
          echo "<tr>";

          echo "<td height=\"20\" bgcolor=\"#101010\" width=\"50\" align=\"right\">";

          echo $db_theend->Record["nocont"];

          echo "</td><td bgcolor=\"#101010\" width=\"500\">";
          $query2="select distinct users.username, count(login_log.cont) as nolog from users, login_log where users.id=login_log.cont and login_log.".$criterio."='".$db_theend->Record[$criterio]."' and login_log.datetime>='".$data." 00:00:00"."' and login_log.datetime<'".$data_urm." 00:00:00"."' group by login_log.cont order by nolog desc";
          $db2->query($query2);
          while($db2->next_record())
          {
            echo "<a class=\"white\" href=\"user_profile.php?user=".$db2->Record["username"]."\">".$db2->Record["username"]."</a> (".$db2->Record["nolog"].")".", ";
          }
          echo "</td>";
          echo "</tr>";
          echo "</table>";

          echo "<table cellspacing=\"0\" cellpading=\"0\" height=\"1\" width=\"10\"><tr><td></td></tr></table>";

      }
  }

  echo "</tr>";
  echo "</table>";

  echo "<br>";
  echo "<a href=\"viewlogs.php?page=".($page-1)."&criterio=".$criterio."&date=".$data."\"><<</a>"." Page ".$page." from ".$page=ceil($nr_inreg/$nr_inreg_pag).". "."<a href=\"viewlogs.php?page=".($page+1)."&criterio=".$criterio."&date=".$data."\">>></a>";
  echo "<br><br>";
  echo "<font color=\"#909090\">Total queries: ".$no_queries."</font>";
}

?>

<body bgcolor="#000000">
<center>
<br>
<table cellspacing="1" cellpadding="0" bgcolor="#606060">
<tr><td bgcolor="#000000">

<table width="980" cellspacing="0" cellpadding="0">
<tr><td height="120">
<img src="pics/met/ens.jpg"></img>
</td></tr>
<tr><td height="1" bgcolor="#404040"></td></tr>
</table>

<table width="980" cellspacing="0" cellpadding="0" bgcolor="#101010">
<tr>
  <td width="10"></td>
  <td align="center" valign="top" width="150">
            <br>
            <table cellspacing="1" cellpadding="0" width="150" bgcolor="#606060">
              <tr>
                <td width="148" bgcolor="#050505" align="center" valign="top">

                  <table cellspacing="0" cellpadding="0">
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                  </table>

                  <table>
                    <tr><td height="10"></td></tr>
                    <tr><td><form action="index1.php" method="POST"><input type="submit" class="imenu" value="Home"></input></form></td></tr>
                    <tr><td><form action="login.php" method="POST"><input type="submit" class="imenu" value="Login"></input></form></td></tr>
                    <tr><td><form action="register.php" method="POST"><input type="submit" class="imenu" value="Register"></input></form></td></tr>
                    <tr><td><form action="forum/index.php" target="_blank" method="POST"><input type="submit" class="imenu" value="Forum"></form></input></td></tr>
                    <tr><td><form action="user_list.php" method="POST"><input type="submit" class="imenu" value="Ranks"></input></form></td></tr>
                    <tr><td><form action="rules.php" method="POST"><input type="submit" class="imenu" value="Rules"></input></form></td></tr>
                    <tr><td><form action="story.php" method="POST"><input type="submit" class="imenu" value="The Story"></input></form></td></tr>
                    <tr><td><form action="worldmap.php" method="POST"><input type="submit" class="imenu" value="World Map"></input></form></td></tr>
                    <tr><td height="10"></td></tr>
                  </table>

                  <table cellspacing="0" cellpadding="0">
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                  </table>

                </td>
              </tr>
            </table>
           <table cellspacing="0" cellpadding="0" width="150">
             <tr><td height="10"></td></tr>
           </table>
            <table cellspacing="0" cellpadding="0" width="150">
              <tr>
                <td width="150" height="50" align="center">

                </td>
              </tr>
            </table>
            <br>

</td>
  <td width="10"></td>
<td valign="top" align="center">
     <br>

          <table cellspacing="1" cellpadding="0" bgcolor="#A0A0A0" width="630">
            <tr><td bgcolor="#500000" align="center" height="22"><b>LOGIN LOGS</b></td></tr>
          </table>

      <table width="630" cellspacing="0" cellpadding="0">
          <tr><td align="center">

     <br>

      <?php users_list(); ?>

     <br><br>

          </td></tr>
     </table>

</td>
  <td width="10"></td>
<td align="center" valign="top" width="150">
            <br>
            <table cellspacing="1" cellpadding="0" width="150" bgcolor="#606060">
              <tr>
                <td width="148" height="170" bgcolor="#050505" align="center">

                  <table cellspacing="0" cellpadding="0">
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                  </table>

                  <table width="120">
                  <tr><td height="20"></td></tr>
                  <tr><td><?php ens_textad();?></td><tr>
                  <tr><td height="20"></td></tr>
                  <tr><td><SCRIPT type='text/javascript' language='JavaScript' src='http://xslt.alexa.com/site_stats/js/s/a?url=www.ens.ro'></SCRIPT></td></tr>
                  <tr><td height="20"></td></tr>
                  </table>

                  <table cellspacing="0" cellpadding="0">
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#000000" height="1" width="146"></td></tr>
                    <tr><td bgcolor="#202020" height="1" width="146"></td></tr>
                  </table>

                </td>
              </tr>
            </table>

</td>
  <td width="10"></td>
</tr>
</table>

</td></tr></table>

<br>
<font color="#C0C0C0"><b>www.ens.ro</b></font>
<br>
<font color="#909090"><b>Contact: endofus@ens.ro</b></font>
<br><br><br>

<table><tr><td width="150" align="center"><?php neogen_monitor();?></td><td width="20"></td><td width="150" align="center"><?php trafic();?></td></tr></table>


</center>
</body>
</html>
