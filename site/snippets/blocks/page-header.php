<?php

/** @var \Kirby\Cms\Block $block */

// Setup //
$headline        = $block->headline()->or($page->title());
$subheadline     = $block->subheadline();
$introduction    = $block->introduction();
$minHeight       = max(0, min(100, $block->minHeight()->or(50)->toInt()));
$backgroundColor = trim($block->backgroundColor()->or('var(--color-dark-green)')->value());

if ($backgroundColor === '') $backgroundColor = 'var(--color-dark-green)';

// Markup // ?>
<section
  class="page-header flex w-screen -ml-[calc((100vw-100%)/2)] items-center bg-dark-green text-off-white"
  style="min-height: <?= $minHeight ?>vh; background-color: <?= esc($backgroundColor) ?>;
        --w-max    : 1100px;"
>
  <div class="w-full max-w-(--w-max) mx-auto py-16 md:py-24">
    <div class="flex pl-5 pt-2 border-l-[10px] border-off-white">
      <?php if ($headline->isNotEmpty())
              snippet('hdl/hdl', ['text'  => $headline->html(), 'level' => 'h1', 'size' => 'hero', 'color' => 'off-white']) ?>
    </div>

    <?php if ($subheadline->isNotEmpty()): ?>
      <p class="mt-6 max-w-3xl text-[clamp(1.25rem,2.5vw,2rem)] leading-snug">
        <?= $subheadline->kt() ?>
      </p>
    <?php endif ?>

    <?php if ($introduction->isNotEmpty()): ?>
      <div class="mt-8 max-w-2xl text-lg leading-relaxed text-off-white/85">
        <?= $introduction->kt() ?>
      </div>
    <?php endif ?>
  </div>
</section>
