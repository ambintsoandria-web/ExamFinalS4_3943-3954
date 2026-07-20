<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<div class="form-page">
    <a href="<?= site_url('operateur/frais') ?>" class="deposit-back"><i class="bi bi-arrow-left"></i> Retour aux
        frais</a>
    <section class="form-card">
        <div class="form-card-head"><span><i class="bi bi-plus-lg"></i></span>
            <div><small>Nouveau barème</small>
                <h1>Ajouter des frais</h1>
                <p>Opération : <b><?= esc(ucfirst($typeOperation['nom'])) ?></b></p>
            </div>
        </div>
        <?php if (session('erreur')): ?>
            <div class="app-alert app-alert-error"><i class="bi bi-exclamation-circle"></i><?= esc(session('erreur')) ?>
            </div><?php endif; ?>
        <form method="post" action="<?= site_url('frais/add') ?>" class="app-form">
            <?= csrf_field() ?><input type="hidden" name="type_operation_id" value="<?= esc($typeOperationId) ?>">
            <div class="form-row">
                <div class="control"><label for="montant_min">Montant minimum</label>
                    <div class="control-input"><input type="number" id="montant_min" name="montant_min"
                            value="<?= esc(old('montant_min')) ?>" placeholder="1 000" required><span>Ar</span></div>
                </div>
                <div class="control"><label for="montant_max">Montant maximum</label>
                    <div class="control-input"><input type="number" id="montant_max" name="montant_max"
                            value="<?= esc(old('montant_max')) ?>" placeholder="5 000" required><span>Ar</span></div>
                </div>
            </div>
            <div class="control"><label for="montant_frais">Montant des frais</label>
                <div class="control-input"><input type="number" id="montant_frais" name="montant_frais"
                        value="<?= esc(old('montant_frais')) ?>" placeholder="50" required><span>Ar</span></div>
            </div>
            <div class="form-actions"><a href="<?= site_url('operateur/frais') ?>"
                    class="button-secondary">Annuler</a><button class="button-primary" type="submit"><i
                        class="bi bi-check2"></i> Enregistrer</button></div>
        </form>
    </section>
</div>
<?= $this->endSection() ?>