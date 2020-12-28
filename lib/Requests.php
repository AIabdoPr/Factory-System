<?php
  class Requests{
    public $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Get All Requests
    public function getAll(){
      $this->db->query("SELECT * FROM requests");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Get Request by id
    public function getById($id){
      $this->db->query("SELECT * FROM requests WHERE id=$id;");
      // Assign Resualt Set
      return $this->db->single();
    }

    // Get Request units by id
    public function getAllUnits($id){
      $this->db->query("SELECT * FROM units WHERE request_id=$id;");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Get Request units by id
    public function getCurrentUnits($id){
      $this->db->query("SELECT * FROM `units` WHERE `request_id`=$id and `invoice_date` IS NULL;");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Add Request
    public function Add($data){
      $this->db->query("SELECT * FROM requests
                        WHERE firstname=:firstname and lastname=:lastname
                        ORDER BY `requesting_date` DESC
                        LIMIT 1;");
      $this->db->bind(":firstname", $data["firstname"]);
      $this->db->bind(":lastname", $data["lastname"]);
      $res = $this->db->single();
      if($res){
        if(!$res->end_production_date){
          $this->db->error = "You have already request";
          return false;
        }
      }
      // Insert Query
      $this->db->query("INSERT INTO `requests` (`firstname`, `lastname`, `phone`, 
                                               `email`, `address`, `machine`, `threads`, `price`)
                        VALUES (:firstname, :lastname, :phone,
                                :email, :address, :machine, :threads, :price);");
      // Bind Data
      $this->db->bind(":firstname", $data["firstname"]);
      $this->db->bind(":lastname", $data["lastname"]);
      $this->db->bind(":phone", $data["phone"]);
      $this->db->bind(":email", $data["email"]);
      $this->db->bind(":address", $data["address"]);
      $this->db->bind(":machine", $data["machine"]);
      $this->db->bind(":threads", $data["threads"]);
      $this->db->bind(":price", $data["price"]);
      // Execute
      $this->db->execute();
    }

    // Update Request
    public function Update($data, $id){
      // Insert Query
      $this->db->query("UPDATE `requests` SET 
                        `firstname`=:firstname,
                        `lastname`=:lastname,
                        `phone`=:phone,
                        `email`=:email,
                        `address`=:address,
                        `machine`=:machine,
                        `threads`=:threads,
                        `price`=:price
                      WHERE `id`=$id;");
      // Bind Data
      $this->db->bind(":firstname", $data["firstname"]);
      $this->db->bind(":lastname", $data["lastname"]);
      $this->db->bind(":phone", $data["phone"]);
      $this->db->bind(":email", $data["email"]);
      $this->db->bind(":address", $data["address"]);
      $this->db->bind(":machine", $data["machine"]);
      $this->db->bind(":threads", $data["threads"]);
      $this->db->bind(":price", $data["price"]);
      // Execute
      $this->db->execute();
    }

    // End Production
    public function endProduct($id){
      // Insert Query
      $this->db->query("UPDATE `requests` SET `end_production_date`=CURDATE() WHERE `id`=$id;");
      // Execute
      $this->db->execute();
    }
  }
?>