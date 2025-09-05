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
        <?php main_menu("news"); ?>
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
    echo "<div class=\"titlebar\">STIRI</div>";
  else
    echo "<div class=\"titlebar\">NEWS</div>";
?>        
<br>
<?php

  $db = new DataBase_theend;
  $db->connect();

  $site_language=site_language();

  $query="select datetime, ro, en from news order by id desc";
  $db->query($query);

  if($db->num_rows())
  {
    while($db->next_record())
    {
      echo "<div class=\"section\">";
      echo "<div class=\"section_black\">";
      echo "<div class=\"section_grey\" style=\"padding: 5px;\">";
      echo "<font color=\"#FFA500\">".$db->Record["datetime"]."</font>";
      echo "<br>";
      if($site_language=="ro")
        echo "".$db->Record["ro"]."";
      else
        echo "".$db->Record["en"]."";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "<br>";
    }
  }
  else
  {
      echo "<div class=\"section\">";
      echo "<div class=\"section_black\">";
      echo "<div class=\"section_grey\" style=\"padding: 5px;\">";
      echo "No news available for the moment.";
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
