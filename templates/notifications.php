<html>
  <head>
    <?php 
      $title = "Notifications";
      include 'inc/header.php';?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <ul class="list-group" style="border: 1px solid #ddd;">
      <?php 
        foreach($notices as $notice):
      ?>
      <li class="list-group-item" style="padding: 6px; text-align: left;">
        <div class="text-center">
          <h5><?php echo $notice->title;?></h5>
          <p><?php echo $notice->description;?></p>
          <span><?php echo $notice->date;?></span>
        </div>
      </li>
      <?php endforeach;?>
    </ul>
    <script>
      <?php displayMessage();?>
    </script>
  </body>
</html>