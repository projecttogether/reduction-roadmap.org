<?php snippet('header') ?>

<main id="page">
  <section class="section section--white section--page-hero">
    <div class="container">
      <h1 class="page-hero__title"><?= $page->title()->html() ?></h1>
    </div>
  </section>

  <section class="section section--white">
    <div class="container container--narrow">
      <?php if ($page->body()->isNotEmpty()): ?>
        <div class="prose prose--legal"><?= $page->body() ?></div>
      <?php endif ?>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
