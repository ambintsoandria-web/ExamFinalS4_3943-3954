<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion opérateur | Vola</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>

<body class="auth-page operator-page">
    <main class="auth-shell">
        <section class="auth-story operator-story">
            <a class="brand" href="<?= site_url('/') ?>"><span class="brand-mark">V</span><span>Vola</span></a>
            <div class="story-copy"><span class="eyebrow"><i></i> Portail professionnel</span>
                <h1>Gérez. Suivez.<br><em>Accompagnez.</em></h1>
                <p>L’espace sécurisé dédié aux équipes et opérateurs Vola.</p>
            </div>
            <p class="story-foot">Administration sécurisée · Activité en temps réel</p>
        </section>
        <section class="auth-panel">
            <div class="login-box">
                <a class="back-link" href="<?= site_url('/') ?>">← Retour à l’espace client</a>
                <div class="login-icon operator-icon"><svg viewBox="0 0 24 24">
                        <path d="M4 21v-2a4 4 0 0 1 4-4h8a4 4 0 0 1 4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg></div>
                <span class="section-label">Accès opérateur</span>
                <h2>Connexion sécurisée</h2>
                <p class="login-lead">Identifiez-vous pour ouvrir votre espace de gestion.</p>
                <?php if (session('erreur')): ?>
                    <div class="alert alert-error" role="alert"><?= esc(session('erreur')) ?></div><?php endif; ?>
                <form action="<?= site_url('connexion/operateur') ?>" method="post" class="login-form">
                    <?= csrf_field() ?>
                    <label for="identifiant">Email ou téléphone</label>
                    <div class="text-field"><svg viewBox="0 0 24 24">
                            <circle cx="12" cy="7" r="4" />
                            <path d="M4 21v-2a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v2" />
                        </svg><input id="identifiant" name="identifiant" value="<?= esc(old('identifiant')) ?>"
                            autocomplete="username" placeholder="Votre identifiant" required autofocus></div>
                    <label for="mot_de_passe">Mot de passe</label>
                    <div class="text-field"><svg viewBox="0 0 24 24">
                            <rect x="5" y="10" width="14" height="10" rx="2" />
                            <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                        </svg><input id="mot_de_passe" name="mot_de_passe" type="password"
                            autocomplete="current-password" placeholder="••••••••" required></div>
                    <button class="primary-button" type="submit">Se connecter <span>→</span></button>
                </form>
                <div class="secure-note">Accès réservé au personnel autorisé</div>
            </div>
        </section>
        <div class="orb orb-one"></div>
        <div class="orb orb-two"></div>
    </main>
</body>

</html>