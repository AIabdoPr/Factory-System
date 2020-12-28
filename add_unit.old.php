<?php
  include_once 'config/init.php';
  $units = new Units();

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){
      if(isset($_POST["add_unit"])){
        $error = null;
        $request = $_POST["request"];
        $weight = $_POST["weight"];
        if($request == "" || $request == "none"){
          $error = "The requests has been required";
        }elseif($weight == "" || $weight == 0){
          $error = "The weight has been required";
        }
        if(!$error){
          $data = array();
          $data["request"] = $request;
          $data["weight"] = $weight;
          $data["worker_id"] = $_SESSION["Worker_ID"];
          $units->Add($data);
          if($units->db->error){
            $e = $units->db->error;
            $units->db->error = "";
            redirect("add_unit.php", isset($words[$e]) ? $words[$e] : $e, "error");
          }else{
            redirect("index.php", $words["Successfully adding the unit"], "success");
          }
        }else{
          redirect("add_unit.php", $words[$error], "error");
        }
      }else{
        $template = new Template('unit-add.php');
        $requests = new Requests();
        $template->requests = $requests->getAll();
        $template->words = $words;
        if($units->db->error){
          $e = $units->db->error;
          redirect(null, $e, "error");
          $units->db->error = "";
        }
        echo $template;
      }
    }else{
      redirect("index.php", $words["You need login for continue"], "error");
    }
  }else{
    redirect("server_connect.php", $words["You need connect to server for continue"], "error");
  }
?>