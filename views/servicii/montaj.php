<?php
$steps = [
    ['num'=>'1','title'=>'Consultație & Măsurare','duration'=>'Ziua 1','desc'=>'Vine un specialist la fața locului, măsoară suprafața, evaluează starea suportului și discută opțiunile de produs cu tine. Consultația este gratuită.','bubbleBg'=>'#1D5FAA','bubbleBorder'=>'2px solid #1D5FAA','numColor'=>'#fff'],
    ['num'=>'2','title'=>'Ofertă detaliată','duration'=>'24–48h','desc'=>'Primești o ofertă scrisă cu preț fix, materiale specificate, termene clare și condiții de garanție. Fără costuri ascunse.','bubbleBg'=>'#fff','bubbleBorder'=>'2px solid #1D5FAA','numColor'=>'#1D5FAA'],
    ['num'=>'3','title'=>'Pregătire suport','duration'=>'Ziua montaj','desc'=>'Curățăm, nivelăm și primăm substratul. Depistăm și remediem denivelările, fisurile sau umiditatea înainte de pozarea pardoselii.','bubbleBg'=>'#fff','bubbleBorder'=>'2px solid oklch(0.85 0.01 240)','numColor'=>'#0F2443'],
    ['num'=>'4','title'=>'Montaj propriu-zis','duration'=>'1–3 zile','desc'=>'Echipa execută montajul conform planului aprobat. Lucrăm ordonat, protejăm zonele adiacente și respectăm recomandările producătorului la milimetru.','bubbleBg'=>'#fff','bubbleBorder'=>'2px solid oklch(0.85 0.01 240)','numColor'=>'#0F2443'],
    ['num'=>'5','title'=>'Recepție & Garanție','duration'=>'Ziua finală','desc'=>'Inspecție finală împreună cu tine, predarea pardoselii aspirate și documentelor de garanție. Semnăm procesul-verbal de recepție.','bubbleBg'=>'#fff','bubbleBorder'=>'2px solid oklch(0.85 0.01 240)','numColor'=>'#0F2443'],
];
?>
<style>
  @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
  .svc-card:hover { box-shadow:0 12px 40px rgba(15,36,67,0.11); transform:translateY(-4px); }
  .svc-adv-card:hover { background:rgba(255,255,255,0.07) !important; }
  .svc-price-card:hover { box-shadow:0 10px 36px rgba(15,36,67,0.09); }
  .svc-step-card:hover { box-shadow:0 8px 32px rgba(15,36,67,0.08); }
</style>

<!-- BREADCRUMB -->
<div style="background:#fff;border-bottom:1px solid oklch(0.93 0.01 240);">
  <div style="max-width:1320px;margin:0 auto;padding:13px 48px;display:flex;gap:6px;align-items:center;font-size:12px;color:oklch(0.56 0.03 240);">
    <a href="<?= BASE_URL ?>" style="color:inherit;text-decoration:none;">Acasă</a>
    <span style="opacity:.4;">›</span>
    <a href="<?= BASE_URL ?>#servicii" style="color:inherit;text-decoration:none;">Servicii</a>
    <span style="opacity:.4;">›</span>
    <span style="color:#0F2443;font-weight:500;">Montaj</span>
  </div>
</div>

<!-- HERO -->
<div style="background:#0F2443;position:relative;overflow:hidden;min-height:540px;display:flex;align-items:center;">
  <div style="position:absolute;inset:0;background:repeating-linear-gradient(45deg,rgba(255,255,255,0.018) 0px,rgba(255,255,255,0.018) 1px,transparent 1px,transparent 48px);pointer-events:none;"></div>
  <div style="position:absolute;top:-160px;right:-80px;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(29,95,170,0.22) 0%,transparent 68%);pointer-events:none;"></div>
  <div style="position:absolute;bottom:-120px;left:30%;width:420px;height:420px;border-radius:50%;background:radial-gradient(circle,rgba(29,95,170,0.10) 0%,transparent 68%);pointer-events:none;"></div>

  <div class="svc-hero">
    <div style="animation:fadeUp 0.6s ease both;">
      <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(29,95,170,0.18);border:1px solid rgba(29,95,170,0.35);border-radius:20px;padding:5px 14px;margin-bottom:24px;">
        <div style="width:7px;height:7px;border-radius:50%;background:#4d8fd4;"></div>
        <span style="font-size:11px;font-weight:700;letter-spacing:0.18em;color:#4d8fd4;text-transform:uppercase;">Serviciu</span>
      </div>
      <h1 style="font-family:'DM Serif Display',serif;font-size:clamp(34px,6vw,58px);color:#fff;line-height:1.1;margin-bottom:22px;">Montaj profesional<br>de pardoseli</h1>
      <p style="font-size:16px;color:oklch(0.67 0.04 230);line-height:1.75;max-width:480px;margin-bottom:36px;">
        De la pregătirea suportului până la ultima îmbinare. Echipa noastră certificată execută montajul oricărui tip de pardoseală cu precizie milimetrică și în termenele asumate.
      </p>
      <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
        <a href="#contact" style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;background:#1D5FAA;color:#fff;font-size:14px;font-weight:600;text-decoration:none;border-radius:10px;letter-spacing:.03em;">
          Solicită ofertă gratuită
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 7h12M8 3l5 4-5 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </a>
        <a href="#proces" style="display:inline-flex;align-items:center;gap:8px;padding:14px 24px;background:transparent;color:rgba(255,255,255,0.75);font-size:14px;font-weight:500;text-decoration:none;border-radius:10px;border:1.5px solid rgba(255,255,255,0.18);">
          Vezi procesul
        </a>
      </div>
    </div>

    <div class="svc-hero-stats" style="animation:fadeUp 0.6s 0.12s ease both;">
      <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:28px 24px;backdrop-filter:blur(8px);">
        <div style="font-family:'DM Serif Display',serif;font-size:42px;color:#fff;line-height:1;margin-bottom:8px;">24h</div>
        <div style="font-size:12px;color:oklch(0.58 0.04 230);line-height:1.5;letter-spacing:.03em;">Timp maxim de răspuns la solicitare</div>
      </div>
      <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:28px 24px;backdrop-filter:blur(8px);">
        <div style="font-family:'DM Serif Display',serif;font-size:42px;color:#fff;line-height:1;margin-bottom:8px;">500+</div>
        <div style="font-size:12px;color:oklch(0.58 0.04 230);line-height:1.5;letter-spacing:.03em;">Proiecte de montaj finalizate</div>
      </div>
      <div style="background:rgba(29,95,170,0.22);border:1px solid rgba(29,95,170,0.4);border-radius:16px;padding:28px 24px;backdrop-filter:blur(8px);">
        <div style="font-family:'DM Serif Display',serif;font-size:42px;color:#fff;line-height:1;margin-bottom:8px;">10 ani</div>
        <div style="font-size:12px;color:oklch(0.65 0.05 230);line-height:1.5;letter-spacing:.03em;">Garanție lucrare inclusă</div>
      </div>
      <div style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:16px;padding:28px 24px;backdrop-filter:blur(8px);">
        <div style="font-family:'DM Serif Display',serif;font-size:42px;color:#fff;line-height:1;margin-bottom:8px;">100%</div>
        <div style="font-size:12px;color:oklch(0.58 0.04 230);line-height:1.5;letter-spacing:.03em;">Satisfacție clienți (NPS 92)</div>
      </div>
    </div>
  </div>
</div>

<!-- CE MONTĂM -->
<div class="svc-section" style="background:#fff;">
  <div class="svc-container">
    <div style="text-align:center;margin-bottom:56px;">
      <div style="font-size:10px;font-weight:700;letter-spacing:0.2em;color:#1D5FAA;text-transform:uppercase;margin-bottom:12px;">Ce montăm</div>
      <h2 style="font-family:'DM Serif Display',serif;font-size:40px;color:#0F2443;line-height:1.2;">Orice tip de pardoseală</h2>
    </div>
    <div class="svc-grid-4">

      <div class="svc-card" style="border:1.5px solid oklch(0.92 0.01 240);border-radius:14px;overflow:hidden;transition:box-shadow .22s,transform .22s;cursor:pointer;">
        <div style="height:170px;position:relative;overflow:hidden;">
          <img src="<?= BASE_URL ?>assets/images/servicii-montaj/mochete.png" alt="Mochete" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
          <div style="position:absolute;top:12px;left:12px;background:#0F2443;color:#fff;font-size:9px;font-weight:700;letter-spacing:.1em;padding:3px 9px;border-radius:20px;text-transform:uppercase;">Popular</div>
        </div>
        <div style="padding:20px;">
          <div style="font-size:16px;font-weight:700;color:#0F2443;margin-bottom:7px;">Mochete</div>
          <div style="font-size:13px;color:oklch(0.50 0.03 240);line-height:1.6;">Tăiere precisă, lipire sau sistem fără lipici, cusături invizibile.</div>
        </div>
      </div>

      <div class="svc-card" style="border:1.5px solid oklch(0.92 0.01 240);border-radius:14px;overflow:hidden;transition:box-shadow .22s,transform .22s;cursor:pointer;">
        <div style="height:170px;overflow:hidden;">
          <img src="<?= BASE_URL ?>assets/images/servicii-montaj/lvt.png" alt="LVT" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
        </div>
        <div style="padding:20px;">
          <div style="font-size:16px;font-weight:700;color:#0F2443;margin-bottom:7px;">LVT & Vinil</div>
          <div style="font-size:13px;color:oklch(0.50 0.03 240);line-height:1.6;">Clic sau adeziv, inclusiv pe suprafețe denivelate (max. 3 mm).</div>
        </div>
      </div>

      <div class="svc-card" style="border:1.5px solid oklch(0.92 0.01 240);border-radius:14px;overflow:hidden;transition:box-shadow .22s,transform .22s;cursor:pointer;">
        <div style="height:170px;overflow:hidden;">
          <img src="<?= BASE_URL ?>assets/images/servicii-montaj/dale.png" alt="Dale Modulare" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
        </div>
        <div style="padding:20px;">
          <div style="font-size:16px;font-weight:700;color:#0F2443;margin-bottom:7px;">Dale Modulare</div>
          <div style="font-size:13px;color:oklch(0.50 0.03 240);line-height:1.6;">Modele geometrice, înlocuire rapidă a dalelor deteriorate.</div>
        </div>
      </div>

      <div class="svc-card" style="border:1.5px solid oklch(0.92 0.01 240);border-radius:14px;overflow:hidden;transition:box-shadow .22s,transform .22s;cursor:pointer;">
        <div style="height:170px;overflow:hidden;">
          <img src="<?= BASE_URL ?>assets/images/servicii-montaj/covoare-pvc.png" alt="Covoare PVC" loading="lazy" style="width:100%;height:100%;object-fit:cover;">
        </div>
        <div style="padding:20px;">
          <div style="font-size:16px;font-weight:700;color:#0F2443;margin-bottom:7px;">Covoare PVC</div>
          <div style="font-size:13px;color:oklch(0.50 0.03 240);line-height:1.6;">Role late, sudură la cald, tăieri complexe în colțuri și nișe.</div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- PROCESUL NOSTRU -->
<div id="proces" class="svc-section" style="background:#f4f1ec;">
  <div class="svc-container">
    <div class="svc-process-grid">

      <div class="svc-process-sticky" style="position:sticky;top:108px;">
        <div style="font-size:10px;font-weight:700;letter-spacing:0.2em;color:#1D5FAA;text-transform:uppercase;margin-bottom:14px;">Cum lucrăm</div>
        <h2 style="font-family:'DM Serif Display',serif;font-size:40px;color:#0F2443;line-height:1.2;margin-bottom:20px;">Procesul nostru pas cu pas</h2>
        <p style="font-size:14px;color:oklch(0.48 0.03 240);line-height:1.75;">Transparență totală: știi mereu în ce etapă ești și ce urmează. Nicio surpriză de preț sau termen.</p>
      </div>

      <div style="display:flex;flex-direction:column;gap:0;position:relative;">
        <div style="position:absolute;left:27px;top:52px;bottom:52px;width:2px;background:linear-gradient(to bottom,#1D5FAA,oklch(0.88 0.01 240));pointer-events:none;"></div>

        <?php foreach ($steps as $step): ?>
        <div style="display:flex;gap:28px;align-items:flex-start;padding:28px 0;position:relative;">
          <div style="width:56px;height:56px;border-radius:50%;background:<?= htmlspecialchars($step['bubbleBg']) ?>;border:<?= htmlspecialchars($step['bubbleBorder']) ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;z-index:1;box-shadow:0 4px 16px rgba(15,36,67,0.10);">
            <span style="font-family:'DM Serif Display',serif;font-size:20px;color:<?= htmlspecialchars($step['numColor']) ?>;line-height:1;"><?= $step['num'] ?></span>
          </div>
          <div class="svc-step-card" style="flex:1;background:#fff;border:1.5px solid oklch(0.92 0.01 240);border-radius:14px;padding:24px 28px;margin-top:4px;transition:box-shadow .2s;">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:10px;">
              <div style="font-size:16px;font-weight:700;color:#0F2443;"><?= htmlspecialchars($step['title']) ?></div>
              <div style="margin-left:auto;font-size:11px;color:#1D5FAA;background:oklch(0.93 0.06 240);padding:3px 10px;border-radius:20px;font-weight:600;white-space:nowrap;"><?= htmlspecialchars($step['duration']) ?></div>
            </div>
            <div style="font-size:14px;color:oklch(0.46 0.03 240);line-height:1.72;"><?= htmlspecialchars($step['desc']) ?></div>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>
</div>

<!-- GARANȚII & AVANTAJE -->
<div class="svc-section" style="background:#0F2443;">
  <div class="svc-container">
    <div style="text-align:center;margin-bottom:52px;">
      <div style="font-size:10px;font-weight:700;letter-spacing:0.2em;color:#4d8fd4;text-transform:uppercase;margin-bottom:12px;">De ce noi</div>
      <h2 style="font-family:'DM Serif Display',serif;font-size:40px;color:#fff;line-height:1.2;">Montaj fără compromisuri</h2>
    </div>
    <div class="svc-grid-3">

      <div class="svc-adv-card" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);border-radius:16px;padding:32px;transition:background .2s;">
        <div style="width:48px;height:48px;background:rgba(29,95,170,0.25);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77 5.82 21.02 7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#4d8fd4" stroke-width="1.6" stroke-linejoin="round"/></svg>
        </div>
        <div style="font-size:18px;font-weight:700;color:#fff;margin-bottom:10px;">Echipă certificată</div>
        <div style="font-size:14px;color:oklch(0.60 0.04 230);line-height:1.7;">Toți instalatorii noștri sunt certificați de producători și participă anual la traininguri de specialitate.</div>
      </div>

      <div class="svc-adv-card" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);border-radius:16px;padding:32px;transition:background .2s;">
        <div style="width:48px;height:48px;background:rgba(29,95,170,0.25);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="2" y="3" width="20" height="18" rx="2.5" stroke="#4d8fd4" stroke-width="1.6"/><path d="M8 10h8M8 14h5" stroke="#4d8fd4" stroke-width="1.6" stroke-linecap="round"/><path d="M2 7h20" stroke="#4d8fd4" stroke-width="1.6"/></svg>
        </div>
        <div style="font-size:18px;font-weight:700;color:#fff;margin-bottom:10px;">Contract clar</div>
        <div style="font-size:14px;color:oklch(0.60 0.04 230);line-height:1.7;">Preț fix stabilit înainte de start. Niciun cost ascuns, tot ce e inclus e scris negru pe alb.</div>
      </div>

      <div class="svc-adv-card" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);border-radius:16px;padding:32px;transition:background .2s;">
        <div style="width:48px;height:48px;background:rgba(29,95,170,0.25);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" stroke="#4d8fd4" stroke-width="1.6"/><path d="M12 6v6l4 2" stroke="#4d8fd4" stroke-width="1.6" stroke-linecap="round"/></svg>
        </div>
        <div style="font-size:18px;font-weight:700;color:#fff;margin-bottom:10px;">Termene respectate</div>
        <div style="font-size:14px;color:oklch(0.60 0.04 230);line-height:1.7;">Planificăm cu marjă de siguranță. Dacă întârziem din vina noastră, acordăm o reducere automată.</div>
      </div>

      <div class="svc-adv-card" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);border-radius:16px;padding:32px;transition:background .2s;">
        <div style="width:48px;height:48px;background:rgba(29,95,170,0.25);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M9 12l2 2 4-4" stroke="#4d8fd4" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z" stroke="#4d8fd4" stroke-width="1.6"/></svg>
        </div>
        <div style="font-size:18px;font-weight:700;color:#fff;margin-bottom:10px;">Garanție 10 ani</div>
        <div style="font-size:14px;color:oklch(0.60 0.04 230);line-height:1.7;">Acoperim orice defect de montaj timp de 10 ani. Reparăm gratuit, fără discuții.</div>
      </div>

      <div class="svc-adv-card" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);border-radius:16px;padding:32px;transition:background .2s;">
        <div style="width:48px;height:48px;background:rgba(29,95,170,0.25);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="#4d8fd4" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 22V12h6v10" stroke="#4d8fd4" stroke-width="1.6" stroke-linejoin="round"/></svg>
        </div>
        <div style="font-size:18px;font-weight:700;color:#fff;margin-bottom:10px;">Curățenie la final</div>
        <div style="font-size:14px;color:oklch(0.60 0.04 230);line-height:1.7;">Plecăm cu toate resturile. Predăm pardoseala gata de folosit, aspirată și ambalajele duse.</div>
      </div>

      <div class="svc-adv-card" style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.09);border-radius:16px;padding:32px;transition:background .2s;">
        <div style="width:48px;height:48px;background:rgba(29,95,170,0.25);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" stroke="#4d8fd4" stroke-width="1.6" stroke-linejoin="round"/></svg>
        </div>
        <div style="font-size:18px;font-weight:700;color:#fff;margin-bottom:10px;">Suport post-montaj</div>
        <div style="font-size:14px;color:oklch(0.60 0.04 230);line-height:1.7;">Suntem la un telefon distanță. Răspundem în 4 ore la orice sesizare din perioada de garanție.</div>
      </div>

    </div>
  </div>
</div>

<!-- TARIFARE -->
<div class="svc-section" style="background:#fff;">
  <div class="svc-container">
    <div style="text-align:center;margin-bottom:52px;">
      <div style="font-size:10px;font-weight:700;letter-spacing:0.2em;color:#1D5FAA;text-transform:uppercase;margin-bottom:12px;">Prețuri orientative</div>
      <h2 style="font-family:'DM Serif Display',serif;font-size:40px;color:#0F2443;line-height:1.2;margin-bottom:14px;">Tarife montaj</h2>
      <p style="font-size:15px;color:oklch(0.50 0.03 240);max-width:500px;margin:0 auto;line-height:1.7;">Prețul final depinde de suprafață, complexitate și produs. Cere o ofertă personalizată. E gratuită și vine în 24h.</p>
    </div>

    <div class="svc-grid-3" style="max-width:960px;margin:0 auto;">

      <div class="svc-price-card" style="border:1.5px solid oklch(0.91 0.01 240);border-radius:16px;padding:36px 32px;display:flex;flex-direction:column;transition:box-shadow .2s;">
        <div style="font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:oklch(0.52 0.03 240);margin-bottom:10px;">Mochete & LVT</div>
        <div style="display:flex;align-items:baseline;gap:4px;margin-bottom:6px;">
          <span style="font-family:'DM Serif Display',serif;font-size:38px;color:#0F2443;line-height:1;">8</span>
          <span style="font-size:16px;font-weight:600;color:#0F2443;">lei</span>
          <span style="font-size:13px;color:oklch(0.52 0.03 240);">/ m²</span>
        </div>
        <div style="font-size:12px;color:oklch(0.58 0.03 240);margin-bottom:24px;">de la</div>
        <div style="height:1px;background:oklch(0.93 0.01 240);margin-bottom:22px;"></div>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Pregătire suport</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Adeziv inclus</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Profile și chituire</div>
        </div>
      </div>

      <div style="border:2px solid #1D5FAA;border-radius:16px;padding:36px 32px;display:flex;flex-direction:column;background:oklch(0.97 0.03 240);position:relative;box-shadow:0 8px 36px rgba(29,95,170,0.14);">
        <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#1D5FAA;color:#fff;font-size:10px;font-weight:700;letter-spacing:.12em;padding:4px 14px;border-radius:20px;white-space:nowrap;text-transform:uppercase;">Cel mai cerut</div>
        <div style="font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:#1D5FAA;margin-bottom:10px;">Dale Modulare</div>
        <div style="display:flex;align-items:baseline;gap:4px;margin-bottom:6px;">
          <span style="font-family:'DM Serif Display',serif;font-size:38px;color:#0F2443;line-height:1;">12</span>
          <span style="font-size:16px;font-weight:600;color:#0F2443;">lei</span>
          <span style="font-size:13px;color:oklch(0.52 0.03 240);">/ m²</span>
        </div>
        <div style="font-size:12px;color:oklch(0.58 0.03 240);margin-bottom:24px;">de la</div>
        <div style="height:1px;background:oklch(0.88 0.03 240);margin-bottom:22px;"></div>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Pregătire suport</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Modele geometrice</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Tăieri la colțuri</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Profile inox incluse</div>
        </div>
      </div>

      <div class="svc-price-card" style="border:1.5px solid oklch(0.91 0.01 240);border-radius:16px;padding:36px 32px;display:flex;flex-direction:column;transition:box-shadow .2s;">
        <div style="font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:oklch(0.52 0.03 240);margin-bottom:10px;">Covoare PVC</div>
        <div style="display:flex;align-items:baseline;gap:4px;margin-bottom:6px;">
          <span style="font-family:'DM Serif Display',serif;font-size:38px;color:#0F2443;line-height:1;">10</span>
          <span style="font-size:16px;font-weight:600;color:#0F2443;">lei</span>
          <span style="font-size:13px;color:oklch(0.52 0.03 240);">/ m²</span>
        </div>
        <div style="font-size:12px;color:oklch(0.58 0.03 240);margin-bottom:24px;">de la</div>
        <div style="height:1px;background:oklch(0.93 0.01 240);margin-bottom:22px;"></div>
        <div style="display:flex;flex-direction:column;gap:10px;">
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Sudură la cald</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Tăieri complexe</div>
          <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:oklch(0.44 0.03 240);"><span style="color:#1D5FAA;font-size:16px;">✓</span> Rosturi invizibile</div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- CTA CONTACT -->
<div id="contact" class="svc-section" style="background:#f4f1ec;">
  <div class="svc-cta-box" style="background:#0F2443;border-radius:24px;position:relative;overflow:hidden;">
    <div style="position:absolute;top:-80px;right:-60px;width:320px;height:320px;border-radius:50%;background:radial-gradient(circle,rgba(29,95,170,0.25) 0%,transparent 70%);pointer-events:none;"></div>
    <div style="position:relative;z-index:1;">
      <div style="font-family:'DM Serif Display',serif;font-size:34px;color:#fff;line-height:1.25;margin-bottom:16px;">Hai să discutăm proiectul tău</div>
      <p style="font-size:14px;color:oklch(0.60 0.04 230);line-height:1.75;">Completează formularul și te contactăm în maxim 24 de ore cu o ofertă personalizată, fără nicio obligație.</p>
    </div>
    <form method="POST" action="<?= BASE_URL ?>contact/submit" style="display:flex;flex-direction:column;gap:12px;position:relative;z-index:1;">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
      <input type="text" name="name" placeholder="Numele tău" required style="padding:13px 16px;border-radius:10px;border:1.5px solid rgba(255,255,255,0.12);background:rgba(255,255,255,0.06);color:#fff;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;">
      <input type="text" name="phone" placeholder="Telefon sau email" required style="padding:13px 16px;border-radius:10px;border:1.5px solid rgba(255,255,255,0.12);background:rgba(255,255,255,0.06);color:#fff;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;">
      <textarea name="message" placeholder="Descriere scurtă (suprafață, tip pardoseală...)" rows="3" style="padding:13px 16px;border-radius:10px;border:1.5px solid rgba(255,255,255,0.12);background:rgba(255,255,255,0.06);color:#fff;font-size:14px;font-family:'DM Sans',sans-serif;outline:none;resize:none;"></textarea>
      <button type="submit" style="padding:14px;background:#1D5FAA;color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;letter-spacing:.03em;">
        Trimite solicitarea →
      </button>
    </form>
  </div>
</div>
