<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){

      $notifications = new SystemNotifications;
      $notices = $notifications->getAll();

      $template = new Template('notifications.php');
      $template->notices = $notices;
      echo $template;
    }else{
      redirect("index.php", "You need login for continue", "error");
    }
  }else{
    redirect("server_connect.php", "You need connect to server for continue", "error");
  }
?>