<?php
  require_once "db.php";
  $conn = new mysqli (DB_SERVER , DB_USER , DB_PASSWORD , DB_DATABASE);
  $sql = "SELECT * FROM incident_type";
  $result = $conn->query($sql); //same as the go button in sql this is to aoto click on the go button
  $incidentTypes = []; //I creat this array list so i can fill in the query result in this array
    while($row = $result->fetch_assoc()){ //to read the 1st row from quert result and fill the data in to $incidentType variable and push in to $incidentTypes variable
        $id = $row["incident_type_id"];
        $type = $row["incident_type_desc"];
        $incidentType = [];
        $incidentType ["id"] = $id;
        $incidentType ["type"] = $type;
        array_push($incidentTypes,$incidentType);
    }
    $conn->close(); // after that i close the connection
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>log call</title>
    <link rel="stylesheet" href="css/bootstrap-4.3.1.css">
  </head>

  <body>
    <div class="container" style = "width:900px">
          <?php
            include "header.php";
           ?>
        <section calss = "mt-3">
            <form action="dispatch.php" method="post">
                <div class="form-group row">
                  <label for="callerName" class = "col-sm-4 col-form-label">Caller's Name</label>
                  <div class="col-sm-8">
                        <input type = "text" class = "form-control" id = "callerName" name = "callerName">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="cantactNo" class = "col-sm-4 col-form-label">Cantact Number</label>
                  <div class="col-sm-8">
                        <input type = "text" class = "form-control" id = "cantactNo" name = "cantactNo">
                  </div>
                </div>

                <div class="form-group row">
                  <label for="locationOfIncident" class = "col-sm-4 col-form-label">Location of incident</label>
                  <div class="col-sm-8">
                        <input type = "text" class = "form-control" id = "locationOfIncident" name = "locationOfIncident">

                  </div>
                </div>

                <div class="form-group row">
                  <label for="typeOfIncident" class = "col-sm-4 col-form-label">Type of incident</label>
                  <div class="col-sm-8">
                      <select id = "typeOfIncident" class = "form-control" name = "typeOfIncident">
                          <option value="">Select</option>
                          <?php
                              foreach($incidentTypes as $incidentType){
                                 /*convert $incidentTypes to $incidentType and display
                                  all the incident type
                                  from the database in the select
                                  dropdown list
                                 */
                                echo "<option value=\"" . $incidentType["id"] . "\"> " . $incidentType["type"] . "</option>";
                        //must have the \" this is for the HTML to read the result if without this will not read also can change \" to just '
                              }
                           ?>



                      </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label for="descriptionOfIncident" class = "col-sm-4 col-form-label">Description of incident</label>
                  <div class="col-sm-8">
                    <textarea name="descriptionOfIncident" class = "form-control" row = "5" id = "descriptionOfIncident"></textarea>

                  </div>
                </div>

                <div class="form-group row">
                  <div class="offset-sm-4 col-sm-8">
                        <button type="submit" class = "btn btn-primary" name = "btn_process_call" id = "submit">Process call</button>
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
