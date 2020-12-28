<html>
  <head>
    <?php
      $title = "Welcome";
      include 'inc/header.php';?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <div class="login-form">
      <h1><?php echo $words["Welcome"]?></h1>
      <a class="btn btn-primary btn-lg btn-block" style="color: #fff;" href="worker-login.php">
        <?php echo $words["Login"]?>
      </a>
      <a class="btn btn-primary btn-lg btn-block" style="color: #fff;" href="worker-signup.php">
        <?php echo $words["Signup"]?>
      </a>
      <?php include 'inc/footer.php';?>
    </div>
    <script>
      <?php displayMessage();?>
    </script>
  </body>
</html>