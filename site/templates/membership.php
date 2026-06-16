<?php snippet('header') ?>

<main id="page">
  <section class="section section--white section--page-hero">
    <div class="container">
      <?php if ($page->headline()->isNotEmpty()): ?>
        <h1 class="page-hero__title"><?= $page->headline()->html() ?></h1>
      <?php else: ?>
        <h1 class="page-hero__title"><?= $page->title()->html() ?></h1>
      <?php endif ?>
    </div>
  </section>

  <section class="section section--white">
    <div class="container container--narrow">
      <?php if ($page->body()->isNotEmpty()): ?>
        <div class="prose"><?= $page->body() ?></div>
      <?php endif ?>

      <?php if ($page->ctaText()->isNotEmpty() && $page->ctaUrl()->isNotEmpty()): ?>
        <div class="section__cta">
          <a href="<?= $page->ctaUrl()->esc() ?>" class="btn btn--primary btn--large">
            <?= $page->ctaText()->html() ?>
          </a>
        </div>
      <?php endif ?>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
