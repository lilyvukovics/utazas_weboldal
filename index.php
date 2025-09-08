<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Travelogue</title>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap');

    /* Alapok */
    * {
      box-sizing: border-box;
    }

    html {
      overflow-x: hidden; /* scroll tiltva */
    }

    body {
      font-family: 'Inter', Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      width: 100%;
      max-width: 100vw;
      overflow-x: hidden; /* scroll tiltva */
    }

    /* Fejléc */
    .main-title {
      text-align: center;
      font-family: 'Playfair Display', serif;
      font-size: 4.2rem;
      font-weight: 700;
      color: white;
      margin: 0;
      padding: 56px 20px 36px;
      text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      letter-spacing: -0.02em;
      position: relative;
      background: linear-gradient(135deg, rgba(255,255,255,.95) 0%, rgba(255,255,255,.8) 100%);
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
      background: radial-gradient(ellipse at center, rgba(255,255,255,.1) 0%, transparent 70%);
      z-index: -1;
      border-radius: 50%;
    }

    .content-wrapper {
      background: #fafbfc;
      border-radius: 30px 30px 0 0;
      min-height: calc(100vh - 200px);
      padding-top: 34px;
      box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 100vw;
    }

    /* Kártyarács */
    .container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 12px;                 
      padding: 12px;
      width: 100%;
      max-width: 100vw;
      align-items: start;       
      justify-items: stretch;
    }

    /* Kártya */
    .card {
      width: 100%;
      background: linear-gradient(145deg, #ffffff 0%, #f8f9ff 100%);
      border: 1px solid rgba(102, 126, 234, 0.1);
      border-radius: 20px;
      overflow: hidden;
      position: relative;
      box-shadow: 0 8px 22px rgba(102, 126, 234, 0.14);
      transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
      display: grid;
      grid-template-rows: auto 1fr; /* kép + tartalom */
    }

    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 14px 30px rgba(102, 126, 234, 0.22);
      border-color: rgba(102, 126, 234, 0.28);
    }

    .card-image-container {
      position: relative;
      overflow: hidden;
    }

    .card img {
      width: 100%;
      height: 200px;            
      object-fit: cover;
      transition: transform .3s ease;
    }

    .card:hover img {
      transform: scale(1.05);
    }

    .card-content {
      padding: 16px;            
      display: grid;
      grid-template-rows: auto 1fr auto; 
      row-gap: 10px;            
      min-height: 0;
    }

    .card h3 {
      margin: 0 0 8px;
      font-size: 20px;
      font-weight: 600;
      color: #2d3748;
      line-height: 1.28;
    }

    .card-info {
      display: grid;
      row-gap: 5px;
      min-height: 0;
    }

    .card-info p {
      margin: 0;
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
      display: grid;
      grid-auto-flow: column;
      gap: 10px;
      margin: 0;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 11px 14px;       
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all .3s ease;
      border: none;
      text-align: center;
    }

    .btn.primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      box-shadow: 0 4px 14px rgba(102, 126, 234, 0.28);
    }

    .btn.primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(102, 126, 234, 0.38);
      background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
    }

    .btn-secondary {
      background: rgba(255, 255, 255, 0.92);
      color: #4a5568;
      border: 2px solid rgba(102, 126, 234, 0.22);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .btn-secondary:hover {
      background: #fff;
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
      padding: 14px;
      border-radius: 8px;
      display: none;
      z-index: 999;
      max-width: min(320px, calc(100vw - 16px));
      word-break: break-word; 
    }

    /* Overlay + popup */
    #overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(173, 216, 230, 0.7);
      backdrop-filter: blur(5px);
      -webkit-backdrop-filter: blur(5px);
      z-index: 999;
    }

    #popupForm {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: linear-gradient(145deg, #ffffff 0%, #f8f9ff 100%);
      padding: 36px 26px 44px;
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
      margin: 0 0 10px;
      padding-top: 8px;
      font-weight: 600;
      text-shadow: 0 1px 2px rgba(102, 126, 234, 0.1);
    }

    #popupForm input[type="text"],
    #popupForm input[type="email"] {
      width: 100%;
      box-sizing: border-box;
      padding: 12px 15px;
      margin-bottom: 14px;
      border: 2px solid rgba(102, 126, 234, 0.2);
      border-radius: 12px;
      font-size: 14px;
      background: rgba(255, 255, 255, 0.85);
      transition: all .3s ease;
    }

    #popupForm input[type="text"]:focus,
    #popupForm input[type="email"]:focus {
      outline: none;
      border-color: #667eea;
      background: #fff;
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
      color: #fff;
      width: 100%;
      margin-bottom: 10px;
      transition: all .3s ease;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
      border-radius: 12px;
      padding: 12px 20px;
      font-weight: 600;
    }

    #popupForm .btn-secondary {
      background: rgba(255, 255, 255, 0.92);
      color: #667eea;
      border: 2px solid rgba(102, 126, 234, 0.3);
      width: 100%;
      margin-bottom: 18px;
      transition: all .3s ease;
      border-radius: 12px;
      padding: 12px 20px;
      font-weight: 600;
    }

    #popupForm p {
      font-size: 0.8em;
      color: #555;
      margin-top: 14px;
      line-height: 1.4;
    }

    #popup-utazas-nev {
      text-align: center;
      font-size: 18px;
      font-weight: 600;
      color: #764ba2;
      margin: 10px 0 18px;
      padding: 10px 15px;
      background: linear-gradient(135deg, rgba(102,126,234,.1) 0%, rgba(118,75,162,.1) 100%);
      border-radius: 12px;
      border: 1px solid rgba(102, 126, 234, 0.2);
    }

    /* Szűrőpanel */
    .filter-panel {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 26px;
      border-radius: 20px;
      margin: 18px auto 34px;
      max-width: calc(100vw - 40px);
      width: 100%;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .filter-title {
      color: white;
      text-align: center;
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 22px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .filter-row {
      display: flex;
      gap: 18px;
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
      text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    .filter-group select,
    .filter-group input {
      padding: 12px 15px;
      border: none;
      border-radius: 12px;
      font-size: 14px;
      background: rgba(255,255,255,0.95);
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: all .3s ease;
    }

    .filter-buttons {
      display: flex;
      gap: 10px;
      margin-top: 8px;
    }

    .filter-btn {
      padding: 12px 18px;
      border: none;
      border-radius: 12px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all .3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .filter-btn.apply {
      background: linear-gradient(135deg, #00b4db 0%, #0083b0 100%);
      color: #fff;
    }

    .filter-btn.reset {
      background: rgba(255,255,255,0.92);
      color: #666;
    }

    /* Reszponzív */
    @media (max-width: 768px) {
      .main-title {
        font-size: 3rem;
        padding: 40px 15px 28px;
      }

      .container {
        grid-template-columns: 1fr;
        gap: 14px;
        padding: 12px;
      }

      .card {
        max-width: 350px;
        margin: 0 auto;
      }

      .card img {
        height: 190px;
      }

      .card-content {
        padding: 14px;
        row-gap: 9px;
      }

      #popupForm {
        width: calc(100vw - 40px);
        max-width: 350px;
        padding: 24px 20px 34px;
        margin: 0 20px;
      }

      #detailsPopup {
        width: calc(100vw - 40px);
        max-width: 300px;
        left: 20px !important;
        right: 20px;
      }
    }

    @media (max-width: 480px) {
      .main-title {
        font-size: 2.5rem;
        padding: 28px 10px 22px;
      }

      .container {
        gap: 12px;
        padding: 8px;
      }

      .card img {
        height: 180px;
      }

      .card-content {
        padding: 12px;
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
            <input type="number" id="filter-ar-min" placeholder="Min Ft" min="0" step="10000"/>
            <span>-</span>
            <input type="number" id="filter-ar-max" placeholder="Max Ft" min="0" step="10000"/>
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

    <!-- Kártyák -->
    <div class="container" id="utazasok-container"></div>

    <!-- Blur háttér overlay -->
    <div id="overlay" onclick="closeForm()"></div>

    <!-- Jelentkezés popup -->
    <div id="popupForm">
      <h3>Érdeklődés az alábbi utazás iránt:</h3>
      <div id="popup-utazas-nev"></div>

      <form action="jelentkezes.php" method="POST">
        <input type="hidden" name="utazas_id" id="popup-utazas-id"/>

        <input type="text"   name="teljes_nev" placeholder="Teljes név" required oninvalid="this.setCustomValidity('Kérjük, adja meg a teljes nevét!')" oninput="this.setCustomValidity('')"/>
        <input type="email"  name="email"      placeholder="Email"     required pattern="[^\s@]+@[^\s@]+" oninvalid="this.setCustomValidity('Kérjük, érvényes email címet adjon meg!')" oninput="this.setCustomValidity('')"/>
        <input type="text"   name="telefon"    placeholder="Telefon"   required oninvalid="this.setCustomValidity('Kérjük, adja meg a telefonszámát!')" oninput="this.setCustomValidity('')"/>
        <input type="text"   name="lakcim"     placeholder="Lakcím"    required oninvalid="this.setCustomValidity('Kérjük, adja meg a lakcímét!')" oninput="this.setCustomValidity('')"/>

        <button type="submit" class="btn">Küldés</button>
        <button type="button" class="btn btn-secondary" onclick="closeForm()">Mégsem</button>

        <p class="tajekoztatas">
          <strong>Tájékoztatás:</strong><br />
          A jelentkezési űrlap kitöltése nem minősül végleges foglalásnak.
          Az adatok elküldésével Ön az utazás iránti érdeklődését jelzi.
          Munkatársaink a megadott elérhetőségek egyikén keresni fogják Önt
          a részletek egyeztetése céljából, a foglalás véglegesítésére pedig
          utazási irodánkban kerül sor.
        </p>
      </form>
    </div>

    <!-- Lebegő részletek doboz -->
    <div id="detailsPopup"></div>
  </div>

  <script>
    let lastDetailsId = null;
    let allUtazasok  = [];

    function openForm(utazasId, utazasNev) {
      document.getElementById('popup-utazas-id').value = utazasId;
      document.getElementById('popupForm').style.display = 'block';
      document.getElementById('overlay').style.display   = 'block';
      document.getElementById('popup-utazas-nev').textContent = utazasNev;
      document.getElementById('detailsPopup').style.display = 'none';
      document.body.style.overflow = 'hidden';
      lastDetailsId = null;
    }

    function closeForm() {
        document.getElementById('popupForm').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';

        // Csak vertikális görgetés vissza, X marad tiltva
        document.body.style.overflowY = 'auto';
        document.body.style.overflowX = 'hidden';
        document.documentElement.style.overflowX = 'hidden'; 
    }
    function showDetailsPopup(event, utazas) {
    const popup = document.getElementById('detailsPopup');

    // ha ugyanarra kattint, zárjuk
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

    // először megjelenítjük "láthatatlanul", hogy legyen mérete
    popup.style.visibility = 'hidden';
    popup.style.display = 'block';

    const rect = event.target.getBoundingClientRect();
    const vw   = window.innerWidth;
    const vh   = window.innerHeight;
    const sx   = window.scrollX;
    const sy   = window.scrollY;
    const pw   = popup.offsetWidth;
    const ph   = popup.offsetHeight;
    const gap  = 8; // biztonsági belső margó az ablak széleitől

    // Alap: a gomb alá, bal szélét a gomb baljához igazítva
    let left = sx + rect.left;
    let top  = sy + rect.bottom + gap;

    // Ha kilóg jobbra, toljuk be balra
    const rightEdge = left + pw;
    const maxRight  = sx + vw - gap;
    if (rightEdge > maxRight) {
        left = Math.max(gap + sx, maxRight - pw);
    }

    // Ha túl közel a bal szélhez, clampeljük
    if (left < sx + gap) {
        left = sx + gap;
    }

    // Ha alul kilógna, tegyük a gomb fölé
    const bottomEdge = top + ph;
    const maxBottom  = sy + vh - gap;
    if (bottomEdge > maxBottom) {
        top = sy + rect.top - ph - gap;
        // ha így meg felül lógna ki, végső megoldás: ablakon belül clamp
        if (top < sy + gap) {
        top = sy + gap;
        }
    }

    popup.style.left = `${left}px`;
    popup.style.top  = `${top}px`;
    popup.style.visibility = 'visible';

    lastDetailsId = utazas.utazas_id;
    }


    window.addEventListener('click', function(e) {
      const popup = document.getElementById('detailsPopup');
      if (!popup.contains(e.target) && !e.target.classList.contains('details-btn')) {
        popup.style.display = 'none';
        lastDetailsId = null;
      }
    });

    function populateFilterOptions() {
      const helyszinSet = new Set();
      allUtazasok.forEach(u => { if (u.desztinacio) helyszinSet.add(u.desztinacio); });

      const helyszinSelect = document.getElementById('filter-helyszin');
      helyszinSelect.innerHTML = '<option value="">Minden helyszín</option>';
      [...helyszinSet].sort().forEach(h => {
        helyszinSelect.innerHTML += `<option value="${h}">${h}</option>`;
      });

      updateIndulasOptions();
    }

    function updateIndulasOptions() {
      const selectedHelyszin = document.getElementById('filter-helyszin').value;
      const indulasSelect    = document.getElementById('filter-indulas');
      const currentValue     = indulasSelect.value;

      const available = new Set();
      allUtazasok.forEach(u => {
        if (!selectedHelyszin || u.desztinacio === selectedHelyszin) {
          if (u.indulasi_helyszin) available.add(u.indulasi_helyszin);
        }
      });

      indulasSelect.innerHTML = '<option value="">Minden indulási hely</option>';
      [...available].sort().forEach(i => {
        const sel = currentValue === i ? 'selected' : '';
        indulasSelect.innerHTML += `<option value="${i}" ${sel}>${i}</option>`;
      });

      if (currentValue && !available.has(currentValue)) {
        indulasSelect.value = '';
      }
    }

    function applyFilters() {
      const helyszin = document.getElementById('filter-helyszin').value;
      const indulas  = document.getElementById('filter-indulas').value;
      const arMin    = parseInt(document.getElementById('filter-ar-min').value) || 0;
      const arMax    = parseInt(document.getElementById('filter-ar-max').value) || Infinity;

      const filtered = allUtazasok.filter(u => {
        const a = !helyszin || u.desztinacio === helyszin;
        const b = !indulas  || u.indulasi_helyszin === indulas;
        const c = u.ar >= arMin && u.ar <= arMax;
        return a && b && c;
      });

      displayUtazasok(filtered);
    }

    function resetFilters() {
      document.getElementById('filter-helyszin').value = '';
      document.getElementById('filter-indulas').value  = '';
      document.getElementById('filter-ar-min').value   = '';
      document.getElementById('filter-ar-max').value   = '';
      updateIndulasOptions();
      displayUtazasok(allUtazasok);
    }

    function displayUtazasok(list) {
      const container = document.getElementById('utazasok-container');
      container.innerHTML = '';

      if (!list.length) {
        container.innerHTML =
          '<p style="text-align:center;color:#666;font-size:18px;margin:40px 0;">Nincs a szűrési feltételeknek megfelelő utazás.</p>';
        return;
      }

      list.forEach(utazas => {
        const div = document.createElement('div');
        div.className = 'card';
        div.innerHTML = `
          <div class="card-image-container">
            <img src="${utazas.boritokep}" alt="borítókép"
              onerror="this.style.display='none';
                       this.parentElement.style.backgroundColor='#f0f0f0';
                       this.parentElement.innerHTML='<div style=&quot;display:flex;align-items:center;justify-content:center;height:200px;color:#666;&quot;>Kép nem található</div>';">
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
              <a class="btn primary"
                 onclick="openForm(${utazas.utazas_id}, '${utazas.utazas_elnevezese.replace(/'/g, "\\'")}')">
                 Érdeklődöm
              </a>

              <a class="btn btn-secondary details-btn"
                 onclick='showDetailsPopup(event, ${JSON.stringify(utazas)})'>
                 Részletek
              </a>
            </div>
          </div>
        `;
        container.appendChild(div);
      });
    }

    /* Betöltés */
    fetch('get-utazasok.php')
      .then(r => r.json())
      .then(data => {
        allUtazasok = data;
        populateFilterOptions();
        displayUtazasok(allUtazasok);
      });
  </script>
</body>
</html>
