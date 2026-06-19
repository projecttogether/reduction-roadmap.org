<?php

///// Setup /////
/////////////////

$cards     = $block->cards()->toStructure();
$colCount  = (int) $block->col_count()->or(3)->value();

if ($cards->isEmpty()) return;

$gridClass = match($colCount) {
  2       => 'grid-cols-1 sm:grid-cols-2',
  4       => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
  default => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
};

///// Markup /////
////////////////// ?>

<div class="grid <?= $gridClass ?> gap-6">
  <?php foreach ($cards as $card): 
      
      $eyebrow = $card->eyebrow()->or(null);
      ?>

    <article class="aspect-3/3.5 flex flex-col gap-4 bg-light-bg rounded p-5">

      <?php // Card header // ?>
      <header class="flex flex-col gap-2">
        <?php if ($eyebrow): ?>
                <div class="text-sm font-light tracking-wide text-dark-green">
                  <?= $eyebrow ?>
                </div>
        <?php endif ?>

        <h3 class="font-heading font-black text-xl leading-snug m-0">
          <?= $card->title()->kt() ?>
        </h3>
      </header>

      <?php // Card body // ?>
      <?php if ($card->body()->isNotEmpty()): ?>
        <div class="text-sm leading-relaxed grow">
          <?= $card->body()->kt() ?>
        </div>
      <?php endif ?>

      <?php // Card footer // ?>
      <?php if ($card->link()->isNotEmpty()): ?>
        <div class="mt-auto pt-2 flex justify-start">
          <?php snippet('btn', [
            'label' => 'Find out more',
            'url'   => $card->link()->toUrl(),
            'size'  => 'sm',
          ]) ?>
        </div>
      <?php endif ?>

    </article>

  <?php endforeach ?>
</div>
