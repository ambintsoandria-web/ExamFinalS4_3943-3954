<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<section class="welcome-panel">
    <div class="welcome-copy"><span class="page-kicker">Portail opérateur</span>
        <h1>Bonjour, <?= esc($operateur['nom']) ?></h1>
        <p>Votre espace de pilotage Mobile Money.</p>
    </div>
    <div class="welcome-symbol"><i class="bi bi-shield-check"></i></div>
</section>
<div class="operator-grid">
    <a href="<?= site_url('operateur/prefixes') ?>" class="operator-tile"><i
            class="bi bi-hash"></i><span><b>Préfixes</b><small>Configurer les numéros autorisés</small></span><i
            class="bi bi-arrow-up-right"></i></a>
    <a href="<?= site_url('operateur/frais') ?>" class="operator-tile"><i class="bi bi-cash-stack"></i><span><b>Barèmes
                de frais</b><small>Gérer les frais des opérations</small></span><i class="bi bi-arrow-up-right"></i></a>
</div>
<div class="metric-row">
    <div class="metric-card"><span><i class="bi bi-people"></i> Clients
            actifs</span><strong><?= (int) $nombreClients ?></strong></div>
    <div class="metric-card"><span><i class="bi bi-arrow-left-right"></i>
            Opérations</span><strong><?= array_sum(array_map('intval', array_column($stats, 'total'))) ?></strong></div>
    <div class="metric-card"><span><i class="bi bi-cash-coin"></i> Volume
            total</span><strong><?= number_format(array_sum(array_map('floatval', array_column($stats, 'montant'))), 0, ',', ' ') ?>
            <small>Ar</small></strong></div>
</div>
<section class="charts-grid">
    <div class="chart-card">
        <div class="chart-head">
            <div><span>Vue globale</span>
                <h2>Opérations par type</h2>
            </div><i class="bi bi-bar-chart"></i>
        </div>
        <div class="chart-box"><canvas id="operationsChart"></canvas></div>
    </div>
    <div class="chart-card">
        <div class="chart-head">
            <div><span>7 derniers jours actifs</span>
                <h2>Activité récente</h2>
            </div><i class="bi bi-activity"></i>
        </div>
        <div class="chart-box"><canvas id="activityChart"></canvas></div>
    </div>
</section>
<div class="session-card"><i class="bi bi-person-check"></i>
    <div><b>Session professionnelle active</b><span><?= esc($operateur['telephone']) ?></span></div><span
        class="status-dot">Connecté</span>
</div>
<script>
    const chartFont = { family: 'DM Sans' };
    new Chart(document.getElementById('operationsChart'), { type: 'bar', data: { labels: <?= json_encode(array_column($stats, 'nom')) ?>, datasets: [{ label: 'Nombre', data: <?= json_encode(array_map('intval', array_column($stats, 'total'))) ?>, backgroundColor: ['#20c684', '#ef6b6b', '#f2b544'], borderRadius: 8, borderSkipped: false }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { font: chartFont } }, y: { beginAtZero: true, ticks: { precision: 0, font: chartFont }, grid: { color: '#edf2ef' } } } } });
    new Chart(document.getElementById('activityChart'), { type: 'line', data: { labels: <?= json_encode(array_column($activite, 'jour')) ?>, datasets: [{ label: 'Opérations', data: <?= json_encode(array_map('intval', array_column($activite, 'total'))) ?>, borderColor: '#12a96f', backgroundColor: 'rgba(18,169,111,.12)', fill: true, tension: .4, pointRadius: 4, pointBackgroundColor: '#fff', pointBorderWidth: 3 }] }, options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { font: chartFont } }, y: { beginAtZero: true, ticks: { precision: 0, font: chartFont }, grid: { color: '#edf2ef' } } } } });
</script>
<?= $this->endSection() ?>