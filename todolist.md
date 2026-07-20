# creation de la base de donnée : 
- > creation des tables : 
    -utilisateurs
    -roles
    -utilisateur_roles
    -comptes_clients
    -types_operations
    -frais
    -transactions
    -transferts
    -prefixes

# login client et operateur(Alan et Ambinintsoa):
    ## Client (Ambinintsoa):
        . (ok)Front:
            .. (ok)Numero de telephone
            .. (ok)bouton valider
        . (ok)Services:
            .. (ok)isNumeroValide
            .. (ok)login
        . (ok)Controllers:
            .. (ok)ClientController:
                ...(ok)/
                ...(ok)connexion
                ...(ok)connexion client
    ## Operateur (Alan):
        . (ok)Front:
            .. (ok)Email
            .. (ok)Mot de passe
            .. (ok)bouton valider
        . (ok)Services:
            .. (ok)authenticate par mdp et identifiant
        . (ok)Controllers:
            .. (ok)OperateurController:
                ...(ok)connexion/operateur
                ...(ok)connexion/operateur(post)
                ...(ok)deconnexion
# Page depot (Ambinintsoa)
    ## Tableau de bord
        . (ok) Front : 
            .. (ok) Affichage du solde restant
        
    ## Pages d'actions du client
        . (ok) Faire un depot
        . (ok) Faire un retrait 
        . (ok) Faire un transfert 
        . (ok) Voir historique