<?php

header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/index.php');

require_once 'db_include.php';

$conn = OpenCon();

if($conn)
{
   $topic = $conn->real_escape_string($_POST['topic']);
   $tweet = $conn->real_escape_string($_POST['tweet']); 
   $priority = $conn->real_escape_string($_POST['priority']); 
   $author = $conn->real_escape_string($_POST['author']);
   $flag = $conn->real_escape_string($_POST['counter_flag']);   

   if($topic != null && 
      $tweet != null &&
      $priority != null &&
      $author != null &&
      $flag != null)
      {
        $query = "INSERT INTO tweet_topic (topic,priority,counter_flag,tweet,author) 
        VALUES ('{$topic}','{$priority}','{$flag}','{$tweet}','{$author}')";

        $conn->query($query);
      }


    CloseCon($conn);
}
exit;


?>