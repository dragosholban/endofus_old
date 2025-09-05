<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<?php

include 'database.php';
include 'functions.php';

function users_list()
{
$db_theend = new DataBase_theend;
$db_theend->connect();
$db2 = new DataBase_theend;
$db2->connect();
$db3 = new DataBase_theend;
$db3->connect();
$db4 = new DataBase_theend;
$db4->connect();
$db5 = new DataBase_theend;
$db5->connect();

echo "<form action=\"\" method=\"POST\">";
echo "Check account: ";
echo "<input class=\"input2\" type=\"text\" name=\"user\"></input>";
echo "&nbsp;";
echo "<input  class=\"input2\" type=\"submit\" value=\"Check!\"></input>";
echo "</form>";

if (ob_get_level() == 0) ob_start();
echo str_pad('',4096)."\n";
ob_flush();
flush();

if($_POST["user"])
{
  $query="select id from users where username='".$_POST["user"]."'";
  //echo "<br>".$query;
  $db_theend->query($query);
  if($db_theend->num_rows())
  {


    $db_theend->next_record();
    $query="select datetime from login_log where cont=".$db_theend->Record["id"]." order by datetime";
    //echo "<br>".$query;
    $db2->query($query);
    while($db2->next_record())
    {
      $data=explode("-",$db2->Record["datetime"]);
      $year=$data[0];
      $mon=$data[1];
      $data=explode(" ",$data[2]);
      $day=$data[0];
      if($lastdate!=$year."-".$mon."-".$day)
      {
      $lastdate=$year."-".$mon."-".$day;
      $query="select distinct computer from login_log where datetime>='".$year."-".$mon."-".$day." 00:00:00' and datetime<='".$year."-".$mon."-".$day." 23:59:59' and cont=".$db_theend->Record["id"];
      //echo "<br>".$query;
      $db3->query($query);
      while($db3->next_record())
      {
        echo str_pad('',4096)."\n";
        ob_flush();
        flush();
        echo "<table>";
        echo "<tr>";
        echo "<td width=\"80\">".$year."-".$mon."-".$day."</td>";
        echo "<td width=\"210\">".$db3->Record["computer"]."</td>";
        echo "<td>";
        $query="select distinct cont from login_log where datetime>='".$year."-".$mon."-".$day." 00:00:00' and datetime<='".$year."-".$mon."-".$day." 23:59:59' and computer='".$db3->Record["computer"]."' order by cont";
        //echo "<br>".$query;
        $db4->query($query);
        while($db4->next_record())
        {
          $query="select username from users where id=".$db4->Record["cont"];
          //echo "<br>".$query;
          $db5->query($query);
          while($db5->next_record())
          {
            if($db5->Record["username"]==$_POST["user"])
              echo "<font color=\"#FFD700\">".$db5->Record["username"]."</font>, ";
            else
              echo "<font color=\"#909090\">".$db5->Record["username"]."</font>, ";
          }
        }
        echo "</td>";
        echo "</tr>";
        echo "</table>";
      }

      echo str_pad('',4096)."\n";

      ob_flush();
      flush();

      }
    }
  ob_end_flush();
  }
  else
  {
    echo "<br><br>User ".$_POST["user"]." not found!<br><br>";
  }
}
}

?>

<body bgcolor="#000000">

<br>


      <?php users_list(); ?>

     <br><br>

</body>
</html>