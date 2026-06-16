<?php snippet('header') ?>

<main id="page">
  <section class="py-16 bg-off-white">
    <div class="container">
      <?php if ($page->headline()->isNotEmpty()): ?>
        <h1 class="font-heading font-black text-[clamp(2rem,5vw,3.5rem)] leading-[1.1] m-0"><?= $page->headline()->html() ?></h1>
      <?php else: ?>
        <h1 class="font-heading font-black text-[clamp(2rem,5vw,3.5rem)] leading-[1.1] m-0"><?= $page->title()->html() ?></h1>
      <?php endif ?>
    </div>
  </section>

  <?php snippet('layout') ?>

  <?php if ($page->downloadButtonText()->isNotEmpty() && $page->downloadUrl()->isNotEmpty()): ?>
    <section class="py-16 bg-off-white">
      <div class="container">
        <a href="<?= $page->downloadUrl()->esc() ?>" class="btn btn-primary btn-lg">
          <?= $page->downloadButtonText()->html() ?>
        </a>
      </div>
    </section>
  <?php endif ?>
</main>

<?php snippet('footer') ?>
