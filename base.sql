-- =============================================
-- 1. OPERATEURS (avec mot de passe)
-- =============================================
CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email VARCHAR(255),
    telephone TEXT UNIQUE NOT NULL,
    nom TEXT NOT NULL,
    mot_de_passe TEXT NOT NULL,
    actif INTEGER DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- =============================================
-- 2. CLIENTS (login auto - pas de mot de passe)
-- =============================================
CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    telephone TEXT UNIQUE NOT NULL,
    nom TEXT DEFAULT 'Client',
    solde REAL DEFAULT 0,
    actif INTEGER DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);
create table client_solde_historique (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    solde_precedent REAL NOT NULL,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);
-- =============================================
-- 3. TYPES D'OPERATIONS
-- =============================================
CREATE TABLE types_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT UNIQUE NOT NULL -- 'depot', 'retrait', 'transfert'
);

-- =============================================
-- 4. BAREMES FRAIS (modifiable par opérateur)
-- =============================================
CREATE TABLE frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    montant_frais REAL NOT NULL,
    FOREIGN KEY (type_operation_id) REFERENCES types_operations(id)
);

-- =============================================
-- 5. TRANSACTIONS (historique des opérations)
-- =============================================
CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    type_operation_id INTEGER NOT NULL,
    montant REAL NOT NULL,
    frais REAL DEFAULT 0,
    date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (type_operation_id) REFERENCES types_operations(id)
);

-- =============================================
-- 6. TRANSFERTS (spécifique)
-- =============================================
CREATE TABLE transferts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    transaction_id INTEGER NOT NULL,
    client_destinataire_id INTEGER NOT NULL,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id),
    FOREIGN KEY (client_destinataire_id) REFERENCES clients(id)
);

-- =============================================
-- 7. PREFIXES (configuration opérateur)
-- =============================================
CREATE TABLE prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefix TEXT UNIQUE NOT NULL
);

-- =============================================
-- INDEX
-- =============================================
CREATE INDEX idx_transactions_client ON transactions(client_id);

CREATE INDEX idx_clients_telephone ON clients(telephone);

CREATE INDEX idx_operateurs_telephone ON operateurs(telephone);



SELECT * FROM transactions JOIN types_operations ON transactions.type_operation_id = types_operations.id WHERE transactions.client_id = 1;