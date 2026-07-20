<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<div class="auth-page">
    <link rel="stylesheet" href="<?= base_url('assets/css/gains.css') ?>">
    <div class="auth-shell auth-shell-lg">

        <div class="login-box full-width">

            <div class="login-icon">
                <i class="bi bi-graph-up-arrow"></i>
            </div>

            <h2>Gains</h2>
            <p class="login-lead">Consultez la répartition des gains par type d'opération.</p>

            <!-- Total Gains -->
            <div class="gains-total">
                <div class="gains-total-card">
                    <span class="gains-total-label">
                        <i class="bi bi-cash-stack"></i> Total des gains
                    </span>
                    <span class="gains-total-value">
                        <?= number_format($totalGains['frais'] ?? 0, 0, ',', ' ') ?> Ar
                    </span>
                </div>
            </div>
            <div>
                <h1>Répartition des gains pour les autres operateurs avec un total de <?= number_format($totalGains['frais'] ?? 0, 0, ',', ' ') ?> Ar</h1>
                <?php if (!empty($gainsByOperateur)): ?>
                    <ul class="gains-list">
                        <?php foreach ($gainsByOperateur as $operateurNom => $totalGain): ?>
                            <li class="gains-list-item">
                                <span class="gains-list-label">
                                    <i class="bi bi-person-circle"></i> <?= esc(ucfirst($operateurNom)) ?>
                                </span>
                                <span class="gains-list-value">
                                    <?= number_format($totalGain['frais_commission'] ?? 0, 0, ',', ' ') ?> Ar
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Gains par type -->
            <div class="gains-section">
                <h3 class="gains-section-title">
                    <i class="bi bi-pie-chart"></i> Répartition par type d'opération
                </h3>

                <div class="gains-table-wrapper">
                    <table class="gains-table">
                        <thead>
                            <tr>
                                <th><i class="bi bi-tag"></i> Type d'opération</th>
                                <th class="text-right"><i class="bi bi-coin"></i> Total gains</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($gainsByTypeOperation)): ?>
                                <?php
                                $maxGain = max($gainsByTypeOperation);
                                $total = array_sum($gainsByTypeOperation);
                                ?>
                                <?php foreach ($gainsByTypeOperation as $typeNom => $totalGain): ?>
                                    <?php
                                    $percentage = $total > 0 ? round(($totalGain / $total) * 100) : 0;
                                    $icon = 'bi-arrow-left-right';
                                    $color = '#f59e0b';
                                    if ($typeNom == 'depot') {
                                        $icon = 'bi-arrow-down-circle';
                                        $color = 'var(--green-dark)';
                                    } elseif ($typeNom == 'retrait') {
                                        $icon = 'bi-arrow-up-circle';
                                        $color = 'var(--danger)';
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="gains-type">
                                                <i class="bi <?= $icon ?> gain-icon gain-icon-<?= esc($typeNom) ?>"></i>
                                                <?= esc(ucfirst($typeNom)) ?>
                                            </span>
                                            <span class="gains-percentage"><?= $percentage ?>%</span>
                                        </td>
                                        <td class="text-right">
                                            <span class="gains-amount">
                                                <?= number_format($totalGain, 0, ',', ' ') ?> Ar
                                            </span>
                                            <!-- Barre de progression -->
                                            <div class="gains-bar-wrapper"><div class="gains-bar gain-bar-<?= esc($typeNom) ?>"></div></div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p>Aucun gain enregistré</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Retour -->
            <div class="gains-back">
                <a href="<?= site_url('operateur/dashboard') ?>">
                    <i class="bi bi-arrow-left"></i> Retour au tableau de bord
                </a>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
