<?php

include 'database.php';

function delete_account($user)
{
$db_theend = new DataBase_theend;

$query="select id, username, email from users where username='".$user."'";
$db_theend->query($query);
if($db_theend->num_rows())
{
        $db_theend->next_record();
        $id=$db_theend->Record["id"];
        $username=$db_theend->Record["username"];
        $email=$db_theend->Record["email"];

        $query="delete from users where id=".$id;
        $db_theend->query($query);
        $query="delete from armory where id=".$id;
        $db_theend->query($query);
        $query="delete from semafor where id=".$id;
        $db_theend->query($query);
        $query="delete from seif where uid=".$id;
        $db_theend->query($query);
        $query="delete from online where id=".$id;
        $db_theend->query($query);
        $query="delete from upgrades where id=".$id;
        $db_theend->query($query);
        $query="delete from mastery where id=".$id;
        $db_theend->query($query);
        $query="delete from user_weapons where id=".$id;
        $db_theend->query($query);
        $query="delete from user_profile where id=".$id;
        $db_theend->query($query);
        $query="delete from top_active_users where id=".$id;
        $db_theend->query($query);
        $query="delete from attack_log where at_id=".$id;
        $db_theend->query($query);
        $query="delete from attack_log where df_id=".$id;
        $db_theend->query($query);
        $query="delete from spy_log where df_id=".$id;
        $db_theend->query($query);
        $query="delete from spy_log where at_id=".$id;
        $db_theend->query($query);
        $query="delete from mail where fromuser=".$id;
        $db_theend->query($query);
        $query="delete from mail where touser=".$id;
        $db_theend->query($query);
        $query="delete from sentbox where touser=".$id;
        $db_theend->query($query);
        $query="delete from sentbox where fromuser=".$id;
        $db_theend->query($query);
        $query="select id from alliances where commander='".$user."'";
        $db_theend->query($query);
        if($db_theend->num_rows())
        {
        $db_theend->next_record();
        $idal=$db_theend->Record["id"];
        $query="delete from alliances where id=".$idal;
        $db_theend->query($query);
        $query="delete from alliance_members where id_al=".$idal;
        $db_theend->query($query);
        $query="delete from superattack_log where at_id=".$idal;
        $db_theend->query($query);
        $query="delete from al_finance_log where id_al=".$idal;
        $db_theend->query($query);
        }
        $query="delete from alliance_members where id_member=".$id;
        $db_theend->query($query);
        $query="delete from votes where user_id=".$id;
        $db_theend->query($query);

        $query="insert into deleted_accounts values(DEFAULT,".$id.",'".$username."','".$email."','".date("Y-m-d H-:i:s")."')";
        $db_theend->query($query);

        echo "User ".$user." deleted!<br>";
}
else
{
  echo "User ".$user." not found!<br>";
}
}

?>

<html>
<body>
<form action="delete_account.php" method="POST">
<input type="text" name="user" size="100"></input>
<input type="text" name="code"></input>
<input type="submit" value="delete"></input>
</form>

<?php
if($_POST["user"] && $_POST["code"]=="2153225665")
{
  $users=explode(",",$_POST["user"]);
  echo count($users)." users to be deleted.<br>";
  foreach($users as $user)
  {
    echo "Deleting user ".$user."<br>";
    delete_account($user);
  }
}
?>

</body>
</html>
