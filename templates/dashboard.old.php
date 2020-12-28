<!-- <html lang="--lang--" dir="--dir--"> -->
<html>
  <head>
    <?php
      if($show == "dashboard") {$title = $words["Dashboard"];}
      elseif($show == "workers") {$title = $words["Workers"];}
      elseif($show == "requests") {$title = $words["Requests"];}
      elseif($show == "stock") {$title = $words["Stock"];}
      include 'inc/header.php';
    ?>
    <script src="Data/script.js?v=<?php echo time();?>"></script>
    <link rel="stylesheet" type="text/css" href="Data/include/calculator/calculator.css?v=<?php echo time();?>">
    <script src="Data/include/calculator/calculator.js" defer></script>
    <link rel="stylesheet" type="text/css" href="Data/style.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/login.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="Data/include/dashboard/dashboard.css?v=<?php echo time();?>">
  </head>
  <body>
    <div id="my-noty" class="noties bottomright"></div>
    <div class="wrapper">
      <!--<div class="top_navbar">-->
      <div style="display: grid;
                  grid-template-columns: 225px auto;
                  width: 100%;
                  height: 60px;
                  position: fixed;
                  top: 0;">
       <!--<div class="logo">-->
        <div style="height: 60px;
                    background: var(--gbg);
                    border-bottom: 1px solid #0E497D;">
          <a href="index.php" style="display: block;
                                     text-align: center;
                                     font-family: 'Montserrat Subrayada', sans-serif;
                                     font-size: 20px;
                                     color: #fff;
                                     padding: 20px 0;">Control Panel</a>
        </div>
        <!--<div class="top_menu">-->
        <div style="/*display: grid;
                    grid-template-columns: auto auto;*/
                    height: 60px;
                    background: #fff;">
          <div style="height: 60px;
                      float: left;">
          </div>
          <!--<div class="right_info">-->
          <div style="/*display: grid;
                      grid-template-columns: auto auto auto auto;*/
                      display: flex;
                      float: right;
                      padding: 0 10px;
                      height: 60px;">

            <div class="icon_wrap" onclick="document.getElementById('calculator-modal').style.display='block'">
              <div class="icon">
                <i class="fas fa-calculator"></i>
              </div>
            </div>
            <!--
            <div id="settings-menu" class="icon_wrap" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="icon">
                <i class="fas fa-cog"></i>
              </div>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="settings-menu">
                <ul class="menu-list">
                  <li class="btn menu-list-item">Language</li>
                  <li class="btn menu-list-item">Update Detials</li>
                </ul>
              </div>
            </div>
            -->

            <a class="icon_wrap" href="worker-settings.php">
              <div class="icon">
                <i class="fas fa-cog"></i>
              </div>
            </a>

            <a class="icon_wrap" href="logout.php">
              <div class="icon">
                <i class="fas fa-sign-out-alt"></i>
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="main_body">
        <div class="sidebar_menu">
          <div class="inner__sidebar_menu">
            <ul>
              <li>
                <a href="index.php?show=dashboard" class="<?php if($show == "dashboard") {echo("active");}?>">
                    <i class="fas fa-chart-line"></i></span>
                  <span>
                  <span class="list"><?php echo $words["Dashboard"];?></span>
                </a>
              </li>
              <li>
                <a href="index.php?show=workers" class="<?php if($show == "workers") {echo("active");}?>">
                  <!--<span class="icon"><i class="fas fa-hard-hat"></i></span>-->
                  <span class="icon"><i class="fas fa-people-carry"></i><i class="fal fa-hard-hat"></i></span>
                  <span class="list"><?php echo $words["Workers"];?></span>
                </a>
              </li>
              <li>
                <a href="index.php?show=requests" class="<?php if($show == "requests") {echo("active");}?>">
                  <span class="icon"><i class="fas fa-clipboard-check"></i></span>
                  <span class="list"><?php echo $words["Requests"];?></span>
                </a>
              </li>
              <li>
                <a href="index.php?show=stock" class="<?php if($show == "stock") {echo("active");}?>">
                  <span class="icon"><i class="fas fa-warehouse"></i></span>
                  <span class="list"><?php echo $words["Stock"];?></span>
                </a>
              </li>
            </ul>
            <div class="hamburger">
              <div class="inner_hamburger">
                  <span class="arrow">
                      <i class="fas fa-long-arrow-alt-left"></i>
                      <i class="fas fa-long-arrow-alt-right" style="display: none;"></i>
                  </span>
              </div>
            </div>
          </div>
        </div>
        <div class="details-front">
          <?php if($show == "dashboard" || $show == "workers"):?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["Present workers"];?></h2>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["First name"];?></th>
                  <th><?php echo $words["Last name"];?></th>
                  <th><?php echo $words["Join date"];?></th>
                </tr>
                <?php 
                  $total_workers = 0;
                  foreach($workers as $worker):
                    if(!$worker->checkout_date && $worker->exists == "Yes"):
                      $total_workers += 1;
                ?>
                <tr>
                  <td><?php echo $worker->id;?></td>
                  <td><?php echo $worker->firstname;?></td>
                  <td><?php echo $worker->lastname;?></td>
                  <td><?php echo $worker->join_date;?></td>
                </tr>
                <?php 
                    endif;
                  endforeach;
                ?>
              </table>
              <br>
              <?php echo $words["All present workers"].": $total_workers";?>
            </div>
          </div>
          <?php   if($show == "workers"):?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["Absente workers"];?></h2>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["First name"];?></th>
                  <th><?php echo $words["Last name"];?></th>
                  <th><?php echo $words["Join date"];?></th>
                </tr>
                <?php 
                  $total_workers = 0;
                  foreach($workers as $worker):
                    if(!$worker->checkout_date && $worker->exists == "no"):
                      $total_workers += 1;
                ?>
                <tr>
                  <td><?php echo $worker->id;?></td>
                  <td><?php echo $worker->firstname;?></td>
                  <td><?php echo $worker->lastname;?></td>
                  <td><?php echo $worker->join_date;?></td>
                </tr>
                <?php
                    endif;
                  endforeach;
                ?>
              </table>
              <br>
              <?php echo $words["All absente workers"].": $total_workers";?>
            </div>
          </div>
          <?php if($_SESSION["Worker_ID"] == 1):?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["Old workers"];?></h2>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["First name"];?></th>
                  <th><?php echo $words["Last name"];?></th>
                  <th><?php echo $words["Join date"];?></th>
                  <th><?php echo $words["Checkout date"];?></th>
                </tr>
                <?php 
                  $total_workers = 0;
                  foreach($workers as $worker):
                    if($worker->checkout_date):
                      $total_workers += 1;
                ?>
                <tr>
                  <td><?php echo $worker->id;?></td>
                  <td><?php echo $worker->firstname;?></td>
                  <td><?php echo $worker->lastname;?></td>
                  <td><?php echo $worker->join_date;?></td>
                  <td><?php echo $worker->checkout_date;?></td>
                </tr>
                <?php
                    endif;
                  endforeach;
                ?>
              </table>
              <br>
              <?php echo $words["All old workers"].": $total_workers";?>
            </div>
          </div>
          <?php endif;?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["All workers"];?></h2>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["First name"];?></th>
                  <th><?php echo $words["Last name"];?></th>
                  <th><?php echo $words["Join date"];?></th>
                  <th><?php echo $words["Exists"];?></th>
                </tr>
                <?php 
                  $total_workers = 0;
                  foreach($workers as $worker):
                    $total_workers += 1;
                ?>
                <tr>
                  <td><?php echo $worker->id;?></td>
                  <td><?php echo $worker->firstname;?></td>
                  <td><?php echo $worker->lastname;?></td>
                  <td><?php echo $worker->join_date;?></td>
                  <td><?php echo $words[$worker->exists];?></td>
                </tr>
                <?php endforeach;?>
              </table>
              <br>
              <?php echo $words["Total workers"].": $total_workers";?>
            </div>
          </div>
          <?php   endif;?>
          <?php endif;?>
          <?php if($show == "dashboard" || $show == "requests"):?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["Current requests"];?></h2>
              <a class="btn btn-primary btn-add" href="add_request.php">
                <i class="fas fa-plus"></i> <?php echo $words["Add"];?>
              </a>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["First name"];?></th>
                  <th><?php echo $words["Last name"];?></th>
                  <th><?php echo $words["Machine used"];?></th>
                  <th><?php echo $words["Requesting date"];?></th>
                  <th><?php echo $words["Total weight"];?></th>
                  <th><?php echo $words["Units number"];?></th>
                </tr>
                <?php 
                  $total_requests = 0;
                  foreach($requests as $request):
                    if(!$request->end_production_date):
                      $total_requests += 1;
                ?>
                <tr style="cursor: pointer;" class="request-item" oncontextmenu="request_item_rclick(this)">
                  <td id="id"><?php echo $request->id;?></td>
                  <td id="firstname"><?php echo $request->firstname;?></td>
                  <td id="lastname"><?php echo $request->lastname;?></td>
                  <td id="machine"><?php echo $request->machine;?></td>
                  <td id="requesting_date"><?php echo $request->requesting_date;?></td>
                  <td id="total_weight"><?php echo $request->total_weight;?></td>
                  <td id="units_number"><?php echo $request->units_number;?></td>
                </tr>
                <?php 
                    endif;
                  endforeach;
                ?>
              </table>
              <div class="dropdown-menu hide" id="rmenu">
              </div>
              <br>
              <?php echo $words["Total current requests"].": $total_requests";?>
            </div>
          </div>
          <?php endif;?>
          <?php   if($show == "requests"):?>
          <?php if($_SESSION["Worker_ID"] == 1):?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["Old requests"];?></h2>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["First name"];?></th>
                  <th><?php echo $words["Last name"];?></th>
                  <th><?php echo $words["Machine used"];?></th>
                  <th><?php echo $words["Requesting date"];?></th>
                  <th><?php echo $words["End production date"];?></th>
                  <th><?php echo $words["Total weight"];?></th>
                  <th><?php echo $words["Units number"];?></th>
                </tr>
                <?php 
                  $total_requests = 0;
                  foreach($requests as $request):
                    if($request->end_production_date):
                      $total_requests += 1;
                ?>
                <tr style="cursor: pointer;" class="request-item" oncontextmenu="request_item_rclick(this)">
                  <td id="id"><?php echo $request->id;?></td>
                  <td id="firstname"><?php echo $request->firstname;?></td>
                  <td id="lastname"><?php echo $request->lastname;?></td>
                  <td id="machine"><?php echo $request->machine;?></td>
                  <td id="requesting_date"><?php echo $request->requesting_date;?></td>
                  <td id="end_production_date"><?php echo $request->end_production_date;?></td>
                  <td id="total_weight"><?php echo $request->total_weight;?></td>
                  <td id="units_number"><?php echo $request->units_number;?></td>
                </tr>
                <?php
                    endif;
                  endforeach;
                ?>
              </table>
              <br>
              <?php echo $words["Total old requests"].": $total_requests";?>
            </div>
          </div>
          <?php endif;?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["All requests"];?></h2>
              <a class="btn btn-primary btn-add" href="add_request.php">
                <i class="fas fa-plus"></i> <?php echo $words["Add"];?>
              </a>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["First name"];?></th>
                  <th><?php echo $words["Last name"];?></th>
                  <th><?php echo $words["Machine used"];?></th>
                  <th><?php echo $words["Requesting date"];?></th>
                  <th><?php echo $words["End production date"];?></th>
                  <th><?php echo $words["Total weight"];?></th>
                  <th><?php echo $words["Units number"];?></th>
                </tr>
                <?php 
                  $total_requests = 0;
                  foreach($requests as $request):
                    $total_requests += 1;
                ?>
                <tr style="cursor: pointer;" class="request-item" oncontextmenu="request_item_rclick(this)">
                  <td id="id"><?php echo $request->id;?></td>
                  <td id="firstname"><?php echo $request->firstname;?></td>
                  <td id="lastname"><?php echo $request->lastname;?></td>
                  <td id="machine"><?php echo $request->machine;?></td>
                  <td id="requesting_date"><?php echo $request->requesting_date;?></td>
                  <td id="requesting_date">
                    <?php
                      if($request->end_production_date){
                        echo $request->end_production_date;
                      }else {
                        echo $words["In production"];
                      }
                    ?>
                  </td>
                  <td id="total_weight"><?php echo $request->total_weight;?></td>
                  <td id="units_number"><?php echo $request->units_number;?></td>
                </tr>
                <?php endforeach;?>
              </table>
              <br>
              <?php echo $words["Total requests"].": $total_requests";?>
            </div>
          </div>
          <?php   endif;?>
          <?php if($show == "dashboard" || $show == "stock"):?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["Units for today"];?></h2>
              <!-- <a class="btn btn-primary btn-add" href="add_unit.php"> -->
              <span class="btn btn-primary btn-add"  onclick="document.getElementById('add-units-modal').style.display='block'">
                <i class="fas fa-plus"></i> <?php echo $words["Add"];?>
              </span>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["Client name"];?></th>
                  <th><?php echo $words["Machine"];?></th>
                  <th><?php echo $words["Weight"];?></th>
                  <th><?php echo $words["Production date"];?></th>
                  <th><?php echo $words["Producted by"];?></th>
                </tr>
                <?php
                  $total_weight = 0;
                  $total_units = 0;
                  foreach($today_units as $unit):
                    $total_units += 1;
                    $total_weight += $unit->unit_weight;
                ?>
                <tr>
                  <td><?php echo $unit->id;?></td>
                  <td><?php echo $unit->cfirstname." ".$unit->clastname;?></td>
                  <td><?php echo $unit->machine;?></td>
                  <td><?php echo $unit->unit_weight;?></td>
                  <td><?php echo date("H:i:s", strtotime($unit->production_date));?></td>
                  <td><?php echo $unit->ufirstname." ".$unit->ulastname;?></td>
                </tr>
                <?php
                  endforeach;
                ?>
              </table>
              <br>
              <?php echo $words["Total weight producted for today"].": $total_weight ".$words["Kg"];?>
              <br>
              <?php echo $words["Total units for today"].": $total_units ".$words["Unit"];?>
            </div>
          </div>
          <?php endif;?>
          <?php   if($show == "stock"):?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["Units on stock"];?></h2>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["Client name"];?></th>
                  <th><?php echo $words["Machine"];?></th>
                  <th><?php echo $words["Weight"];?></th>
                  <th><?php echo $words["Production date"];?></th>
                  <th><?php echo $words["Producted by"];?></th>
                </tr>
                <?php
                  $total_weight = 0;
                  $total_units = 0;
                  foreach($units as $unit):
                    if(!$unit->invoice_date):
                      $total_units += 1;
                      $total_weight += $unit->unit_weight;
                ?>
                <tr>
                  <td><?php echo $unit->id;?></td>
                  <td><?php echo $unit->cfirstname." ".$unit->clastname;?></td>
                  <td><?php echo $unit->machine;?></td>
                  <td><?php echo $unit->unit_weight;?></td>
                  <td><?php echo $unit->production_date;?></td>
                  <td><?php echo $unit->ufirstname." ".$unit->ulastname;?></td>
                </tr>
                <?php
                    endif;
                  endforeach;
                ?>
              </table>
              <br>
              <?php echo $words["Total weight on stock"].": $total_weight ".$words["Kg"];?>
              <br>
              <?php echo $words["Total units on stock"].": $total_units ".$words["Unit"];?>
            </div>
          </div>
          <?php if($_SESSION["Worker_ID"] == 1):?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["Old units"];?></h2>
              <table>
                <tr>
                  <th style="width: min-content;"><?php echo $words["ID"];?></th>
                  <th><?php echo $words["Client name"];?></th>
                  <th><?php echo $words["Machine"];?></th>
                  <th><?php echo $words["Weight"];?></th>
                  <th><?php echo $words["Production date"];?></th>
                  <th><?php echo $words["Invoice date"];?></th>
                  <th><?php echo $words["Producted by"];?></th>
                </tr>
                <?php
                  $total_weight = 0;
                  $total_units = 0;
                  foreach($units as $unit):
                    if($unit->invoice_date):
                      $total_units += 1;
                      $total_weight += $unit->unit_weight;
                ?>
                <tr>
                  <td><?php echo $unit->id;?></td>
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
              <?php echo $words["Total weight producted"].": $total_weight".$words["Kg"];?>
              <br>
              <?php echo $words["Total units producted"].": $total_units ".$words["Unit"];?>
            </div>
          </div>
          <?php endif;?>
          <div class="item_wrap">
            <div style="width:100%;">
              <h2 style="text-align:center;"><?php echo $words["All units producted"]?></h2>
              <!-- <a class="btn btn-primary btn-add" href="add_unit.php"> -->
              <span class="btn btn-primary btn-add"  onclick="document.getElementById('add-units-modal').style.display='block'">
                <i class="fas fa-plus"></i> <?php echo $words["Add"]?>
              </span>
              <table>
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
                  $total_weight = 0;
                  $total_units = 0;
                  foreach($units as $unit):
                    $total_units += 1;
                    $total_weight += $unit->unit_weight;
                ?>
                <tr>
                  <td><?php echo $unit->id;?></td>
                  <td><?php echo $unit->cfirstname." ".$unit->clastname;?></td>
                  <td><?php echo $unit->machine;?></td>
                  <td><?php echo $unit->unit_weight;?></td>
                  <td><?php echo $unit->production_date;?></td>
                  <td>
                    <?php
                      if($unit->invoice_date){
                        echo $unit->invoice_date;
                      }else {
                        echo $words["On Stock"];
                      }
                    ?>
                  </td>
                  <td><?php echo $unit->ufirstname." ".$unit->ulastname;?></td>
                </tr>
                <?php
                  endforeach;
                ?>
              </table>
              <br>
              <?php echo $words["Total weight producted"].": $total_units ".$words["Kg"];?>
              <br>
              <?php echo $words["Total units producted"].": $total_units ".$words["Unit"];?>
            </div>
          </div>
          <?php   endif;?>
        </div>
      </div>
    </div>
    <div id="calculator-modal" class="modal">
      <div class="modal-body animate">
        <div class="calculator-grid">
          <div class="output">
            <div data-previous-operand class="previous-operand"></div>
            <div data-current-operand class="current-operand"></div>
          </div>
          <button onclick="document.getElementById('calculator-modal').style.display='none'">OFF</button>
          <button data-all-clear>AC</button>
          <button data-delete>DEL</button>
          <button data-operation>÷</button>
          <button data-number>1</button>
          <button data-number>2</button>
          <button data-number>3</button>
          <button data-operation>*</button>
          <button data-number>4</button>
          <button data-number>5</button>
          <button data-number>6</button>
          <button data-operation>-</button>
          <button data-number>7</button>
          <button data-number>8</button>
          <button data-number>9</button>
          <button data-operation style="grid-row: span 2;">+</button>
          <button data-number>.</button>
          <button data-number>0</button>
          <button data-equals>=</button>
        </div>
      </div>
    </div>
    <div id="add-units-modal" class="modal">
      <div class="modal-body animate">
        <div style="width: 600px;
                    background-color: #ced4da;
                    padding: 20px 15px;
                    border-radius: 5px;">
          <h2 class="text-center"><?php echo $words["Add new unit"]?></h2>
          <div class="form-group">
            <h4><?php echo $words["Select a requests"]?>:</h4>
            <select id="request" class="form-control">
              <option value="none"><?php echo $words["None"]?></option>
              <?php
              foreach($requests as $request):
                if(!$request->end_production_date):
              ?>
              <option value="<?php echo $request->id?>">
                <?php echo $request->firstname." ".$request->lastname;?>
              </option>
              <?php
                endif;
              endforeach;
              ?>
            </select>
          </div>
          <div class="form-group" style="display: grid; 
                                         grid-template-columns: auto min-content;
                                         grid-gap: 5px;">
            <input type="number" class="form-control" id="weight-enter" oninput="input_weight()" placeholder="<?php echo $words["Weight"]?>" min="0">
            <button class="btn btn-primary btn-lg btn-block" id="add-unit-btn" onclick="add_unit()" disabled>
              <?php echo $words["Add"]?>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div id="updates" class="updates-down">
      <div id="updates-tool-bar">
        <button id="messages-btn" class="btn disabled" onclick='load_updates("messages")'>
          <?php echo $words["Messages"]?>
        </button>
        <button id="notifications-btn" class="btn" onclick='load_updates("notifications")'>
          <?php echo $words["Notifiactions"]?>
        </button>
        <button id="updown-btn" class="close" aria-hidden="true">-</button>
      </div>
      <div id="details" class="hide">
      </div>
    </div>
    <script>
      <?php displayMessage();?>
      $(document).ready(function(){
        $(".hamburger").click(function(){
          $(".wrapper").toggleClass("active");
        })
      });

      // Get the calculator_el
      var calculator_el = document.getElementById('calculator-modal');
      var updates_el = document.getElementById('updates');
      var updates_tool_bar_el = document.getElementById('updates-tool-bar');
      var message_btn_el = document.getElementById('messages-btn');
      var notifications_btn_el = document.getElementById('notifications-btn');
      var updown_btn_el = document.getElementById('updown-btn');
      var details_el = document.getElementById('details');
      var ctype = "";

      updown_btn_el.onclick = function(event) {
        if(updates_el.className == "updates-down") {
          updates_el.className = "updates-up";
          details_el.className = "show";
          if(ctype == "") {
            load_updates("messages");
          }
        }else {
          updates_el.className = "updates-down";
          details_el.className = "hide";
        }
      }

      function load_updates(type) {
        if(updates_el.className == "updates-down") {
          updates_el.className = "updates-up";
          details_el.className = "show";
        }
        if(type == "messages" & type != ctype) {
          ctype = type;
          details_el.innerHTML = '<object type="text/html" data="messages.php" style="width: 100%; height: 100%;"></object>';
          message_btn_el.className = "btn disabled";
          notifications_btn_el.className = "btn enabled";
        }else if(type == "notifications" & type != ctype) {
          ctype = type;
          details_el.innerHTML = '<object type="text/html" data="notifications.php" style="width: 100%; height: 100%;"></object>';
          notifications_btn_el.className = "btn disabled";
          message_btn_el.className = "btn enabled";
        }
      }

      function request_item_rclick(element) {
        var id = element.querySelector("#id").innerHTML;
        document.getElementById("rmenu").className = "show";
        document.getElementById("rmenu").innerHTML = "";
        document.getElementById("rmenu").style.top = mouseY(event) + 'px';
        document.getElementById("rmenu").style.left = mouseX(event) + 'px';

        var menuitems = [
          '<a class="dropdown-item" href="request_details.php?id='+id+'" style="border-radius: 2px;">'+ 
            '<?php echo $words["Update"]?>'+
          '</a>',
          '<a class="dropdown-item" href="invoicing_requests.php?id='+id+'" style="border-radius: 2px;">'+ 
            '<?php echo $words["Invoice"]?>'+
          '</a>',
        ];
        for(var menuitem in menuitems) {
          $("#rmenu").append(menuitems[menuitem]);
        }
        window.event.returnValue = false;
      }

      // this is from another SO post...  
      $(document).bind("click", function(event) {
        if(document.getElementById("rmenu")){
          document.getElementById("rmenu").className = "hide";
        }
        if(event.target.className == "modal"){
          event.target.style.display = "none";
        }
      });
    </script>
  </body>
</html>