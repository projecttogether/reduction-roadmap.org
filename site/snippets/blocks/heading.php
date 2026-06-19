<?php

/** @var \Kirby\Cms\Block $b */

// Setup // 
//////////////////

$b            = $block;
$text_eyebrow = $b->text_eyebrow()->or(null);

// Markup // 
////////////////// ?>

<div class="font-heading">

  <?php // Eyebrow // 
        if($text_eyebrow): ?>
          <p class="text-[1.2rem] font-light tracking-wide text-dark-green mb-6">
            <?= $text_eyebrow ?>
          </p>
  <?php endif ?>

  <?php // Hdl. text // ?>
  <?php $level = $b->level()->or('h2')->value() ?>
  <<?= $level ?> class="<?= match($level) {
    'h1' => 'text-6xl',
    'h2' => 'text-5xl',
    'h3' => 'text-4xl',
    'h4' => 'text-3xl',
    'h5' => 'text-2xl',
    default => 'text-xl',
  } ?>">
    <?= $b->with_hyph()->isTrue() ? $b->text()->hyph() : $b->text() ?>
  </<?= $level ?>>
</div>