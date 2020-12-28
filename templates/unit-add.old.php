<html>
  <head>
    <?php
      $title = $words["New unit"];
      include 'inc/header.php';?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <form method="post" action="add_unit.php" class="login-form" novalidate>
      <div style="margin-bottom: 15px;">
        <a href="index.php" style="font-size: 25px; float: left; color: #888;">
          <i class="fas fa-arrow-left"></i> <?php echo $words["Go back"]?>
        </a>
      </div>
      <br>
      <h2 class="text-center"><?php echo $words["Add new unit"]?></h2>

      <div class="form-group">
        <h4 style="text-align:left;"><?php echo $words["Select a requests"]?>:</h4>
        <select name="request" class="form-control">
          <option value="none"><?php echo $words["None"]?></option>
          <?php
          foreach($requests as $request):
            if(!$request->end_production_date):
          ?>
          <option value="<?php echo $request->id?>">
            <?php echo $request->firstname." ".$request->lastname;?>
          </option>
          <?php
            endif;
          endforeach;
          ?>
        </select>
      </div>

      <div class="form-group">
        <h4 style="text-align:left;"><?php echo $words["Weight"]?>:</h4>
        <input type="number" class="form-control" name="weight" value="0" min="0" required>
      </div>

      <div class="form-group">
        <button class="btn btn-primary btn-lg btn-block" name="add_unit">
          <?php echo $words["Add"]?>
        </button>
      </div>
      <?php include 'inc/footer.php';?>
    </form>
    <script>
      <?php displayMessage();?>
    </script>
  </body>
</html>