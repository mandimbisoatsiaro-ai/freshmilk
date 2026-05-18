<?php

session_start();

require "../include/db.php";

/*
|--------------------------------------------------------------------------
| CHECK LOGIN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: /pages/login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

/*
|--------------------------------------------------------------------------
| GET CART ITEMS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("

    SELECT
        c.*,
        p.price

    FROM cart_items c

    JOIN products p
    ON c.product_id = p.id

    WHERE c.user_id = :user_id

");

$stmt->execute([

    "user_id" => $user_id

]);

$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| CHECK EMPTY CART
|--------------------------------------------------------------------------
*/

if (count($cartItems) <= 0) {

    header("Location: /pages/cart.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| CALCUL TOTAL
|--------------------------------------------------------------------------
*/

$total = 0;

foreach ($cartItems as $item) {

    $total += $item["price"] * $item["quantity"];
}

/*
|--------------------------------------------------------------------------
| CREATE ORDER
|--------------------------------------------------------------------------
*/

$sql = "

    INSERT INTO orders (

        user_id,
        total,
        status

    )

    VALUES (

        :user_id,
        :total,
        'pending'

    )

    RETURNING id

";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    "user_id" => $user_id,
    "total" => $total

]);

$order = $stmt->fetch(PDO::FETCH_ASSOC);

$orderId = $order["id"];

/*
|--------------------------------------------------------------------------
| INSERT ORDER ITEMS
|--------------------------------------------------------------------------
*/

foreach ($cartItems as $item) {

    $sql = "

        INSERT INTO order_items (

            order_id,
            product_id,
            quantity,
            price

        )

        VALUES (

            :order_id,
            :product_id,
            :quantity,
            :price

        )

    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([

        "order_id" => $orderId,
        "product_id" => $item["product_id"],
        "quantity" => $item["quantity"],
        "price" => $item["price"]

    ]);
}

/*
|--------------------------------------------------------------------------
| CLEAR CART
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("

    DELETE FROM cart_items

    WHERE user_id = :user_id

");

$stmt->execute([

    "user_id" => $user_id

]);

/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/

header("Location: /pages/orders.php");

exit();