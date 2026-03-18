<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

requireAdmin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;

$disponibilite = [
    'id' => 0,
    'jour_semaine' => '',
    'heure_debut' => '',
    'heure_fin' => '',
    'actif' => 1,
];

if ($isEdit) {
    $stmt = $pdo->prepare("
        SELECT
            id,
            jour_semaine,
            heure_debut,
            heure_fin,
            actif
        FROM disponibilites
        WHERE id = ?
    ");
    $stmt->execute([$id]);
    $dispoDb = $stmt->fetch();

    if (!$dispoDb) {
        header('Location: disponibilites.php?error=' . urlencode('Disponibilité introuvable.'));
        exit;
    }

    $disponibilite = $dispoDb;
}

$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $isEdit ? 'Modifier' : 'Ajouter' ?> une disponibilité</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body style="background-color:#f9fafb;">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1"><?= $isEdit ? 'Modifier' : 'Ajouter' ?> une disponibilité</h1>
            <p class="text-secondary mb-0">Renseignez une plage horaire d’ouverture.</p>
        </div>
        <a href="disponibilites.php" class="btn btn-outline-secondary">Retour</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form method="post" action="disponibilite_save.php" class="row g-4">

                <input type="hidden" name="id" value="<?= (int)$disponibilite['id'] ?>">

                <div class="col-md-6">
                    <label for="jour_semaine" class="form-label fw-semibold">Jour de la semaine *</label>
                    <select id="jour_semaine" name="jour_semaine" class="form-select" required>
                        <option value="">-- Sélectionnez --</option>
                        <option value="1" <?= (string)$disponibilite['jour_semaine'] === '1' ? 'selected' : '' ?>>Lundi</option>
                        <option value="2" <?= (string)$disponibilite['jour_semaine'] === '2' ? 'selected' : '' ?>>Mardi</option>
                        <option value="3" <?= (string)$disponibilite['jour_semaine'] === '3' ? 'selected' : '' ?>>Mercredi</option>
                        <option value="4" <?= (string)$disponibilite['jour_semaine'] === '4' ? 'selected' : '' ?>>Jeudi</option>
                        <option value="5" <?= (string)$disponibilite['jour_semaine'] === '5' ? 'selected' : '' ?>>Vendredi</option>
                        <option value="6" <?= (string)$disponibilite['jour_semaine'] === '6' ? 'selected' : '' ?>>Samedi</option>
                        <option value="7" <?= (string)$disponibilite['jour_semaine'] === '7' ? 'selected' : '' ?>>Dimanche</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="heure_debut" class="form-label fw-semibold">Heure début *</label>
                    <input
                        type="time"
                        id="heure_debut"
                        name="heure_debut"
                        class="form-control"
                        required
                        value="<?= e(substr((string)$disponibilite['heure_debut'], 0, 5)) ?>"
                    >
                </div>

                <div class="col-md-3">
                    <label for="heure_fin" class="form-label fw-semibold">Heure fin *</label>
                    <input
                        type="time"
                        id="heure_fin"
                        name="heure_fin"
                        class="form-control"
                        required
                        value="<?= e(substr((string)$disponibilite['heure_fin'], 0, 5)) ?>"
                    >
                </div>

                <div class="col-md-4">
                    <label for="actif" class="form-label fw-semibold">Actif *</label>
                    <select id="actif" name="actif" class="form-select" required>
                        <option value="1" <?= (string)$disponibilite['actif'] === '1' ? 'selected' : '' ?>>Oui</option>
                        <option value="0" <?= (string)$disponibilite['actif'] === '0' ? 'selected' : '' ?>>Non</option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-danger">
                        <?= $isEdit ? 'Enregistrer les modifications' : 'Ajouter la disponibilité' ?>
                    </button>
                    <a href="disponibilites.php" class="btn btn-outline-secondary ms-2">Annuler</a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>