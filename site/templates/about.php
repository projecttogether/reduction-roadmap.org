<?php snippet('header') ?>

<main id="page">
  <section class="section section--white section--page-hero">
    <div class="container">
      <h1 class="page-hero__title"><?= $page->title()->html() ?></h1>
    </div>
  </section>

  <?php snippet('layout') ?>
</main>

<?php snippet('footer') ?>
