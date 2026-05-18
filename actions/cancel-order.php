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

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $orderId = $_POST["order_id"];

    $userId = $_SESSION["user_id"];

    /*
    |--------------------------------------------------------------------------
    | VERIFY ORDER
    |--------------------------------------------------------------------------
    */

    $query = $pdo->prepare("

        SELECT *

        FROM orders

        WHERE id = :id

        AND user_id = :user_id

    ");

    $query->execute([

        "id" => $orderId,
        "user_id" => $userId

    ]);

    $order =
    $query->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | CANCEL ONLY IF PENDING
    |--------------------------------------------------------------------------
    */

    if ($order && $order["status"] === "pending") {

        $update = $pdo->prepare("

            UPDATE orders

            SET status = 'cancelled'

            WHERE id = :id

        ");

        $update->execute([

            "id" => $orderId

        ]);
    }
}

header("Location: /pages/my-orders.php");

exit();