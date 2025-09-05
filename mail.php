<?php

function inbox($user,$myrace,$page)
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();
  
  $site_language=site_language();

  echo "<div class=\"titlebar\">INBOX</div>";
  echo "<br />";

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\" style=\"padding: 2px;\">";

     echo "<div style=\"float: right; color: #A0A0A0; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;\">";
	 echo "<span id=\"mail_nav\"></span>";
     echo "</div>";    
  
  if($site_language=="en")
  {
  echo "<a class=\"light_blue\" onClick=\"emaillist.submit();\">[delete]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"checkemail(document.emaillist.emailcheck);\">[check all]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"uncheckemail(document.emaillist.emailcheck);\">[uncheck all]</a>";
  }
  else 
  {
  echo "<a class=\"light_blue\" onClick=\"emaillist.submit();\">[sterge]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"checkemail(document.emaillist.emailcheck);\">[selecteaza]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"uncheckemail(document.emaillist.emailcheck);\">[deselecteaza]</a>";
  }
  
  echo "</div>";
  echo "</div>";
  echo "</div>";

  echo "<div class=\"section\">";


     $query="select count(datetime) as nrmail from mail where touser=".$user;
     $db_theend->query($query);
     $db_theend->next_record();
     $mails=$db_theend->Record["nrmail"];
     if(!$mails) $mails=0;

     if($page<1 || $page>ceil($mails/30)) $page=1;

     echo "<form name=\"emaillist\" action=\"play.php\" method=\"POST\">";
     echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
     echo "<input type=\"hidden\" name=\"what\" value=\"delete\"></input>";

     $firstmail=0;
     $lastmail=0;

     $query="select mail.id, mail.fromuser, mail.touser, mail.fromuser, mail.datetime, mail.subject, mail.text, mail.new, users.username, users.race from mail left join users on mail.fromuser=users.id where mail.touser=".$user." order by mail.datetime desc limit ".(($page-1)*30).",30";
     $db_theend->query($query);
     $i=0;
     echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
     while($db_theend->next_record())
     {
         if(!$firstmail)
           $firstmail=$db_theend->Record["id"];
         else
           if($db_theend->Record["id"]>$firstmail)
             $firstmail=$db_theend->Record["id"];
         if($db_theend->Record["new"]==1)
         {
             echo "<tr>";
             echo "<td class=\"mail1\">";
             echo "<input type=\"checkbox\" id=\"emailcheck\" name=\"".$db_theend->Record["id"]."\"></input>";
             echo "</td>";
             echo "<td class=\"mail2\">";
             if($db_theend->Record["username"])
               echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["fromuser"]."\">".$db_theend->Record["username"]."</a>";
             else
               if($db_theend->Record["fromuser"]==0)
                 echo "<font color=\"#FF0000\">ENS Team</font>";
             echo " : ";
             echo "<a class=\"mail_new\" href=\"play.php?loc=mail&what=view&box=inbox&message=".$db_theend->Record["id"]."\">";
             if($db_theend->Record["fromuser"]==0)
               echo "<font color=\"#FF0000\">".str_replace("<br>"," ",substr($db_theend->Record["subject"],0,35))."</font>";
             else
               echo str_replace("<br>"," ",substr($db_theend->Record["subject"],0,35));
             echo "</a>";
             echo "</td>";
             echo "<td class=\"mail3\"><a class=\"mail_date\" href=\"play.php?loc=mail&what=view&box=inbox&message=".$db_theend->Record["id"]."\">".$db_theend->Record["datetime"]."</a></td>";
             echo "</tr>";
         }
         else
         {
             echo "<tr>";
             echo "<td class=\"mail1\">";
             echo "<input type=\"checkbox\" id=\"emailcheck\" name=\"".$db_theend->Record["id"]."\"></input>";
             echo "</td>";
             echo "<td class=\"mail2\">";
             if($db_theend->Record["username"])
               echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["fromuser"]."\">".$db_theend->Record["username"]."</a>";
             else
               if($db_theend->Record["fromuser"]==0)
                 echo "<font color=\"#FF0000\">ENS Team</font>";
             echo " : ";
             echo "<a class=\"mail\" href=\"play.php?loc=mail&what=view&box=inbox&message=".$db_theend->Record["id"]."\">";
             if($db_theend->Record["fromuser"]==0)
               echo "<font color=\"#FF0000\">".str_replace("<br>"," ",substr($db_theend->Record["subject"],0,35))."</font>";
             else
               echo str_replace("<br>"," ",substr($db_theend->Record["subject"],0,35));
             echo "</a>";
             echo "</td>";
             echo "<td class=\"mail3\"><a class=\"mail_date\" href=\"play.php?loc=mail&what=view&box=inbox&message=".$db_theend->Record["id"]."\">".$db_theend->Record["datetime"]."</a></td>";
             echo "</tr>";             
         }

         if(!$lastmail)
           $lastmail=$db_theend->Record["id"];
         else
           if($db_theend->Record["id"]<$lastmail)
             $lastmail=$db_theend->Record["id"];
         $i++;
     }
     echo "</table>";

  echo "<input type=\"hidden\" name=\"startm\" value=\"".$lastmail."\"></input>";
  echo "<input type=\"hidden\" name=\"stopm\" value=\"".$firstmail."\"></input>";
  echo "</form>";
  echo "</div>";
   
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\" style=\"padding: 2px;\">";

     $lastmail=$page*30;
     if($lastmail>$mails) $lastmail=$mails;
     
     echo "<div style=\"float: right; color: #A0A0A0; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;\">";
     if($site_language=="en")
       echo "Showing mails ".(($page-1)*30+1)." - ".$lastmail." from ".$mails." <b><font color=\"#FFFFFF\">&middot;</font></b> ";
     else 
       echo "Afisez mesajele ".(($page-1)*30+1)." - ".$lastmail." din ".$mails." <b><font color=\"#FFFFFF\">&middot;</font></b> ";  
     if($page-1)
     {
       echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
       echo "<input type=\"hidden\" name=\"page\" value=\"".($page-1)."\"></input>";
       echo "<input class=\"submit4\" type=\"submit\" value=\" < \"></input>";
       echo "</form> ";
     }
     if($site_language=="en")
       echo "Page ".$page." from ".ceil($mails/30)." ";
     else 
       echo "Pag. ".$page." din ".ceil($mails/30)." ";  
     if($page<ceil($mails/30))
     {
       echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
       echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
       echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
       echo "</form>";
     }
     echo "</div>";  
     
     echo "\n";
     echo "<script type=\"text/javascript\">\n";
     if($site_language=="en")
       $text="Showing mails ".(($page-1)*30+1)." - ".$lastmail." from ".$mails." <b><font color=\\\"#FFFFFF\\\">&middot;</font></b> ";
     else 
       $text="Afisez mesajele ".(($page-1)*30+1)." - ".$lastmail." din ".$mails." <b><font color=\\\"#FFFFFF\\\">&middot;</font></b> ";  
     if($page-1)
     {
       $text.="<form style=\\\"display: inline;\\\" action=\\\"play.php\\\" method=\\\"POST\\\">";
       $text.="<input type=\\\"hidden\\\" name=\\\"loc\\\" value=\\\"mail\\\"></input>";
       $text.="<input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"".($page-1)."\\\"></input>";
       $text.="<input class=\\\"submit4\\\" type=\\\"submit\\\" value=\\\" < \\\"></input>";
       $text.="</form> ";
     }
     if($site_language=="en")
       $text.="Page ".$page." from ".ceil($mails/30)." ";
     else 
       $text.="Pag. ".$page." din ".ceil($mails/30)." ";  
     if($page<ceil($mails/30))
     {
       $text.="<form style=\\\"display: inline;\\\" action=\\\"play.php\\\" method=\\\"POST\\\">";
       $text.="<input type=\\\"hidden\\\" name=\\\"loc\\\" value=\\\"mail\\\"></input>";
       $text.="<input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"".($page+1)."\\\"></input>";
       $text.="<input class=\\\"submit4\\\" type=\\\"submit\\\" value=\\\" > \\\"></input>";
       $text.="</form>";
     }     
     echo "document.getElementById('mail_nav').innerHTML=\"".$text."\";\n";
     echo "</script>\n";
  
  if($site_language=="en")
  {
  echo "<a class=\"light_blue\" onClick=\"emaillist.submit();\">[delete]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"checkemail(document.emaillist.emailcheck);\">[check all]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"uncheckemail(document.emaillist.emailcheck);\">[uncheck all]</a>";
  }
  else 
  {
  echo "<a class=\"light_blue\" onClick=\"emaillist.submit();\">[sterge]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"checkemail(document.emaillist.emailcheck);\">[selecteaza]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"uncheckemail(document.emaillist.emailcheck);\">[deselecteaza]</a>";
  }
  
  echo "</div>";
  echo "</div>";
  echo "</div>"; 
}

function sentbox($user,$myrace,$page)
{
     $db_theend = new DataBase_theend;
     $db_theend->connect();
     
     $site_language=site_language();

  echo "<div class=\"titlebar\">SENTBOX</div>";
  echo "<br />"; 
  
     echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\" style=\"padding: 2px;\">";

     echo "<div style=\"float: right; color: #A0A0A0; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;\">";
	 echo "<span id=\"mail_nav\"></span>";
     echo "</div>";    
  
  if($site_language=="en")
  {
  echo "<a class=\"light_blue\" onClick=\"emaillist.submit();\">[delete]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"checkemail(document.emaillist.emailcheck);\">[check all]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"uncheckemail(document.emaillist.emailcheck);\">[uncheck all]</a>";
  }
  else 
  {
  echo "<a class=\"light_blue\" onClick=\"emaillist.submit();\">[sterge]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"checkemail(document.emaillist.emailcheck);\">[selecteaza]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"uncheckemail(document.emaillist.emailcheck);\">[deselecteaza]</a>";
  }
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  echo "<div class=\"section\">";  

     $query="select count(datetime) as nrmail from sentbox where fromuser=".$user;
     $db_theend->query($query);
     $db_theend->next_record();
     $mails=$db_theend->Record["nrmail"];
     if(!$mails) $mails=0;

     if($page<1 || $page>ceil($mails/30)) $page=1;

     echo "<form name=\"emaillist\" action=\"play.php\" method=\"POST\">";
     echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
     echo "<input type=\"hidden\" name=\"what\" value=\"delete\"></input>";

     $firstmail=0;
     $lastmail=0;

     $query="select sentbox.id, sentbox.fromuser, sentbox.touser, sentbox.datetime, sentbox.subject, sentbox.text, users.username, users.race from sentbox, users where sentbox.fromuser=".$user." and sentbox.touser=users.id order by sentbox.datetime desc limit ".(($page-1)*30).",30";
     $db_theend->query($query);
     $i=0;
     echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
     while($db_theend->next_record())
     {
         if(!$firstmail)
           $firstmail=$db_theend->Record["id"];
         else
           if($db_theend->Record["id"]>$firstmail)
             $firstmail=$db_theend->Record["id"];

             echo "<tr>";
             echo "<td class=\"mail1\">";
             echo "<input type=\"checkbox\" id=\"emailcheck\" name=\"".$db_theend->Record["id"]."\"></input>";
             echo "</td>";
             echo "<td class=\"mail2\">";
             if($db_theend->Record["username"])
               echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["touser"]."\">".$db_theend->Record["username"]."</a>";
             else
               if($db_theend->Record["fromuser"]==0)
                 echo "<font color=\"#FF0000\">ENS Team</font>";             
             echo " : ";
             echo "<a class=\"mail\" href=\"play.php?loc=mail&what=view&box=sentbox&message=".$db_theend->Record["id"]."\">".str_replace("<br>"," ",substr($db_theend->Record["subject"],0,35));
             echo "</a>";
             echo "</td>";
             echo "<td class=\"mail3\"><a class=\"mail_date\" href=\"play.php?loc=mail&what=view&box=sentbox&message=".$db_theend->Record["id"]."\">".$db_theend->Record["datetime"]."</a></td>";
             echo "</tr>";

         if(!$lastmail)
           $lastmail=$db_theend->Record["id"];
         else
           if($db_theend->Record["id"]<$lastmail)
             $lastmail=$db_theend->Record["id"];

         $i++;
     }
	 echo "</table>";

	 echo "<input type=\"hidden\" name=\"startm\" value=\"".$lastmail."\"></input>";
     echo "<input type=\"hidden\" name=\"stopm\" value=\"".$firstmail."\"></input>";
     echo "</form>";
     
  echo "</div>";   

  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_page\" style=\"padding: 2px;\">";

     $lastmail=$page*30;
     if($lastmail>$mails) $lastmail=$mails;
     
     echo "<div style=\"float: right; color: #A0A0A0; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;\">";
     if($site_language=="en")
       echo "Showing mails ".(($page-1)*30+1)." - ".$lastmail." from ".$mails." <b><font color=\"#FFFFFF\">&middot;</font></b> ";
     else 
       echo "Afisez mesajele ".(($page-1)*30+1)." - ".$lastmail." din ".$mails." <b><font color=\"#FFFFFF\">&middot;</font></b> ";  
     if($page-1)
     {
       echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
       echo "<input type=\"hidden\" name=\"page\" value=\"".($page-1)."\"></input>";
       echo "<input class=\"submit4\" type=\"submit\" value=\" < \"></input>";
       echo "</form> ";
     }
     if($site_language=="en")
       echo "Page ".$page." from ".ceil($mails/30)." ";
     else 
       echo "Pag. ".$page." din ".ceil($mails/30)." ";  
     if($page<ceil($mails/30))
     {
       echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
       echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
       echo "<input type=\"hidden\" name=\"page\" value=\"".($page+1)."\"></input>";
       echo "<input class=\"submit4\" type=\"submit\" value=\" > \"></input>";
       echo "</form>";
     }
     echo "</div>";  
     
     echo "\n";
     echo "<script type=\"text/javascript\">\n";
     if($site_language=="en")
       $text="Showing mails ".(($page-1)*30+1)." - ".$lastmail." from ".$mails." <b><font color=\\\"#FFFFFF\\\">&middot;</font></b> ";
     else 
       $text="Afisez mesajele ".(($page-1)*30+1)." - ".$lastmail." din ".$mails." <b><font color=\\\"#FFFFFF\\\">&middot;</font></b> ";  
     if($page-1)
     {
       $text.="<form style=\\\"display: inline;\\\" action=\\\"play.php\\\" method=\\\"POST\\\">";
       $text.="<input type=\\\"hidden\\\" name=\\\"loc\\\" value=\\\"mail\\\"></input>";
       $text.="<input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"".($page-1)."\\\"></input>";
       $text.="<input class=\\\"submit4\\\" type=\\\"submit\\\" value=\\\" < \\\"></input>";
       $text.="</form>";
     }
     if($site_language=="en")
       $text.="Page ".$page." from ".ceil($mails/30)." ";
     else 
       $text.="Pag. ".$page." din ".ceil($mails/30)." ";  
     if($page<ceil($mails/30))
     {
       $text.="<form style=\\\"display: inline;\\\" action=\\\"play.php\\\" method=\\\"POST\\\">";
       $text.="<input type=\\\"hidden\\\" name=\\\"loc\\\" value=\\\"mail\\\"></input>";
       $text.="<input type=\\\"hidden\\\" name=\\\"page\\\" value=\\\"".($page+1)."\\\"></input>";
       $text.="<input class=\\\"submit4\\\" type=\\\"submit\\\" value=\\\" > \\\"></input>";
       $text.="</form>";
     }     
     echo "document.getElementById('mail_nav').innerHTML=\"".$text."\";\n";
     echo "</script>\n";
  
  if($site_language=="en")
  {
  echo "<a class=\"light_blue\" onClick=\"emaillist.submit();\">[delete]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"checkemail(document.emaillist.emailcheck);\">[check all]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"uncheckemail(document.emaillist.emailcheck);\">[uncheck all]</a>";
  }
  else 
  {
  echo "<a class=\"light_blue\" onClick=\"emaillist.submit();\">[sterge]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"checkemail(document.emaillist.emailcheck);\">[selecteaza]</a>";
  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  echo "<a class=\"light_blue\" onClick=\"uncheckemail(document.emaillist.emailcheck);\">[deselecteaza]</a>";
  	
  }

  echo "</div>";
  echo "</div>";
  echo "</div>";      

}

function usermail()
{
  $myrace=userrace($_COOKIE["uid"]);

  $site_language=site_language();

  if($_POST["what"]=="send")
  {
     $db = new DataBase_theend;
     $db->connect();

     echo "<div class=\"titlebar\">";
     if($site_language=="en")
       echo "REPLY MESSAGE";
     else 
       echo "RASPUNDE LA MESAJ";  
     echo "</div>";
     echo "<br />";

     echo "<div class=\"section\">";
     echo "<div class=\"section_black\">";
     echo "<div class=\"section_grey\">";

     if($_POST["user"])
     {
       $query="select username from users where id=".$_POST["user"];
       $db->query($query);
       $db->next_record();
       $tousername=$db->Record["username"];
     }
     else
     {
       if($_POST["user"]==0)
         $tousername="ENS Team";
     }

     $query="select username from users where id=".$_COOKIE["uid"];
     $db->query($query);
     $db->next_record();
     $fromusername=$db->Record["username"];
     
     echo "<form method=\"POST\" action=\"sendmail.php\">";
     echo "<input type=\"hidden\" name=\"file\" value=\"play.php\" />";
     echo "<input type=\"hidden\" name=\"from\" value=\"".$_COOKIE["uid"]."\" />";
     echo "<input type=\"hidden\" name=\"to\" value=\"".$_POST["user"]."\" />";
     echo "<p class=\"bigline\">";
     if($site_language=="en")
       echo "Subject: ";
     else
       echo "Subiect: ";
	 echo "</p>";
     if($_POST["subject"])
     {
       echo "<input class=\"input3\" type=\"text\" name=\"subject\" value=\"".$_POST["subject"]."\" />";
     }
     else
     {
       echo "<input class=\"input3\" type=\"text\" name=\"subject\" value=\"no subject\" />";
     }
     echo "<p class=\"bigline\">";
     if($site_language=="en")
       echo "Message: ";
     else
       echo "Mesaj: ";
	 echo "</p>";       
     if($_POST["message"])
     {
       echo "<textarea name=\"text\" class=\"mail\" rows=\"15\" cols=\"100\">\n\n\n*****\n".$_POST["message"]."</textarea>";
     }
     else
     {
       echo "<textarea name=\"text\" class=\"mail\" rows=\"15\" cols=\"100\"></textarea>";
     }
     echo "<p class=\"bigline\">";     
     if($site_language=="en")
       echo "<input class=\"submit4\" type=\"submit\" value=\"Send Message\" />";
     else
       echo "<input class=\"submit4\" type=\"submit\" value=\"Trimite Mesaj\" />";
	 echo "</p>";       
     echo "</form>";

     echo "<br>";
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
     echo "<br>";

     echo "</div>";
     echo "</div>";
     echo "</div>";
  }
  if($_GET["what"]=="view" && $_GET["box"]=="inbox" && $_GET["message"])
  {
     echo "<div class=\"titlebar\">";
     if($site_language=="en")
       echo "VIEW MESSAGE";
     else 
       echo "AFISARE MESAJ"; 
     echo "</div>";  
     echo "<br />";

     $db_theend = new DataBase_theend;
     $db_theend->connect();
     $db2 = new DataBase_theend;
     $db2->connect();
     $query="select mail.id, mail.fromuser, mail.touser, mail.datetime, mail.subject, mail.text, mail.new, users.username, users.race from mail left join users on mail.fromuser=users.id where mail.id=".$_GET["message"];
     $db_theend->query($query);
     $db_theend->next_record();

     if($_COOKIE["uid"]==$db_theend->Record["touser"])
     {
    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\">";
    
    echo "<div style=\"width: 90%; margin: 0 auto; color: #A0A0A0; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;\">";
    
    echo "<br />";
    
    echo "<p class=\"bigline\">"; 
    if($site_language=="en")
       echo "From: ";
     else
       echo "De la: ";
     if($db_theend->Record["username"])
       echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["fromuser"]."\">".$db_theend->Record["username"]."</a>";
     else
       if($db_theend->Record["fromuser"]==0)
         echo "<font color=\"#FF0000\">ENS Team</font>";
     echo "</p>";  
     echo "<p class=\"bigline\">";  
     if($site_language=="en")
       echo "Subject: ";
     else
       echo "Subiect: ";
     echo "<font color=\"#F0F0F0\">".$db_theend->Record["subject"]."</font>";
     echo "</p>"; 
     
    echo "</div>"; 
    
    echo "<br />";

     echo "<div class=\"mail\">";
     echo nl2br($db_theend->Record["text"]);
     echo "</div>";

     echo "<div style=\"width: 90%; margin: 0 auto; margin-top: 5px; margin-bottom: 5px; text-align: right;\">";
     
     echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
     echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
     echo "<input type=\"hidden\" name=\"what\" value=\"send\"></input>";
     echo "<input type=\"hidden\" name=\"user\" value=\"".$db_theend->Record["fromuser"]."\"></input>";
     echo "<input type=\"hidden\" name=\"subject\" value=\"RE: ".$db_theend->Record["subject"]."\"></input>";
     echo "<input type=\"hidden\" name=\"message\" value=\"";
     if($db_theend->Record["username"])
       echo $db_theend->Record["username"];
     else
       if($db_theend->Record["fromuser"]==0)
         echo "ENS Team";
     echo " wrote:\n".$db_theend->Record["text"]."\"></input>";
     if($site_language=="en")
       echo "<input type=\"submit\" class=\"submit4\" value=\"reply\" />";
     else 
       echo "<input type=\"submit\" class=\"submit4\" value=\"raspunde\" />";  
     echo "</form>";
     
     echo "&nbsp;";

     echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
     echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
     echo "<input type=\"hidden\" name=\"what\" value=\"delete\"></input>";
     echo "<input type=\"hidden\" name=\"id\" value=\"".$db_theend->Record["id"]."\"></input>";
     if($site_language=="en")
       echo "<input type=\"submit\" class=\"submit4\" value=\"delete\" />";
     else 
       echo "<input type=\"submit\" class=\"submit4\" value=\"sterge\" />";  
     echo "</form>";
     
     echo "&nbsp;";

     echo "<form style=\"display: inline;\" action=\"play.php\" method=\"GET\">";
     echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"/>";
     if($site_language=="en")
       echo "<input type=\"submit\" class=\"submit4\" value=\"back\" />";
     else 
       echo "<input type=\"submit\" class=\"submit4\" value=\"inapoi\" />";  
     echo "</form>";
   
     echo "</div>";  

     if($db_theend->Record["new"]==1)
     {
       $query="update mail set new=0 where id=".$_GET["message"];
       $db2->query($query);
       $query="update users set newmail=newmail-1 where id=".$_COOKIE["uid"];
       $db2->query($query);
     }

    echo "</div>"; 
    echo "</div>";
    echo "</div>";
     
    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\" style=\"padding: 5px;\">";
    
     if($site_language=="en")
       echo "<img src=\"pics/warned.gif\"></img> <span style=\"cursor: pointer; cursor: hand;\" onClick=\"showhide('message_reporting');\"><font color=\"#FFA500\"><b>Message reporting</b></font></span>";
     else
       echo "<img src=\"pics/warned.gif\"></img> <span style=\"cursor: pointer; cursor: hand;\" onClick=\"showhide('message_reporting');\"><font color=\"#FFA500\"><b>Raportare mesaj</b></font></span>";

     echo "<br>";
     if($site_language=="en")
       echo "<font color=\"#909090\">Please report any obscene, racist, threathening (in other way that the game concepts)<br>or spam email. Take care that any abbusive report will be punished.</font>";
     else
       echo "<font color=\"#909090\">Te rugam raporteaza orice mesaj obscen, rasist, amenintator (exceptand conceptele jocului)<br>sau considerat spam. Atentie, orice raportare abuziva va fi pedepsita.</font>";
     echo "<div id=\"message_reporting\" style=\"display: none;\">";
     echo "<br/ >";
     echo "<form name=\"form_report_message\" method=\"POST\" action=\"play.php\">";
     echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
     echo "<input type=\"hidden\" name=\"what\" value=\"report\"></input>";
     echo "<input type=\"hidden\" name=\"datetime\" value=\"".$db_theend->Record["datetime"]."\"></input>";
     echo "<input type=\"hidden\" name=\"fromuser\" value=\"".$db_theend->Record["fromuser"]."\"></input>";
     echo "<input type=\"hidden\" name=\"touser\" value=\"".$db_theend->Record["touser"]."\"></input>";
     if($site_language=="en")
       echo "<p class=\"bigline\">Your comments:</p>";
     else
       echo "<p class=\"bigline\">Comentariile tale:</p>";
     echo "<textarea name=\"comments\" class=\"mail\" rows=\"5\" cols=\"50\"></textarea>";
     if($site_language=="en")
       echo "<p class=\"bigline\"><input type=\"submit\" class=\"submit4\" value=\"Report message!\" /></p>";
     else 
       echo "<p class=\"bigline\"><input type=\"submit\" class=\"submit4\" value=\"Raporteaza mesaj!\" /></p>";  
     echo "</form>";
     echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
     }

  }

  if($_GET["what"]=="view" && $_GET["box"]=="sentbox" && $_GET["message"])
  {
    echo "<div class=\"titlebar\">";
    if($site_language=="en")
      echo "VIEW MESSAGE";
    else 
      echo "AFISARE MESAJ";  
    echo "</div>"; 
    echo "<br />";
    
     $db_theend = new DataBase_theend;
     $db_theend->connect();
     $db2 = new DataBase_theend;
     $db2->connect();
     $query="select sentbox.id, sentbox.fromuser, sentbox.touser, sentbox.datetime, sentbox.subject, sentbox.text, users.username, users.race from sentbox, users where sentbox.id=".$_GET["message"]." and sentbox.touser=users.id";
     $db_theend->query($query);
     $db_theend->next_record();

     if($_COOKIE["uid"]==$db_theend->Record["fromuser"])
     {
    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\">";
    
    echo "<div style=\"width: 90%; margin: 0 auto; color: #A0A0A0; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px;\">";
    
    echo "<br />";

	echo "<p class=\"bigline\">";    
     if($site_language=="en")
       echo "To: ";
     else
       echo "Catre: ";
     if($db_theend->Record["username"])
       echo "<a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["touser"]."\">".$db_theend->Record["username"]."</a>";
     else
       if($db_theend->Record["touser"]==0)
         echo "<font color=\"#FF0000\">ENS Team</font>";
	echo "</p>";
	echo "<p class=\"bigline\">";	
     if($site_language=="en")
       echo "Subject: ";
     else
       echo "Subiect: ";
     echo $db_theend->Record["subject"];
	echo "</p>";

    echo "</div>"; 
    
    echo "<br />";	
	
     echo "<div class=\"mail\">";
     echo nl2br($db_theend->Record["text"]);
     echo "</div>";
     
     echo "<div style=\"width: 90%; margin: 0 auto; margin-top: 5px; margin-bottom: 5px; text-align: right;\">";

     echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
     echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
     echo "<input type=\"hidden\" name=\"what\" value=\"delete\"></input>";
     echo "<input type=\"hidden\" name=\"box\" value=\"sentbox\" />";
     echo "<input type=\"hidden\" name=\"id\" value=\"".$db_theend->Record["id"]."\"></input>";
     if($site_language=="en")
       echo "<input class=\"submit4\" type=\"submit\" value=\"Delete\"></input>";
     else
       echo "<input class=\"submit4\" type=\"submit\" value=\"Sterge\"></input>";
     echo "</form>";
     
     echo " ";

     echo "<form style=\"display: inline;\" action=\"play.php\" method=\"POST\">";
     echo "<input type=\"hidden\" name=\"loc\" value=\"mail\"></input>";
     echo "<input type=\"hidden\" name=\"what\" value=\"sentbox\" />";
     if($site_language=="en")
       echo "<input class=\"submit4\" type=\"submit\" value=\"Back\"></input>";
     else
       echo "<input class=\"submit4\" type=\"submit\" value=\"Inapoi\"></input>";
     echo "</form>";
     
     echo "</div>";

     echo "</div>";
     echo "</div>";
     echo "</div>";
     }
  }

  if($_POST["what"]=="report") // && $_POST["datetime"] && $_POST["fromuser"] && $_POST["touser"])
  {
    echo "<div class=\"titlebar\">";
    if($site_language=="en")
      echo "MESSAGE REPORT";
    else 
      echo "RAPORTARE MESAJ";  
    echo "</div>"; 
    echo "<br />";

    echo "<div class=\"section\">";
    echo "<div class=\"section_black\">";
    echo "<div class=\"section_grey\">";    
    
  	echo "Message has been reported to game's administrators.";
     echo "<br><br>";
     if($site_language=="en")
       echo "Your comments: ";
     else
       echo "Comentariile tale: ";
     echo "<br>";
     echo $_POST["comments"];
     echo "<br><br>";
     if($site_language=="en")
       echo "Thank you!";
     else
       echo "Multumim!";
     echo "<br><br>";
     $db_theend = new DataBase_theend;
     $db_theend->connect();
     $query="select text from mail where datetime='".$_POST["datetime"]."' and fromuser=".$_POST["fromuser"]." and touser=".$_POST["touser"];
     $db_theend->query($query);
     $db_theend->next_record();

     $query="insert into mail_reports values(DEFAULT,".$_POST["fromuser"].",".$_POST["touser"].",'".$db_theend->Record["text"]."','".$_POST["comments"]."')";
     //echo $query;

     $db_theend->query($query);
     // mail("endofus@ens.ro","In game message report","Datetime: ".$_POST["datetime"]."\nFrom user: ".$_POST["fromuser"]."\nTo user: ".$_POST["touser"]."\n\nMessage:\n".$db_theend->Record["text"]."\n\nComments:\n".$_POST["comments"],"From: endofus\n");
     
     echo "</div>";
     echo "</div>";
     echo "</div>";     
  }

  if($_POST["what"]=="delete" && $_POST["id"])
  {
     $db_theend = new DataBase_theend;
     $db_theend->connect();
     if($_POST["box"]=="sentbox")
     {
       $query="delete from sentbox where id=".$_POST["id"];
       $db_theend->query($query);     	
     }
     else 
     {
       $query="delete from mail where id=".$_POST["id"];
       $db_theend->query($query);

       // newmail update
       $query="update users set newmail=(select count(id) from mail where new=1 and touser=".$_COOKIE["uid"].") where id=".$_COOKIE["uid"];
       $db_theend->query($query);
     }
  }
  if($_POST["what"]=="delete" && $_POST["startm"] && $_POST["stopm"])
  {
     $db_theend = new DataBase_theend;
     $db_theend->connect();

     for($i=$_POST["startm"];$i<=$_POST["stopm"];$i++)
     {
       if($_POST["$i"])
       {
         $query="delete from mail where id=".$i;
         $db_theend->query($query);
       }
     }

     // newmail update
     $query="update users set newmail=(select count(id) from mail where new=1 and touser=".$_COOKIE["uid"].") where id=".$_COOKIE["uid"];
     $db_theend->query($query);
  }
  if((!$_POST["what"] && !$_GET["what"] && !$_POST["user"]) || ($_POST["what"]=="delete") || ($_POST["what"]=="inbox"))
  {
     if($_POST["page"]) inbox($_COOKIE["uid"],$myrace,$_POST["page"]);
     else inbox($_COOKIE["uid"],$myrace,1);
  }
  if($_POST["what"]=="sentbox")
  {
     if($_POST["page"]) sentbox($_COOKIE["uid"],$myrace,$_POST["page"]);
     else sentbox($_COOKIE["uid"],$myrace,1);
  }
  echo "<br>";
}

?>
