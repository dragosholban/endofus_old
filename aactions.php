<?php
function aactions()
{
  $db = new DataBase_theend;
  $db->connect();

  echo "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">";
  echo "<tr><td height=\"1\" bgcolor=\"#404040\"></td></tr>";
  echo "<tr><td height=\"18\" bgcolor=\"#101520\">&nbsp;&nbsp;&nbsp;&nbsp;<font color=\"#C0D0E0\" style=\"font-size: 7pt;\"><b>AUTO-ACTIONS</b></font></td></tr>";
  echo "<tr><td height=\"1\" bgcolor=\"#404040\"></td></tr>";
  echo "</table>";

  echo "<br>";
  
  echo "<table class=\"dotted\" bgcolor=\"#000000\" width=\"90%\"><tr><td align=\"center\">";
  echo "<div style=\"overflow:hidden;font-size:10px;line-height:12px;color:#F0F0F0;font-family:verdana,arial,sans-serif;font-weight:normal;text-decoration:none;\">";
  echo "This section allows you to schedule some automatic tasks to be executed even if you are offline.";
  echo "<br>";
  echo "You can define max. 10 tasks.";
  echo "<br><br>";
  echo "<font color=\"#FFA500\">This option is not yet available.</font>";
  echo "</div>";
  echo "</td></tr></table>";  

}
?>
