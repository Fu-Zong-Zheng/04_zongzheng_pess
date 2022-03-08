<?php
ob_start();
//check if the Session exists , then redirect user to home page
//Make sure statr the session 1st
    if(isset($_SESSION) == false){
      session_start();
    }
    $has_cookie_display_name = isset($_COOKIE["COOKIE_DISPLAYNAME"]);
    if($has_cookie_display_name == true){
      /*
        If there is a cookie's value from previous login, then load the value
      in to the session.
      */
      $_SESSION["SESS_DISPLAYNAME"] = $_COOKIE["COOKIE_DISPLAYNAME"];
    }

    if(isset($_SESSION["SESS_DISPLAYNAME"])){
      header("location:logcall.php");
    }
    //check the login button
    $is_loginbutton_click = isset($_POST["btnSubmit"]);

    if($is_loginbutton_click == true){
      $user_name = $_POST["tbUsername"]; //get inputs
      $password = $_POST["tbPassword"]; //get inputs

      if($user_name == "Heiman" && $password == "password"){
        $_SESSION["SESS_DISPLAYNAME"] = "Heiman";
        //if both username and password have then the server(session) will document the value "Heiman".
        $has_remember_me_check = isset($_POST["cbRememberMe"]);
        if($has_remember_me_check == true){
            //will set the cookie to expire in 30 days
            //if set to 0 or not specificed the cookie will expire
            //at the end of the seesion (when close the browser)

          $expiry_time = time() + 60 * 60 * 24 * 30;
          setcookie("COOKIE_DISPLAYNAME" , "Heiman" , $expiry_time);
        }
        header("location:logcall.php");
      }
      else{
        echo "<span style='color:red'>Wrong Username or Password</span>";
      }
    }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Log in</title>
  </head>
  <body>
    <h2>Customer login</h2>
    <p>
        Please enter your user name and password to lo in to the website.<br>
        If you do not have an account you can et one free by <a href="register.php">registering</a>
    </p>
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
      <table>
        <tbody>
          <tr>
            <td>Username</td>
            <td><input type="textbox" name="tbUsername" id="tbUsername"></td>
          </tr>

          <tr>
            <td>Password</td>
            <td><input type="password" name="tbPassword" id="tbPassword"></td>
          </tr>

          <tr>
            <td></td>
            <td><input type="checkbox" name="cbRememberMe" id="cbRememberMe" value="Yes"></td>
          </tr>

          <tr>
            <td></td>
            <td><input type="submit" name="btnSubmit" id="btnSubmit" value="Log in"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </body>
</html>
