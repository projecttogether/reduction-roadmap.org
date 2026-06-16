<?php snippet('header') ?>

<main id="page">
  <section class="section section--white section--page-hero">
    <div class="container">
      <?php if ($page->headline()->isNotEmpty()): ?>
        <h1 class="page-hero__title"><?= $page->headline()->html() ?></h1>
      <?php else: ?>
        <h1 class="page-hero__title"><?= $page->title()->html() ?></h1>
      <?php endif ?>

      <?php if ($heroImage = $page->heroImage()->toFile()): ?>
        <div class="roadmap__hero-image">
          <img
            src="<?= $heroImage->url() ?>"
            alt="<?= $heroImage->alt()->or($page->title())->html() ?>"
            loading="lazy"
          >
        </div>
      <?php endif ?>
    </div>
  </section>

  <section class="section section--white">
    <div class="container container--narrow">
      <?php if ($page->body()->isNotEmpty()): ?>
        <div class="prose"><?= $page->body() ?></div>
      <?php endif ?>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
