<?php

$host = getenv("PGHOST");
$dbname = getenv("PGDATABASE");
$user = getenv("PGUSER");
$password = getenv("PGPASSWORD");
$port = getenv("PGPORT");

try {

    $pdo = new PDO(
        "pgsql:host=$host;port=$port;dbname=$dbname",
        $user,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Erreur connexion : " . $e->getMessage());

}