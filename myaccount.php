<?php

function account()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();

  if($site_language=="en")
    echo "<div class=\"titlebar\">ACCOUNT INFO</div>";
  else 
    echo "<div class=\"titlebar\">INFORMATII CONT</div>";  
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";

  if($_POST["what"]=="change_friend" && $_POST["username"])
  {
    $post_username=sql_quote($_POST["username"]);
    $query="select id from users where username='".$post_username."'";
    $db_theend->query($query);
    if($db_theend->num_rows())
    {
      $db_theend->next_record();
      $query="update users set id_friend1=".$db_theend->Record["id"]." where id=".$_COOKIE["uid"];
      $db_theend->query($query);
    }
    else
    {
      if($site_language=="en")
    	echo "<font color=\"#FF0000\">Player ".$post_username." was not found!</font><br /><br />";
      else 
        echo "<font color=\"#FF0000\">Jucatorul ".$post_username." nu a fost gasit!</font><br /><br />";
    }
  }

  if($_POST["what"]=="delete_friend")
  {
    $query="update users set id_friend1=DEFAULT where id=".$_COOKIE["uid"];
    $db_theend->query($query);
  }

  if($site_language=="en")
  {
    echo "<img src=\"pics/warned.gif\"></img> If you play End of Us at the same computer as another player, you have to enter his/her account name here. This setting only applies for same computers, not networks!";
    echo "<br /><font color=\"#A0A0A0\">Letting us know will avoid the risk of being recognized as a cheater and excluded from the game.</font>";
  }
  else 
  {
    echo "<img src=\"pics/warned.gif\"></img> Daca joci End of Us la acelasi calculator cu un alt jucator, trebuie sa specifici aici numele contului lui. Acest lucru este valabil doar pentru aceleasi calculatoare, nu retele!";
    echo "<br /><font color=\"#A0A0A0\">Oferindu-ne acesta informatie evitati riscul de a fi identificat ca trisor si exclus din joc.</font>";
  }
  echo "<br /><br />";
  
  $query="select b.id, b.username, b.race from users a, users b where a.id=".$_COOKIE["uid"]." and b.id=a.id_friend1";
  $db_theend->query($query);
  if($db_theend->num_rows())
  {
    $db_theend->next_record();

    echo "<form name=\"form_delete_friend\" action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"account\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"delete_friend\"></input>";
    echo "</form>";

    if($site_language=="en")
      echo "You have entered <a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a> as the other End of Us player that plays this game on the same PC as you. <a href=\"#\" onClick=\"form_delete_friend.submit();\">[delete]</a><br><br>";
    else 
      echo "Ai introdus pe <a class=\"".$db_theend->Record["race"]."\" href=\"user_profile.php?uid=".$db_theend->Record["id"]."\">".$db_theend->Record["username"]."</a> ca fiind numele contului celuilalt jucator End of Us care joca acest joc de la acelsi calculator ca si tine. <a href=\"#\" onClick=\"form_delete_friend.submit();\">[sterge]</a><br><br>";  

    echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"account\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"change_friend\"></input>";
    if($site_language=="en")
      echo "Change player: ";
    else 
      echo "Schimba jucatorul: ";  
    echo "<input class=\"input5\" type=\"text\" name=\"username\"></input>";
    echo "<input class=\"submit1\" type=\"submit\" value=\"OK\"></input>";
    echo "</form>";
  }
  else
  {
    echo "<form action=\"play.php\" method=\"POST\">";
    echo "<input type=\"hidden\" name=\"loc\" value=\"account\"></input>";
    echo "<input type=\"hidden\" name=\"what\" value=\"change_friend\"></input>";
    if($site_language=="en")
      echo "Name of the player: ";
    else 
      echo "Numele jucatorului: ";  
    echo "<input class=\"input5\" type=\"text\" name=\"username\"></input>";
    echo "<input class=\"submit1\" type=\"submit\" value=\"OK\"></input>";
    echo "</form>";
  }

  if($site_language=="en")
    echo "<br><font color=\"#FFA500\">If you refuse to share this information you will be at risk of losing both accounts if sharing the same computer.</font>";
  else 
    echo "<br><font color=\"#FFA500\">Daca refuzi sa oferi acesta informatie exista riscul de a pierde ambele conturi daca impart acelasi calculator.</font>";  

  echo "</div>";
  echo "</div>";
  echo "</div>";
  
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";  

  $query="select users.username, users.race, users.email, online.inactivedate from users, online where users.id=".$_COOKIE["uid"]." and users.id=online.id";
  $db_theend->query($query);
  $db_theend->next_record();

  $can_inactivate=0;

  if(time()-strtotime($db_theend->Record["inactivedate"])>7*24*3600)
  {
    $can_inactivate=1;
  }

  echo "<table class=\"table1\" cellspacing=\"1\" cellpadding=\"0\">";
  echo "<tr>";
  echo "<td class=\"acinf1\">";
  if($site_language=="en")
    echo "Username:";
  else
    echo "Nume:";
  echo "</td>";
  echo "<td class=\"acinf2\">".$db_theend->Record["username"]."</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"acinf1\">";
  if($site_language=="en")
    echo "Race:";
  else
    echo "Rasa:";
  echo "</td>";
  echo "<td class=\"acinf2\">";
  switch($db_theend->Record["race"])
  {
  	case "human":
  		if($site_language=="en")
  		  echo "human";
  		else 
  		  echo "om"; 
  		break;
  	case "machine":
  		if($site_language=="en")
  		  echo "machine";
  		else 
  		  echo "masina";  		
  		break;
  	case "alien":
  		if($site_language=="en")
  		  echo "alien";
  		else 
  		  echo "extraterestru";  		
  		break;		
  }
  echo "</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"acinf1\">E-mail:</td>";
  echo "<td class=\"acinf2\">".$db_theend->Record["email"]."</td>";
  echo "</tr>";
  echo "<tr>";
  echo "<td class=\"acinf1\">";
  if($site_language=="en")
    echo "Account status:";
  else 
    echo "Stare cont:";
  echo "</td>";
  echo "<td class=\"acinf2\">";
  if($site_language=="en")
    echo "active";
  else 
    echo "activ";  
  echo "</td>";
  echo "</tr>";
  if($can_inactivate)
  {
    echo "<tr>";
    echo "<td class=\"acinf3\" colspan=\"2\">";
    echo "<form action=\"deactivate_account.php\" method=\"POST\">";
    if($site_language=="en")
      echo "<input class=\"submit4\" type=\"submit\" value=\"Deactivate Account\" />";
    else 
      echo "<input class=\"submit4\" type=\"submit\" value=\"Dezactiveaza cont\" />";  
    echo "</form>"; 
    echo "<br />";   
    if($site_language=="en")
    {
      echo "*Setting your account inactive will log you out of the game. ";
      echo "Your account will be reactivated automaticaly on your next login.";
      echo "<br>An account can be deactivated only once in 7 days. If you do not use your accout it will deactivate itself after 3 days from your last login.</td>";
    }
    else 
    {
      echo "*Dezactivarea contului te va scoate din joc. ";
      echo "Contul tau se va reactiva automat la urmatorul login.";
      echo "<br>Un cont poate fi dezactivat doar odata la 7 zile. daca nu folosesti contul, el se va dezactiva automat dupa 3 zile de la ultima accesare.</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";  
}

function chpsswd()
{
  $db_theend = new DataBase_theend;
  $db_theend->connect();

  $site_language=site_language();

  if($site_language=="en")
    echo "<div class=\"titlebar\">CHANGE PASSWORD</div>";
  else 
    echo "<div class=\"titlebar\">SCHIMBARE PAROLA</div>";  
  	
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";
    
  if(!($_POST["cp"]) || !($_POST["np"]) || !($_POST["rp"]))
  {
  echo "<div class=\"change_pass\">";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"loc\" value=\"chpsswd\"></input>";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "Current password: ";
  else
    echo "Parola curenta: ";
  echo "<input class=\"input5\" type=\"password\" name=\"cp\"></input>";
  echo "</p>";
  echo "<p class=\"bigline\">";  
  if($site_language=="en")
    echo "New password: ";
  else
    echo "Noua parola: ";
  echo "<input class=\"input5\" type=\"password\" name=\"np\"></input>";
  echo "</p>";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "Retype password: ";
  else
    echo "Reintrodu parola: ";
  echo "<input class=\"input5\" type=\"password\" name=\"rp\"></input>";
  echo "</p>";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "<input class=\"submit1\" type=\"submit\" value=\"Change\"></input>";
  else
    echo "<input class=\"submit1\" type=\"submit\" value=\"Schimba\"></input>";
  echo "</p>";  
  echo "</form>";
  echo "</div>";
  }
  else
  {
  $query="select password from users where id=".$_COOKIE["uid"];
  $db_theend->query($query);
  $db_theend->next_record();
  if ($db_theend->Record["password"]!=md5($_POST["cp"]))
    echo "<br>Current password not enetered! Retry.<br>";
  else
  if ($_POST["np"]!=$_POST["rp"])
    echo "<br>Password retype incorrect! Retry.<br>";
  else
  {
    $query="update users set password='".md5($_POST["np"])."' where id=".$_COOKIE["uid"];
    $db_theend->query($query);
    echo "<br>Password changed!<br>";
  }
  }
  
  echo "</div>";
  echo "</div>";
  echo "</div>";  
}

function resetac()
{
  $db = new DataBase_theend;
  $db->connect();
  $db2 = new DataBase_theend;
  $db2->connect();
  
  $site_language=site_language();

  if($site_language=="en")
    echo "<div class=\"titlebar\">RESET ACCOUNT</div>";
  else 
    echo "<div class=\"titlebar\">RESETARE CONT</div>";  
  	
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\">";  
  
  if($_POST["opt"]=="reset" && $_POST["pass"] && $_POST["race"] && $_POST["race"]!="none")
  {
    $password=md5($_POST["pass"]);

    $query="select id, username from users where id=".$_COOKIE["uid"]." and password='".$password."'";
    $db->query($query);
    if($db->num_rows())
    {
       $db->next_record();

       $query="update users set race='".$_POST["race"]."' where id=".$db->Record["id"];
       $db2->query($query);
       $query="update armory set attack=0, elite_at=0, elite_df=0, units=10, untrained=10, level=0, exp=0, gold=0, turnlen=20, lastacct='".date("Y-m-d H:i:s")."', workers=0, spy=0, antispy=0, rank=0, rank_value=0, turn=100, attack_rank=0, defense_rank=0, spy_rank=0, sentry_rank=0, attack_rank_value=0, defense_rank_value=0, spy_rank_value=0, sentry_rank_value=0 where id=".$db->Record["id"];
       $db2->query($query);
       $query="update upgrades set attack=0, defense=0, spy=0, antispy=0, worker=0, wprec=0, population=0, elite=0, attack_time=0, defense_time=0, spy_time=0, antispy_time=0, worker_time=0, wprec_time=0, population_time=0, elite_time=0 where id=".$db->Record["id"];
       $db2->query($query);

       $query="update semafor set armory=0, skey='' where id=".$db->Record["id"];
       $db2->query($query);

       //$query="update online set online=-1, datetime='".date("Y-m-d H:i:s")."', inactivedate='".date("Y-m-d H:i:s")."'";
       //$db2->query($query);

       //$query="update user_profile set firstname='', lastname='', location='', avatar='' where id=".$db->Record["id"];
       //$db2->query($query);

       $query="update seif set gold=20000, max_gold=10000000, date='' where uid=".$db->Record["id"];
       $db2->query($query);

       $query="update mastery set battle=0, battle_win=0 where id=".$db->Record["id"];
       $db2->query($query);

       $query="update top_active_users set week1=0, week2=0 where id=".$db->Record["id"];
       $db2->query($query);

       $query="select id from alliances where commander='".$db->Record["username"]."'";
       $db2->query($query);
       if($db2->num_rows())
       {
         $db2->next_record();
         $idal=$db2->Record["id"];
         $query="delete from alliances where id=".$idal;
         $db2->query($query);
         $query="delete from alliance_members where id_al=".$idal;
         $db2->query($query);
         $query="delete from superattack_log where at_id=".$idal;
         $db2->query($query);
         $query="delete from al_finance_log where id_al=".$idal;
         $db2->query($query);
       }
       $query="delete from alliance_members where id_member=".$db->Record["id"];
       $db2->query($query);

       $query="delete from user_weapons where id=".$db->Record["id"];
       $db2->query($query);

       if($site_language=="en")
         echo "<br /><font color=\"#FFD700\">Reset complete.</font><br />";
       else 
         echo "<br /><font color=\"#FFD700\">Resetare completa.</font><br />";  
    }
    else
    {
      if($site_language=="en")
    	echo "<br /><font color=\"#FF0000\">Wrong password.</font><br />";
      else 
        echo "<br /><font color=\"#FF0000\">Parola gresita.</font><br />";
    }
  }

  echo "<div class=\"reset_ac\">";
  echo "<form action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" value=\"rstac\" name=\"loc\"></input>";
  echo "<input type=\"hidden\" value=\"reset\" name=\"opt\"></input>";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "Enter your current password: ";
  else 
    echo "Introdu parola curenta: ";  
  echo "<input class=\"input5\" type=\"password\" name=\"pass\" /></p>";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "Choose your race: ";
  else 
    echo "Alege-ti rasa: ";  
  if($site_language=="en")  
    echo "<select class=\"select1\" name=\"race\"><option class=\"option1\" value=\"none\" selected=\"selected\">Choose your race</option><option class=\"option1\" value=\"human\">human</option><option class=\"option1\" value=\"machine\">machine</option><option class=\"option1\" value=\"alien\">alien</option></select></p>";
  else 
    echo "<select class=\"select1\" name=\"race\"><option class=\"option1\" value=\"none\" selected=\"selected\">Alege-ti rasa</option><option class=\"option1\" value=\"human\">om</option><option class=\"option1\" value=\"machine\">masina</option><option class=\"option1\" value=\"alien\">extraterestru</option></select></p>";  
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "<input class=\"submit1\" type=\"submit\" value=\"Reset\"></input>";
  else 
    echo "<input class=\"submit1\" type=\"submit\" value=\"Reseteaza cont\"></input>";  
  echo "</p>";
  echo "</form>";
  echo "</div>";

  echo "</div>";
  echo "</div>";
  echo "</div>";
}

function edit_profile()
{
  $db = new DataBase_theend;
  $db->connect();
  
  $site_language=site_language();

  if($site_language=="en")  
    echo "<div class=\"titlebar\">EDIT PROFILE</div>";
  else 
    echo "<div class=\"titlebar\">EDITARE PROFIL</div>";
  echo "<br />";
  
  echo "<div class=\"section\">";
  echo "<div class=\"section_black\">";
  echo "<div class=\"section_grey\" style=\"text-align: center;\">";

  if($_POST["do"]=="deleteimage")
  {
    $query="select avatar from user_profile where id=".$_COOKIE["uid"];
    $db->query($query);
    $db->next_record();
    if($db->Record["avatar"])
    {
      unlink($db->Record["avatar"]);
    }
  	$query="update user_profile set avatar='' where id=".$_COOKIE["uid"];
    $db->query($query);
  }
  
  if($_POST["MAX_FILE_SIZE"])
  {
    $uploaddir="pics/avatars";
    $uploadfile=$uploaddir."/avatar_".userid($_COOKIE["user"]);

    $number=random_number(1,9999);

    $uploadfile=$uploadfile."_".$number;

    $valid_pic=1;

    if(move_uploaded_file($_FILES['avatar']['tmp_name'],$uploadfile))
    {
      $result_array = getimagesize($uploadfile);
      if($result_array)
      {
        $mime_type=$result_array['mime'];

        switch ($mime_type)
        {
          case "image/jpeg":
            /*echo "Tipul fisierului este 'jpeg'";*/
            rename($uploadfile,$uploadfile.".jpg");
            $uploadfile.=".jpg";
            break;
          case "image/gif":
            /*echo "Tipul fisierului este 'gif'";*/
            rename($uploadfile,$uploadfile.".gif");
            $uploadfile.=".gif";
            break;
          case "image/bmp":
            /*echo "Tipul fisierului este 'bmp'";*/
            rename($uploadfile,$uploadfile.".bmp");
            $uploadfile.=".bmp";
            break;
          case "image/png":
            /*echo "Tipul fisierului este 'png'";*/
            rename($uploadfile,$uploadfile.".png");
            $uploadfile.=".png";
            break;
          default:
            unlink($uploadfile);
            $uploadfile="";
            if($site_language=="en")
              echo "\n<script>alert('The uploaded file is not in the sepecified format.\\n Please follow those specifications.');</script>";
            else 
              echo "\n<script>alert('Fisierul upload-at nu este in formatul specificat.\\n Va rugam respectati specificatiile.');</script>";  
        }//switch

        $width = $result_array[0];
        $height = $result_array[1];
        if (($width>120)||($height>120))
        {
          $valid_pic=0;
          if($site_language=="en")
            echo "\n<script>alert('The uploaded image is over 120 x 120 pixels (width, height) and will not be used as your avatar.');</script>";
          else 
            echo "\n<script>alert('Imaginea upload-ata depaseste dimensiunile 120 x 120 pixeli (latime, inaltime) si nu va fi folosita ca avatar.');</script>";  
        }
      }
    }
    else
    {
      if($site_language=="en")
    	echo "\n<script>alert('Internal error (code ".$_FILES['avatar']['error'].").\\nPlease announce the administrators.');</script>";
      else 
        echo "\n<script>alert('Eroare interna (cod ".$_FILES['avatar']['error'].").\\nVa rugam anuntati administratorul.');</script>";
      $valid_pic=0;
    }

    if ($valid_pic==1)
    {
      $query="select avatar from user_profile where id=".$_COOKIE["uid"];
      $db->query($query);
      $db->next_record();
      if($db->Record["avatar"])
      {
        //echo "unlink(".$db->Record["avatar"].")";
        unlink($db->Record["avatar"]);
      }

      $avatar=$uploadfile;
    }
    else
      $avatar="";

    $query="update user_profile set avatar='".$avatar."' where id=".$_COOKIE["uid"];
    $db->query($query);
  }

  $race=userrace($_COOKIE["uid"]);
  echo "<img class=\"avatar\" src=\"".useravatar2($_COOKIE["uid"],$race)."\"></img>";
  echo "<br />";

      $query="select avatar from user_profile where id=".$_COOKIE["uid"];
      $db->query($query);
      $db->next_record();
      if($db->Record["avatar"])
      {
        echo "<form id=\"form_delete_image\" name=\"form_delete_image\" action=\"play.php\" method=\"POST\">";
        echo "<input type=\"hidden\" name=\"loc\" value=\"editprofile\"></input>";
        echo "<input type=\"hidden\" name=\"do\" value=\"deleteimage\"></input>";
        echo "</form>";
      	if($site_language=="en")
      	  echo "<a class=\"light_blue\" style=\"cursor: pointer; cursor: hand;\" onclick=\"form_delete_image.submit();\">[delete image]</a>";
      	else   
      	  echo "<a class=\"light_blue\" style=\"cursor: pointer; cursor: hand;\" onclick=\"form_delete_image.submit();\">[sterge imaginea]</a>";
      	echo "<br />";  
      }  
  
  echo "<br />";
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "Change picture: ";
  else 
    echo "Schimba imaginea: ";  
  echo "</p>";  
  echo "<p class=\"bigline\">";
  if($site_language=="en")
    echo "<font color=\"#909090\">Max. file size: 100.000 bytes, 120 x 120 pixels.<br />File type: jpg, gif, bmp, png</font>";
  else 
    echo "<font color=\"#909090\">Dimensiuni max. fisier: 100.000 bytes, 120 x 120 pixels.<br />Tip fisier: jpg, gif, bmp, png</font>";  
  echo "</p>";
  echo "<form  enctype=\"multipart/form-data\" action=\"play.php\" method=\"POST\">";
  echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000\"></input>";
  echo "<input type=\"hidden\" name=\"loc\" value=\"editprofile\"></input>";
  echo "<p class=\"bigline\">";
  echo "<input class=\"submit4\" name=\"avatar\" type=\"file\"></input>";
  echo "</p>"; 
  echo "<p class=\"bigline\">";
  echo "<input class=\"submit4\" type=\"submit\" value=\"Upload\"></input>";
  echo "</p>";
  echo "</form>";
  
  echo "</div>";
  echo "</div>";
  echo "</div>";
}

?>
