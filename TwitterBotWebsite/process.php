<?php
session_start();

require_once 'db_include.php';

// if(isset($_POST['login'])) echo "working"; else die("go fuck yourself!!!"); 

if(isset($_POST['login']))
{
    if(empty($_POST['username']) || empty($_POST['password']))
    {
        header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/login.php?Empty= Please fill in the username and password.');
    }
    else{
        //open connection
        $conn = OpenCon();
        if($conn)
        {
            $user = $conn->real_escape_string($_POST['username']);
            $pass = $conn->real_escape_string($_POST['password']);

            $query = "SELECT * FROM users WHERE username = '" . $user . "' and password = '" . $pass . "'" ;

            $result = $conn->query($query);

            if($row = $result->fetch_assoc())
            {
                $S_user = $row['username'];
                $S_pass = $row['password'];

                $_SESSION['S_user'] = $S_user;
                
                $conn->close();
                header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/index.php?');
            }
            else{
                header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/login.php?Invalid=The username or password were incorrect.');
            }
        }
    }
}
else{
    die("Not Working!!");
}


?>