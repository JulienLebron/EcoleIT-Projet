<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

requireAdmin();

$sql = "
    SELECT
        id,
        jour_semaine,
        heure_debut,
        heure_fin,
        actif
    FROM disponibilites
    ORDER BY jour_semaine ASC, heure_debut ASC
";

$stmt = $pdo->query($sql);
$disponibilites = $stmt->fetchAll();

$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';

function getJourLabel(int $jour): string
{
    return match ($jour) {
        1 => 'Lundi',
        2 => 'Mardi',
        3 => 'Mercredi',
        4 => 'Jeudi',
        5 => 'Vendredi',
        6 => 'Samedi',
        7 => 'Dimanche',
        default => 'Inconnu',
    };
}

function formatHeureDispo(string $heure): string
{
    return substr($heure, 0, 5);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Disponibilités</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body style="background-color:#f9fafb;">

<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="mb-1">Gestion des disponibilités</h1>
            <p class="text-secondary mb-0">Ajoutez, modifiez ou supprimez les créneaux d’ouverture du salon.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="dashboard.php" class="btn btn-outline-secondary">Dashboard</a>
            <a href="logout.php" class="btn btn-outline-danger">Déconnexion</a>
        </div>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-success">
            <?= e($message) ?>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-1">Plages horaires</h2>
                <p class="text-secondary mb-0">Nombre total : <?= count($disponibilites) ?></p>
            </div>
            <div>
                <a href="disponibilite_form.php" class="btn btn-danger">
                    Ajouter une disponibilité
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <?php if (empty($disponibilites)): ?>
                <div class="alert alert-info mb-0">
                    Aucune disponibilité enregistrée.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Jour</th>
                                <th>Heure début</th>
                                <th>Heure fin</th>
                                <th>Actif</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($disponibilites as $dispo): ?>
                                <tr>
                                    <td><?= e(getJourLabel((int)$dispo['jour_semaine'])) ?></td>
                                    <td><?= e(formatHeureDispo($dispo['heure_debut'])) ?></td>
                                    <td><?= e(formatHeureDispo($dispo['heure_fin'])) ?></td>
                                    <td>
                                        <?php if ((int)$dispo['actif'] === 1): ?>
                                            <span class="badge bg-success">Oui</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Non</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="disponibilite_form.php?id=<?= (int)$dispo['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                Modifier
                                            </a>
                                            <a
                                                href="disponibilite_delete.php?id=<?= (int)$dispo['id'] ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Confirmer la suppression de cette disponibilité ?');"
                                            >
                                                Supprimer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>