<html>
  <head>
    <?php
      $title = $words["Signup"];
      include 'inc/header.php';?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <form class="login-form" method="post" action="worker-signup.php" enctype="multipart/form-data">
      <div style="margin-bottom: 15px;">
        <a href="index.php" style="font-size: 25px; float: left; color: #888;">
          <i class="fas fa-arrow-left"></i> <?php echo $words["Go back"]?>
        </a>
      </div>
      <br>

      <h2 class="text-center"><?php echo $words["Signup"]?></h2>

      <div class="form-group">
        <h4><?php echo $words["First name"]?>:</h4>
        <input type="text" class="form-control" name="firstname" value="" autofocus>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Last name"]?>:</h4>
        <input type="text" class="form-control" name="lastname" value="">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Birth date"]?>:</h4>
        <input type="date" class="form-control" name="birth_date" value="">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Gander"]?>:</h4>
        <select name="gander" class="form-control">
          <option value="Male"><?php echo $words["Male"]?></option>
          <option value="Female"><?php echo $words["Female"]?></option>
        </select>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Phone"]?>:</h4>
        <input type="phone" class="form-control" name="phone" value="">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Email"]?>:</h4>
        <input type="email" class="form-control" name="email" value="">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Address"]?>:</h4>
        <input type="address" class="form-control" name="address" value="">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Username"]?>:</h4>
        <input type="text" class="form-control" name="username" value="">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Password"]?>:</h4>
        <input type="password" class="form-control" name="password" value="">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Confirm password"]?>:</h4>
        <input type="password" class="form-control" name="confirm_password" value="">
      </div>

      <?php if(isset($_SESSION["HaveAdmin"]) && $_SESSION["HaveAdmin"] == false):?>
 
      <h4><?php echo $words["Machines"]?>:</h4>
      <div style="display: grid; grid-template-columns: auto auto; grid-gap: 5px;">
        <input type="text" class="form-control machine" placeholder="<?php echo $words["Machine"]?>">
        <span id="add-item" class="btn btn-primary"><?php echo $words["Add"]?></span>
      </div>
      <ul id="todolist-items" class="list-group" style="overflow: auto; height: 102px; border: 1px solid #ddd; margin: 5px 0;">
      </ul>
      <h5><?php echo $words["Total items"]?>: <span class="count-items"></span></h5>
      <textarea class="form-control machines" name="machines" style="display: none;"></textarea>

      <script>
        $("#todolist-items").sortable();
        $("#todolist-items").disableSelection();

        count_machines();

        // add item btn
        $("#add-item").click(function(){
          add_machine($('.machine').val());
        });

        // count tasks
        function count_machines(){
          var count = $("#todolist-items li").length;
          $('.count-items').html(count);
          var items = new Array();
          const machines_names = document.querySelectorAll('#todolist-items li #machine-name');
          for (let i = 0; i <= machines_names.length - 1; i++) {
            items.push(machines_names[i].innerHTML);
          }
          $('.machines').val(JSON.stringify(items));
        }

        //create task
        function add_machine(machine){
          if(machine != ''){
            var todolist_items = new Array();
            const machines = document.querySelectorAll('#todolist-items li #machine-name');
            for (let i = 0; i <= machines.length - 1; i++) {
              todolist_items.push(machines[i].innerHTML);
            }
            if(todolist_items.indexOf(machine) === -1){
              var markup = '<li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 4px; text-align: left;">'+
                             '<span id="machine-name" style="width: 95%; overflow-wrap: break-word; padding: 0 5px;">'+machine+'</span>'+
                             '<button type="button" id="remove-item" class=" close" onclick="remove_machine(this)" style="width: 5%; padding: 0 5px;">'+
                               '<span aria-hidden="true">&times;</span>'+
                             '</button>'+
                           '</li>';
              $('#todolist-items').append(markup);
              $('.machine').val('');
              count_machines();
            }else{
              createNoty('<?php echo $words["The Item already exists"]?>', "danger");
            }
          }else{
              createNoty('<?php echo $words["Please enter the machine name"]?>', "danger");
          }
        }

        //remove task from list
        function remove_machine(element){
          $(element).parent().remove();
          count_machines();
        }
      </script>
      <?php endif;?>

      <div class="form-group">
        <h4><?php echo $words["Profile image"]?>:</h4>
        <input type="file" class="form-control" name="image_file" accept=".jpg, .png, .jpeg" onchange="check_for_file(this)">
      </div>

      <br>
      <button class="btn btn-primary btn-lg btn-block" name="signup"><?php echo $words["Signup"]?></button>
      <?php include 'inc/footer.php';?>
    </form>
    <script>
      <?php displayMessage();?>
      function check_for_file(el){
        if(el.value.indexOf(".png") == -1 && el.value.indexOf(".jpg") == -1){
          createNoty("<?php echo $words['Please select file with .png .jpg extension']?>", "danger")
          el.value = "";
        }
      }
    </script>
  </body>
</html>