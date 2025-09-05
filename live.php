<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
  <meta name="description" content="Massive multiplayer online game. Adventure game. Browser based. Joc de strategie online.">
  <meta name="keywords" content="massive, multiplayer, free, online, game, mmorpg, strategie, razboi, war">
  <link rel="stylesheet" type="text/css" href="css/new_style.css">
  <title>End of us - massive multiplayer online game (joc online de strategie)</title>

<script type="text/javascript">
function span_write(text)
{
  document.getElementById('text1').innerHTML=text+"<font color=\"#A0A0A0\">"+document.getElementById('text1').innerHTML+"</font>";
}

function ajaxFunction(last_attack)
{
  var xmlHttp;

  try
  {    // Firefox, Opera 8.0+, Safari    
  	xmlHttp=new XMLHttpRequest();    
  }
  catch (e)
  {    // Internet Explorer    
  	try
    {      
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");      
    }
    catch (e)
    {      
      try
      {        
       	 xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");        
      }
      catch (e)
      {        
      	 alert("Your browser does not support AJAX!");        
      	 return false;        
      }      
    }    
  }
  xmlHttp.onreadystatechange=function()
  {
    if(xmlHttp.readyState==4)
    {
      s=xmlHttp.responseText.split("&");
  
      if(s[0]==1)
      {
        span_write(s[2]+"&nbsp;&nbsp;&nbsp;<b>"+s[3]+"</b> attacked <b>"+s[4]+"</b> using <b>"+s[5]+"</b> Action Point(s). <b>"+s[6]+"</b> won.<br>");
      }
      //span_write(s[0]+" "+s[1]+"<br>");
      setTimeout("ajaxFunction("+s[1]+")",1000);       
    }
  }
  xmlHttp.open("GET","read_attack.php?last_attack="+last_attack,true);
  xmlHttp.send(null);  
}
</script>
  
</head>
<body bgcolor="#203040">
<table width="100%">
<tr><td width="130" valign="top">
<br>

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

  setTimeout("ajaxFunction(0)",1000);
  
</script>

</td><tr></table>
</body>
</html>