<?php
  class Workers{
    public $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Get All Workers
    public function getAll(){
      $this->db->query("SELECT * FROM `workers`");
      // Assign Resualt Set
      return $this->db->resualtSet();
    }

    // Get Worker by id
    public function getById($id){
      $this->db->query("SELECT * FROM `workers` WHERE `id`=$id;");
      // Assign Resualt Set
      return $this->db->single();
    }

    // SignUp Worker
    public function SignUp($data, $have_admin){
      $this->db->query("SELECT * FROM `workers` WHERE `username`='".$data["username"]."'");
      if($this->db->resualtSet()){
        $this->db->error = 'The username already exists';
        return false;
      }
      // Insert Query
      $this->db->query("INSERT INTO `workers` (`id`, `firstname`, `lastname`, `username`,
                                               `password`, `birth_date`, `gander`,
                                               `phone`, `email`, `address`)
                        VALUES (:id, :firstname, :lastname, :username, :password,
                                :birth_date, :gander, :phone, :email, :address)");
      // Bind Data
      $this->db->bind(":id", $have_admin==false ? 1 : null);
      $this->db->bind(":firstname", $data["firstname"]);
      $this->db->bind(":lastname", $data["lastname"]);
      $this->db->bind(":username", $data["username"]);
      $this->db->bind(":password", md5($data["password"]));
      $this->db->bind(":birth_date", $data["birth_date"]);
      $this->db->bind(":gander", $data["gander"]);
      $this->db->bind(":phone", $data["phone"]);
      $this->db->bind(":email", $data["email"]);
      $this->db->bind(":address", $data["address"]);
      // Execute
      $this->db->execute();
    }

    // Login Worker
    public function Login($username, $password){
      // Check for username
      $this->db->query("SELECT * FROM `workers` WHERE `username`='$username'");
      $data = $this->db->single();
      if(!$this->db->error){
        if(!$data){
          $this->db->error = "The username does not exists";
          return false;
        }
      }else{
        return false;
      }
      // Check for password
      if(md5($password) != $data->password){
        $this->db->error = "The password is incorrect";
        return false;
      }
      // Check if worker is checkouted
      if($data->checkout_date){
        $this->db->error = "You'r checkouted you can't enter to system<br>Call the system admin for more information";
        return false;
      }
      // login the worker
      $this->db->query("UPDATE `workers` SET `exists`='Yes' WHERE `id`=".$data->id.";");
      $this->db->execute();
      if($this->db->error){
        return false;
      }
      // Successfully Login
      return $data;
    }

    // Update Worker Settings
    public function Update($data, $worker_id){
      // Insert Query
      $password = $data["password"];
      if($password){
        $password = md5($password);
        $password = "password='$password',";
      }
      $query = "UPDATE `workers` SET 
                          `firstname`=:firstname,
                          `lastname`=:lastname,
                          $password
                          `birth_date`=:birth_date,
                          `gander`=:gander,
                          `phone`=:phone,
                          `email`=:email,
                          `address`=:address,
                          `settings`=:settings
                        WHERE `id`=$worker_id;";
      $this->db->query($query);
      // Bind Data
      $this->db->bind(":firstname", $data["firstname"]);
      $this->db->bind(":lastname", $data["lastname"]);
      $this->db->bind(":birth_date", $data["birth_date"]);
      $this->db->bind(":gander", $data["gander"]);
      $this->db->bind(":phone", $data["phone"]);
      $this->db->bind(":email", $data["email"]);
      $this->db->bind(":address", $data["address"]);
      $this->db->bind(":settings", $data["settings"]);
      // Execute
      $this->db->execute();
    }

    // Worker Logout
    public function Logout($worker_id){
      $this->db->query("UPDATE `workers` SET `exists`='No' WHERE `id`=$worker_id;");
      $this->db->execute();
    }

    // Reload all workers
    public function Reload(){
      $workers = $this->getAll();
      foreach($workers as $worker){
        if($worker->exists == "Yes"){
          $this->Logout($worker->id);
        }
      }
    }
  }
?>