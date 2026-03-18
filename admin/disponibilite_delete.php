<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

requireAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: disponibilites.php?error=' . urlencode('Disponibilité invalide.'));
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM disponibilites WHERE id = ?");
$stmt->execute([$id]);
$dispo = $stmt->fetch();

if (!$dispo) {
    header('Location: disponibilites.php?error=' . urlencode('Disponibilité introuvable.'));
    exit;
}

$stmt = $pdo->prepare("DELETE FROM disponibilites WHERE id = ?");
$stmt->execute([$id]);

header('Location: disponibilites.php?message=' . urlencode('Disponibilité supprimée avec succès.'));
exit;