<?php
  define("JSON_PATH", "config/data.json");
  define("LANGUAGE_PATH", "config/Languages.json");
  if(!isset($_SESSION["LangDisplay"])){
    $_SESSION["LangDisplay"] = "ar";
  }
  $LangData = json_decode(file_get_contents(LANGUAGE_PATH), true)[$_SESSION["LangDisplay"]];
  $words = $LangData["words"];
  if(file_exists(JSON_PATH)){
    try {
      $str = file_get_contents(JSON_PATH);
      $data = json_decode($str, true);
      $db = new Database($host = $data["DB_HOST"],
                         $user = $data["DB_USER"],
                         $pass = $data["DB_PASS"],
                         $dbname = $data["DB_NAME"]);
      if($db->error){
        $_SESSION["ServerConnected"] = false;
        $_SESSION["WorkerLogined"] = false;
        $_SESSION["message"] = $db->error;
        $_SESSION["message_type"] = "error";
        $db->error = "";
        unlink(JSON_PATH);
      }else{
        define("DB_HOST", $data["DB_HOST"]);
        define("DB_USER", $data["DB_USER"]);
        define("DB_PASS", $data["DB_PASS"]);
        define("DB_NAME", $data["DB_NAME"]);
        define("SITE_TITLE", $data["SITE_TITLE"]);
        $_SESSION["ServerConnected"] = true;
        $cdate = strval(date("Y-m-d", time()));
        if($cdate != $data["CDATE"]){
          $workers = new Workers;
          $workers->Reload();

          $data["CDATE"] = $cdate;
          $file = fopen(JSON_PATH, "w");
          fwrite($file, json_encode($data));
          fclose($file);

          header("location: logout.php");
        }
      }
    }catch (Exception $e){
      $_SESSION["ServerConnected"] = false;
      $_SESSION["WorkerLogined"] = false;
      $_SESSION["message"] = $e;
      $_SESSION["message_type"] = "error";
    }
  }else{
    $_SESSION["ServerConnected"] = false;
    $_SESSION["WorkerLogined"] = false;
  }
?>