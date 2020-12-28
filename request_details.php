<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){

      $request_id = isset($_GET["id"]) ? $_GET["id"] : null;
      if($request_id){
        $requests = new Requests();
        $settings = new SystemSettings();

        if(isset($_POST["update"])){
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
            $requests->Update($data, $request_id);
            if($requests->db->error){
              $e = $requests->db->error;
              $requests->db->error = "";
              redirect("request_details.php?id=$request_id",
                       isset($words[$e]) ? $words[$e] : $e,
                       "error");
            }else{
              redirect("index.php", $words["Successfully updating the request details"], "success");
            }
          }else{
            redirect("request_details.php?id=$request_id", $words[$error], "error");
          }
        }else{
          $template = new Template('request-details.php');
          $request = $requests->getById($request_id);
          if($request){
            $template->words = $words;
            $template->request = $request;
            $template->machines = json_decode($settings->getByName("machines"));
            echo $template;
          }else{
            redirect("index.php", $words["An error occurred when loading the request details, Please check and try again"], "error");
            // $e = $requests->db->error;
            // $requests->db->error = "";
            // redirect("index.php", $e, "error");
          }
        }
      }else{
        redirect("index.php", $words["You need request id, Please check and try again"], "error");
      }
    }else{
      redirect("index.php", $words["You need login for continue"], "error");
    }
  }else{
    redirect("server_connect.php", $words["You need connect to server for continue"], "error");
  }
?>