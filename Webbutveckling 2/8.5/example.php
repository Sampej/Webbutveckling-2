<?php
header("Content-type: text/html");
$html = file_get_contents("example.html");


// Skapar ett random id 
$random_session_id =  round(microtime(true) * 3000);

session_start([
'cookie_lifetime' => 500,
'cookie_secure' => true,
'cookie_httponly' => true,
]);

// Skapar en cookie som varar i 3 timmar som är säker
setcookie("session_id", $random_session_id,time() + 10800);


$html = str_replace("---session-id-secure---", $random_session_id, $html);
echo $html;

?>