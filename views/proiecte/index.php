<?php
$allTags = ['Rezidențial','Comercial','Industrial','Mochete','LVT','Covoare PVC','Dale Modulare'];

$tagColors = [
    'Rezidențial'   => ['bg' => 'oklch(0.94 0.07 55)',  'text' => 'oklch(0.40 0.15 48)'],
    'Comercial'     => ['bg' => 'oklch(0.93 0.06 240)', 'text' => '#1D5FAA'],
    'Industrial'    => ['bg' => 'oklch(0.93 0.02 240)', 'text' => 'oklch(0.32 0.04 240)'],
    'Mochete'       => ['bg' => '#0F2443',              'text' => '#fff'],
    'LVT'           => ['bg' => 'oklch(0.93 0.09 195)', 'text' => 'oklch(0.32 0.13 190)'],
    'Covoare PVC'   => ['bg' => 'oklch(0.94 0.09 42)',  'text' => 'oklch(0.40 0.16 42)'],
    'Dale Modulare' => ['bg' => 'oklch(0.93 0.08 290)', 'text' => 'oklch(0.36 0.13 290)'],
];

$tagCounts = [];
foreach ($allTags as $tag) {
    $tagCounts[$tag] = count(array_filter($projects, fn($p) => in_array($tag, $p['tags'], true)));
}
$totalCount = count($projects);

$patterns = [
    'repeating-linear-gradient(45deg,#1a3a6e 0px,#1a3a6e 6px,#0F2443 6px,#0F2443 24px)',
    'repeating-linear-gradient(90deg,#1e4272 0px,#1e4272 8px,#0F2443 8px,#0F2443 30px)',
    'repeating-linear-gradient(135deg,#162e55 0px,#162e55 5px,#0F2443 5px,#0F2443 20px)',
    'repeating-linear-gradient(0deg,#1e4272 0px,#1e4272 6px,#0F2443 6px,#0F2443 22px)',
    'repeating-linear-gradient(60deg,#1a3a6e 0px,#1a3a6e 5px,#0F2443 5px,#0F2443 20px)',
    'repeating-linear-gradient(120deg,#1e4272 0px,#1e4272 7px,#0F2443 7px,#0F2443 26px)',
];
?>

<style>
  @keyframes cardIn {
    from { opacity:0; transform:translateY(16px) scale(0.98); }
    to   { opacity:1; transform:translateY(0) scale(1); }
  }
  .proj-hero { background:#0F2443; padding:96px 48px 88px; text-align:center; position:relative; overflow:hidden; }
  .proj-hero::before { content:''; position:absolute; inset:0; background:repeating-linear-gradient(45deg,rgba(255,255,255,.025) 0px,rgba(255,255,255,.025) 1px,transparent 1px,transparent 44px); pointer-events:none; }
  .proj-hero-inner { position:relative; z-index:1; max-width:660px; margin:0 auto; }
  .proj-badge { display:inline-block; font-size:11px; font-weight:700; letter-spacing:.2em; color:#4d8fd4; text-transform:uppercase; margin-bottom:22px; background:rgba(29,95,170,.18); padding:5px 16px; border-radius:20px; border:1px solid rgba(29,95,170,.3); }
  .proj-h1 { font-family:'DM Serif Display',serif; font-size:56px; color:#fff; line-height:1.12; margin-bottom:22px; }
  .proj-sub { font-size:16px; color:oklch(0.68 0.04 230); line-height:1.7; max-width:500px; margin:0 auto; }
  .proj-stats { display:flex; justify-content:center; margin-top:60px; padding-top:48px; border-top:1px solid rgba(255,255,255,.08); gap:0; }
  .proj-stat { flex:1; padding:0 36px; text-align:center; }
  .proj-stat:not(:last-child) { border-right:1px solid rgba(255,255,255,.08); }
  .proj-stat-n { font-family:'DM Serif Display',serif; font-size:44px; color:#fff; line-height:1; }
  .proj-stat-l { font-size:11px; color:oklch(0.55 0.04 230); margin-top:8px; letter-spacing:.12em; text-transform:uppercase; }

  .proj-filter { background:#fff; border-bottom:1px solid oklch(0.93 0.01 240); position:sticky; top:73px; z-index:90; box-shadow:0 2px 16px rgba(15,36,67,.06); }
  .proj-filter-inner { max-width:1320px; margin:0 auto; padding:14px 48px; display:flex; align-items:center; gap:7px; flex-wrap:wrap; }
  .filter-btn { padding:7px 15px; border-radius:20px; font-size:12px; font-weight:600; letter-spacing:.05em; font-family:'DM Sans',sans-serif; cursor:pointer; border:1.5px solid oklch(0.88 0.01 240); background:#fff; color:#0F2443; transition:all .15s; white-space:nowrap; }
  .filter-btn.active { background:#1D5FAA; color:#fff; border-color:#1D5FAA; }
  .filter-btn:hover:not(.active) { opacity:.82; }
  .proj-count { margin-left:auto; font-size:12px; color:oklch(0.55 0.03 240); letter-spacing:.03em; }
  .proj-count strong { font-weight:600; color:#0F2443; }

  .proj-grid-wrap { max-width:1320px; margin:0 auto; padding:52px 48px 100px; }
  .proj-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:26px; }
  .proj-card { text-decoration:none; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 2px 16px rgba(15,36,67,.06); border:1px solid oklch(0.93 0.01 240); display:flex; flex-direction:column; transition:transform .22s,box-shadow .22s; animation:cardIn .38s ease both; }
  .proj-card:hover { transform:translateY(-5px); box-shadow:0 16px 48px rgba(15,36,67,.13); }
  .proj-card[hidden] { display:none !important; }
  .proj-img { height:210px; position:relative; overflow:hidden; flex-shrink:0; }
  .proj-img img { width:100%; height:100%; object-fit:cover; }
  .proj-img-grad { position:absolute; inset:0; background:linear-gradient(to top,rgba(10,28,56,.82) 0%,rgba(10,28,56,.15) 55%,transparent 100%); }
  .proj-img-year { position:absolute; top:14px; right:14px; background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.18); border-radius:6px; padding:4px 10px; font-size:11px; font-weight:600; color:rgba(255,255,255,.88); letter-spacing:.05em; backdrop-filter:blur(6px); }
  .proj-img-title { position:absolute; bottom:16px; left:18px; right:18px; font-size:17px; font-weight:700; color:#fff; line-height:1.25; text-shadow:0 2px 8px rgba(0,0,0,.4); }
  .proj-info { padding:16px 18px 20px; flex:1; display:flex; flex-direction:column; gap:11px; }
  .proj-location { display:flex; align-items:center; gap:5px; color:oklch(0.52 0.03 240); font-size:12px; line-height:1.4; }
  .proj-tags { display:flex; gap:5px; flex-wrap:wrap; }
  .proj-tag { font-size:10px; font-weight:700; padding:3px 9px; border-radius:20px; letter-spacing:.07em; text-transform:uppercase; }
  .proj-footer { display:flex; align-items:center; gap:7px; border-top:1px solid oklch(0.95 0.01 240); padding-top:13px; margin-top:auto; }
  .proj-surface { font-size:14px; font-weight:700; color:#0F2443; letter-spacing:.01em; }
  .proj-surface-l { font-size:11px; color:oklch(0.58 0.03 240); }
  .proj-details { margin-left:auto; font-size:12px; color:#1D5FAA; font-weight:600; display:flex; align-items:center; gap:4px; letter-spacing:.02em; }

  .proj-empty { text-align:center; padding:64px 0; color:oklch(0.55 0.03 240); font-size:15px; }

  @media (max-width:900px) {
    .proj-grid { grid-template-columns:1fr 1fr; }
    .proj-h1 { font-size:38px; }
    .proj-hero { padding:64px 24px 60px; }
    .proj-filter-inner, .proj-grid-wrap { padding-left:24px; padding-right:24px; }
  }
  @media (max-width:580px) {
    .proj-grid { grid-template-columns:1fr; }
    .proj-stats { flex-direction:column; gap:24px; }
    .proj-stat { border-right:none !important; padding:0; }
  }
</style>

<!-- HERO -->
<div class="proj-hero">
  <div class="proj-hero-inner">
    <div class="proj-badge">Portofoliu</div>
    <h1 class="proj-h1">Proiectele noastre</h1>
    <p class="proj-sub">Peste 200 de proiecte finalizate în toată România, de la apartamente rezidențiale până la hale industriale de mii de m².</p>
    <div class="proj-stats">
      <div class="proj-stat">
        <div class="proj-stat-n"><?= $stats['total'] ?>+</div>
        <div class="proj-stat-l">Proiecte</div>
      </div>
      <div class="proj-stat">
        <div class="proj-stat-n"><?= $stats['locations'] ?></div>
        <div class="proj-stat-l">Localități</div>
      </div>
      <div class="proj-stat">
        <div class="proj-stat-n"><?= $stats['surface'] >= 1000 ? number_format($stats['surface'] / 1000, 0, ',', '.') . 'k+' : $stats['surface'] ?></div>
        <div class="proj-stat-l">M² instalați</div>
      </div>
    </div>
  </div>
</div>

<!-- FILTER BAR -->
<div class="proj-filter">
  <div class="proj-filter-inner">
    <button class="filter-btn active" data-filter="toate" onclick="filterProjects('toate', this)">
      Toate <span style="font-weight:400;opacity:.55;margin-left:5px;">(<?= $totalCount ?>)</span>
    </button>
    <?php foreach ($allTags as $tag): ?>
      <?php if ($tagCounts[$tag] > 0): ?>
      <button class="filter-btn" data-filter="<?= htmlspecialchars($tag) ?>" onclick="filterProjects('<?= htmlspecialchars(addslashes($tag)) ?>', this)">
        <?= htmlspecialchars($tag) ?> <span style="font-weight:400;opacity:.55;margin-left:5px;">(<?= $tagCounts[$tag] ?>)</span>
      </button>
      <?php endif; ?>
    <?php endforeach; ?>
    <div class="proj-count" id="proj-count">
      <strong id="proj-count-n"><?= $totalCount ?></strong> proiecte afișate
    </div>
  </div>
</div>

<!-- GRID -->
<div class="proj-grid-wrap">
  <?php if (empty($projects)): ?>
    <div class="proj-empty">Nu există proiecte publicate momentan.</div>
  <?php else: ?>
  <div class="proj-grid" id="proj-grid">
    <?php foreach ($projects as $i => $p):
      $pattern = $patterns[$i % count($patterns)];
      $tagsJson = htmlspecialchars(json_encode($p['tags']), ENT_QUOTES);
    ?>
    <div class="proj-card"
       data-tags="<?= $tagsJson ?>"
       style="animation-delay:<?= $i * 55 ?>ms;">

      <!-- IMAGE -->
      <div class="proj-img" style="<?= $p['image'] ? '' : 'background:' . $pattern ?>">
        <?php if ($p['image']): ?>
          <img src="<?= BASE_URL ?>assets/images/projects/<?= htmlspecialchars($p['image']) ?>"
               alt="<?= htmlspecialchars($p['title']) ?>">
        <?php else: ?>
          <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
            <div style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:6px;padding:5px 12px;font-size:9px;font-family:monospace;color:rgba(255,255,255,.4);letter-spacing:.07em;">foto proiect</div>
          </div>
        <?php endif; ?>
        <div class="proj-img-grad"></div>
        <div class="proj-img-year"><?= (int)$p['year'] ?></div>
        <div class="proj-img-title"><?= htmlspecialchars($p['title']) ?></div>
      </div>

      <!-- INFO -->
      <div class="proj-info">
        <div class="proj-location">
          <svg width="11" height="13" viewBox="0 0 11 13" fill="none" style="flex-shrink:0;margin-top:1px;"><path d="M5.5 1C3.015 1 1 3.015 1 5.5 1 8.988 5.5 12.5 5.5 12.5S10 8.988 10 5.5C10 3.015 7.985 1 5.5 1z" stroke="currentColor" stroke-width="1.2"/><circle cx="5.5" cy="5.5" r="1.5" fill="currentColor"/></svg>
          <span><?= htmlspecialchars($p['client'] ?: '—') ?><?= $p['location'] ? ' · ' . htmlspecialchars($p['location']) : '' ?></span>
        </div>

        <?php if (!empty($p['tags'])): ?>
        <div class="proj-tags">
          <?php foreach ($p['tags'] as $tag):
            $c = $tagColors[$tag] ?? ['bg'=>'#eee','text'=>'#333'];
          ?>
            <span class="proj-tag" style="background:<?= $c['bg'] ?>;color:<?= $c['text'] ?>;"><?= htmlspecialchars($tag) ?></span>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="proj-footer">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="1.5" stroke="#1D5FAA" stroke-width="1.3"/><path d="M1 5.5h12M5.5 1v12" stroke="#1D5FAA" stroke-width="1.3"/></svg>
          <?php if ($p['surface']): ?>
            <span class="proj-surface"><?= number_format((int)$p['surface'], 0, ',', '.') ?> m²</span>
            <span class="proj-surface-l">suprafață</span>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<script>
function filterProjects(tag, btn) {
  document.querySelectorAll('.filter-btn').forEach(function(b){ b.classList.remove('active'); });
  btn.classList.add('active');

  var cards = document.querySelectorAll('#proj-grid .proj-card');
  var visible = 0;

  cards.forEach(function(card) {
    var tags = JSON.parse(card.dataset.tags || '[]');
    var show = tag === 'toate' || tags.indexOf(tag) !== -1;
    card.hidden = !show;
    if (show) visible++;
  });

  document.getElementById('proj-count-n').textContent = visible;
}
</script>
