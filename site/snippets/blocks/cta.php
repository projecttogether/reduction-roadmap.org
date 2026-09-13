<?php

/** @var \Kirby\Cms\Block $block */

$headline = $block->headline();
$text = $block->text();
$buttonText = $block->buttonText();
$buttonUrl = $block->buttonLink()->toUrl();
$backgroundColor = trim($block->backgroundColor()->or('var(--color-dark-green)')->value());
$hasHeadline = $headline->isNotEmpty();
$hasText = $text->isNotEmpty();
$hasButton = $buttonText->isNotEmpty() && $buttonUrl !== null;
$hasBody = $hasText || $hasButton;
$splitLayout = $hasHeadline && $hasBody;

if ($backgroundColor === '') $backgroundColor = 'var(--color-dark-green)';
?>

<section
  class="cta-block w-full bg-dark-green text-off-white"
  style="background-color: <?= esc($backgroundColor) ?>;"
>
  <div class="grid gap-10 px-6 py-16 md:px-12 md:py-20 <?= $splitLayout ? 'lg:grid-cols-2' : 'grid-cols-1' ?> lg:px-16">
    <?php if ($hasHeadline): ?>
      <div class="flex items-start">
        <?php snippet('hdl/hdl', [
          'text'  => $headline->html(),
          'level' => 'h2',
          'size'  => 'lg',
          'color' => 'off-white',
          'class' => 'max-w-xl',
        ]) ?>
      </div>
    <?php endif ?>

    <?php if ($hasBody): ?>
      <div class="flex flex-col items-start justify-start">
        <?php if ($hasText): ?>
          <div class="max-w-2xl text-lg leading-relaxed text-off-white/90">
            <?= $text->kt() ?>
          </div>
        <?php endif ?>
        <?php if ($hasButton): ?>
          <div class="mt-8">
            <?php snippet('btn', [
              'label' => $buttonText->html(),
              'url' => $buttonUrl,
              'size' => 'md',
              'highlight' => true,
              'target' => preg_match('/^(https?:)?\/\//i', $buttonUrl) === 1 ? '_blank' : null,
            ]) ?>
          </div>
        <?php endif ?>
      </div>
    <?php endif ?>
  </div>
</section>
