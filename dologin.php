<?php

include 'database.php';
include 'functions.php';

$db_theend = new DataBase_theend;
$db_theend->connect();

$username=sql_quote($_POST["username"]);
$password=sql_quote($_POST["password"]);

$code=$_POST["sendcode"];
$query="select value from image_codes where id=".$code;
$db_theend->query($query);
$db_theend->next_record();
$code=$db_theend->Record["value"];

if($_POST["code"]==$code)
{

$query="select * from users where username='".$username."' and password='".md5($password)."'";

$db_theend->query($query);
if ($db_theend->num_rows())
{
  $db_theend->next_record();
  $username=$db_theend->Record["username"];
  $password=$db_theend->Record["password"];
  $userid=$db_theend->Record["id"];
  $race=$db_theend->Record["race"];
  $data=getdate();
  $query="select * from online_statistic where user=".$userid." and data='".$data["year"]."-".$data["mon"]."-".$data["mday"]."'";
  $db_theend->query($query);
  if (!$db_theend->num_rows())
  {
    $query="insert into online_statistic values(".$userid.",'".$data["year"]."-".$data["mon"]."-".$data["mday"]."')";
    $db_theend->query($query);
    $last_mon = date("Y-m-d", mktime(0,0,0, date('m')-1, date('d'), date('Y')));
    $query="delete from online_statistic where data<'".$last_mon."'";
    $db_theend->query($query);
  }

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

    setcookie("user","".$username);
    setcookie("uid","".$userid);
    setcookie("code1","".md5($username));
    setcookie("code2","".md5($password));
    setcookie("online","".time());
    setcookie("svtime","".time());

    $ip=$_SERVER['REMOTE_ADDR'];
    $hostname = gethostbyaddr($ip);

    $query="insert into login_log values('".$userid."','".date("Y-m-d H:i:s")."','".$ip."','".$hostname."','".getenv("HTTP_X_FORWARDED_FOR")."','".$computer."',".$new_cookie.")";
    $db_theend->query($query);

    // online table update
    $query="select online, login_time from online where id=".$userid;
    $db_theend->query($query);
    $db_theend->next_record();
    if($db_theend->Record["online"] && $db_theend->Record["login_time"])
    {
      $query="update online set online=1, datetime='".date("Y-m-d H:i:s")."', login_time=".time().", seconds_day=seconds_day+".(time()-$db_theend->Record["login_time"])." where id=".$userid;
      $db_theend->query($query);
    }
    else
    {
      $query="update online set online=1, datetime='".date("Y-m-d H:i:s")."', login_time=".time()." where id=".$userid;
      $db_theend->query($query);
    }

    // newmail update
    $query="update users set newmail=(select count(datetime) from mail where new=1 and touser=".$userid.") where id=".$userid;
    $db_theend->query($query);
    
    // ad verify
    
    if($_COOKIE["ad"]==1)
    {
      $query="select uid from accept_ads where uid=".$userid;	
      $db_theend->query($query);
      if($db_theend->num_rows())
      {
      	 $query="update accept_ads set accept_ad=1 where uid=".$userid;
      	 $db_theend->query($query);
      }
      else 
      {
      	 $query="insert into accept_ads values(".$userid.",1)";
      	 $db_theend->query($query);      	
      }
    }
    else 
    {
      $query="select uid from accept_ads where uid=".$userid;	
      $db_theend->query($query);
      if($db_theend->num_rows())
      {
      	 $query="update accept_ads set accept_ad=0 where uid=".$userid;
      	 $db_theend->query($query);
      }
      else 
      {
      	 $query="insert into accept_ads values(".$userid.",0)";
      	 $db_theend->query($query);      	
      }    	
    }

    header("Location: play.php?loc=cc&login=1");

}
else
  header("Location: login.php?loginerr=1");
}
else
  header("Location: login.php?loginerr=1");
?>
