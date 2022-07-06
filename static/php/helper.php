<?php

function check_is_login()
{
    session_start();
    if (empty($_SESSION["username"]))
    {
        header("Location: ./401.html");
        exit;
    }
    
}
?>