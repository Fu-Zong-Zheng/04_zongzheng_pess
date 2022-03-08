<?php
//many to many for dispatch table.

/*
  1st read all the fields from the logcall.php by accessin the $_POST variable
  controlC the name of the field from the logcall.php and controlV in to the $_POST variable
  once done the 1st field do an echo test and access from the logcall.php fill in the caller name column first
  then click on prcess call should be able to see the coller name value that u've written at logcall.php page after that
  do the rest of the field (done)
*/
  $caller_name = $_POST["callerName"];
  $contact_No = $_POST["cantactNo"];
  $location_of_incident = $_POST["locationOfIncident"];
  $type_of_incident = $_POST["typeOfIncident"];
  $description_of_incident = $_POST["descriptionOfIncident"];

  require_once "db.php";
  $conn = new mysqli (DB_SERVER , DB_USER , DB_PASSWORD , DB_DATABASE);
  $sql = "SELECT patrolcar.patrolcar_id,patrolcar_status.patrolcar_status_desc FROM `patrolcar` INNER JOIN patrolcar_status ON patrolcar.patrolcar_status_id = patrolcar_status.patrolcar_status_id";
  $result = $conn->query($sql); //same as the go button in the sql
  $cars = [];
  while($row = $result->fetch_assoc()){
      $id = $row["patrolcar_id"];
      $status = $row["patrolcar_status_desc"];
      $car = [];
      $car ["id"] = $id;
      $car ["status"] = $status;
      array_push($cars,$car);
  }
  $conn->close();

  $btn_dispatch_clicked = isset($_POST["btn_dispatch"]);
  $btn_process_call_clicked = isset($_POST["btn_process_call"]);
  if($btn_dispatch_clicked == false && $btn_process_call_clicked == false){
    header("location:logcall.php");
  }
  $incidents = [];
  if($btn_dispatch_clicked == true){
    $insert_incident_success = false;
    $has_car_selection = isset($_POST["cbCarSelection"]);
    $patrolcar_dispatched = [];
    $num_of_patrolcar_dispatched = 0;
    if($has_car_selection == true){
      $patrolcar_dispatched = $_POST["cbCarSelection"];
      $num_of_patrolcar_dispatched = count($patrolcar_dispatched);
    }

    $incident_status = 0;


    if($num_of_patrolcar_dispatched > 0){
        $incident_status = 2; //dispatched
    }
    else {
        $incident_status = 1; //pending
    }
    $caller_name = $_POST["callerName"];
    $contact_No = $_POST["cantactNo"];
    $location_of_incident = $_POST["locationOfIncident"];
    $type_of_incident = $_POST["typeOfIncident"];
    $description_of_incident = $_POST["descriptionOfIncident"];

    $sql = "INSERT INTO `incident`(`caller_name`, `phpne_number`, `incident_type_id`, `incident_location`, `incident_desc`, `incident_status_id`, `time_called`) VALUES ('" . $caller_name . "','" . $contact_No . "','" . $type_of_incident . "','" . $location_of_incident . "','" . $description_of_incident . "','" . $incident_status . "',now())";
    //echo $sql;
    $conn = new mysqli (DB_SERVER , DB_USER , DB_PASSWORD , DB_DATABASE);
    $insert_incident_success = $conn->query($sql);
    if($insert_incident_success == false){
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $incident_id = mysqli_insert_id($conn); //return the PK this one can use in the dispatch table
    //echo "<br> new incident id: " . $incident_id;
    $update_sucess = false;
    $insert_dispatch_sucess = false;
    foreach($patrolcar_dispatched as $each_car_id){
      //echo $each_car_id . "<br>";
      $sql = "UPDATE `patrolcar` SET `patrolcar_status_id`=1 WHERE `patrolcar_id`='" . $each_car_id . "'";
      $update_sucess = $conn->query($sql);


      if($update_sucess == false){
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
      $sql = "INSERT INTO `dispatch`(`incident_id`, `patrolcar_id`, `time_dispatched`) VALUES (" . $incident_id . ",'" . $each_car_id . "',now())";//1 car many incident or 1 incident many cars
      $insert_dispatch_sucess = $conn->query($sql);

      if($insert_dispatch_sucess == false){
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    $conn->close();

    if($insert_dispatch_sucess == true && $update_sucess == true){ //to check makesure the SQL is right if got error we will not see
      header("location:logcall.php");
    }
  }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dispatch</title>
    <link rel="stylesheet" href="css/bootstrap-4.3.1.css">
  </head>

  <body>
    <div class="container" style = "width:900px">
      <?php
        include "header.php";
       ?>
        <section calss = "mt-3">
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="form-group row">
                  <label for="callerName" class = "col-sm-4 col-form-label">Caller's Name</label>
                  <div class="col-sm-8">
                        <span>
                            <?php echo $caller_name;?>
                            <input type = "hidden" id = "callerName" name = "callerName" value = "<?php echo $caller_name;?>">
                        </span>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="cantactNo" class = "col-sm-4 col-form-label">Cantact Number</label>
                  <div class="col-sm-8">
                    <span>
                      <?php echo $contact_No;?>
                      <input type = "hidden" id = "cantactNo" name = "cantactNo" value="<?php echo $contact_No;?>">
                    </span>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="locationOfIncident" class = "col-sm-4 col-form-label">Location of incident</label>
                  <div class="col-sm-8">
                    <span>
                        <?php echo $location_of_incident; ?>
                        <input type = "hidden" id = "locationOfIncident" name = "locationOfIncident" value="<?php echo $location_of_incident; ?>">
                    </span>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="typeOfIncident" class = "col-sm-4 col-form-label">Type of incident</label>
                  <div class="col-sm-8">
                    <span>
                        <?php echo $type_of_incident; ?>
                        <input id = "typeOfIncident" type="hidden" name = "typeOfIncident" value="<?php echo $type_of_incident; ?>">
                    </span>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="descriptionOfIncident" class = "col-sm-4 col-form-label">Description of incident</label>
                  <div class="col-sm-8">
                    <span>
                        <?php echo $description_of_incident; ?>
                        <input name="descriptionOfIncident" type="hidden" id = "descriptionOfIncident" value="<?php echo $description_of_incident; ?>">
                    </span>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="patrolCar" class = "col-sm-4 col-form-label">Choose patrol car (s)</label>
                  <div class="col-sm-8">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th>Car Number</th>
                          <th>Status</th>
                          <th></th>
                        </tr>

                            <?php
                              foreach($cars as $car){
                                echo "<tr>" .
                                    "<td>" .$car["id"]. "</td>" .
                               "<td>" .$car["status"]. "</td>" .
                               "<td>" .
                                 "<input type=\"checkbox\" " . "value=\"" . $car ["id"] . "\" " . "name=\"cbCarSelection[]\">" .
                                 "</td>" .
                                 "</tr>";
                              }
                             ?>


                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="offset-sm-4 col-sm-8">
                        <button type="submit" class = "btn btn-primary" name = "btn_dispatch" id = "submit">Dispatch</button>
                  </div>
                </div>

            </form>
        </section>
        <?php
              include "footer.php";
         ?>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script  src="js/popper.min.js"></script>
    <script  src="js/bootstrap-4.0.0.js"></script>
  </body>
</html>
