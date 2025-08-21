<?php
header('Content-Type: text/html; charset=utf-8');

echo "<h1>API Teszt - Mit ad vissza a get-utazasok.php</h1>";

// Szimuláljuk az API hívást
ob_start();
include 'get-utazasok.php';
$api_response = ob_get_clean();

echo "<h2>Nyers API válasz:</h2>";
echo "<pre>" . htmlspecialchars($api_response) . "</pre>";

echo "<h2>Feldolgozott adatok:</h2>";
$data = json_decode($api_response, true);

if ($data) {
    foreach ($data as $index => $utazas) {
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
        echo "<h3>Utazás " . ($index + 1) . ": " . htmlspecialchars($utazas['utazas_elnevezese']) . "</h3>";
        echo "<p><strong>Boritokep mező:</strong> '" . htmlspecialchars($utazas['boritokep']) . "'</p>";
        
        // Ellenőrizzük, hogy létezik-e a fájl
        $file_path = $utazas['boritokep'];
        if (file_exists($file_path)) {
            echo "<p style='color: green;'>✓ Fájl létezik: $file_path</p>";
            echo "<p>Fájl mérete: " . filesize($file_path) . " byte</p>";
        } else {
            echo "<p style='color: red;'>✗ Fájl NEM létezik: $file_path</p>";
        }
        
        echo "</div>";
    }
} else {
    echo "<p style='color: red;'>Nem sikerült feldolgozni a JSON választ!</p>";
}
?>