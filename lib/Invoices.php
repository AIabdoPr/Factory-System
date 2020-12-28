<?php
  class Invoices{
    public $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Get All Invoices
    public function getAll(){
      $this->db->query("SELECT * FROM invoices`");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Get Request by id
    public function getById($id){
      $this->db->query("SELECT * FROM invoices WHERE id=$id;");
      // Assign Resualt Set
      return $this->db->single();
    }

    // Add Invoice
    public function Add($data){
      // Insert Query
      $this->db->query("INSERT INTO `invoices` (`request_id`, `worker_id`, `units_number`,
                                                `weight`, `amount`)
                        VALUES (:request_id, :worker_id, :units_number, :weight, :amount);");
      // Bind Data
      $this->db->bind(":request_id", $data["request_id"]);
      $this->db->bind(":worker_id", $data["worker_id"]);
      $this->db->bind(":units_number", $data["units_number"]);
      $this->db->bind(":weight", $data["weight"]);
      $this->db->bind(":amount", $data["amount"]);
      // Execute
      $this->db->execute();
      if(!$this->db->error){
        $request = $this->getRequestDetails($data["request_id"]);
        $this->db->query("UPDATE `requests` SET 
                            `total_weight`=:new_total_weight,
                            `units_number`=:new_units_number,
                            `total_amount`=:new_total_amount
                          WHERE `id`=:request_id;");
        // Bind Data
        $new_total_weight = $request->total_weight-floatval($data["weight"]);
        $new_units_number = $request->units_number-floatval($data["units_number"]);
        $new_total_amount = $request->total_amount+floatval($data["amount"]);
        $this->db->bind(":new_total_weight", $new_total_weight);
        $this->db->bind(":new_units_number", $new_units_number);
        $this->db->bind(":new_total_amount", $new_total_amount);
        $this->db->bind(":request_id", $data["request_id"]);
        // Execute
        $this->db->execute();
        // Get Invoice ID
        $this->db->query("SELECT id FROM `invoices` ORDER BY `id` DESC");
        $invoice_id = $this->db->single()->id;
        return $invoice_id;
      }
    }

    // get request details
    public function getRequestDetails($request_id){
      // Insert Query
      $this->db->query("SELECT * FROM requests WHERE id=:request_id;");
      // Bind Data
      $this->db->bind(":request_id", $request_id);
      // Assign Single Resualt
      return $this->db->single();
    }

    // Export Invoice as HTML
    public function exportHTML($id){
      $template = file_get_contents("templates/invoice-tmp.php");
      $invoice = $this->getById($id);
      $request = $this->getRequestDetails($invoice->request_id);
      $settings = new SystemSettings;
      $arrfind = array(
        ":SITE_TITLE:",
        ":admin_address:",
        ":admin_phone:",
        ":admin_email:",
        ":invoice_id:",
        ":request_id:",
        ":firstname:",
        ":lastname:",
        ":phone:",
        ":email:",
        ":address:",
        ":invoice_date:",
        ":request_date:",
        ":units_number:",
        ":weight:",
        ":amount:"
      );
      $arrreplace = array(
        SITE_TITLE,
        json_decode($settings->getByName("address")),
        json_decode($settings->getByName("phone")),
        json_decode($settings->getByName("email")),
        $invoice->id,
        $request->id,
        $request->firstname,
        $request->lastname,
        $request->phone,
        $request->email,
        $request->address,
        $invoice->invoice_date,
        $request->requesting_date,
        $invoice->units_number,
        $invoice->weight,
        $invoice->amount
      );
      $template = str_replace($arrfind, $arrreplace, $template);
      $file_name = "Invoice-".$invoice->id."-.php";
      $invoice_file = fopen("Exports/Invoices/".$file_name, "w");
      fwrite($invoice_file, $template);
      fclose($invoice_file);
      return $file_name;
    }
  }
?>