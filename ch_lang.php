<?php

if($_POST["lang_sel"]=="en" || $_GET["lang_sel"]=="en")
{
  setcookie("lang","en",mktime(0,0,0,12,31,2020));
}
else
{
  setcookie("lang","ro",mktime(0,0,0,12,31,2020));
}

header("Location: index.php");

?>