<?php snippet('header') ?>

<main id="page">
  <section class="py-16 bg-off-white">
    <div class="container">
      <?php if ($page->headline()->isNotEmpty()): ?>
        <h2 class="font-heading font-black text-[clamp(2rem,5vw,3.5rem)] leading-[1.1] m-0"><?= $page->headline()->html() ?></h2>
      <?php else: ?>
        <h2 class="font-heading font-black text-[clamp(2rem,5vw,3.5rem)] leading-[1.1] m-0"><?= $page->title()->html() ?></h2>
      <?php endif ?>
    </div>
  </section>

  <?php snippet('layout') ?>

  <section class="py-16 bg-off-white">
    <div class="container max-w-[800px]">
      <?php if ($page->intro()->isNotEmpty()): ?>
        <p class="text-lg mb-8"><?= $page->intro()->html() ?></p>
      <?php endif ?>

      <!-- Contact form placeholder — integrate a form plugin here (e.g. kirby-uniform) -->
      <div class="p-16 border-2 border-dashed border-light-bg rounded-lg text-center text-gray-400">
        <p>Contact form coming soon.</p>
      </div>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
