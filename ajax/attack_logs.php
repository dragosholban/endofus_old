<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

include '../database.php';
include '../functions.php';
 
$db = new DataBase_theend;
$db->connect();
$db2 = new DataBase_theend;
$db2->connect();

$site_language=site_language();

if($_COOKIE["uid"] && $_GET["uid"])
{
  $query="select id, at_id, df_id, date, win_id from attack_log where at_id=".$_COOKIE["uid"]." and df_id=".$_GET["uid"]." order by date desc";
  $db->query($query);
  
  if($db->num_rows())
  {
  
  $nr_inreg_cur=0;
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  
  while($db->next_record())
  {
	$nr_inreg_cur++;
    $query="select username, race from users where id=".$db->Record["df_id"];
    $db2->query($query);
    $db2->next_record();
    
  	echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
    echo "<tr>";
    echo "<td class=\"atl1\"><font color=\"#A0A0A0\">&nbsp;".$nr_inreg_cur."&nbsp;</font></td>";
    echo "<td class=\"atl2\"><a class=\"".$db2->Record["race"]."\" href=\"user_profile.php?uid=".$db->Record["df_id"]."\">".$db2->Record["username"]."</a></td>";
    echo "<td class=\"atl3\">";
    if ($db->Record["win_id"]==$_COOKIE["uid"])
    {
      if($site_language=="en")
        echo "<font color=\"#F0F0F0\">you won</font>";
      else
        echo "<font color=\"#F0F0F0\">ai castigat</font>";
    }
    if ($db->Record["win_id"]==$db->Record["df_id"])
    {
      if($site_language=="en")
        echo "<font color=\"#A0A0A0\">you lost</font>";
      else
        echo "<font color=\"#A0A0A0\">ai pierdut</font>";
    }
    if ($db->Record["win_id"]==0)
    {
      if($site_language=="en")
        echo "draw";
      else
        echo "egalitate";
    }
    echo "</td>";
    echo "<td class=\"atl4\">".$db->Record["date"]."</td>";    
    echo "<td class=\"atl5\" style=\"text-align: center;\">";
    echo "<span id=\"attack_details_button_span_".$db->Record["id"]."\"><input class=\"submit4\" type=\"button\" value=\"details\" onClick=\"attackDetails(".$db->Record["id"]."); showhide('attack_details_".$db->Record["id"]."');\"></input></span>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<div style=\"margin: 10px; display:none;\" id=\"attack_details_".$db->Record["id"]."\">";
    
    echo "<div class=\"attack_details\">";
    echo "<span id=\"attack_details_span_".$db->Record["id"]."\"></span>";
    echo "</div>";
    
    echo "</div>"; 
  }  
  
  echo "</table>";
  
  }
  else 
  {
  	if($site_language=="en")
  	  echo "No attacks.";
  	else 
  	  echo "Nici un atac.";  
  }
}  
?>
