-- Create the contracts table (required for add client + phone verification).
-- Run this in phpMyAdmin: select database react_contracts_db, then run the SQL below.

CREATE TABLE IF NOT EXISTS contracts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  agence VARCHAR(100) NOT NULL,
  n_client VARCHAR(100) NOT NULL,
  n_contrat VARCHAR(100) NOT NULL UNIQUE,
  nom VARCHAR(255) NOT NULL,
  prenom VARCHAR(255) NOT NULL,
  cin VARCHAR(50) NOT NULL,
  n_tlf1 VARCHAR(20) NOT NULL,
  n_tlf2 VARCHAR(20) NOT NULL,
  verification_code VARCHAR(10) DEFAULT NULL,
  verified TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
