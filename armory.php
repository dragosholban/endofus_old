<?php

function armory()
{

  $myrace=userrace($_COOKIE["uid"]);

  global $login_expires;
  global $no_queries;
  
  $site_language=site_language();

  $ppath="pics/";

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $id=$_COOKIE["uid"];
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "WEAPONS INVENTORY";
  else 
    echo "INVENTAR ARME";  
  echo "</div>";
  
  echo "<br />";
  
  if($_POST["what"]=="attack")
  {

  $query="select weapons.id, weapons.name, weapons.price, weapons.type, weapons.power, user_weapons.now1, user_weapons.procw1 from weapons, user_weapons where weapons.type=1 and weapons.id=user_weapons.w1 and user_weapons.id=".$id." order by weapons.price desc";
  $db_theend->query($query);
  $no_queries+=1;

  echo "<div class=\"section\">";

  $afisat=0;
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  
  while($db_theend->next_record())
  {

  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_sell=$ppt*80/100;

  $afisat=1;
  
  echo "<tr>";
  echo "<td class=\"arm1\">";
  echo $db_theend->Record["name"];
  echo "</td>";
  echo "<td class=\"arm2\">".number_format($db_theend->Record["now1"])."</td>";  
  echo "<td class=\"arm3\">";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">".number_format($db_theend->Record["procw1"])."</font>";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">&nbsp/&nbsp;".number_format($db_theend->Record["now1"]*$db_theend->Record["power"])."</font>";
  echo "</td>";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"sell_armory\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";  
  echo "<td class=\"arm4\"><input class=\"input4\" id=\"is".$db_theend->Record["id"]."\" type=\"text\" size=\"5\" name=\"".str_replace(" ","",$db_theend->Record["name"])."\" onkeyup=\"javaprice2('ws".$db_theend->Record["id"]."','is".$db_theend->Record["id"]."',".$ppt_sell.",".$wproc.");\" value=\"1\"></input></td>";
  echo "<td class=\"arm5\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Sell\"></input>";
  else
    echo "<input class=\"submit4\" type=\"submit\" value=\"Vinde\"></input>";
  echo "</td>";
  echo "</form>";
  echo "<td class=\"arm6\"><span id=\"ws".$db_theend->Record["id"]."\">".round($wproc*$ppt_sell)."</span>";
  if($site_language=="en")
    echo " EKR";
  else
    echo " EKR";
  echo "</td>";
  echo "</tr>";
  $i++;
  }
  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "No weapons";
    else
      echo "Nici o arma";
    echo "</td></tr>";  
  }
  echo "</table>";
  echo "</div>";
  }
  
  if($_POST["what"]=="defense")
  {

  $query="select weapons.id, weapons.name, weapons.price, weapons.type, weapons.power, user_weapons.now1, user_weapons.procw1 from weapons, user_weapons where weapons.type=0 and weapons.id=user_weapons.w1 and user_weapons.id=".$id." order by weapons.price desc";
  $db_theend->query($query);
  $no_queries+=1;

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  $afisat=0;
  if($db_theend->num_rows())
  {
    // echo "<tr><td colspan=\"9\" height=\"1\" bgcolor=\"#404040\"></td></tr>";
  }
  
  while($db_theend->next_record())
  {

  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_sell=$ppt*80/100;

  $afisat=1;
  
  echo "<tr>";
  echo "<td class=\"arm1\">";
  echo $db_theend->Record["name"];
  echo "</td>";
  echo "<td class=\"arm2\">".number_format($db_theend->Record["now1"])."</td>";  
  echo "<td class=\"arm3\">";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">".number_format($db_theend->Record["procw1"])."</font>";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">&nbsp/&nbsp;".number_format($db_theend->Record["now1"]*$db_theend->Record["power"])."</font>";
  echo "</td>";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"sell_armory\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
  echo "<td class=\"arm4\"><input class=\"input4\" id=\"is".$db_theend->Record["id"]."\" type=\"text\" size=\"5\" name=\"".str_replace(" ","",$db_theend->Record["name"])."\" onkeyup=\"javaprice2('ws".$db_theend->Record["id"]."','is".$db_theend->Record["id"]."',".$ppt_sell.",".$wproc.");\" value=\"1\"></input></td>";
  echo "<td class=\"arm5\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Sell\"></input>";
  else
    echo "<input class=\"submit4\" type=\"submit\" value=\"Vinde\"></input>";
  echo "</td>";
  echo "</form>";
  echo "<td class=\"arm6\"><span id=\"ws".$db_theend->Record["id"]."\">".round($wproc*$ppt_sell)."</span>";
  if($site_language=="en")
    echo " EKR";
  else
    echo " EKR";
  echo "</td>";
  echo "</tr>";

  }
  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "No weapons";
    else
      echo "Nici o arma";
    echo "</td></tr>";  
  }

  echo "</table>";

  echo "</div>";

  }  

  if($_POST["what"]=="spy")
  {

  $query="select weapons.id, weapons.name, weapons.price, weapons.type, weapons.power, user_weapons.now1, user_weapons.procw1 from weapons, user_weapons where weapons.type=3 and weapons.id=user_weapons.w1 and user_weapons.id=".$id." order by weapons.price desc";
  $db_theend->query($query);
  $no_queries+=1;

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  $afisat=0;
  if($db_theend->num_rows())
  {
    // echo "<tr><td colspan=\"9\" height=\"1\" bgcolor=\"#404040\"></td></tr>";
  }
  $i=0;
  while($db_theend->next_record())
  {

  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_sell=$ppt*80/100;

  //if(!$afisat) echo "<br>";
  $afisat=1;
  
  echo "<tr>";
      
  echo "<td class=\"arm1\">";
  echo $db_theend->Record["name"];
  echo "</td>";
  echo "<td class=\"arm2\">".number_format($db_theend->Record["now1"])."</td>";  
  echo "<td class=\"arm3\">";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">".number_format($db_theend->Record["procw1"])."</font>";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">&nbsp/&nbsp;".number_format($db_theend->Record["now1"]*$db_theend->Record["power"])."</font>";
  echo "</td>";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"sell_armory\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
  echo "<td class=\"arm4\"><input class=\"input4\" id=\"is".$db_theend->Record["id"]."\" type=\"text\" size=\"5\" name=\"".str_replace(" ","",$db_theend->Record["name"])."\" onkeyup=\"javaprice2('ws".$db_theend->Record["id"]."','is".$db_theend->Record["id"]."',".$ppt_sell.",".$wproc.");\" value=\"1\"></input></td>";
  echo "<td class=\"arm5\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Sell\"></input>";
  else
    echo "<input class=\"submit4\" type=\"submit\" value=\"Vinde\"></input>";
  echo "</td>";
  echo "</form>";
  echo "<td class=\"arm6\"><span id=\"ws".$db_theend->Record["id"]."\">".round($wproc*$ppt_sell)."</span>";
  if($site_language=="en")
    echo " EKR";
  else
    echo " EKR";
  echo "</td>";
  echo "</tr>";
  }
  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "No weapons";
    else
      echo "Nici o arma";
    echo "</td></tr>";  
  }

  echo "</table>";

  echo "</div>";

  } 
  
  if($_POST["what"]=="sentry")
  {

  $query="select weapons.id, weapons.name, weapons.price, weapons.type, weapons.power, user_weapons.now1, user_weapons.procw1 from weapons, user_weapons where weapons.type=4 and weapons.id=user_weapons.w1 and user_weapons.id=".$id." order by weapons.price desc";
  $db_theend->query($query);
  $no_queries+=1;

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  $afisat=0;
  if($db_theend->num_rows())
  {
    // echo "<tr><td colspan=\"9\" height=\"1\" bgcolor=\"#404040\"></td></tr>";
  }
  $i=0;
  while($db_theend->next_record())
  {

  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_sell=$ppt*80/100;

  //if(!$afisat) echo "<br>";
  $afisat=1;
  
  echo "<tr>";
      
  echo "<td class=\"arm1\">";
  echo $db_theend->Record["name"];
  echo "</td>";
  echo "<td class=\"arm2\">".number_format($db_theend->Record["now1"])."</td>";  
  echo "<td class=\"arm3\">";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">".number_format($db_theend->Record["procw1"])."</font>";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">&nbsp/&nbsp;".number_format($db_theend->Record["now1"]*$db_theend->Record["power"])."</font>";
  echo "</td>";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"sell_armory\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
  echo "<td class=\"arm4\"><input class=\"input4\" id=\"is".$db_theend->Record["id"]."\" type=\"text\" size=\"5\" name=\"".str_replace(" ","",$db_theend->Record["name"])."\" onkeyup=\"javaprice2('ws".$db_theend->Record["id"]."','is".$db_theend->Record["id"]."',".$ppt_sell.",".$wproc.");\" value=\"1\"></input></td>";
  echo "<td class=\"arm5\">";
  if($site_language=="en")
    echo "<input class=\"submit4\" type=\"submit\" value=\"Sell\"></input>";
  else
    echo "<input class=\"submit4\" type=\"submit\" value=\"Vinde\"></input>";
  echo "</td>";
  echo "</form>";
  echo "<td class=\"arm6\"><span id=\"ws".$db_theend->Record["id"]."\">".round($wproc*$ppt_sell)."</span>";
  if($site_language=="en")
    echo " EKR";
  else
    echo " EKR";
  echo "</td>";
  echo "</tr>";
  }
  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "No weapons";
    else
      echo "Nici o arma";
    echo "</td></tr>";  
  }

  echo "</table>";

  echo "</div>";

  }
  
  echo "<br />";
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "REPAIR WEAPONS";
  else 
    echo "REPARARE ARME";  
  echo "</div>";

  echo "<br />";
  
  if($_POST["what"]=="attack")
  {  

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $query="select weapons.id, weapons.name, weapons.type, weapons.power, weapons.price, user_weapons.now1, user_weapons.procw1 from weapons, user_weapons where weapons.type=1 and weapons.id=user_weapons.w1 and user_weapons.id=".$id." order by weapons.price desc";
  $db_theend->query($query);
  $no_queries+=1;
  $afisat=0;
  $i=0;
  while($db_theend->next_record())
  {
  	
  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_repair=$ppt*50/100;

  if($db_theend->Record["procw1"]<($db_theend->Record["now1"]*$db_theend->Record["power"]))
  {
    echo "<tr>";
    echo "<td class=\"arm1\">";
    echo $db_theend->Record["name"];
    echo "</td>";
    echo "<td class=\"arm2\">".number_format($db_theend->Record["now1"])."</td>";
  echo "<td class=\"arm3\">";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">".number_format($db_theend->Record["procw1"])."</font>";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">&nbsp/&nbsp;".number_format($db_theend->Record["now1"]*$db_theend->Record["power"])."</font>";
  echo "</td>";
    echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"armory\"></input>";
    echo "<input type=\"hidden\" name=\"act\" value=\"repair\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
    echo "<input type=\"hidden\" name=\"weapon\" value=\"".$db_theend->Record["id"]."\"></input>";
    echo "<td class=\"arm4\"><input id=\"i".$db_theend->Record["id"]."\" class=\"input4\" type=\"text\" name=\"proc\" value=\"".($nr*$power-$proc)."\" size=\"5\" onkeyup=\"javaprice('w".$db_theend->Record["id"]."','i".$db_theend->Record["id"]."',".$ppt_repair.");\"></input></td>";
    echo "<td class=\"arm5\">";
    if($site_language=="en")
      echo "<input class=\"submit4\" type=\"submit\" value=\"Repair\"></input>";
    else
      echo "<input class=\"submit4\" type=\"submit\" value=\"Repara\"></input>";
    echo "</td>";
    echo "</form>";
    echo "<td class=\"arm6\"><span id=\"w".$db_theend->Record["id"]."\">".(($nr*$power-$proc)*$ppt_repair)."</span> ";
    if($site_language=="en")
      echo "EKR";
    else
      echo "EKR";
    echo "</td>";
    echo "</tr>";

    $afisat=1;
  }
    
  }

  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "Nothing to be repaired";
    else
      echo "Nimic de reparat";
    echo "</td></tr>";  
  }
  
  echo "</table>";

  echo "</div>";
  
  }

  if($_POST["what"]=="defense")
  {  

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $query="select weapons.id, weapons.name, weapons.type, weapons.power, weapons.price, user_weapons.now1, user_weapons.procw1 from weapons, user_weapons where weapons.type=0 and weapons.id=user_weapons.w1 and user_weapons.id=".$id." order by weapons.price desc";
  $db_theend->query($query);
  $no_queries+=1;
  $afisat=0;
  $i=0;
  while($db_theend->next_record())
  {
  	
  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_repair=$ppt*50/100;

  if($db_theend->Record["procw1"]<($db_theend->Record["now1"]*$db_theend->Record["power"]))
  {
    echo "<tr>";
    echo "<td class=\"arm1\">";
    echo $db_theend->Record["name"];
    echo "</td>";
    echo "<td class=\"arm2\">".number_format($db_theend->Record["now1"])."</td>";
  echo "<td class=\"arm3\">";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">".number_format($db_theend->Record["procw1"])."</font>";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">&nbsp/&nbsp;".number_format($db_theend->Record["now1"]*$db_theend->Record["power"])."</font>";
  echo "</td>";
    echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"armory\"></input>";
    echo "<input type=\"hidden\" name=\"act\" value=\"repair\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
    echo "<input type=\"hidden\" name=\"weapon\" value=\"".$db_theend->Record["id"]."\"></input>";
    echo "<td class=\"arm4\"><input id=\"i".$db_theend->Record["id"]."\" class=\"input4\" type=\"text\" name=\"proc\" value=\"".($nr*$power-$proc)."\" size=\"5\" onkeyup=\"javaprice('w".$db_theend->Record["id"]."','i".$db_theend->Record["id"]."',".$ppt_repair.");\"></input></td>";
    echo "<td class=\"arm5\">";
    if($site_language=="en")
      echo "<input class=\"submit4\" type=\"submit\" value=\"Repair\"></input>";
    else
      echo "<input class=\"submit4\" type=\"submit\" value=\"Repara\"></input>";
    echo "</td>";
    echo "</form>";
    echo "<td class=\"arm6\"><span id=\"w".$db_theend->Record["id"]."\">".(($nr*$power-$proc)*$ppt_repair)."</span> ";
    if($site_language=="en")
      echo "EKR";
    else
      echo "EKR";
    echo "</td>";
    echo "</tr>";
    // echo "<tr><td colspan=\"9\" height=\"1\" bgcolor=\"#404040\"></td></tr>";
    $afisat=1;
    
    $i++;
  }
    
  }

  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "Nothing to be repaired";
    else
      echo "Nimic de reparat";
    echo "</td></tr>";  
  }
  
  echo "</table>";
  
  echo "</div>";
  
  }  
  
  if($_POST["what"]=="spy")
  {  

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $query="select weapons.id, weapons.name, weapons.type, weapons.power, weapons.price, user_weapons.now1, user_weapons.procw1 from weapons, user_weapons where weapons.type=3 and weapons.id=user_weapons.w1 and user_weapons.id=".$id." order by weapons.price desc";
  $db_theend->query($query);
  $no_queries+=1;
  $afisat=0;
  $i=0;
  while($db_theend->next_record())
  {
  	
  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_repair=$ppt*50/100;

  if($db_theend->Record["procw1"]<($db_theend->Record["now1"]*$db_theend->Record["power"]))
  {
    echo "<tr>";
    
    echo "<td class=\"arm1\">";
    echo $db_theend->Record["name"];
    echo "</td>";
    echo "<td class=\"arm2\">".number_format($db_theend->Record["now1"])."</td>";
    echo "<td class=\"arm3\">";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">".number_format($db_theend->Record["procw1"])."</font>";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">&nbsp/&nbsp;".number_format($db_theend->Record["now1"]*$db_theend->Record["power"])."</font>";
  echo "</td>";
    echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"armory\"></input>";
    echo "<input type=\"hidden\" name=\"act\" value=\"repair\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
    echo "<input type=\"hidden\" name=\"weapon\" value=\"".$db_theend->Record["id"]."\"></input>";
    echo "<td class=\"arm4\"><input id=\"i".$db_theend->Record["id"]."\" class=\"input4\" type=\"text\" name=\"proc\" value=\"".($nr*$power-$proc)."\" size=\"5\" onkeyup=\"javaprice('w".$db_theend->Record["id"]."','i".$db_theend->Record["id"]."',".$ppt_repair.");\"></input></td>";
    echo "<td class=\"arm5\">";
    if($site_language=="en")
      echo "<input class=\"submit4\" type=\"submit\" value=\"Repair\"></input>";
    else
      echo "<input class=\"submit4\" type=\"submit\" value=\"Repara\"></input>";
    echo "</td>";
    echo "</form>";
    echo "<td class=\"arm6\"><span id=\"w".$db_theend->Record["id"]."\">".(($nr*$power-$proc)*$ppt_repair)."</span> ";
    if($site_language=="en")
      echo "EKR";
    else
      echo "EKR";
    echo "</td>";
    echo "</tr>";
    $afisat=1;
  }
    
  }

  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "Nothing to be repaired";
    else
      echo "Nimic de reparat";
    echo "</td></tr>";  
  }
  
  echo "</table>";

  echo "</div>";
  
  }  
  
  if($_POST["what"]=="sentry")
  {  

  echo "<div class=\"section\">";
  
  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";

  $query="select weapons.id, weapons.name, weapons.type, weapons.power, weapons.price, user_weapons.now1, user_weapons.procw1 from weapons, user_weapons where weapons.type=4 and weapons.id=user_weapons.w1 and user_weapons.id=".$id." order by weapons.price desc";
  $db_theend->query($query);
  $no_queries+=1;
  $afisat=0;
  $i=0;
  while($db_theend->next_record())
  {
  	
  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_repair=$ppt*50/100;

  if($db_theend->Record["procw1"]<($db_theend->Record["now1"]*$db_theend->Record["power"]))
  {
    echo "<tr>";
   
    echo "<td class=\"arm1\">";
    echo $db_theend->Record["name"];
    echo "</td>";
    echo "<td class=\"arm2\">".number_format($db_theend->Record["now1"])."</td>";
  echo "<td class=\"arm3\">";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">".number_format($db_theend->Record["procw1"])."</font>";
  echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">&nbsp/&nbsp;".number_format($db_theend->Record["now1"]*$db_theend->Record["power"])."</font>";
  echo "</td>";
    echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"armory\"></input>";
    echo "<input type=\"hidden\" name=\"act\" value=\"repair\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
    echo "<input type=\"hidden\" name=\"weapon\" value=\"".$db_theend->Record["id"]."\"></input>";
    echo "<td class=\"arm4\"><input id=\"i".$db_theend->Record["id"]."\" class=\"input4\" type=\"text\" name=\"proc\" value=\"".($nr*$power-$proc)."\" size=\"5\" onkeyup=\"javaprice('w".$db_theend->Record["id"]."','i".$db_theend->Record["id"]."',".$ppt_repair.");\"></input></td>";
    echo "<td class=\"arm5\">";
    if($site_language=="en")
      echo "<input class=\"submit4\" type=\"submit\" value=\"Repair\"></input>";
    else
      echo "<input class=\"submit4\" type=\"submit\" value=\"Repara\"></input>";
    echo "</td>";
    echo "</form>";
    echo "<td class=\"arm6\"><span id=\"w".$db_theend->Record["id"]."\">".(($nr*$power-$proc)*$ppt_repair)."</span> ";
    if($site_language=="en")
      echo "EKR";
    else
      echo "EKR";
    echo "</td>";
    echo "</tr>";
    $afisat=1;
  }
    
  }

  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "Nothing to be repaired";
    else
      echo "Nimic de reparat";
    echo "</td></tr>";  
  }
  
  echo "</table>";

  echo "</div>";
  
  }  
  
  $query="select weapons.id, weapons.name, weapons.price, weapons.type, weapons.power, user_weapons.now1, user_weapons.procw1 from weapons, user_weapons where weapons.id=user_weapons.w1 and user_weapons.id=".$id." order by weapons.type desc, weapons.price desc";
  $db_theend->query($query);
  $no_queries+=1;

  $query="select attack, defense, spy, antispy from upgrades where id=".$_COOKIE["uid"];
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();
  $atlevel=$db_theend->Record["attack"];
  $dflevel=$db_theend->Record["defense"];
  $spylevel=$db_theend->Record["spy"];
  $antispylevel=$db_theend->Record["antispy"];  

  $afisat=0;  
  
  echo "<br />";
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "BUY WEAPONS";
  else 
    echo "CUMPARARE ARME";  
  echo "</div>";

  echo "<br />";
  
  if($_POST["what"]=="attack")
  {
  echo "<div class=\"section\">";

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  
  echo "<form name=\"form_buy_weapons\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"armory\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
  echo "<input type=\"hidden\" name=\"act\" value=\"buy\"></input>";

  $query="select name, power, price from weapons where race='".$myrace."' and type=1 order by power";
  $db_theend->query($query);
  $no_queries+=1;
  $i=0;
  
  while($db_theend->next_record() && $atlevel)
  {
    $afisat=1;  	
    $atlevel--;

  echo "<tr>";
  echo "<td class=\"arm7\">".$db_theend->Record["name"]."</td>";
  echo "<td class=\"arm8\">";
  echo "<font color=\"#F0F0F0\">".number_format($db_theend->Record["power"])."</font> ";
  if($site_language=="en")
    echo "attack power";
  else
    echo "putere de atac";
  echo "</td>";  
  echo "<td class=\"arm9\">".number_format($db_theend->Record["price"])." ";
  if($site_language=="en")
    echo "EKR";
  else
    echo "EKR";
  echo "</td>";
  echo "<td class=\"arm10\">";
  if($site_language=="en")
    echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">Quantity:</font>";
  else
    echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">Cantitate:</font>";
  echo "&nbsp;&nbsp;&nbsp;<input class=\"input4\" type=\"text\" size=\"5\" name=\"".str_replace(" ","",$db_theend->Record["name"])."\" value=\"0\"></input>&nbsp;&nbsp;&nbsp;</td>";
  echo "</tr>";

  }

  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "No weapons availlable";
    else
      echo "Nu sunt arme disponibile";
    echo "</td></tr>";  
  }
  else
  {
    echo "<tr><td class=\"arm11\" colspan=\"4\">";
  	if($site_language=="en")
    {
      echo "<input id=\"form_buy_weapons_submit_button\" class=\"submit4\" type=\"button\" value=\"Buy\" onClick=\"document.getElementById('form_buy_weapons_submit_button').disabled = true; form_buy_weapons.submit();\"></input>";
    }
    else
    {
      echo "<input id=\"form_buy_weapons_submit_button\" class=\"submit4\" type=\"button\" value=\"Cumpara\" onClick=\"document.getElementById('form_buy_weapons_submit_button').disabled = true; form_buy_weapons.submit();\"></input>";
    }
    echo "</td></tr>";  
  }
  echo "</form>";
  
  echo "</table>";
  
  echo "</div>";  	 
  }
  
  if($_POST["what"]=="defense")
  {

  echo "<div class=\"section\">";

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  
  echo "<form name=\"form_buy_weapons\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"armory\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
  echo "<input type=\"hidden\" name=\"act\" value=\"buy\"></input>";  	
  	
  $query="select name, power, price from weapons where race='".$myrace."' and type=0 order by power";
  $db_theend->query($query);
  $no_queries+=1;

  while($db_theend->next_record() && $dflevel)
  {
  $afisat=1;
  $dflevel--;
  
  echo "<tr>";
  echo "<td class=\"arm7\">".$db_theend->Record["name"]."</td>";
  echo "<td class=\"arm8\">";
  echo "<font color=\"#F0F0F0\">".number_format($db_theend->Record["power"])."</font> ";
  if($site_language=="en")
    echo "defense power";
  else
    echo "putere de aparare";
  echo "</td>";
  echo "<td class=\"arm9\">".number_format($db_theend->Record["price"])." ";
  if($site_language=="en")
    echo "EKR";
  else
    echo "EKR";
  echo "</td>";
  echo "<td class=\"arm10\">";
  if($site_language=="en")
    echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">Quantity:</font>";
  else
    echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">Cantitate:</font>";
  echo "&nbsp;&nbsp;&nbsp;<input class=\"input4\" type=\"text\" size=\"5\" name=\"".str_replace(" ","",$db_theend->Record["name"])."\" value=\"0\"></input>&nbsp;&nbsp;&nbsp;</td>";
  
  echo "</tr>";
  }  
  
  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "No weapons availlable";
    else
      echo "Nu sunt arme disponibile";
    echo "</td></tr>";  
  }
  else
  {
    echo "<tr><td class=\"arm11\" colspan=\"4\">";
    if($site_language=="en")
      echo "<input id=\"form_buy_weapons_submit_button\" class=\"submit4\" type=\"button\" value=\"Buy\" onClick=\"document.getElementById('form_buy_weapons_submit_button').disabled = true; form_buy_weapons.submit();\"></input>";
    else
      echo "<input id=\"form_buy_weapons_submit_button\" class=\"submit4\" type=\"button\" value=\"Cumpara\" onClick=\"document.getElementById('form_buy_weapons_submit_button').disabled = true; form_buy_weapons.submit();\"></input>";
    echo "</td></tr>";
  }
  echo "</form>";
  echo "</table>";
  echo "</div>";  	
  }
  
  if($_POST["what"]=="spy")
  {

  echo "<div class=\"section\">";

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  echo "<form name=\"form_buy_weapons\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"armory\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
  echo "<input type=\"hidden\" name=\"act\" value=\"buy\"></input>";  	
  	
  $query="select name, power, price from weapons where race='".$myrace."' and type=3 order by power";
  $db_theend->query($query);
  $no_queries+=1;

  while($db_theend->next_record() && $spylevel)
  {
  $afisat=1;
  $spylevel--;
  echo "<tr>";
  echo "<td class=\"arm7\">".$db_theend->Record["name"]."</td>";
  echo "<td class=\"arm8\">";
  echo "<font color=\"#F0F0F0\">".number_format($db_theend->Record["power"])."</font> ";
  if($site_language=="en")
    echo "spy power";
  else
    echo "putere de spionaj";
  echo "</td>";
  echo "<td class=\"arm9\">".number_format($db_theend->Record["price"])." ";
  if($site_language=="en")
    echo "EKR";
  else
    echo "EKR";
  echo "</td>";
  echo "<td class=\"arm10\">";
  if($site_language=="en")
    echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">Quantity:</font>";
  else
    echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">Cantitate:</font>";
  echo "&nbsp;&nbsp;&nbsp;<input class=\"input4\" type=\"text\" size=\"5\" name=\"".str_replace(" ","",$db_theend->Record["name"])."\" value=\"0\"></input>&nbsp;&nbsp;&nbsp;</td>";
  echo "</tr>";
  }  
  
  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "No weapons availlable";
    else
      echo "Nu sunt arme disponibile";
    echo "</td></tr>";  
  }
  else
  {
    echo "<tr><td class=\"arm11\" colspan=\"4\">";
  	if($site_language=="en")
      echo "<input id=\"form_buy_weapons_submit_button\" class=\"submit4\" type=\"button\" value=\"Buy\" onClick=\"document.getElementById('form_buy_weapons_submit_button').disabled = true; form_buy_weapons.submit();\"></input>";
    else
      echo "<input id=\"form_buy_weapons_submit_button\" class=\"submit4\" type=\"button\" value=\"Cumpara\" onClick=\"document.getElementById('form_buy_weapons_submit_button').disabled = true; form_buy_weapons.submit();\"></input>";
    echo "</td></tr>";  
  }
  
  echo "</form>";
  echo "</table>";
  echo "</div>";  
  }  
  
  if($_POST["what"]=="sentry")
  {

  echo "<div class=\"section\">";

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  echo "<form name=\"form_buy_weapons\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"armory\"></input>";
  echo "<input type=\"hidden\" name=\"what\" value=\"".$_POST["what"]."\"></input>";
  echo "<input type=\"hidden\" name=\"act\" value=\"buy\"></input>";  	
  	
  $query="select name, power, price from weapons where race='".$myrace."' and type=4 order by power";
  $db_theend->query($query);
  $no_queries+=1;

  while($db_theend->next_record() && $antispylevel)
  {
  $afisat=1;
  $antispylevel--;
  echo "<tr>";

  echo "<td class=\"arm7\">".$db_theend->Record["name"]."</td>";
  echo "<td class=\"arm8\">";
  echo "<font color=\"#F0F0F0\">".number_format($db_theend->Record["power"])."</font> ";
  if($site_language=="en")
    echo "sentry power";
  else
    echo "putere de contra-spionaj";
  echo "</td>";
  echo "<td class=\"arm9\">".number_format($db_theend->Record["price"])." ";
  if($site_language=="en")
    echo "EKR";
  else
    echo "EKR";
  echo "</font></td>";
  echo "<td class=\"arm10\">";
  if($site_language=="en")
    echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">Quantity:</font>";
  else
    echo "<font color=\"#A0A0A0\" style=\"font-size: 7pt;\">Cantitate:</font>";
  echo "&nbsp;&nbsp;&nbsp;<input class=\"input4\" type=\"text\" size=\"5\" name=\"".str_replace(" ","",$db_theend->Record["name"])."\" value=\"0\"></input>&nbsp;&nbsp;&nbsp;</td>";
  echo "</tr>";
  }  
  
  if(!$afisat)
  {
    echo "<tr><td class=\"arm11\">";
  	if($site_language=="en")
      echo "No weapons availlable";
    else
      echo "Nu sunt arme disponibile";
    echo "</td></tr>";  
  }
  else
  {
    echo "<tr><td class=\"arm11\" colspan=\"4\">";
  	if($site_language=="en")
      echo "<input id=\"form_buy_weapons_submit_button\" class=\"submit4\" type=\"button\" value=\"Buy\" onClick=\"document.getElementById('form_buy_weapons_submit_button').disabled = true; form_buy_weapons.submit();\"></input>";
    else
      echo "<input id=\"form_buy_weapons_submit_button\" class=\"submit4\" type=\"button\" value=\"Cumpara\" onClick=\"document.getElementById('form_buy_weapons_submit_button').disabled = true; form_buy_weapons.submit();\"></input>";
    echo "</td></tr>";  
  }
  echo "</form>";
  echo "</table>";
  echo "</div>";  
  }  

}

function buy_armory()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db2 = new DataBase_theend;
  $db2->connect();

  $userrace=userrace($_COOKIE["uid"]);

  $query="select name, price from weapons where race='".$userrace."' order by price desc";
  $db_theend->query($query);
  $cost=0;
  while($db_theend->next_record())
  {
      if(round($_POST[str_replace(" ","",$db_theend->Record["name"])])>0)
        $cost=$cost+round($_POST[str_replace(" ","",$db_theend->Record["name"])])*$db_theend->Record["price"];
  }

  $query="select gold from armory where id=".$_COOKIE["uid"];
  $db_theend->query($query);
  $db_theend->next_record();
  $gold=$db_theend->Record["gold"];
  $id=$_COOKIE["uid"];

  if($cost>$gold)
     return -1; // Not enogh gold!
  else
  {
     $id=$_COOKIE["uid"];
     $query="select id, name, power from weapons where race='".$userrace."'";
     $db_theend->query($query);
     while($db_theend->next_record())
     {
         if(round($_POST[str_replace(" ","",$db_theend->Record["name"])])>0)
         {
             $query2="select user_weapons.id, user_weapons.w1, user_weapons.now1, user_weapons.procw1, weapons.power from user_weapons, weapons where user_weapons.w1=weapons.id and weapons.name='".$db_theend->Record["name"]."' and user_weapons.id=".$id;
             $db2->query($query2);
             if($db2->num_rows())
             {
                 $db2->next_record();
                 $now1=$db2->Record["now1"]+round($_POST[str_replace(" ","",$db_theend->Record["name"])]);
                 $procw1=$db2->Record["procw1"]+round($_POST[str_replace(" ","",$db_theend->Record["name"])])*$db2->Record["power"];
                 $query3="update user_weapons set now1=".$now1.", procw1=".$procw1." where id=".$id." and w1=".$db2->Record["w1"];
                 $db2->query($query3);
             }
             else
             {
                 $query3="insert into user_weapons values (".$id.",".$db_theend->Record["id"].",".round($_POST[str_replace(" ","",$db_theend->Record["name"])]).",".(round($_POST[str_replace(" ","",$db_theend->Record["name"])])*$db_theend->Record["power"]).")";
                 $db2->query($query3);
             }
         }
     }
     $query="update armory set gold=".($gold-$cost)." where id=".$id;
     $db_theend->query($query);

     return 1;
  }
}

function repair_armory()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  semafor_on($_COOKIE["uid"]);

  $query="select user_weapons.procw1, weapons.price, weapons.power, user_weapons.id, user_weapons.now1 from user_weapons, weapons where user_weapons.id=".$_COOKIE["uid"]." and user_weapons.w1=weapons.id and weapons.id=".$_POST["weapon"];
  $db_theend->query($query);
  if($db_theend->num_rows()) $db_theend->next_record();

  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_repair=$ppt*50/100;

  $proc=round($_POST["proc"]);

  if($proc>0)
  {

  if($proc>($db_theend->Record["now1"]*$db_theend->Record["power"])-$db_theend->Record["procw1"])
    $proc=($db_theend->Record["now1"]*$db_theend->Record["power"])-$db_theend->Record["procw1"];
  $cost=$proc*$ppt_repair;
  $id=$db_theend->Record["id"];

  $query="select armory.gold from armory, users where users.username='".$_COOKIE["user"]."' and users.id=armory.id";
  $db_theend->query($query);
  if($db_theend->num_rows()) $db_theend->next_record();
  $gold=$db_theend->Record["gold"];
  if($cost>$db_theend->Record["gold"])
  {
     semafor_off($_COOKIE["uid"]);
     return -1; //Not enough gold!
  }
  else
  {
     $query="update user_weapons set procw1=procw1+".$proc." where w1=".$_POST["weapon"]." and id=".$id;
     $db_theend->query($query);
     $query="update armory set gold=".($gold-$cost)." where id=".$id;
     $db_theend->query($query);
     semafor_off($_COOKIE["uid"]);
     return 1;
  }

  }
}

function sell_armory()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  semafor_on($_COOKIE["uid"]);

  $query="select id, name from weapons";
  $db_theend->query($query);
  while($db_theend->next_record())
  {
    if(round($_POST[str_replace(" ","",$db_theend->Record["name"])])>0)
    {
      $w1=$db_theend->Record["id"];
      $nosell=round($_POST[str_replace(" ","",$db_theend->Record["name"])]);
      break;
    }
  }

  if($nosell>0)
  {

  $query="select weapons.power, weapons.price, user_weapons.now1, user_weapons.procw1, user_weapons.id from user_weapons, users, weapons where users.username='".$_COOKIE["user"]."' and users.id=user_weapons.id and user_weapons.w1=".$w1." and user_weapons.w1=weapons.id";
  $db_theend->query($query);
  $db_theend->next_record();
  $id=$db_theend->Record["id"];
  $now1=$db_theend->Record["now1"];
  $procw1=$db_theend->Record["procw1"];

  $power=$db_theend->Record["power"];
  $proc=$db_theend->Record["procw1"];
  $nr=$db_theend->Record["now1"];
  $price=$db_theend->Record["price"];
  $wproc=$proc/$nr;
  $ppt=$price/$power;
  $ppt_sell=$ppt*80/100;

    if($now1>=$nosell)
  {
    $now1=$now1-$nosell;
    if($now1>0)
    {
      $query="update user_weapons set now1=".$now1.", procw1=".round($proc-$nosell*$wproc)." where id=".$id. " and w1=".$w1;
      $db_theend->query($query);
      $query="update armory set gold=gold+".round($nosell*$wproc*$ppt_sell)." where id=".$id;
      $db_theend->query($query);
    }
    else
    {
      $query="delete from user_weapons where id=".$id. " and w1=".$w1;
      $db_theend->query($query);
      $query="update armory set gold=gold+".round($nosell*$wproc*$ppt_sell)." where id=".$id;
      $db_theend->query($query);
    }
  }
  }
  semafor_off($_COOKIE["uid"]);
}
?>
