<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mobile Money' ?></title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/operateur.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/situation.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/gains.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
</head>

<body>
    <?php
    $authType = session('auth_type');
    $isOperateur = $authType === 'operateur';
    $isClient = $authType === 'client';
    $homeUrl = $isOperateur ? site_url('operateur/espace') : site_url('client/espace');
    ?>

    <!-- ============================================
     OVERLAY (mobile)
     ============================================ -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ============================================
     NAVBAR (barre du haut)
     ============================================ -->
    <nav class="navbar-custom">
        <!-- Toggle Sidebar (mobile) -->
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        <a href="<?= $homeUrl ?>" class="brand">
            <span class="brand-mark"><i class="bi bi-phone"></i></span>
            Mobile Money
        </a>

        <div class="nav-right">
            <div class="nav-user">
                <div class="avatar">
                    <?= esc(strtoupper(substr(session('auth_nom') ?? 'OP', 0, 2))) ?>
                </div>
                <span>
                    <?= esc(session('auth_nom') ?? ($isClient ? 'Client' : 'Opérateur')) ?>
                    <small class="nav-role"><?= $isClient ? 'Client' : 'Opérateur' ?></small>
                </span>
            </div>
            <form action="<?= site_url('deconnexion') ?>" method="post" class="logout-form">
                <?= csrf_field() ?>
                <button type="submit" class="logout-btn" aria-label="Se déconnecter" title="Se déconnecter">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </nav>

    <!-- ============================================
     SIDEBAR (menu latéral)
     ============================================ -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-label"><?= $isClient ? 'Mon espace' : 'Administration' ?></div>
        <ul class="sidebar-menu">
            <?php if ($isClient): ?>
                <li>
                    <a href="<?= site_url('client/espace') ?>"
                        class="<?= ($active ?? 'dashboard') === 'dashboard' ? 'active' : '' ?>">
                        <i class="bi bi-grid"></i>
                        Tableau de bord
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('client/depot') ?>" class="<?= ($active ?? '') === 'depot' ? 'active' : '' ?>">
                        <i class="bi bi-arrow-down-circle"></i>
                        Faire un dépôt
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('client/retrait') ?>"
                        class="<?= ($active ?? '') === 'retrait' ? 'active' : '' ?>">
                        <i class="bi bi-arrow-up-circle"></i>
                        Faire un retrait
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('client/transfert') ?>"
                        class="<?= ($active ?? '') === 'transfert' ? 'active' : '' ?>">
                        <i class="bi bi-arrow-left-right"></i>
                        Faire un transfert
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('client/historique') ?>"
                        class="<?= ($active ?? '') === 'transfert' ? 'active' : '' ?>">
                        <i class="bi bi-arrow-left-right"></i>
                        Voir l'historique
                    </a>
                </li>


            <?php elseif ($isOperateur): ?>
                <li>
                    <a href="<?= site_url('operateur/espace') ?>"
                        class="<?= ($active ?? '') === 'dashboard' ? 'active' : '' ?>">
                        <i class="bi bi-grid"></i>
                        Tableau de bord
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('operateur/prefixes') ?>"
                        class="<?= ($active ?? '') == 'prefixes' ? 'active' : '' ?>">
                        <i class="bi bi-hash"></i>
                        Préfixes
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('operateur/frais') ?>" class="<?= ($active ?? '') == 'frais' ? 'active' : '' ?>">
                        <i class="bi bi-currency-dollar"></i>
                        Frais
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('operateur/clients') ?>"
                        class="<?= ($active ?? '') == 'clients' ? 'active' : '' ?>">
                        <i class="bi bi-people"></i>
                        Clients
                        <span class="badge"><?= $total_clients ?? 0 ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('operateur/gains') ?>" class="<?= ($active ?? '') == 'gains' ? 'active' : '' ?>">
                        <i class="bi bi-graph-up-arrow"></i>
                        Gains
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('operateur/comissions') ?>" class="<?= ($active ?? '') == 'commissions' ? 'active' : '' ?>">
                        <i class="bi bi-graph-up-arrow"></i>
                        Commissions
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <!-- Version -->
        <div class="sidebar-version">
            <i class="bi bi-code-square"></i> Version 1.0
        </div>
    </aside>

    <!-- ============================================
     CONTENU PRINCIPAL
     ============================================ -->
    <div class="main-content">
        <div class="page-content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <?= $this->include('layout/footer') ?>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                }
            });
        });
    </script>
</body>

</html>
