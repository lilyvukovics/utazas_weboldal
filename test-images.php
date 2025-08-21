<?php
// Teszt fájl a képek ellenőrzésére

// 1. Ellenőrizzük, hogy létezik-e a borito_kepek mappa
echo "<h2>Mappa ellenőrzés:</h2>";
if (is_dir('borito_kepek')) {
    echo "✅ A 'borito_kepek' mappa létezik<br>";
    
    // Listázzuk ki a mappában lévő fájlokat
    $files = scandir('borito_kepek');
    echo "<h3>Fájlok a mappában:</h3>";
    foreach ($files as $file) {
        if ($file != '.' && $file != '..') {
            echo "📁 " . $file . "<br>";
        }
    }
} else {
    echo "❌ A 'borito_kepek' mappa NEM létezik<br>";
}

echo "<hr>";

// 2. Teszteljük az adatbázis kapcsolatot és a képek lekérdezését
echo "<h2>Adatbázis teszt:</h2>";

$port = 3306;
$host = 'localhost';
$db = 'utazast_kezelo';
$user = 'utazast_kezelo';
$pass = 'utazast_kezelo1234';

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    echo "❌ Adatbázis kapcsolódási hiba: " . $conn->connect_error;
} else {
    echo "✅ Adatbázis kapcsolat OK<br>";
    
    $sql = "SELECT utazas_id, utazas_elnevezese, boritokep FROM utazas u INNER JOIN utazas_reszletek r ON u.utazas_id = r.utazas_id LIMIT 3";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<h3>Első 3 utazás adatai:</h3>";
        while ($row = $result->fetch_assoc()) {
            echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
            echo "<strong>ID:</strong> " . $row['utazas_id'] . "<br>";
            echo "<strong>Név:</strong> " . $row['utazas_elnevezese'] . "<br>";
            echo "<strong>Eredeti kép:</strong> " . $row['boritokep'] . "<br>";
            
            $full_path = 'borito_kepek/' . $row['boritokep'];
            echo "<strong>Teljes útvonal:</strong> " . $full_path . "<br>";
            
            // Ellenőrizzük, hogy létezik-e a fájl
            if (file_exists($full_path)) {
                echo "✅ Fájl létezik<br>";
                echo "<img src='" . $full_path . "' style='max-width: 200px; height: auto;' alt='teszt kép'><br>";
            } else {
                echo "❌ Fájl NEM létezik<br>";
            }
            echo "</div>";
        }
    } else {
        echo "❌ Nincs adat az adatbázisban vagy hiba történt<br>";
    }
    
    $conn->close();
}
?>