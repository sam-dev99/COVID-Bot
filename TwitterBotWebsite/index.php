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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link id="pagestyle" rel="stylesheet" href="style.css">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script
  src="https://code.jquery.com/jquery-3.4.1.js"
  integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
  crossorigin="anonymous"></script>

</head>

<style>
        .topnav {
  overflow: hidden;
  background-color: #333;
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
#configbtn{
  float: left;
}
#submit{
  float: left;
}
</style>




<body>

<?php


require_once 'db_include.php';

$conn = OpenCon();
$query = "SELECT * FROM tweet_topic";




echo '<table class="table">
        <thead class="thead-dark">
      <tr>
          <th scope="col"> <font face="Arial">ID</font> </th>
          <th scope="col"> <font face="Arial">Topic</font> </th>
          <th scope="col"> <font face="Arial">Priority</font> </th>
          <th scope="col" style="padding-right:-4em"> <font face="Arial">Counter_flag</font> </th>
          <th scope="col" style="padding-right:20px"> <font face="Arial">Tweet</font> </th>
          <th scope="col" style="padding-left:0px"> <font face="Arial">Author</font> </th>
          <th scope="col" style="padding-left:0px"> <font face="Arial">Delete</font> </th>
      </tr>
      </thead>
      ';

if($conn)
{
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $ID = $row["ID"];
            $TOPIC = $row["topic"];
            $PRIORITY = $row["priority"];
            $FLAG = $row["counter_flag"];
            $TWEET = $row["tweet"];
            $AUTHOR = $row["author"];

            echo '<form action="delete_row.php" method="post"><tr>
                      <td>'.$ID.'</td>
                      <td>'.$TOPIC.'</td>
                      <td>'.$PRIORITY.'</td>
                      <td>'.$FLAG.'</td>
                      <td>'.$TWEET.'</td>
                      <td>'.$AUTHOR.'</td>
                      <td><button type = "submit" class="btn btn-danger" name="ID" value="' . $ID . '"><i class="fa fa-trash">'.'</i></button></td>
                    <tr></form>';
        }
        $result->free();
    }

}

else{
    die("something went wrong:". $conn -> error);
}
?>


<?php
echo '<br style="clear:both" /><br /><form action="update_table.php" method="post">

<div class="form-group">
<label>Topic: </label>
<input type="text" class="form-control" name = "topic" /><br/>
</div>

<div>
  <img  src="images/twitter.png" height="300" width="300" style=" float:right;margin-right:60px">
</div>

<div class="form-group">
<label>Tweet: </label>
<input type="text" class="form-control" name = "tweet" ><br/>
</div>



<div class="form-group">
<label>Priority: </label>
<input type="text" class="form-control" name = "priority" ><br/>
</div>

<div class="form-group">
<label>Counter_flag: </label>
<input type="text" class="form-control" name = "counter_flag" /><br/>
</div>

<div class="form-group">
<label>Author: </label>
<input type="text" class="form-control" name = "author" /><br/>
</div>

<div class="form-group">
  <button type="submit" id="submit"class="btn btn-primary">Submit</button>
</div>
</form>

  <form action="configure.php" method="get">
  <button style="float:left;margin-left:30px;margin-bottom:50px" id="configbtn" action="configure.php" action="get" type="submit" class="btn btn-primary">Configure</button>
  </form>

  <form action="callpython.php" method="post">
  <button style="float:right;margin-right:30px;margin-bottom:50px" name="start" type="submit" class="btn btn-primary">Start</button>
  <button style="float:right;margin-right:30px;margin-bottom:50px" name="stop" type="submit" class="btn btn-primary">Stop</button>
  </form>
';


?>

</body>
</html>
