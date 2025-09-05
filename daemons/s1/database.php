<?php
class DataBaseMySQL
{
    // connection properties
    var $Host = "";
    var $DataBase = "";
    var $User = "";
    var $Password = "";

    var $Link_ID = null;   // mysqli connection
    var $Query_ID = null;  // mysqli result
    var $Record = array(); // current record
    var $Row;              // current row number
    var $Errno = 0;
    var $Error = "";

    // stop on fatal error
    function halt($msg)
    {
        printf("<p><b>MySQL error!</b></p>\n");
        die("Session halted: " . $msg);
    }

    // connect to database
    function connect()
    {
        if ($this->Link_ID == null) {
            $this->Link_ID = new mysqli($this->Host, $this->User, $this->Password, $this->DataBase);

            if ($this->Link_ID->connect_error) {
                $this->halt("Connect failed: " . $this->Link_ID->connect_error);
            }
        }
    }

    // run a query
    function query($query_str)
    {
        $this->connect();

        $this->Query_ID = $this->Link_ID->query($query_str);
        $this->Row = 0;

        if (!$this->Query_ID) {
            $this->Errno = $this->Link_ID->errno;
            $this->Error = $this->Link_ID->error;
            $this->halt("Invalid SQL: " . $query_str);
        }

        return $this->Query_ID;
    }

    // fetch next record
    function next_record()
    {
        if ($this->Query_ID) {
            $this->Record = $this->Query_ID->fetch_assoc();
            $this->Row++;

            if (!$this->Record) {
                $this->Query_ID->free();
                $this->Query_ID = null;
                return false;
            }
            return true;
        }
        return false;
    }

    // move to a specific row
    function seek($pos)
    {
        if ($this->Query_ID) {
            $this->Query_ID->data_seek($pos);
            $this->Row = $pos;
        }
    }

    // number of rows
    function num_rows()
    {
        return ($this->Query_ID) ? $this->Query_ID->num_rows : 0;
    }

    // number of fields
    function num_fields()
    {
        return ($this->Query_ID) ? $this->Query_ID->field_count : 0;
    }

    // get field value
    function get_field($field)
    {
        return isset($this->Record[$field]) ? $this->Record[$field] : null;
    }

    function sql_quote($str)
    {
        $this->connect();
        return $this->Link_ID->real_escape_string($str);
    }
}

class DataBase_theend extends DataBaseMySQL
{
    var $Host = "localhost";
    var $User = "endofus";
    var $Password = "Avioane13!";
    var $DataBase = "endofus";
}

class DataBase_s2 extends DataBaseMySQL
{
    var $Host = "localhost";
    var $User = "ens_ens15";
    var $Password = "parolaens15";
    var $DataBase = "ens_s2";
}