<html>
  <head>
    <?php 
      $title = "Messages";
      include 'inc/header.php';
      
    ?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/chat.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties topright"></div>
    <div id="chat">
      <ul id="messages" class="list-group">
      </ul>
      <div id="message-enter" class="hide">
        <textarea id="message-text" placeholder="<?php echo $words["Type the message here..."];?>" oninput="input_message()" autofocus></textarea>
        <button id="send-message" class="btn" onclick="send_message()" disabled>
          <i class="fas fa-location-arrow"></i>
        </button>
      </div>
    </div>
    <script>
      <?php displayMessage();?>

      // When the worker clicks anywhere outside of the calculator_el, close it
      document.onclick = function(event) {
        if (event.target.className != ("fas fa-cog" || "btn btn-anage")) {
          document.getElementById("manage-message").className = "list-group hide";
        }
      }

      var msgs = "";
      var max_count = "";
      function load_messages(count) {
        $.ajax({
          url: "manage-messages.php",
          method: "POST",
          data: {"load_messages": true,
                 "count": count
          },
          success: function(data) {
            if(msgs != data) {
              msgs = data;
              data += '<div id="manage-message" class="hide list-group">'+
                      '  <div id="message-edit-btn" class="btn"><?php echo $words["Update"]?></div>'+
                      '  <div id="message-remove-btn" class="btn"><?php echo $words["Remove"]?></div>'+
                      '</div>'
              $("#messages").html(data);
              messages_el = document.getElementById("messages");
              messages_el.scrollTop = messages_el.scrollHeight;
            }
          },
        });
      }

      function get_message_text(clear = false) {
        var el = $("#message-enter textarea");
        var message_text = el.val();
        if(clear) {
          el.val("");
        }
        return message_text;
      }

      function input_message() {
        if(get_message_text()) {
          document.getElementById("send-message").disabled = false;
        }else {
          document.getElementById("send-message").disabled = true;
        }
      }

      function send_message() {
        message_text = get_message_text(true);
        $.ajax({
          url: "manage-messages.php",
          method: "POST",
          datatype: "json",
          data: {"add_message": true,
                 "message": message_text
          },
          success: function(data) {
            if(data[0] == false) {
              createNoty(data[1], "danger");
            }
          }
        });
        document.getElementById("send-message").disabled = true;
      }

      setInterval(
        function() {
          load_messages(max_count);
        },
        800
      );

      function manage_message(element, id) {
        manage_el = document.getElementById("manage-message");
        manage_el.className = "show";
        // chat_el_detials = getOffset(document.getElementById("chat"));
        manage_el_detials = getOffset(manage_el);
        element_detials = getOffset(element);
        x = element_detials.left-manage_el_detials.width+element_detials.width;
        y = element_detials.top+element_detials.height;
        // x = element_detials.left-manage_el_detials.width;
        // y = element_detials.top-element_detials.height-chat_el_detials.height;
        manage_el.style.top = y;
        manage_el.style.left = x;
        document.getElementById("message-remove-btn").onclick = function(){removeMessage(id);}
      }
      
      function removeMessage(id) {
        $.ajax({
          url: "manage-messages.php",
          method: "POST",
          data: {"remove_message": true,
                 "message_id": id
          },
          success: function(data) {
            if(data[0] == false){
              createNoty(data[1], "danger");
            }
          },
        });
      }
    </script>
  </body>
</html>