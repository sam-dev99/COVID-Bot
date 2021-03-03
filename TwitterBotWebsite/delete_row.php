<?php
header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/index.php');

require_once 'db_include.php';

$conn = OpenCon();

if($conn)
{
    if(isset($_POST['ID']))
    {
        $query = "DELETE FROM tweet_topic WHERE id=" . $conn->real_escape_string($_POST['ID']);
        $conn->query($query);

        CloseCon($conn);
    }

}

exit;
?>