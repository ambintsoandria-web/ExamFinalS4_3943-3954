<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<div class="auth-page">
    <link rel="stylesheet" href="<?= base_url('assets/css/situation.css') ?>">
    <div class="auth-shell auth-shell-lg">

        <div class="login-box full-width">

            <div class="login-icon">
                <i class="bi bi-people"></i>
            </div>

            <h2>Situation des Clients</h2>
            <p class="login-lead">Consultez la situation financière de vos clients.</p>

            <!-- Filtre date -->
            <div class="situation-filter">
                <label for="situation-date">
                    <i class="bi bi-calendar3"></i> Date de la situation :
                </label>
                <input type="date" id="situation-date" name="situation-date" value="<?= esc($date ?? date('Y-m-d')) ?>"
                    onchange="updateSituation()" class="situation-date-input">
                <button onclick="updateSituation()" class="btn-filter">
                    <i class="bi bi-search"></i> Filtrer
                </button>
            </div>

            <!-- Stats -->
            <div class="situation-stats">
                <div class="stat-card">
                    <span class="stat-label">Total clients</span>
                    <span class="stat-value"><?= count($clients) ?></span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">Solde total</span>
                    <span class="stat-value">
                        <?php
                        $total = array_sum(array_column($clients, 'solde'));
                        echo number_format($total, 0, ',', ' ') . ' Ar';
                        ?>
                    </span>
                </div>
                <div class="stat-card">
                    <span class="stat-label">Solde moyen</span>
                    <span class="stat-value">
                        <?php
                        $moyenne = count($clients) > 0 ? $total / count($clients) : 0;
                        echo number_format($moyenne, 0, ',', ' ') . ' Ar';
                        ?>
                    </span>
                </div>
            </div>

            <!-- Tableau -->
            <div class="situation-table-wrapper">
                <table class="situation-table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-person"></i> Nom</th>
                            <th><i class="bi bi-phone"></i> Téléphone</th>
                            <th class="text-right"><i class="bi bi-wallet2"></i> Solde</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($clients)): ?>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td>
                                        <span class="client-name"><?= esc($client['nom']) ?></span>
                                    </td>
                                    <td>
                                        <span class="client-phone"><?= esc($client['telephone']) ?></span>
                                    </td>
                                    <td class="text-right">
                                        <span
                                            class="client-solde <?= $client['solde'] > 0 ? 'positive' : ($client['solde'] < 0 ? 'negative' : 'zero') ?>">
                                            <?= number_format($client['solde'], 0, ',', ' ') ?> Ar
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>Aucun client enregistré</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Retour -->
            <div class="situation-back">
                <a href="<?= site_url('operateur/dashboard') ?>">
                    <i class="bi bi-arrow-left"></i> Retour au tableau de bord
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function updateSituation() {
        const date = document.getElementById('situation-date').value;
        if (date) {
            window.location.href = `<?= site_url('operateur/clients') ?>?date=${encodeURIComponent(date)}`;
        }
    }

    document.getElementById('situation-date').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            updateSituation();
        }
    });
</script>

<?= $this->endSection() ?>