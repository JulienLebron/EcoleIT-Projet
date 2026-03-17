<?php
require_once './config/database.php';

function redirectErreur(string $message): void
{
    header('Location: reservation.php?error=' . urlencode($message));
    exit;
}

function minutesDepuisMinuit(string $heure): int
{
    [$h, $m] = explode(':', substr($heure, 0, 5));
    return ((int)$h * 60) + (int)$m;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirectErreur('Méthode non autorisée.');
}

$serviceId = isset($_POST['service_id']) ? (int)$_POST['service_id'] : 0;
$dateRdv = trim($_POST['date_rdv'] ?? '');
$heureRdv = trim($_POST['heure_rdv'] ?? '');
$nomClient = trim($_POST['nom_client'] ?? '');
$emailClient = trim($_POST['email_client'] ?? '');
$telephone = trim($_POST['telephone'] ?? '');

if ($serviceId <= 0 || !$dateRdv || !$heureRdv || !$nomClient || !$emailClient || !$telephone) {
    redirectErreur('Tous les champs obligatoires doivent être remplis.');
}

$dateObj = DateTime::createFromFormat('Y-m-d', $dateRdv);
if (!$dateObj || $dateObj->format('Y-m-d') !== $dateRdv) {
    redirectErreur('Date invalide.');
}

if (!preg_match('/^\d{2}:\d{2}$/', $heureRdv)) {
    redirectErreur('Heure invalide.');
}

if (!filter_var($emailClient, FILTER_VALIDATE_EMAIL)) {
    redirectErreur('Adresse email invalide.');
}

if ($dateRdv < date('Y-m-d')) {
    redirectErreur('Impossible de réserver dans le passé.');
}

$jourSemaine = (int)$dateObj->format('N');

/**
 * Récupération du service
 */
$stmt = $pdo->prepare("
    SELECT id, duree_minutes
    FROM services
    WHERE id = ?
");
$stmt->execute([$serviceId]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    redirectErreur('Service introuvable.');
}

$dureeService = (int)$service['duree_minutes'];
$debutNouveau = minutesDepuisMinuit($heureRdv);
$finNouveau = $debutNouveau + $dureeService;

/**
 * Vérifier que le créneau rentre dans une plage active
 */
$stmt = $pdo->prepare("
    SELECT heure_debut, heure_fin
    FROM disponibilites
    WHERE jour_semaine = ?
      AND actif = 1
");
$stmt->execute([$jourSemaine]);
$plages = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dansUnePlage = false;

foreach ($plages as $plage) {
    $debutPlage = minutesDepuisMinuit($plage['heure_debut']);
    $finPlage = minutesDepuisMinuit($plage['heure_fin']);

    if ($debutNouveau >= $debutPlage && $finNouveau <= $finPlage) {
        $dansUnePlage = true;
        break;
    }
}

if (!$dansUnePlage) {
    redirectErreur('Ce créneau est en dehors des horaires disponibles.');
}

/**
 * Vérifier les conflits
 */
$stmt = $pdo->prepare("
    SELECT r.heure_rdv, s.duree_minutes
    FROM reservations r
    INNER JOIN services s ON s.id = r.service_id
    WHERE r.date_rdv = ?
      AND r.statut IN ('en_attente', 'confirme')
");
$stmt->execute([$dateRdv]);
$reservationsExistantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($reservationsExistantes as $reservation) {
    $debutExistant = minutesDepuisMinuit($reservation['heure_rdv']);
    $finExistant = $debutExistant + (int)$reservation['duree_minutes'];

    if ($debutNouveau < $finExistant && $finNouveau > $debutExistant) {
        redirectErreur('Ce créneau vient d’être réservé. Veuillez en choisir un autre.');
    }
}

/**
 * Insertion
 */
$stmt = $pdo->prepare("
    INSERT INTO reservations (
        service_id,
        date_rdv,
        heure_rdv,
        nom_client,
        email_client,
        telephone,
        statut
    ) VALUES (?, ?, ?, ?, ?, ?, 'confirme')
");
$stmt->execute([
    $serviceId,
    $dateRdv,
    $heureRdv . ':00',
    $nomClient,
    $emailClient,
    $telephone
]);

header('Location: reservation.php?success=1');
exit;