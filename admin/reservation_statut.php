<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: reservations.php?error=' . urlencode('Méthode non autorisée.'));
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$statut = $_POST['statut'] ?? '';
$date = $_POST['date'] ?? date('Y-m-d');

$statutsAutorises = ['en_attente', 'confirme', 'annule'];

if ($id <= 0) {
    header('Location: reservations.php?date=' . urlencode($date) . '&error=' . urlencode('Réservation invalide.'));
    exit;
}

if (!in_array($statut, $statutsAutorises, true)) {
    header('Location: reservations.php?date=' . urlencode($date) . '&error=' . urlencode('Statut invalide.'));
    exit;
}

/**
 * Vérifie que la réservation existe
 */
$stmt = $pdo->prepare("
    SELECT id
    FROM reservations
    WHERE id = ?
");
$stmt->execute([$id]);
$reservation = $stmt->fetch();

if (!$reservation) {
    header('Location: reservations.php?date=' . urlencode($date) . '&error=' . urlencode('Réservation introuvable.'));
    exit;
}

/**
 * Mise à jour du statut
 */
$stmt = $pdo->prepare("
    UPDATE reservations
    SET statut = ?
    WHERE id = ?
");
$stmt->execute([$statut, $id]);

header('Location: reservations.php?date=' . urlencode($date) . '&message=' . urlencode('Statut mis à jour avec succès.'));
exit;