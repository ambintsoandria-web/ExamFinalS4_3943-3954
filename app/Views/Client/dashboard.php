<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<?php if (session('succes')): ?><div class="app-alert app-alert-success"><i class="bi bi-check-circle"></i><?= esc(session('succes')) ?></div><?php endif; ?>
<section class="welcome-panel">
    <div class="welcome-copy"><span class="page-kicker">Espace client</span><h1>Bonjour, <?= esc($client['nom']) ?></h1><p>Gérez votre argent simplement et en toute sécurité.</p></div>
    <div class="welcome-symbol"><i class="bi bi-wallet2"></i></div>
</section>
<section class="balance-panel">
    <div><span>Solde disponible</span><strong><?= number_format((float) $client['solde'], 0, ',', ' ') ?> <small>Ar</small></strong><p><i class="bi bi-phone"></i><?= esc($client['telephone']) ?></p></div>
    <span class="balance-decoration"></span>
</section>
<div class="quick-grid">
    <a href="<?= site_url('client/depot') ?>" class="quick-action quick-deposit"><i class="bi bi-arrow-down"></i><span><b>Déposer</b><small>Ajouter de l’argent</small></span><i class="bi bi-chevron-right"></i></a>
    <a href="<?= site_url('client/retrait') ?>" class="quick-action quick-withdraw"><i class="bi bi-arrow-up"></i><span><b>Retirer</b><small>Retirer de l’argent</small></span><i class="bi bi-chevron-right"></i></a>
    <a href="<?= site_url('client/transfert') ?>" class="quick-action quick-transfer"><i class="bi bi-arrow-left-right"></i><span><b>Transférer</b><small>Envoyer à un client</small></span><i class="bi bi-chevron-right"></i></a>
</div>
<?= $this->endSection() ?>
