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

    <a
        href ="#page"
        class="skip-link px-4 py-2 bg-dark-green text-off-white font-bold no-underline rounded-b">Skip to Content</a>

    <header
        class="sticky top-0 z-50 bg-off-white border-b border-transparent"
        id   ="header">
      <div class="container flex items-center justify-between gap-8 py-4">

        <div>
          <a
              href      ="<?= $site->url() ?>"
              class     ="block no-underline leading-none"
              aria-label="<?= $site->title()->html() ?> – Home">
            <?php if ($logo = $site->logo()->toFile()): ?>
                    <img
                        src   ="<?= $logo->url() ?>"
                        alt   ="<?= $site->title()->html() ?>"
                        class ="h-12 w-auto"
                        width ="<?= $logo->width() ?>"
                        height="<?= $logo->height() ?>">
            <?php else: ?>
                    <span class="font-heading font-black text-lg text-dark-green"><?= $site->title()->html() ?></span>
            <?php endif ?>
          </a>
        </div>

        <?php snippet('nav') ?>

    </header>
