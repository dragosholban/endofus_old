<?php
        include 'database.php';
        include 'functions.php';

        $db=new DataBase_theend();
        $db->connect();

        $datetime=getdate();

        if ($_GET["id"])
        {
                if ($_GET["user_code"])
                {
                        $query="select * from newusers where id=".$_GET["id"]." and code=".$_GET["user_code"];
                        $db->query($query);
                        if ($db->num_rows())
                        {
                                $db->next_record();
                                $query="insert into users values(DEFAULT, '".$db->Record["username"]."', '".md5($db->Record["password"])."', '".$db->Record["email"]."','".$db->Record["race"]."','".date("Y-m-d H:i:s")."',0,0,0,0,0,DEFAULT)";
                                $race=$db->Record["race"];
                                $db->query($query);

                                $query="select LAST_INSERT_ID() as id from users";
                                $db->query($query);
                                $db->next_record();
                                $id=$db->Record["id"];

                                $query="insert into armory values (".$id.",0,0,0,10,10,0,0,0,20,'1000-01-01 00:00:00',0,0,0,0,0,100,'".date("Y-m-d H:i:s")."',0,0,0,0,0,0,0,0,0)";
                                $db->query($query);
                                $query="insert into semafor values(".$id.",0,'')";
                                $db->query($query);
                                $query="insert into online values(".$id.",0,'".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."',0,0)";
                                $db->query($query);
                                $query="insert into user_profile values(".$id.",'','','','')";
                                $db->query($query);
                                $query="insert into seif values(".$id.",20000,10000000,NOW())";
                                $db->query($query);
                                $query="insert into upgrades values(".$id.",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0)";
                                $db->query($query);
                                $query="insert into mastery values(".$id.",0,0)";
                                $db->query($query);
                                $query="insert into top_active_users values(".$id.",0,0)";
                                $db->query($query);
                                $query="insert into actions values(".$id.",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)";
                                $db->query($query);                                

                                $query="delete from newusers where id=".$_GET["id"]." and code=".$_GET["user_code"];
                                $db->query($query);

                                js_alert("Account activated.\\nYou can now login and play.");
                                echo "<script>window.location='index.php';</script>";
                        }
                        else
                        {
                                js_alert("Registration expired.\\nPlease make another account and register it earlier.");
                                echo "<script>window.location='index.php';</script>";
                        }
                }
                else
                        echo "<script>window.location='index.php';</script>";
        }
        else
                echo "<script>window.location='index.php';</script>";
?>
