<?php

$image = $page->cover()->toFile() ?? $page->images()->first();
?>

<?php snippet('header') ?>

<main id="page">
  <section class="bg-off-white py-16 md:py-24">
    <div class="container grid gap-10 lg:grid-cols-12 lg:items-start">
      <aside class="lg:col-span-4">
        <h1 class="font-heading text-5xl font-black leading-tight text-black-green md:text-6xl">
          <?= $page->title()->html() ?>
        </h1>

        <dl class="mt-8 grid gap-5 text-base text-dark-green">
          <?php foreach ([
            'Ort' => $page->location()->value(),
            'Jahr' => $page->year()->value(),
            'Fläche' => $page->area()->toFloat() > 0
              ? number_format($page->area()->toFloat(), 0, ',', '.') . ' m²'
              : '',
            'Funktion' => $page->function()->value(),
            'Baumaßnahme' => $page->constructionType()->value(),
          ] as $label => $value): ?>
            <?php if ($value !== ''): ?>
              <div>
                <dt class="text-xs uppercase tracking-wide text-dark-green/70"><?= esc($label) ?></dt>
                <dd class="mt-1 font-medium text-black-green"><?= esc($value) ?></dd>
              </div>
            <?php endif ?>
          <?php endforeach ?>

          <?php if ($page->co2Range()->isNotEmpty()): ?>
            <div>
              <dt class="text-xs uppercase tracking-wide text-dark-green/70">CO₂-Belastung</dt>
              <dd class="mt-1 font-medium text-black-green">
                <?= esc(match ($page->co2Range()->value()) {
                  'below-10' => 'Unter 10 kgCO₂/m²/Jahr',
                  '10-20' => '10–20 kgCO₂/m²/Jahr',
                  '20-30' => '20–30 kgCO₂/m²/Jahr',
                  'above-30' => 'Über 30 kgCO₂/m²/Jahr',
                  default => $page->co2Range()->value(),
                }) ?>
              </dd>
            </div>
          <?php endif ?>
        </dl>

        <?php if ($page->detailLink()->isNotEmpty()): ?>
          <div class="mt-8">
            <?php snippet('btn', [
              'label'  => 'Weiterführende Informationen',
              'url'    => $page->detailLink()->toUrl(),
              'size'   => 'sm',
              'target' => '_blank',
            ]) ?>
          </div>
        <?php endif ?>
      </aside>

      <div class="lg:col-span-8">
        <?php if ($image): ?>
          <figure class="aspect-4/3 overflow-hidden">
            <img src="<?= esc($image->url()) ?>" alt="<?= esc($image->alt()->or($page->title())->value()) ?>" class="size-full object-cover">
          </figure>
        <?php endif ?>

        <?php if ($page->description()->isNotEmpty()): ?>
          <div class="mt-8 max-w-3xl text-lg leading-relaxed text-dark-green">
            <?= $page->description()->kt() ?>
          </div>
        <?php endif ?>
      </div>
    </div>
  </section>

  <?php snippet('layout') ?>
</main>

<?php snippet('footer') ?>
