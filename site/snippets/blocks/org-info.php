<?php
  $theme = $block->theme()->or('dark')->value();
  $sectionClass = match($theme) {
    'dark'  => 'bg-dark-green text-off-white',
    'light' => 'bg-light-bg',
    default => 'bg-off-white',
  };
?>
<section class="py-16 text-center <?= $sectionClass ?>">
  <div class="container">
    <?php if ($block->headline()->isNotEmpty()): ?>
      <h2 class="font-heading font-black text-[clamp(1.5rem,3vw,2.5rem)] mb-8"><?= $block->headline()->html() ?></h2>
    <?php endif ?>
    <?php if ($block->body()->isNotEmpty()): ?>
      <div class="text-[clamp(1rem,2vw,1.125rem)] max-w-[65ch] mx-auto mb-8"><?= $block->body() ?></div>
    <?php endif ?>
    <?php if ($block->buttonText()->isNotEmpty() && $block->buttonUrl()->isNotEmpty()): ?>
      <a href="<?= $block->buttonUrl()->esc() ?>" class="btn btn-primary btn-lg">
        <?= $block->buttonText()->html() ?>
      </a>
    <?php endif ?>
  </div>
</section>
