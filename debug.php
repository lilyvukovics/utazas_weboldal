<?php
echo "<h1>🔍 Image Debug Tool</h1>";
echo "<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.section { border: 1px solid #ddd; padding: 15px; margin: 15px 0; border-radius: 5px; }
.ok { color: green; font-weight: bold; }
.error { color: red; font-weight: bold; }
.warning { color: orange; font-weight: bold; }
img { max-width: 200px; border: 1px solid #ccc; margin: 5px; }
</style>";

// 1. Check current directory and file structure
echo "<div class='section'>";
echo "<h2>📁 File Structure Check</h2>";
echo "<strong>Current working directory:</strong> " . getcwd() . "<br>";

if (is_dir('borito_kepek')) {
    echo "<span class='ok'>✅ 'borito_kepek' directory exists</span><br>";
    
    $files = array_diff(scandir('borito_kepek'), array('.', '..'));
    if (empty($files)) {
        echo "<span class='error'>❌ Directory is empty!</span><br>";
    } else {
        echo "<span class='ok'>✅ Found " . count($files) . " files:</span><br>";
        foreach ($files as $file) {
            $fullPath = 'borito_kepek/' . $file;
            $size = filesize($fullPath);
            echo "  📄 $file (" . round($size/1024, 1) . " KB)<br>";
        }
    }
} else {
    echo "<span class='error'>❌ 'borito_kepek' directory does NOT exist!</span><br>";
    echo "<strong>Available directories:</strong><br>";
    $dirs = glob('*', GLOB_ONLYDIR);
    foreach ($dirs as $dir) {
        echo "  📁 $dir<br>";
    }
}
echo "</div>";

// 2. Database connection and data check
echo "<div class='section'>";
echo "<h2>🗄️ Database Check</h2>";

$host = 'localhost';
$db = 'utazast_kezelo';
$user = 'utazast_kezelo';
$pass = 'utazast_kezelo1234';

try {
    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }
    
    echo "<span class='ok'>✅ Database connection successful</span><br>";
    
    // Check what's actually in the database
    $sql = "SELECT utazas_id, utazas_elnevezese, boritokep FROM utazas u INNER JOIN utazas_reszletek r ON u.utazas_id = r.utazas_id LIMIT 5";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<span class='ok'>✅ Found " . $result->num_rows . " travel records</span><br>";
        echo "<h3>Raw database data:</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Name</th><th>Image (raw)</th><th>Full Path</th><th>File Exists?</th><th>Preview</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            $fullPath = 'borito_kepek/' . $row['boritokep'];
            $fileExists = file_exists($fullPath);
            
            echo "<tr>";
            echo "<td>" . $row['utazas_id'] . "</td>";
            echo "<td>" . htmlspecialchars($row['utazas_elnevezese']) . "</td>";
            echo "<td>" . htmlspecialchars($row['boritokep']) . "</td>";
            echo "<td>" . htmlspecialchars($fullPath) . "</td>";
            echo "<td>" . ($fileExists ? "<span class='ok'>✅ Yes</span>" : "<span class='error'>❌ No</span>") . "</td>";
            echo "<td>";
            if ($fileExists) {
                echo "<img src='$fullPath' alt='preview'>";
            } else {
                echo "<span class='error'>File not found</span>";
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<span class='error'>❌ No data found in database</span><br>";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<span class='error'>❌ Database error: " . $e->getMessage() . "</span><br>";
}
echo "</div>";

// 3. Test the actual API response
echo "<div class='section'>";
echo "<h2>🔌 API Response Test</h2>";

if (file_exists('get-utazasok.php')) {
    echo "<span class='ok'>✅ get-utazasok.php exists</span><br>";
    
    // Simulate the API call
    ob_start();
    include 'get-utazasok.php';
    $apiResponse = ob_get_clean();
    
    echo "<h3>API Response:</h3>";
    echo "<textarea style='width: 100%; height: 200px;'>" . htmlspecialchars($apiResponse) . "</textarea><br>";
    
    $decoded = json_decode($apiResponse, true);
    if (json_last_error() === JSON_ERROR_NONE) {
        echo "<span class='ok'>✅ Valid JSON response</span><br>";
        if (!empty($decoded)) {
            echo "<span class='ok'>✅ Contains " . count($decoded) . " records</span><br>";
            echo "<h4>First record image path:</h4>";
            if (isset($decoded[0]['boritokep'])) {
                echo "<strong>Path:</strong> " . htmlspecialchars($decoded[0]['boritokep']) . "<br>";
                if (file_exists($decoded[0]['boritokep'])) {
                    echo "<span class='ok'>✅ File exists</span><br>";
                    echo "<img src='" . $decoded[0]['boritokep'] . "' alt='test'>";
                } else {
                    echo "<span class='error'>❌ File does not exist</span><br>";
                }
            }
        } else {
            echo "<span class='warning'>⚠️ Empty response</span><br>";
        }
    } else {
        echo "<span class='error'>❌ Invalid JSON: " . json_last_error_msg() . "</span><br>";
    }
} else {
    echo "<span class='error'>❌ get-utazasok.php does not exist</span><br>";
}
echo "</div>";

// 4. Browser console JavaScript test
echo "<div class='section'>";
echo "<h2>🌐 Frontend Test</h2>";
echo "<button onclick='testAPI()'>Test API Call</button>";
echo "<div id='apiResult'></div>";
echo "<script>
function testAPI() {
    fetch('get-utazasok.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('apiResult').innerHTML = 
                '<h4>API Response:</h4><pre>' + JSON.stringify(data, null, 2) + '</pre>';
            
            if (data.length > 0) {
                const firstImage = data[0].boritokep;
                document.getElementById('apiResult').innerHTML += 
                    '<h4>Testing first image:</h4>' +
                    '<p>Path: ' + firstImage + '</p>' +
                    '<img src=\"' + firstImage + '\" alt=\"test\" style=\"max-width: 200px; border: 1px solid red;\" onerror=\"this.style.border=\\'3px solid red\\'; this.alt=\\'FAILED TO LOAD\\';\" onload=\"this.style.border=\\'3px solid green\\';\"/>';
            }
        })
        .catch(error => {
            document.getElementById('apiResult').innerHTML = 
                '<span class=\"error\">Error: ' + error + '</span>';
        });
}
</script>";
echo "</div>";
?>