<?php

/** @var \Kirby\Cms\Block $block */

$headline     = $block->headline()->or($page->title());
$text         = $block->text();
$image        = $block->image()->toFile();
$alt          = $block->alt()->or($image?->alt() ?? '');
$layout       = $block->layout()->or('equal')->value();
$headlineSize = $block->headlineSize()->or('hero')->value();
$gridClass    = $layout === 'text-wide' ? 'lg:grid-cols-[2fr_1fr]' : 'lg:grid-cols-2';
?>

<section class="hero flex min-h-screen w-screen -ml-[calc((100vw-100%)/2)] bg-off-white text-black-green">
  <div class="grid min-h-screen w-full grid-cols-1 <?= $gridClass ?>">

    <?php // Left col. // ?>
    <div class="flex flex-col justify-end bg-dark-green px-6 pb-16 pt-40 md:px-12 md:py-16 lg:px-16">
      <div class="w-full">
        <?php if ($headline->isNotEmpty())
          snippet('hdl/hdl', [
            'text'  => $headline->html(),
            'level' => 'h1',
            'size'  => $headlineSize,
            'color' => 'off-white',
            'class' => 'select-none',
          ]) ?>

        <?php if ($text->isNotEmpty()): ?>
          <div class="mt-8 text-fließtext-md text-off-white">
            <?= $text->kt() ?>
          </div>
        <?php endif ?>
      </div>
    </div>

    <?php // Right col. // ?>
    <div class="min-h-[50vh] bg-light-bg lg:min-h-screen">
      <?php if ($image): ?>
        <img
          src="<?= esc($image->url()) ?>"
          alt="<?= $alt->esc() ?>"
          class="size-full object-cover"
          loading="eager"
        >
      <?php endif ?>
    </div>
  </div>
</section>
