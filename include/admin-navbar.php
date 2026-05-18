<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php

if (session_status() === PHP_SESSION_NONE) {

    session_start();
}

/*
|--------------------------------------------------------------------------
| DATABASE
|--------------------------------------------------------------------------
*/

require_once __DIR__ . "/db.php";

/*
|--------------------------------------------------------------------------
| PENDING ORDERS COUNT
|--------------------------------------------------------------------------
*/

$pendingQuery = $pdo->query("

    SELECT COUNT(*)

    FROM orders

    WHERE status = 'pending'

");

$pendingCount =
$pendingQuery->fetchColumn();

?>

<nav class="admin-navbar">

    <div class="admin-logo">

        <a href="/index.php">
            FreshMilk Admin
        </a>

    </div>

    <!-- MENU BUTTON -->

    <div
        class="admin-menu-toggle"
        id="admin-menu-toggle"
    >
        ☰
    </div>

    <!-- LINKS -->

    <div
        class="admin-links"
        id="admin-links"
    >

        <a href="/pages/admin.php">
            Dashboard
        </a>

        <a href="/pages/add-product.php">
            Ajouter produit
        </a>

        <a href="/pages/admin/manage-products.php">
            Produits
        </a>

        <a href="/pages/admin/order-admin.php">

    Commandes

    <?php if ($pendingCount > 0): ?>

        <span class="admin-badge">

            <?= $pendingCount ?>

        </span>

    <?php endif; ?>

</a>

    </div>

    <!-- USER -->

    <div class="admin-user">

        <span>
            👋 <?= htmlspecialchars($_SESSION["username"]) ?>
        </span>

        <a href="/pages/logout.php">
            Déconnexion
        </a>

    </div>

</nav>

<script>

const adminMenuToggle =
document.getElementById("admin-menu-toggle");

const adminLinks =
document.getElementById("admin-links");

adminMenuToggle.addEventListener("click", () => {

    adminLinks.classList.toggle("active");

});

</script>