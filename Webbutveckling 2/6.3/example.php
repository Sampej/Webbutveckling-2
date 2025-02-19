<?php
header('Content-type: text/html');

include 'example.html'; 

$servername = "atlas.dsv.su.se";
$username = "usr_22326870";
$password = "326870";
$dbNamn = 'db_22326870';
$portNr = 3306;

$connect = mysqli_connect($servername, $username, $password, $dbNamn, $portNr);

try{    

    // Läser in data från formuläret
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $connect->begin_transaction();
    
        $name = strip_tags(isset($_POST['name']) ? $_POST['name'] : ''); 
        $email = strip_tags(isset($_POST['email']) ? $_POST['email'] : '');
        $homepage = strip_tags(isset($_POST['homepage']) ? $_POST['homepage'] : '');
        $comment = strip_tags(isset($_POST['comment']) ? $_POST['comment'] : '');
        
        // skapar ett random
        function randomHex($bytes=4) {
            return bin2hex(openssl_random_pseudo_bytes($bytes));
          }
    
          $id = randomHex(50);

        // Undviker SQL-injektion med hjälp av prepare
        $sql = "INSERT INTO Entries (ID ,name, email, homepage, comment) VALUES (?, ?, ?, ?, ?)";
        $sqlInjection = $connect->prepare($sql);
        $sqlInjection->bind_param("sssss",$id ,$name, $email, $homepage, $comment);
    
    
        // Lägger till datan i tabellen
        if ($sqlInjection->execute()) {
            echo "";
        } else {
            echo "FEL: " . $sql . $sqlInjection->error;
        }
        if (!empty($_FILES['file']['tmp_name'])){
            $imageData = file_get_contents($_FILES['file']['tmp_name']);
            $mimeType = $_FILES['file']['type'];
            $sql = "INSERT INTO Bilder (Entry_ID, bild, mimeType) VALUES (?, ?, ?)";
            $statement = $connect->prepare($sql);
            $statement->bind_param("sbs", $id ,$imageData, $mimeType);
            $statement->send_long_data(1, $imageData); 
            $statement -> execute();
        }
        
        $connect->commit();
    
        $sqlInjection->close();
    }   

} catch (Exception $e) {
    // Felmeddelande
    $connect->rollback();
    echo "FEL: " . $e->getMessage();

}

// Laddar in tidigare data från databasen
$formerPosts = mysqli_query($connect, "SELECT Entries.*,Bilder.bild FROM Entries left join Bilder on Entries.id = Bilder.Entry_ID order by time");

// Läser in data från formuläret
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

    if (!empty($row['bild'])) {
        $imageData = base64_encode($row['bild']);
        echo "<img src='data:image/jpeg;base64,{$imageData}' alt='Bild'>";
    }
    echo "<hr />";

    $counter++;
}
echo "<!--===entries===-->";

$connect->close();


?>  