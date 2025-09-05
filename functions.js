function showhide(what)
{
  if(document.getElementById(what).style.display=='none')
  {
  	document.getElementById(what).style.display='block';
  }
  else
  {
  	document.getElementById(what).style.display='none';
  }
} 

function hide(what)
{
  	document.getElementById(what).style.display='none';
} 

function javaprice(id,id2,price)
{
  var str=""+id;
  var str2=""+id2;

  var proc=document.getElementById(str2).value;

  var text=parseInt(""+price*proc);

  document.getElementById(str).innerHTML=text;
}

function javaprice2(id,id2,price,proc)
{
  var str=""+id;
  var str2=""+id2;

  var nr=document.getElementById(str2).value;

  var text=parseInt(""+price*proc*nr);

  document.getElementById(str).innerHTML=text;
}

function setPointer(theRow, thePointerColor)
{
    if (thePointerColor == '' || typeof(theRow.style) == 'undefined') {
        return false;
    }
    if (typeof(document.getElementsByTagName) != 'undefined') {
        var theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        var theCells = theRow.cells;
    }
    else {
        return false;
    }

    var rowCellsCnt  = theCells.length;
    for (var c = 0; c < rowCellsCnt; c++) {
    theCells[c].style.backgroundColor = thePointerColor;
    }

    return true;
} // end of the 'setPointer()' function

function unSetPointer(theRow)
{
    if (typeof(theRow.style) == 'undefined') {
        return false;
    }
    if (typeof(document.getElementsByTagName) != 'undefined') {
        var theCells = theRow.getElementsByTagName('td');
    }
    else if (typeof(theRow.cells) != 'undefined') {
        var theCells = theRow.cells;
    }
    else {
        return false;
    }

    var rowCellsCnt  = theCells.length;
    for (var c = 0; c < rowCellsCnt; c++) {
    theCells[c].style.backgroundColor = '';
    }

    return true;
} // end of the 'unSetPointer()' function

function confirm_disband_form()
{
  var a=confirm("Are you sure you want to disband this alliance?\nYou will not be able to join or create another alliance for 48 hours from now!");

  if(a)
  {
    document.disband_form.submit();
  }
}

function confirm_form_leave_alliance_1()
{
  var a=confirm("Are you sure you want to leave this alliance?\nYou will not be able to join or create another alliance for 48 hours from now!");

  if(a)
  {
    document.form_leave_alliance_1.submit();
  }
}

function confirm_form_leave_alliance_2()
{
  var a=confirm("Are you sure you want to leave this alliance?\nYou will not be able to join or create another alliance for 48 hours from now!");

  if(a)
  {
    document.form_leave_alliance_2.submit();
  }
}

function turntime(time,race)
{
  var min=time/60;
  var sec=time%60;

  min=parseInt(min);

  if(sec<0) sec=0;
  if(min<0) min=0;

  if(sec<10) sec="0"+sec;
  if(min<10) min="0"+min;

  var totaltime=1201;

  var barcolor='';

  if(race=="alien") barbg='pics/redbar.gif';
  if(race=="human") barbg='pics/bluebar.gif';
  if(race=="machine") barbg='pics/greenbar.gif';

  var bar=(totaltime-time)*100/totaltime;

  var barcode="<div style=\"position: relative; left:0px; top:0px; height: 16px; width=104px; margin-left:0px; margin-right: 0px; margin-top:0px; margin-bottom: 0px;\" align=\"center\"><table cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#404040\" width=\"104\" height=\"14\"><tr><td bgcolor=\"#000000\"><table cellspacing=\"0\" cellpadding=\"0\"><td background=\""+barbg+"\" height=\"10\" width=\""+bar+"\"></td></table></td></tr></table></div>";

  document.getElementById("turntimebar").innerHTML=barcode;
  if(time<=0) time=1201;
  setTimeout("turntime("+(time-1)+",'"+race+"')",1000);

}

function checkemail(field)
{
  for(i=0;i<field.length;i++)
    field[i].checked=true;
}

function uncheckemail(field)
{
  for(i=0;i<field.length;i++)
    field[i].checked=false;
}

function allianceSafeLogs(alid,log)
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
    if(xmlHttp.readyState==1)
    {
      document.getElementById("alliance_safe_logs_span").innerHTML="The request has been set up"; 
    }  	
    if(xmlHttp.readyState==2)
    {
      document.getElementById("alliance_safe_logs_span").innerHTML="The request has been sent"; 
    }  	
    if(xmlHttp.readyState==3)
    {
      document.getElementById("alliance_safe_logs_span").innerHTML="The request is in process"; 
    }
    if(xmlHttp.readyState==4)
    {
      if(log=="deposit")
      {
        document.getElementById("alliance_safe_deposit_logs_span").innerHTML=xmlHttp.responseText;
      	document.getElementById("alliance_safe_deposit_logs_button_span").innerHTML="<input class=\"submit4\" type=\"button\" onclick=\"showhide('alliance_safe_deposit_logs_table'); hide('alliance_safe_transfer_logs_table');\" value=\"View Deposit Logs\" />"; 
      }
      if(log=="transfer") 
      {
      	document.getElementById("alliance_safe_transfer_logs_span").innerHTML=xmlHttp.responseText;
      	document.getElementById("alliance_safe_transfer_logs_button_span").innerHTML="<input class=\"submit4\" type=\"button\" onclick=\"showhide('alliance_safe_transfer_logs_table'); hide('alliance_safe_deposit_logs_table');\" value=\"View Transfer Logs\" />"; 
      }
    }    
  }
  xmlHttp.open("GET","ajax/al_safe_logs.php?al_id="+alid+"&log="+log,true);
  xmlHttp.send(null);  
}

function attackLogs(uid)
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
    if(xmlHttp.readyState==1)
    {
      document.getElementById("attack_logs_span").innerHTML="The request has been set up"; 
    }  	
    if(xmlHttp.readyState==2)
    {
      document.getElementById("attack_logs_span").innerHTML="The request has been sent"; 
    }  	
    if(xmlHttp.readyState==3)
    {
      document.getElementById("attack_logs_span").innerHTML="The request is in process"; 
    }
    if(xmlHttp.readyState==4)
    {
      document.getElementById("attack_logs_span").innerHTML=xmlHttp.responseText;
      document.getElementById("attack_logs_button_span").innerHTML="<span onClick=\"showhide(attack_logs_table);\"><font color=\"#A0A0A0\">[view past attacks on this user]</font></span>"; 
    }    
  }
  xmlHttp.open("GET","ajax/attack_logs.php?uid="+uid,true);
  xmlHttp.send(null);  
}

function attackDetails(attack_id)
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
    if(xmlHttp.readyState==1)
    {
      document.getElementById("attack_details_span_"+attack_id).innerHTML="The request has been set up"; 
    }  	
    if(xmlHttp.readyState==2)
    {
      document.getElementById("attack_details_span_"+attack_id).innerHTML="The request has been sent"; 
    }  	
    if(xmlHttp.readyState==3)
    {
      document.getElementById("attack_details_span_"+attack_id).innerHTML="The request is in process"; 
    }
    if(xmlHttp.readyState==4)
    {
      document.getElementById("attack_details_span_"+attack_id).innerHTML=xmlHttp.responseText; 
      document.getElementById("attack_details_button_span_"+attack_id).innerHTML="<input class=\"submit4\" type=\"button\" value=\"details\" onClick=\"showhide('attack_details_"+attack_id+"');\"></input>";
    }    
  }
  xmlHttp.open("GET","ajax/attack_details.php?at="+attack_id,true);
  xmlHttp.send(null);  
}

function spyDetails(spy_id)
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
    if(xmlHttp.readyState==1)
    {
      document.getElementById("spy_details_span_"+spy_id).innerHTML="The request has been set up"; 
    }  	
    if(xmlHttp.readyState==2)
    {
      document.getElementById("spy_details_span_"+spy_id).innerHTML="The request has been sent"; 
    }  	
    if(xmlHttp.readyState==3)
    {
      document.getElementById("spy_details_span_"+spy_id).innerHTML="The request is in process"; 
    }
    if(xmlHttp.readyState==4)
    {
      document.getElementById("spy_details_span_"+spy_id).innerHTML=xmlHttp.responseText; 
      document.getElementById("spy_details_button_span_"+spy_id).innerHTML="<input class=\"submit4\" type=\"button\" value=\"Details\" onClick=\"showhide('spy_details_"+spy_id+"');\"></input>";
    }    
  }
  xmlHttp.open("GET","ajax/spy_details.php?sp="+spy_id,true);
  xmlHttp.send(null);  
}

function depositSafe()
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
    if(xmlHttp.readyState==1)
    {
      document.getElementById("result").innerHTML="The request has been set up"; 
    }  	
    if(xmlHttp.readyState==2)
    {
      document.getElementById("result").innerHTML="The request has been sent"; 
    }  	
    if(xmlHttp.readyState==3)
    {
      document.getElementById("result").innerHTML="The request is in process"; 
    }
    if(xmlHttp.readyState==4)
    {
      s=xmlHttp.responseText.split("&");
      if(s[0]==1)
      {
        document.getElementById("outOfSafeGold").innerHTML=s[1];
        document.getElementById("inSafeGold").innerHTML=s[2];
        document.getElementById("totalGold").innerHTML=s[3];
      	document.getElementById("result").innerHTML="";
      } 
      else
      {
      	document.getElementById("result").innerHTML="An error occured!";
      } 
    }    
  }
  amount=document.getElementById("inputDepositAmount").value;
  document.getElementById("inputDepositAmount").value="";
  xmlHttp.open("GET","ajax/updatesafe.php?act=deposit&amount="+amount,true);
  xmlHttp.send(null);  
}

function retractSafe()
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
    if(xmlHttp.readyState==1)
    {
      document.getElementById("result").innerHTML="The request has been set up"; 
    }  	
    if(xmlHttp.readyState==2)
    {
      document.getElementById("result").innerHTML="The request has been sent"; 
    }  	
    if(xmlHttp.readyState==3)
    {
      document.getElementById("result").innerHTML="The request is in process"; 
    }
    if(xmlHttp.readyState==4)
    {
      s=xmlHttp.responseText.split("&");
      if(s[0]==1)
      {
        document.getElementById("outOfSafeGold").innerHTML=s[1];
        document.getElementById("inSafeGold").innerHTML=s[2];
        document.getElementById("totalGold").innerHTML=s[3];
      	document.getElementById("result").innerHTML="";
      } 
      else
      {
      	document.getElementById("result").innerHTML="An error occured!";
      }
    }    
  }
  amount=document.getElementById("inputRetractAmount").value;
  document.getElementById("inputRetractAmount").value="";
  xmlHttp.open("GET","ajax/updatesafe.php?act=retract&amount="+amount,true);
  xmlHttp.send(null);  
}