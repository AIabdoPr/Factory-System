<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){

      $requests = new Requests();
      $settings = new SystemSettings();

      if(isset($_POST["add_request"])){
        $error = null;
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $machine = $_POST["machine"];
        $threads = $_POST["threads"];
        $price = $_POST["price"];
        if($firstname == ""){
          $error = "The first name has been required";
        }elseif($lastname == ""){
          $error = "The last name has been required";
        }elseif($phone == ""){
          $error = "The phone has been required";
        }elseif($email == ""){
          $error = "The email has been required";
        }elseif($address == ""){
          $error = "The address has been required";
        }elseif($machine == "" || $machine == "none"){
          $error = "The machine has been required ";
        }elseif($threads == "" || $threads == "[]"){
          $error = "The threads has been required";
        }elseif($price == ""){
          $error = "The price has been required";
        }
        if(!$error){
          $data = array();
          $data["firstname"] = $firstname;
          $data["lastname"] = $lastname;
          $data["phone"] = $phone;
          $data["email"] = $email;
          $data["address"] = $address;
          $data["machine"] = $machine;
          $data["threads"] = $threads;
          $data["price"] = $price;
          $requests->Add($data);
          if($requests->db->error){
            $e = $requests->db->error;
            $requests->db->error = "";
            redirect("add_request.php", isset($words[$e]) ? $words[$e] : $e, "error");
          }else{
            redirect("index.php", $words["Successfully entring the request"], "success");
          }
        }else{
          redirect("add_request.php", $words[$error], "error");
        }
      }else{
        $template = new Template('request-add.php');
        $template->words = $words;
        $template->machines = json_decode($settings->getByName("machines"));
        if($requests->db->error){
          $e = $requests->db->error;
          redirect(null, $e, "error");
          $requests->db->error = "";
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