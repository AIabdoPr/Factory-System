<?php
  try{
    include_once 'config/init.php';
    $workers = new Workers();
    $workers->Logout($_SESSION["Worker_ID"]);
  }catch(Exception $e) {
    echo $e;
  }

  // Initialize the session
  session_start();

  // Unset all of the session variables
  $_SESSION = array();

  // Destroy the session.
  session_destroy();

  // Redirect to index page
  header("location: index.php");
  exit;
?>