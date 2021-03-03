<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="utf-8">
    <title>Login Form</title>
  </head>
  <body>
    
    <div class="loginbox">

      <img src="images/logo.png" class="logo">
      <h1>Login Here</h1>

      <form action="process.php" method="post">
        <p>Username</p>
        <input type="text" name="username" placeholder="Enter Username">
        <p>Password</p>
        <input type="password" name="password" placeholder="Enter Password">
        <button type="submit" name='login' class="btn btn-primary">Login</button>
      </form>

      <?php
      //check if empty parameters were given
        if(@$_GET['Empty'] == true)
      {
      ?>
        <div style="top: 30px" class="alert alert-danger" role="alert"><?php echo $_GET['Empty'] ?></div>
      <?php 
        }
      
      ?>

      
      <?php
      //check if invalid users
        if(@$_GET['Invalid'] == true)
      {
      ?>
        <div style="top: 30px" class="alert alert-danger" role="alert"><?php echo $_GET['Invalid'] ?></div>
      <?php 
        }
      ?>
    </div>



  </body>
</html>