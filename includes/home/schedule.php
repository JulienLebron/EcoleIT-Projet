<?php
require_once './config/database.php';

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

/**
 * Tableau de base pour garantir l'affichage des 7 jours
 */
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

foreach ($rows as $row) {
    $jour = (int)$row['jour_semaine'];
    $actif = (int)$row['actif'] === 1;

    if (!$actif) {
        continue;
    }

    $horairesParJour[$jour]['ouvert'] = true;
    $horairesParJour[$jour]['creneaux'][] =
        formatHeure($row['heure_debut']) . ' - ' . formatHeure($row['heure_fin']);
}
?>

<section id="horaires" class="py-5 bg-white">
    <div class="container">
        <div class="mx-auto" style="max-width: 56rem;">

            <div class="text-center mb-5">
                <div class="d-inline-block px-4 py-2 rounded-pill mb-3" style="background-color: #ffe4e6; color: #e11d48;">
                    Horaires
                </div>
                <h2 class="display-5 fw-bold text-dark mb-4">Nos horaires d'ouverture</h2>
                <p class="fs-5 text-secondary">
                    Nous sommes à votre disposition 6 jours sur 7. Prenez rendez-vous pour garantir votre créneau.
                </p>
            </div>

            <div class="p-4 p-md-5 shadow rounded-4" style="background: linear-gradient(135deg, #f9fafb, #fff1f2);">

                <div class="row g-3">

                    <?php foreach ($horairesParJour as $jour): ?>
                        <?php
                            $ouvert = $jour['ouvert'];
                            $texteHoraires = $ouvert
                                ? implode(' / ', $jour['creneaux'])
                                : 'Fermé';
                        ?>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-between p-4 rounded-3 <?= $ouvert ? 'bg-white shadow-sm' : 'bg-light opacity-75' ?>">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="<?= $ouvert ? 'bg-success' : 'bg-secondary' ?> rounded-circle" style="width: 0.75rem; height: 0.75rem;"></div>
                                    <span class="<?= $ouvert ? 'text-dark' : 'text-muted' ?>">
                                        <?= htmlspecialchars($jour['nom']) ?>
                                    </span>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <?php if ($ouvert): ?>
                                        <i class="fa-regular fa-clock text-danger"></i>
                                    <?php endif; ?>

                                    <span class="<?= $ouvert ? 'text-dark' : 'text-muted' ?>">
                                        <?= htmlspecialchars($texteHoraires) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="mt-4 p-4 rounded-4 text-white" style="background-color: #f43f5e;">
                    <div class="d-flex align-items-start gap-3">
                        <i class="fa-regular fa-clock mt-1"></i>
                        <div>
                            <h3 class="fs-6 mb-3">Informations importantes</h3>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">• Rendez-vous obligatoire pour toutes les prestations</li>
                                <li class="mb-2">• Les horaires peuvent varier les jours fériés</li>
                                <li class="mb-2">• Certaines prestations longues nécessitent un créneau adapté</li>
                                <li>• Contactez-nous pour toute demande spécifique</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>