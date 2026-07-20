<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#071b17">
    <title>Connexion client | Vola</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>

<body class="auth-page">
    <main class="auth-shell">
        <section class="auth-story" aria-label="Presentation du service">
            <a class="brand" href="<?= site_url('/') ?>" aria-label="Accueil Vola">
                <span class="brand-mark">V</span><span>Vola</span>
            </a>
            <div class="story-copy">
                <span class="eyebrow"><i></i> Votre argent, simplement</span>
                <h1>Tout votre argent.<br><em>Au même endroit.</em></h1>
                <p>Consultez votre solde, suivez vos opérations et transférez votre argent en toute sérénité.</p>
                <div class="trust-row">
                    <span><svg viewBox="0 0 24 24">
                            <path d="M12 3 5 6v5c0 4.5 2.9 8.6 7 10 4.1-1.4 7-5.5 7-10V6l-7-3Z" />
                            <path d="m9 12 2 2 4-4" />
                        </svg> Sécurisé</span>
                    <span><svg viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg> Disponible 24/7</span>
                </div>
            </div>
            <p class="story-foot">Paiements simples · Transferts instantanés · Suivi en temps réel</p>
        </section>

        <section class="auth-panel">
            <div class="login-box">
                <span class="mobile-brand"><b>V</b> Vola</span>
                <div class="login-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <rect x="5" y="2.5" width="14" height="19" rx="3" />
                        <path d="M9 6h6M10 18h4" />
                    </svg>
                </div>
                <span class="section-label">Espace client</span>
                <h2>Heureux de vous revoir</h2>
                <p class="login-lead">Entrez votre numéro pour accéder à votre compte.</p>

                <?php if (session('erreur')): ?>
                    <div class="alert alert-error" role="alert"><?= esc(session('erreur')) ?></div>
                <?php endif; ?>
                <?php if (session('succes')): ?>
                    <div class="alert alert-success" role="status"><?= esc(session('succes')) ?></div>
                <?php endif; ?>

                <form action="<?= site_url('connexion/client') ?>" method="post" class="login-form">
                    <?= csrf_field() ?>
                    <label for="telephone">Numéro de téléphone</label>
                    <div class="phone-field">
                        <span class="country-code"><span class="flag">🇲🇬</span> +261 <i></i></span>
                        <input id="telephone" name="telephone" type="tel" value="<?= esc(old('telephone')) ?>"
                            placeholder="33 12 345 67" inputmode="numeric" autocomplete="tel" maxlength="13" required
                            autofocus>
                    </div>
                    <small class="field-help">Utilisez le numéro associé à votre compte Vola.</small>
                    <button class="primary-button" type="submit">Continuer <span>→</span></button>
                </form>

                <div class="secure-note"><svg viewBox="0 0 24 24">
                        <rect x="5" y="10" width="14" height="10" rx="2" />
                        <path d="M8 10V7a4 4 0 0 1 8 0v3" />
                    </svg> Connexion protégée et données chiffrées</div>
                <div class="operator-link">Vous travaillez chez Vola ? <a
                        href="<?= site_url('connexion/operateur') ?>">Accès opérateur <span>↗</span></a></div>
            </div>
            <p class="legal">En continuant, vous acceptez nos <a href="#">conditions d’utilisation</a> et notre <a
                    href="#">politique de confidentialité</a>.</p>
        </section>
        <div class="orb orb-one"></div>
        <div class="orb orb-two"></div>
    </main>
</body>

</html>