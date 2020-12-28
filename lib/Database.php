<?php
  class Database{
    public $dbh;
    public  $error;
    private $stmt;

    public function __construct($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $dbname = DB_NAME){
      $this->host = $host;
      $this->user = $user;
      $this->pass = $pass;
      if($dbname != ""){
        $this->dbname = $dbname;
        $dbname = ";dbname=".$dbname;
      }
      // Set DSN
      $dsn = "mysql:host=".$this->host."".$dbname;

      // Set Option
      $option= array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      );

      // PDO Instance
      try {
        $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
      } catch (PDOException $e) {
        $this->error = $e->getMessage();
      }
    }

    public function import_file($file_path){
      # Import resuelts
      $ress = array();

      # read file into array
      $file = file($file_path);

      # import file line by line
      # and filter (remove) those lines, beginning with an sql comment token
      $file = array_filter($file,
              create_function('$line',
                  'return strpos(ltrim($line), "--") !== 0;'));

      # and filter (remove) those lines, beginning with an sql notes token
      $file = array_filter($file,
              create_function('$line',
                  'return strpos(ltrim($line), "/*") !== 0;'));
      $sql = "";
      $del_num = false;
      foreach($file as $line){
        $query = trim($line);
        try
        {
          $delimiter = is_int(strpos($query, "DELIMITER"));
          if($delimiter || $del_num){
            if($delimiter && !$del_num ){
              $sql = "";
              $sql = $query."; ";
              $ress[] = "OK<br/>---<br/>";
              $del_num = true;
            }else if($delimiter && $del_num){
              $sql .= $query." ";
              $del_num = false;
              $ress[] = $sql."<br/>do---do<br/>";
              $this->query($sql);
              $this->execute();
              $sql = "";
            }else{              
              $sql .= $query."; ";
            }
          }else{
            $delimiter = is_int(strpos($query, ";"));
            if($delimiter){
              $this->query("$sql $query");
              $this->execute();
              $ress[] = "$sql $query<br>---<br/>";
              $sql = "";
            }else{
              $sql .= " $query";
            }
          }
        }
        catch (\Exception $e)
        {
          $ress[] = $e->getMessage() . "<br /> <p>The sql is: $query</p>";
          $this->error = $e->getMessage() . "<br /> <p>The sql is: $query</p>";
        }
      }
      return $ress;
    }

    public function query($query){
      $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null){
      if(is_null($type)){
        switch (true) {
          case is_int($value):
            $type = PDO::PARAM_INT;
            break;
          case is_bool($value):
            $type = PDO::PARAM_BOOL;
            break;
          case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
          default:
            $type = PDO::PARAM_STR;
            break;
        }
      }
      $this->stmt->bindValue($param, $value, $type);
    }

    public function execute(){
      try{
        return $this->stmt->execute();
      } catch (PDOException $e) {
        $this->error = $e->getMessage();
        return $this->error;
      }
    }

    public function resualtSet(){
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single(){
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
  }
?>