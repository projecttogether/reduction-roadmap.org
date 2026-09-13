<?php

/** @var \Kirby\Cms\Block $block */

$headline = $block->headline()->or($page->title());
$text = $block->text();
$image = $block->image()->toFile();
$alt = $block->alt()->or($image?->alt() ?? '');
?>

<section class="hero flex min-h-screen w-screen -ml-[calc((100vw-100%)/2)] bg-off-white text-black-green">
  <div class="grid min-h-screen w-full grid-cols-1 lg:grid-cols-2">

    <?php // Left col. // ?>
    <div class="flex items-center px-6 py-16 md:px-12 md:py-24 lg:px-16 bg-dark-green">
      <div class="w-full max-w-2xl">
        <?php if ($headline->isNotEmpty())
          snippet('hdl/hdl', [
            'text'  => $headline->html(),
            'level' => 'h1',
            'size'  => 'hero',
            'color' => 'off-white',
          ]) ?>

        <?php if ($text->isNotEmpty()): ?>
          <div class="mt-8 max-w-xl text-lg leading-relaxed text-black-green/80 md:text-xl">
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
