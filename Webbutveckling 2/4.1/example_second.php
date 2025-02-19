<?php

header("Content-type: text/html");

// Skriver ut data från formuläret
foreach($_GET as $key => $value){
    echo $key, " = ", $value, "<br>";
}


?>