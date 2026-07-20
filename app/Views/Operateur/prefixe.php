<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <div>
        <span class="page-kicker">Configuration réseau</span>
        <h1>Gestion des préfixes</h1>
        <p>Ajoutez les préfixes téléphoniques autorisés pour la connexion des clients.</p>
    </div>
    <span class="page-icon"><i class="bi bi-hash"></i></span>
</div>

<?php if (session('erreur')): ?>
    <div class="prefix-alert prefix-alert-error"><?= esc(session('erreur')) ?></div>
<?php endif; ?>
<?php if (session('succes')): ?>
    <div class="prefix-alert prefix-alert-success"><?= esc(session('succes')) ?></div>
<?php endif; ?>

<div class="prefix-layout">
    <div class="prefix-card">
        <div class="card-header">
            <span><i class="bi bi-plus-circle"></i></span>
            <div>
                <h2>Ajouter un préfixe</h2>
                <p>Le préfixe doit contenir exactement trois chiffres.</p>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= site_url('operateur/prefixes/add') ?>" method="post" class="prefix-form">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="prefix">Préfixe téléphonique</label>
                    <div class="prefix-input"><i class="bi bi-phone"></i><input id="prefix" type="text" name="prefix"
                            value="<?= esc(old('prefix')) ?>" placeholder="Ex. 040" inputmode="numeric"
                            pattern="0[0-9]{2}" minlength="3" maxlength="3" required></div>
                    <small>Format attendu : 3 chiffres commençant par 0.</small>
                </div>
                <button type="submit" class="save-button"><i class="bi bi-check2"></i> Enregistrer le préfixe</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <i class="bi bi-list"></i> Liste des préfixes
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Préfixe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listePrefixe as $key => $prefixe): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td>
                                    <span class="badge bg-primary">
                                        <i class="bi bi-hash"></i> <?= esc($prefixe['prefix']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($listePrefixe)): ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted">
                                    <i class="bi bi-info-circle"></i> Aucun préfixe enregistré
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>