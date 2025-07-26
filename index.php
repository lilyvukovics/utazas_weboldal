<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
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

    </style>
</head>
<body>

<h1>Elérhető utazások</h1>
<div class="container" id="utazasok-container"></div>

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

function openForm(utazasId, utazasNev) {
    document.getElementById('popup-utazas-id').value = utazasId;
    document.getElementById('popupForm').style.display = 'block';
    document.getElementById('popup-utazas-nev').textContent = utazasNev;
    document.getElementById('detailsPopup').style.display = 'none';
    lastDetailsId = null;
}

function closeForm() {
    document.getElementById('popupForm').style.display = 'none';
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

// Betöltjük az utazásokat
fetch('get-utazasok.php')
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById('utazasok-container');
        data.forEach(utazas => {
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
    });
</script>


</body>
</html>
