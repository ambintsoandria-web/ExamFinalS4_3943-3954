CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    email VARCHAR(255),
    telephone TEXT UNIQUE NOT NULL,
    nom TEXT NOT NULL,
    mot_de_passe TEXT NOT NULL,
    actif INTEGER DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

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
CREATE TABLE types_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT UNIQUE NOT NULL -- 'depot', 'retrait', 'transfert'
);

CREATE TABLE frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min REAL NOT NULL,
    montant_max REAL NOT NULL,
    montant_frais REAL NOT NULL,
    FOREIGN KEY (type_operation_id) REFERENCES types_operations(id)
);

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
CREATE TABLE transferts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    transaction_id INTEGER NOT NULL,
    client_destinataire_id INTEGER NOT NULL,
    FOREIGN KEY (transaction_id) REFERENCES transactions(id),
    FOREIGN KEY (client_destinataire_id) REFERENCES clients(id)
);

CREATE TABLE prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefix TEXT UNIQUE NOT NULL,
    id_operateur INTEGER NOT NULL,
    FOREIGN KEY (id_operateur) REFERENCES operateurs(id)
);

CREATE INDEX idx_transactions_client ON transactions(client_id);

CREATE INDEX idx_clients_telephone ON clients(telephone);

CREATE INDEX idx_operateurs_telephone ON operateurs(telephone);

SELECT * FROM transactions JOIN types_operations ON transactions.type_operation_id = types_operations.id WHERE transactions.client_id = 1;



-- 1. OPERATEURS
INSERT INTO operateurs (email, telephone, nom, mot_de_passe) VALUES 
('admin@mobilemoney.com', '0330000001', 'Admin Principal', 'admin123'),
('operateur1@mobilemoney.com', '0340000001', 'Opérateur Jean', 'op123');

-- 2. CLIENTS
INSERT INTO clients (telephone, nom, solde) VALUES 
('0331234567', 'Rakoto Jean', 150000),
('0347654321', 'Rabe Marie', 25000),
('0339876543', 'Andrianaina Faly', 5000),
('0381234567', 'Rasoa Lala', 0);

-- 3. TYPES D'OPERATIONS
INSERT INTO types_operations (nom) VALUES 
('depot'), 
('retrait'), 
('transfert');

-- 4. PREFIXES
INSERT INTO prefixes (prefix) VALUES 
('033'), ('034'), ('037'), ('038'), ('039');

-- 5. BAREMES FRAIS (retrait)
INSERT INTO frais (type_operation_id, montant_min, montant_max, montant_frais)
SELECT 
    (SELECT id FROM types_operations WHERE nom = 'retrait'),
    montant_min, montant_max, frais
FROM (
    SELECT 100 as montant_min, 1000 as montant_max, 50 as frais UNION
    SELECT 1001, 5000, 50 UNION
    SELECT 5001, 10000, 100 UNION
    SELECT 10001, 25000, 200 UNION
    SELECT 25001, 50000, 400 UNION
    SELECT 50001, 100000, 800 UNION
    SELECT 100001, 250000, 1500 UNION
    SELECT 250001, 500000, 3000
);

-- 6. BAREMES FRAIS (transfert)
INSERT INTO frais (type_operation_id, montant_min, montant_max, montant_frais)
SELECT 
    (SELECT id FROM types_operations WHERE nom = 'transfert'),
    montant_min, montant_max, frais
FROM (
    SELECT 100 as montant_min, 1000 as montant_max, 50 as frais UNION
    SELECT 1001, 5000, 50 UNION
    SELECT 5001, 10000, 100 UNION
    SELECT 10001, 25000, 200 UNION
    SELECT 25001, 50000, 400 UNION
    SELECT 50001, 100000, 800 UNION
    SELECT 100001, 250000, 1500 UNION
    SELECT 250001, 500000, 3000
);

-- 7. TRANSACTIONS (exemples)
INSERT INTO transactions (client_id, type_operation_id, montant, frais) VALUES 
(1, (SELECT id FROM types_operations WHERE nom = 'depot'), 100000, 0),
(1, (SELECT id FROM types_operations WHERE nom = 'retrait'), 20000, 200),
(1, (SELECT id FROM types_operations WHERE nom = 'transfert'), 15000, 150),
(2, (SELECT id FROM types_operations WHERE nom = 'depot'), 50000, 0),
(2, (SELECT id FROM types_operations WHERE nom = 'retrait'), 10000, 100);

-- 8. TRANSFERTS
INSERT INTO transferts (transaction_id, client_destinataire_id) VALUES 
(3, 2);

-- 9. HISTORIQUE SOLDE CLIENTS
INSERT INTO client_solde_historique (client_id, solde_precedent) VALUES 
(1, 0),
(1, 100000),
(1, 80000),
(1, 65000),
(2, 0),
(2, 50000),
(2, 40000);
