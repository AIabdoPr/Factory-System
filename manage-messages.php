<?php
  include_once 'config/init.php';

  if(isset($_SESSION["ServerConnected"]) && $_SESSION["ServerConnected"] === true){
    if(isset($_SESSION["WorkerLogined"]) && $_SESSION["WorkerLogined"] === true){

      $messages = new WorkersMessages;

      if(isset($_POST["add_message"])){
        $message = $_POST["message"];
        if($message != ""){
          $data = array();
          $data["message"] = $message;
          $data["worker_id"] = $_SESSION["Worker_ID"];
          $messages->Add($data);
          if($messages->db->error){
            $e = $messages->db->error;
            $messages->db->error = "";
            echo json_encode(array(false, $e));
          }else {
            echo json_encode(array(true));
          }
        }
      }elseif(isset($_POST["load_messages"])){
        $count = isset($_POST["count"]) ? $_POST["count"] : "";
        $msgs = $messages->getAll($count);
        
        foreach($msgs as $msg):
        ?>
          <li class="message-block">
            <div class="content <?php if($msg->worker_id != $_SESSION["Worker_ID"]){echo "right";}?>">
              <img class="user-img" src="Imports/Workers/Worker-<?php echo $msg->worker_id;?>-/Image.png">
              <div class="message">
                <span class="user-name"><?php echo $msg->firstname." ".$msg->lastname;?></span>
                <p class="message-text"><?php echo $msg->message;?></p>
                <span class="message-date"><?php echo $msg->date;?></span>
              </div>
              <?php if($msg->worker_id == $_SESSION["Worker_ID"]):?>
              <button class="btn manage-btn" onclick="manage_message(this, '<?php echo $msg->id;?>')">
                <i class="fas fa-cog"></i>
              </button>
              <?php endif;?>
            </div>
          </li>
        <?php
        endforeach;
      }elseif(isset($_POST["update_message"])) {
        $id = $_POST["message_id"];
        $new_message = $_POST["new_message"];
        $messages->Update($id, $new_message);
        if($messages->db->error){
          $e = $messages->db->error;
          $messages->db->error = "";
          echo json_encode(array(false, $e));
        }else {
          echo json_encode(array(true));
        }
      }elseif(isset($_POST["remove_message"])) {
        $id = $_POST["message_id"];
        $messages->removeMessage($id);
        if($messages->db->error){
          $e = $messages->db->error;
          $messages->db->error = "";
          echo json_encode(array(false, $e));
        }else {
          echo json_encode(array(true));
        }
      }else {
        header("location: messages.php");
      }
    }else{
      redirect("index.php", $words["You need login for continue"], "error");
    }
  }else{
    redirect("server_connect.php", $words["You need connect to server for continue"], "error");
  }
?>