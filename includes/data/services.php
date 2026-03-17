<?php
if (!isset($pdo)) {
    require_once __DIR__ . '/../../config/database.php';
}

$sql = "
    SELECT
        id,
        categorie,
        description_categorie,
        nom,
        description,
        duree_minutes,
        prix_euros
    FROM services
    ORDER BY categorie ASC, nom ASC
";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();

$servicesParCategorie = [];

foreach ($rows as $row) {
    $categorie = $row['categorie'];

    if (!isset($servicesParCategorie[$categorie])) {
        $servicesParCategorie[$categorie] = [
            'description_categorie' => $row['description_categorie'],
            'items' => []
        ];
    }

    $servicesParCategorie[$categorie]['items'][] = $row;
}