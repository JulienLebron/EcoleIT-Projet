<?php
require_once './config/database.php';
require_once __DIR__ . '/includes/data/horaires.php';

$sql = "SELECT id, nom, duree_minutes, prix_euros FROM services ORDER BY categorie, nom";
$stmt = $pdo->query($sql);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prendre rendez-vous - Studio21</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./public/css/style.css">

    <style>
        body {
            background-color: #f9fafb;
        }

        .reservation-card {
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.06);
            border: 0;
        }

        .creneau-btn {
            border: 1px solid #f43f5e;
            color: #f43f5e;
            background: white;
            border-radius: 999px;
            padding: 10px 18px;
            transition: 0.2s ease;
        }

        .creneau-btn:hover,
        .creneau-btn.active {
            background-color: #f43f5e;
            color: white;
        }

        .hidden-block {
            display: none;
        }
    </style>
</head>
<body>
<?php
$currentPage = 'reservation';
require_once './includes/header.php';
?>

<div class="container py-5 mt-5">
    <div class="text-center mb-5">
        <div class="d-inline-block px-4 py-2 rounded-pill mb-3" style="background-color:#ffe4e6; color:#e11d48;">
            Réservation
        </div>
        <h1 class="display-5 fw-bold">Prendre rendez-vous</h1>
        <p class="text-secondary fs-5">Choisissez votre prestation, une date, puis un créneau disponible.</p>
    </div>

    <div class="card reservation-card">
        <div class="card-body p-4 p-md-5">

            <?php if (!empty($_GET['success'])): ?>
                <div class="alert alert-success mb-4">
                    Votre réservation a bien été enregistrée.
                </div>
            <?php endif; ?>

            <?php if (!empty($_GET['error'])): ?>
                <div class="alert alert-danger mb-4">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form action="enregistrer_reservation.php" method="post" id="reservationForm">
                <div class="row g-4">

                    <div class="col-md-6">
                        <label for="service_id" class="form-label fw-semibold">1. Choisissez un service *</label>
                        <select name="service_id" id="service_id" class="form-select form-select-lg" required>
                            <option value="">-- Sélectionnez --</option>
                            <?php foreach ($services as $service): ?>
                                <option value="<?= (int)$service['id'] ?>">
                                    <?= htmlspecialchars($service['nom']) ?> —
                                    <?= (int)$service['duree_minutes'] ?> min —
                                    <?php if ((float)$service['prix_euros'] > 0): ?>
                                        <?= number_format((float)$service['prix_euros'], 0, ',', ' ') ?>€
                                    <?php else: ?>
                                        Sur devis
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="date_rdv" class="form-label fw-semibold">2. Choisissez une date *</label>
                        <input type="date" name="date_rdv" id="date_rdv" class="form-control form-control-lg" required min="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <hr class="my-5">

                <div id="creneauxBlock">
                    <h3 class="h4 mb-3">3. Créneaux disponibles</h3>
                    <p class="text-secondary" id="creneauxMessage">
                        Sélectionnez un service et une date pour afficher les disponibilités.
                    </p>
                    <div id="creneauxContainer" class="d-flex flex-wrap gap-2"></div>
                </div>

                <input type="hidden" name="heure_rdv" id="heure_rdv">

                <div id="infosClientBlock" class="hidden-block mt-5">
                    <hr class="my-5">

                    <h3 class="h4 mb-4">4. Vos informations</h3>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="nom_client" class="form-label fw-semibold">Nom complet *</label>
                            <input type="text" name="nom_client" id="nom_client" class="form-control" required maxlength="100">
                        </div>

                        <div class="col-md-6">
                            <label for="email_client" class="form-label fw-semibold">Email *</label>
                            <input type="email" name="email_client" id="email_client" class="form-control" required maxlength="150">
                        </div>

                        <div class="col-md-6">
                            <label for="telephone" class="form-label fw-semibold">Téléphone *</label>
                            <input type="text" name="telephone" id="telephone" class="form-control" required maxlength="20">
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="submit" class="btn btn-lg text-white px-5" style="background-color:#f43f5e;">
                            Confirmer la réservation
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?php require_once './includes/footer.php' ?>

<script>
const serviceSelect = document.getElementById('service_id');
const dateInput = document.getElementById('date_rdv');
const creneauxContainer = document.getElementById('creneauxContainer');
const creneauxMessage = document.getElementById('creneauxMessage');
const heureInput = document.getElementById('heure_rdv');
const infosClientBlock = document.getElementById('infosClientBlock');

async function chargerCreneaux() {
    const serviceId = serviceSelect.value;
    const dateRdv = dateInput.value;

    creneauxContainer.innerHTML = '';
    heureInput.value = '';
    infosClientBlock.classList.add('hidden-block');

    if (!serviceId || !dateRdv) {
        creneauxMessage.textContent = 'Sélectionnez un service et une date pour afficher les disponibilités.';
        return;
    }

    creneauxMessage.textContent = 'Chargement des créneaux...';

    try {
        const response = await fetch(`ajax/get_creneaux.php?service_id=${encodeURIComponent(serviceId)}&date=${encodeURIComponent(dateRdv)}`);
        const data = await response.json();

        if (!data.success) {
            creneauxMessage.textContent = data.message || 'Impossible de charger les créneaux.';
            return;
        }

        if (!data.creneaux.length) {
            creneauxMessage.textContent = 'Aucun créneau disponible pour cette date.';
            return;
        }

        creneauxMessage.textContent = 'Choisissez une heure :';

        data.creneaux.forEach(creneau => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'creneau-btn';
            button.textContent = creneau;
            button.dataset.heure = creneau;

            button.addEventListener('click', () => {
                document.querySelectorAll('.creneau-btn').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                heureInput.value = creneau;
                infosClientBlock.classList.remove('hidden-block');
            });

            creneauxContainer.appendChild(button);
        });
    } catch (error) {
        creneauxMessage.textContent = 'Erreur lors du chargement des créneaux.';
    }
}

serviceSelect.addEventListener('change', chargerCreneaux);
dateInput.addEventListener('change', chargerCreneaux);
</script>

</body>
</html>