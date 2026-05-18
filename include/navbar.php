<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<?php
require_once __DIR__ . "/db.php";

$cartCount = 0;

if (isset($_SESSION["user_id"])) {

    $stmt = $pdo->prepare("
        SELECT COALESCE(SUM(quantity), 0) as total
        FROM cart_items
        WHERE user_id = :user_id
    ");

    $stmt->execute([
        "user_id" => $_SESSION["user_id"]
    ]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $cartCount = $result["total"];
}
?>
<nav class="navbar">
<div class="navbar-container">
    <div class="logo">

        <a href="/index.php">

            FreshMilk

        </a>

    </div>

    <div class="nav-links">

        <a href="/index.php">
            Accueil
        </a>

        <a href="/pages/products.php">
            Produits
        </a>

        <a href="/pages/about.php">
            À propos
        </a>

        <a href="/pages/contact.php">
            Contact
        </a>

    </div>

    <div class="nav-right">

<?php if(isset($_SESSION["user_id"])): ?>

    <span class="user-name">
        👋 <?php echo $_SESSION["username"]; ?>
    </span>

    <?php if(isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>

        <a href="/pages/admin.php">
            Admin
        </a>

    <?php endif; ?>

    <a
        href="/pages/logout.php"
        class="register-btn"
    >
        Déconnexion
    </a>

    <a href="/pages/my-orders.php">
        Mes commandes
    </a>

<?php else: ?>

    <a
        href="/pages/login.php"
        class="login-btn"
    >
        Connexion
    </a>

    <a
        href="/pages/register.php"
        class="register-btn"
    >
        Inscription
    </a>
    

<?php endif; ?>

    <a
        href="/pages/cart.php"
        class="cart-btn"
    >

        🛒 Panier

        <span
            id="cart-count"
            class="cart-count"
        >
            <?= $cartCount ?>
        </span>

    </a>

    <button
        id="darkModeToggle" class="dark-btn"
    >
        🌙
    </button>

</div>
</div>
</nav>