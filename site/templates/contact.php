<?php snippet('header') ?>

<main id="page">
  <section class="section section--white section--page-hero">
    <div class="container">
      <?php if ($page->headline()->isNotEmpty()): ?>
        <h2 class="page-hero__title"><?= $page->headline()->html() ?></h2>
      <?php else: ?>
        <h2 class="page-hero__title"><?= $page->title()->html() ?></h2>
      <?php endif ?>
    </div>
  </section>

  <section class="section section--white">
    <div class="container container--narrow">
      <?php if ($page->intro()->isNotEmpty()): ?>
        <p class="contact__intro"><?= $page->intro()->html() ?></p>
      <?php endif ?>

      <!-- Contact form placeholder — integrate a form plugin here (e.g. kirby-uniform) -->
      <div class="contact-form-placeholder">
        <p>Contact form coming soon.</p>
      </div>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
