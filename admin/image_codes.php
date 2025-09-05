<html>
<body>
<?php
include 'database.php';

$db=new DataBase_theend;
$db->connect();

function random_number($li,$ls)
{
        srand ((float) microtime( )*1000000);
        $random_number = rand($li,$ls);
        return $random_number;
}

for ($i=0;$i<1000;$i++)
{
	$id=$i+1;
	$value=random_number(10000,99999);
$query="insert into image_codes values (".$id.",".$value.")";
$db->query($query);
echo $id." -> ".$value."<br>";
}
?>
</body>
</html>
