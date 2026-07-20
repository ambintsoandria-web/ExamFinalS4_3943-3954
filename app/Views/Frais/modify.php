<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<div class="form-page">
    <a href="<?= site_url('operateur/frais') ?>" class="deposit-back"><i class="bi bi-arrow-left"></i> Retour aux frais</a>
    <section class="form-card">
        <div class="form-card-head"><span><i class="bi bi-pencil"></i></span><div><small>Barème existant</small><h1>Modifier les frais</h1><p>Ajustez les montants de ce barème.</p></div></div>
        <form method="post" action="<?= site_url('frais/update/' . $frais['id']) ?>" class="app-form">
            <?= csrf_field() ?>
            <div class="form-row">
                <div class="control"><label for="montant_min">Montant minimum</label><div class="control-input"><input type="number" id="montant_min" name="montant_min" value="<?= esc($frais['montant_min']) ?>" required><span>Ar</span></div></div>
                <div class="control"><label for="montant_max">Montant maximum</label><div class="control-input"><input type="number" id="montant_max" name="montant_max" value="<?= esc($frais['montant_max']) ?>" required><span>Ar</span></div></div>
            </div>
            <div class="control"><label for="montant_frais">Frais</label><div class="control-input"><input type="number" id="montant_frais" name="montant_frais" value="<?= esc($frais['montant_frais']) ?>" required><span>Ar</span></div></div>
            <div class="form-actions"><a href="<?= site_url('operateur/frais') ?>" class="button-secondary">Annuler</a><button class="button-primary" type="submit"><i class="bi bi-check2"></i> Enregistrer</button></div>
        </form>
    </section>
</div>
<?= $this->endSection() ?>
