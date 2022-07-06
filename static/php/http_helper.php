<?php
function redirect($url)
{
    header('Location: '.$url);
    exit();
};

// function not_found()
// {
//     header('Location: http://".$_SERVER['HTTP_HOST']."/pages/404.html');
//     exit();
// }

// function unauthorized()
// {
//     header('Location: http://".$_SERVER['HTTP_HOST']."/index.php');
//     exit();
// }
?>