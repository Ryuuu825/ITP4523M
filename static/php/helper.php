<?php

function check_is_login()
{
    session_start();
    if (empty($_SESSION["username"]))
    {
        header("Location: ../index.php");
        exit;
    }
    
}
?>