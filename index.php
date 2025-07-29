<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elérhető utazások</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 2px 2px 6px #ccc;
            position: relative;
            padding: 10px;
        }
        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }
        .card h3 {
            margin: 10px 0 5px;
        }
        .btn {
            margin: 6px 6px 0 0;
            display: inline-block;
            padding: 8px 12px;
            background-color: dodgerblue;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-secondary {
            background-color: darkslategray;
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
            background: white;
            padding: 40px 30px 50px 30px; /* felül 40px, alul 50px */
            border-radius: 16px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
            width: 360px;
            z-index: 1000;
            font-family: 'Segoe UI', sans-serif;
        }

        #popupForm h3 {
            font-size: 20px;
            color: #333;
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
            padding-top: 10px; /* ÚJ: ad térközt a teteje és a konténer között */
        }

        #popupForm input[type="text"],
        #popupForm input[type="email"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
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
            background-color: #00b4d8;
            color: white;
            width: 100%;
            margin-bottom: 10px;
            transition: background-color 0.2s ease-in-out;
        }

        #popupForm .btn:hover {
            background-color: #0096c7;
        }

        #popupForm .btn-secondary {
            background-color: #adb5bd;
            color: white;
            width: 100%;
            margin-bottom: 20px; /* ÚJ: térköz az aljához */
        }

        #popupForm .btn-secondary:hover {
            background-color: #6c757d;
        }

        #popupForm p {
            font-size: 0.8em;
            color: #555;
            margin-top: 15px;
            line-height: 1.4;
        }

        #popup-utazas-nev {
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            color: #0077cc;  /* vagy #333, ha visszafogottabb kell */
            margin: 10px 0 20px 0;
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
            max-width: 900px;
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
            body {
                padding: 0 10px;
            }
            
            h1 {
                text-align: center;
                font-size: 28px;
                margin: 20px 0;
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
            
            .card {
                width: 100%;
                max-width: 350px;
                margin: 0 auto;
            }
            
            .card img {
                height: 200px;
            }
            
            .card h3 {
                font-size: 18px;
            }
            
            .card p {
                font-size: 14px;
            }
            
            .btn {
                padding: 6px 10px;
                font-size: 13px;
                margin: 4px 4px 0 0;
            }
            
            #popupForm {
                width: calc(100vw - 40px);
                max-width: 350px;
                padding: 30px 20px 40px 20px;
                margin: 0 20px;
            }
            
            #popupForm h3 {
                font-size: 18px;
            }
            
            #popupForm input[type="text"],
            #popupForm input[type="email"] {
                padding: 8px 10px;
                font-size: 13px;
                margin-bottom: 12px;
            }
            
            #popupForm button {
                padding: 8px 14px;
                font-size: 13px;
            }
            
            #popupForm p {
                font-size: 0.75em;
                margin-top: 12px;
            }
            
            #popup-utazas-nev {
                font-size: 16px;
                margin: 8px 0 15px 0;
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
            h1 {
                font-size: 24px;
                margin: 15px 0;
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
            
            .card {
                max-width: 100%;
                padding: 8px;
            }
            
            .card img {
                height: 180px;
            }
            
            .card h3 {
                font-size: 16px;
                margin: 8px 0 4px;
            }
            
            .card p {
                font-size: 13px;
                margin: 3px 0;
            }
            
            .btn {
                padding: 5px 8px;
                font-size: 12px;
                margin: 3px 3px 0 0;
            }
            
            #popupForm {
                width: calc(100vw - 20px);
                max-width: none;
                padding: 20px 15px 30px 15px;
                margin: 0 10px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .container {
                gap: 18px;
                padding: 0 15px;
            }
            
            .card {
                width: calc(50% - 9px);
                max-width: 320px;
            }
            
            .filter-panel {
                padding: 28px;
            }
        }

        @media (min-width: 1025px) {
            .container {
                justify-content: flex-start;
                padding: 0 20px;
            }
            
            .card {
                width: calc(33.333% - 14px);
                max-width: 300px;
            }
        }

        @media (min-width: 1400px) {
            .container {
                justify-content: center;
            }
            
            .card {
                width: calc(25% - 15px);
                max-width: 300px;
            }
        }

    </style>
</head>
<body>

<h1>Elérhető utazások</h1>

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
            <img src="kepek/${utazas.boritokep}" alt="borítókép">
            <h3>${utazas.utazas_elnevezese}</h3>
            <p><strong>Indulás:</strong> ${utazas.utazas_ideje}</p>
            <p><strong>Helyszín:</strong> ${utazas.desztinacio}</p>
            <p><strong>Ár:</strong> ${utazas.ar} Ft</p>
            <a class="btn" onclick="openForm(${utazas.utazas_id}, '${utazas.utazas_elnevezese.replace(/'/g, "\\'")}')">Érdeklődöm</a>
            <a class="btn btn-secondary details-btn" onclick='showDetailsPopup(event, ${JSON.stringify(utazas)})'>Részletek</a>
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
