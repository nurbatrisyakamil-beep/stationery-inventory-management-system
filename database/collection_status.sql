USE sims_db;

-- Run this once if your stationery_requests table already exists.
ALTER TABLE stationery_requests
    MODIFY COLUMN status ENUM('pending','approved','rejected','collected') NOT NULL DEFAULT 'pending';

ALTER TABLE stationery_requests
    ADD COLUMN collected_at TIMESTAMP NULL DEFAULT NULL AFTER reviewed_at;
