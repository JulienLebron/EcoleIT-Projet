<?php
//----------------------------------------------------
function executeRequete($req, $params = [])
{
    global $pdo; // connexion PDO définie dans init.inc.php

    try
    {
        $stmt = $pdo->prepare($req); // prépare la requête
        $stmt->execute($params); // exécute avec les paramètres
    }
    catch(PDOException $e)
    {
        die("🛑 Une erreur est survenue sur la requête SQL.<br>
        Message de l'erreur : " . $e->getMessage() . "<br>
        Code de la requête : " . $req);
    }

    return $stmt; // retourne PDOStatement
}
//----------------------------------------------------
function debug($var, $mode = 1)
{
    echo '<div style="background: orange; padding: 5px;">';

    $trace = debug_backtrace();
    $trace = array_shift($trace);

    echo "Debug demandé dans le fichier : $trace[file] à la ligne $trace[line].";

    if($mode === 1)
    {
        echo '<pre>'; print_r($var); echo '</pre>';
    }
    else
    {
        echo '<pre>'; var_dump($var); echo '</pre>';
    }

    echo '</div>';
}

function internauteEstConnecte()
{
    if(!isset($_SESSION['membre']))
    {
        return false;
    }
    else
    {
        return true;
    }
}

/**
 * Retourne l'icône Font Awesome selon la catégorie
 */
function getCategorieIcon(string $categorie): string
{
    return match ($categorie) {
        'Coupe' => 'fa-scissors',
        'Coloration' => 'fa-droplet',
        'Soins & Coiffage' => 'fa-wind',
        'Prestations spéciales' => 'fa-crown',
        default => 'fa-star',
    };
}

/**
 * Formate la durée en minutes vers un affichage lisible
 * Ex: 45 => 45 min, 120 => 2h, 150 => 2h30
 */
function formatDuree(int $minutes): string
{
    $heures = intdiv($minutes, 60);
    $reste = $minutes % 60;

    if ($heures > 0 && $reste > 0) {
        return $heures . 'h' . str_pad((string)$reste, 2, '0', STR_PAD_LEFT);
    }

    if ($heures > 0) {
        return $heures . 'h';
    }

    return $minutes . ' min';
}

/**
 * Formate le prix
 * 0 => Sur devis
 */
function formatPrix(float $prix): string
{
    if ($prix <= 0) {
        return 'Sur devis';
    }

    return number_format($prix, 0, ',', ' ') . '€';
}

/**
 * Formate une heure SQL 09:00:00 -> 9h00
 */
function formatHeure(string $heure): string
{
    $timestamp = strtotime($heure);
    return date('G\hi', $timestamp);
}

// login admin
define('ADMIN_LOGIN', 'admin');

// mot de passe hashé (généré avec password_hash)
define('ADMIN_PASSWORD_HASH', '$2y$10$FQJxxzxfnTMWWu5zSdgkAe.Za38v6gb6aqpDQXfrpi0d0lOS/CNBm');


function isAdminLoggedIn(): bool
{
    return !empty($_SESSION['admin_logged_in']);
}

function requireAdmin(): void
{
    if (!isAdminLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}