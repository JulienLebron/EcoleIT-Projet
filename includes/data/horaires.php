<?php
if (!isset($pdo)) {
    require_once __DIR__ . '/../../config/database.php';
}

$sql = "
    SELECT
        jour_semaine,
        heure_debut,
        heure_fin,
        actif
    FROM disponibilites
    ORDER BY jour_semaine ASC, heure_debut ASC
";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll();

$jours = [
    1 => 'Lundi',
    2 => 'Mardi',
    3 => 'Mercredi',
    4 => 'Jeudi',
    5 => 'Vendredi',
    6 => 'Samedi',
    7 => 'Dimanche',
];

$horairesParJour = [];

foreach ($jours as $numeroJour => $nomJour) {
    $horairesParJour[$numeroJour] = [
        'nom' => $nomJour,
        'creneaux' => [],
        'ouvert' => false,
    ];
}

if (!function_exists('formatHeureFooter')) {
    function formatHeureFooter(string $heure): string
    {
        $timestamp = strtotime($heure);
        return date('G\hi', $timestamp);
    }
}

foreach ($rows as $row) {
    $jour = (int)$row['jour_semaine'];
    $actif = (int)$row['actif'] === 1;

    if (!$actif) {
        continue;
    }

    $horairesParJour[$jour]['ouvert'] = true;
    $horairesParJour[$jour]['creneaux'][] =
        formatHeureFooter($row['heure_debut']) . ' - ' . formatHeureFooter($row['heure_fin']);
}