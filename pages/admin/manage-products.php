<?php

session_start();


require '../../include/db.php';

/* Protection admin */

if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {

    header("Location: ../../index.php");
    exit();
}

/* Produits */

$sql = "
SELECT *
FROM products
ORDER BY id DESC
";

$stmt = $pdo->query($sql);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Gestion Produits
    </title>

    <link rel="stylesheet"
          href="/css/style.css?v=3">
        <link rel="stylesheet" href="../../css/admin.css">

</head>

<body>
<?php include "../../include/admin-navbar.php"; ?>

<link rel="stylesheet" href="../../css/add-product.css">
    <div class="admin-container">

        <h1>
            Gestion des produits
        </h1>

        <a href="/pages/add-product.php"
           class="add-btn">

            Ajouter un produit

        </a>

        <div class="products-admin-grid">

            <?php foreach($products as $product): ?>

                <div class="product-admin-card">

                    <img
                        src="/assets/images/products/<?= $product['image'] ?>"
                        alt="<?= $product['name'] ?>">

                    <h3>
                        <?= $product['name'] ?>
                    </h3>

                    <p>
                        <?= $product['price'] ?> €
                    </p>

                    <p>
                        Stock : <?= $product['stock'] ?>
                    </p>

                    <div class="admin-actions">

                        <a href="edit-product.php?id=<?= $product['id'] ?>"
                           class="edit-btn">

                            Modifier

                        </a>

                        <a href="delete-product.php?id=<?= $product['id'] ?>"
                           class="delete-btn">

                            Supprimer

                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>
<?php include "../../include/footer.php"; ?>
<script src="/js/darkmode.js"></script>
</body>

</html>