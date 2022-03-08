<?php
    ob_start();
    if(isset($_SESSION) == false){
      session_start();
    }

    $has_session_display_name = isset($_SESSION["SESS_DISPLAYNAME"]);
    if($has_session_display_name == true){
      $_SESSION["SESS_DISPLAYNAME"] = null;
      session_destroy();
    }

    $has_cookie_display_name = isset($_COOKIE["COOKIE_DISPLAYNAME"]);
    if($has_cookie_display_name == true){
      unset($_COOKIE["COOKIE_DISPLAYNAME"]);
      setcookie("COOKIE_DISPLAYNAME" , null , -1);
    }
    header("location:login.php");
 ?>
