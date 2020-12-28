<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true) {
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === false || !isset($_SESSION["WorkerLogined"])) {

      $workers = new Workers;
      $settings = new SystemSettings;

      if(isset($_POST["signup"])) {
        $error = null;
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $birth_date = $_POST["birth_date"];
        $gander = $_POST["gander"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        if($firstname == "") {
          $error = "The first name has been required";
        }elseif($lastname == "") {
          $error = "The last name has been required";
        }elseif($birth_date == "") {
          $error = "The birth date has been required";
        }elseif($phone == "") {
          $error = "The phone number has been required";
        }elseif($email == "") {
          $error = "The email has been required";
        }elseif($address == "") {
          $error = "The address has been required";
        }elseif($username == "") {
          $error = "The username has been required";
        }elseif($password == "") {
          $error = "The password has been required";
        }elseif($confirm_password == "") {
          $error = "The confirm password has been required";
        }elseif($password != $confirm_password) {
          $error = "The password and confirm password does not matched";
        }
        if(isset($_SESSION["HaveAdmin"]) && $_SESSION["HaveAdmin"] == false) {
          $machines = $_POST["machines"];
          if($machines == "" || $machines == "[]") {
            $error = "The machines has been required";
          }
        }
        /*
        if($_FILES["image_file"]["name"] == "") {
          $error = "The profile image has been required";
        }else {
          $imagetmp = $_FILES['image_file']['tmp_name'];
        }
        */
        if(isset($_FILES['image_file']) && $_FILES['image_file']['name'] != "") {
          $imagetmp = $_FILES['image_file']['tmp_name'];
        }else {
          $error = "The profile image has been required";
        }
        if(!$error) {
          $data = array();
          $data["firstname"] = $firstname;
          $data["lastname"] = $lastname;
          $data["birth_date"] = $birth_date;
          $data["gander"] = $gander;
          $data["phone"] = $phone;
          $data["email"] = $email;
          $data["address"] = $address;
          $data["username"] = $username;
          $data["password"] = $password;
          $data["settings"] = json_encode(array("lang"=> "en"));
          if(isset($_SESSION["HaveAdmin"]) && $_SESSION["HaveAdmin"] == false) {
            $settingsdata = array();
            $settingsdata["machines"] = $machines;
            $settingsdata["phone"] = json_encode($phone);
            $settingsdata["email"] = json_encode($email);
            $settingsdata["address"] = json_encode($address);
          }
          $worker_id = $workers->Signup($data, $_SESSION["HaveAdmin"]);
          if($workers->db->error) {
            $e = $workers->db->error;
            $workers->db->error = "";
            $_SESSION["WorkerLogined"] = false;
            redirect("worker-signup.php", isset($words[$e]) ? $words[$e] : $e, "error");
          }else{
            if(isset($_SESSION["HaveAdmin"]) && $_SESSION["HaveAdmin"] == false) {
              $settings->Add("machines", $settingsdata["machines"]);
              $settings->Add("phone", $settingsdata["phone"]);
              $settings->Add("email", $settingsdata["email"]);
              $settings->Add("address", $settingsdata["address"]);
              if($settings->db->error) {
                $e = $settings->db->error;
                $settings->db->error = "";
                redirect("worker-signup.php", isset($words[$e]) ? $words[$e] : $e, "error");
              }
            }
            $workers->db->error = "";
            $data = $workers->Login($username, $password);
            if($workers->db->error) {
              $e = $workers->db->error;
              $workers->db->error = "";
              $_SESSION["WorkerLogined"] = false;
              redirect("worker-signup.php", isset($words[$e]) ? $words[$e] : $e, "error");
            }else{
              $dirname = "Imports/Workers/Worker-".$data->id."-";
              $filename = $dirname."/image.png";
              if(!is_dir($dirname)) {mkdir($dirname);}
              move_uploaded_file($imagetmp, $filename);
              $_SESSION["Worker_ID"] = $data->id;
              $_SESSION["WorkerLogined"] = true;
              redirect("index.php",
                       $words["Successfully Signup"]."<br>worker id: ".$data->id,
                       "success");
            }
          }
        }else{
          $_SESSION["WorkerLogined"] = false;
          redirect("worker-signup.php", isset($words[$error]) ? $words[$error] : $error, "error");
          // redirect("worker-signup.php", $words[$error], "error");
        }
      }else{
        if($workers->getById('1')) {
          $_SESSION["HaveAdmin"] = true;
        }else{
          $_SESSION["HaveAdmin"] = false;
        }
        $template = new Template('signup.php');
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