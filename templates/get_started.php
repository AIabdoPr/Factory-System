<html>
  <head>
    <?php
      $title = $words["Server Conncetion"];
      include 'inc/header.php';
    ?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <div class="login-form">
      <form method="post" action="server_connect.php" novalidate>
        <h2 class="text-center"><?php echo $words["Conncet to server"]?></h2>

        <div class="form-group">
          <h4><?php echo $words["Hostname"]?>:</h4>
          <input type="text" class="form-control" name="hostname" autofocus>
        </div>

        <div class="form-group">
          <h4><?php echo $words["Username"]?>:</h4>
          <input type="text" class="form-control" name="username">
        </div>

        <div class="form-group">
          <h4><?php echo $words["Password"]?>:</h4>
          <input type="password" class="form-control" name="password">
        </div>

        <div class="form-group">
          <h4><?php echo $words["Database"]?>:</h4>
          <input type="text" class="form-control" name="database">
        </div>

        <div class="form-group">
          <h4><?php echo $words["Site title"]?>:</h4>
          <input type="text" class="form-control" name="site_title" value="<?php echo SITE_TITLE;?>">
        </div>

        <button class="btn btn-primary btn-lg btn-block" name="get_started"><?php echo $words["Connect"]?></button>
        <?php include 'inc/footer.php';?>
      </form>
    </div>
    <script>
      <?php displayMessage();?>
    </script>
  </body>
</html>