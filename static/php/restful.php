<?php

    include_once("CURD.php");
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
    {
        // get the id and table name from the url
        $id = $_GET['id'];
        $table = $_GET['table'];
        // delete the record
        DELETE($table, $id);
    }
?>