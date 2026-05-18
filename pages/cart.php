<?php

session_start();

if (!isset($_SESSION["user_id"])) {

    header("Location: login.php");
    exit;
}

require_once "../include/db.php";

$user_id = $_SESSION["user_id"];

/*
|--------------------------------------------------------------------------
| GET CART ITEMS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("

    SELECT
        c.*,
        p.name,
        p.price,
        p.image

    FROM cart_items c

    JOIN products p
    ON c.product_id = p.id

    WHERE c.user_id = :user_id

");

$stmt->execute([

    "user_id" => $user_id

]);

$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| TOTAL
|--------------------------------------------------------------------------
*/

$total = 0;

foreach ($items as $row) {

    $total += $row["price"] * $row["quantity"];
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Panier - FreshMilk</title>

    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body class="dark">

<?php include "../include/navbar.php"; ?>

<main class="cart-page">

    <h1>
        Mon Panier
    </h1>

    <div class="cart-container">

        <?php if (count($items) > 0): ?>

            <?php foreach ($items as $row): ?>

                <?php
                    $subtotal =
                    $row["price"] * $row["quantity"];
                ?>

                <div class="cart-item">

                    <img
                        src="/assets/images/products/<?= htmlspecialchars($row["image"]) ?>"
                        alt="<?= htmlspecialchars($row["name"]) ?>"
                    >

                    <div class="cart-info">

                        <h3>
                            <?= htmlspecialchars($row["name"]) ?>
                        </h3>

                        <p>
                            Prix :
                            <?= htmlspecialchars($row["price"]) ?> €
                        </p>

                        <div class="qty-controls">

                            <form
                                method="POST"
                                action="../actions/decrease_quantity.php"
                            >

                                <input
                                    type="hidden"
                                    name="product_id"
                                    value="<?= $row['product_id'] ?>"
                                >

                                <button type="submit">
                                    -
                                </button>

                            </form>

                            <span>
                                <?= $row["quantity"] ?>
                            </span>

                            <form
                                method="POST"
                                action="../actions/increase_quantity.php"
                            >

                                <input
                                    type="hidden"
                                    name="product_id"
                                    value="<?= $row['product_id'] ?>"
                                >

                                <button type="submit">
                                    +
                                </button>

                            </form>

                        </div>

                        <p class="subtotal">

                            Sous-total :
                            <?= number_format($subtotal, 2) ?> €

                        </p>

                        <form
                            method="POST"
                            action="../actions/remove_from_cart.php"
                        >

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?= $row['product_id'] ?>"
                            >

                            <button
                                class="remove-btn"
                                type="submit"
                            >
                                🗑 Supprimer
                            </button>

                        </form>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <p class="empty-cart">
                Ton panier est vide 🛒
            </p>

        <?php endif; ?>

    </div>

    <?php if (count($items) > 0): ?>

        <div class="cart-total">

            <h2>

                Total :
                <?= number_format($total, 2) ?> €

            </h2>

            <a
                href="/pages/checkout.php"
                class="checkout-btn"
            >
                Valider la commande
            </a>

        </div>

    <?php endif; ?>

</main>

<?php include "../include/footer.php"; ?>

<script src="/js/darkmode.js"></script>

</body>

</html>