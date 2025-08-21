<?php
echo "<h1>Debug - Mi van az adatbázisban?</h1>";

$port = 3306;
$host = 'localhost';
$db = 'utazast_kezelo';
$user = 'utazast_kezelo';
$pass = 'utazast_kezelo1234';

// Próbáljunk csatlakozni
echo "<h2>1. Adatbázis kapcsolat teszt:</h2>";
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    echo "<p style='color:red;'>Kapcsolódási hiba: " . $conn->connect_error . "</p>";
    exit;
} else {
    echo "<p style='color:green;'>Sikeres kapcsolódás!</p>";
}

// Lekérdezzük az adatokat
echo "<h2>2. Adatok az adatbázisból:</h2>";
$sql = "SELECT 
    u.utazas_id, 
    u.utazas_elnevezese, 
    r.boritokep
FROM utazas u
INNER JOIN utazas_reszletek r ON u.utazas_id = r.utazas_id
LIMIT 5";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Név</th><th>Boritokep (nyers)</th><th>Teljes útvonal</th><th>Fájl létezik?</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        $raw_boritokep = $row['boritokep'];
        $full_path = !empty($raw_boritokep) ? 'borito_kepek/' . $raw_boritokep : 'borito_kepek/default.svg';
        $file_exists = file_exists($full_path) ? 'IGEN' : 'NEM';
        $file_color = file_exists($full_path) ? 'green' : 'red';
        
        echo "<tr>";
        echo "<td>" . $row['utazas_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['utazas_elnevezese']) . "</td>";
        echo "<td>" . htmlspecialchars($raw_boritokep) . "</td>";
        echo "<td>" . htmlspecialchars($full_path) . "</td>";
        echo "<td style='color: $file_color;'>" . $file_exists . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p style='color:red;'>Nincs adat az adatbázisban vagy hiba történt!</p>";
}

// Nézzük meg, milyen fájlok vannak a könyvtárban
echo "<h2>3. Fájlok a borito_kepek könyvtárban:</h2>";
$files = scandir('borito_kepek');
echo "<ul>";
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $size = filesize('borito_kepek/' . $file);
        echo "<li>$file ($size byte)</li>";
    }
}
echo "</ul>";

$conn->close();
?>