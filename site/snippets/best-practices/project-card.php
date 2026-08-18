<?php

/** @var \Kirby\Cms\Page $project */

// Setup //
//////////////////

$image = $project->cover()->toFile() ?? $project->images()->first();
$url   = $project->detailLink()->isNotEmpty()
  ? $project->detailLink()->value()
  : $project->url();
$isExternal     = parse_url($url, PHP_URL_HOST) !== parse_url($site->url(), PHP_URL_HOST);
$location       = $project->location()->value();
$year           = $project->year()->value();
$area           = $project->area()->toFloat();
$co2RangeLabels = [
  'below-10' => 'Unter 10 kgCO₂/m²/Jahr',
  '10-20'    => '10–20 kgCO₂/m²/Jahr',
  '20-30'    => '20–30 kgCO₂/m²/Jahr',
  'above-30' => 'Über 30 kgCO₂/m²/Jahr',
];
$co2Label = $co2RangeLabels[$project->co2Range()->value()] ?? null;

$args_btn_details = [
  'label'  => 'Weiterführende Informationen',
  'url'    => $url,
  'size'   => 'sm',
  'target' => $isExternal ? '_blank' : null,
];

// Markup //
////////////////// ?>

<article
  class="best-practices-project flex min-w-0 flex-col border border-dark-green bg-off-white"
  data-function="<?= esc(Str::slug($project->function()->value())) ?>"
  data-construction="<?= esc(Str::slug($project->constructionType()->value())) ?>"
  data-co2="<?= esc($project->co2Range()->value()) ?>"
>
  <?php if ($image): ?>
    <a href="<?= esc($url) ?>" class="block aspect-4/3 overflow-hidden"<?= $isExternal ? ' target="_blank" rel="noopener noreferrer"' : '' ?>>
      <img src="<?= esc($image->url()) ?>" alt="<?= esc($image->alt()->or($project->title())->value()) ?>" class="size-full object-cover transition-transform duration-300 hover:scale-[1.02]">
    </a>
  <?php endif ?>

  <div class="flex flex-1 flex-col gap-5 p-5 md:p-6">
    <header>
      <h3 class="font-heading text-2xl font-black leading-tight text-black-green">
        <a href="<?= esc($url) ?>"<?= $isExternal ? ' target="_blank" rel="noopener noreferrer"' : '' ?>><?= $project->title()->html() ?></a>
      </h3>
      <?php if ($location !== '' || $year !== ''): ?>
        <p class="mt-2 text-base text-dark-green">
          <?= esc(implode(', ', array_filter([$location, $year]))) ?>
        </p>
      <?php endif ?>
    </header>

    <dl class="mt-auto flex flex-wrap gap-2 text-xs uppercase tracking-wide text-off-white">
      <?php foreach ([
        $project->function()->value(),
        $project->constructionType()->value(),
        $area > 0 ? number_format($area, 0, ',', '.') . ' m²' : null,
        $co2Label,
      ] as $tag): ?>
        <?php if ($tag !== null && $tag !== ''): ?>
          <div class="bg-dark-green px-2 py-1">
            <dt class="sr-only">Project category</dt>
            <dd><?= esc($tag) ?></dd>
          </div>
        <?php endif ?>
      <?php endforeach ?>
    </dl>

    <?php if ($project->description()->isNotEmpty()): ?>
      <div class="text-base leading-relaxed text-dark-green">
        <?= $project->description()->kt() ?>
      </div>
    <?php endif ?>


    <div class="flex justify-start items-start flex-wrap gap-2 hidden">
      <?php snippet('btn', $args_btn_details) ?>
    </div>
  </div>
</article>
