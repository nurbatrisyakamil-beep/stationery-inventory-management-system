<?php session_start(); if (($_SESSION['user_role'] ?? '') === 'staff') { header('Location: stock_movement.php'); } else { header('Location: item_form.php'); } exit;
