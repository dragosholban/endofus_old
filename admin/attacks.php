<html>
<body>
<?php
include 'database.php';

$db=new DataBase_theend;
$db->connect();

$query="select attack_log.id, attack_log.date, a.username as at, b.username as df, c.username as win, attack_log.atp, attack_log.dfp, attack_log.turns, attack_log.at_units, attack_log.df_units, attack_log.exp, attack_log.exp_lost, attack_log.gold, attack_log.units_killed, attack_log.units_captured from attack_log, users a, users b, users c where attack_log.at_id=a.id and attack_log.df_id=b.id and attack_log.win_id=c.id order by date desc";
$db->query($query);
echo "<table border=\"1\">";
echo "<tr><th>attack id</th><th>date & time</th><th>attacker</th><th>defender</th><th>winner</th><th>attack power</th><th>defense power</th><th>turns</th><th>attack units</th><th>defense units</th><th>exp win</th><th>exp lost</th><th>gold win</th><th>units killed</th><th>units captured</th></tr>";
while($db->next_record())
{
  echo "<tr><td>".$db->Record["id"]."</td><td>".$db->Record["date"]."</td><td>".$db->Record["at"]."</td><td>".$db->Record["df"]."</td><td>".$db->Record["win"]."</td><td>".$db->Record["atp"]."</td><td>".$db->Record["dfp"]."</td><td>".$db->Record["turns"]."</td><td>".$db->Record["at_units"]."</td><td>".$db->Record["df_units"]."</td><td>".$db->Record["exp"]."</td><td>".$db->Record["exp_lost"]."</td><td>".$db->Record["gold"]."</td><td>".$db->Record["units_killed"]."</td><td>".$db->Record["units_captured"]."</td></tr>";
}
echo "</table>";
?>
</body>
</html>
