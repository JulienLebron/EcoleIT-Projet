<?php
session_start();
require_once __DIR__ . '/../config/functions.php';

if (isAdminLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body style="background:#f9fafb;">


<div class="container py-5 mt-5">
    <div class="mx-auto mt-5" style="max-width:400px;">
        <div class="card shadow p-4">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-4">

                <div class="d-flex align-items-center justify-content-center text-white"
                    style="width: 2.5rem; height: 2.5rem; background-color: #f43f5e; border-radius: 0.75rem;">
                    <i class="fa-solid fa-scissors"></i>
                </div>

                <h2 class="mb-0">Admin Studio21</h2>

            </div>

            <?php if (!empty($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?= e($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="login_traitement.php">
                <div class="mb-3">
                    <label class="form-label">Identifiant</label>
                    <input type="text" name="login" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-danger w-100">Se connecter</button>
            </form>
        </div>
    </div>
</div>


</body>
</html>