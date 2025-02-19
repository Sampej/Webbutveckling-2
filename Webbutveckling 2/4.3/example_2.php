<?php

header("Content-type: text/html");

// Kollar fall session_id finns i kakan
// skriver ut data från formuläret

foreach($_GET as $key => $value){
    echo $key, " = ", $value, "<br>";
}

if(isset($_COOKIE["session_id"])){
    echo "session-id = " .$_COOKIE["session_id"] . "<br>";
}
    

?>