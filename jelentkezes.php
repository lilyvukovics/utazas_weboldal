<?php
$host = 'localhost';
$db = 'utazast_kezelo';
$user = 'utazast_kezelo';
$pass = 'utazast_kezelo1234';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$utazas_id = $_POST['utazas_id'];
$teljes_nev = $_POST['teljes_nev'];
$email = $_POST['email'];
$telefon = $_POST['telefon'];
$lakcim = $_POST['lakcim'];
$allapot = 'érdeklődik';
$regisztracio_idopont = date("Y-m-d H:i:s");

$stmt = $conn->prepare("INSERT INTO elofoglalas (teljes_nev, telefon, email, lakcim, regisztracio_idopont, utazas_id, allapot)
                        VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssis", $teljes_nev, $telefon, $email, $lakcim, $regisztracio_idopont, $utazas_id, $allapot);

if ($stmt->execute()) {
    echo "Sikeres jelentkezés!";
} else {
    echo "Hiba történt: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
