<?php
  ob_start();
  $has_cookie_display_name = isset($_COOKIE["COOKIE_DISPLAYNAME"]);
  if($has_cookie_display_name == true){
    $_cookie_Display_name = $_COOKIE["COOKIE_DISPLAYNAME"];
    echo "Welcome <strong>" . $_cookie_Display_name . "!</strong> [<a href='logout.php'>Log out</a>]";
  }
  else{
    if(isset($_SESSION) == false){
      session_start();
    }
    //Check for session
    $has_session_display_name = isset($_SESSION["SESS_DISPLAYNAME"]);
    if($has_session_display_name == true){
      $session_display_name = $_SESSION["SESS_DISPLAYNAME"];
      echo "Welcome <strong>" .   $session_display_name . "!</strong> [<a href='logout.php'>Log out</a>]";
    }
    else{
      echo "<a href='login.php'>Login</a>";
    }
  }
 ?>


<header>
  <img src="images/jingche.jpg" class = "img-fluid" alt="PESS">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
<div class="collapse navbar-collapse" id="navbarSupportedContent1">
<ul class="navbar-nav mr-auto">
  <li class="nav-item active"> <a class="nav-link" href="logcall.php">Home<span class="sr-only">(current)</span></a> </li>
  <li class="nav-item"> <a class="nav-link" href="dispatch.php">Dispatch</a> </li>

  <li class="nav-item"> <a class="nav-link" href="search.php">Search</a> </li>





  </li>
</ul>

</div>
</nav>
</header>
