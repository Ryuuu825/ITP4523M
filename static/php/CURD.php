<?php 
    include_once("../php/conn.php");
    include_once("../php/helper.php");
    
    check_is_login();

    $conn = get_db_connection();

    function GETALL($table)
    {
        global $conn;
        $sql = "SELECT * FROM $table";
        $result = mysqli_query($conn, $sql);
        $rows = array();
        while ($row = mysqli_fetch_assoc($result))
        {
            $rows[] = $row;
        }
        return $rows;
    }

    function GET($table, $id)
    {
        global $conn;
        $sql = "SELECT * FROM $table WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function DELETE($table, $id)
    {
        global $conn;
        $sql = "DELETE FROM $table WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        return $result;
    }


?>