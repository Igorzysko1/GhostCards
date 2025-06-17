<?php require_once 'db_connection.php'; ?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GhostCards</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <header>
        <section class="header-data">
            <!-- logo -->
            <span class="app-name">GhostCards</span>
        </section>
        <nav class="header-nav">
            <a href="index.php" class="header-button">Strona Główna</a>
            <a href="zestawy.php?action=add" class="header-button">Dodaj zestaw</a>
        </nav>
    </header>
    <main>