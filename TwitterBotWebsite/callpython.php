<?php
    if(isset($_POST['start'])){
        $command = escapeshellcmd('D:\xampp\htdocs\TwitterBot\twitterapp\launch.py');
        $output = shell_exec($command);
        echo $output;
        header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/index.php?');
    }
    if(isset($_POST['stop'])){
        $command = escapeshellcmd('echo "stopped" > D:\xampp\htdocs\TwitterBot\twitterapp\stop.txt ');
        $output = shell_exec($command);
        header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/index.php?');
    }

?>