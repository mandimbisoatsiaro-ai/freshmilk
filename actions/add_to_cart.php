<?php
session_start();
require_once "../include/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$product_id = $_POST["product_id"];

// vérifier si produit déjà dans panier
$stmt = $pdo->prepare("
    SELECT * FROM cart_items
    WHERE user_id = :user_id AND product_id = :product_id
");

$stmt->execute([
    "user_id" => $user_id,
    "product_id" => $product_id
]);

$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item) {

    // augmenter quantité
    $stmt = $pdo->prepare("
        UPDATE cart_items
        SET quantity = quantity + 1
        WHERE user_id = :user_id AND product_id = :product_id
    ");

    $stmt->execute([
        "user_id" => $user_id,
        "product_id" => $product_id
    ]);

} else {

    // ajouter nouveau produit
    $stmt = $pdo->prepare("
        INSERT INTO cart_items (user_id, product_id, quantity)
        VALUES (:user_id, :product_id, 1)
    ");

    $stmt->execute([
        "user_id" => $user_id,
        "product_id" => $product_id
    ]);
}

$product_id = $_POST["product_id"];

header("Location: ../pages/product-detail.php?id=" . $product_id);

exit;