<?php
session_start();

if(! isset($_SESSION['S_user']))
{
    header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/login.php?End_Session=Your Session has ended, please login again to enter...');
}
else{
    require_once "db_include.php";
            
    $conn = OpenCon();
            
    if($conn)
    {
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);
        
        $query = "insert into configurations(Name,Description) values('$name','$description')";
        
        $conn->query($query);
        
        $conn->close();
        
        header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/configure.php?');
    }
}
?>