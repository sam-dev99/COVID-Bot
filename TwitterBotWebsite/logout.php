<?php 
    session_start();
    if(isset($_GET['logout']))
    {
        session_destroy();
        header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/login.php');
    }
    else{
        header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/index.php');
    }
?>