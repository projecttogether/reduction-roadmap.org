<?php

/** @var \Kirby\Cms\Block $b */

// Setup // 
//////////////////

$b            = $block;
$text_eyebrow = $b->text_eyebrow()->or(null);
$borderClasses = [
  'borderTop' => ['sm' => 'border-t', 'md' => 'border-t-2', 'lg' => 'border-t-4'],
  'borderRight' => ['sm' => 'border-r', 'md' => 'border-r-2', 'lg' => 'border-r-4'],
  'borderBottom' => ['sm' => 'border-b', 'md' => 'border-b-2', 'lg' => 'border-b-4'],
  'borderLeft' => ['sm' => 'border-l', 'md' => 'border-l-2', 'lg' => 'border-l-4'],
];
$borderClassList = [];
foreach ($borderClasses as $field => $classes)
  $borderClassList[] = $classes[$b->$field()->value()] ?? '';
$borderClass = implode(' ', array_filter($borderClassList));

// Markup // 
////////////////// ?>

<div class="font-heading <?= esc($borderClass) ?>">

    <?php // Eyebrow //
      if ($text_eyebrow->isNotEmpty()): ?>
          <div class="mb-6 px-2 pt-1 pb-0.75 inline-flex bg-dark-green text-off-white">
            <p class="text-[1rem] font-light tracking-wide">
              <?= $text_eyebrow ?>
            </p>
          </div>
  <?php endif ?>

  <?php // Hdl. text // ?>
  <?php $level = $b->level()->or('h2')->value() ?>
  <<?= $level ?> class="font-black
  <?= match($level) 
  {
    'h1' => 'text-3xl md:text-4xl tracking-[-0.0125em]',
    'h2' => 'text-3xl md:text-4xl tracking-[-0.0125em]',
    'h3' => 'text-3xl md:text-4xl tracking-[-0.0125em]',
    'h4' => 'text-3xl tracking-[-0.0125em]',
    'h5' => 'text-2xl tracking-[-0.0125em]',
    default => 'text-xl tracking-[-0.0125em]',
  } ?>">
    <?= $b->with_hyph()->isTrue() ? $b->text()->hyph() : $b->text() ?>
  </<?= $level ?>>
</div>