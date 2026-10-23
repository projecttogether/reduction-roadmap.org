<?php

/** @var \SchmollStudio\BestPractices\BestPracticeProjectPage $project */

// Setup //
//////////////////

$image        = $project->cover()->toFile() ?? $project->images()->first();
$location     = $project->location()->value();
$period       = $project->projectPeriod()->value();

// With the overlay switched off the card carries no trigger, is not
// clickable and shows no "Mehr erfahren" button.
$hasOverlay   = $project->hasOverlay();
// Markup //
////////////////// ?>

<article
  class="best-practices-project group flex min-w-0 flex-col border border-dark-green bg-off-white<?= $hasOverlay ? ' cursor-pointer' : '' ?>"
  data-function="<?= esc($project->buildingUse()->value()) ?>"
  data-construction="<?= esc($project->constructionType()->value()) ?>"
  data-co2="<?= esc($project->thgTarget()->value()) ?>"
  <?php if ($hasOverlay): ?>
    data-project-trigger
    data-project-id="<?= esc($project->id()) ?>"
    data-project-title="<?= esc($project->title()->value()) ?>"
    data-project-url="<?= esc($project->url()) ?>"
    data-project-source="<?= esc($project->hasExternalDetail() ? $project->sourceUrl()->value() : '') ?>"
  <?php endif ?>
>
  <?php if ($image): ?>
    <div class="aspect-4/3 overflow-hidden">
      <img src="<?= esc($image->url()) ?>" alt="<?= esc($image->alt()->or($project->title())->value()) ?>" class="size-full object-cover transition-transform duration-300 motion-reduce:transition-none<?= $hasOverlay ? ' group-hover:scale-[1.02]' : '' ?>">
    </div>
  <?php endif ?>

  <div class="flex flex-1 flex-col gap-5 p-5 md:p-6">
    <header>
      <h3 class="font-heading text-2xl font-black leading-tight text-black-green">
        <?= $project->title()->html() ?>
      </h3>
      <?php if ($location !== '' || $period !== ''): ?>
        <p class="mt-2 text-base text-dark-green">
          <?= esc(implode(', ', array_filter([$location, $period]))) ?>
        </p>
      <?php endif ?>
    </header>

    <?php snippet('best-practices/project-meta', [
      'project' => $project,
      'class'   => 'border-t border-dark-green/20 pt-5',
    ]) ?>

    <?php if ($project->description()->isNotEmpty()): ?>
      <div class="border-t border-dark-green/20 pt-5 text-base leading-relaxed text-dark-green">
        <?= $project->description()->kt() ?>
      </div>
    <?php endif ?>


    <?php if ($hasOverlay): ?>
    <div class="mt-auto flex flex-wrap items-start justify-start gap-2">
      <button
        type="button"
        class="flex h-[30px] w-fit items-center justify-center bg-dark-green px-3 text-sm font-medium text-off-white transition-colors hover:bg-dark-green/65 focus:outline-none focus:ring-2 focus:ring-dark-green/30"
        data-project-more
        aria-haspopup="dialog"
      >
        <span class="inline-flex pt-0.5">Mehr erfahren</span>
      </button>
    </div>
    <?php endif ?>
  </div>
</article>
