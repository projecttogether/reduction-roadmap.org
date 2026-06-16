<section class="section section--white section--hero">
  <div class="container">
    <?php if ($block->headline()->isNotEmpty()): ?>
      <h1 class="hero__title"><?= $block->headline()->html() ?></h1>
    <?php endif ?>
    <?php if ($block->subheadline()->isNotEmpty()): ?>
      <p class="hero__subtitle"><?= $block->subheadline()->kt() ?></p>
    <?php endif ?>
    <?php if ($block->buttonText()->isNotEmpty() && $block->buttonUrl()->isNotEmpty()): ?>
      <a href="<?= $block->buttonUrl()->esc() ?>" class="btn btn--primary btn--large">
        <?= $block->buttonText()->html() ?>
      </a>
    <?php endif ?>
  </div>
</section>
