<?php
  include_once 'config/init.php';
  $units = new Units();

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){
      $template = new Template('unit-add.php');
      $requests = new Requests();
      $template->requests = $requests->getAll();
      $template->words = $words;
      echo $template;
    }else{
      redirect("index.php", $words["You need login for continue"], "error");
    }
  }else{
    redirect("server_connect.php", $words["You need connect to server for continue"], "error");
  }
?>