<?php
$host = 'localhost';
$db = 'utazast_kezelo';
$user = 'utazast_kezelo';
$pass = 'utazast_kezelo1234';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

$success = false;
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Beérkező adatok normalizálása
    $utazas_id = isset($_POST['utazas_id']) ? intval($_POST['utazas_id']) : 0;
    $teljes_nev = isset($_POST['teljes_nev']) ? trim($_POST['teljes_nev']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $telefon = isset($_POST['telefon']) ? trim($_POST['telefon']) : '';
    $lakcim = isset($_POST['lakcim']) ? trim($_POST['lakcim']) : '';
    $allapot = 'érdeklődik';
    $regisztracio_idopont = date("Y-m-d H:i:s");

    // Kötelező mezők ellenőrzése
    $hianyzo = [];
    if (!$utazas_id) { $hianyzo[] = 'Utazás azonosító'; }
    if ($teljes_nev === '') { $hianyzo[] = 'Teljes név'; }
    if ($email === '') { $hianyzo[] = 'Email'; }
    if ($telefon === '') { $hianyzo[] = 'Telefon'; }
    if ($lakcim === '') { $hianyzo[] = 'Lakcím'; }

    if (!empty($hianyzo)) {
        $error_message = 'Kérjük, töltse ki az összes mezőt: ' . implode(', ', $hianyzo) . '.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Email formátum ellenőrzése (tartalmaznia kell @ jelet és szabványos formátumot)
        $error_message = 'Kérjük, érvényes email címet adjon meg.';
    } else {
        // Minden rendben, adatbázis művelet
        $stmt = $conn->prepare("INSERT INTO elofoglalas (teljes_nev, telefon, email, lakcim, regisztracio_idopont, utazas_id, allapot)
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $teljes_nev, $telefon, $email, $lakcim, $regisztracio_idopont, $utazas_id, $allapot);

        if ($stmt->execute()) {
            $success = true;
        } else {
            $error_message = 'Hiba történt: ' . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelentkezés visszajelzés</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background: linear-gradient(145deg, #ffffff 0%, #f8f9ff 100%);
            border-radius: 25px;
            padding: 50px 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            width: calc(100% - 40px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px auto;
            animation: bounce 0.6s ease-out;
        }

        .success-icon::before {
            content: "✓";
            color: white;
            font-size: 40px;
            font-weight: bold;
        }

        .error-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px auto;
            animation: shake 0.6s ease-out;
        }

        .error-icon::before {
            content: "✕";
            color: white;
            font-size: 40px;
            font-weight: bold;
        }

        h1 {
            color: #667eea;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(102, 126, 234, 0.1);
        }

        .message {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            padding: 20px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 15px;
            border-left: 4px solid #667eea;
        }

        .error-message {
            color: #e53e3e;
            background: rgba(229, 62, 62, 0.05);
            border-left-color: #e53e3e;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .back-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        .back-button::before {
            content: "←";
            font-size: 18px;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-5px);
            }
            75% {
                transform: translateX(5px);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 25px;
                margin: 20px;
                width: calc(100% - 40px);
            }

            h1 {
                font-size: 24px;
            }

            .message {
                font-size: 14px;
                padding: 15px;
            }

            .back-button {
                padding: 12px 25px;
                font-size: 14px;
            }

            .success-icon,
            .error-icon {
                width: 60px;
                height: 60px;
                margin-bottom: 20px;
            }

            .success-icon::before,
            .error-icon::before {
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($success): ?>
            <div class="success-icon"></div>
            <h1>Köszönjük az érdeklődését!</h1>
            <div class="message">
                Sikeresen rögzítettük jelentkezését.<br><br>
                <strong>Kollégáink hamarosan keresni fogják Önt</strong> a megadott elérhetőségek egyikén a részletek egyeztetése céljából.<br><br>
                A jelentkezési űrlap kitöltése nem minősül végleges foglalásnak. A foglalás véglegesítésére utazási irodánkban kerül sor.
            </div>
        <?php else: ?>
            <div class="error-icon"></div>
            <h1>Hiba történt!</h1>
            <div class="message error-message">
                <?php echo $error_message ?: "Nem sikerült feldolgozni a jelentkezést. Kérjük, próbálja újra később."; ?>
            </div>
        <?php endif; ?>
        
        <a href="index.php" class="back-button">Vissza az utazásokhoz</a>
    </div>
</body>
</html>