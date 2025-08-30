<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travelogue</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap');
        
        /* Global overflow and box-sizing fixes */
        * {
            box-sizing: border-box;
        }
        
        html {
            overflow-x: hidden;
        }
        
        body {
            font-family: 'Inter', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            width: 100%;
            max-width: 100vw;
        }
        
        .main-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            font-weight: 700;
            color: white;
            margin: 0;
            padding: 60px 20px 40px 20px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            letter-spacing: -0.02em;
            position: relative;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.8) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .main-title::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            height: 120%;
            background: radial-gradient(ellipse at center, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            z-index: -1;
            border-radius: 50%;
        }
        
        .main-title::after {
            content: '✈️';
            position: absolute;
            top: -10px;
            right: 10px;
            font-size: 2rem;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.3));
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .content-wrapper {
            background: #fafbfc;
            border-radius: 30px 30px 0 0;
            min-height: calc(100vh - 200px);
            padding-top: 40px;
            box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 100vw;
            overflow-x: hidden;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            padding: 20px;
            width: 100%;
            max-width: 100vw;
            justify-content: center;
            align-items: stretch;
        }
        
        .card {
            width: 320px;
            max-width: calc(100vw - 40px);
            background: linear-gradient(145deg, #ffffff 0%, #f8f9ff 100%);
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
            position: relative;
            padding: 0;
            transition: all 0.3s ease;
            border: 1px solid rgba(102, 126, 234, 0.1);
            display: flex;
            flex-direction: column;
        }
        
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.25);
            border-color: rgba(102, 126, 234, 0.3);
        }
        
        .card-image-container {
            position: relative;
            overflow: hidden;
        }
        
        .card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .card:hover img {
            transform: scale(1.05);
        }
        
        .card-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        

        
        .card h3 {
            margin: 0 0 12px 0;
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
            line-height: 1.3;
        }
        
        .card-info {
            /* flex-grow removed to eliminate gap between price and buttons */
        }
        
        .card-info p {
            margin: 6px 0;
            font-size: 14px;
            color: #4a5568;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .card-info strong {
            color: #667eea;
            font-weight: 600;
            min-width: 120px;
            display: inline-block;
        }
        

        
        .card-buttons {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }
        
        .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-align: center;
        }
        
        .btn.primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #4a5568;
            border: 2px solid rgba(102, 126, 234, 0.2);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        
        .btn-secondary:hover {
            background: white;
            border-color: rgba(102, 126, 234, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            color: #667eea;
        }
        


        /* Lebegő részletek panel */
        #detailsPopup {
            position: absolute;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 8px;
            display: none;
            z-index: 999;
            width: 280px;
        }

        #popupForm {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(145deg, #ffffff 0%, #f8f9ff 100%);
            padding: 40px 30px 50px 30px; /* felül 40px, alul 50px */
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.25);
            width: 360px;
            max-width: calc(100vw - 40px);
            z-index: 1000;
            font-family: 'Segoe UI', sans-serif;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        #popupForm h3 {
            font-size: 22px;
            color: #667eea;
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
            padding-top: 10px;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(102, 126, 234, 0.1);
        }

        #popupForm input[type="text"],
        #popupForm input[type="email"] {
            width: 100%;
            box-sizing: border-box;
            padding: 12px 15px;
            margin-bottom: 15px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 12px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        #popupForm input[type="text"]:focus,
        #popupForm input[type="email"]:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
            transform: translateY(-1px);
        }

        #popupForm button {
            padding: 10px 16px;
            border: none;
            border-radius: 24px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 10px;
        }

        #popupForm .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 100%;
            margin-bottom: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
        }

        #popupForm .btn:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        #popupForm .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #667eea;
            border: 2px solid rgba(102, 126, 234, 0.3);
            width: 100%;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
        }

        #popupForm .btn-secondary:hover {
            background: white;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
            color: #5a67d8;
        }

        #popupForm p {
            font-size: 0.8em;
            color: #555;
            margin-top: 15px;
            line-height: 1.4;
        }

        #popup-utazas-nev {
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            color: #764ba2;
            margin: 10px 0 20px 0;
            padding: 10px 15px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 12px;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        /* Blur háttér overlay */
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(173, 216, 230, 0.7); /* világos kék átlátszó */
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: 999;
        }

        /* Szűrő panel */
        .filter-panel {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            border-radius: 20px;
            margin: 20px auto 40px auto;
            max-width: calc(100vw - 40px);
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .filter-title {
            color: white;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .filter-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            min-width: 180px;
        }

        .filter-group label {
            color: white;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .filter-group select,
        .filter-group input {
            padding: 12px 15px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .filter-group select:focus,
        .filter-group input:focus {
            outline: none;
            background: white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        .price-range {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .price-range input {
            width: 120px;
        }

        .price-range span {
            color: white;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .filter-btn {
            padding: 12px 20px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .filter-btn.apply {
            background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
            color: white;
        }

        .filter-btn.apply:hover {
            background: linear-gradient(135deg, #0083b0 0%, #006080 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .filter-btn.reset {
            background: rgba(255, 255, 255, 0.9);
            color: #666;
        }

        .filter-btn.reset:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        /* Responsive design */
        @media (max-width: 1200px) {
            .container {
                justify-content: center;
                padding: 0 20px;
            }
            
            .filter-panel {
                margin: 20px 20px 40px 20px;
                padding: 25px;
            }
        }

        @media (max-width: 768px) {
            .main-title {
                font-size: 3rem;
                padding: 40px 15px 30px 15px;
            }
            
            .main-title::after {
                font-size: 1.5rem;
                top: -5px;
                right: 5px;
            }
            
            .content-wrapper {
                border-radius: 25px 25px 0 0;
                padding-top: 30px;
            }
            
            .filter-panel {
                margin: 15px 10px 30px 10px;
                padding: 20px 15px;
                border-radius: 15px;
            }
            
            .filter-title {
                font-size: 20px;
                margin-bottom: 20px;
            }
            
            .filter-row {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
            }
            
            .filter-group {
                min-width: auto;
            }
            
            .filter-group label {
                font-size: 13px;
                margin-bottom: 6px;
            }
            
            .filter-group select,
            .filter-group input {
                padding: 10px 12px;
                font-size: 13px;
            }
            
            .price-range {
                justify-content: space-between;
                gap: 8px;
            }
            
            .price-range input {
                width: calc(50% - 15px);
                min-width: 100px;
            }
            
            .filter-buttons {
                justify-content: center;
                gap: 8px;
                margin-top: 5px;
            }
            
            .filter-btn {
                padding: 10px 16px;
                font-size: 13px;
                flex: 1;
                max-width: 120px;
            }
            
            .container {
                justify-content: center;
                gap: 15px;
                padding: 0 5px;
            }
            
            .container {
                gap: 20px;
                padding: 10px;
            }
            
            .card {
                width: 100%;
                max-width: 350px;
                margin: 0 auto;
            }
            
            .card img {
                height: 200px;
            }
            
            .card-content {
                padding: 15px;
            }
            
            .card h3 {
                font-size: 18px;
                margin-bottom: 10px;
            }
            
            .card-info p {
                font-size: 13px;
                margin: 4px 0;
            }
            
            .card-info strong {
                min-width: 100px;
                font-size: 12px;
                display: inline-block;
            }
            

            
            .btn {
                padding: 10px 12px;
                font-size: 13px;
            }
            
            #popupForm {
                width: calc(100vw - 40px);
                max-width: 350px;
                padding: 25px 20px 35px 20px;
                margin: 0 20px;
            }
            
            #popupForm h3 {
                font-size: 18px;
            }
            
            #popupForm input[type="text"],
            #popupForm input[type="email"] {
                padding: 10px 12px;
                font-size: 13px;
                margin-bottom: 12px;
            }
            
            #popupForm .btn,
            #popupForm .btn-secondary {
                padding: 10px 16px;
                font-size: 13px;
            }
            
            #popupForm p {
                font-size: 0.75em;
                margin-top: 12px;
            }
            
            #popup-utazas-nev {
                font-size: 15px;
                margin: 8px 0 15px 0;
                padding: 8px 12px;
            }
            
            #detailsPopup {
                width: calc(100vw - 40px);
                max-width: 300px;
                padding: 12px;
                font-size: 13px;
                left: 20px !important;
                right: 20px;
            }
        }

        @media (max-width: 480px) {
            .main-title {
                font-size: 2.5rem;
                padding: 30px 10px 25px 10px;
            }
            
            .main-title::after {
                font-size: 1.2rem;
                top: -3px;
                right: 3px;
            }
            
            .content-wrapper {
                border-radius: 20px 20px 0 0;
                padding-top: 25px;
            }
            
            .filter-panel {
                margin: 10px 5px 25px 5px;
                padding: 15px 10px;
            }
            
            .filter-title {
                font-size: 18px;
                margin-bottom: 15px;
            }
            
            .filter-group select,
            .filter-group input {
                padding: 8px 10px;
                font-size: 12px;
            }
            
            .price-range input {
                width: calc(45% - 5px);
                min-width: 80px;
            }
            
            .container {
                gap: 15px;
                padding: 5px;
            }
            
            .card {
                max-width: 100%;
            }
            
            .card img {
                height: 180px;
            }
            
            .card-content {
                padding: 12px;
            }
            
            .card h3 {
                font-size: 16px;
                margin: 0 0 8px 0;
            }
            
            .card-info p {
                font-size: 12px;
                margin: 3px 0;
            }
            
            .card-info strong {
                min-width: 90px;
                font-size: 11px;
                display: inline-block;
            }
            

            
            .btn {
                padding: 8px 10px;
                font-size: 12px;
            }
            
            #popupForm {
                width: calc(100vw - 20px);
                max-width: none;
                padding: 20px 15px 30px 15px;
                margin: 0 10px;
            }
            
            #popup-utazas-nev {
                font-size: 14px;
                padding: 6px 10px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .container {
                gap: 22px;
                padding: 15px;
                justify-content: center;
                max-width: 100vw;
            }
            
            .card {
                width: calc(50% - 11px);
                max-width: 340px;
                min-width: 280px;
            }
            
            .filter-panel {
                padding: 28px;
                max-width: calc(100vw - 30px);
            }
        }

        @media (min-width: 1025px) {
            .container {
                justify-content: center;
                padding: 20px;
                gap: 25px;
                max-width: 100vw;
            }
            
            .card {
                width: calc(33.333% - 17px);
                max-width: 320px;
                min-width: 280px;
            }
        }

        @media (min-width: 1400px) {
            .container {
                justify-content: center;
                gap: 25px;
                max-width: 100vw;
            }
            
            .card {
                width: calc(25% - 19px);
                max-width: 320px;
                min-width: 280px;
            }
        }

    </style>
</head>
<body>

<h1 class="main-title">Travelogue</h1>

<div class="content-wrapper">
<!-- Szűrő panel -->
<div class="filter-panel">
    <div class="filter-title">Szűrés</div>
    <div class="filter-row">
        <div class="filter-group">
            <label for="filter-helyszin">Helyszín</label>
            <select id="filter-helyszin" onchange="updateIndulasOptions()">
                <option value="">Minden helyszín</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label for="filter-indulas">Indulási helyszín</label>
            <select id="filter-indulas">
                <option value="">Minden indulási hely</option>
            </select>
        </div>
        
        <div class="filter-group">
            <label>Ár</label>
            <div class="price-range">
                <input type="number" id="filter-ar-min" placeholder="Min Ft" min="0" step="10000">
                <span>-</span>
                <input type="number" id="filter-ar-max" placeholder="Max Ft" min="0" step="10000">
            </div>
        </div>
        
        <div class="filter-group">
            <div class="filter-buttons">
                <button class="filter-btn apply" onclick="applyFilters()">Szűrés</button>
                <button class="filter-btn reset" onclick="resetFilters()">Törlés</button>
            </div>
        </div>
    </div>
</div>

<div class="container" id="utazasok-container"></div>

<!-- Blur háttér overlay -->
<div id="overlay" onclick="closeForm()"></div>

<!-- Jelentkezés popup -->
<div id="popupForm">
  <h3>Érdeklődés az alábbi utazás iránt:</h3>
  <div id="popup-utazas-nev" style="font-weight: bold; margin-bottom: 20px;"></div>

  <form action="jelentkezes.php" method="POST">
    <input type="hidden" name="utazas_id" id="popup-utazas-id">
    
    <input type="text" name="teljes_nev" placeholder="Teljes név" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="telefon" placeholder="Telefon" required>
    <input type="text" name="lakcim" placeholder="Lakcím" required>

    <button type="submit" class="btn">Küldés</button>
    <button type="button" class="btn btn-secondary" onclick="closeForm()">Mégsem</button>

    <p class="tajekoztatas">
      <strong>Tájékoztatás:</strong><br>
      A jelentkezési űrlap kitöltése nem minősül végleges foglalásnak. Az adatok elküldésével Ön az utazás iránti érdeklődését jelzi. Munkatársaink a megadott elérhetőségek egyikén keresni fogják Önt a részletek egyeztetése céljából, a foglalás véglegesítésére pedig utazási irodánkban kerül sor.
    </p>
  </form>
</div>


<!-- Lebegő részletek doboz -->
<div id="detailsPopup"></div>

</div> <!-- End of content-wrapper -->

<script>
let lastDetailsId = null;
let allUtazasok = []; // Összes utazás tárolása a szűréshez

function openForm(utazasId, utazasNev) {
    document.getElementById('popup-utazas-id').value = utazasId;
    document.getElementById('popupForm').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
    document.getElementById('popup-utazas-nev').textContent = utazasNev;
    document.getElementById('detailsPopup').style.display = 'none';
    document.body.style.overflow = 'hidden'; // Letiltja a scrollolást
    lastDetailsId = null;
}

function closeForm() {
    document.getElementById('popupForm').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
    document.body.style.overflow = 'auto'; // Visszaállítja a scrollolást
}

function showDetailsPopup(event, utazas) {
    const popup = document.getElementById('detailsPopup');

    // Ha ugyanarra kattintott, tűnjön el
    if (lastDetailsId === utazas.utazas_id) {
        popup.style.display = "none";
        lastDetailsId = null;
        return;
    }

    popup.innerHTML = `
        <strong>Leírás:</strong> ${utazas.leiras}<br>
        <strong>Indulási dátum:</strong> ${utazas.indulasi_datum}<br>
        <strong>Visszaindulás:</strong> ${utazas.visszaindulas_datum}<br>
        <strong>Indulási helyszín:</strong> ${utazas.indulasi_helyszin}
    `;

    // Pozícionálás a gomb alá
    const rect = event.target.getBoundingClientRect();
    popup.style.top = window.scrollY + rect.bottom + 5 + "px";
    popup.style.left = window.scrollX + rect.left + "px";
    popup.style.display = "block";

    lastDetailsId = utazas.utazas_id;
}

// Kattintás máshová: elrejti a popupot
window.addEventListener("click", function(e) {
    const popup = document.getElementById("detailsPopup");
    if (!popup.contains(e.target) && !e.target.classList.contains("details-btn")) {
        popup.style.display = "none";
        lastDetailsId = null;
    }
});

// Szűrő funkciók
function populateFilterOptions() {
    const helyszinSet = new Set();
    
    allUtazasok.forEach(utazas => {
        if (utazas.desztinacio) helyszinSet.add(utazas.desztinacio);
    });
    
    // Helyszín dropdown feltöltése
    const helyszinSelect = document.getElementById('filter-helyszin');
    helyszinSelect.innerHTML = '<option value="">Minden helyszín</option>';
    [...helyszinSet].sort().forEach(helyszin => {
        helyszinSelect.innerHTML += `<option value="${helyszin}">${helyszin}</option>`;
    });
    
    // Indulási helyszín dropdown feltöltése (összes opcióval kezdve)
    updateIndulasOptions();
}

function updateIndulasOptions() {
    const selectedHelyszin = document.getElementById('filter-helyszin').value;
    const indulasSelect = document.getElementById('filter-indulas');
    const currentIndulasValue = indulasSelect.value; // Jelenlegi kiválasztott érték mentése
    
    let availableIndulasok = new Set();
    
    if (selectedHelyszin === '') {
        // Ha nincs helyszín kiválasztva, minden indulási hely elérhető
        allUtazasok.forEach(utazas => {
            if (utazas.indulasi_helyszin) availableIndulasok.add(utazas.indulasi_helyszin);
        });
    } else {
        // Ha van kiválasztott helyszín, csak az ahhoz tartozó indulási helyek
        allUtazasok.forEach(utazas => {
            if (utazas.desztinacio === selectedHelyszin && utazas.indulasi_helyszin) {
                availableIndulasok.add(utazas.indulasi_helyszin);
            }
        });
    }
    
    // Indulási helyszín dropdown újraépítése
    indulasSelect.innerHTML = '<option value="">Minden indulási hely</option>';
    [...availableIndulasok].sort().forEach(indulas => {
        const isSelected = currentIndulasValue === indulas ? 'selected' : '';
        indulasSelect.innerHTML += `<option value="${indulas}" ${isSelected}>${indulas}</option>`;
    });
    
    // Ha a korábban kiválasztott indulási hely már nem elérhető, töröljük a kiválasztást
    if (currentIndulasValue && !availableIndulasok.has(currentIndulasValue)) {
        indulasSelect.value = '';
    }
}

function applyFilters() {
    const helyszinFilter = document.getElementById('filter-helyszin').value;
    const indulasFilter = document.getElementById('filter-indulas').value;
    const arMinFilter = parseInt(document.getElementById('filter-ar-min').value) || 0;
    const arMaxFilter = parseInt(document.getElementById('filter-ar-max').value) || Infinity;
    
    const filteredUtazasok = allUtazasok.filter(utazas => {
        const helyszinMatch = !helyszinFilter || utazas.desztinacio === helyszinFilter;
        const indulasMatch = !indulasFilter || utazas.indulasi_helyszin === indulasFilter;
        const arMatch = utazas.ar >= arMinFilter && utazas.ar <= arMaxFilter;
        
        return helyszinMatch && indulasMatch && arMatch;
    });
    
    displayUtazasok(filteredUtazasok);
}

function resetFilters() {
    document.getElementById('filter-helyszin').value = '';
    document.getElementById('filter-indulas').value = '';
    document.getElementById('filter-ar-min').value = '';
    document.getElementById('filter-ar-max').value = '';
    updateIndulasOptions(); // Indulási helyszínek visszaállítása
    displayUtazasok(allUtazasok);
}

function displayUtazasok(utazasok) {
    const container = document.getElementById('utazasok-container');
    container.innerHTML = '';
    
    if (utazasok.length === 0) {
        container.innerHTML = '<p style="text-align: center; color: #666; font-size: 18px; margin: 40px 0;">Nincs a szűrési feltételeknek megfelelő utazás.</p>';
        return;
    }
    
    utazasok.forEach(utazas => {
        const div = document.createElement('div');
        div.className = 'card';
        div.innerHTML = `
            <div class="card-image-container">
                <img src="${utazas.boritokep}" alt="borítókép" onerror="this.style.display='none'; this.parentElement.style.backgroundColor='#f0f0f0'; this.parentElement.innerHTML='<div style=\\'display:flex;align-items:center;justify-content:center;height:220px;color:#666;\\'>Kép nem található</div>';">
            </div>
            <div class="card-content">
                <h3>${utazas.utazas_elnevezese}</h3>
                <div class="card-info">
                    <p><strong>📅 Indulás:</strong> ${utazas.utazas_ideje}</p>
                    <p><strong>🏝️ Helyszín:</strong> ${utazas.desztinacio}</p>
                    <p><strong>🚌 Indulási hely:</strong> ${utazas.indulasi_helyszin}</p>
                    <p><strong>💰 Ár:</strong> ${parseInt(utazas.ar).toLocaleString()} Ft</p>
                </div>
                <div class="card-buttons">
                    <a class="btn primary" onclick="openForm(${utazas.utazas_id}, '${utazas.utazas_elnevezese.replace(/'/g, "\\'")}')">Érdeklődöm</a>
                    <a class="btn btn-secondary details-btn" onclick='showDetailsPopup(event, ${JSON.stringify(utazas)})'>Részletek</a>
                </div>
            </div>
        `;
        container.appendChild(div);
    });
}

// Betöltjük az utazásokat
fetch('get-utazasok.php')
    .then(response => response.json())
    .then(data => {
        allUtazasok = data; // Összes utazás eltárolása
        populateFilterOptions(); // Szűrő opciók feltöltése
        displayUtazasok(allUtazasok); // Összes utazás megjelenítése
    });
</script>


</body>
</html>
