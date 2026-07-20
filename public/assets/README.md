# Structure des Assets - BiblioHub

## 📁 Organisation des fichiers

```
public/assets/
├── css/
│   └── main.css              # CSS compilé (à utiliser en production)
└── scss/
    ├── main.scss             # Point d'entrée principal SCSS
    ├── _variables.scss       # Variables et configuration
    ├── _navbar.scss          # Styles de la navbar
    └── _books.scss           # Styles de la grille de livres
```

## 🎨 Architecture SCSS

### Variables Globales (`_variables.scss`)
- **Couleurs** : Variables pour tous les états de couleur
- **Espacements** : Échelle de margin/padding standardisée
- **Typographie** : Tailles de police et familles de polices
- **Points de rupture** : Breakpoints responsifs
- **Transitions** : Animations et transitions réutilisables

### Navbar (`_navbar.scss`)
- Design sticky avec backdrop blur
- Menu responsive mobile/desktop
- Animations fluides

### Grille de Livres (`_books.scss`)
- Layout responsive avec CSS Grid
- Animation de hover élégante
- Dégradés et effets de brillance

## 🚀 Comment utiliser

### En production (actuellement)
Les fichiers CSS compilés sont déjà prêts à l'emploi :
```html
<link rel="stylesheet" href="/assets/css/main.css">
```

### Pour modifier les styles (développement)

#### Option 1 : Installation de SASS compilateur
```bash
# Avec npm
npm install -g sass

# Compiler SCSS → CSS
sass public/assets/scss/main.scss public/assets/css/main.css

# Watch mode (recompile si changement)
sass --watch public/assets/scss:public/assets/css
```

#### Option 2 : VSCode Live SASS Compiler
1. Installer l'extension "Live Sass Compiler"
2. Clic droit sur `public/assets/scss/main.scss` → "Watch Sass"
3. Les fichiers CSS sont auto-générés

## 📝 Guideline de développement

### Avant de modifier le CSS :
1. **TOUJOURS** modifier les fichiers `.scss` dans `public/assets/scss/`
2. **JAMAIS** modifier `main.css` directement
3. Compiler les SCSS pour générer le CSS final
4. Tester sur tous les breakpoints

### Structure des fichiers SCSS :
- Chaque composant a son propre fichier `_component.scss`
- Tous les imports se font dans `main.scss`
- Les variables sont centralisées dans `_variables.scss`
- Utiliser les variables au lieu de hardcoder les valeurs

### Exemple d'utilisation des variables :
```scss
.mon-element {
    padding: $spacing-lg;
    color: $primary;
    background: $gradient-primary;
    transition: $transition-smooth;
    border-radius: $radius-md;
}

@media (max-width: $breakpoint-md) {
    .mon-element {
        padding: $spacing-md;
    }
}
```

## 🎨 Palette de couleurs

| Classe | Couleur | Utilisation |
|--------|---------|-------------|
| Primary | #667eea | Boutons, accents |
| Secondary | #764ba2 | Highlights, emphasis |
| Success | #48c774 | Actions positives |
| Warning | #ffdd57 | Alertes |
| Danger | #f14668 | Erreurs |
| Info | #3298dc | Information |
| Light | #f5f5f5 | Backgrounds clairs |
| Dark | #363636 | Texte principal |

## 🔧 Breakpoints Responsifs

| Device | Width |
|--------|-------|
| Téléphone (SM) | < 576px |
| Tablette (MD) | < 768px |
| Medium (LG) | < 992px |
| Desktop (XL) | < 1200px |

## 📦 Fichiers à modifier selon le besoin

| Besoin | Fichier |
|--------|---------|
| Changer les couleurs | `_variables.scss` |
| Modifier la navbar | `_navbar.scss` |
| Ajuster les cartes | `_books.scss` |
| Ajouter un nouveau composant | Créer `_component.scss` + importer dans `main.scss` |
| Changer la police | `_variables.scss` et `main.scss` |

## ✅ Checklist avant la mise en production

- [ ] Tous les SCSS compilés en CSS
- [ ] CSS minifié (optionnel : ajouter `--style=compressed`)
- [ ] Testé sur tous les breakpoints
- [ ] Images optimisées
- [ ] Pas d'erreur console
- [ ] Performance OK (lighthouse)

---
**Dernière mise à jour** : 18 avril 2026
