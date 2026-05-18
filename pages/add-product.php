<?php

session_start();

require '../include/db.php';

/* Protection admin */

if (!isset($_SESSION["user_id"])) {

    header("Location: /pages/login.php");
    exit();
}

if ($_SESSION["role"] !== "admin") {

    header("Location: /index.php");
    exit();
}

/* Ajouter produit */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    $imageName = $_FILES['image']['name'];

    $tmp = $_FILES['image']['tmp_name'];

    $image = uniqid() . '-' . basename($imageName);

    move_uploaded_file(
        $tmp,
        "../assets/images/products/" . $image
    );

    $sql = "INSERT INTO products
    (name, price, stock, description, image)

    VALUES
    (:name, :price, :stock, :description, :image)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':name' => $name,
        ':price' => $price,
        ':stock' => $stock,
        ':description' => $description,
        ':image' => $image
    ]);

    header("Location: /pages/admin/manage-products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Ajouter produit
    </title>

    <link rel="stylesheet"
          href="/css/style.css?v=3">
    <link rel="stylesheet" href="/css/add-product.css?v=3">
    <link rel="stylesheet" href="../../css/admin.css">

</head>

<body>


<?php include "../include/admin-navbar.php"; ?>

<div class="admin-form-container">

    <form
        action=""
        method="POST"
        enctype="multipart/form-data"
        class="admin-form"
    >

        <h1>
            Ajouter un produit
        </h1>

        <input
            type="text"
            name="name"
            placeholder="Nom produit"
            required
        >

        <input
            type="number"
            step="0.01"
            name="price"
            placeholder="Prix"
            required
        >

        <input
            type="number"
            name="stock"
            placeholder="Stock"
            required
        >

        <textarea
            name="description"
            placeholder="Description"
        ></textarea>

        <input
            type="file"
            name="image"
            required
        >

        <button type="submit">
            Ajouter produit
        </button>

    </form>

</div>

<?php include "../include/footer.php"; ?>
<script src="/js/darkmode.js"></script>
</body>
</html>