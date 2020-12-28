<?php
  class WorkersMessages{
    public $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Get All Messages
    public function getAll($count = ""){
      $query = "SELECT messages.*,
                               workers.firstname,
                               workers.lastname
                        FROM messages
                        INNER JOIN workers ON messages.`worker_id` = workers.id";
      if($count){
        $query .= " LIMIT $count";
      }
      $this->db->query($query);
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Get Today Messages
    public function getToday(){
      $this->db->query("SELECT * FROM messages WHERE DATE(`date`)=CURDATE();");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Add Message
    public function Add($data){
      // Insert The Message
      $query = "INSERT INTO `messages` (`worker_id`, `message`)
                        VALUES (".$data["worker_id"].", '".$data["message"]."');";
      $this->db->query($query);
      /*
      $this->db->query("INSERT INTO `messages` (`worker_id`, `message`)
                        VALUES (:worker_id, :message);");
      $this->db->bind(":worker_id ", $data["worker_id"], );
      $this->db->bind(":message", $data["message"]);
      */
      $this->db->execute();
    }
    
    // Remove Message
    function removeMessage($mesgid){
      $this->db->query("DELETE FROM `messages` WHERE id=$mesgid;");
      $this->db->execute();
    }
  }
?>