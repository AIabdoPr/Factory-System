<html>
  <head>
    <?php
      $title = $words["Settings"];
      include 'inc/header.php';
    ?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <form class="login-form" method="post" action="worker-settings.php" enctype="multipart/form-data">
      <div style="margin-bottom: 15px;">
        <a href="index.php" style="font-size: 25px; float: left; color: #888;">
          <i class="fas fa-arrow-left"></i> <?php echo $words["Go back"]?>
        </a>
      </div>
      <br>

      <h2 class="text-center"><?php echo $words["Update Settings"]?></h2>

      <div class="form-group">
        <img src="Imports/Workers/Worker-<?php echo $worker->id?>-/Image.png?v=<?php echo time();?>"
             style="border-radius: 50%; width: 150px; height: 150px;">
        <h4 style="text-align: center; margin-bottom: -4px;"><?php echo $worker->firstname." ".$worker->lastname?></h4>
        <p style="text-align: center;">@<?php echo $worker->username;?></p>
      </div>

      <div class="form-group">
        <h4><?php echo $words["First name"]?>:</h4>
        <input type="text" class="form-control" name="firstname" value="<?php echo $worker->firstname?>"  autofocus>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Last name"]?>:</h4>
        <input type="text" class="form-control" name="lastname" value="<?php echo $worker->lastname?>">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Birth date"]?>:</h4>
        <input type="date" class="form-control" name="birth_date" value="<?php echo $worker->birth_date?>">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Gander"]?>:</h4>
        <select class="form-control" name="gander">
          <option value="Male" <?php if($worker->gander == "Male"){echo "selected";}?>>
            <?php echo $words["Male"]?>
          </option>
          <option value="Female" <?php if($worker->gander == "Female"){echo "selected";}?>>
            <?php echo $words["Female"]?>
          </option>
        </select>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Phone"]?>:</h4>
        <input type="phone" class="form-control" name="phone" value="<?php echo $worker->phone?>">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Email"]?>:</h4>
        <input type="email" class="form-control" name="email" value="<?php echo $worker->email?>">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Address"]?>:</h4>
        <input type="address" class="form-control" name="address" value="<?php echo $worker->address?>">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Username"]?>:</h4>
        <input type="text" class="form-control" name="username"  value="<?php echo $worker->username?>" disabled>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Current password"]?>:</h4>
        <input type="password" class="form-control" name="current_password">
      </div>

      <div class="form-group">
        <h4><?php echo $words["New password"]?>:</h4>
        <input type="password" class="form-control" name="new_password">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Confirm password"]?>:</h4>
        <input type="password" class="form-control" name="confirm_password">
      </div>

      <?php if($_SESSION["Worker_ID"] == 1):?>
 
      <div style="display: grid; grid-template-columns: auto auto; grid-gap: 5px;">
        <input type="text" class="form-control machine" placeholder="<?php echo $words["Machine"]?>">
        <span type="button" id="add-item" class="btn btn-primary">
          <?php echo $words["Add"]?>
        </span>
      </div>
      <ul id="todolist-items" class="list-group" style="overflow: auto; height: 102px; border: 1px solid #ddd; margin: 5px 0;">
      </ul>
      <h5><?php echo $words["Total items"]?>: <span class="count-items"></span></h5>
      <textarea class="form-control machines" name="machines" style="display: none;"></textarea>

      <script>
        $("#todolist-items").sortable();
        $("#todolist-items").disableSelection();

        <?php foreach($machines as $machine):?>
        create_item("<?php echo $machine?>");
        <?php endforeach;?>
        countTodos();

        //create todo
        function create_item(machine) {
          if(machine != ''){
            var machine = machine;
            createTodo(machine);
            countTodos();
          }else{
            createNoty('<?php echo $words["Please enter the machine name"]?>', "danger");
          }
        }

        // add item btn
        $("#add-item").click(function(){
          create_item($('.machine').val());
        });

        // count tasks
        function countTodos(){
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
        function createTodo(machine){
          var todolist_items = new Array();
          const machines = document.querySelectorAll('#todolist-items li #machine-name');
          for (let i = 0; i <= machines.length - 1; i++) {
            todolist_items.push(machines[i].innerHTML);
          }
          if(todolist_items.indexOf(machine) === -1){
            var markup = '<li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 4px; text-align: left;">'+
                           '<span id="machine-name" style="width: 95%; overflow-wrap: break-word; padding: 0 5px;">'+machine+'</span>'+
                           '<button type="button" class=" close" onclick="removeItem(this)" style="width: 5%; padding: 0 5px;">'+
                             '<span aria-hidden="true">&times;</span>'+
                           '</button>'+
                         '</li>';
            $('#todolist-items').append(markup);
            $('.machine').val('');
          }else{
            createNoty('<?php echo $words["The Item already exists"]?>', "danger");
          }
        }

        //remove task from list
        function removeItem(element){
          $(element).parent().remove();
          countTodos();
        }
      </script>

      <?php endif;?>

      <div class="form-group">
        <h4><?php echo $words["Language"]?>:</h4>
        <select class="form-control" name="language">
          <option value="en" <?php if($_SESSION["LangDisplay"] == "en"){echo "selected";}?>>
            English
          </option>
          <option value="ar" <?php if($_SESSION["LangDisplay"] == "ar"){echo "selected";}?>>
            Arabic
          </option>
        </select>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Profile image"]?>:</h4>
        <input type="file" class="form-control" name="image_file" accept=".jpg, .png, .jpeg" onchange="check_for_file(this)">
      </div>

      <br>
      <button class="btn btn-primary btn-lg btn-block" name="update_settings">
        <?php echo $words["Update"]?>
      </button>
      <?php include 'inc/footer.php';?>
    </form>
    <script>
      <?php displayMessage();?>
      function check_for_file(el){
        if(el.value.indexOf(".png") == -1 && el.value.indexOf(".jpg") == -1 && el.value.indexOf(".jpeg") == -1){
          createNoty("<?php echo $words['Please select file with .png .jpg extension']?>", "danger")
          el.value = "";
        }
      }
    </script>
  </body>
</html>