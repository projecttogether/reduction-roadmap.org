<?php 
/** @var \Kirby\Cms\Block $block */ 

// Setup //
//////////////////

$align = $block->align()->or('left');
$colCount = $block->colCount()->or(1);
$borderClasses = [
  'borderTop' => ['sm' => 'border-t', 'md' => 'border-t-2', 'lg' => 'border-t-4'],
  'borderRight' => ['sm' => 'border-r', 'md' => 'border-r-2', 'lg' => 'border-r-4'],
  'borderBottom' => ['sm' => 'border-b', 'md' => 'border-b-2', 'lg' => 'border-b-4'],
  'borderLeft' => ['sm' => 'border-l', 'md' => 'border-l-2', 'lg' => 'border-l-4'],
];
$borderClassList = [];
foreach ($borderClasses as $field => $classes) {
  $borderClassList[] = $classes[$block->$field()->value()] ?? '';
}
$borderClass = implode(' ', array_filter($borderClassList));

// Markup //
////////////////// ?>

<div class="text-fließtext-sm text-(--text-align) columns-(--cols) gap-12 <?= esc($borderClass) ?>"
     style="--text-align: <?= $align ?>;
            --cols      : <?= $colCount ?>;">
  <?= $block->text()->kt()->hyph(); ?>
</div>