<?php
class DataBaseMySQL
{

 // date membru

 var $Host="";                // adresa serverului MySQL
 var $DataBase="";        // numele bazei de date de pe server
 var $User="";                // numele utilizatorului
 var $Password="";        // parola utilizatorului
 var $Link_ID=0;        // rezultatul lui mysql_connect()
 var $Query_ID=0;        // rezultatul celei mai recente mysql_query()
 var $Record=array();        // rezultatul curent al lui mysql_fetch_array()
 var $Row;                // numarul randului curent
 var $Errno=0;                // starea de eroare a interogarii
 var $Error="";

 // metode

 // opreste executia in caz de eroare fatala
 function halt($msg)
 {
  printf("<p>Database error: %s</p>\n",$msg);
  printf("<p>MySQL error: <b>%s (%s)</b></p>\n",$this->Errno,$this->Error);
  printf("<p><b>MySQL error!</b></p>\n");
  die("Session halted");
 }

 // conectarea la baza de date
 function connect()
 {
  if($this->Link_ID==0)        // inca nu exista o conexiune
  {
   $this->Link_ID=mysql_connect($this->Host,$this->User,$this->Password);
   // succes sau esec?
   if(!$this->Link_ID)
    $this->halt("Connect failed");
   // deschide baza de date
   if(!mysql_query(sprintf("use %s",$this->DataBase),$this->Link_ID))
    $this->halt("Cannot use database".$this->DataBase);
  }
 }

 // trimite o interogare serverulu MySQL
 function query($query_str)
 {
  // realizeaza conectarea
  $this->connect();
  // incearca sa execute interogarea
  $this->Query_ID=mysql_query($query_str,$this->Link_ID);
  // initial stabilim pointerul pe prima inregistrare
  $this->Row=0;
  // salveaza erorile
  $this->Errno=mysql_errno();
  $this->Error=mysql_error();
  // eroare fatala?
  if(!$this->Query_ID)
   $this->halt("Invalid SQL: ".$query_str);
  return $this->Query_ID;
 }

 // furnizeaza daca mai exista o inregistrare
 function next_record()
 {
  // salveaza intr-un tablou inregistrarile
  $this->Record=mysql_fetch_array($this->Query_ID);
  $this->Row++;
  // salveaza erorile
  $this->Errno=mysql_errno();
  $this->Error=mysql_error();
  // returneaza inregistrarea gasita
  $stat=is_array($this->Record);
  if(!$stat)
  {
   // nu mai exista o alta inregistrare
   mysql_free_result($this->Query_ID);
   // se elibereaza interogarea
   $this->Query_ID=0;
  }
  return $stat;
 }

 // furnizeaza o inregistrare dupa pozitia ei
 function seek($pos)
 {
  $status=mysql_data_seek($this->Query_ID,$pos);
  if($status)
   $this->Row=$pos;
  return;
 }

 // numarul de inregistrari gasite
 function num_rows()
 {
  return mysql_num_rows($this->Query_ID);
 }

 // numarul de campuri
 function num_fields()
 {
  return mysql_num_fields($this->Query_ID);
 }

 // valoarea unui camp particular
 function get_field($field)
 {
  return $this->Return[$field];
 }
}

class DataBase_theend extends DataBaseMySQL
{
  var $Host="p50mysql67.secureserver.net";
  var $User="ens_s1";
  var $Password="Avioane13";
  var $DataBase="ens_s1";
}

?>
