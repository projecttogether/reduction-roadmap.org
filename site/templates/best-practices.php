<?php snippet('header') ?>

<main id="page">
  <section class="bg-off-white py-16 md:py-24">
    <div class="container">
      <h1 class="font-heading text-5xl font-black leading-tight text-black-green md:text-6xl">
        <?= $page->title()->html() ?>
      </h1>
    </div>
  </section>

  <section class="py-16 md:py-24">
    <div class="container">
      <?= $page->layout()->toLayouts() ?>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
