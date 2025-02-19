<?php
$html = file_get_contents("example.html");

// Skapar ett random id 
$random_session_id = round(microtime(true) * 3000);

$html = str_replace("---session-id---", $random_session_id, $html);
echo $html;

?>