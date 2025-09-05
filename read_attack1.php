<?php
include 'database.php';
include 'functions.php';

$db = new DataBase_theend;
$db->connect();

$query="select * from attack_log order by id desc limit 1";
$db->query($query);
$db->next_record();
echo "id=".$db->Record["id"].random_number(1,10).";";
?>