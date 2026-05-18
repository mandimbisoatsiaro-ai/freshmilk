<?php
session_start();
require_once "../include/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$product_id = $_POST["product_id"];

// diminuer la quantité
$stmt = $pdo->prepare("
    UPDATE cart_items
    SET quantity = quantity - 1
    WHERE user_id = :user_id AND product_id = :product_id
");

$stmt->execute([
    "user_id" => $user_id,
    "product_id" => $product_id
]);

// supprimer si quantité <= 0
$stmt = $pdo->prepare("
    DELETE FROM cart_items
    WHERE user_id = :user_id AND product_id = :product_id AND quantity <= 0
");

$stmt->execute([
    "user_id" => $user_id,
    "product_id" => $product_id
]);

// retour panier
header("Location: ../pages/cart.php");
exit;