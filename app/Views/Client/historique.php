<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<div class="page-heading"><div><span class="page-kicker">Activité du compte</span><h1>Mon historique</h1><p>Retrouvez toutes les opérations effectuées sur votre compte.</p></div><span class="page-icon"><i class="bi bi-clock-history"></i></span></div>
<section class="data-card">
<?php if (!empty($listeHistorique)): ?>
    <div class="data-table-wrap"><table class="data-table"><thead><tr><th>Opération</th><th class="align-right">Montant</th><th class="align-right">Frais</th><th class="align-right">Date</th></tr></thead><tbody>
    <?php foreach ($listeHistorique as $transaction): $type = $transaction['type'] ?? $transaction['nom'] ?? $transaction['type_operation'] ?? ''; ?>
        <tr><td><span class="operation-type operation-<?= esc($type) ?>"><i class="bi <?= $type === 'depot' ? 'bi-arrow-down-circle' : ($type === 'retrait' ? 'bi-arrow-up-circle' : 'bi-arrow-left-right') ?>"></i><?= esc(ucfirst($type)) ?></span></td><td class="align-right amount-cell"><?= number_format($transaction['montant'],0,',',' ') ?> Ar</td><td class="align-right"><?= number_format($transaction['frais'],0,',',' ') ?> Ar</td><td class="align-right date-cell"><?= date('d/m/Y H:i',strtotime($transaction['date_transaction'])) ?></td></tr>
    <?php endforeach; ?></tbody></table></div><p class="table-count"><?= count($listeHistorique) ?> transaction(s)</p>
<?php else: ?><div class="empty-box"><i class="bi bi-inbox"></i><h3>Aucune transaction</h3><p>Vos futures opérations apparaîtront ici.</p></div><?php endif; ?>
</section>
<?= $this->endSection() ?>
