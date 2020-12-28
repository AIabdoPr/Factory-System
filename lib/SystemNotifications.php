<?php
  class SystemNotifications{
    public $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Get All Notifications
    public function getAll(){
      $this->db->query("SELECT * FROM notifications;");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Get Notification by id
    public function getById($id, $as="all"){
      $this->db->query("SELECT * FROM notifications WHERE id=$id;");
      // Assign Resualt Set
      if($as == "all"){
        return $this->db->resualtSet();
      }else{
        return $this->db->single();
      }
    }

    // Get Today Notifications
    public function getToday(){
      $this->db->query("SELECT * FROM notifications WHERE DATE(`date`)=CURDATE();");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Add notification
    public function Add($data){
      // Insert The Notification
      $this->db->query("INSERT INTO `notifications` (`title`, `description`)
                        VALUES (:title, :description);");
      $this->db->bind(":title", $data["title"]);
      $this->db->bind(":description", $data["description"]);
      $this->db->execute();
    }
  }
?>