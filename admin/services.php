<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

requireAdmin();

$sql = "
    SELECT
        id,
        categorie,
        description_categorie,
        nom,
        description,
        duree_minutes,
        prix_euros
    FROM services
    ORDER BY categorie ASC, nom ASC
";

$stmt = $pdo->query($sql);
$services = $stmt->fetchAll();

$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body style="background-color:#f9fafb;">

<div class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="mb-1">Gestion des services</h1>
            <p class="text-secondary mb-0">Ajoutez, modifiez ou supprimez les prestations proposées.</p>
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
                <h2 class="h4 mb-1">Liste des services</h2>
                <p class="text-secondary mb-0">Nombre total : <?= count($services) ?></p>
            </div>
            <div>
                <a href="service_form.php" class="btn btn-danger">
                    <i class="fa-solid fa-plus me-2"></i>Ajouter un service
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <?php if (empty($services)): ?>
                <div class="alert alert-info mb-0">
                    Aucun service enregistré.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Catégorie</th>
                                <th>Nom</th>
                                <th>Durée</th>
                                <th>Prix</th>
                                <th>Description</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?= e($service['categorie']) ?></td>
                                    <td class="fw-semibold"><?= e($service['nom']) ?></td>
                                    <td><?= (int)$service['duree_minutes'] ?> min</td>
                                    <td>
                                        <?php if ((float)$service['prix_euros'] > 0): ?>
                                            <?= number_format((float)$service['prix_euros'], 2, ',', ' ') ?> €
                                        <?php else: ?>
                                            Sur devis
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-secondary">
                                        <?= e($service['description']) ?>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="service_form.php?id=<?= (int)$service['id'] ?>" class="btn btn-sm btn-outline-primary">
                                                Modifier
                                            </a>
                                            <a
                                                href="service_delete.php?id=<?= (int)$service['id'] ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Confirmer la suppression de ce service ?');"
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