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
    <div class="login-form">
      <div style="margin-bottom: 15px;">
        <a href="index.php" style="font-size: 25px; float: left; color: #888;">
          <i class="fas fa-arrow-left"></i> <?php echo $words["Go back"]?>
        </a>
      </div>
      <br>
      <h2 class="text-center"><?php echo $words["Add new unit"]?></h2>

      <div class="form-group">
        <h4><?php echo $words["Select a requests"]?>:</h4>
        <select id="request" class="form-control">
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

      <div class="form-group" style="display: grid; 
                                     grid-template-columns: auto min-content;
                                     grid-gap: 5px;">
        <input type="number" class="form-control" id="weight-enter" oninput="input_weight()" placeholder="<?php echo $words["Weight"]?>" min="0">
        <button class="btn btn-primary btn-lg btn-block" id="add-unit-btn" onclick="add_unit()" disabled>
          <?php echo $words["Add"]?>
        </button>
      </div>

      <?php include 'inc/footer.php';?>
    </div>
    <script>
      <?php displayMessage();?>

      function get_weight(clear = false) {
        var el = $("#weight-enter");
        var weight = el.val();
        if(clear) {
          el.val("");
        }
        return weight;
      }

      function input_weight() {
        v = get_weight();
        if(v && v != 0) {
          document.getElementById("add-unit-btn").disabled = false;
        }else {
          document.getElementById("add-unit-btn").disabled = true;
        }
      }

      function add_unit(){
        weight = get_weight(true);
        request_id = $("#request").val();
        $.ajax({
          url: "manage-units.php",
          method: "POST",
          dataType: 'json',
          data: {"add_unit": true,
                 "request_id": request_id,
                 "weight": weight,
          },
          success: function(data) {
            if(data[0] == false) {
              createNoty(data[1], "danger");
            }else {
              createNoty(data[1], "success");
            }
            document.getElementById("add-unit-btn").disabled = true;
          }
        });
      }
    </script>
  </body>
</html>