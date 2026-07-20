# creation de la base de donnée (Alan et Ambinintsoa) :
- > (ok) creation des tables :
    - (ok) operateurs
    - (ok) clients
    - (ok) types_operations
    - (ok) frais
    - (ok) transactions
    - (ok) transferts
    - (ok) prefixes
    - (ok) commisions
    - (ok) client_solde_historique
- > (ok) ajout des relations :
    - (ok) transaction vers client
    - (ok) transaction vers type d'operation
    - (ok) transfert vers transaction
    - (ok) transfert vers client destinataire
    - (ok) prefixe vers operateur
    - (ok) commission vers operateur
- > (ok) ajout des colonnes de la version 2 :
    - (ok) frais_commission dans transactions
    - (ok) id_operateur_recepteur dans transactions
    - (ok) id_operateur dans prefixes

# login client et operateur (Alan et Ambinintsoa) :
    ## Client (Ambinintsoa) :
        . (ok) Front :
            .. (ok) Numero de telephone
            .. (ok) Bouton continuer
            .. (ok) Message d'erreur
            .. (ok) Lien vers connexion operateur
            .. (ok) CSS responsive similaire a une application mobile money
        . (ok) Services / Models :
            .. (ok) isNumeroValide
            .. (ok) verification du prefixe
            .. (ok) login_auto
            .. (ok) verification du compte actif
        . (ok) Controllers :
            .. (ok) ClientController :
                ...(ok) /
                ...(ok) connexion
                ...(ok) connexion/client (post)
                ...(ok) creation session client
                ...(ok) redirection espace client
        . (ok) Filter :
            .. (ok) ClientAuthFilter
            .. (ok) blocage des pages operateur
    ## Operateur (Alan) :
        . (ok) Front :
            .. (ok) Identifiant ou telephone
            .. (ok) Mot de passe
            .. (ok) Bouton se connecter
            .. (ok) Message identifiants incorrects
        . (ok) Services / Models :
            .. (ok) authenticate par mot de passe et identifiant
            .. (ok) verification operateur actif
        . (ok) Controllers :
            .. (ok) OperateurController :
                ...(ok) connexion/operateur
                ...(ok) connexion/operateur (post)
                ...(ok) creation session operateur
                ...(ok) deconnexion
        . (ok) Filter :
            .. (ok) OperateurAuthFilter
            .. (ok) blocage des pages client

# navbar, sidebar et interface generale (Ambinintsoa) :
    ## Layout :
        . (ok) Navbar commune
        . (ok) Sidebar responsive
        . (ok) Footer commun
        . (ok) Affichage du nom du compte connecte
        . (ok) Affichage du role client ou operateur
        . (ok) Bouton deconnexion en POST
    ## Menu client :
        . (ok) Tableau de bord
        . (ok) Faire un depot
        . (ok) Faire un retrait
        . (ok) Faire un transfert
        . (ok) Voir historique
    ## Menu operateur :
        . (ok) Tableau de bord
        . (ok) Prefixes
        . (ok) Frais
        . (ok) Clients
        . (ok) Gains
        . (ok) Commissions
        . (ok) Situation operateurs

# page depot, retrait et transfert (Ambinintsoa) :
    ## Tableau de bord client :
        . (ok) Front :
            .. (ok) Affichage du solde restant
            .. (ok) Affichage du telephone
            .. (ok) Raccourcis vers les operations
            .. (ok) Graphique des montants
            .. (ok) Graphique du nombre d'operations
    ## Depot :
        . (ok) Front :
            .. (ok) Champ montant
            .. (ok) Bouton confirmer depot
            .. (ok) CSS simple et propre
        . (ok) Services / Models :
            .. (ok) insertion transaction depot
            .. (ok) frais a zero
            .. (ok) augmentation du solde client
        . (ok) Controller :
            .. (ok) client/depot
            .. (ok) client/depot (post)
    ## Retrait :
        . (ok) Front :
            .. (ok) Champ montant
            .. (ok) Bouton confirmer retrait
        . (ok) Services / Models :
            .. (ok) recherche du bareme de frais
            .. (ok) insertion transaction retrait
            .. (ok) diminution du solde avec les frais
        . (ok) Controller :
            .. (ok) client/retrait
            .. (ok) client/retrait (post)
    ## Transfert :
        . (ok) Front :
            .. (ok) Telephone destinataire
            .. (ok) Montant du transfert
            .. (ok) Ajout de plusieurs destinataires
            .. (ok) Option ajouter frais de retrait
            .. (ok) Affichage des erreurs
        . (ok) Services / Models :
            .. (ok) recherche du client destinataire
            .. (ok) insertion dans transactions
            .. (ok) insertion dans transferts
            .. (ok) debit de l'expediteur
            .. (ok) credit du destinataire
        . (ok) Controller :
            .. (ok) client/transfert
            .. (ok) client/transfert (post)

# historique client (Ambinintsoa) :
    ## Front :
        . (ok) Liste des transactions
        . (ok) Type d'operation
        . (ok) Montant
        . (ok) Frais
        . (ok) Date de transaction
    ## Services / Models :
        . (ok) getHistoriqueClient
        . (ok) jointure avec types_operations
    ## Controller :
        . (ok) client/historique

# page de gains et situation clients (Alan) :
    ## Page de gains :
        . (ok) Front :
            .. (ok) Gains totaux
            .. (ok) Gains par type d'operation
            .. (ok) Commissions par operateur
            .. (ok) Separation frais et commissions
        . (ok) Services / Models :
            .. (ok) getSommeTotalGains
            .. (ok) getSommeTotalGainsByTypeOperation
            .. (ok) getGainsByOperateur
        . (ok) Controller :
            .. (ok) operateur/gains
    ## Situation des clients :
        . (ok) Front :
            .. (ok) Filtrer par date
            .. (ok) Liste des clients avec solde
            .. (ok) Total et moyenne des soldes
        . (ok) Services / Models :
            .. (ok) getSoldebyClient
            .. (ok) getSituationClients
        . (ok) Controller :
            .. (ok) operateur/client
            .. (ok) operateur/clients
            .. (ok) operateur/situation

# Version 2 - cote operateur (Alan) :
    ## Configuration des prefixes :
        . (ok) Front :
            .. (ok) Choix de l'operateur
            .. (ok) Saisie du prefixe
            .. (ok) Liste des prefixes avec nom operateur
            .. (ok) Bouton supprimer
        . (ok) Services / Models :
            .. (ok) getAvecOperateur
            .. (ok) getOperateurParNumero
            .. (ok) isNumeroValide
        . (ok) Controllers :
            .. (ok) operateur/prefixes
            .. (ok) operateur/prefixes/add
            .. (ok) operateur/prefixes/delete
    ## Configuration des commissions :
        . (ok) Front :
            .. (ok) Choix d'un autre operateur
            .. (ok) Pourcentage de commission
            .. (ok) Liste des commissions
            .. (ok) Suppression d'une commission
        . (ok) Regles :
            .. (ok) Impossible de choisir son propre operateur
            .. (ok) Une commission par operateur
        . (ok) Services / Models :
            .. (ok) getPourcentage
            .. (ok) getAvecOperateur
            .. (ok) existePourOperateur
        . (ok) Controllers :
            .. (ok) operateur/comissions
            .. (ok) operateur/commissions/add
            .. (ok) operateur/commissions/delete

# Version 2 - calcul inter-operateurs (Alan et Ambinintsoa) :
    ## Calcul du transfert :
        . (ok) Identifier l'operateur expediteur avec son prefixe
        . (ok) Identifier l'operateur recepteur avec son prefixe
        . (ok) Commission a zero pour le meme operateur
        . (ok) Calcul du pourcentage pour un autre operateur
        . (ok) Enregistrer frais_commission
        . (ok) Enregistrer id_operateur_recepteur
        . (ok) Debiter montant + frais + commission
    ## Transfert multiple :
        . (ok) Diviser le montant entre tous les numeros
        . (ok) Autoriser plusieurs numeros du meme operateur
        . (ok) Refuser le melange de plusieurs operateurs
        . (ok) Afficher une erreur claire
        . (ok) Restaurer tous les numeros apres erreur
        . (ok) Corriger Array to string conversion
    ## Frais de retrait :
        . (ok) Option inclure frais de retrait
        . (ok) Aucun frais de retrait pour les autres operateurs

# situation des autres operateurs (Alan) :
    ## Front :
        . (ok) Boucle sur les autres operateurs uniquement
        . (ok) Carte par operateur
        . (ok) Affichage de la commission uniquement
        . (ok) Total general des commissions
        . (ok) Beau CSS similaire au login
    ## Services / Models :
        . (ok) getAutresOperateurs
        . (ok) getGainsByOperateur
        . (ok) somme de frais_commission
    ## Controller :
        . (ok) goToSituationOperateur
        . (ok) operateur/situationOperateur

# tests et livraison (Alan et Ambinintsoa) :
    ## Verification :
        . (ok) Syntaxe PHP des Models
        . (ok) Syntaxe PHP des Controllers
        . (ok) Syntaxe PHP des Views
        . (ok) Verification des routes
        . (ok) Test connexion client
        . (ok) Test connexion operateur
        . (ok) Test depot et retrait
        . (ok) Test transfert meme operateur
        . (ok) Test transfert autre operateur
        . (ok) Test transfert multiple
        . (ok) Test calcul commission Orange
        . (ok) Test affichage gains
    ## Livraison :
        . (a faire) Verification finale du projet
        . (a faire) Commit final Version 2
        . (a faire) Mettre le Tag v2
        . (a faire) Verifier que le tag pointe sur le bon commit
        . (a faire) Livraison avant 17h10
