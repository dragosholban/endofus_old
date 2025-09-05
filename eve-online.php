<?php
include "functions.php";
$n=random_number(1,100);
?>
<html>
<head></head>
<body style="margin: 0px;" bgcolor="#000000">

<?php
if($n<=10)
{
?>

<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000 codebase="http://download.macromedia.com/pub/shockwave/cabs/ flash/swflash.cab#version=4,0,0,0" ID=ad_banner_example1 WIDTH=468 HEIGHT=60>
  <PARAM NAME=movie VALUE="468x60.swf?clickTAG=https://secure.eve-online.com/ft/?aid=102677">
  <PARAM NAME=loop VALUE=false>
  <PARAM NAME=menu VALUE=false>
  <PARAM NAME=quality VALUE=medium>
  <EMBED src="pics/banners/468x60.swf?clickTAG=https://secure.eve-online.com/ft/?aid=102677" loop=false menu=false quality=medium bgcolor=#FFFFFF swLiveConnect=FALSE WIDTH=468 HEIGHT=60 TYPE="application/x-shockwave-flash"><PARAM NAME=bgcolor VALUE=#FFFFFF>
</object>

<?php
}
else 
{
?>
<!-- PRECISIONCLICK.COM 2007 (C) -->
<!-- Ad Format: 468x60 -->
<script language="javascript"><!--
var d=new Date();var ccb=(d.getTime()%8673806982)+Math.random();document.write('<scr'+'ipt language="javascript" src="http://servedby.precisionclick.com/midas/?src=pub&nid=1357&site=3228&adfmt=6&ccb='+ccb+'"></scr'+'ipt>');
//--></script><noscript><iframe src="http://geo.precisionclick.com/ad/?typ=1&pub=1&nid=1357&site=3228&adfmt=6" width="468" height="60" marginwidth="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe></noscript><?php
}
?>

</body>

</html>
