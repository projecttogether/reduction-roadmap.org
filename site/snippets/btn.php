<?php
// Doc. //
//////////////////

// $url      – href for the link
// $label    – visible link text (pre-escaped HTML)
// $isActive – bool, whether this item is the current page
// $mobile   – bool, use mobile styles (default false = desktop)

// Setup //
//////////////////

$is_link   ??= true;
$url       = $is_link ? ($url ? $url : 'NO URL PROVIDED') : null;
$size      ??= 'sm';
$mobile    ??= false;
$isActive  ??= false;
$target    ??= null;
$highlight ??= false;
$type      ??= null;

// Markup // 
////////////////// ?>

<?php if($is_link): ?> <a <?php else: ?> <button <?php endif ?>

  <?php if($is_link): ?> href="<?= $url ?>" <?php endif ?>
  data-active="<?= $isActive ? 'true' : 'false' ?>"
  <?= $type ? 'data-type="' . $type . '"' : '' ?>
  class      ="
    <?= $size == 'sm' ? 'px-3 h-[30px]' : '' ?>
    <?= $size == 'md' ? 'px-6 h-[40px]' : '' ?>
    <?= $size == 'lg' ? 'px-9 h-[50px]' : '' ?>

    flex justify-center items-center font-medium transition-colors
    rounded
    <?= $highlight ? 'bg-orange-400 text-off-white' : 'bg-dark-green text-off-white' ?>
    hover:bg-dark-green/65
    data-[active=true]:bg-dark-green/65

    <?php if ($mobile): ?>
            text-[clamp(1.5rem,5vw,2.5rem)] 
    <?php else: ?>
            text-sm
    <?php endif ?>"

  <?= $isActive ? 'aria-current="page"' : '' ?>
  <?= $target === '_blank' ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>

  <span class="inline-flex">
    <?= $label ?>
  </span>

<?php if($is_link): ?> </a> <?php else: ?> </button> <?php endif ?>