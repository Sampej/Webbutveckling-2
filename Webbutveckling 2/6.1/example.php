<?php
header('Content-type: text/html');
// Läser in datan från filen  samt decodar jsondatan och convertera till ett php-obejkt
$json = file_get_contents('dataInfo.json');
$jsonData = json_decode($json, true);

// Hämtar tiden, useragent, RemoteAddr & enhetensnamn
$tid = date('H:i:s Y/m/d');
$httpUserAgent = $_SERVER['HTTP_USER_AGENT'];
$remoteAddr = $_SERVER['REMOTE_ADDR'];
$remoteAddrNamn = gethostbyaddr($_SERVER['REMOTE_ADDR']);

// Skapar en ny array
$data = array(
  "<b>".'Inloggningstiden:'. "</b>"=> $tid, "<b>".'Useragent:'."</b>" => $httpUserAgent,"<b>".
  'RemoteAddr:'."</b>" => $remoteAddr, "<b>".'Enhetensnamn:'."</b>" => $remoteAddrNamn
);

// Addera nya datan till arrayen samt koda arrayen till JSON format
$jsonData[] = $data;
$json = json_encode($jsonData);

// Skriver ut datan
foreach ($jsonData as $visaData) {
    foreach ($visaData as $key => $value) {
        echo $key . ' ' . $value . '<br>' .'<br>';
    }
}

// Datan sparas i filen
$spara = file_put_contents('dataInfo.json', $json);
if ($spara !== false) {
  echo "Datan sparades i filen";
} else {
  echo "Error!";
}

?>

