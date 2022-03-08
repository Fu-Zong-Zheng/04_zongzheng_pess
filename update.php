<?php
  require_once "db.php";
  $is_btnSearch_click = isset($_POST["btnSearch"]);
  $car = null; 
  $statuses = [];
  if($is_btnSearch_click == true){
      $car_id = $_POST["patrolCarId"];
      //echo "your car id is: " . $car_id;
      $sql = "SELECT * FROM `patrolcar` WHERE `patrolcar_id` = '" . $car_id . "'";
      $conn = new mysqli (DB_SERVER , DB_USER , DB_PASSWORD , DB_DATABASE);
      $result = $conn->query($sql);
      if($row = $result->fetch_assoc()){
        $car_id = $row["patrolcar_id"];
        $status_id = $row["patrolcar_status_id"];
        $car = [];
        $car ["id"] = $car_id;
        $car ["status_id"] = $status_id;
      }

      $conn = new mysqli (DB_SERVER , DB_USER , DB_PASSWORD , DB_DATABASE);
      $sql = "SELECT * FROM patrolcar_status";
      $result = $conn->query($sql);
      while($row = $result->fetch_assoc()){
          $id = $row["patrolcar_status_id"];
          $title = $row["patrolcar_status_desc"];
          $status = [];
          $status ["id"] = $id;
          $status ["title"] = $title;
          array_push($statuses,$status);
      }

      $conn->close();

  }


    $btn_update_click = isset($_POST["btnUpdate"]);
    if($btn_update_click == true){
        $update_sucess = false;
        $conn = new mysqli (DB_SERVER , DB_USER , DB_PASSWORD , DB_DATABASE);
        $new_status_id = $_POST["carStatus"];
        $car_id = $_POST["patrolCarId"];

        $sql = "UPDATE `patrolcar` SET `patrolcar_status_id`=" . $new_status_id . " WHERE `patrolcar_id`='" . $car_id . "'";
        $update_sucess = $conn->query($sql);

        if($update_sucess == false){
          echo "Error: " . $sql . "<br>" . $conn->error;
        }

        if($new_status_id == 4){ //Arr
          $sql = "UPDATE `dispatch` SET `time_arrived`=now() WHERE time_arrived IS null AND patrolcar_id = '" . $car_id . "'";
          $update_sucess = $conn->query($sql);

          if($update_sucess == false){
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
        else if($new_status_id == 3){
          $sql = "SELECT incident_id FROM `dispatch` WHERE time_completed IS null AND patrolcar_id='" . $car_id . "'";
          $result = $conn->query($sql);
          $incident_id = 0;
          if($result->num_rows > 0){
            if($row = $result->fetch_assoc()){
              $incident_id = $row["incident_id"];

            }
          }

          $sql = "UPDATE `dispatch` SET `time_completed`=now() WHERE time_completed IS null AND patrolcar_id = '" . $car_id . "'";
          $update_sucess = $conn->query($sql);

          if($update_sucess == false){
            echo "Error: " . $sql . "<br>" . $conn->error;
          }

          $sql = "UPDATE `incident` SET `incident_status_id`=3 WHERE incident_id = '" . $incident_id . "'";
          $update_sucess = $conn->query($sql);

          if($update_sucess == false){
            echo "Error: " . $sql . "<br>" . $conn->error;
          }
        }
        $conn->close();

        if($update_sucess == true){
            header("location:search.php");
        }
    }
 ?>



<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Update Patrol Cr</title>
    <link rel="stylesheet" href="css/bootstrap-4.3.1.css">
  </head>

  <body>
    <div class="container" style = "width:900px">
      <?php
        include "header.php";
       ?>
        <section calss = "mt-3">
            <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>" method="post">
            <?php
              if($car != null){
                  echo "<div class=\"form-group row\">
                    <label for=\"patrolCarId\" class = \"col-sm-4 col-form-label\">Patrol Car Number</label>
                    <div class=\"col-sm-8\">
                          <span>
                              " . $car["id"] . "
                              <input type = \"hidden\" id = \"patrolCarId\" name = \"patrolCarId\" value = \"" . $car["id"] . "\">
                          </span>
                    </div>
                  </div>

                  <div class=\"form-group row\">
                    <label for=\"cantactNo\" class = \"col-sm-4 col-form-label\">Patrol Car Status</label>
                    <div class=\"col-sm-8\">
                      <select id=\"carStatus\" class=\"form-control\" name=\"carStatus\">
                        <option value=\"\">Select</option>
                        ";
                        $selected = "";
                        foreach($statuses as $status){
                          if($status ["id"] == $car ["status_id"]){
                            $selected = "selected=\"selected\"";
                          }
                          echo "<option value=\"" . $status ["id"] . "\" " . $selected . ">" . $status ["title"] . "</option>";
                          $selected = "";
                        }

                        echo
                        "


                      </select>
                    </div>
                  </div>



                  <div class=\"form-group row\">
                    <div class=\"offset-sm-4 col-sm-8\">
                          <button type=\"submit\" class = \"btn btn-primary\" name = \"btnUpdate\" id = \"submit\">Update</button>
                    </div>
                  </div>";
              }
              else{
                echo   "<div class=\"form-group row\">
                    <div class=\"col-sm-12\">
                        No records found.
                    </div>
                  </div>";
              }
             ?>

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
