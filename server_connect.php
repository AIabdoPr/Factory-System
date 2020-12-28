<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === false){
    if(isset($_POST["get_started"])){
      $error = null;
      $hostname = $_POST["hostname"];
      $username = $_POST["username"];
      $password = $_POST["password"];
      $database = $_POST["database"];
      $site_title = $_POST["site_title"];
      if($hostname == ""){
        $error = "The hostname has been required";
      }elseif($username == ""){
        $error = "The username has been required";
      }elseif($database == ""){
        $error = "The database has been required";
      }elseif($site_title == ""){
        $error = "The site title has been required";
      }
      if(!$error){
        $data = array();
        $data["DB_HOST"] = $hostname;
        $data["DB_USER"] = $username;
        $data["DB_PASS"] = $password;
        $data["DB_NAME"] = $database;
        $data["SITE_TITLE"] = $site_title;
        $data["CDATE"] = strval(date("Y-m-d", time()));
        $db = new Database($hostname, $username, $password, "");
        if($db->error){
          $e = $db->error;
          $db->error = "";
          redirect("server_connect.php", $e, "error");
        }else{
          $db->query("CREATE DATABASE IF NOT EXISTS $database");
          $db->execute();
          $db = new Database($hostname, $username, $password, $database);
          if($db->error){
            $e = $db->error;
            $db->error = "";
            redirect("server_connect.php", $e, "error");
          }
          $db->import_file("config/db_install.sql");
          if($db->error){
            $e = $db->error;
            $db->error = "";
            redirect("server_connect.php", $e, "error");
          }else{
            $file = fopen(JSON_PATH, "w");
            fwrite($file, json_encode($data));
            fclose($file);
            define("DB_HOST", $data["DB_HOST"]);
            define("DB_USER", $data["DB_USER"]);
            define("DB_PASS", $data["DB_PASS"]);
            define("DB_NAME", $data["DB_NAME"]);
            define("SITE_TITLE", $data["SITE_TITLE"]);
            $_SESSION["WorkerLogined"] = false;
            redirect("worker-signup.php", $words["Successfully connecting to server"], "success");
          }
        }
      }else{
        redirect("server_connect.php", $words[$error], "error");
      }
    }else{
      define("SITE_TITLE", "Factory System");
      $template = new Template('get_started.php');
      $template->words = $words;
      echo($template);
    }
  }else{
    redirect("index.php", $words["The server already connected"], "error");
  }
?>