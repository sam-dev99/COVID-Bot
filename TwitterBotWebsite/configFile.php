<?php
session_start();

if(isset($_SESSION['S_user']))
{
          echo '<div class="topnav">
              <a class="active" href="index.php">' .$_SESSION['S_user'] . '</a>
              <a href="logout.php?logout">Logout</a>
          </div>';
}
else{
    header('Location: http://'. $_SERVER['HTTP_HOST'] . '/TwitterBot/login.php?End_Session=Your Session has ended, please login again to enter...');
}

?>

<html>
    <head>
        <title>Config</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
                    .topnav {
  overflow: hidden;
  background-color: #333;
}
body{
  background-color: #E0E0E0;
}
.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}
#submitconfig{
  margin-left: 20px;
  width: 80px;
}
input[type=checkbox]{
  margin-left: 20px;
}
label{
  font-weight: bold;
  margin-top: 5px;
  display: inline-block;
  width: 250px;
  margin-left: 20px;
  padding: 5px;
}
input[type=input]{
  padding: 2px;
  width: 250px;
  border: solid #000
}
input[type=radio]{
  margin-left: 20px;
}
#configimg{
  width: 500px;
  height: 500px;
  float: right;
  margin-right: 100px;
  margin-top: -20;

}
#topic{
  width: 250px;
  border: solid #000;

}

</style>
</head>

    <body>
        <?php
            require_once "db_include.php";

            $conn = OpenCon();

            if($conn)
            {
                $mainID = $conn->real_escape_string($_GET['id']);
                $query = "select * from fileconfig f where f.config_ID = " . $mainID . "";

                $result = $conn->query($query);

                if (mysqli_num_rows($result)==0)
                {
                    //create new configuration.

                    $query = "insert into fileconfig(config_ID) values($mainID)";

                    $add = $conn->query($query);

                   $URL="configFile.php?id=" . $mainID;
                    echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';

                    // $conn-close();


                }

                if($result)
                {
                    while($row = $result->fetch_assoc())
                    {
                        $ID = $row['ID'];

                        if($row['title']) $title = $row['title'];
                        else $title = NULL;

                        if($row['topic']) $topic = $row['topic'];
                        else $topic = NULL;

                        if($row['hashtag']) $hashtag = $row['hashtag'];
                        else $hashtag = NULL;

                        if($row['customized']) $custom = $row['customized'];
                        else $custom = NULL;

                        if($row['tweetsperconfig']) $tweets_per_config = $row['tweetsperconfig'];
                        else $tweets_per_config = 0;

                        if($row['tweetsperhour']) $tweets_per_hour = $row['tweetsperhour'];
                        else $tweets_per_hour = 0;

                        if($row['random']) $random = $row['random'];
                        else $random = 0;

                        if($row['incremental']) $incremental = $row['incremental'];
                        else $incremental = 0;

                        if($row['decremental']) $decremental = $row['decremental'];
                        else $decremental = 0;

                        if($row['deploy']) $deploy = $row['deploy'];
                        else $deploy = 0;


                        echo '<div id="configure" ><form action="applyConfiguration.php" method="post">
                          <img src="images/config.png" id="configimg" alt="">
                            <label>Title:</label>
                            <input type="input"   name="title" value=' . $title . '><br>

                            <label>Topic:</label>
                            <select id="topic" name="topic">
                            <option value="">' . $row['topic'] . '</option>';
                             

                            $topic_query = "select distinct topic from tweet_topic";
                            $get_topics = $conn->query($topic_query);

                            if($get_topics)
                            {
                                while($topic = $get_topics->fetch_assoc())
                                {
                                    echo '<option value="' . $topic['topic'] . '">' . $topic['topic'] . '</option>';
                                }
                            }
                           

                            echo ' <option value=""></option></select><br>

                            <label>Hashtag of the day:</label>
                            <input type="input" name="hashtag" value=' . $hashtag . '><br>

                            <label>Custom priority:</label>
                            <input type="input" name="custom" value=' . $custom . '><br>

                            <label>Tweets per configuration:</label>
                            <input type="input" name="tweetsperconfig" value=' . $tweets_per_config . '><br>

                            <label>Tweets Frequency:</label>
                            <input type="input" name="tweetsperhour" value=' . $tweets_per_hour . '><br>

                            <input type="radio" name="priority" '; if($random) echo 'checked'; echo ' value="random">
                            <label>Random</label>

                            <br>
                              <input type="radio" name="priority" '; if($incremental) echo 'checked'; echo ' value="incremental">
                            <label>Incremental</label>
                            <br>

                            <input type="radio" name="priority" '; if($decremental) echo 'checked'; echo ' value="decremental">
                            <label >Decremental</label>

                            <br>
                            <input type="checkbox" name="deploy[]" '; if($deploy) echo 'checked'; echo ' value=' . $deploy .'>
                            <label>Deploy</label>


                            <input hidden name="id" value="' . $ID . '">
                            <br>
                            <br>

                            <input type="submit" name="Apply" value="Apply" class="btn btn-primary" id="submitconfig">
                        </form></div>';


                    }
                }
            }

        ?>

    </body>
</html>
