<?php

session_start();

require '../../include/db.php';

/*
|--------------------------------------------------------------------------
| SECURITE ADMIN
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {

    header("Location: ../../index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| RECUPERATION PRODUIT
|--------------------------------------------------------------------------
*/
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Produit introuvable.");
}

$stmt = $pdo->prepare("
    SELECT *
    FROM products
    WHERE id = ?
");

$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Produit introuvable.");
}

/*
|--------------------------------------------------------------------------
| UPDATE PRODUIT
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $update = $pdo->prepare("
        UPDATE products
        SET
            name = ?,
            price = ?,
            stock = ?
        WHERE id = ?
    ");

    $update->execute([
        $name,
        $price,
        $stock,
        $id
    ]);

    header("Location: manage-products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <title>
        Modifier Produit
    </title>
    <link rel="stylesheet" href="../../css/edit-product.css">
    <link rel="stylesheet"
          href="/css/style.css?v=3">
    <link rel="stylesheet" href="../../css/admin.css">
    

</head>

<body>

<?php include "../../include/admin-navbar.php"; ?>

<div class="form-container">

    <h1>
        Modifier le produit
    </h1>

    <form method="POST">

        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($product['name']) ?>"
            required>

        <input
            type="number"
            step="0.01"
            name="price"
            value="<?= $product['price'] ?>"
            required>

        <input
            type="number"
            name="stock"
            value="<?= $product['stock'] ?>"
            required>

        <button type="submit">
            Sauvegarder
        </button>

    </form>

</div>
<?php include "../../include/footer.php"; ?>
<script src="/js/darkmode.js"></script>
</body>
</html>