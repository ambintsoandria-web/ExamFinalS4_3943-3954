# Grille d'audit — Mini-blog CI4 + SQLite
**Module :** Qualité & sécurité du code · 2ᵉ année
**Durée conseillée :** 2 h (1 h audit en binôme + 1 h restitution)

## Contexte

Une IA a produit ce mini-blog en quelques secondes. Il **fonctionne** en
démonstration. Votre rôle est celui du **développeur senior qui relit le code
d'un junior** avant la mise en production.

## Consignes

1. Faites tourner l'application et vérifiez qu'elle marche (inscription,
   connexion, articles, admin).
2. **Trouvez au moins 6 problèmes.** Pour chacun, remplissez une ligne du tableau.
3. **Corrigez-en au moins 3**, dont au moins **un de sécurité**.
4. Préparez une **démonstration** d'au moins un problème (montrer qu'il casse
   réellement, pas seulement le décrire).

## Catégories à utiliser

- **Sécurité** — un attaquant peut nuire (vol de données, usurpation, etc.)
- **Correction** — le code donne un résultat faux ou corrompt les données
- **Performance** — ça marche petit, ça s'écroule en grand

## Tableau à compléter

| # | Fichier / méthode | Problème constaté | Catégorie | Gravité (1-5) | Comment le démontrer | Correctif proposé |
|---|-------------------|-------------------|-----------|---------------|----------------------|-------------------|
| 1 |                   |                   |           |               |                      |                   |
| 2 |                   |                   |           |               |                      |                   |
| 3 |                   |                   |           |               |                      |                   |
| 4 |                   |                   |           |               |                      |                   |
| 5 |                   |                   |           |               |                      |                   |
| 6 |                   |                   |           |               |                      |                   |



1) Liste des erreurs de ce code : 
=> Manque de sécurité du code n'importe qui peut se connecter si il a une email valide
$user = $db->query("SELECT * FROM utilisateurs WHERE email = '$email'")->getRowArray(); //

=> Manque de filtre au niveau de filters
n'importe quel utilisateur peut supprimer des articles il peuvent tous aller dans admin


=> il Manque le lien pour aller vers la page register




Liste des erreurs de ce mini projet: 
-Auth.php / Manque de sécurité / Sécurité / 5 / N'importe quelle persnne a le droit de se connecter si il a une email valide / Corriger la methode et appliquer le mot de passe

-dashboard.php / Manque de sécurité / NavSécuritéigation / 3 / N'importe qui peut aller dans admin / mettre un filtre selon le role de l'utilisateur et ne pas mettre dans le navigateur

-layout.php / Manque lien pour aller vers register / Navigation / 3 / on ne peut pas acceder à la page register via l'interface / Mettre le lien dans layout.php

-Auth.php / requete dans la fonction login / Performance / 2 / Manque de struture de code on ne met pas de requete dans controller / utiliser la fonction de base de code ignter mettrel es methodes dans les models

-Articles.php / code trop lourd / Performance / 4 / code pas assez performant au niveau de la fonction index() dans le foreach / Solution : creer une vue