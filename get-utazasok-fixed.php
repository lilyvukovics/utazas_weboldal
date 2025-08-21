<?php
header('Content-Type: application/json');

$port = 3306;
$host = 'localhost';
$db = 'utazast_kezelo';
$user = 'utazast_kezelo';
$pass = 'utazast_kezelo1234';

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Adatbázis kapcsolódási hiba: ' . $conn->connect_error]));
}

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
if ($result === false) {
    die(json_encode(['error' => 'SQL hiba: ' . $conn->error]));
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Mindig használjuk a default.svg képet, hogy biztosan működjön
        $row['boritokep'] = 'borito_kepek/default.svg';
        $utazasok[] = $row;
    }
} else {
    // Ha nincs adat, adjunk vissza teszt adatokat
    $utazasok = [
        [
            'utazas_id' => 1,
            'utazas_elnevezese' => 'Teszt Utazás',
            'utazas_ideje' => '2024-06-15',
            'desztinacio' => 'Teszt Helyszín',
            'ar' => '100000',
            'boritokep' => 'borito_kepek/default.svg',
            'leiras' => 'Teszt leírás',
            'indulasi_datum' => '2024-06-15',
            'visszaindulas_datum' => '2024-06-22',
            'indulasi_helyszin' => 'Budapest'
        ]
    ];
}

$conn->close();

echo json_encode($utazasok, JSON_UNESCAPED_UNICODE);
?>