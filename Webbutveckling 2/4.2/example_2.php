<?php

header("Content-type: text/html");

// Kollar fall session_id finns i kakan
// skriver ut data från formuläret
if(isset($_COOKIE["session_id"])){
    echo "session id " .$_COOKIE["session_id"] . "<br>";
}

if(isset($_GET['name'])){
    echo "name = ".$_GET['name'];
}
    


?>