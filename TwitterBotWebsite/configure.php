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
<title>Configuration</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript">
$('.load-modal').on('click', function(e){
    e.preventDefault();
    $('#AddConfig').modal('show');
});
</script>
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
</style>
<body>
  <?php 
    require_once "db_include.php";

    $conn = OpenCon();

    if($conn)
    {
      $query = "SELECT * FROM configurations";
      $result = $conn->query($query);
      
      echo '    <table class="table">
                <thead class="thead-dark">
                  <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Configure</th>
                  </tr>
                </thead>';

      if($result){
        while($row = $result->fetch_assoc()){
          $id = $row['ID'];
          $name = $row['Name'];
          $description = $row['Description'];
          
          
         echo '
                
                <form action="configFile.php" method="get">
                  <tr>
                    <td>' . $name . '</td>
                    <td>' . $description . '</td>
                    <td hidden><input hidden name="id" value="' . $id . '">
                    <td><button type="submit">configure</button><td>
                  </tr>
                  </form>';
        }
      }
    }
  ?>
  
<div class="modal fade" id="orangeModalSubscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-warning" role="document">
    <!--Content-->
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header text-center">
        <h4 class="modal-title white-text w-100 font-weight-bold py-2">Add Configuration</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="white-text">&times;</span>
        </button>
      </div>

      <!--Body-->
      
      <div class="modal-body">
        <form role="form" method="POST" action="addConfiguration.php">
                    <input type="hidden" name="_token" value="">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="name" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Description</label>
                        <div>
                            <input type="text" class="form-control input-lg" name="description">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <button type="submit" class="btn btn-success">Add</button>
                        </div>
                    </div>
        </form>
      </div>
      
      
    </div>
    <!--/.Content-->
  </div>
</div>

<div class="text-center">
  <a href="" style="position:absolute;margin-top:600px;margin-left:500px;background-color:	#1E90FF;color: #FFFFFF" class="btn btn-default btn-rounded" data-toggle="modal" data-target="#orangeModalSubscription">Add Configuration</a>
</div>
  




</body>
</html>