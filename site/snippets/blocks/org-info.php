<?php
  $theme = $block->theme()->or('dark')->value();
  $themeClass = 'section--' . $theme;
?>
<section class="section section--org-info <?= $themeClass ?>">
  <div class="container">
    <?php if ($block->headline()->isNotEmpty()): ?>
      <h2 class="org-info__headline"><?= $block->headline()->html() ?></h2>
    <?php endif ?>
    <?php if ($block->body()->isNotEmpty()): ?>
      <div class="org-info__body"><?= $block->body() ?></div>
    <?php endif ?>
    <?php if ($block->buttonText()->isNotEmpty() && $block->buttonUrl()->isNotEmpty()): ?>
      <a href="<?= $block->buttonUrl()->esc() ?>" class="btn btn--primary btn--large">
        <?= $block->buttonText()->html() ?>
      </a>
    <?php endif ?>
  </div>
</section>
