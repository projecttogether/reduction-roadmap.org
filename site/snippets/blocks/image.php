<?php

/** @var \Kirby\Cms\Block $block */

// Setup //
//////////////////

$caption = $block->caption();
$link    = $block->link();
$image   = $block->image()->toFile();
$alt     = $block->alt()->or($image?->alt() ?? '');
$src     = $image?->url();
$ratio   = $block->ratio()->or('auto');
$crop    = 'true';

if(!$src) return;

// Markup //
////////////////// ?>

<figure class="relative flex flex-col"
        style="--ar: <?= $ratio ?>;">

  <div class="relative aspect-(--ar) overflow-hidden">
    <?php if ($link->isNotEmpty()): ?>
            <a href="<?= Str::esc($link->toUrl()) ?>"
                class="size-full">
              <img src="<?= $src ?>" alt="<?= $alt->esc() ?>"
                    class="size-full object-cover">
            </a>
    <?php else: ?>
            <img src="<?= $src ?>" 
                  alt="<?= $alt->esc() ?>"
                  class="absolute inset-0 size-full object-cover">
    <?php endif ?>
  </div>

  <?php if ($caption->isNotEmpty()): ?>
          <figcaption class="mt-4 text-center">
            <?= $caption ?>
          </figcaption>
  <?php endif ?>

</figure>