-- Add verification columns to contracts (for phone verification with Twilio).
-- Run in phpMyAdmin on database react_contracts_db.
-- If you get "Unknown column 'verification_code'" or "verified", run these one by one
-- (ignore error if column already exists):

ALTER TABLE contracts ADD COLUMN verification_code VARCHAR(10) DEFAULT NULL;
ALTER TABLE contracts ADD COLUMN verified TINYINT(1) DEFAULT 0;
