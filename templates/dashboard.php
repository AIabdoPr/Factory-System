<html>
  <head>
    <?php
      if($show == "dashboard") {$title = $words["Dashboard"];}
      elseif($show == "workers") {$title = $words["Workers"];}
      elseif($show == "requests") {$title = $words["Requests"];}
      elseif($show == "stock") {$title = $words["Stock"];}
      include 'inc/header.php';
    ?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/include/dashboard/dashboard.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties bottomright"></div>
    <div class="wrapper">
      <div class="top_navbar">
       <div class="logo">
          <a href="index.php">Control Panel</a>
        </div>
        <div class="top_menu">
          <div style="height: 60px;
                      float: left;">
          </div>
          <div class="right_info">
            <div class="icon_wrap" onclick="document.getElementById('calculator-modal').style.display='block'">
              <div class="icon">
                <i class="fas fa-calculator"></i>
              </div>
            </div>

            <!--
            <div id="settings-menu" class="icon_wrap" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="icon">
                <i class="fas fa-cog"></i>
              </div>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="settings-menu">
                <ul class="menu-list">
                  <li class="btn menu-list-item">Language</li>
                  <li class="btn menu-list-item">Update Detials</li>
                </ul>
              </div>
            </div>
            -->

            <a class="icon_wrap" href="worker-settings.php">
              <div class="icon">
                <i class="fas fa-cog"></i>
              </div>
            </a>

            <a class="icon_wrap" href="logout.php">
              <div class="icon">
                <i class="fas fa-sign-out-alt"></i>
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="main_body">
        <div class="sidebar_menu">
          <div class="inner__sidebar_menu">
            <ul>
              <li>
                <a href="index.php?show=dashboard" class="<?php if($show == "dashboard") {echo("active");}?>">
                    <i class="fas fa-chart-line"></i></span>
                  <span>
                  <span class="list"><?php echo $words["Dashboard"];?></span>
                </a>
              </li>
              <li>
                <a href="index.php?show=workers" class="<?php if($show == "workers") {echo("active");}?>">
                  <!--<span class="icon"><i class="fas fa-hard-hat"></i></span>-->
                  <span class="icon"><i class="fas fa-people-carry"></i><i class="fal fa-hard-hat"></i></span>
                  <span class="list"><?php echo $words["Workers"];?></span>
                </a>
              </li>
              <li>
                <a href="index.php?show=requests" class="<?php if($show == "requests") {echo("active");}?>">
                  <span class="icon"><i class="fas fa-clipboard-check"></i></span>
                  <span class="list"><?php echo $words["Requests"];?></span>
                </a>
              </li>
              <li>
                <a href="index.php?show=stock" class="<?php if($show == "stock") {echo("active");}?>">
                  <span class="icon"><i class="fas fa-warehouse"></i></span>
                  <span class="list"><?php echo $words["Stock"];?></span>
                </a>
              </li>
            </ul>
            <div class="hamburger">
              <div class="inner_hamburger">
                  <span class="arrow">
                      <i class="fas fa-long-arrow-alt-left"></i>
                      <i class="fas fa-long-arrow-alt-right" style="display: none;"></i>
                  </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="details-front">
      </div>

    </div>
    <script src="Data/include/dashboard/dashboard.js?v=<?php echo time();?>"></script>
    <script>
      <?php displayMessage();?>
      var show = '<?php echo $show;?>';
      const units = new UnitsControl(show);
      units.load_units();
      setInterval(
        function() {
          //Load_detials();
        },
        800
      );
    </script>
  </body>
</html>