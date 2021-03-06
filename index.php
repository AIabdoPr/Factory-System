<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){
      $workers = new Workers();
      $requests = new Requests();
      $units = new Units();
      $template = new Template('dashboard.php');
      $template->words = $words;
      $template->show = isset($_GET["show"]) ? $_GET["show"] : "dashboard";
      $template->requests = $requests->getAll();
      $template->workers = $workers->getAll();
      $template->today_units = $units->getToday();
      $template->units = $units->getAll();/*
      $template = str_replace(array("--lang--", "--dir--"),
                              array($_SESSION["LangDisplay"], $LangData["dir"]),
                              $template);*/
      echo($template);
    }else{
      $template = new Template('welcome.php');
      $template->words = $words;
      echo($template);
    }
  }else{
    header('Location: server_connect.php');
    exit;
  }
?>