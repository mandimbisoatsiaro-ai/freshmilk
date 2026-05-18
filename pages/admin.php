<?php
session_start();

require "../include/db.php";

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
| TOTAL PRODUITS
|--------------------------------------------------------------------------
*/
$productQuery = $pdo->query("SELECT COUNT(*) FROM products");
$totalProducts = $productQuery->fetchColumn();

/*
|--------------------------------------------------------------------------
| TOTAL COMMANDES
|--------------------------------------------------------------------------
*/
$orderQuery = $pdo->query("SELECT COUNT(*) FROM orders");
$totalOrders = $orderQuery->fetchColumn();

/*
|--------------------------------------------------------------------------
| TOTAL UTILISATEURS
|--------------------------------------------------------------------------
*/
$userQuery = $pdo->query("SELECT COUNT(*) FROM users");
$totalUsers = $userQuery->fetchColumn();
/*
|--------------------------------------------------------------------------
| TOTAL REVENUE
|--------------------------------------------------------------------------
*/

$revenueQuery = $pdo->query("

    SELECT COALESCE(SUM(total), 0)
    FROM orders

    WHERE status != 'cancelled'

");

$totalRevenue = $revenueQuery->fetchColumn();

/*
|--------------------------------------------------------------------------
| PENDING ORDERS
|--------------------------------------------------------------------------
*/

$pendingQuery = $pdo->query("

    SELECT COUNT(*)
    FROM orders

    WHERE status = 'pending'

");

$pendingOrders = $pendingQuery->fetchColumn();

/*
|--------------------------------------------------------------------------
| DELIVERED ORDERS
|--------------------------------------------------------------------------
*/

$deliveredQuery = $pdo->query("

    SELECT COUNT(*)
    FROM orders

    WHERE status = 'delivered'

");

$deliveredOrders = $deliveredQuery->fetchColumn();
/*
|--------------------------------------------------------------------------
| RECENT ORDERS
|--------------------------------------------------------------------------
*/

$recentOrdersQuery = $pdo->query("

    SELECT
        orders.*,
        users.username

    FROM orders

    JOIN users
    ON orders.user_id = users.id

    ORDER BY orders.created_at DESC

    LIMIT 5

");

$recentOrders =
$recentOrdersQuery->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| RECENT USERS
|--------------------------------------------------------------------------
*/

$recentUsersQuery = $pdo->query("

    SELECT *

    FROM users

    ORDER BY id DESC

    LIMIT 5

");

$recentUsers =
$recentUsersQuery->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| TOP PRODUCTS
|--------------------------------------------------------------------------
*/

$topProductsQuery = $pdo->query("

    SELECT
        products.name,
        COUNT(order_items.product_id) as total_sales

    FROM order_items

    JOIN products
    ON order_items.product_id = products.id

    GROUP BY products.name

    ORDER BY total_sales DESC

    LIMIT 5

");

$topProducts =
$topProductsQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin - FreshMilk</title>
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet"
          href="/css/style.css">

</head>

<body class="dark">
<?php include "../include/admin-navbar.php"; ?>
<main class="admin-page">
<?php if (isset($_SESSION["admin_notification"])): ?>

    <div class="admin-toast">

        🔔 <?= $_SESSION["admin_notification"] ?>

    </div>

    <?php unset($_SESSION["admin_notification"]); ?>

<?php endif; ?>
    <h1>Administration</h1>

<div class="admin-dashboard">

    <div class="admin-header">

        <h1>
            Dashboard Admin
        </h1>

        <p>
            Gérez votre boutique FreshMilk facilement.
        </p>

    </div>

    <div class="admin-stats">

        <div class="stat-card">

            <h2>
                <?= $totalProducts ?>
            </h2>

            <p>
                Produits
            </p>

        </div>

        <div class="stat-card">

            <h2>
                <?= $totalOrders ?>
            </h2>

            <p>
                Commandes
            </p>

        </div>

        <div class="stat-card">

            <h2>
                <?= $totalUsers ?>
            </h2>

            <p>
                Utilisateurs
            </p>

        </div>
        <div class="stat-card">

    <h2>
        €<?= number_format($totalRevenue, 2) ?>
    </h2>

    <p>
        Chiffre d'affaires
    </p>

</div>

<div class="stat-card">

    <h2>
        <?= $pendingOrders ?>
    </h2>

    <p>
        Commandes Pending
    </p>

</div>

<div class="stat-card">

    <h2>
        <?= $deliveredOrders ?>
    </h2>

    <p>
        Commandes Livrées
    </p>

</div>

    </div>

    <div class="admin-actions">

        <div class="admin-card">

            <h3>
                Ajouter produit
            </h3>

            <p>
                Ajoutez rapidement de nouveaux produits.
            </p>

            <a
                href="/pages/add-product.php"
                class="admin-btn"
            >
                Ajouter
            </a>

        </div>

        <div class="admin-card">

            <h3>
                Gérer produits
            </h3>

            <p>
                Modifiez ou supprimez vos produits.
            </p>

            <a
                href="/pages/admin/manage-products.php"
                class="admin-btn"
            >
                Gérer
            </a>

        </div>

        <div class="admin-card">

            <h3>
                📦 Commandes
            </h3>

            <p>
                Consultez les commandes des clients.
            </p>

            <a
                href="/pages/admin/order-admin.php"
                class="admin-btn"
            >
                Voir
            </a>

        </div>
        <div class="admin-card">

    <h3>
        📩 Messages
    </h3>

    <p>
        Consultez les messages envoyés par les clients.
    </p>

    <a
        href="/pages/admin/messages.php"
        class="admin-btn"
    >
        Voir messages
    </a>

</div>

    </div>

</div>
<div class="analytics-section">

    <!-- RECENT ORDERS -->

    <div class="analytics-card">

        <h2>
            📦 Dernières commandes
        </h2>

        <?php foreach ($recentOrders as $order): ?>

            <div class="analytics-item">

                <div>

                    <strong>
                        #<?= $order["id"] ?>
                    </strong>

                    <p>
                        <?= htmlspecialchars($order["username"]) ?>
                    </p>

                </div>

                <span>
                    €<?= $order["total"] ?>
                </span>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- RECENT USERS -->

    <div class="analytics-card">

        <h2>
            👥 Nouveaux utilisateurs
        </h2>

        <?php foreach ($recentUsers as $user): ?>

            <div class="analytics-item">

                <div>

                    <strong>
                        <?= htmlspecialchars($user["username"]) ?>
                    </strong>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- TOP PRODUCTS -->

    <div class="analytics-card">

        <h2>
            🥛 Top Produits
        </h2>

        <?php foreach ($topProducts as $product): ?>

            <div class="analytics-item">

                <div>

                    <strong>
                        <?= htmlspecialchars($product["name"]) ?>
                    </strong>

                </div>

                <span>
                    <?= $product["total_sales"] ?> ventes
                </span>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</main>

<?php include "../include/footer.php"; ?>
<script src="/js/darkmode.js"></script>
</body>
</html>