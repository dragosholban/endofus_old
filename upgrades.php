<?php

function upgrades()
{

  $site_language=site_language();
	
  $attack_price=25000;
  $defense_price=25000;
  $spy_price=50000;
  $sentry_price=50000;
  $elite_price=25000;
  $workers_price=50000;
  $weapons_price=25000;
  $population_price=100000;
  
  $attack_time=1;
  $defense_time=1;
  $spy_time=2;
  $sentry_time=2;
  $elite_time=1;
  $workers_time=2;
  $weapons_time=1;
  $population_time=4;  

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $id=$_COOKIE["uid"];

  $query="select attack, defense, spy, antispy, worker, wprec, population, elite, attack_time, defense_time, spy_time, antispy_time, worker_time, wprec_time, population_time, elite_time from upgrades where id=".$_COOKIE["uid"];
  $db_theend->query($query);
  $no_queries+=1;
  $db_theend->next_record();

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
  
  echo "<div class=\"upgrade_level\">";
  if($site_language=="en")
    echo "Current level: ".$db_theend->Record["attack"];
  else 
    echo "Nivel curent: ".$db_theend->Record["attack"];
  echo "</div>";
  
  echo "<div class=\"upgrades\">";
  
  echo "<font color=\"#FFA500\" style=\"font-size: 10px;\"><b>";
  if($site_language=="en")
    echo "Attack Level";
  else
    echo "Nivel atac";
  echo "</font></b>";
  
  echo "<br /><br />";
  
  if($site_language=="en")
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Attack levels will increase your attack power with 10% and will make availlable a new attack weapon.</font>";
  else 
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Nivelele de atac iti vor mari puterea de atac cu 10% si iti vor da o noua arma.</font>";    
  
  echo "<br /><br />";
  
  if($db_theend->Record["attack"]<10 && $db_theend->Record["attack_time"]==0)
  {
    if(date("i")>=0 && date("i")<5)
      $alltime=(5-date("i"))+(pow(2,$db_theend->Record["attack"])*20*$attack_time);
  	if(date("i")>=5 && date("i")<25)
      $alltime=(25-date("i"))+(pow(2,$db_theend->Record["attack"])*20*$attack_time);
    if(date("i")>=25 && date("i")<45)
      $alltime=(45-date("i"))+(pow(2,$db_theend->Record["attack"])*20*$attack_time);
    if(date("i")>=45 && date("i")<60)
      $alltime=(60+5-date("i"))+(pow(2,$db_theend->Record["attack"])*20*$attack_time);
    $allhours=floor($alltime/60);    
    $allmins=$alltime%60; 
      
    echo "<div style=\"float: right; margin-right: 10px;\">";
  	echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"upgrade\"></input>";
    echo "<input type=\"hidden\" name=\"atlevel\" value=\"".($db_theend->Record["attack"]+1)."\"></input>";
    echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
    echo "</form>";
    echo "</div>";
    
    if($site_language=="en")
      echo "Upgrade to level ".($db_theend->Record["attack"]+1)." costs ".number_format((pow(4,$db_theend->Record["attack"])*$attack_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Upgrade estimated duration: ".$allhours." hour(s), ".$allmins." minute(s).</font>";
    else 
      echo "Nivelul ".($db_theend->Record["attack"]+1)." costa ".number_format((pow(4,$db_theend->Record["attack"])*$attack_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Durata estimata a trecerii la noul nivel: ".$allhours." ore, ".$allmins." minute.</font>";  
  }
  
  if($db_theend->Record["attack_time"]>0)
  {
    if(date("i")>=0 && date("i")<5)
      $timeleft=(5-date("i"))+(($db_theend->Record["attack_time"]-1)*20);
  	if(date("i")>=5 && date("i")<25)
      $timeleft=(25-date("i"))+(($db_theend->Record["attack_time"]-1)*20);
    if(date("i")>=25 && date("i")<45)
      $timeleft=(45-date("i"))+(($db_theend->Record["attack_time"]-1)*20);
    if(date("i")>=45 && date("i")<60)
      $timeleft=(60+5-date("i"))+(($db_theend->Record["attack_time"]-1)*20);
    $hoursleft=floor($timeleft/60);    
    $minsleft=$timeleft%60;    
    if($site_language=="en")      
  	  echo "Upgrading to level ".($db_theend->Record["attack"]+1)."... estimated time left: ".$hoursleft." hour(s), ".$minsleft." minute(s).<br><br>";
  	else 
  	  echo "Se face trecerea la nivelul ".($db_theend->Record["attack"]+1)."... timp ramas: ".$hoursleft." ore, ".$minsleft." minute.<br><br>";  
    $proc=100-round(($timeleft*100)/((pow(2,$db_theend->Record["attack"])*$attack_time+1)*20));
    if($proc==0) $proc=1;
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\" width=\"100%\"><tr><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr><td background=\"pics/greenbar.gif\" width=\"".$proc."%\" height=\"8\"></td><td height=\"8\" width=\"".(100-$proc)."%\"></td></table></td></table>";
  }  

  echo "</div>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  echo "<br />";

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "DEFENSE";
  else 
    echo "APARARE";  
  echo "</div>";

  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"upgrade_level\">";
  if($site_language=="en")
    echo "Current level: ".$db_theend->Record["defense"];
  else 
    echo "Nivel curent: ".$db_theend->Record["defense"];  
  echo "</div>";  
  
  echo "<div class=\"upgrades\">";

  echo "<font color=\"#FFA500\" style=\"font-size: 10px;\"><b>";
  if($site_language=="en")
    echo "Defense Level";
  else
    echo "Nivel aparare";
  echo "</b></font>";
  
  echo "<br /><br />";  
  
  if($site_language=="en")
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Defense levels will increase your defense power with 10% and will make availlable a new defense weapon.</font>";
  else 
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Nivelele de aparare iti vor mari puterea de aparare cu 10% si iti vor da o noua arma.</font>";  

  echo "<br /><br />";  
  
  if($db_theend->Record["defense"]<10 && $db_theend->Record["defense_time"]==0)
  {
    if(date("i")>=0 && date("i")<5)
      $alltime=(5-date("i"))+(pow(2,$db_theend->Record["defense"])*20*$defense_time);
  	if(date("i")>=5 && date("i")<25)
      $alltime=(25-date("i"))+(pow(2,$db_theend->Record["defense"])*20*$defense_time);
    if(date("i")>=25 && date("i")<45)
      $alltime=(45-date("i"))+(pow(2,$db_theend->Record["defense"])*20*$defense_time);
    if(date("i")>=45 && date("i")<60)
      $alltime=(60+5-date("i"))+(pow(2,$db_theend->Record["defense"])*20*$defense_time);
    $allhours=floor($alltime/60);    
    $allmins=$alltime%60; 
      
    echo "<div style=\"float: right; margin-right: 10px;\">";
  	echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"upgrade\"></input>";
    echo "<input type=\"hidden\" name=\"dflevel\" value=\"".($db_theend->Record["defense"]+1)."\"></input>";
    echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
    echo "</form>";
    echo "</div>";
    
    if($site_language=="en")
      echo "Upgrade to level ".($db_theend->Record["defense"]+1)." costs ".number_format((pow(4,$db_theend->Record["defense"])*$defense_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Upgrade estimated duration: ".$allhours." hour(s), ".$allmins." minute(s).</font>";
    else 
      echo "Nivelul ".($db_theend->Record["defense"]+1)." costa ".number_format((pow(4,$db_theend->Record["defense"])*$defense_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Duarata estimata a trecerii la noul nivel: ".$allhours." ore, ".$allmins." minute.</font>";  
  }
  
  if($db_theend->Record["defense_time"]>0)
  {
    if(date("i")>=0 && date("i")<5)
      $timeleft=(5-date("i"))+(($db_theend->Record["defense_time"]-1)*20);
  	if(date("i")>=5 && date("i")<25)
      $timeleft=(25-date("i"))+(($db_theend->Record["defense_time"]-1)*20);
    if(date("i")>=25 && date("i")<45)
      $timeleft=(45-date("i"))+(($db_theend->Record["defense_time"]-1)*20);
    if(date("i")>=45 && date("i")<60)
      $timeleft=(60+5-date("i"))+(($db_theend->Record["defense_time"]-1)*20);
    $hoursleft=floor($timeleft/60);    
    $minsleft=$timeleft%60;     
    if($site_language=="en")      
  	  echo "Upgrading to level ".($db_theend->Record["defense"]+1)."... estimated time left: ".$hoursleft." hour(s), ".$minsleft." minute(s).<br><br>";
  	else 
  	  echo "Se face trecerea la nivelul ".($db_theend->Record["defense"]+1)."... timp ramas: ".$hoursleft." ore, ".$minsleft." minute.<br><br>";  
    $proc=100-round(($timeleft*100)/((pow(2,$db_theend->Record["defense"])*$defense_time+1)*20));
    if($proc==0) $proc=1;
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\" width=\"100%\"><tr><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr><td background=\"pics/greenbar.gif\" width=\"".$proc."%\" height=\"8\"></td><td height=\"8\" width=\"".(100-$proc)."%\"></td></table></td></table>";
  }  

  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";

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
  
  echo "<div class=\"upgrade_level\">";
  if($site_language=="en")
    echo "Current level: ".$db_theend->Record["spy"];
  else 
    echo "Nivel curent: ".$db_theend->Record["spy"];  
  echo "</div>";  

  echo "<div class=\"upgrades\">";
  
  echo "<font color=\"#FFA500\" style=\"font-size: 10px;\"><b>";
  if($site_language=="en")
    echo "Spy Level";
  else
    echo "Nivel spionaj";
  echo "</b></font>";
  
  echo "<br /><br />";   
  
  if($site_language=="en")
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Spy levels will increase your spy power with 10% and will make availlable a new spy weapon.</font>";
  else 
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Nivelele de spionaj iti vor mari puterea de spionaj cu 10% si iti vor da o noua arma.</font>";  

  echo "<br /><br />";   
  
  if($db_theend->Record["spy"]<10 && $db_theend->Record["spy_time"]==0)
  {
    if(date("i")>=0 && date("i")<5)
      $alltime=(5-date("i"))+(pow(2,$db_theend->Record["spy"])*20*$spy_time);
  	if(date("i")>=5 && date("i")<25)
      $alltime=(25-date("i"))+(pow(2,$db_theend->Record["spy"])*20*$spy_time);
    if(date("i")>=25 && date("i")<45)
      $alltime=(45-date("i"))+(pow(2,$db_theend->Record["spy"])*20*$spy_time);
    if(date("i")>=45 && date("i")<60)
      $alltime=(60+5-date("i"))+(pow(2,$db_theend->Record["spy"])*20*$spy_time);
    $allhours=floor($alltime/60);    
    $allmins=$alltime%60; 
      
    echo "<div style=\"float: right; margin-right: 10px;\">";
  	echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"upgrade\"></input>";
    echo "<input type=\"hidden\" name=\"spy\" value=\"".($db_theend->Record["spy"]+1)."\"></input>";
    echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
    echo "</form>";
    echo "</div>";
    
    if($site_language=="en")
      echo "Upgrade to level ".($db_theend->Record["spy"]+1)." costs ".number_format((pow(4,$db_theend->Record["spy"])*$spy_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Upgrade estimated duration: ".$allhours." hour(s), ".$allmins." minute(s).</font>";
    else 
      echo "Nivelul ".($db_theend->Record["spy"]+1)." costa ".number_format((pow(4,$db_theend->Record["spy"])*$spy_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Durata estimata a trecerii la noul nivel: ".$allhours." ore, ".$allmins." minute.</font>";  
  }
  
  if($db_theend->Record["spy_time"]>0)
  {
    if(date("i")>=0 && date("i")<5)
      $timeleft=(5-date("i"))+(($db_theend->Record["spy_time"]-1)*20);
  	if(date("i")>=5 && date("i")<25)
      $timeleft=(25-date("i"))+(($db_theend->Record["spy_time"]-1)*20);
    if(date("i")>=25 && date("i")<45)
      $timeleft=(45-date("i"))+(($db_theend->Record["spy_time"]-1)*20);
    if(date("i")>=45 && date("i")<60)
      $timeleft=(60+5-date("i"))+(($db_theend->Record["spy_time"]-1)*20);
    $hoursleft=floor($timeleft/60);    
    $minsleft=$timeleft%60;  
    if($site_language=="en")        
  	  echo "Upgrading to level ".($db_theend->Record["spy"]+1)."... estimated time left: ".$hoursleft." hour(s), ".$minsleft." minute(s).<br><br>";
  	else 
  	  echo "Se face trecerea la nivelul ".($db_theend->Record["spy"]+1)."... timp ramas: ".$hoursleft." ore, ".$minsleft." minute.<br><br>";  
    $proc=100-round(($timeleft*100)/((pow(2,$db_theend->Record["spy"])*$spy_time+1)*20));
    if($proc==0) $proc=1;
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\" width=\"100%\"><tr><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr><td background=\"pics/greenbar.gif\" width=\"".$proc."%\" height=\"8\"></td><td height=\"8\" width=\"".(100-$proc)."%\"></td></table></td></table>";
  }  

  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  echo "<br />";
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "SENTRY";
  else 
    echo "CONTRA-SPIONAJ";  
  echo "</div>";
  
  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"upgrade_level\">";
  if($site_language=="en")
    echo "Current level: ".$db_theend->Record["antispy"];
  else 
    echo "Nivel curent: ".$db_theend->Record["antispy"];  
  echo "</div>";  

  echo "<div class=\"upgrades\">";  

  echo "<font color=\"#FFA500\" style=\"font-size: 10px;\"><b>";
  if($site_language=="en")
    echo "Sentry Level";
  else
    echo "Nivel contra-spionaj";
  echo "</b></font>";
  
  echo "<br /><br />";  

  if($site_language=="en")
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Sentry levels will increase your sentry power with 10% and will make availlable a new sentry weapon.</font>";
  else 
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Nivelele de contra-spionaj iti vor mari puterea de contra-spionaj cu 10% si iti vor da o noua arma.</font>";  

  echo "<br /><br />";  
  
  if($db_theend->Record["antispy"]<10 && $db_theend->Record["antispy_time"]==0)
  {
    if(date("i")>=0 && date("i")<5)
      $alltime=(5-date("i"))+(pow(2,$db_theend->Record["antispy"])*20*$sentry_time);
  	if(date("i")>=5 && date("i")<25)
      $alltime=(25-date("i"))+(pow(2,$db_theend->Record["antispy"])*20*$sentry_time);
    if(date("i")>=25 && date("i")<45)
      $alltime=(45-date("i"))+(pow(2,$db_theend->Record["antispy"])*20*$sentry_time);
    if(date("i")>=45 && date("i")<60)
      $alltime=(60+5-date("i"))+(pow(2,$db_theend->Record["antispy"])*20*$sentry_time);
    $allhours=floor($alltime/60);    
    $allmins=$alltime%60; 
      
    echo "<div style=\"float: right; margin-right: 10px;\">";
  	echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"upgrade\"></input>";
    echo "<input type=\"hidden\" name=\"sentry\" value=\"".($db_theend->Record["antispy"]+1)."\"></input>";
    echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
    echo "</form>";
    echo "</div>";
    
  	if($site_language=="en")
      echo "Upgrade to level ".($db_theend->Record["antispy"]+1)." costs ".number_format((pow(4,$db_theend->Record["antispy"])*$sentry_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Upgrade estimated duration: ".$allhours." hour(s), ".$allmins." minute(s).</font>";    
    else 
      echo "Nivelul ".($db_theend->Record["antispy"]+1)." costa ".number_format((pow(4,$db_theend->Record["antispy"])*$sentry_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Durata estimata a trecerii la noul nivel: ".$allhours." ore, ".$allmins." minute.</font>";      
  }
  
  if($db_theend->Record["antispy_time"]>0)
  {
    if(date("i")>=0 && date("i")<5)
      $timeleft=(5-date("i"))+(($db_theend->Record["antispy_time"]-1)*20);
  	if(date("i")>=5 && date("i")<25)
      $timeleft=(25-date("i"))+(($db_theend->Record["antispy_time"]-1)*20);
    if(date("i")>=25 && date("i")<45)
      $timeleft=(45-date("i"))+(($db_theend->Record["antispy_time"]-1)*20);
    if(date("i")>=45 && date("i")<60)
      $timeleft=(60+5-date("i"))+(($db_theend->Record["antispy_time"]-1)*20);
    $hoursleft=floor($timeleft/60);    
    $minsleft=$timeleft%60;   
    if($site_language=="en")       
  	  echo "Upgrading to level ".($db_theend->Record["antispy"]+1)."... estimated time left: ".$hoursleft." hour(s), ".$minsleft." minute(s).<br><br>";
  	else 
  	  echo "Se face trecerea la nivelul ".($db_theend->Record["antispy"]+1)."... timp ramas: ".$hoursleft." ore, ".$minsleft." minute.<br><br>";  
    $proc=100-round(($timeleft*100)/((pow(2,$db_theend->Record["antispy"])*$sentry_time+1)*20));
  if($proc==0) $proc=1;
  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\" width=\"100%\"><tr><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr><td background=\"pics/greenbar.gif\" width=\"".$proc."%\" height=\"8\"></td><td height=\"8\" width=\"".(100-$proc)."%\"></td></table></td></table>";
  } 

  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";

  echo "<br />";
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "ELITE UNITS";
  else 
    echo "UNITATI DE ELITA";  
  echo "</div>";
  
  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"upgrade_level\">";
  if($site_language=="en")
    echo "Current level: ".$db_theend->Record["elite"]."<br /><font color=\"#909090\" style=\"font-size: 7pt;\">(you can train ".$db_theend->Record["elite"]."0% of tour total comabat units<br />into elite units)</font>";
  else 
    echo "Nivel curent: ".$db_theend->Record["elite"]."<br /><font color=\"#909090\" style=\"font-size: 7pt;\">(poti antrena ".$db_theend->Record["elite"]."0% din totalul de unitati<br />de lupta in unitati de elita)</font>";
  echo "</div>";  
  
  echo "<div class=\"upgrades\">";

  echo "<font color=\"#FFA500\" style=\"font-size: 10px;\"><b>";
  if($site_language=="en")
    echo "Elite Units Level";
  else
    echo "Nivel unitati de elita";
  echo "</b></font>";
  
  echo "<br /><br />";

  if($site_language=="en")
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Elite units levels will increase your max. number of elite units wich you can train from combat units with 10%.</font>";
  else 
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Nivelele unitatilor de elita vor mari numarul unitatilor de elita ce pot fi antrenate din totalul unitatilor de lupta cu 10%.</font>";

  echo "<br /><br />";
  
  if($db_theend->Record["elite"]<10 && $db_theend->Record["elite_time"]==0)
  {
    if(date("i")>=0 && date("i")<5)
      $alltime=(5-date("i"))+(pow(2,$db_theend->Record["elite"])*20*$elite_time);
  	if(date("i")>=5 && date("i")<25)
      $alltime=(25-date("i"))+(pow(2,$db_theend->Record["elite"])*20*$elite_time);
    if(date("i")>=25 && date("i")<45)
      $alltime=(45-date("i"))+(pow(2,$db_theend->Record["elite"])*20*$elite_time);
    if(date("i")>=45 && date("i")<60)
      $alltime=(60+5-date("i"))+(pow(2,$db_theend->Record["elite"])*20*$elite_time);
    $allhours=floor($alltime/60);    
    $allmins=$alltime%60; 

    echo "<div style=\"float: right; margin-right: 10px;\">";
  	echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"upgrade\"></input>";
    echo "<input type=\"hidden\" name=\"elite\" value=\"".($db_theend->Record["elite"]+1)."\"></input>";
    echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
    echo "</form>";
    echo "</div>";    
    
  	if($site_language=="en")
      echo "Upgrade to level ".($db_theend->Record["elite"]+1)." costs ".number_format((pow(4,$db_theend->Record["elite"])*$elite_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Upgrade estimated duration: ".$allhours." hour(s), ".$allmins." minute(s).</font>";
    else 
      echo "Nivelul ".($db_theend->Record["elite"]+1)." costa ".number_format((pow(4,$db_theend->Record["elite"])*$elite_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Durata estimata a trecerii la noul nivel: ".$allhours." ore, ".$allmins." minute.</font>";
  }
  
  if($db_theend->Record["elite_time"]>0)
  {
    if(date("i")>=0 && date("i")<5)
      $timeleft=(5-date("i"))+(($db_theend->Record["elite_time"]-1)*20);
  	if(date("i")>=5 && date("i")<25)
      $timeleft=(25-date("i"))+(($db_theend->Record["elite_time"]-1)*20);
    if(date("i")>=25 && date("i")<45)
      $timeleft=(45-date("i"))+(($db_theend->Record["elite_time"]-1)*20);
    if(date("i")>=45 && date("i")<60)
      $timeleft=(60+5-date("i"))+(($db_theend->Record["elite_time"]-1)*20);
    $hoursleft=floor($timeleft/60);    
    $minsleft=$timeleft%60;    
    if($site_language=="en")      
  	  echo "Upgrading to level ".($db_theend->Record["elite"]+1)."... estimated time left: ".$hoursleft." hour(s), ".$minsleft." minute(s).<br><br>";
  	else 
  	  echo "Se face trecerea la nivelul ".($db_theend->Record["elite"]+1)."... timp ramas: ".$hoursleft." ore, ".$minsleft." minute.<br><br>";  
    $proc=100-round(($timeleft*100)/((pow(2,$db_theend->Record["elite"])*$elite_time+1)*20));
    if($proc==0) $proc=1;  	
    echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\" width=\"100%\"><tr><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr><td background=\"pics/greenbar.gif\" width=\"".$proc."%\" height=\"8\"></td><td height=\"8\" width=\"".(100-$proc)."%\"></td></table></td></table>";
  } 
    
  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";


  echo "<br />";

  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "INCOME";
  else 
    echo "VENIT";
  echo "</div>";
  
  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"upgrade_level\">";
  if($site_language=="en")
    echo "Current level: ".$db_theend->Record["worker"]."<br /><font color=\"#909090\" style=\"font-size: 7pt;\">(every worker/slave will produce ".(10+$db_theend->Record["worker"])." EKR per turn)</font>";
  else  
    echo "Nivel curent: ".$db_theend->Record["worker"]."<br /><font color=\"#909090\" style=\"font-size: 7pt;\">(fiecare muncitor/sclav va produce ".(10+$db_theend->Record["worker"])." EKR pe tur)</font>";  
  echo "</div>";  
  
  echo "<div class=\"upgrades\">";

  echo "<font color=\"#FFA500\" style=\"font-size: 10px;\"><b>";
  if($site_language=="en")
    echo "Income Level";
  else
    echo "Nivel venit";
  echo "</b></font>";
  
  echo "<br /><br />";

  if($site_language=="en")
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Income levels will increase your workers'/slaves' production by 1 EKR per turn.</font>";
  else 
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Nivelele veniturilor vor mari capacitatea de productie a unui muncitor/sclav cu 1 EKR pe tur.</font>";

  echo "<br /><br />";  
  
  if($db_theend->Record["worker"]<10 && $db_theend->Record["worker_time"]==0)
  {
    if(date("i")>=0 && date("i")<5)
      $alltime=(5-date("i"))+(pow(2,$db_theend->Record["worker"])*20*$workers_time);
  	if(date("i")>=5 && date("i")<25)
      $alltime=(25-date("i"))+(pow(2,$db_theend->Record["worker"])*20*$workers_time);
    if(date("i")>=25 && date("i")<45)
      $alltime=(45-date("i"))+(pow(2,$db_theend->Record["worker"])*20*$workers_time);
    if(date("i")>=45 && date("i")<60)
      $alltime=(60+5-date("i"))+(pow(2,$db_theend->Record["worker"])*20*$workers_time);
    $allhours=floor($alltime/60);    
    $allmins=$alltime%60; 

    echo "<div style=\"float: right; margin-right: 10px;\">";
  	echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"upgrade\"></input>";
    echo "<input type=\"hidden\" name=\"worker\" value=\"".($db_theend->Record["worker"]+1)."\"></input>";
    echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
    echo "</form>";
    echo "</div>";
    
    if($site_language=="en")
      echo "Upgrade to level ".($db_theend->Record["worker"]+1)." costs ".number_format((pow(4,$db_theend->Record["worker"])*$workers_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Upgrade estimated duration: ".$allhours." hour(s), ".$allmins." minute(s).</font>";
    else 
        echo "Nivelul ".($db_theend->Record["worker"]+1)." costa ".number_format((pow(4,$db_theend->Record["worker"])*$workers_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Durata estimata a trecerii la noul nivel: ".$allhours." ore, ".$allmins." minute.</font>";      
  }
  
  if($db_theend->Record["worker_time"]>0)
  {
    if(date("i")>=0 && date("i")<5)
      $timeleft=(5-date("i"))+(($db_theend->Record["worker_time"]-1)*20);
  	if(date("i")>=5 && date("i")<25)
      $timeleft=(25-date("i"))+(($db_theend->Record["worker_time"]-1)*20);
    if(date("i")>=25 && date("i")<45)
      $timeleft=(45-date("i"))+(($db_theend->Record["worker_time"]-1)*20);
    if(date("i")>=45 && date("i")<60)
      $timeleft=(60+5-date("i"))+(($db_theend->Record["worker_time"]-1)*20);
    $hoursleft=floor($timeleft/60);    
    $minsleft=$timeleft%60;     
    if($site_language=="en")     
  	  echo "Upgrading to level ".($db_theend->Record["worker"]+1)."... estimated time left: ".$hoursleft." hour(s), ".$minsleft." minute(s).<br><br>";
  	else 
  	  echo "Se face trecerea la nivelul ".($db_theend->Record["worker"]+1)."... timp: ".$hoursleft." ore, ".$minsleft." minute.<br><br>";  
    $proc=100-round(($timeleft*100)/((pow(2,$db_theend->Record["worker"])*$workers_time+1)*20));
  if($proc==0) $proc=1;  	
  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\" width=\"100%\"><tr><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr><td background=\"pics/greenbar.gif\" width=\"".$proc."%\" height=\"8\"></td><td height=\"8\" width=\"".(100-$proc)."%\"></td></table></td></table>";
  } 

  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";

  echo "<br />";
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "WEAPON'S PRECISION";
  else 
    echo "PRECIZIE ARME";  
  echo "</div>";  
  
  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
  
  echo "<div class=\"upgrade_level\">";
  if($site_language=="en")
    echo "Current level: ".$db_theend->Record["wprec"]."<br /><font color=\"#909090\" style=\"font-size: 7pt;\">(".(60+4*$db_theend->Record["wprec"])."% precision)</font>";
  else 
    echo "Nivel curent: ".$db_theend->Record["wprec"]."<br /><font color=\"#909090\" style=\"font-size: 7pt;\">(".(60+4*$db_theend->Record["wprec"])."% precizie)</font>";
  echo "</div>";  
  
  echo "<div class=\"upgrades\">";

  echo "<font color=\"#FFA500\" style=\"font-size: 10px;\"><b>";
  if($site_language=="en")
    echo "Weapon Precision Level";
  else
    echo "Nivel precizie arme";
  echo "</b></font>";
  
  echo "<br /><br />";

  if($site_language=="en")
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Weapon precision levels will increase your weapons' precision with 4%.</font>";
  else 
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Nivelele de precizie a armelor vor mari precizia acestora cu 4%.</font>";  
  
  echo "<br /><br />";

  if($db_theend->Record["wprec"]<10 && $db_theend->Record["wprec_time"]==0)
  {
    if(date("i")>=0 && date("i")<5)
      $alltime=(5-date("i"))+(pow(2,$db_theend->Record["wprec"])*20*$weapons_time);
  	if(date("i")>=5 && date("i")<25)
      $alltime=(25-date("i"))+(pow(2,$db_theend->Record["wprec"])*20*$weapons_time);
    if(date("i")>=25 && date("i")<45)
      $alltime=(45-date("i"))+(pow(2,$db_theend->Record["wprec"])*20*$weapons_time);
    if(date("i")>=45 && date("i")<60)
      $alltime=(60+5-date("i"))+(pow(2,$db_theend->Record["wprec"])*20*$weapons_time);
    $allhours=floor($alltime/60);    
    $allmins=$alltime%60; 

    echo "<div style=\"float: right; margin-right: 10px;\">";
  	echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"upgrade\"></input>";
    echo "<input type=\"hidden\" name=\"precision\" value=\"".($db_theend->Record["wprec"]+1)."\"></input>";
    echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
    echo "</form>";
    echo "</div>";
    
    if($site_language=="en")
      echo "Upgrade to level ".($db_theend->Record["wprec"]+1)." costs ".number_format((pow(4,$db_theend->Record["wprec"])*$weapons_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Upgrade estimated duration: ".$allhours." hour(s), ".$allmins." minute(s).</font>";
    else 
      echo "Nivelul ".($db_theend->Record["wprec"]+1)." costa ".number_format((pow(4,$db_theend->Record["wprec"])*$weapons_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Durata estimata a trecerii la noul nivel: ".$allhours." ore, ".$allmins." minute.</font>";  
  }
  
  if($db_theend->Record["wprec_time"]>0)
  {
    if(date("i")>=0 && date("i")<5)
      $timeleft=(5-date("i"))+(($db_theend->Record["wprec_time"]-1)*20);
  	if(date("i")>=5 && date("i")<25)
      $timeleft=(25-date("i"))+(($db_theend->Record["wprec_time"]-1)*20);
    if(date("i")>=25 && date("i")<45)
      $timeleft=(45-date("i"))+(($db_theend->Record["wprec_time"]-1)*20);
    if(date("i")>=45 && date("i")<60)
      $timeleft=(60+5-date("i"))+(($db_theend->Record["wprec_time"]-1)*20);
    $hoursleft=floor($timeleft/60);    
    $minsleft=$timeleft%60;   
    if($site_language=="en")       
  	  echo "Upgrading to level ".($db_theend->Record["wprec"]+1)."... estimated time left: ".$hoursleft." hour(s), ".$minsleft." minute(s).<br><br>";
  	else 
  	  echo "Se face trecerea la nivelul ".($db_theend->Record["wprec"]+1)."... timp ramas: ".$hoursleft." ore, ".$minsleft." minute.<br><br>";  
    $proc=100-round(($timeleft*100)/((pow(2,$db_theend->Record["wprec"])*$weapons_time+1)*20));
  if($proc==0) $proc=1;    	
  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\" width=\"100%\"><tr><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr><td background=\"pics/greenbar.gif\" width=\"".$proc."%\" height=\"8\"></td><td height=\"8\" width=\"".(100-$proc)."%\"></td></table></td></table>";
  }   

  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";

  echo "<br />";
  
  echo "<div class=\"titlebar\">";
  if($site_language=="en")
    echo "POPULATION";
  else 
    echo "POPULATIE";  
  echo "</div>";  

  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";  
  
  echo "<div class=\"upgrade_level\">";
  if($site_language=="en")
    echo "Current level: ".$db_theend->Record["population"];
  else 
    echo "Nivel curent: ".$db_theend->Record["population"];  
  echo "</div>";   
  
  echo "<div class=\"upgrades\">";

  echo "<font color=\"#FFA500\" style=\"font-size: 10px;\"><b>";
  if($site_language=="en")
    echo "Population Level";
  else
    echo "Nivel populatie";
  echo "</b></font>";

  echo "<br /><br />";
  
  if($site_language=="en")
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Population levels will increase your max. number of units with 10%.</font>";
  else 
    echo "<font color=\"#909090\" style=\"font-size: 7pt;\">Nivelele populatiei vor mari numarul maxim de unitati cu 10%.</font>";  
  
  echo "<br /><br />";  

  if($db_theend->Record["population"]<10 && $db_theend->Record["population_time"]==0)
  {
    if(date("i")>=0 && date("i")<5)
      $alltime=(5-date("i"))+(pow(2,$db_theend->Record["population"])*20*$population_time);
  	if(date("i")>=5 && date("i")<25)
      $alltime=(25-date("i"))+(pow(2,$db_theend->Record["population"])*20*$population_time);
    if(date("i")>=25 && date("i")<45)
      $alltime=(45-date("i"))+(pow(2,$db_theend->Record["population"])*20*$population_time);
    if(date("i")>=45 && date("i")<60)
      $alltime=(60+5-date("i"))+(pow(2,$db_theend->Record["population"])*20*$population_time);
    $allhours=floor($alltime/60);    
    $allmins=$alltime%60; 
      
    echo "<div style=\"float: right; margin-right: 10px;\">";
  	echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"upgrade\"></input>";
    echo "<input type=\"hidden\" name=\"population\" value=\"".($db_theend->Record["population"]+1)."\"></input>";
    echo "<input class=\"submit4\" type=\"submit\" value=\"Upgrade\"></input>";
    echo "</form>";
    echo "</div>";
    
    if($site_language=="en")
      echo "Upgrade to level ".($db_theend->Record["population"]+1)." costs ".number_format((pow(4,$db_theend->Record["population"])*$population_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Upgrade estimated duration: ".$allhours." hour(s), ".$allmins." minute(s).</font>";
    else 
      echo "Nivelul ".($db_theend->Record["population"]+1)." costa ".number_format((pow(4,$db_theend->Record["population"])*$population_price))." EKR.<br><font color=\"#90FF90\" style=\"font-size: 7pt;\">Durata estimata a trecerii la noul nivel: ".$allhours." ore, ".$allmins." minute.</font>";  
  }
  
  if($db_theend->Record["population_time"]>0)
  {
    if(date("i")>=0 && date("i")<5)
      $timeleft=(5-date("i"))+(($db_theend->Record["population_time"]-1)*20);
  	if(date("i")>=5 && date("i")<25)
      $timeleft=(25-date("i"))+(($db_theend->Record["population_time"]-1)*20);
    if(date("i")>=25 && date("i")<45)
      $timeleft=(45-date("i"))+(($db_theend->Record["population_time"]-1)*20);
    if(date("i")>=45 && date("i")<60)
      $timeleft=(60+5-date("i"))+(($db_theend->Record["population_time"]-1)*20);
    $hoursleft=floor($timeleft/60);    
    $minsleft=$timeleft%60;  
    if($site_language=="en")        
  	  echo "Upgrading to level ".($db_theend->Record["population"]+1)."... estimated time left: ".$hoursleft." hour(s), ".$minsleft." minute(s).<br><br>";
  	else 
  	  echo "Se face trecerea la nivelul ".($db_theend->Record["population"]+1)."... timp ramas: ".$hoursleft." ore, ".$minsleft." minute.<br><br>";  
    $proc=100-round(($timeleft*100)/((pow(2,$db_theend->Record["population"])*$population_time+1)*20));
  if($proc==0) $proc=1;  	
  echo "<table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#606060\" width=\"100%\"><tr><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\"><tr><td background=\"pics/greenbar.gif\" width=\"".$proc."%\" height=\"8\"></td><td height=\"8\" width=\"".(100-$proc)."%\"></td></table></td></table>";
  }  

  echo "</div>";
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

function upgrade_armory()
{
  $attack_price=25000;
  $defense_price=25000;
  $spy_price=50000;
  $sentry_price=50000;
  $elite_price=25000;
  $workers_price=50000;
  $weapons_price=25000;
  $population_price=100000;
  
  $attack_time=1;
  $defense_time=1;
  $spy_time=2;
  $sentry_time=2;
  $elite_time=1;
  $workers_time=2;
  $weapons_time=1;
  $population_time=4;   

  $db_theend = new DataBase_theend;
  $db_theend->connect();

  semafor_on($_COOKIE["uid"]);

  $query="select users.id, upgrades.attack, upgrades.defense, upgrades.spy, upgrades.antispy, upgrades.worker, upgrades.wprec, upgrades.population, upgrades.elite, armory.gold from upgrades, armory, users where upgrades.id=users.id and armory.id=users.id and users.id=".$_COOKIE["uid"]."";
  $db_theend->query($query);
  $db_theend->next_record();
  $id=$db_theend->Record["id"];

  if($_POST["atlevel"])
  {
    $level=$_POST["atlevel"];
    $duration=pow(2,$level-1)*$attack_time+1;
    $cost=pow(4,$db_theend->Record["attack"])*$attack_price;
    if($db_theend->Record["gold"]>=$cost)
    {
            $gold=$db_theend->Record["gold"]-$cost;
            $query="update armory set gold=".$gold." where id=".$id;
            $db_theend->query($query);
            $query="update upgrades set attack_time=".$duration." where id=".$id;
            $db_theend->query($query);
    }
  }

  if($_POST["dflevel"])
  {
    $level=$_POST["dflevel"];
    $duration=pow(2,$level-1)*$defense_time+1;
    $cost=pow(4,$db_theend->Record["defense"])*$defense_price;
    if($db_theend->Record["gold"]>=$cost)
    {
            $gold=$db_theend->Record["gold"]-$cost;
            $query="update armory set gold=".$gold." where id=".$id;
            $db_theend->query($query);
            $query="update upgrades set defense_time=".$duration." where id=".$id;
            $db_theend->query($query);
    }
  }

  if($_POST["worker"])
  {
    $level=$_POST["worker"];
    $duration=pow(2,$level-1)*$workers_time+1;
    $cost=pow(4,$db_theend->Record["worker"])*$workers_price;
    if($db_theend->Record["gold"]>=$cost)
    {
            $gold=$db_theend->Record["gold"]-$cost;
            $query="update armory set gold=".$gold." where id=".$id;
            $db_theend->query($query);
            $query="update upgrades set worker_time=".$duration." where id=".$id;
            $db_theend->query($query);
    }
  }

  if($_POST["spy"])
  {
    $level=$_POST["spy"];
    $duration=pow(2,$level-1)*$spy_time+1;
    $cost=pow(4,$db_theend->Record["spy"])*$spy_price;
    if($db_theend->Record["gold"]>=$cost)
    {
            $gold=$db_theend->Record["gold"]-$cost;
            $query="update armory set gold=".$gold." where id=".$id;
            $db_theend->query($query);
            $query="update upgrades set spy_time=".$duration." where id=".$id;
            $db_theend->query($query);
    }
  }

  if($_POST["sentry"])
  {
    $level=$_POST["sentry"];
    $duration=pow(2,$level-1)*$sentry_time+1;
    $cost=pow(4,$db_theend->Record["antispy"])*$sentry_price;
    if($db_theend->Record["gold"]>=$cost)
    {
            $gold=$db_theend->Record["gold"]-$cost;
            $query="update armory set gold=".$gold." where id=".$id;
            $db_theend->query($query);
            $query="update upgrades set antispy_time=".$duration." where id=".$id;
            $db_theend->query($query);
    }
  }

  if($_POST["precision"])
  {
    $level=$_POST["precision"];
    $duration=pow(2,$level-1)*$weapons_time+1;
    $cost=pow(4,$db_theend->Record["wprec"])*$weapons_price;
    if($db_theend->Record["gold"]>=$cost)
    {
            $gold=$db_theend->Record["gold"]-$cost;
            $query="update armory set gold=".$gold." where id=".$id;
            $db_theend->query($query);
            $query="update upgrades set wprec_time=".$duration." where id=".$id;
            $db_theend->query($query);
    }
  }

  if($_POST["population"])
  {
    $level=$_POST["population"];
    $duration=pow(2,$level-1)*$population_time+1;
    $cost=pow(4,$db_theend->Record["population"])*$population_price;
    if($db_theend->Record["gold"]>=$cost)
    {
            $gold=$db_theend->Record["gold"]-$cost;
            $query="update armory set gold=".$gold." where id=".$id;
            $db_theend->query($query);
            $query="update upgrades set population_time=".$duration." where id=".$id;
            $db_theend->query($query);
    }
  }

  if($_POST["elite"])
  {
    $level=$_POST["elite"];
    $duration=pow(2,$level-1)*$elite_time+1;
    $cost=pow(4,$db_theend->Record["elite"])*$elite_price;
    if($db_theend->Record["gold"]>=$cost)
    {
            $gold=$db_theend->Record["gold"]-$cost;
            $query="update armory set gold=".$gold." where id=".$id;
            $db_theend->query($query);
            $query="update upgrades set elite_time=".$duration." where id=".$id;
            $db_theend->query($query);
    }
  }

  semafor_off($_COOKIE["uid"]);
}

function sell_upgrade($type,$race,$level,$price)
{
/*
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  $db2 = new DataBase_theend;
  $db2->connect();

  if($type=="attack")
    $dbtype=1;
  if($type=="defense")
    $dbtype=0;

  $level_count=1;
  $can_sell=1;

  if($type=="defense" || $type=="attack")
  {
    $query="select id from weapons where type=".$dbtype." and race='".$race."' order by power";
    $db_theend->query($query);
    while($db_theend->next_record() && $can_sell)
    {
      if($level_count<$level)
      {
        $level_count++;
      }
      else
      {
        $query="select w1 from user_weapons where id=".$_COOKIE["uid"]." and w1=".$db_theend->Record["id"];
        $db2->query($query);
        if($db2->num_rows())
        {
          // are arme de levelul pe care vrea sa-l vanda, vanzarea nu este posibila
          $can_sell=0;
        }
      }
    }
  }

  if($type=="attack" && $can_sell)
  {
    $query="select attack from upgrades where id=".$_COOKIE["uid"];
    $db_theend->query($query);
    $db_theend->next_record();
    if($level==$db_theend->Record["attack"])
    {
      $level=$level-1;
      if($level<0) $level=0;
      $query="update upgrades set attack=".$level." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
      $query="update armory set gold=gold+".$price." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
    }
  }

  if($type=="defense" && $can_sell)
  {
    $query="select defense from upgrades where id=".$_COOKIE["uid"];
    $db_theend->query($query);
    $db_theend->next_record();
    if($level==$db_theend->Record["defense"])
    {
      $level=$level-1;
      if($level<0) $level=0;
      $query="update upgrades set defense=".$level." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
      $query="update armory set gold=gold+".$price." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
    }
  }

  if($type=="spy" && $can_sell)
  {
    $query="select spy from upgrades where id=".$_COOKIE["uid"];
    $db_theend->query($query);
    $db_theend->next_record();
    if($level==$db_theend->Record["spy"])
    {
      $level=$level-1;
      if($level<0) $level=0;
      $query="update upgrades set spy=".$level." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
      $query="update armory set gold=gold+".$price." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
    }
  }

  if($type=="sentry" && $can_sell)
  {
    $query="select antispy from upgrades where id=".$_COOKIE["uid"];
    $db_theend->query($query);
    $db_theend->next_record();
    if($level==$db_theend->Record["antispy"])
    {
      $level=$level-1;
      if($level<0) $level=0;
      $query="update upgrades set antispy=".$level." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
      $query="update armory set gold=gold+".$price." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
    }
  }

  if($type=="worker" && $can_sell)
  {
    $query="select worker from upgrades where id=".$_COOKIE["uid"];
    $db_theend->query($query);
    $db_theend->next_record();
    if($level==$db_theend->Record["worker"])
    {
      $level=$level-1;
      if($level<0) $level=0;
      $query="update upgrades set worker=".$level." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
      $query="update armory set gold=gold+".$price." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
    }
  }

  if($can_sell)
  {
    return 1;
  }
  else
  {
    return 0;
  }
*/
}
?>
