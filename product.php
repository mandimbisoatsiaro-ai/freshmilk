<?php

$products = [

   1 => [

      "name" => "Lait Frais",

      "price" => "3€",

      "image" =>
      "https://images.unsplash.com/photo-1550583724-b2692b85b150?q=80&w=800",

      "description" =>
      "Lait frais naturel riche en calcium."

   ],

   2 => [

      "name" => "Fromage Bio",

      "price" => "6€",

      "image" =>
      "https://images.unsplash.com/photo-1628088062854-d1870b4553da?q=80&w=800",

      "description" =>
      "Fromage bio artisanal."

   ],

   3 => [

      "name" => "Yaourt Nature",

      "price" => "2€",

      "image" =>
      "https://images.unsplash.com/photo-1571212515416-fef01fc43637?q=80&w=800",

      "description" =>
      "Yaourt frais et naturel."

   ]

];

$id = $_GET["id"];

$product = $products[$id];

?>

<!DOCTYPE html>
<html lang="fr">

<head>

   <meta charset="UTF-8">

   <meta name="viewport"
         content="width=device-width, initial-scale=1.0">

   <title>

      <?= $product["name"] ?>

   </title>

   <link rel="stylesheet"
         href="css/style.css">

</head>
<script src="../js/cart.js"></script>
<body>

   <?php include "include/navbar.php"; ?>

   <main class="product-details">

      <img src="<?= $product["image"] ?>"
           alt="<?= $product["name"] ?>">

      <div class="details">

         <h1>

            <?= $product["name"] ?>

         </h1>

         <p class="price">

            <?= $product["price"] ?>

         </p>

         <p>

            <?= $product["description"] ?>

         </p>

         <button>

            Ajouter au panier

         </button>

      </div>

   </main>

   <?php include "include/footer.php"; ?>

</body>

</html>