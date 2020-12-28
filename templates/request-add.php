<html>
  <head>
    <?php
      $title = $words["New request"];
      include 'inc/header.php';
    ?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/include/dashboard/dashboard.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <form id="add-new-request" method="post" action="add_request.php" class="login-form" novalidate>
      <div style="margin-bottom: 15px;">
        <a href="index.php" style="font-size: 25px; float: left; color: #888;">
          <i class="fas fa-arrow-left"></i> <?php echo $words["Go back"]?>
        </a>
      </div>
      <br>
      <h2 class="text-center"><?php echo $words["Add new request"]?></h2>

      <div class="form-group">
        <h4><?php echo $words["Client first name"]?>:</h4>
        <input type="text" class="form-control" name="firstname" autofocus>
      </div>

      <div class="form-group">
        <h4><?php echo $words["Client last name"]?>:</h4>
        <input type="text" class="form-control" name="lastname">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Phone"]?>:</h4>
        <input type="phone" class="form-control" name="phone">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Email"]?>:</h4>
        <input type="email" class="form-control" name="email">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Address"]?>:</h4>
        <input type="address" class="form-control" name="address">
      </div>

      <div class="form-group">
        <h4><?php echo $words["Machine"]?>:</h4>
        <select name="machine" class="form-control">
          <option value="none"><?php echo $words["None"]?></option>
          <?php foreach($machines as $machine):?>
          <option value="<?php echo $machine?>"><?php echo $machine?></option>
          <?php endforeach;?>
        </select>
      </div>

      <h4><?php echo $words["Threads"]?>:</h4>
      <div style="display: grid; grid-template-columns: auto auto auto; grid-gap: 5px;">
        <input type="text" class="form-control thread" placeholder="<?php echo $words["Thread"]?>">
        <input type="number" class="form-control thread-weight"
               placeholder="<?php echo $words["Weight (Kg)"]?>">
        <span id="add-item" class="btn btn-primary"><?php echo $words["Add"]?></span>
      </div>
      <br>
      <ul id="todolist-items" class="list-group" style="overflow: auto; height: 102px; border: 1px solid #ddd;">
      </ul>
      <br>
      <h5>
        <?php echo $words["Total items"]?>: <span class="count-items"></span>
      </h5>
      <h5>
        <?php echo $words["Total weight"]?>: <span class="total-weight"></span> <?php echo $words["Kg"]?>
      </h5>
      <script>
        <?php displayMessage();?>
        $("#todolist-items").sortable();
        $("#todolist-items").disableSelection();

        countTodos();

        //create todo
        function create_item(thread, weight) {
          if(thread != ''){
            if(weight != 0){
              var thread = thread;
              var weight = weight;
              createTodo(thread, weight); 
              countTodos();
            }else{
              createNoty('<?php echo $words["The weight has been required"]?>', 'danger');
            }
          }else{
            createNoty('<?php echo $words["The thread has been required"]?>', 'danger');
          }
        }

        // add item btn
        $("#add-item").click(function(){
          create_item($('.thread').val(), $('.thread-weight').val());
        });

        // count tasks
        function countTodos(){
          var items = new Array();
          var count = $("#todolist-items li").length;
          $('.count-items').html(count);
          const threads = document.querySelectorAll('#thread-name');
          const threads_weight = document.querySelectorAll('#thread-weight');
          var total_weight = 0;
          for (let i = 0; i <= threads_weight.length - 1; i++) {
            total_weight += parseFloat(threads_weight[i].innerHTML);
            items.push([threads[i].innerHTML, parseFloat(threads_weight[i].innerHTML)]);
          }
          $('.total-weight').html(total_weight);
          $('.threads').val(JSON.stringify(items));
        }

        //create task
        function createTodo(thread, weight){
          var todolist_items = new Array();
          const threads = document.querySelectorAll('#todolist-items li #thread-name');
          for (let i = 0; i <= threads.length - 1; i++) {
            todolist_items.push(threads[i].innerHTML);
          }
          if(todolist_items.indexOf(thread) === -1){
            var markup = '<li class="list-group-item d-flex justify-content-between align-items-center" style="padding: 4px; text-align: left;">'+
                           '<span id="thread-name" style="width: 55%; overflow-wrap: break-word; padding: 0 5px;">'+thread+'</span>'+
                           '<span style="width: 40%; overflow-wrap: break-word; padding: 0 5px;">'+
                             '<span id="thread-weight">'+weight+'</span> <?php echo $words["Kg"]?>'+
                           '</span>'+
                           '<button id="remove-item" class="close" onclick="removeItem(this)" style="width: 5%; padding: 0 5px;">'+
                             '<span aria-hidden="true">&times;</span>'+
                           '</button>'+
                         '</li>';
            $('#todolist-items').append(markup);
            $('.thread').val('');
            $('.thread-weight').val('');
          }else{
            createNoty('<?php echo $words["The Item already exists"]?>', 'danger');
          }
        }

        //remove task from list
        function removeItem(element){
          $(element).parent().remove();
          countTodos();
        }
      </script>

      <textarea class="form-control threads" name="threads" style="display: none;"></textarea>

      <div class="form-group">
        <h4><?php echo $words["Price"]?>:</h4>
        <input type="number" class="form-control" name="price">
      </div>

      <div class="form-group">
        <button class="btn btn-primary btn-lg btn-block" name="add_request">
          <?php echo $words["Start production"]?>
        </button>
      </div>
      <?php include 'inc/footer.php';?>
    </form>
  </body>
</html>