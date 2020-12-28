<?php
  class SystemSettings{
    public $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Get All SystemSettings
    public function getAll(){
      $this->db->query("SELECT * FROM settings");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Get Setting by name
    public function getByName($name){
      $this->db->query("SELECT * FROM settings WHERE name=:name;");
      $this->db->bind(":name", $name);
      // Assign Resualt Set
      return $this->db->single()->vals;
    }

    // Add Setting
    public function Add($name, $vals){
      if($this->getByName($name)){
        $this->db->error = "You have already used this name";
        return false;
      }
      // Insert Query
      $this->db->query("INSERT INTO `settings` (`name`, `vals`) VALUES (:name, :vals);");
      // Bind Data
      $this->db->bind(":name", $name);
      $this->db->bind(":vals", $vals);
      // Execute
      $this->db->execute();
    }

    // Update Setting
    public function Update($name, $vals){
      // Insert Query
      $this->db->query("UPDATE `settings` SET `vals`=:vals WHERE `name`=:name;");
      // Bind Data
      $this->db->bind(":name", $name);
      $this->db->bind(":vals", $vals);
      // Execute
      $this->db->execute();
    }
  }
?>