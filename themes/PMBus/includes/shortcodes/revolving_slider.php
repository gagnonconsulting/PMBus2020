<?php

// Used to make the revolving reel of logos on home page scale to the browser size

function screen_size(){

    session_start();
    if(isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])){

    } else if(isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
      $_SESSION['screen_width'] = $_REQUEST['width'];
      $_SESSION['screen_height'] = $_REQUEST['height'];
      header('Location: ' . $_SERVER['PHP_SELF']);
    } else {
      echo '<script type="text/javascript">window.location = "' . $_SERVER['PHP_SELF'] . '?width="+screen.width+"&height="+screen.height;</script>';
    }
    ?>

  <script>
    function myFunction() {
      var x = screen.width;
      return (x);
    }
    var s = myFunction();
  </script>
  <?php
    $sz = "<script>document.write(Math.floor('s'))</script>"; //I want above javascript variable 'a' value to be store here

    /*
    echo gettype($sz);
    $width = " <script>screen.width; </script>";
    $wi = (int)$width;
    echo $wi;
    echo gettype($width);
    echo $zs; */
    $wid = .95 * $_SESSION['screen_width'];
    return do_shortcode('
      [ihrss-gallery
        type="WIDGET"
        w="'.$wid.'"
        h="75"
        speed="2"
        bgcolor="#FFFFFF"
        gap="1"
      random="YES"]'
    );
}

add_shortcode('full_width_logos', 'screen_size');
