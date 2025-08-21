<?php
header('Content-Type: application/json');

$port = 3306;
$host = 'localhost';
$db = 'utazast_kezelo';
$user = 'utazast_kezelo';
$pass = 'utazast_kezelo1234';

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Adatbázis kapcsolódási hiba']));
}

// Részletes lekérdezés
$sql = "SELECT 
    u.utazas_id, 
    u.utazas_elnevezese, 
    u.utazas_ideje, 
    u.desztinacio,
    r.ar, 
    r.boritokep,
    r.leiras,
    r.indulasi_datum,
    r.visszaindulas_datum,
    r.indulasi_helyszin
FROM utazas u
INNER JOIN utazas_reszletek r ON u.utazas_id = r.utazas_id";

$result = $conn->query($sql);

$utazasok = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add the path prefix in PHP instead of SQL
        if (!empty($row['boritokep'])) {
            $row['boritokep'] = 'borito_kepek/' . $row['boritokep'];
        } else {
            // Ha nincs kép megadva, használjunk egy alapértelmezett képet
            $row['boritokep'] = 'borito_kepek/default.svg';
        }
        $utazasok[] = $row;
    }
}

$conn->close();

echo json_encode($utazasok, JSON_UNESCAPED_UNICODE);
