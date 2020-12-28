<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){

      $units = new Units();
      $requests = new Requests();

      if(isset($_POST["add_unit"])){
        $error = null;
        $request = $_POST["request_id"];
        $weight = $_POST["weight"];
        if($request == "" || $request == "none"){
          $error = "The Requests has been required";
        }elseif($weight == "" || $weight == 0){
          $error = "The Weight has been required";
        }
        if(!$error){
          $data = array();
          $data["request"] = $request;
          $data["weight"] = $weight;
          $data["worker_id"] = $_SESSION["Worker_ID"];
          $units->Add($data);
          if($units->db->error){
            $e = $units->db->error;
            $units->db->error = "";
            echo json_encode(array(false, $e));
          }else{
            echo json_encode(array(true, "Successfully entring the unit"));
          }
        }else{
          echo json_encode(array(false, $error));
        }
      }elseif(isset($_POST["remove_unit"])) {
        $unit_id = $_POST["unit_id"];
        $units->removeUnit($unit_id);
        if($units->db->error){
          $e = $units->db->error;
          $units->db->error = "";
          echo json_encode(array(false, $e));
        }else{
          echo json_encode(array(true, "Successfully removing the unit"));
        }
      // }elseif(isset($_POST["load_units"])) {
      }else {
        $count = isset($_POST["count"]) ? $_POST["count"] : "";
        $type = isset($_POST["type"]) ? $_POST["type"] : "all";
        if($type == "today"){$dunits = $units->getToday($count);}
        else{$dunits = $units->getAll($count);}
        $total_weight = 0;
        $total_units = 0;
        ?>
<table id="units-<?php echo $type?>">
  <tr>
    <th style="width: min-content;"><?php echo $words["ID"]?></th>
    <th><?php echo $words["Client name"]?></th>
    <th><?php echo $words["Machine"]?></th>
    <th><?php echo $words["Weight"]?></th>
    <th><?php echo $words["Production date"]?></th>
    <th><?php echo $words["Invoice date"]?></th>
    <th><?php echo $words["Producted by"]?></th>
  </tr>
<?php
        foreach($dunits as $unit):
          if($unit->invoice_date):
            $total_units += 1;
            $total_weight += $unit->unit_weight;
?>
  <tr>
    <td style="width: min-content;"><?php echo $unit->id;?></td>
    <td><?php echo $unit->cfirstname." ".$unit->clastname;?></td>
    <td><?php echo $unit->machine;?></td>
    <td><?php echo $unit->unit_weight;?></td>
    <td><?php echo $unit->production_date;?></td>
    <td><?php echo $unit->invoice_date;?></td>
    <td><?php echo $unit->ufirstname." ".$unit->ulastname;?></td>
  </tr>
<?php
          endif;
        endforeach;
?>

</table>
<br>
<?php echo $words["Total weight producted"].": $total_units ".$words["Kg"];?>
<br>
<?php echo $words["Total units producted"].": $total_units ".$words["Unit"];
      }
    }else{
      redirect("index.php", "You need login for continue", "error");
    }
  }else{
    redirect("server_connect.php", "You need connect to server for continue", "error");
  }
?>