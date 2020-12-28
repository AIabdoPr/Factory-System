<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){

      $request_id = isset($_GET["id"]) ? $_GET["id"] : null;
      $invoices = new Invoices();
      $requests = new Requests();
      $units = new Units();
      $settings = new SystemSettings();
      
      if(isset($_POST["invoice"])){
        $error = null;
        $units_ids = $_POST["units-ids"];
        $units_number = $_POST["units_number"];
        $weight = $_POST["weight"];
        $amount = $_POST["amount"];
        $end_product = isset($_POST["end_product"]) ? $_POST["end_product"] : false;
        if($units_ids == "" || $units_ids == "[]"){
          $error = "Please select the units you want invoice it";
        }
        if(!$error){
          $data = array();
          $data["request_id"] = $request_id;
          $data["worker_id"] = $_SESSION["Worker_ID"];
          $data["units_number"] = $units_number;
          $data["weight"] = $weight;
          $data["amount"] = $amount;
          $invoice_id = $invoices->Add($data);
          if($invoices->db->error){
            $_SESSION["message"] = $words["An error occurred when adding the invoice, Please chech and try again"];
            $_SESSION["message_type"] = "error";
          }else{
            $units->invoiceUnits($units_ids, $request_id);
            if($end_product == "true"){
              $requests->endProduct($request_id);
            }
            $invoices->exportHTML($invoice_id);
            if($invoices->db->error){
              $_SESSION["message"] = $words["An error occurred when exporting the invoice, Please check and try again"];
              $_SESSION["message_type"] = "error";
            }else{
              redirect("invoices.php?id=$invoice_id", $words["Successfully invoicing"], "success");
            }
          }
        }else{
          $_SESSION["message"] = $words[$error];
          $_SESSION["message_type"] = "error";
        }
      }
      if($request_id){
        $template = new Template('request-invoice.php');
        $request = $requests->getById($request_id);

        if($requests->db->error or !$request){
          redirect("index.php",
                   $words["The id number does not exists, please check and try again"],
                   "error");
        }
        $template->words = $words;
        $template->request = $request;
        $template->units = $requests->getCurrentUnits($request_id);
        echo $template;
      }else{
        redirect("index.php", $words["You need request id, please check and try again"], "error");
      }
    }else{
      redirect("index.php", $words["You need login for continue"], "error");
    }
  }else{
    redirect("server_connect.php", $words["You need connect to server for continue"], "error");
  }
?>