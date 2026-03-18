<?php
session_start();

require_once __DIR__ . '/../config/functions.php';

// protection
requireAdmin();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dashboard Admin</h1>
        <a href="logout.php" class="btn btn-outline-danger">Déconnexion</a>
    </div>

    <div class="card p-4">
        <p>Bienvenue dans l'administration 🎉</p>

        <ul>
            <li><a href="reservations.php">Gérer les réservations</a></li>
            <li><a href="services.php">Gérer les services</a></li>
            <li><a href="disponibilites.php">Gérer les disponibilités</a></li>
        </ul>
    </div>
</div>

</body>
</html>