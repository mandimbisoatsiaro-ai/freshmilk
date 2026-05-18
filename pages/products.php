
<?php

include '../include/db.php';

$query = $pdo->query("SELECT * FROM products ORDER BY id DESC");

$products = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Produits - FreshMilk</title>
    <link rel="stylesheet" href="/css/navbar.css">
    <link rel="stylesheet" href="../css/style.css">

</head>

<body class="dark">

<?php include "../include/navbar.php"; ?>

<main class="products-page">

    <h1 class="page-title">
        Nos Produits
    </h1>
    <input
    type="text"
    id="search-input"
    placeholder="Rechercher un produit..."
>

    <div class="products-container">

        <?php foreach($products as $product): ?>

            <div     class="product-card searchable-product"
                     data-name="<?= strtolower($product['name']) ?>"
                 > 

                <img
                    src="/assets/images/products/<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                >

                <h3>
                    <?php echo $product['name']; ?>
                </h3>

                <p class="description">

                    <?php echo $product['description']; ?>

                </p>

                <p class="price">

                    €<?php echo $product['price']; ?>

                </p>

                <a
                    href="product-detail.php?id=<?php echo $product['id']; ?>"
                >

                    <button>

                        Voir le produit

                    </button>

                </a>

            </div>

        <?php endforeach; ?>

    </div>

</main>

<?php include "../include/footer.php"; ?>
<script src="../js/darkmode.js"></script>
<script>

const searchInput =
document.getElementById("search-input");

searchInput.addEventListener("keyup", () => {

    const value =
    searchInput.value.toLowerCase();

    const products =
    document.querySelectorAll(
        ".searchable-product"
    );

    products.forEach(product => {

        const name =
        product.dataset.name;

        if(name.includes(value)){

            product.style.display = "";

        }else{

            product.style.display = "none";

        }

    });

});

</script>
</body>
</html>