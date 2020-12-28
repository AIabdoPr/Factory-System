<?php
  include_once 'config/init.php';
  $workers = new Workers;

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === false || !isset($_SESSION["WorkerLogined"])){
      if(isset($_POST["login"])){
        $error = "";
        $username = $_POST["username"];
        $password = $_POST["password"];
        if($username == ""){
          "The username has been required";
        }elseif($password == ""){
          "The password has been required";
        }
        if(!$error){
          $workers->db->error = "";
          $data = $workers->Login($username, $password);
          if($workers->db->error){
            $e = $workers->db->error;
            $workers->db->error = "";
            $_SESSION["WorkerLogined"] = false;
            $e = isset($words[$e]) ? $words[$e] : $e;
            redirect("worker-login.php", $e, "error");
          }else{
            $_SESSION["LangDisplay"] = json_decode($data->settings)->lang;
            $_SESSION["Worker_ID"] = $data->id;
            $_SESSION["WorkerLogined"] = true;
            redirect("index.php", $words["Successfully Login"], "success");
          }
        }else{
          $_SESSION["WorkerLogined"] = false;
          redirect("worker-login.php", $words[$error], "error");
        }
      }else{
        $template = new Template('login.php');
        $template->words = $words;
        echo $template;
      }
    }else{
      redirect("index.php", $words["You are already logined"], "error");
    }
  }else{
    header('Location: server_connect.php');
    exit;
  }
?>