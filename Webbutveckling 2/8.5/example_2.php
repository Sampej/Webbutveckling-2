<?php

header("Content-type: text/html");

//Kollar om den är secure eller inte. 
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
    echo "session-id-secure = " .$_COOKIE["session_id"] . "<br>";
    echo "name = ".$_GET['name'];
}else{
   header("location: example.php");
}

?>