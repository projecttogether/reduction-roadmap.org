<?php snippet('header') ?>

<main id="page">
  <section class="pt-16 bg-off-white">
    <div class="container">
      <h1 class="font-heading font-black text-[clamp(2rem,5vw,3.5rem)] leading-[1.1] m-0"><?= $page->title()->html() ?></h1>
    </div>
  </section>

  <?php snippet('layout') ?>
</main>

<?php snippet('footer') ?>
