<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

requireAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$service = [
    'id' => 0,
    'categorie' => '',
    'description_categorie' => '',
    'nom' => '',
    'description' => '',
    'duree_minutes' => '',
    'prix_euros' => '',
];

if ($isEdit) {
    $stmt = $pdo->prepare("
        SELECT
            id,
            categorie,
            description_categorie,
            nom,
            description,
            duree_minutes,
            prix_euros
        FROM services
        WHERE id = ?
    ");
    $stmt->execute([$id]);
    $serviceDb = $stmt->fetch();

    if (!$serviceDb) {
        header('Location: services.php?error=' . urlencode('Service introuvable.'));
        exit;
    }

    $service = $serviceDb;
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdit ? 'Modifier' : 'Ajouter' ?> un service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body style="background-color:#f9fafb;">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1"><?= $isEdit ? 'Modifier' : 'Ajouter' ?> un service</h1>
            <p class="text-secondary mb-0">Renseignez les informations du service.</p>
        </div>
        <a href="services.php" class="btn btn-outline-secondary">Retour</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="service_save.php" class="row g-4">

                <input type="hidden" name="id" value="<?= (int)$service['id'] ?>">

                <div class="col-md-6">
                    <label for="categorie" class="form-label fw-semibold">Catégorie *</label>
                    <input
                        type="text"
                        id="categorie"
                        name="categorie"
                        class="form-control"
                        required
                        value="<?= e((string)$service['categorie']) ?>"
                    >
                </div>

                <div class="col-md-6">
                    <label for="nom" class="form-label fw-semibold">Nom du service *</label>
                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        class="form-control"
                        required
                        value="<?= e((string)$service['nom']) ?>"
                    >
                </div>

                <div class="col-12">
                    <label for="description_categorie" class="form-label fw-semibold">Description de la catégorie *</label>
                    <textarea
                        id="description_categorie"
                        name="description_categorie"
                        class="form-control"
                        rows="2"
                        required
                    ><?= e((string)$service['description_categorie']) ?></textarea>
                </div>

                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description du service *</label>
                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        rows="3"
                        required
                    ><?= e((string)$service['description']) ?></textarea>
                </div>

                <div class="col-md-6">
                    <label for="duree_minutes" class="form-label fw-semibold">Durée (minutes) *</label>
                    <input
                        type="number"
                        id="duree_minutes"
                        name="duree_minutes"
                        class="form-control"
                        min="1"
                        required
                        value="<?= e((string)$service['duree_minutes']) ?>"
                    >
                </div>

                <div class="col-md-6">
                    <label for="prix_euros" class="form-label fw-semibold">Prix (€)</label>
                    <input
                        type="number"
                        id="prix_euros"
                        name="prix_euros"
                        class="form-control"
                        min="0"
                        step="0.01"
                        value="<?= e((string)$service['prix_euros']) ?>"
                    >
                    <div class="form-text">Mettez 0 pour “Sur devis”.</div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-danger">
                        <?= $isEdit ? 'Enregistrer les modifications' : 'Ajouter le service' ?>
                    </button>
                    <a href="services.php" class="btn btn-outline-secondary ms-2">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>