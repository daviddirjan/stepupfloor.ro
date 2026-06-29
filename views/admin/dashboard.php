<!-- Grila analitice -->
<div class="analytics-grid">

    <div class="stat-card">
        <div class="stat-label-tag">Catalog</div>
        <div class="stat-val"><?= $countProducts ?></div>
        <div class="stat-lbl">Total Produse</div>
        <div class="stat-sub"><?= $countCategories ?> categori<?= $countCategories === 1 ? 'e' : 'i' ?></div>
    </div>

    <div class="stat-card stat-card--accent">
        <div class="stat-label-tag">Trafic</div>
        <div class="stat-val"><?= number_format($totalVisitors) ?></div>
        <div class="stat-lbl">Vizitatori unici</div>
        <div class="stat-sub">sesiuni înregistrate</div>
    </div>

    <div class="stat-card stat-card--accent">
        <div class="stat-label-tag">Vânzări</div>
        <div class="stat-val"><?= number_format($totalOrders) ?></div>
        <div class="stat-lbl">Total Comenzi</div>
        <div class="stat-sub">exclusiv anulate</div>
    </div>

    <div class="stat-card <?= $conversionRate > 0 ? 'stat-card--green' : '' ?>">
        <div class="stat-label-tag">Conversie</div>
        <div class="stat-val"><?= $conversionRate ?>%</div>
        <div class="stat-lbl">Rata de conversie</div>
        <div class="stat-sub"><?= $countContacts + $totalOrders ?> acțiuni / <?= number_format($totalVisitors) ?> vizitatori</div>
    </div>

    <div class="stat-card stat-card--green">
        <div class="stat-label-tag">Financiar</div>
        <div class="stat-val"><?= number_format($totalRevenue, 0, ',', '.') ?></div>
        <div class="stat-lbl">Total Venit (RON)</div>
        <div class="stat-sub">comenzi finalizate</div>
    </div>

    <div class="stat-card <?= $countUnread > 0 ? 'stat-card--warn' : '' ?>">
        <div class="stat-label-tag">Inbox</div>
        <div class="stat-val"><?= $countUnread ?></div>
        <div class="stat-lbl">Mesaje necitite</div>
        <div class="stat-sub"><?= $countContacts ?> total mesaje</div>
    </div>

</div>

<!-- Grafic vizitatori -->
<?php if (!empty($visitorsChart)): ?>
<div class="chart-card">
    <div class="chart-header">
        <h2>Vizitatori unici — ultimele 30 de zile</h2>
    </div>
    <?php
    $maxCnt = max(array_column($visitorsChart, 'cnt')) ?: 1;
    $byDay  = array_column($visitorsChart, 'cnt', 'day');
    $period = new DatePeriod(new DateTime('-29 days'), new DateInterval('P1D'), new DateTime('tomorrow'));
    $days   = [];
    foreach ($period as $dt) {
        $key    = $dt->format('Y-m-d');
        $days[] = ['day' => $key, 'cnt' => (int)($byDay[$key] ?? 0)];
    }
    ?>
    <div class="bar-chart">
        <?php foreach ($days as $d): ?>
        <?php $pct = round($d['cnt'] / $maxCnt * 100); ?>
        <div class="bar-col" title="<?= $d['day'] ?>: <?= $d['cnt'] ?> vizitatori">
            <div class="bar-fill" style="height:<?= max($pct, 2) ?>%"></div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="chart-labels">
        <span><?= date('d M', strtotime('-29 days')) ?></span>
        <span>Azi, <?= date('d M') ?></span>
    </div>
</div>
<?php else: ?>
<div class="chart-card" style="text-align:center;padding:2.5rem;color:var(--color-subtle);font-family:var(--font-ui);font-size:0.875rem;">
    Graficul vizitatorilor va apărea după primele vizite pe site.
</div>
<?php endif; ?>

<!-- Acțiuni rapide -->
<div class="quick-actions">
    <a href="<?= BASE_URL ?>admin/orders/create"   class="btn-primary">+ Comandă nouă</a>
    <a href="<?= BASE_URL ?>admin/products/create" class="btn-secondary">+ Produs nou</a>
    <a href="<?= BASE_URL ?>admin/blog/create"     class="btn-secondary">+ Articol blog</a>
    <a href="<?= BASE_URL ?>admin/contacts"        class="btn-secondary">Contacte<?= $countUnread > 0 ? ' (' . $countUnread . ')' : '' ?></a>
    <a href="<?= BASE_URL ?>admin/orders"          class="btn-secondary">Toate comenzile</a>
</div>
