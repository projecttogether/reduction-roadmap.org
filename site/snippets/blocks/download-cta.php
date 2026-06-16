<section class="py-16 bg-off-white text-center">
  <div class="container">
    <?php if ($block->bodyText()->isNotEmpty()): ?>
      <div class="text-[clamp(1rem,2vw,1.125rem)] max-w-[60ch] mx-auto mb-8"><?= $block->bodyText()->kt() ?></div>
    <?php endif ?>
    <?php if ($block->headline()->isNotEmpty()): ?>
      <h2 class="font-heading font-black text-[clamp(1.5rem,3vw,2.25rem)] mb-8"><?= $block->headline()->html() ?></h2>
    <?php endif ?>
    <?php if ($block->buttonText()->isNotEmpty() && $block->buttonUrl()->isNotEmpty()): ?>
      <a href="<?= $block->buttonUrl()->esc() ?>" class="btn btn-primary btn-lg">
        <?= $block->buttonText()->html() ?>
      </a>
    <?php endif ?>
  </div>
</section>
