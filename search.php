<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Search Patrol Car</title>
    <link rel="stylesheet" href="css/bootstrap-4.3.1.css">
  </head>

  <body>
    <div class="container" style = "width:900px">
      <?php
        include "header.php";
       ?>
        <section calss = "mt-3">
            <form method="post" action="update.php">
                <div class="form-group row">
                  <label for="patrolCar" class = "col-sm-3 col-form-label">Patrol Car Number</label>
                  <div class="col-sm-3">
                        <input type = "text" class = "form-control" id = "patrolCarId" name = "patrolCarId">
                  </div>

                  <div class="col-sm-6">
                      <button type="submit" class = "btn btn-primary" name = "btnSearch" id = "submit">Search</button>
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
