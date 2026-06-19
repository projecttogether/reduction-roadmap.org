<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta
        name   ="viewport"
        content="width=device-width, initial-scale=1.0">
    <title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>
    <meta
        name   ="description"
        content="<?= $page->description()->or($site->description())->html() ?>">
    <link
        rel ="icon"
        href="<?= url('assets/images/favicon.ico') ?>">
    <link
        rel ="preconnect"
        href="https://fonts.googleapis.com">
    <link
        rel        ="preconnect"
        href       ="https://fonts.gstatic.com"
        crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Martel:wght@700;900&family=Inter:wght@400;500;700&display=swap"
        rel ="stylesheet">
    <link
        rel ="stylesheet"
        href="<?= url('assets/css/main.css') ?>">
  </head>
  <body class="font-body text-black-green bg-off-white antialiased">
    
    <?php snippet('nav') ?>
