<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/eeefd7d5ca.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/png" href="./img/favicon.png" />
    <link rel="stylesheet" href="css/style.css">
    <?php if (isset($styleSheetBis) != null) : ?>
        <link rel="stylesheet" href="<?= $styleSheetBis ?>">
    <?php endif; ?>
    <?php if (isset($styleSheetBis2) != null) : ?>
        <link rel="stylesheet" href="<?= $styleSheetBis2 ?>">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <title><?= $pageTitle; ?></title>
</head>

<body>
    <div class="filter"></div>
    <?= $pageContent; ?>

</body>
<script src="js/script.js"></script>
<script src="js/mobile-detect.js"></script>
<?php if (isset($scriptJs) != null) : ?>
    <script type="text/javascript" src="<?= $scriptJs ?>"> </script>
<?php endif; ?>

</html>