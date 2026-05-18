<?php

session_start();

require "../include/db.php";

require "../vendor/autoload.php";

use Dompdf\Dompdf;

/*
|--------------------------------------------------------------------------
| CHECK LOGIN
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["user_id"])) {

    header("Location: /pages/login.php");
    exit();
}

$userId = $_SESSION["user_id"];

$orderId = $_GET["id"] ?? null;

if (!$orderId) {

    die("Commande invalide");
}

/*
|--------------------------------------------------------------------------
| GET ORDER
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("

    SELECT *

    FROM orders

    WHERE id = :id

    AND user_id = :user_id

");

$stmt->execute([

    "id" => $orderId,
    "user_id" => $userId

]);

$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {

    die("Commande introuvable");
}

/*
|--------------------------------------------------------------------------
| GET ITEMS
|--------------------------------------------------------------------------
*/

$stmtItems = $pdo->prepare("

    SELECT oi.*, p.name

    FROM order_items oi

    JOIN products p ON oi.product_id = p.id

    WHERE oi.order_id = :order_id

");

$stmtItems->execute([

    "order_id" => $orderId

]);

$items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| HTML FACTURE
|--------------------------------------------------------------------------
*/

$html = '

<h1 style="color:#3b82f6;">
    FreshMilk - Facture
</h1>

<hr>

<h3>Commande #' . $order["id"] . '</h3>

<p>Date : ' . $order["created_at"] . '</p>

<p>Status : ' . $order["status"] . '</p>

<br>

<table width="100%" border="1" cellspacing="0" cellpadding="10">

<tr>

    <th>Produit</th>
    <th>Quantité</th>
    <th>Prix</th>

</tr>

';

foreach ($items as $item) {

    $html .= '

    <tr>

        <td>' . $item["name"] . '</td>
        <td>' . $item["quantity"] . '</td>
        <td>' . $item["price"] . ' €</td>

    </tr>

    ';
}

$html .= '

</table>

<br>

<h2>Total : ' . $order["total"] . ' €</h2>

<p>Merci pour votre confiance 🥛 FreshMilk</p>

';

/*
|--------------------------------------------------------------------------
| GENERATE PDF
|--------------------------------------------------------------------------
*/

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("facture-" . $orderId . ".pdf", [
    "Attachment" => true
]);