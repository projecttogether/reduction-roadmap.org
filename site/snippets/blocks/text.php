<?php 
/** @var \Kirby\Cms\Block $block */ 

// Setup //
//////////////////

$align = $block->align()->or('left');
$colCount = $block->colCount()->or(1);

// Markup //
////////////////// ?>

<div class="text-fließtext-sm text-(--text-align) columns-(--cols) gap-12"
     style="--text-align: <?= $align ?>;
            --cols      : <?= $colCount ?>;">
  <?= $block->text(); ?>
</div>