<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

requireAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: services.php?error=' . urlencode('Service invalide.'));
    exit;
}

/**
 * Vérifie si le service existe
 */
$stmt = $pdo->prepare("SELECT id FROM services WHERE id = ?");
$stmt->execute([$id]);
$service = $stmt->fetch();

if (!$service) {
    header('Location: services.php?error=' . urlencode('Service introuvable.'));
    exit;
}

/**
 * Optionnel : empêcher la suppression si des réservations existent déjà
 */
$stmt = $pdo->prepare("SELECT COUNT(*) FROM reservations WHERE service_id = ?");
$stmt->execute([$id]);
$nbReservations = (int)$stmt->fetchColumn();

if ($nbReservations > 0) {
    header('Location: services.php?error=' . urlencode('Impossible de supprimer ce service car des réservations y sont liées.'));
    exit;
}

$stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
$stmt->execute([$id]);

header('Location: services.php?message=' . urlencode('Service supprimé avec succès.'));
exit;