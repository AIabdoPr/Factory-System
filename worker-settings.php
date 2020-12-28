<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){

      $workers = new Workers;
      $worker = $workers->getById($_SESSION["Worker_ID"]);
      $worker->settings = json_decode($worker->settings);
      
      $requests = new Requests();
      $settings = new SystemSettings();
      $machines = json_decode($settings->getByName("machines"));

      if(isset($_POST["update_settings"])){
        $error = null;
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $birth_date = $_POST["birth_date"];
        $gander = $_POST["gander"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];
        $language = $_POST["language"];
        if($firstname == ""){
          $error = "The first name has been required";
        }elseif($lastname == ""){
          $error = "The last name has been required";
        }elseif($birth_date == ""){
          $error = "The birth date has been required";
        }elseif($phone == ""){
          $error = "The phone number has been required";
        }elseif($email == ""){
          $error = "The email has been required";
        }elseif($address == ""){
          $error = "The address has been required";
        }elseif($current_password != ""){
          if(md5($current_password) != $worker->password){
            $error = "The current password is incorrect";
          }elseif($new_password == ""){
            $error = "The new password has been required";
          }elseif($confirm_password == ""){
            $error = "The confirm password has been required";
          }elseif($new_password != $confirm_password){
            $error = "The new password and confirm password does not matched";
          }
        }elseif($new_password || $confirm_password){
          $error = "The current password has been required";
        }
        if($_SESSION["Worker_ID"] == 1){
          $machines = $_POST["machines"];
          if($machines == "" || $machines == "[]"){
            $error = "The machines has been required";
          }
        }
        if(!$error){
          $data = array();
          $data["firstname"] = $firstname;
          $data["lastname"] = $lastname;
          $data["birth_date"] = $birth_date;
          $data["gander"] = $gander;
          $data["phone"] = $phone;
          $data["email"] = $email;
          $data["address"] = $address;
          $_SESSION["LangDisplay"] = $language;
          $worker->settings->lang = $language;
          $data["settings"] = json_encode($worker->settings);
          $data["password"] = $new_password;
          if($_SESSION["Worker_ID"] == 1){
            $settingsdata = array();
            $settingsdata["machines"] = $machines;
            $settingsdata["phone"] = json_encode($phone);
            $settingsdata["email"] = json_encode($email);
            $settingsdata["address"] = json_encode($address);
          }
          if(isset($_FILES["image_file"]) && $_FILES["image_file"]["name"] != "") {
            $dirname = "Imports/Workers/Worker-".$worker->id."-";
            $filename = $dirname."/image.png";
            if(!is_dir($dirname)){mkdir($dirname);}
            if(file_exists($filename)){unlink($filename);}
            move_uploaded_file($_FILES['image_file']['tmp_name'], $filename);
          }
          $workers->Update($data, $_SESSION["Worker_ID"]);
          if($workers->db->error){
            $e = $workers->db->error;
            $workers->db->error = "";
            redirect("worker-settings.php", isset($words[$e]) ? $words[$e] : $e, "error");
          }elseif($_SESSION["Worker_ID"] == 1){
            $settings->Update("machines", $settingsdata["machines"]);
            $settings->Update("phone", $settingsdata["phone"]);
            $settings->Update("email", $settingsdata["email"]);
            $settings->Update("address", $settingsdata["address"]);
            if($settings->db->error){
              $e = $settings->db->error;
              $settings->db->error = "";
              redirect("worker-settings.php", isset($words[$e]) ? $words[$e] : $e, "error");
            }else{
              redirect("index.php", $words["Successfully updating settings"], "success");
            }
          }else{
            redirect("index.php", $words["Successfully updating settings"], "success");
          }
        }else{
          redirect("worker-settings.php", $words[$error], "error");
        }
      }else{
        $template = new Template('settings.php');
        if($_SESSION["Worker_ID"] == 1){
          $template->machines = $machines;
        }
        $template->worker = $worker;
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