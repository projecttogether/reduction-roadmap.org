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

  <?php snippet('layout') ?>

  <?php if ($page->downloadButtonText()->isNotEmpty() && $page->downloadUrl()->isNotEmpty()): ?>
    <section class="section section--white">
      <div class="container">
        <a href="<?= $page->downloadUrl()->esc() ?>" class="btn btn--primary btn--large">
          <?= $page->downloadButtonText()->html() ?>
        </a>
      </div>
    </section>
  <?php endif ?>
</main>

<?php snippet('footer') ?>
