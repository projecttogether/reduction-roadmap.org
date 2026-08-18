<?php

/** @var \Kirby\Cms\Block $block */

// Setup //
////////////////////////////////////

$source = $block->source()->toPage();
$source ??= site()->find('best-practices');
if ($source === null) return;

$projects = $source->children()->filterBy('template', 'best-practice-project')->listed();
if ($projects->isEmpty()) return;

$blockId   = 'best-practices-grid-' . $block->id();
$columns   = $block->columns()->or(2)->int();
$gridClass = $columns === 3 ? 'grid-cols-1 md:grid-cols-2 xl:grid-cols-3' : 'grid-cols-1 lg:grid-cols-2';

$co2RangeLabels = [
  'below-10' => 'Unter 10 kgCO₂/m²/Jahr',
  '10-20'    => '10–20 kgCO₂/m²/Jahr',
  '20-30'    => '20–30 kgCO₂/m²/Jahr',
  'above-30' => 'Über 30 kgCO₂/m²/Jahr',
];

$filters = [
  'function' => [
    'label' => 'Funktion',
    'attribute' => 'data-function',
    'values' => $projects->pluck('function', ',', true),
  ],
  'construction' => [
    'label' => 'Baumaßnahme',
    'attribute' => 'data-construction',
    'values' => $projects->pluck('constructionType', ',', true),
  ],
  'co2' => [
    'label' => 'kgCO₂/m²/Jahr',
    'attribute' => 'data-co2',
    'values' => $projects->pluck('co2Range', ',', true),
  ],
];

foreach ($filters as $key => $f) {
  $filters[$key]['values'] = array_values(array_filter(array_unique(array_map(fn ($val) => trim((string)$val), $f['values']))));
  sort($filters[$key]['values'], SORT_NATURAL | SORT_FLAG_CASE);
}

// Markup //
//////////////////////////////////// ?>

<section 
  id="<?= esc($blockId) ?>" 
  class="best-practices-project-grid flex flex-col gap-8">

  <?php 
  // Filter bar //
  ////////////////////////

  snippet('best-practices/project-filterbar', ['filters' => $filters, 'co2RangeLabels'  => $co2RangeLabels]);

  // Grid items //
  //////////////////////// ?>

  <div class="grid <?= $gridClass ?> gap-6" data-projects>
    <?php foreach ($projects as $proj) snippet('best-practices/project-card', ['project' => $proj]) ?>
  </div>

  <?php 
  // Empty grid notif. //
  //////////////////////// ?>

  <p class="hidden border border-dark-green px-4 py-5 text-base text-dark-green" data-empty-results role="status">
    Keine Projekte entsprechen den ausgewählten Filtern.
  </p>

</section>

<?php
// Filter JS
snippet('best-practices/project-grid-filter', ['blockId' => $blockId]) ?>
