<?php

session_start();

require "../include/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: /index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| MARK ALL AS READ
|--------------------------------------------------------------------------
*/

$pdo->query("
    UPDATE notifications
    SET is_read = true
    WHERE is_read = false
");

/*
|--------------------------------------------------------------------------
| REDIRECT BACK
|--------------------------------------------------------------------------
*/

header("Location: /pages/admin/notifications.php");
exit();