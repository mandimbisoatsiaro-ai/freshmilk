<?php

session_start();

require '../../include/db.php';

/*
|--------------------------------------------------------------------------
| SECURITE ADMIN
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {

    header("Location: ../../index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| ID PRODUIT
|--------------------------------------------------------------------------
*/
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Produit introuvable.");
}

/*
|--------------------------------------------------------------------------
| DELETE ORDER ITEMS
|--------------------------------------------------------------------------
*/
$deleteItems = $pdo->prepare("
    DELETE FROM order_items
    WHERE product_id = ?
");

$deleteItems->execute([$id]);

/*
|--------------------------------------------------------------------------
| DELETE PRODUCT
|--------------------------------------------------------------------------
*/
$deleteProduct = $pdo->prepare("
    DELETE FROM products
    WHERE id = ?
");

$deleteProduct->execute([$id]);

/*
|--------------------------------------------------------------------------
| REDIRECTION
|--------------------------------------------------------------------------
*/
header("Location: manage-products.php");
exit();
?>