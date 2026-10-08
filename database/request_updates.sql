USE sims_db;
CREATE TABLE IF NOT EXISTS stationery_requests (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 requester_name VARCHAR(100) NOT NULL,
 item_name VARCHAR(120) NOT NULL,
 category VARCHAR(80) NOT NULL,
 quantity INT UNSIGNED NOT NULL,
 reason VARCHAR(255) NULL,
 status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 reviewed_at TIMESTAMP NULL DEFAULT NULL
);
