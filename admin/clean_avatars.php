#!/usr/bin/php -q
<?php

include 'database.php';

$db=new DataBase_theend;
$db->connect();

function dirList ($directory) 
{

    // create an array to hold directory list
    $results = array();

    // create a handler for the directory
    $handler = opendir($directory);

    // keep going until all files in directory have been read
    while ($file = readdir($handler)) {

        // if $file isn't this directory or its parent, 
        // add it to the results array
        if ($file != '.' && $file != '..')
            $results[] = $file;
    }

    // tidy up: close the handler
    closedir($handler);

    // done!
    return $results;

}

$file=dirList("../pics/avatars/");
$i=0;
foreach($file as $f)
{
	echo "<br />".$f;
	
	$query="select * from alliances where avatar='pics/avatars/".$f."'";
	$db->query($query);
	if($db->num_rows())
	{
		$del=0;
	}
	else 
	{
		$del=1;
	}
	if($del)
	{
	$query="select * from user_profile where avatar='pics/avatars/".$f."'";
	$db->query($query);
	if($db->num_rows())
	{
		$del=0;
	}
	else 
	{
		$del=1;
	}
	}
	if($del && $f!="humans.jpg" && $f!="machines.jpg" && $f!="aliens.jpg")
	{
		if(unlink("../pics/avatars/".$f))
		{
		  echo " (deleted)";
		}
		else 
		{
			echo " unlink(../pics/avatars/".$f.")";
			echo " (delete error)";
		}
		$i++;
	}
}
echo "<br /><b>Total: ".$i." files</b>";
?>
