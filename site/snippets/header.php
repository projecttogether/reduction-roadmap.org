<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>
  <meta name="description" content="<?= $page->description()->or($site->description())->html() ?>">
  <link rel="icon" href="<?= url('assets/images/favicon.ico') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Martel:wght@700;900&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= url('assets/css/main.css') ?>">
</head>
<body>

<a href="#page" class="skip-link">Skip to Content</a>

<header class="site-header" id="header">
  <div class="site-header__inner">

    <div class="site-header__logo">
      <a href="<?= $site->url() ?>" aria-label="<?= $site->title()->html() ?> – Home">
        <?php if ($logo = $site->logo()->toFile()): ?>
          <img src="<?= $logo->url() ?>" alt="<?= $site->title()->html() ?>" width="<?= $logo->width() ?>" height="<?= $logo->height() ?>">
        <?php else: ?>
          <span class="site-header__logo-text"><?= $site->title()->html() ?></span>
        <?php endif ?>
      </a>
    </div>

    <nav class="site-nav" aria-label="Main navigation">
      <ul class="site-nav__list" role="list">
        <?php foreach ($site->children()->listed() as $item): ?>
          <li class="site-nav__item">
            <a
              href="<?= $item->url() ?>"
              class="site-nav__link<?= $item->isActive() ? ' site-nav__link--active' : '' ?>"
              <?= $item->isActive() ? 'aria-current="page"' : '' ?>
            ><?= $item->title()->html() ?></a>
          </li>
        <?php endforeach ?>
      </ul>
    </nav>

    <button class="site-header__nav-toggle" aria-controls="mobile-nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="site-header__hamburger"></span>
    </button>

  </div>

  <nav class="site-nav-mobile" id="mobile-nav" aria-label="Mobile navigation" hidden>
    <ul class="site-nav-mobile__list" role="list">
      <?php foreach ($site->children()->listed() as $item): ?>
        <li class="site-nav-mobile__item">
          <a
            href="<?= $item->url() ?>"
            class="site-nav-mobile__link<?= $item->isActive() ? ' site-nav-mobile__link--active' : '' ?>"
          ><?= $item->title()->html() ?></a>
        </li>
      <?php endforeach ?>
    </ul>
  </nav>

</header>

<script>
  (function () {
    const toggle = document.querySelector('.site-header__nav-toggle');
    const nav = document.getElementById('mobile-nav');
    if (!toggle || !nav) return;
    toggle.addEventListener('click', function () {
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!expanded));
      nav.hidden = expanded;
      document.body.classList.toggle('nav-open', !expanded);
    });
  })();
</script>
