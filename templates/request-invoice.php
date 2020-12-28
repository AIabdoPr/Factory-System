<html>
  <head>
    <?php
      $title = "Invoicing";
      include 'inc/header.php';
    ?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <form method="post" action="invoicing_requests.php?id=<?php echo $request->id;?>"  class="login-form" style="width: 90%;">
      <div style="margin-bottom: 15px;">
        <a href="index.php" style="font-size: 25px; float: left; color: #888;">
          <i class="fas fa-arrow-left"></i> <?php echo $words["Go back"]?>
        </a>
      </div>
      <br>

      <h2 class="text-center"><?php echo $words["Invoicing request"]?></h2>
      <div class="form-group">
        <h4><?php echo $words["Request ID"]?>:</h4>
        <input type="text" class="form-control" value="<?php echo $request->id;?>" disabled>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Client full name"]?>:</h4>
        <input type="text" class="form-control" value="<?php echo $request->firstname." ".$request->lastname;?>" disabled>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Requesting date"]?>:</h4>
        <input type="text" class="form-control" value="<?php echo $request->requesting_date;?>" disabled>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Machine used"]?>:</h4>
        <input type="text" class="form-control" value="<?php echo $request->machine;?>" disabled>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Threads"]?>:</h4>
        <ul class="list-group" style="overflow: auto; height: 102px; max-width: 100%; min-width: 100%; resize: both; border: 1px solid #ddd; margin: 5px 0;">
          <?php
            $threads = json_decode($request->threads);
            $thread_weight = 0;
            foreach($threads as $thread):
              $thread_weight += $thread[1];
          ?>
          <li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 4px; text-align: left;">
            <?php echo $thread[0].": ".$thread[1]." ".$words["Kg"];?>
          </li>
          <?php endforeach;?>
        </ul>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Threads weight"]?>:</h4>
        <input type="text" class="form-control" value="<?php echo $thread_weight;?>" disabled>
      </div>

      <div class="form-group">
        <div style="display: grid; grid-template-columns: auto auto; grid-gap: 5px;">
          <h4 style="text-align: center;"><?php echo $words["Current units"]?>:</h4>
          <h4 style="text-align: center;"><?php echo $words["Invoicing units"]?>:</h4>
          <ul class="list-group" id="current-units" style="max-height: 400px;
                                                           min-height: 50px;
                                                           overflow-y: scroll;
                                                           border: 1px solid #ddd;">
            <?php foreach($units as $unit):?>
            <li class="list-group-item" style="padding: 2px;display: grid; grid-template-columns: 49% 2% 49%;" onclick="add_unit(this)">
              <span id="id"><?php echo $unit->id;?></span>
              <span>|</span>
              <span>
                <span id="weight"><?php echo $unit->unit_weight;?></span> <?php echo $words["Kg"]?>
              </span>
            </li>
            <?php endforeach?>
          </ul>
          <ul class="list-group" id="Invoicing-units" style="max-height: 400px;
                                                              min-height: 50px;
                                                              overflow-y: scroll;
                                                              border: 1px solid #ddd;">
          </ul>
        </div>
      </div>
      <textarea class="form-control hide" id="units-ids" name="units-ids"></textarea>
      <input type="number" class="form-control hide" id="units-number" name="units_number">
      <input type="float" class="form-control hide" id="total-weight" name="weight">

      <div class="form-group">
        <h4><?php echo $words["Amount"]?>:</h4>
        <input type="number" class="form-control" id="amount" name="amount">
      </div>

      <div class="form-group">
        <input type="checkbox" name="end_product" value="true">
          <span style="font-size: 18px;"><?php echo $words["End production"]?></span>
        </input>
      </div>

      <button class="btn btn-primary btn-lg btn-block" name="invoice">
        <?php echo $words["Invoice"]?>
      </button>

      <?php include 'inc/footer.php';?>
    </form>
    <script>
      <?php displayMessage();?>
      var price = <?php echo $request->price;?>;

      function add_unit(element){
        var id = element.querySelector("#id").innerHTML;
        var weight = element.querySelector("#weight").innerHTML;
        element.remove();
        var item = '<li class="list-group-item" style="padding: 2px;display: grid; grid-template-columns: 49% 2% 49%;" onclick="remove_unit(this)">'+
                   '  <span id="id">'+id+'</span>'+
                   '  <span>|</span>'+
                   '  <span><span id="weight">'+weight+'</span> <?php echo $words["Kg"]?></span>'+
                   '</li>'
        $('#Invoicing-units').append(item);
        count_units();
      }

      function remove_unit(element){
        var id = element.querySelector("#id").innerHTML;
        var weight = element.querySelector("#weight").innerHTML;
        element.remove();
        var item = '<li class="list-group-item" style="padding: 2px;display: grid; grid-template-columns: 49% 2% 49%;" onclick="add_unit(this)">'+
                   '  <span id="id">'+id+'</span>'+
                   '  <span>|</span>'+
                   '  <span><span id="weight">'+weight+'</span> <?php echo $words["Kg"]?></span>'+
                   '</li>'
        $('#current-units').append(item);
        count_units();
      }

      function count_units(){
        var el = document.getElementById("Invoicing-units");
        var ids = el.querySelectorAll("#id");
        var weights = el.querySelectorAll("#weight");
        var count = ids.length;
        var data = [];
        var total_weight = 0;
        for(var i=0; i<count; i++) {
          var id = ids[i].innerHTML;
          var weight = weights[i].innerHTML;
          data.push(id);
          total_weight += parseFloat(weight);
        }
        $("#units-number").val(count);
        $("#total-weight").val(total_weight);
        $("#amount").val(total_weight*price);
        $("#units-ids").val(JSON.stringify(data));
      }
      count_units();
    </script>
  </body>
</html>