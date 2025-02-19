<?php
header('Content-type: text/html');

include 'example.html'; 

$servername = "atlas.dsv.su.se";
$username = "usr_22326870";
$password = "326870";
$dbNamn = 'db_22326870';
$portNr = 3306;

$connect = mysqli_connect($servername, $username, $password, $dbNamn, $portNr);

// Läser in data från formuläret
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(isset($_POST['name']) ? $_POST['name'] : ''); 
    $email = strip_tags(isset($_POST['email']) ? $_POST['email'] : '');
    $homepage = strip_tags(isset($_POST['homepage']) ? $_POST['homepage'] : '');
    $comment = strip_tags(isset($_POST['comment']) ? $_POST['comment'] : '');

    // Undviker SQL-injektion med hjälp av prepare
    $sql = "INSERT INTO Visitors (name, email, homepage, comment) VALUES (?, ?, ?, ?)";
    $sqlInjection = $connect->prepare($sql);
    $sqlInjection->bind_param("ssss", $name, $email, $homepage, $comment);
    

    // Lägger till datan i tabellen, om något går fel skrivs ett felmeddelande ut 
    if ($sqlInjection->execute()) {
        echo "";
    } else {
        echo "FEL: " . $sql . $sqlInjection->error;
    }

    $sqlInjection->close();
}   

// Laddar in tidigare data från databasen
$formerPosts = mysqli_query($connect, "SELECT * FROM Visitors order by time");

echo "<!--===entries===-->";
$counter = 1;
while ($row = mysqli_fetch_assoc($formerPosts)) {
    
    echo "<b>Inlägg:</b> " . $counter ;
    echo "<br>";
    echo "<br>";
    echo "<b>Tid:</b> " . $row['time'] . "<br />";
    echo "<b>Från:</b> <a href='//" . $row['homepage'] . "'>" . $row['name'] . "</a><br />";
    echo "<b>E-post:</b> <a href='//:" . $row['email'] . "'>" . $row['email'] . "</a><br />";
    echo "<br>";
    echo "<b>Kommentar:</b> " . $row['comment'];
    echo "<br>";
    echo "<hr />";
    $counter++;
}
echo "<!--===entries===-->";

$connect->close();


?>