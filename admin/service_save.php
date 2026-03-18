<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: services.php?error=' . urlencode('Méthode non autorisée.'));
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$categorie = trim($_POST['categorie'] ?? '');
$descriptionCategorie = trim($_POST['description_categorie'] ?? '');
$nom = trim($_POST['nom'] ?? '');
$description = trim($_POST['description'] ?? '');
$dureeMinutes = isset($_POST['duree_minutes']) ? (int)$_POST['duree_minutes'] : 0;
$prixEuros = isset($_POST['prix_euros']) && $_POST['prix_euros'] !== '' ? (float)$_POST['prix_euros'] : 0;

if ($categorie === '' || $descriptionCategorie === '' || $nom === '' || $description === '' || $dureeMinutes <= 0 || $prixEuros < 0) {
    $redirect = $id > 0 ? 'service_form.php?id=' . $id : 'service_form.php';
    header('Location: ' . $redirect . '&error=' . urlencode('Merci de remplir correctement tous les champs obligatoires.'));
    exit;
}

if ($id > 0) {
    $stmt = $pdo->prepare("
        UPDATE services
        SET
            categorie = ?,
            description_categorie = ?,
            nom = ?,
            description = ?,
            duree_minutes = ?,
            prix_euros = ?
        WHERE id = ?
    ");
    $stmt->execute([
        $categorie,
        $descriptionCategorie,
        $nom,
        $description,
        $dureeMinutes,
        $prixEuros,
        $id
    ]);

    header('Location: services.php?message=' . urlencode('Service modifié avec succès.'));
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO services (
        categorie,
        description_categorie,
        nom,
        description,
        duree_minutes,
        prix_euros
    ) VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->execute([
    $categorie,
    $descriptionCategorie,
    $nom,
    $description,
    $dureeMinutes,
    $prixEuros
]);

header('Location: services.php?message=' . urlencode('Service ajouté avec succès.'));
exit;