<?php

/** @var \Kirby\Cms\Block $b */

// Setup // 
//////////////////

$b = $block;
$text_eyebrow = $b->text_eyebrow()->or(null);

// Markup // 
////////////////// ?>

<div class="text-6xl font-heading">

  <?php // Eyebrow // 
        if($text_eyebrow): ?>
          <p class="text-[1.2rem] font-light tracking-wide text-dark-green mb-6">
            <?= $text_eyebrow ?>
          </p>
  <?php endif ?>

  <?php // Hdl. text // ?>
  <<?= $level = $b->level()->or('h2') ?>>
    <?= $b->with_hyph()->isTrue() ? $b->text()->hyph() : $b->text() ?>
  </<?= $level ?>>
</div>