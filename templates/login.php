<html>
  <head>
    <?php 
      $title = $words["Login"];
      include 'inc/header.php';
    ?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <form method="post" action="worker-login.php" class="login-form" novalidate>
      <div style="margin-bottom: 15px;">
        <a href="index.php" style="font-size: 25px; float: left; color: #888;">
          <i class="fas fa-arrow-left"></i> <?php echo $words["Go back"]?>
        </a>
      </div>
      <br>

      <h2 class="text-center"><?php echo $words["Login"]?></h2>

      <div class="form-group">
        <h4><?php echo $words["Username"]?>:</h4>
        <input type="text" class="form-control" name="username" required>
      </div>

      <div class="form-group">
        <h4 style="text-align:left;"><?php echo $words["Password"]?>:</h4>
        <input type="password" class="form-control" name="password" required>
      </div>

      <input type="submit" class="btn btn-primary btn-lg btn-block" value="<?php echo $words["Login"]?>" name="login"/>
      <?php include 'inc/footer.php';?>
    </form>
    <script>
      <?php displayMessage();?>
    </script>
  </body>
</html>