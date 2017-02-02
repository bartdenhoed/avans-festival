<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= TITLE; ?></title>

    <link href="<?= BASE_URL; ?>css/style.css" rel="stylesheet">
</head>
<body>
    <div class="topbar">
        <div class="title">
            <a href="<?= BASE_URL; ?>">
                <h1><?= TITLE; ?></h1>
            </a>
        </div>
        <div class="menu">
            <a href="<?= URL; ?>home">Overzicht</a>
            <a href="<?= URL; ?>artist/add">Band/Artiest toevoegen</a>
            <a href="<?= URL; ?>stage/add">Podium toevoegen</a>
        </div>
    </div>

    <div class="container">
        <?php if ($this->feedback): ?>
            <div class="content feedback">
                <p><strong>Melding: <?= $this->feedback; ?></strong></p>
            </div>
        <?php endif; ?>
