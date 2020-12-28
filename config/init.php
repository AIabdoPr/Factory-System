<?php
  // Start Session
  session_start();

  // Config file
  require_once 'config.php';

  // Include Helpers
  require_once 'lib/helpers.php';

  // Auto Loader
  require_once('lib/template.php');
  function __autoload($class_name){
    require_once 'lib/'.$class_name.'.php';
  }
?>