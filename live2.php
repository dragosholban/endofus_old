<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
  <meta name="description" content="Massive multiplayer online game. Adventure game. Browser based. Joc de strategie online.">
  <meta name="keywords" content="massive, multiplayer, free, online, game, mmorpg, strategie, razboi, war">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <title>End of us - massive multiplayer online game (joc online de strategie)</title>
</head>
<body bgcolor="#203040">
<script language='javascript' type='text/javascript' name='myScriptName' id='myScript' src='read_attack.php'></script>
<table width="100%">
<tr><td width="130">
<br>
<script type="text/javascript"><!--
google_ad_client = "pub-7634296240444560";
google_ad_width = 120;
google_ad_height = 600;
google_ad_format = "120x600_as";
google_ad_type = "text_image";
google_ad_channel = "";
google_color_border = "203040";
google_color_bg = "203040";
google_color_link = "C0D0E0";
google_color_text = "909090";
google_color_url = "F0F0F0";
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</td>

<td align="left" valign="top">
<br>
<font color="#FFD700"><b>Connected to END OF US Live Server...</b></font>
<br>
<font color="#909090"><b>Begining live transmision from battlefield...</b></font>
<br>
<font color="#203040">joc online strategie razboi, massive multiplayer free online game, war, aliens, humans, machines, online games, mmporg, rpg, strategy</font>
<br>

<span id="text1"></span>

<script type="text/javascript">

function span_write(text)
{
  document.getElementById('text1').innerHTML=text+document.getElementById('text1').innerHTML;
}

function write_all(i,last_attack)
{
  s=print1.split("&");
  
  if(s[0]==1)
  {
    span_write(s[2]+"&nbsp;&nbsp;&nbsp;<b>"+s[3]+"</b> attacked <b>"+s[4]+"</b> using <b>"+s[5]+"</b> Action Point(s). <b>"+s[6]+"</b> won.<br>");
  }
  
  //document.getElementById('myScript').src = "";
  //document.getElementById('myScript').src = "read_attack.php?i="+i+"&last_attack="+s[1];
  //document['myScriptName'].src="read_attack.php?i="+i+"&last_attack="+s[1];
  //document.write('<script language=\"javascript\" type=\"text/javascript\" src=\"' + 'read_attack.php?i='+i+'&last_attack='+s[1] + '\"><\/script>');
  
var headID = document.getElementsByTagName("head")[0];
var newScript = document.createElement('script');
newScript.type = 'text/javascript';
newScript.src = "read_attack.php?i="+i+"&last_attack="+s[1];
headID.appendChild(newScript);  
  
  i++;
  
  setTimeout("write_all("+i+",'"+s[1]+"')",1000);
}

write_all(1,'0');
</script>

</td><tr></table>
</body>
</html>