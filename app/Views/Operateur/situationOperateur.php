<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<?php $totalCommissions = array_sum(array_column($listeOperateurs, 'situation')); ?>
<div class="page-heading"><div><span class="page-kicker">Autres opérateurs</span><h1>Situation des commissions</h1><p>Commissions dues à chaque autre opérateur.</p></div><span class="page-icon"><i class="bi bi-percent"></i></span></div>
<section class="settlement-total"><div><span>Total des commissions à envoyer</span><strong><?= number_format($totalCommissions,2,',',' ') ?> <small>Ar</small></strong></div><i class="bi bi-wallet2"></i></section>
<div class="settlement-grid"><?php if($listeOperateurs):foreach($listeOperateurs as $operateur):?><article class="settlement-card"><header class="settlement-head"><span class="settlement-logo"><?= esc(strtoupper(substr($operateur['nom'],0,2))) ?></span><div><b><?= esc($operateur['nom']) ?></b><span><?= esc($operateur['telephone']) ?></span></div></header><footer class="settlement-due commission-only"><span>Commission à envoyer</span><strong><?= number_format($operateur['situation'],2,',',' ') ?> Ar</strong></footer></article><?php endforeach;else:?><div class="settlement-empty">Aucun autre opérateur actif.</div><?php endif;?></div>
<?= $this->endSection() ?>
