<section class="py-32 bg-off-white text-center">
  <div class="container">
    <?php if ($block->headline()->isNotEmpty()): ?>
      <h1 class="font-heading font-black text-[clamp(2rem,5vw,4rem)] leading-[1.1] mb-8 max-w-[18ch] mx-auto"><?= $block->headline()->html() ?></h1>
    <?php endif ?>
    <?php if ($block->subheadline()->isNotEmpty()): ?>
      <p class="text-[clamp(1rem,2vw,1.25rem)] max-w-[55ch] mx-auto mb-8"><?= $block->subheadline()->kt() ?></p>
    <?php endif ?>
    <?php if ($block->buttonText()->isNotEmpty() && $block->buttonUrl()->isNotEmpty()): ?>
      <a href="<?= $block->buttonUrl()->esc() ?>" class="btn btn-primary btn-lg">
        <?= $block->buttonText()->html() ?>
      </a>
    <?php endif ?>
  </div>
</section>
