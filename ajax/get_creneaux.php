<?php
require_once '../config/database.php';

header('Content-Type: application/json; charset=utf-8');

function reponseJson(array $data): void
{
    echo json_encode($data);
    exit;
}

function minutesDepuisMinuit(string $heure): int
{
    [$h, $m] = explode(':', substr($heure, 0, 5));
    return ((int)$h * 60) + (int)$m;
}

function heureDepuisMinutes(int $minutes): string
{
    $h = floor($minutes / 60);
    $m = $minutes % 60;
    return sprintf('%02d:%02d', $h, $m);
}

$serviceId = isset($_GET['service_id']) ? (int)$_GET['service_id'] : 0;
$date = $_GET['date'] ?? '';

if ($serviceId <= 0 || !$date) {
    reponseJson([
        'success' => false,
        'message' => 'Paramètres invalides.'
    ]);
}

$dateObj = DateTime::createFromFormat('Y-m-d', $date);
if (!$dateObj || $dateObj->format('Y-m-d') !== $date) {
    reponseJson([
        'success' => false,
        'message' => 'Date invalide.'
    ]);
}

if ($date < date('Y-m-d')) {
    reponseJson([
        'success' => false,
        'message' => 'Date passée non autorisée.'
    ]);
}

/**
 * 1 = lundi ... 7 = dimanche
 */
$jourSemaine = (int)$dateObj->format('N');

/**
 * Récupération du service
 */
$stmt = $pdo->prepare("
    SELECT id, nom, duree_minutes
    FROM services
    WHERE id = ?
");
$stmt->execute([$serviceId]);
$service = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$service) {
    reponseJson([
        'success' => false,
        'message' => 'Service introuvable.'
    ]);
}

$dureeService = (int)$service['duree_minutes'];

/**
 * Récupération des disponibilités du jour
 */
$stmt = $pdo->prepare("
    SELECT heure_debut, heure_fin
    FROM disponibilites
    WHERE jour_semaine = ?
      AND actif = 1
    ORDER BY heure_debut ASC
");
$stmt->execute([$jourSemaine]);
$disponibilites = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$disponibilites) {
    reponseJson([
        'success' => true,
        'creneaux' => [],
        'message' => 'Salon fermé ce jour-là.'
    ]);
}

/**
 * Récupération des réservations de la date
 */
$stmt = $pdo->prepare("
    SELECT r.heure_rdv, s.duree_minutes
    FROM reservations r
    INNER JOIN services s ON s.id = r.service_id
    WHERE r.date_rdv = ?
      AND r.statut IN ('en_attente', 'confirme')
");
$stmt->execute([$date]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$reservationsBloquantes = [];

foreach ($reservations as $reservation) {
    $debut = minutesDepuisMinuit($reservation['heure_rdv']);
    $fin = $debut + (int)$reservation['duree_minutes'];

    $reservationsBloquantes[] = [
        'debut' => $debut,
        'fin' => $fin,
    ];
}

/**
 * Génération des créneaux
 * Pas de 30 minutes
 */
$pas = 30;
$creneauxDisponibles = [];

foreach ($disponibilites as $plage) {
    $debutPlage = minutesDepuisMinuit($plage['heure_debut']);
    $finPlage = minutesDepuisMinuit($plage['heure_fin']);

    for ($debutCreneau = $debutPlage; $debutCreneau + $dureeService <= $finPlage; $debutCreneau += $pas) {
        $finCreneau = $debutCreneau + $dureeService;
        $conflit = false;

        foreach ($reservationsBloquantes as $reservation) {
            if ($debutCreneau < $reservation['fin'] && $finCreneau > $reservation['debut']) {
                $conflit = true;
                break;
            }
        }

        if (!$conflit) {
            $creneauxDisponibles[] = heureDepuisMinutes($debutCreneau);
        }
    }
}

reponseJson([
    'success' => true,
    'creneaux' => $creneauxDisponibles
]);