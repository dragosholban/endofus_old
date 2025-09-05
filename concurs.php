<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include "database.php";
include "functions.php";

function sort_array($array)
{
	
}

$db = new DataBase_theend;
$db->connect();

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

<?php
$i=0;

$query="select a.id as ideul, a.username, (select count(user_id) as vizitatori from user_referals where user_id=ideul) as vizitatori from users a order by vizitatori desc, username";
//$query="select * from user_referals order by data desc";
$db->query($query);
//echo "<br /><br />";
//echo "<div style=\"width: 40%; margin-left: 10px; float: left; text-align: center;\">";
//echo "<font style=\"font-size: 16px;\"><b>S1</b></font>";
//echo "<br /><br />";
//echo "<table class=\"table1\">";
while($db->next_record())
{
  if($db->Record["vizitatori"])	
  {
	//echo "<tr>";
	//echo "<td class=\"cell2\">".$db->Record["ideul"]."</td>";
	//echo "<td class=\"cell2\">".$db->Record["username"]."</td>";
	//echo "<td class=\"cell2\">".$db->Record["vizitatori"]."</td>";
	//echo "</tr>";
	$array[$i]["id"]=$db->Record["ideul"];
	$array[$i]["username"]=$db->Record["username"];
	$array[$i]["vizitatori"]=$db->Record["vizitatori"];
	$array[$i]["s"]="s1";
	$i++;
  }
}
//echo "</table>";
//echo "</div>";


$db2 = new DataBase_s2;
$db2->connect();

$query="select a.id as ideul, a.username, (select count(user_id) as vizitatori from user_referals where user_id=ideul) as vizitatori from users a order by vizitatori desc, username";
//$query="select * from user_referals order by data desc";
$db2->query($query);

//echo "<div style=\"width: 40%; margin-right: 10px; float: right; text-align: center;\">";
//echo "<font style=\"font-size: 16px;\"><b>S2</b></font>";
//echo "<br /><br />";
//echo "<table class=\"table1\">";
while($db2->next_record())
{
  if($db2->Record["vizitatori"])	
  {
	//echo "<tr>";
	//echo "<td class=\"cell2\">".$db2->Record["ideul"]."</td>";
	//echo "<td class=\"cell2\">".$db2->Record["username"]."</td>";
	//echo "<td class=\"cell2\">".$db2->Record["vizitatori"]."</td>";
	//echo "</tr>";
	$array[$i]["id"]=$db2->Record["ideul"];
	$array[$i]["username"]=$db2->Record["username"];
	$array[$i]["vizitatori"]=$db2->Record["vizitatori"];
	$array[$i]["s"]="s2";
	$i++;	
  }
}
//echo "</table>";
//echo "</div>";
//echo "<br /><br />";

$array_size=$i;

for($x = 0; $x < $array_size; $x++) {
  for($y = 0; $y < $array_size; $y++) {
    if($array[$x]["vizitatori"] > $array[$y]["vizitatori"]) {
      $hold = $array[$x];
      $array[$x] = $array[$y];
      $array[$y] = $hold;
    }
  }
}

echo "<div style=\"clear: both; width: 40%; margin: 10px; text-align: center;\">";
echo "<table class=\"table1\">";
for($j=0;$j<$i;$j++)
{
	if($j<4)
	{	
	echo "<tr>";
	echo "<td class=\"cell2\"><font color=\"#FFD700\">".$array[$j]["id"]."</font></td>";
	echo "<td class=\"cell2\"><font color=\"#FFD700\">".$array[$j]["username"]." (".$array[$j]["s"].")"."</font></td>";
	echo "<td class=\"cell2\"><font color=\"#FFD700\">".$array[$j]["vizitatori"]."</font></td>";
	echo "</tr>";	
	}
	else 
	{
	echo "<tr>";
	echo "<td class=\"cell2\">".$array[$j]["id"]."</td>";
	echo "<td class=\"cell2\">".$array[$j]["username"]." (".$array[$j]["s"].")"."</td>";
	echo "<td class=\"cell2\">".$array[$j]["vizitatori"]."</td>";
	echo "</tr>";		
	}
}
echo "</table>";
echo "</div>";
echo "<br /><br />";
?>

</body>

</html>
