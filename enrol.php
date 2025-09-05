<?php

  include 'database.php';
  include 'functions.php';


  $username="";
  $password="";
  $repassword="";
  $email="";
  $race="";

  if ($_POST["username"])
    $username=$_POST["username"];
  if ($_POST["password"])
    $password=$_POST["password"];
  if ($_POST["repassword"])
    $repassword=$_POST["repassword"];
  if ($_POST["email"])
    $email=$_POST["email"];
  $race=$_POST["race"];

  if($race=="none")
  {
    header("Location: register.php?error=11");
  }
  else
    if ((!alphanum_field($username))||(strlen($username)<4) || (strlen($username)>15))
    {
      header("Location: register.php?error=1");
    }
    else
      if (($username[0]==" ")||($username[0]=="-")||($username[0]=="."))
      {
        header("Location: register.php?error=2");
      }
      else
        if ((!alphanum_field($password))||(strlen($password)<6))
        {
          header("Location: register.php?error=3");
        }
        else
          if ($password!=$repassword)
          {
            header("Location: register.php?error=4");
          }
          else
            if(!email_field($email))
              {
                header("Location: register.php?error=12");
              }
            else
            {
              $db=new DataBase_theend();
              $db->connect();

              $query="select username from users where username='".$username."'";
              $db->query($query);
              if ($db->num_rows()) //dak mai este vreun utiliz cu acelasi nume.. nashpa
              {
                 header("Location: register.php?error=5");
              }
              else
              {
                $query="select email from users where email='".$email."'";
                $db->query($query);
                if ($db->num_rows()) //dak mai este vreun utiliz cu acelasi email.. nashpa
                {
                   header("Location: register.php?error=6");
                }
                else
                {
                  $query="select username from newusers where username='".$username."'";
                  $db->query($query);
                  if ($db->num_rows())
                  {
                     header("Location: register.php?error=7");
                  }
                  else
                  {
                    $query="select username from newusers where email='".$email."'";
                    $db->query($query);
                    if ($db->num_rows())
                    {
                       header("Location: register.php?error=8");
                    }
                    else
                    {
                      $query="select count(email) as nr_deleted from deleted_accounts where email='".$email."' group by email";
                      $db->query($query);
                      if ($db->num_rows()>=3)
                      {
                         header("Location: register.php?error=13");
                      }
                      else
                      {
                        $user_code=random_number(1000000,9999999);

                        $query="insert into newusers values(DEFAULT,0,".$user_code.",'".$username."','".$password."','".$email."','".$race."','".date("Y-m-d H:i:s")."')";
                        $db->query($query);
                        $query="select LAST_INSERT_ID() as id from newusers";
                        $db->query($query);
                        $db->next_record();
                        $id=$db->Record["id"];

                        $email_text="\n";
                        $email_text.="You registered to our online game with following information:\n";
                        $email_text.="\n\tUsername: ".$username."\n\tPassword: ".$password."\n\tEmail: ".$email."\n";
                        $email_text.="You can play the best online game after you activate your account by clicking this link: \n";
                        $email_text.="\thttps://endofus.pixery.ro/activate_account.php?id=".$id."&user_code=".$user_code."\n";
                        $email_text.="\n\tThis link will be available only for 24 hours. After that you will need to register again.\n\tThank you!";

                        $email_header="From: noreply@endofus.net\n";

                        if (mail($email,"Code for activating account at \"END OF US\" Online Game",$email_text,$email_header))
                        {
                          header("Location: register.php?error=10");
                        }
                        else
                        {
                          header("Location: register.php?error=9");
                        }
                      }
                    }
                  }
                }
              }
            }
?>

