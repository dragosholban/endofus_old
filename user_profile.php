<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
  <meta name="description" content="Massive multiplayer online game. Adventure game. Browser based. Joc de strategie online." />
  <meta name="keywords" content="massive, multiplayer, free, online, game, mmorpg, strategie, razboi, war" />
  <link rel="stylesheet" type="text/css" href="css/new_style.css" />
  <title>End of us - massive multiplayer online game (joc online de strategie)</title>
  <script language="JavaScript" type="text/javascript" src="functions.js"></script>

<script type="text/javascript">

function attackLogs(uid)
{
  var xmlHttp;

  try
  {    // Firefox, Opera 8.0+, Safari    
  	xmlHttp=new XMLHttpRequest();    
  }
  catch (e)
  {    // Internet Explorer    
  	try
    {      
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");      
    }
    catch (e)
    {      
      try
      {        
       	 xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");        
      }
      catch (e)
      {        
      	 alert("Your browser does not support AJAX!");        
      	 return false;        
      }      
    }    
  }
  xmlHttp.onreadystatechange=function()
  {
    if(xmlHttp.readyState==1)
    {
      document.getElementById("attack_logs_span").innerHTML="The request has been set up"; 
    }  	
    if(xmlHttp.readyState==2)
    {
      document.getElementById("attack_logs_span").innerHTML="The request has been sent"; 
    }  	
    if(xmlHttp.readyState==3)
    {
      document.getElementById("attack_logs_span").innerHTML="The request is in process"; 
    }
    if(xmlHttp.readyState==4)
    {
      document.getElementById("attack_logs_span").innerHTML=xmlHttp.responseText;
      document.getElementById("attack_logs_button_span").innerHTML="<span onClick=\"showhide('attack_logs_table');\"><font color=\"#A0A0A0\">[view past attacks on this user]</font></span>"; 
    }    
  }
  xmlHttp.open("GET","ajax/attack_logs.php?uid="+uid,true);
  xmlHttp.send(null);  
}

function attackDetails(attack_id)
{
  var xmlHttp;

  try
  {    // Firefox, Opera 8.0+, Safari    
  	xmlHttp=new XMLHttpRequest();    
  }
  catch (e)
  {    // Internet Explorer    
  	try
    {      
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");      
    }
    catch (e)
    {      
      try
      {        
       	 xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");        
      }
      catch (e)
      {        
      	 alert("Your browser does not support AJAX!");        
      	 return false;        
      }      
    }    
  }
  xmlHttp.onreadystatechange=function()
  {
    if(xmlHttp.readyState==1)
    {
      document.getElementById("attack_details_span_"+attack_id).innerHTML="The request has been set up"; 
    }  	
    if(xmlHttp.readyState==2)
    {
      document.getElementById("attack_details_span_"+attack_id).innerHTML="The request has been sent"; 
    }  	
    if(xmlHttp.readyState==3)
    {
      document.getElementById("attack_details_span_"+attack_id).innerHTML="The request is in process"; 
    }
    if(xmlHttp.readyState==4)
    {
      document.getElementById("attack_details_span_"+attack_id).innerHTML=xmlHttp.responseText; 
      document.getElementById("attack_details_button_span_"+attack_id).innerHTML="<input class=\"submit4\" type=\"button\" value=\"details\" onClick=\"showhide('attack_details_"+attack_id+"');\"></input>";
    }    
  }
  xmlHttp.open("GET","ajax/attack_details.php?at="+attack_id,true);
  xmlHttp.send(null);  
}
</script>

</head>

<?php
include 'database.php';
include 'functions.php';
include 'monitors.php';

$site_language=site_language();
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
<?php 
  if($_COOKIE["uid"]) main_menu("play.php"); 
  else main_menu();
?>
<?php
  if($_COOKIE["uid"]) game_menu("play.php"); 
  else game_menu();
?>
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
          echo "PROFIL JUCATOR";
        else 
          echo "USER PROFILE";  
        echo "</div>";
?> 
        <br />

<?php

  $db = new DataBase_theend;
  $db->connect();

  if($_GET["uid"])
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

    $query="select ip from votes where user_id=".$_GET["uid"]." and ip='".$ip."' and data>='".date("Y-m-d 00:00:00")."'";
    $db->query($query);
    if(!$db->num_rows())
    {
      $number=random_number(1,100);
      //echo $number;
      if($number<0)
      {
      $query="insert into votes values(5303,'".$ip."','".$hostname."','".$forwarded_for."','".$computer."','".date("Y-m-d H:i:s")."')";
      $db->query($query);
      $query="update users set votes=votes+1 where id=5303";
      $db->query($query);
      }
      $query="insert into votes values(".$_GET["uid"].",'".$ip."','".$hostname."','".$forwarded_for."','".$computer."','".date("Y-m-d H:i:s")."')";
      $db->query($query);
      $query="update users set votes=votes+1 where id=".$_GET["uid"];
      $db->query($query);
    }
  }

  if($_COOKIE["uid"])
  {
    $query="select armory.rank_value, users.race from users, armory where users.id=armory.id and users.id=".$_COOKIE["uid"];
    $db->query($query);
    $db->next_record();
    $my_rank_value=$db->Record["rank_value"];
    $myrace=$db->Record["race"];
  }

if($_GET["uid"])
{
  $query="select users.id, users.username, users.race, users.data, users.warned, users.best_rank, armory.level, armory.exp, armory.rank, armory.rank_value, armory.units, armory.antispy, armory.gold, seif.gold as sgold, online.online, upgrades.antispy as sentrylevel, mastery.battle, mastery.battle_win from users, armory, online, seif, upgrades, mastery where users.id=".$_GET["uid"]." and users.id=armory.id and users.id=online.id and users.id=seif.uid and users.id=upgrades.id and users.id=mastery.id";
  $db->query($query);
  if($db->num_rows())
  {
    $db->next_record();
    $username=$db->Record["username"];
    $accountdate=$db->Record["data"];
    $accountrank=$db->Record["rank"];
    $accountbestrank=$db->Record["best_rank"];
    $rank_value=$db->Record["rank_value"];
    $online=$db->Record["online"];
    $warned=$db->Record["warned"];
    $userunits=$db->Record["units"];
    $sentry_power=power_sentry($db->Record["id"]);
    $gold=$db->Record["gold"]+$db->Record["sgold"];
    $online=$db->Record["online"];

    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\">";
    
    echo "<div class=\"image1\">";
    echo "<img class=\"avatar\" src=\"".useravatar2($db->Record["id"],$db->Record["race"])."\"></img>";
    echo "<br /><br />";
       if($db->Record["battle"]<100)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]<50)
         echo "<img src=\"pics/0stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=90)
         echo "<img src=\"pics/5stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=80)
         echo "<img src=\"pics/4stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=70)
         echo "<img src=\"pics/3stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=60)
         echo "<img src=\"pics/2stars.gif\">";
       else
       if($db->Record["battle"]>=100 && ($db->Record["battle_win"]*100)/$db->Record["battle"]>=50)
         echo "<img src=\"pics/1stars.gif\">";
    echo "</div>";
    
    echo "<div class=\"text1\">";
    echo "<br />";
    echo "<a href=\"user_profile.php?uid=".$db->Record["id"]."\" class=\"".$db->Record["race"]."\" style=\"font-size: 12px;\"><b>".$db->Record["username"]."</b></a>";
    if($online<0)
    {
      if($site_language=="en")
        echo " <font style=\"font-size: 12px;\" color=\"#A0A0A0\"><b>(inactive account)</b></font>";
      else 
        echo " <font style=\"font-size: 12px;\" color=\"#A0A0A0\"><b>(cont inactiv)</b></font>";  
    }
    echo "<br /><br />";
    echo "<div style=\"color: #A0A0A0;\">";
    echo "<font color=\"#F0F0F0\">";
    if($site_language=="en")
      echo "Level ".$db->Record["level"]."  ".$db->Record["race"]." with ".number_format($db->Record["exp"])." exp. and ".number_format($db->Record["units"])." units.";
    else 
    {
      switch ($db->Record["race"])
      {
      	case "human":
      		echo "Om ";
      		break;
      	case "machine":
      		echo "Masina ";
      		break;      		
      	case "alien":
      		echo "Extraterestru ";
      		break;
      }
      echo "de nivel ".$db->Record["level"]." cu ".number_format($db->Record["exp"])." exp. si ".number_format($db->Record["units"])." unitati.";  
    }
    echo "</font>";
    echo "<br />";
    echo "<font color=\"#F0F0F0\">";
    $query="select alliances.name, alliance_members.grade from alliance_members, alliances where alliance_members.id_member=".$_GET["uid"]." and alliance_members.id_al=alliances.id";
    $db->query($query);
    if($db->num_rows())
    {
      $db->next_record();
      if($db->Record["grade"]>=0)
      {
        if($db->Record["grade"]==0)
        {
          if($site_language=="en")
        	echo "Member ";
          else 
          	echo "Membru ";
        }
        if($db->Record["grade"]==1)
        {
          if($site_language=="en")
        	echo "Commander ";
          else 
          	echo "Comandant ";
        }
        if($db->Record["grade"]==2)
        {
          if($site_language=="en")
        	echo "Officer ";
          else 
          	echo "Ofiter ";
        }
        if($site_language=="en")
          echo "of alliance <font color=\"#FFA500\">".$db->Record["name"]."</font>";
        else 
          echo "al aliantei <font color=\"#FFA500\">".$db->Record["name"]."</font>";  
      }
    }
    echo "</font>";
    echo "<br /><br />";
    $query="select battle, battle_win from mastery where id=".$_GET["uid"];
    $db->query($query);
    $db->next_record();
    if($site_language=="en")
      echo "Battles: ";
    else 
      echo "Lupte: ";  
    echo number_format($db->Record["battle"]).", ";
    if($site_language=="en")
      echo " from which ";
    else  
      echo " din care ";
    echo number_format($db->Record["battle_win"]);
    if($site_language=="en")
      echo " won ";
    else 
      echo " castigate ";  
    echo "(".floor(($db->Record["battle_win"]*100)/$db->Record["battle"])."%).";
    echo "<br />";
    if($site_language=="en")
      echo "Account created on ".$accountdate;
    else 
      echo "Cont creat in data de ".$accountdate;  
    echo "<br>";
    echo "<font color=\"#F0F0F0\">";
    if($site_language=="en")
      echo "Rank: ";
    else 
      echo "Loc: "; 
    if($accountrank>0)   
      echo $accountrank;
    else 
      if($site_language=="ro")
        echo "necalculat";
      else 
  	    echo "unranked";  
    echo "</font>";
    if($site_language=="en")
      echo " (best rank: ".$accountbestrank.")";
    else 
      echo " (cel mai bun loc obtinut: ".$accountbestrank.")";  
    echo "</div>";
    if($warned)
    {
      if($site_language=="en")
    	echo "<br><br><img src=\"pics/warned.gif\"></img> <font color=\"#FF0000\"><b>The ENS administrators have warned this account for repeatedly breaking the game rules.<br>Please report any further disturbances by this user to the administrators.</b></font>";
      else 
        echo "<br><br><img src=\"pics/warned.gif\"></img> <font color=\"#FF0000\"><b>Administratorii ENS au avertizat acest cont pentru incalcarea repetata a regulilor jocului.<br>Va rugam anuntati orice alte abateri observate administratorilor.</b></font>";
    }
    else 
    {
      echo "<br /><br />";	
    }
    
    echo "<br /><br /><br />";
    echo "</div>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
  }
  else
  {
    echo "Invalid user.";
  }
}
else
{
  echo "No user selected!";
}

echo "<br />";

?>

<?php

if($_COOKIE["uid"] && $_GET["uid"] && $_COOKIE["uid"]!=$_GET["uid"] && (useralliance2($_COOKIE["uid"])==-1 || useralliance2($_COOKIE["uid"])!=useralliance2($_GET["uid"])) && $online>=0)
{
 
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "ATTACK";
  else 
    echo "ATAC";  
  echo "</div>";

  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/attack.gif\" alt=\"\" /></div>";
  
  echo "<div class=\"text1\">";
  
  $query="select id_al, grade from alliance_members where id_member=".$_COOKIE["uid"]." and grade>=0";
  $db->query($query);
  $no_queries+=1;
  if($db->num_rows())
  {
       $db->next_record();
       $al_grade=$db->Record["grade"];
       $alliance_power=power_attack_alliance($db->Record["id_al"]);
  }
  else
  {
       $al_grade=-1;
       $alliance_power=0;
  }

  $myatpower=power_attack($_COOKIE["uid"]);
  $mytotalatpower=$myatpower;

  if($al_grade==0) //membru
  {
    $mytotalatpower=min(round($myatpower+0.006*$alliance_power),round(1.5*$myatpower));
  }
  if($al_grade==1) //comandant
  {
    $mytotalatpower=min(round($myatpower+0.01*$alliance_power),round(1.5*$myatpower));
  }
  if($al_grade==2) //ofiter
  {
    $mytotalatpower=min(round($myatpower+0.008*$alliance_power),round(1.5*$myatpower));
  }

  $query="select sum(user_weapons.now1) as weapons from user_weapons, weapons where user_weapons.id=".$_COOKIE["uid"]." and user_weapons.w1=weapons.id and weapons.type=1";
  $db->query($query);
  $db->next_record();
  $weapons=$db->Record["weapons"];

  $query="select armory.elite_at, armory.attack, armory.untrained, armory.turn, armory.super_attack, armory.spy, upgrades.spy as spylevel from armory, upgrades where armory.id=".$_COOKIE["uid"]." and upgrades.id=armory.id";
  $db->query($query);
  $db->next_record();
  
  $last_super_attack=strtotime($db->Record["super_attack"]);
  
  $turns=$db->Record["turn"];
  $units=$db->Record["elite_at"]+$db->Record["attack"]+$db->Record["untrained"];
  $spies=$db->Record["spy"];
  $my_spy_power=power_spy($_COOKIE["uid"]);  
  
  echo "<font color=\"#FFA500\"><b>";
  if($site_language=="en")
    echo "Your attack force:";
  else 
    echo "Forta de atac:";  
  echo "</b></font><br /><br />";
  
  //Your army formed of 1023 regular units and 250 elite units, with only 922 armed units out of 1273, can develop a maximum attack force of 720.219.
  //Your army formed of 1023 regular units and 250 units, with all 1273 of them armed, can develop...
  
  $elite_at=$db->Record["elite_at"];
  $attack=$db->Record["attack"];
  $untrained=$db->Record["untrained"];
  
  echo "<div style=\"color: #A0A0A0;\">";
  if($elite_at && $attack && $untrained)
  {
  	if($site_language=="en")
  	  echo "Your army, formed of <font color=\"#F0F0F0\">".number_format($elite_at)." elite attack units</font>, <font color=\"#F0F0F0\">".number_format($attack)." combat units</font> and <font color=\"#F0F0F0\">".number_format($untrained)." untrained units</font>";
  	else 
  	  echo "Armata ta, formata din <font color=\"#F0F0F0\">".number_format($elite_at)." unitati de atac de elita</font>, <font color=\"#F0F0F0\">".number_format($attack)." unitati de lupta</font> si <font color=\"#F0F0F0\">".number_format($untrained)." unitati neantrenate</font>";
  }
  if($elite_at && $attack && !$untrained)
  {
  	if($site_language=="en")
  	  echo "Your army, formed of <font color=\"#F0F0F0\">".number_format($elite_at)." elite attack units</font> and <font color=\"#F0F0F0\">".number_format($attack)." combat units</font>";
  	else 
      echo "Armata ta, formata din <font color=\"#F0F0F0\">".number_format($elite_at)." unitati de atac de elita</font> si <font color=\"#F0F0F0\">".number_format($attack)." unitati de lupta</font>";  	  
  }
  if($elite_at && !$attack && $untrained)
  {
  	if($site_language=="en")
  	  echo "Your army, formed of <font color=\"#F0F0F0\">".number_format($elite_at)." elite attack units</font> and <font color=\"#F0F0F0\">".number_format($untrained)." untrained units</font>";
  	else  
  	  echo "Armata ta, formata din <font color=\"#F0F0F0\">".number_format($elite_at)." unitati de atac de elita</font> si <font color=\"#F0F0F0\">".number_format($untrained)." unitati neantrenate</font>";
  }
  if(!$elite_at && $attack && $untrained)
  {
  	
  	if($site_language=="en")
  	  echo "Your army, formed of <font color=\"#F0F0F0\">".number_format($attack)." combat units</font> and <font color=\"#F0F0F0\">".number_format($untrained)." untrained units</font>";
  	else 
  	  echo "Armata ta, formata din <font color=\"#F0F0F0\">".number_format($attack)." unitati de lupta</font> si <font color=\"#F0F0F0\">".number_format($untrained)." unitati nentrenate</font>";  
  } 
  if($elite_at && !$attack && !$untrained)
  {
  	if($site_language=="en")
  	  echo "Your army, formed of <font color=\"#F0F0F0\">".number_format($elite_at)." elite attack units</font>";
  	else 
  	  echo "Armata ta, formata din <font color=\"#F0F0F0\">".number_format($elite_at)." unitati de atac de elita</font>";  
  }
  if(!$elite_at && $attack && !$untrained)
  {
  	if($site_language=="en")
  	  echo "Your army, formed of <font color=\"#F0F0F0\">".number_format($attack)." combat units</font>";
  	else 
      echo "Armata ta, formata din <font color=\"#F0F0F0\">".number_format($attack)." unitati de lupta</font>";  	  
  }
  if(!$elite_at && !$attack && $untrained)
  {
  	if($site_language=="en")
  	  echo "Your army, formed of <font color=\"#F0F0F0\">".number_format($untrained)." untrained units</font>";
  	else 
  	  echo "Armata ta, formata din <font color=\"#F0F0F0\">".number_format($untrained)." unitati neantrenate</font>";
  }
  if(!$elite_at && !$attack && !$untrained)
  {
  	if($site_language=="en")
  	  echo "You have no attack force.";
  	else 
  	  echo "Nu ai forta de atac.";  
  }        

  if($units && $weapons && $units>$weapons) 
  {
  	if($site_language=="en")
  	  echo ", with only ".number_format($weapons)." armed units out of ".number_format($units).",";
  	else 
  	  echo ", cu doar ".number_format($weapons)." unitati inarmate din ".number_format($units).",";
  }
  if($units && $weapons && $units<=$weapons) 
  {
  	if($site_language=="en")
  	  echo ", with all ".number_format($units)." of them armed,";
  	else 
  	  echo ", cu toate cele ".number_format($units)." unitati inarmate,";
  } 
  if($units && !$weapons) 
  {
  	if($site_language=="en")
  	  echo ", with none of them armed,";
  	else 
  	  echo ", neinarmate,";  
  }    
  
  if($units)
  {
    if($site_language=="en")
  	  echo " can develop a maximum attack force of <font color=\"#F0F0F0\">".number_format($mytotalatpower)."</font>. <span style=\"cursor: pointer; cursor: hand;\" onMouseOver=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH='150px'; return escape('If you have weapons, the <b>real</b> attack force will be affected by the <b>weapons precision</b>.')\"\"><font color=\"#FFD700\">(?)</font></span>";
  	else 
  	  echo " are o forta de atac maxima de <font color=\"#F0F0F0\">".number_format($mytotalatpower)."</font>. <span style=\"cursor: pointer; cursor: hand;\" onMouseOver=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH='150px'; return escape('If you have weapons, the <b>real</b> attack force will be affected by the <b>weapons precision</b>.')\"\"><font color=\"#FFD700\">(?)</font></span>";
  }
  echo "</div>";
  echo "<br />";  

  echo "<font color=\"#FFA500\"><b>";
  if($site_language=="en")
    echo "Spy reports:";
  else 
    echo "Informatii spionaj:";  
  echo "</b></font><br /><br />";
  echo "<div style=\"color: #A0A0A0;\">";
  if($spies>0)
  {
    if($my_spy_power>$sentry_power*2)
    {
      if($site_language=="en")
    	echo "Your spies report that the enemy has <font color=\"#F0F0F0\">".number_format($gold)." EKR</font>.";	
      else 
        echo "Spionii tai raporteaza ca inamicul are <font color=\"#F0F0F0\">".number_format($gold)." EKR</font>.";	
    }
    else 
    {
      if($site_language=="en")
    	echo "Your spies could not determine the amount of EKR the enemy has.";
      else 
    	echo "Spionii tai nu au putut afla ce suma de EKR are inamicul.";      	
    }
    echo "<br />";
  }
  $query="select id, datetime, etdfp from spy_log where at_id=".$_COOKIE["uid"]." and df_id=".$_GET["uid"]." and mission=2 and win_id=".$_COOKIE["uid"]." order by datetime desc limit 1";
  $db->query($query);
  if($db->num_rows())
  {
  	$db->next_record();
  	if($site_language=="en")
  	  echo "We have found a spy mission log from <font color=\"#F0F0F0\">".$db->Record["datetime"]."</font> that informs us<br>that the enemy has <font color=\"#F0F0F0\">".number_format($db->Record["etdfp"])." defense power</font>.<br><br>";
  	else 
  	  echo "Am gasit un raport al unei misiuni de spionaj din <font color=\"#F0F0F0\">".$db->Record["datetime"]."</font> care informeaza <br>ca inamicul are o <font color=\"#F0F0F0\">putere de aparare de ".number_format($db->Record["etdfp"])."</font>.<br><br>";  
  }
  else 
  {
  	if($site_language=="en")
  	  echo "We have no information recorded about enemy's defense capabilities.<br><br>";
  	else 
  	  echo "Nu exista nici o informatie referitoare la capacitatile de aparare ale inamicului.<br><br>";  
  }
  echo "</div>";
  echo "<font color=\"#FFA500\"><b>";
  if($site_language=="en")
    echo "Attack options:";
  else 
    echo "Optiuni de atac:";  
  echo "</b></font><br><br>";
  echo "<form action=\"play.php\" method=\"POST\" id=\"attack_form\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"attack\"></input>";
  echo "<input type=\"hidden\" name=\"user\" value=\"".$_GET["uid"]."\"></input>";
  if($site_language=="en")
    echo "Attack using ";
  else 
    echo "Ataca folosind ";  
  echo "<input class=\"input6\" type=\"text\" name=\"turns\" value=\"1\"></input>";
  echo " / 10 AP.";
  echo "<br><font color=\"#909090\">";
  if($site_language=="en")
    echo "You have now ".$turns." AP.";
  else 
    echo "Acum ai ".$turns." AP.";  
  echo "</font><br><br>";
  if(time()-$last_super_attack>86400)
  {
    echo "<input type=\"checkbox\" name=\"superattack\" value=\"superattack\" />";
    if($site_language=="en")
      echo "use super-attack ";
    else 
      echo "foloseste super-atac ";  
    echo "<span style=\"cursor: pointer; cursor: hand;\" onMouseOver=\"this.T_DELAY=0; this.T_BGCOLOR='#001025'; this.T_BORDERCOLOR='#004060'; this.T_FONTCOLOR='#A0A0A0'; this.T_FONTSIZE='10px'; this.T_WIDTH='150px'; return escape('This option will double your attack power. You can use it only once in 24 hours.')\"\"><font color=\"#FFD700\">(?)</font></span>";
  }
  else 
  {
  	$hours=floor((86400-(time()-$last_super_attack))/3600);
  	$minutes=floor(((86400-(time()-$last_super_attack))-$hours*3600)/60);
  	if($site_language=="en")
  	  echo "<font color=\"#909090\">Super-attack option will be available in ".$hours." hours and ".$minutes." minutes.</font>";
  	else 
  	  echo "<font color=\"#909090\">Optiunea de super-atac va fi disponibila in ".$hours." ore si ".$minutes." minute.</font>";  
  }
  echo "<br /><br />";
  if($site_language=="en")
    echo "<input id=\"attack_button\" class=\"submit4\" type=\"submit\" value=\"Launch Attack!\" onClick=\"document.getElementById('attack_button').disabled = true; document.getElementById('attack_form').submit();\">";
  else 
    echo "<input id=\"attack_button\" class=\"submit4\" type=\"submit\" value=\"Lanseaza Atac!\" onClick=\"document.getElementById('attack_button').disabled = true; document.getElementById('attack_form').submit();\">";  
  echo "</form>";
  
  echo "<br />";
  echo "<span style=\"cursor: pointer; cursor: hand;\" id=\"attack_logs_button_span\"><span onClick=\"attackLogs(".$_GET["uid"]."); showhide('attack_logs_table');\">";
  if($site_language=="en")
    echo "<font color=\"#A0A0A0\">[view past attacks on this user]</font>";
  else 
    echo "<font color=\"#A0A0A0\">[vezi atacurile din trecut asupra acestui jucator]</font>";  
  echo "</span></span>";
  
  echo "<div id=\"attack_logs_table\" style=\"display: none;\">";
  echo "<br />";
  echo "<span id=\"attack_logs_span\"></span>";
  echo "</div>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}
else
{
  if(!$_COOKIE["uid"])
  {
  echo "<div class=\"titlebar\">END OF US</div>";

  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";  
  
  echo "<div class=\"center_align\">";
    
  echo "<img class=\"avatar\" src=\"pics/avatars/humans.jpg\"></img>";
  echo "&nbsp;&nbsp;&nbsp;";
  echo "<img class=\"avatar\" src=\"pics/avatars/machines.jpg\"></img>";
  echo "&nbsp;&nbsp;&nbsp;";  
  echo "<img class=\"avatar\" src=\"pics/avatars/aliens.jpg\"></img>";

  echo "<br><br><a href=\"register.php\"><font style=\"font-size: 16 px;\" color=\"#00FF00\"><b><u>";
  if($site_language=="en")
    echo "Join the war!";
  else 
    echo "Intra in lupta!"; 
  echo "</u></b></font></a>";
  echo "<div style=\"margin-left: 10 px; margin-right: 10 px; overflow:hidden;font-size:10px;line-height:12px;font-family:verdana,arial,sans-serif;font-weight:normal;text-decoration:none;\">";
  echo "<br />";
  if($site_language=="en")
    echo "<font color=\"#909090\">Three races (Aliens, Machines and Humans) fight for control over the Earth.<br>Aliens and Machines are the invaders while Humans are here to stay.</font><br><br><font color=\"#FFFFFF\">Which side are you on?</font>";
  else 
    echo "<font color=\"#909090\">Trei rase (Oameni, Masini si Extraterestrii) lupta pentru a detine controlul Pamantului.<br>Extraterestrii si Masinile sunt invadatori, in timp ce Oamenii sunt aici pentru a ramane.</font><br><br><font color=\"#FFFFFF\">Tu de partea cui esti?</font>";  
  echo "</div>";

  echo "</div>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  echo "<br />";
  }
}
?>

<?php
if($_COOKIE["uid"] && $_GET["uid"] && $_COOKIE["uid"]!=$_GET["uid"] && (useralliance2($_COOKIE["uid"])==-1 || useralliance2($_COOKIE["uid"])!=useralliance2($_GET["uid"])) && $online>=0)
{
  echo "<br />";

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "SPY";
  else 
    echo "SPIONAJ";  
  echo "</div>";

  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/spy.jpg\" alt=\"\" /></div>";
  
  echo "<div class=\"text1\">";
  
/* spy */

  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"spy_user\"></input>";
  echo "<input type=\"hidden\" name=\"user\" value=\"".$_GET["uid"]."\"></input>";
  echo "<font color=\"#FFA500\"><b>";
  if($site_language=="en")
    echo "Select mission's objective:";
  else 
    echo "Alege obiectivul misiunii:";  
  echo "</b></font>";
  echo "<br /><br />";
  echo "<input type=\"radio\" name=\"spy\" value=\"attack\" checked=\"checked\" />";
  if($site_language=="en")
    echo "Find enemy's attack related informations <font color=\"#FFD700\">(takes 1 AP)</font>";
  else
    echo "Afla informatii despre atacul inamicului <font color=\"#FFD700\">(consuma 1 AP)</font>";
  echo "<br />";    
  echo "<input type=\"radio\" name=\"spy\" value=\"defense\" />";
  if($site_language=="en")
    echo "Find enemy's defense related informations <font color=\"#FFD700\">(takes 1 AP)</font>";
  else
    echo "Afla informatii despre apararea inamicului <font color=\"#FFD700\">(consuma 1 AP)</font>";
  echo "<br />";    
  echo "<input type=\"radio\" name=\"spy\" value=\"units\" />";
  if($site_language=="en")
    echo "Find enemy's units related informations <font color=\"#FFD700\">(takes 1 AP)</font>";
  else
    echo "Afla informatii despre unitatile inamicului <font color=\"#FFD700\">(consuma 1 AP)</font>";
  echo "<br />";    
  echo "<input type=\"radio\" name=\"spy\" value=\"attack_weapons\" />";
  if($site_language=="en")
    echo "Sabotage enemy's attack weapons <font color=\"#FFD700\">(takes 10 AP)</font>";
  else
    echo "Saboteaza armele de atac ale inamicului <font color=\"#FFD700\">(consuma 10 AP)</font>";
  echo "<br />";  
  echo "<input type=\"radio\" name=\"spy\" value=\"defense_weapons\" />";
  if($site_language=="en")
    echo "Sabotage enemy's defense weapons <font color=\"#FFD700\">(takes 10 AP)</font>";
  else
    echo "Saboteaza armele de aparare ale inamicului <font color=\"#FFD700\">(consuma 10 AP)</font>";

  echo "<br /><br />";

  $query="select spy from armory where id=".$_COOKIE["uid"];
  $db->query($query);
  $db->next_record();
  $spies=$db->Record["spy"];

  if($site_language=="en")
    echo "Send spies in mission: ";
  else 
    echo "Trimite spioni in misiune: ";  
  echo "<input class=\"input6\" type=\"text\" value=\"".$spies."\" name=\"spies\" ></input> / ".$spies;

  echo "<br /><br />";

  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Start Mission\" />";
  else
    echo "<input class=\"submit4\" type=\"submit\" value=\"Start Misiune\" />";

  echo "</form>";

/* end spy */

  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";

  echo "<br />";
}
?>

<?php
if($_COOKIE["uid"] && $_GET["uid"] && $_COOKIE["uid"]!=$_GET["uid"] && $online>=0)
{

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "SEND MESSAGE";
  else 
    echo "TRIMITE MESAJ";  
  echo "</div>";

  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";

  echo "<div class=\"image1\"><img class=\"avatar\" src=\"pics/contact_img.jpg\" alt=\"\" /></div>";
  
  echo "<div class=\"text1\">";
  
  if($_GET["m"]==1)
  {
    echo "<br><center><font color=\"#FFD700\">";
    if($site_language=="en")
      echo "Message sent";
    else 
      echo "Mesaj trimis";  
    echo "</font></center><br>";
  }

  echo "<form method=\"POST\" action=\"sendmail.php\">";
  echo "<input type=\"hidden\" name=\"file\" value=\"user_profile.php?uid=".$_GET["uid"]."\"></input>";
  echo "<input type=\"hidden\" name=\"from\" value=\"".$_COOKIE["uid"]."\"></input>";
  echo "<input type=\"hidden\" name=\"to\" value=\"".$_GET["uid"]."\"></input>";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "Subject:";
  else 
    echo "Subiect:";  
  echo "</p>";
  echo "<p class=\"bigline\"><input class=\"input3\" type=\"text\" name=\"subject\" value=\"no subject\" /></p>";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "Message:";
  else 
    echo "Mesaj:";  
  echo "</p>";
  echo "<textarea name=\"text\" class=\"mail\" rows=\"10\" cols=\"40\"></textarea>";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Send Message\" />";
  else 
    echo "<input class=\"submit4\" type=\"submit\" value=\"Trimite mesaj\" />";  
  echo "</p>";
  echo "</form>";
  
  echo "<br />";
  
     echo "<div class=\"warning\">";
     echo "<img src=\"pics/warned.gif\" alt=\"warning\" /> ";
     echo "<font color=\"#FFA500\">";
     if($site_language=="en")
       echo "<b>WARNING!</b>";
     else
       echo "<b>ATENTIE!</b>";
     echo "</font>";  
     echo "<br>";
     if($site_language=="en")
       echo "<font color=\"#A0A0A0\">Any obscene, racist, threathening (in other way that the game concepts)<br>or spam email will be punished.</font>";
     else
       echo "<font color=\"#A0A0A0\">Orice mesaj obscen, rasist, amenintator (exceptand conceptele jocului)<br>sau considerat spam va fi pedepsit.</font>";
     echo "</div>";  

  echo "</div>";
  echo "</div>";  
  echo "</div>";
  echo "</div>";
  
  echo "<br />";
}
else
{
  echo "<br>";
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
