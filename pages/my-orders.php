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

$userId = $_SESSION["user_id"];

/*
|--------------------------------------------------------------------------
| GET USER ORDERS
|--------------------------------------------------------------------------
*/

$query = $pdo->prepare("

    SELECT *

    FROM orders

    WHERE user_id = :user_id

    ORDER BY created_at DESC

");

$query->execute([

    "user_id" => $userId

]);

$orders =
$query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Mes commandes - FreshMilk</title>

    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="/css/my-orders.css">
    <link rel="stylesheet" href="/css/style.css">

</head>

<body class="dark">

<?php include "../include/navbar.php"; ?>

<main class="my-orders-page">

    <div class="orders-header">

        <h1>
            📦 Mes Commandes
        </h1>

        <p>
            Suivez vos commandes FreshMilk.
        </p>

    </div>

    <div class="orders-container">

        <?php foreach ($orders as $order): ?>

            <?php

            /*
            |--------------------------------------------------------------------------
            | ORDER ITEMS
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

            <div class="order-card">

                <div class="order-top">

                    <div>

                        <h2>
                            Commande #<?= $order["id"] ?>
                        </h2>

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

                <div class="order-products">

                    <?php foreach ($items as $item): ?>

                        <div class="order-product">

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

                <div class="order-bottom">

    <h3>
        Total :
        <?= $order["total"] ?> €
    </h3>

    <!-- BOUTON FACTURE -->
    <a
        href="/pages/invoice.php?id=<?= $order['id'] ?>"
        class="invoice-btn"
    >
        📄 Télécharger facture
    </a>

    <?php if ($order["status"] === "pending"): ?>

        <form
            method="POST"
            action="/actions/cancel-order.php"
        >

            <input
                type="hidden"
                name="order_id"
                value="<?= $order["id"] ?>"
            >

            <button
                type="submit"
                class="cancel-btn"
            >
                ❌ Annuler
            </button>

        </form>

    <?php endif; ?>

</div>

        <?php endforeach; ?>

    </div>

</main>

<?php include "../include/footer.php"; ?>

<script src="/js/darkmode.js"></script>

</body>

</html>