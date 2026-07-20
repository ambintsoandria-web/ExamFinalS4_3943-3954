<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<div class="deposit-wrap">
    <a class="deposit-back" href="<?= site_url('client/espace') ?>"><i class="bi bi-arrow-left"></i> Retour au
        compte</a>
    <section class="deposit-card">
        <div class="deposit-icon withdraw-icon"><i class="bi bi-arrow-up"></i></div>
        <span class="page-kicker">Retirer de mon compte</span>
        <h1>Faire un Retrait</h1>
        <p class="deposit-lead">Indiquez le montant à débiter à votre solde.</p>
        <?php if (session('erreur')): ?>
            <div class="prefix-alert prefix-alert-error" role="alert"><?= esc(session('erreur')) ?></div><?php endif; ?>
        <form action="<?= site_url('client/retrait') ?>" method="post" class="deposit-form">
            <?= csrf_field() ?>
            <label for="montant">Montant du retrait</label>
            <div class="amount-input">
                <input type="number" name="montant" id="montant" value="<?= esc(old('montant')) ?>" placeholder="50 000"
                    min="100" step="1" required autofocus>
                <span>Ar</span>
            </div>
            <small>Minimum 100 Ar</small>
            <button type="submit" class="deposit-button">Confirmer le retrait <i class="bi bi-arrow-right"></i></button>
        </form>
    </section>
</div>
<?= $this->endSection() ?>