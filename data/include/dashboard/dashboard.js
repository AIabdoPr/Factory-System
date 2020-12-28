var DisplaySettings = JSON.parse(
  $.getJSON(
    {
    'url': "data/include/dashboard/DisplaySettings.json",
    'async': false
    }
  ).responseText
);

class WorkersControl {

  constructor(show) {
    this.show = show;
    this.workers_data = {};
  }

  get_workers(type, count, dataType = "html") {
    var r;
    $.ajax({
      url: "manage-workers.php",
      method: "POST",
      async: false,
      global: false,
      dataType: dataType,
      data: {"load_workers": true,
             "type": type,
             "count": count,
      },
      success: function(data) {
        r = data;
      }
    });
    return r;
  }

  load_workers(count = "") {
    if(this.show == "dashboard" || this.show == "workers"){
      var ndata = this.get_workers("current");
      if(!("current" in this.workers_data) || this.units_data["current"] != ndata){
        this.units_data["current"] = ndata;
        alert(ndata);
      }
    }else if(this.show == "worker"){}
  }

  add_worker() {
    weight = get_weight(true);
    worker_id = $("#worker").val();
    $.ajax({
      url: "manage-workers.php",
      method: "POST",
      dataType: 'json',
      data: {"add_worker": true,
             "worker_id": worker_id,
             "weight": weight,
      },
      success: function(data) {
        if(data[0] == false) {
          createNoty(data[1], "danger");
        }else {
          createNoty(data[1], "success");
        }
        document.getElementById("add-worker-btn").disabled = true;
      }
    });
  }
}

class UnitsControl {

  constructor(show) {
    this.show = show;
    this.units_data = {};
  }

  get_units(type, count, dataType = "html") {
    var r;
    $.ajax({
      url: "manage-units.php",
      method: "POST",
      async: false,
      global: false,
      dataType: dataType,
      data: {"load_units": true,
             "type": type,
             "count": count,
      },
      success: function(data) {
        r = data;
      }
    });
    return r;
  }

  load_units(count = "") {
    if(this.show == "dashboard"){
      var ndata = this.get_units("today");
      if(!("today" in this.units_data) || this.units_data["today"] != ndata){
        this.units_data["today"] = ndata;
        alert(ndata);
      }
    }
  }

  get_weight(clear = false) {
    var el = $("#weight-enter");
    var weight = el.val();
    if(clear) {
      el.val("");
    }
    return weight;
  }

  input_weight() {
    v = get_weight();
    if(v && v != 0) {
      document.getElementById("add-unit-btn").disabled = false;
    }else {
      document.getElementById("add-unit-btn").disabled = true;
    }
  }

  add_unit() {
    weight = get_weight(true);
    worker_id = $("#worker").val();
    $.ajax({
      url: "manage-units.php",
      method: "POST",
      dataType: 'json',
      data: {"add_unit": true,
             "worker_id": worker_id,
             "weight": weight,
      },
      success: function(data) {
        if(data[0] == false) {
          createNoty(data[1], "danger");
        }else {
          createNoty(data[1], "success");
        }
        document.getElementById("add-unit-btn").disabled = true;
      }
    });
  }
}

function load_details() {
  
}