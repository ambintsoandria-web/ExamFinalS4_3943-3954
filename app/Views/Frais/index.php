<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<div class="auth-page frais-page">
    <div class="auth-shell frais-shell">

        <?php if (session('erreur')): ?>
            <div class="alert alert-error">
                <i class="bi bi-exclamation-circle"></i>
                <?= esc(session('erreur')) ?>
            </div>
        <?php endif; ?>

        <?php if (session('succes')): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                <?= esc(session('succes')) ?>
            </div>
        <?php endif; ?>

        <div class="login-box full-width">

            <div class="login-icon">
                <i class="bi bi-cash-stack"></i>
            </div>

            <h2>Gestion des frais</h2>
            <p class="login-lead">Configurez les barèmes de frais par type d'opération.</p>

            <?php foreach ($data as $item): ?>
                <div class="frais-section">

                    <!-- En-tête -->
                    <div class="frais-header">
                        <div class="frais-header-left">
                            <?php
                            $iconClass = 'transfert';
                            if ($item['type_operation']['nom'] == 'depot') {
                                $iconClass = 'depot';
                            } elseif ($item['type_operation']['nom'] == 'retrait') {
                                $iconClass = 'retrait';
                            }
                            ?>
                            <i class="bi bi-arrow-down-circle icon <?= $iconClass ?>"></i>
                            <h3><?= esc($item['type_operation']['nom']) ?></h3>
                            <span class="frais-badge"><?= count($item['frais']) ?> barème(s)</span>
                        </div>
                        <a href="<?= site_url('operateur/frais/create/' . $item['type_operation']['id']) ?>"
                            class="btn-add-frais">
                            <i class="bi bi-plus-circle"></i> Ajouter un frais
                        </a>
                    </div>

                    <!-- Tableau -->
                    <?php if (!empty($item['frais'])): ?>
                        <div class="frais-table-wrapper">
                            <table class="frais-table">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-arrow-right"></i> Montant min</th>
                                        <th><i class="bi bi-arrow-left"></i> Montant max</th>
                                        <th class="center"><i class="bi bi-coin"></i> Frais</th>
                                        <th class="center"><i class="bi bi-tools"></i> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($item['frais'] as $frais): ?>
                                        <tr>
                                            <td><?= number_format($frais['montant_min'], 0, ',', ' ') ?> Ar</td>
                                            <td><?= number_format($frais['montant_max'], 0, ',', ' ') ?> Ar</td>
                                            <td class="center">
                                                <span class="frais-tag">
                                                    <?= number_format($frais['montant_frais'], 0, ',', ' ') ?> Ar
                                                </span>
                                            </td>
                                            <td class="center">
                                                <div class="frais-actions">
                                                    <a href="<?= site_url('frais/edit/' . $frais['id']) ?>" class="btn-edit">
                                                        <i class="bi bi-pencil"></i> Modifier
                                                    </a>
                                                    <a href="<?= site_url('frais/delete/' . $frais['id']) ?>" class="btn-delete"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce frais ?')">
                                                        <i class="bi bi-trash"></i> Supprimer
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="frais-empty">
                            <i class="bi bi-inbox icon"></i>
                            <p>Aucun barème de frais pour <strong><?= esc($item['type_operation']['nom']) ?></strong></p>
                            <a href="<?= site_url('operateur/frais/create/' . $item['type_operation']['id']) ?>">
                                <i class="bi bi-plus-circle"></i> Ajouter un premier frais
                            </a>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

            <!-- Retour -->
            <div class="frais-back">
                <a href="<?= site_url('operateur/dashboard') ?>">
                    <i class="bi bi-arrow-left"></i> Retour au tableau de bord
                </a>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>