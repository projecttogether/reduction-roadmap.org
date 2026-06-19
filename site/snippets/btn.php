<?php
// Doc. //
//////////////////

// $url      – href for the link
// $label    – visible link text (pre-escaped HTML)
// $isActive – bool, whether this item is the current page
// $mobile   – bool, use mobile styles (default false = desktop)

// Setup //
//////////////////

$size ??= 'sm';
$mobile ??= false;
$isActive ??= false;

// Markup // 
////////////////// ?>

<a
  href ="<?= $url ?>"
  data-active="<?= $isActive ? 'true' : 'false' ?>"
  class="
    <?= $size == 'sm' ? 'px-3 h-[30px]' : '' ?>
    <?= $size == 'md' ? 'px-6 h-[40px]' : '' ?>
    <?= $size == 'lg' ? 'px-9 h-[50px]' : '' ?>

    flex justify-center items-center font-medium transition-colors
    rounded
    bg-dark-green text-off-white
    hover:bg-dark-green/65
    data-[active=true]:bg-dark-green/65

    <?php if ($mobile): ?>
            text-[clamp(1.5rem,5vw,2.5rem)] 
    <?php else: ?>
            text-sm
    <?php endif ?>"

  <?= $isActive ? 'aria-current="page"' : '' ?>>

  <span class="inline-flex">
    <?= $label ?>
  </span>

</a>
