<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<?php if (session('succes')): ?>
    <div class="app-alert app-alert-success"><i class="bi bi-check-circle"></i><?= esc(session('succes')) ?></div>
<?php endif; ?>
<section class="welcome-panel">
    <div class="welcome-copy"><span class="page-kicker">Espace client</span>
        <h1>Bonjour, <?= esc($client['nom']) ?></h1>
        <p>Gérez votre argent simplement et en toute sécurité.</p>
    </div>
    <div class="welcome-symbol"><i class="bi bi-wallet2"></i></div>
</section>
<section class="balance-panel">
    <div><span>Solde disponible</span><strong><?= number_format((float) $client['solde'], 0, ',', ' ') ?>
            <small>Ar</small></strong>
        <p><i class="bi bi-phone"></i><?= esc($client['telephone']) ?></p>
    </div>
    <span class="balance-decoration"></span>
</section>
<div class="quick-grid">
    <a href="<?= site_url('client/depot') ?>" class="quick-action quick-deposit"><i
            class="bi bi-arrow-down"></i><span><b>Déposer</b><small>Ajouter de l’argent</small></span><i
            class="bi bi-chevron-right"></i></a>
    <a href="<?= site_url('client/retrait') ?>" class="quick-action quick-withdraw"><i
            class="bi bi-arrow-up"></i><span><b>Retirer</b><small>Retirer de l’argent</small></span><i
            class="bi bi-chevron-right"></i></a>
    <a href="<?= site_url('client/transfert') ?>" class="quick-action quick-transfer"><i
            class="bi bi-arrow-left-right"></i><span><b>Transférer</b><small>Envoyer à un client</small></span><i
            class="bi bi-chevron-right"></i></a>
</div>
<section class="charts-grid">
    <div class="chart-card">
        <div class="chart-head">
            <div><span>Mes opérations</span>
                <h2>Répartition des montants</h2>
            </div><i class="bi bi-pie-chart"></i>
        </div>
        <div class="chart-box chart-box-small"><canvas id="clientOperationsChart"></canvas></div>
    </div>
    <div class="chart-card">
        <div class="chart-head">
            <div><span>Mon activité</span>
                <h2>Nombre d’opérations</h2>
            </div><i class="bi bi-bar-chart-line"></i>
        </div>
        <div class="chart-box chart-box-small"><canvas id="clientCountChart"></canvas></div>
    </div>
</section>
<script>
    const clientLabels = <?= json_encode(array_map('ucfirst', array_column($stats, 'nom'))) ?>;
    const clientColors = ['#20c684', '#ef6b6b', '#f2b544'];
    new Chart(document.getElementById('clientOperationsChart'), {
        type: 'doughnut',
        data: {
            labels: clientLabels,
            datasets: [{ data: <?= json_encode(array_map('floatval', array_column($stats, 'montant'))) ?>, backgroundColor: clientColors, borderWidth: 0, hoverOffset: 5 }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '68%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { family: 'DM Sans' } } } } }
    });
    new Chart(document.getElementById('clientCountChart'), {
        type: 'bar',
        data: { labels: clientLabels, datasets: [{ data: <?= json_encode(array_map('intval', array_column($stats, 'total'))) ?>, backgroundColor: clientColors, borderRadius: 9, borderSkipped: false, barThickness: 35 }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false } }, y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#edf2ef' } } } }
    });
</script>
<?= $this->endSection() ?>