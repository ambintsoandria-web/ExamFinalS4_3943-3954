<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<section class="welcome-panel"><div class="welcome-copy"><span class="page-kicker">Portail opérateur</span><h1>Bonjour, <?= esc($operateur['nom']) ?></h1><p>Votre espace de pilotage Mobile Money.</p></div><div class="welcome-symbol"><i class="bi bi-shield-check"></i></div></section>
<div class="operator-grid">
    <a href="<?= site_url('operateur/prefixes') ?>" class="operator-tile"><i class="bi bi-hash"></i><span><b>Préfixes</b><small>Configurer les numéros autorisés</small></span><i class="bi bi-arrow-up-right"></i></a>
    <a href="<?= site_url('operateur/frais') ?>" class="operator-tile"><i class="bi bi-cash-stack"></i><span><b>Barèmes de frais</b><small>Gérer les frais des opérations</small></span><i class="bi bi-arrow-up-right"></i></a>
</div>
<div class="session-card"><i class="bi bi-person-check"></i><div><b>Session professionnelle active</b><span><?= esc($operateur['telephone']) ?></span></div><span class="status-dot">Connecté</span></div>
<?= $this->endSection() ?>
