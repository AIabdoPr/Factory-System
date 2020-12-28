<?php
  // Redirect To Page
  function redirect($page = false, $message = null, $message_type = null){
    if(is_string($page)){
      $location = $page;
    }else{
      $location = $_SREVER["SCRIPT_NAME"];
    }

    // Check For Message
    if($message != null){
      // Set Message
      $_SESSION["message"] = $message;
    }
    // Check For Message Type
    if($message_type != null){
      // Set Message Type
      $_SESSION["message_type"] = $message_type;
    }

    // Redirect
    header("Location: ".$location);
    exit();
  }

  function displayMessage(){
    if(!empty($_SESSION["message"])){
      // Assign Message Var
      $message = $_SESSION["message"];
      $message_type = $_SESSION["message_type"];
      // Create Output
      if($message_type == "error"){/*
        echo '<script>$(".alert").alert()</script>
              <div class="alert alert-danger alert-dismissible" style="width: 100%;">
                <a class="close" data-dismiss="alert" aria-label="Close">&times;</a>
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                '.$message.'
              </div>';*/
        echo 'createNoty("'.$message.'", "danger");';
      }else{
        /*
        echo '<script>$(".alert").alert()</script>
              <div class="alert alert-success alert-dismissible" style="width: 100%;">
                <a class="close" data-dismiss="alert" aria-label="Close">&times;</a>
                <i class="glyphicon glyphicon-exclamation-sign"></i>
                '.$message.'
              </div>';*/
        echo 'createNoty("'.$message.'", "success");';
      }

      // Unset Message
      unset($_SESSION["message"]);
      unset($_SESSION["message_type"]);
    }else{
      echo "";
    }
  }
?>