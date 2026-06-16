<?php snippet('header') ?>

<main id="page">
  <section class="py-16 bg-off-white">
    <div class="container">
      <?php if ($page->headline()->isNotEmpty()): ?>
        <h1 class="font-heading font-black text-[clamp(2rem,5vw,3.5rem)] leading-[1.1] m-0"><?= $page->headline()->html() ?></h1>
      <?php else: ?>
        <h1 class="font-heading font-black text-[clamp(2rem,5vw,3.5rem)] leading-[1.1] m-0"><?= $page->title()->html() ?></h1>
      <?php endif ?>

      <?php if ($heroImage = $page->heroImage()->toFile()): ?>
        <div class="mt-8">
          <img
            src="<?= $heroImage->url() ?>"
            alt="<?= $heroImage->alt()->or($page->title())->html() ?>"
            class="w-full h-auto"
            loading="lazy"
          >
        </div>
      <?php endif ?>
    </div>
  </section>

  <?php snippet('layout') ?>
</main>

<?php snippet('footer') ?>
