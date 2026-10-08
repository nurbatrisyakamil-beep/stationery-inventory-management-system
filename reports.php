<?php
require __DIR__ . '/includes/auth.php';
require_admin();
require __DIR__ . '/config/database.php';

$total_stock = (int)$pdo->query('SELECT COALESCE(SUM(quantity), 0) FROM items')->fetchColumn();

$most_used_stmt = $pdo->query("
    SELECT items.name, COALESCE(SUM(stock_movements.quantity), 0) AS issued_quantity
    FROM stock_movements
    INNER JOIN items ON items.id = stock_movements.item_id
    WHERE stock_movements.movement_type = 'out'
    GROUP BY items.id, items.name
    ORDER BY issued_quantity DESC, items.name ASC
    LIMIT 1
");
$most_used = $most_used_stmt->fetch();
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>SIMS | Reports</title><link rel="stylesheet" href="assets/css/style.css"><link rel="stylesheet" href="assets/css/pages.css"></head><body class="dashboard-page"><aside class="sidebar"><div class="logo"><span>✎</span><div><strong>SIMS</strong><small>Stationery Inventory</small></div></div><nav><a href="dashboard.php">▦ Dashboard</a><a href="inventory.php">▤ Inventory</a><a class="active" href="reports.php">▥ Reports</a><a href="profile.php">♙ Profile</a></nav><a class="logout" href="logout.php">⇥ Logout</a></aside><main class="dashboard"><header><div><p class="eyebrow">DASHBOARD › REPORTS</p><h1>Reports</h1><p class="muted">Live report data from the MySQL database.</p></div><button class="primary-btn small" onclick="window.print()">⇩ Export Report</button></header><div class="cards"><section class="content-card"><h2>Stock Summary</h2><p class="number"><?= $total_stock ?></p><p class="muted">Total units in inventory</p></section><section class="content-card"><h2>Out of Stock</h2><p class="number warning"><?=(int)$pdo->query('SELECT COUNT(*) FROM items WHERE quantity <= 0')->fetchColumn()?></p><p class="muted">items currently have no stock</p><a href="inventory.php">View inventory →</a></section><section class="content-card"><h2>Most Used Item</h2><?php if ($most_used): ?><p class="number"><?=htmlspecialchars($most_used['name'])?></p><p class="muted"><?= (int)$most_used['issued_quantity'] ?> units issued from inventory</p><?php else: ?><p class="number">—</p><p class="muted">No stock-out records yet</p><?php endif; ?></section></div></main></body></html>