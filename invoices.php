<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){

      $invoice_id = isset($_GET["id"]) ? $_GET["id"] : null;
      if($invoice_id){
        $template = new Template("invoice.php");
        $template->words = $words;
        $template->invoice_id = $invoice_id;
        echo $template;
      }else{
        redirect("index.php", $words["You need invoice id, Please check and try agin"], "error");
      }
    }else{
      redirect("index.php", $words["You need login for continue"], "error");
    }
  }else{
    redirect("server_connect.php", $words["You need connect to server for continue"], "error");
  }
?>