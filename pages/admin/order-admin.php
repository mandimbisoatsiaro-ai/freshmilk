<?php

session_start();

require "../../include/db.php";

/*
|--------------------------------------------------------------------------
| CHECK ADMIN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: /pages/login.php");
    exit();
}

if ($_SESSION["role"] !== "admin") {

    header("Location: /index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| UPDATE STATUS
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $orderId = $_POST["order_id"];
    $status = $_POST["status"];

    $update = $pdo->prepare("

        UPDATE orders

        SET status = :status

        WHERE id = :id

    ");

    $update->execute([

        "status" => $status,
        "id" => $orderId

    ]);
}

/*
|--------------------------------------------------------------------------
| GET ORDERS
|--------------------------------------------------------------------------
*/

$sql = "

    SELECT
        orders.*,
        users.username

    FROM orders

    JOIN users
    ON orders.user_id = users.id

    ORDER BY orders.created_at DESC

";

$query = $pdo->query($sql);

$orders = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Commandes - FreshMilk</title>

    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/admin-orders.css">
    <link rel="stylesheet" href="/css/style.css">

</head>

<body class="dark">

<?php include "../../include/admin-navbar.php"; ?>

<main class="admin-orders-page">

    <div class="admin-orders-header">

        <h1>
            📦 Gestion des Commandes
        </h1>

        <p>
            Gérez toutes les commandes clients FreshMilk.
        </p>

    </div>

    <div class="orders-container">

        <?php foreach ($orders as $order): ?>

            <?php

            /*
            |--------------------------------------------------------------------------
            | GET ORDER ITEMS
            |--------------------------------------------------------------------------
            */

            $itemsQuery = $pdo->prepare("

                SELECT
                    oi.*,
                    p.name,
                    p.image

                FROM order_items oi

                JOIN products p
                ON oi.product_id = p.id

                WHERE oi.order_id = :order_id

            ");

            $itemsQuery->execute([

                "order_id" => $order["id"]

            ]);

            $items =
            $itemsQuery->fetchAll(PDO::FETCH_ASSOC);

            ?>

            <div class="admin-order-card">

                <div class="order-top">

                    <div>

                        <h2>
                            Commande #<?= $order["id"] ?>
                        </h2>

                        <p>
                            👤 Client :
                            <?= htmlspecialchars($order["username"]) ?>
                        </p>

                        <p>
                            📅 <?= $order["created_at"] ?>
                        </p>

                    </div>

                    <div
                        class="status-badge <?= $order["status"] ?>"
                    >

                        <?= strtoupper($order["status"]) ?>

                    </div>

                </div>

                <div class="order-items">

                    <?php foreach ($items as $item): ?>

                        <div class="order-item">

                            <img
                                src="/assets/images/products/<?= htmlspecialchars($item["image"]) ?>"
                                alt="<?= htmlspecialchars($item["name"]) ?>"
                            >

                            <div>

                                <h3>
                                    <?= htmlspecialchars($item["name"]) ?>
                                </h3>

                                <p>
                                    Quantité :
                                    <?= $item["quantity"] ?>
                                </p>

                                <p>
                                    Prix :
                                    <?= $item["price"] ?> €
                                </p>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

                <div class="order-footer">

                    <h3>
                        Total :
                        <?= $order["total"] ?> €
                    </h3>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="order_id"
                            value="<?= $order["id"] ?>"
                        >

                        <select name="status">

                            <option value="pending">
                                Pending
                            </option>

                            <option value="processing">
                                Processing
                            </option>

                            <option value="shipping">
                                Shipping
                            </option>

                            <option value="delivered">
                                Delivered
                            </option>

                            <option value="cancelled">
                                Cancelled
                            </option>

                        </select>

                        <button type="submit">
                            Mettre à jour
                        </button>

                    </form>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</main>

<script src="/js/darkmode.js"></script>

</body>

</html>