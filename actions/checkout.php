<?php
session_start();
require_once "../include/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

/*
    1. récupérer panier
*/
$stmt = $pdo->prepare("
    SELECT c.product_id, c.quantity, p.price
    FROM cart_items c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = :user_id
");

$stmt->execute(["user_id" => $user_id]);
$cart = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($cart) === 0) {
    header("Location: ../pages/cart.php");
    exit;
}

/*
    2. calcul total
*/
$total = 0;
foreach ($cart as $item) {
    $total += $item["price"] * $item["quantity"];
}

/*
    3. créer commande
*/
$stmt = $pdo->prepare("
    INSERT INTO orders (user_id, total)
    VALUES (:user_id, :total)
    RETURNING id
");

$stmt->execute([
    "user_id" => $user_id,
    "total" => $total
]);

$order_id = $stmt->fetchColumn();
/*
|--------------------------------------------------------------------------
| ADMIN NOTIFICATION
|--------------------------------------------------------------------------
*/

$pdo->prepare("
    INSERT INTO notifications (type, message)
    VALUES ('order', :message)
")->execute([
    "message" => "Nouvelle commande #$order_id reçue"
]);
/*
    4. copier produits dans order_items
*/
foreach ($cart as $item) {

    $stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, price)
        VALUES (:order_id, :product_id, :quantity, :price)
    ");

    $stmt->execute([
        "order_id" => $order_id,
        "product_id" => $item["product_id"],
        "quantity" => $item["quantity"],
        "price" => $item["price"]
    ]);
}

/*
    5. vider panier
*/
$stmt = $pdo->prepare("
    DELETE FROM cart_items WHERE user_id = :user_id
");

$stmt->execute(["user_id" => $user_id]);

/*
    6. redirection confirmation
*/
header("Location: ../pages/order-success.php?id=" . $order_id);
exit;