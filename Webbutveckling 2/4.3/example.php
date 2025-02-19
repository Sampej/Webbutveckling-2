<?php
header("Content-type: text/html");
$html = file_get_contents("example.html");

// Skapar ett random id med hjälp av session_id()
  session_start();   
  $random_session_id = session_id();

// Skapar en cookie som varar i 3 timmar. 
setcookie("session_id", $random_session_id,time() + 10800);

    $html = str_replace("---session-id---", $random_session_id, $html);
    echo $html;

?>