<?php

/** @var \SchmollStudio\BestPractices\BestPracticeProjectPage $project */

// Setup //
//////////////////

$image        = $project->cover()->toFile() ?? $project->images()->first();
$location     = $project->location()->value();
$period       = $project->projectPeriod()->value();
$co2Label     = $project->hasThgRange() ? $project->thgRangeLabel() : null;

// Each meta value carries its own label so it is clear what the value refers to.
// Wording follows the filter bar on the same page, so a tag and the filter that
// matches it read the same.
$metaItems = array_values(array_filter(
  [
    ['label' => 'Funktion',     'value' => $project->buildingUseLabel()],
    ['label' => 'Baumaßnahme',  'value' => $project->constructionTypeLabel()],
    ['label' => 'Fläche (BGF)', 'value' => $project->displayArea()],
    ['label' => 'THG-Zielwert', 'value' => $co2Label],
  ],
  fn ($item) => trim((string)$item['value']) !== ''
));

// Markup //
////////////////// ?>

<article
  class="best-practices-project group flex min-w-0 cursor-pointer flex-col border border-dark-green bg-off-white"
  data-function="<?= esc($project->buildingUse()->value()) ?>"
  data-construction="<?= esc($project->constructionType()->value()) ?>"
  data-co2="<?= esc($project->thgTarget()->value()) ?>"
  data-project-trigger
  data-project-id="<?= esc($project->id()) ?>"
  data-project-title="<?= esc($project->title()->value()) ?>"
  data-project-url="<?= esc($project->url()) ?>"
  data-project-source="<?= esc($project->hasExternalDetail() ? $project->sourceUrl()->value() : '') ?>"
>
  <?php if ($image): ?>
    <div class="aspect-4/3 overflow-hidden">
      <img src="<?= esc($image->url()) ?>" alt="<?= esc($image->alt()->or($project->title())->value()) ?>" class="size-full object-cover transition-transform duration-300 group-hover:scale-[1.02] motion-reduce:transition-none">
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

    <?php if ($metaItems !== []): ?>
      <dl class="mt-auto flex flex-wrap gap-x-6 gap-y-3 border-t border-dark-green/20 pt-5">
        <?php foreach ($metaItems as $metaItem): ?>
          <div class="flex flex-col gap-0.5">
            <dt class="text-[10px] uppercase leading-none tracking-wide text-dark-green/70">
              <?= esc($metaItem['label']) ?>
            </dt>
            <dd class="text-xs leading-tight text-dark-green">
              <?= esc($metaItem['value']) ?>
            </dd>
          </div>
        <?php endforeach ?>
      </dl>
    <?php endif ?>

    <?php if ($project->description()->isNotEmpty()): ?>
      <div class="border-t border-dark-green/20 pt-5 text-base leading-relaxed text-dark-green">
        <?= $project->description()->kt() ?>
      </div>
    <?php endif ?>


    <div class="flex flex-wrap items-start justify-start gap-2">
      <button
        type="button"
        class="flex h-[30px] w-fit items-center justify-center bg-dark-green px-3 text-sm font-medium text-off-white transition-colors hover:bg-dark-green/65 focus:outline-none focus:ring-2 focus:ring-dark-green/30"
        data-project-more
        aria-haspopup="dialog"
      >
        <span class="inline-flex pt-0.5">Mehr erfahren</span>
      </button>
    </div>
  </div>
</article>
