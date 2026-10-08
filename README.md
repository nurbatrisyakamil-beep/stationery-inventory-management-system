# SIMS project

Open this folder in Visual Studio Code. Put `sims-starter` inside `C:\xampp\htdocs`, start Apache and MySQL in XAMPP, then open `http://localhost/sims-starter/`.

In phpMyAdmin, import `database/sims_db.sql`, then `database/request_updates.sql`, and finally `database/sv_feedback_update.sql`, then `database/collection_status.sql` if you are updating an existing database. Then open `http://localhost/sims-starter/install.php` once to create the first Admin account.

Admin: `admin@sims.test` / `admin123`  
Staff accounts are created by Staff users themselves at `register.php` using an email ending in `@uptm.edu.my`.

The project supports MySQL login, Staff self-registration using UPTM email, Admin inventory management, stock movement, Staff stationery requests, collection notifications, live MySQL-based reports, and Staff collection confirmation. Staff can mark an approved request as Collected after pickup. Approved requests are collected every Wednesday, 10:00 AM - 4:00 PM at the ICT Counter. Change this schedule in `config/collection_schedule.php` when needed.
