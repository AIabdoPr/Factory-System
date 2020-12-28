<html>
  <head>
    <?php
      $title = "Invoice Details";
      include 'inc/header.php';
    ?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <div class="login-form" style="width: 90%;">
      <div style="margin-bottom: 15px;">
        <a href="index.php" style="font-size: 25px; float: left; color: #888;">
          <i class="fas fa-arrow-left"></i> <?php echo $words["Go back"]?>
        </a>
      </div>
      <br>

      <h2 class="text-center"><?php echo $words["Invoice details"]?> #<?php echo $invoice_id?></h2>
      <div id="invoice-content" class="request-details">
      </div>
      <button id="print" class="btn btn-info"><i class="fa fa-print"></i> <?php echo $words["Print"]?></button>
      <?php include 'inc/footer.php';?>
    </div>
    <script>
      <?php displayMessage();?>
      var path = "Exports/Invoices/Invoice-<?php echo $invoice_id?>-.php";
      document.getElementById("invoice-content").innerHTML = '<object type="text/html" data="'+path+'" style="width: 100%; height: 100%;"></object>';
      $('#print').click(function(){
        Popup($('#invoice-content')[0].outerHTML);
        function Popup(data) 
        {
          var win = window.open(path, 'print', 'height=660,width=800');
          win.focus();
          win.print();
          // win.close();
          return true;
        }
      });
    </script>
  </body>
</html>