<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<div class="page-heading">
    <div>
        <span class="page-kicker">Configuration</span>
        <h1>Gestion des commissions</h1>
        <p>Définissez les pourcentages de commission par opérateur.</p>
    </div>
    <span class="page-icon"><i class="bi bi-percent"></i></span>
</div>

<?php if (session('erreur')): ?>
    <div class="prefix-alert prefix-alert-error"><?= esc(session('erreur')) ?></div>
<?php endif; ?>
<?php if (session('succes')): ?>
    <div class="prefix-alert prefix-alert-success"><?= esc(session('succes')) ?></div>
<?php endif; ?>

<div class="prefix-layout">
    <!-- Formulaire -->
    <div class="prefix-card">
        <div class="card-header">
            <span><i class="bi bi-plus-circle"></i></span>
            <div>
                <h2>Ajouter une commission</h2>
                <p>Définissez le pourcentage pour un opérateur.</p>
            </div>
        </div>
        <div class="card-body">
            <form action="<?= site_url('operateur/commissions/add') ?>" method="post" class="prefix-form">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="id_operateur">Opérateur</label>
                    <div class="select-wrap">
                        <i class="bi bi-building"></i>
                        <select id="id_operateur" name="id_operateur" required>
                            <option value="">-- Choisir --</option>
                            <?php foreach ($operateurs as $operateur): ?>
                                <option value="<?= $operateur['id'] ?>">
                                    <?= esc($operateur['nom']) ?> (<?= esc($operateur['telephone']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pct_commission">Pourcentage (%)</label>
                    <div class="prefix-input">
                        <i class="bi bi-percent"></i>
                        <input id="pct_commission" type="number" name="pct_commission" step="0.01" min="0" max="100"
                            placeholder="Ex: 2.5" required>
                    </div>
                    <small>Valeur en pourcentage (ex: 2.5 = 2.5%)</small>
                </div>

                <button type="submit" class="save-button">
                    <i class="bi bi-check2"></i> Enregistrer
                </button>
            </form>
        </div>
    </div>

    <!-- Liste -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-list"></i> Liste des commissions
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Opérateur</th>
                            <th>Commission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commissions as $key => $commission): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= esc($commission['operateur_nom']) ?></td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= number_format($commission['pct_commission'], 2) ?> %
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= site_url('operateur/commissions/edit/' . $commission['id']) ?>"
                                        class="btn-edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?= site_url('operateur/commissions/delete/' . $commission['id']) ?>"
                                        method="post" class="action-form" onsubmit="return confirm('Supprimer cette commission ?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-delete" aria-label="Supprimer la commission">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (empty($commissions)): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    <i class="bi bi-info-circle"></i> Aucune commission
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
