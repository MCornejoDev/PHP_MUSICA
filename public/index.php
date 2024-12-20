<?php
// Carga el autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Inicia la sesión (asegúrate de que initSession() esté definido y disponible)
initSession();

require_once __DIR__ . '/../resources/views/components/input/input.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cornejo Music</title>
    <link rel="shortcut icon" href="<?= BASE_URL ?>/img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/app.min.css">
</head>

<body>
    <div class="grid grid-flow-row auto-rows-max">
        <!-- Cargar el header antes del main -->
        <?php require_once __DIR__ . '/../resources/views/layouts/header.php'; ?>

        <!-- El controlador se carga dentro del main -->
        <main class="mt-10 mb-10">
            <?php require_once __DIR__ . '/../app/autoloading.php'; ?>
        </main>

        <!-- Footer -->
        <?php require_once __DIR__ . '/../resources/views/layouts/footer.php'; ?>
    </div>
</body>

<script type="module" src="<?= BASE_URL ?>/js/app.min.js"></script>

</html>