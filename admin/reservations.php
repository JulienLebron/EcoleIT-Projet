<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

requireAdmin();

$dateFiltre = $_GET['date'] ?? date('Y-m-d');

$dateObj = DateTime::createFromFormat('Y-m-d', $dateFiltre);
if (!$dateObj || $dateObj->format('Y-m-d') !== $dateFiltre) {
    $dateFiltre = date('Y-m-d');
}

$sql = "
    SELECT
        r.id,
        r.date_rdv,
        r.heure_rdv,
        r.nom_client,
        r.email_client,
        r.telephone,
        r.statut,
        s.nom AS service_nom
    FROM reservations r
    INNER JOIN services s ON s.id = r.service_id
    WHERE r.date_rdv = :date_rdv
    ORDER BY r.heure_rdv ASC
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['date_rdv' => $dateFiltre]);
$reservations = $stmt->fetchAll();

$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';

function badgeStatutClass(string $statut): string
{
    return match ($statut) {
        'en_attente' => 'bg-warning text-dark',
        'confirme' => 'bg-success',
        'annule' => 'bg-danger',
        default => 'bg-secondary',
    };
}

function formatHeureAdmin(string $heure): string
{
    return substr($heure, 0, 5);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Réservations</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color:#f9fafb;">

<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="mb-1">Gestion des réservations</h1>
            <p class="text-secondary mb-0">Consultez, confirmez ou annulez les rendez-vous.</p>
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
        <div class="card-body">
            <form method="get" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="date" class="form-label fw-semibold">Filtrer par date</label>
                    <input
                        type="date"
                        id="date"
                        name="date"
                        class="form-control"
                        value="<?= e($dateFiltre) ?>"
                    >
                </div>

                <div class="col-md-auto">
                    <button type="submit" class="btn btn-danger">Afficher</button>
                </div>

                <div class="col-md-auto">
                    <a href="reservations.php" class="btn btn-outline-secondary">Aujourd’hui</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="h4 mb-4">Réservations du <?= e(date('d/m/Y', strtotime($dateFiltre))) ?></h2>

            <?php if (empty($reservations)): ?>
                <div class="alert alert-info mb-0">
                    Aucune réservation pour cette date.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Heure</th>
                                <th>Service</th>
                                <th>Client</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $reservation): ?>
                                <tr>
                                    <td class="fw-semibold">
                                        <?= e(formatHeureAdmin($reservation['heure_rdv'])) ?>
                                    </td>
                                    <td>
                                        <?= e($reservation['service_nom']) ?>
                                    </td>
                                    <td>
                                        <?= e($reservation['nom_client']) ?>
                                    </td>
                                    <td>
                                        <?= e($reservation['email_client']) ?>
                                    </td>
                                    <td>
                                        <?= e($reservation['telephone']) ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= badgeStatutClass($reservation['statut']) ?>">
                                            <?= e($reservation['statut']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2 flex-wrap">
                                            <?php if ($reservation['statut'] !== 'confirme'): ?>
                                                <form method="post" action="reservation_statut.php" class="d-inline">
                                                    <input type="hidden" name="id" value="<?= (int)$reservation['id'] ?>">
                                                    <input type="hidden" name="statut" value="confirme">
                                                    <input type="hidden" name="date" value="<?= e($dateFiltre) ?>">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        Valider
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <?php if ($reservation['statut'] !== 'annule'): ?>
                                                <form method="post" action="reservation_statut.php" class="d-inline">
                                                    <input type="hidden" name="id" value="<?= (int)$reservation['id'] ?>">
                                                    <input type="hidden" name="statut" value="annule">
                                                    <input type="hidden" name="date" value="<?= e($dateFiltre) ?>">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Confirmer l’annulation de cette réservation ?');"
                                                    >
                                                        Annuler
                                                    </button>
                                                </form>
                                            <?php endif; ?>
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