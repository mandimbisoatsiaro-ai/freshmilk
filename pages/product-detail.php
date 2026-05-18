<?php

include '../include/db.php';

$id = $_GET['id'] ?? 1;

$query = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$query->execute([$id]);

$product = $query->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Produit introuvable");
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $product['name']; ?> - FreshMilk
    </title>
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet"
          href="../css/style.css">

</head>

<body>

<?php include '../include/navbar.php'; ?>

<section class="product-detail">

    <div class="product-detail-container">

        <div class="product-image">

            <img
                src="/assets/images/products/<?php echo $product['image']; ?>"
                alt="<?php echo $product['name']; ?>"
            >

        </div>

        <div class="product-info">

            <h1>
                <?php echo $product['name']; ?>
            </h1>

            <h2>
                <?php echo number_format($product['price']); ?> €
            </h2>

            <p>
                <?php echo $product['description']; ?>
            </p>

<form method="POST" action="/actions/add_to_cart.php">

    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

    <button type="submit" class="add-to-cart">
        Ajouter au panier
    </button>

</form>

        </div>

    </div>

</section>

<?php include '../include/footer.php'; ?>


<script src="/js/darkmode.js"></script>
</body>
</html>