<?php
  class units{
    public $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Get All units
    public function getAll($count = ""){
      if($count){
        $count = "LIMIT '$count'";
      }
      $this->db->query("SELECT units.*,
                               workers.firstname AS ufirstname,
                               workers.lastname AS ulastname,
                               requests.firstname AS cfirstname,
                               requests.lastname AS clastname,
                               requests.machine
                        FROM units
                        INNER JOIN workers ON units.`worker_id` = workers.id
                        INNER JOIN requests ON units.request_id = requests.id
                        $count;");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Get Today units
    public function getToday($count = ""){
      if($count){
        $count = "LIMIT '$count'";
      }
      $this->db->query("SELECT units.*,
                               workers.firstname AS ufirstname,
                               workers.lastname AS ulastname,
                               requests.firstname AS cfirstname,
                               requests.lastname AS clastname,
                               requests.machine
                        FROM units
                        INNER JOIN workers ON units.`worker_id` = workers.id
                        INNER JOIN requests ON units.request_id = requests.id
                        WHERE DATE(production_date)=CURDATE()
                        $count;");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Get unit by id
    public function getById($id, $as="all"){
      $this->db->query("SELECT * FROM units WHERE id=$id;");
      // Assign Resualt Set
      if($as == "all"){
        return $this->db->resualtSet();
      }else{
        return $this->db->single();
      }
    }

    // Add unit
    public function Add($data){
      // Insert The Unit
      $this->db->query("INSERT INTO `units` (`request_id`, `unit_weight`, `worker_id`)
                        VALUES (:request_id, :unit_weight, :worker_id);");
      $this->db->bind(":request_id", $data["request"]);
      $this->db->bind(":unit_weight", $data["weight"]);
      $this->db->bind(":worker_id", $data["worker_id"]);
      $this->db->execute();
      // get clinet details
      $this->db->query("SELECT * FROM `requests` WHERE id=:request_id;");
      $this->db->bind(":request_id", $data["request"]);
      $cdate = $this->db->single();
      $this->db->query("UPDATE `requests`
                        SET `units_number`=:units_number, total_weight=:total_weight
                        WHERE id=:request_id;");
      $this->db->bind(":total_weight", $cdate->total_weight+$data["weight"]);
      $this->db->bind(":units_number", $cdate->units_number+1);
      $this->db->bind(":request_id", $data["request"]);
      $this->db->execute();
    }

    // Invoice Unis by ids
    public function invoiceUnits($ids, $request_id){
      $ids = str_replace(array("[", "]"), array("(", ")"), $ids);
      $this->db->query("UPDATE `units`
                        SET invoice_date=CURDATE()
                        WHERE `request_id`=$request_id
                        AND `id` IN $ids;");
      $this->db->execute();
    }
  }
?>