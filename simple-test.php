<?php
echo "<h1>🧪 Alapvető teszt</h1>";

// 1. PHP működik?
echo "<h2>1. PHP teszt</h2>";
echo "✅ PHP működik! Verzió: " . phpversion() . "<br>";
echo "📅 Idő: " . date('Y-m-d H:i:s') . "<br>";

// 2. Hol vagyunk?
echo "<h2>2. Hely teszt</h2>";
echo "📁 Jelenlegi mappa: " . __DIR__ . "<br>";
echo "🌐 Script útvonal: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";

// 3. Léteznek a fájlok?
echo "<h2>3. Fájl teszt</h2>";
$files_to_check = ['index.php', 'get-utazasok.php', 'jelentkezes.php'];
foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "✅ $file létezik<br>";
    } else {
        echo "❌ $file HIÁNYZIK<br>";
    }
}

// 4. Borito_kepek mappa
echo "<h2>4. Képmappa teszt</h2>";
if (is_dir('borito_kepek')) {
    echo "✅ borito_kepek mappa létezik<br>";
    $files = scandir('borito_kepek');
    $image_files = array_filter($files, function($file) {
        return !in_array($file, ['.', '..']) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
    });
    
    if (empty($image_files)) {
        echo "❌ Nincsenek képfájlok a mappában!<br>";
    } else {
        echo "✅ Képfájlok száma: " . count($image_files) . "<br>";
        echo "<h3>Képfájlok:</h3>";
        foreach ($image_files as $img) {
            echo "🖼️ $img<br>";
        }
        
        // Próbáljunk meg megjeleníteni az első képet
        $first_image = reset($image_files);
        echo "<h3>Első kép teszt:</h3>";
        echo "<img src='borito_kepek/$first_image' style='max-width: 200px; border: 2px solid green;' alt='teszt kép'><br>";
        echo "Kép útvonal: borito_kepek/$first_image<br>";
    }
} else {
    echo "❌ borito_kepek mappa NEM létezik!<br>";
    echo "<h3>Elérhető mappák:</h3>";
    $dirs = glob('*', GLOB_ONLYDIR);
    foreach ($dirs as $dir) {
        echo "📁 $dir<br>";
    }
}

// 5. Adatbázis egyszerű teszt
echo "<h2>5. Adatbázis teszt</h2>";
try {
    $conn = new mysqli('localhost', 'utazast_kezelo', 'utazast_kezelo1234', 'utazast_kezelo');
    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }
    echo "✅ Adatbázis kapcsolat OK<br>";
    
    // Egyszerű lekérdezés
    $result = $conn->query("SELECT COUNT(*) as count FROM utazas");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "✅ Utazások száma: " . $row['count'] . "<br>";
    }
    
    $conn->close();
} catch (Exception $e) {
    echo "❌ Adatbázis hiba: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>🔧 Mit csinálj most:</h2>";
echo "<ol>";
echo "<li>Nyisd meg ezt: <strong>http://localhost/utazas/simple-test.php</strong></li>";
echo "<li>Nézd meg, hogy minden ✅ zöld-e</li>";
echo "<li>Ha valami ❌ piros, azt kell megoldani először</li>";
echo "<li>Írd meg, hogy mit látsz!</li>";
echo "</ol>";
?>