<?php

/**
 * Slide-in detail panel for the project grid.
 *
 * One panel per grid holding one section per project. Opening a card reveals
 * the matching section, so no content has to be fetched or cloned at runtime
 * and blocks that ship their own scripts initialise normally.
 *
 * @var string $blockId
 * @var \Kirby\Cms\Pages $projects
 */

$blockId  ??= '';
$projects ??= null;

if ($projects === null) return;

// Only projects whose overlay is switched on get a section, so a disabled
// project cannot be reached even if its id is guessed.
$projects = $projects->filter(fn ($project) => $project->hasOverlay());

if ($projects->isEmpty()) return;

$overlayId = 'best-practices-overlay-' . $blockId;
?>

<div
  id="<?= esc($overlayId) ?>"
  class="fixed inset-0 z-50"
  data-project-overlay
  hidden
>
  <div
    class="absolute inset-0 bg-black-green/60 opacity-0 transition-opacity duration-300 ease-out motion-reduce:transition-none"
    data-overlay-backdrop
  ></div>

  <aside
    class="absolute inset-y-0 right-0 flex w-full translate-x-full flex-col bg-off-white transition-transform duration-300 ease-out motion-reduce:transition-none md:w-2/3"
    data-overlay-panel
    role="dialog"
    aria-modal="true"
  >
    <button
      type="button"
      class="absolute right-5 top-5 z-10 flex size-10 shrink-0 items-center justify-center border border-dark-green bg-off-white text-dark-green transition-colors hover:bg-dark-green hover:text-off-white focus:outline-none focus:ring-2 focus:ring-dark-green/30"
      data-overlay-close
      aria-label="Detailansicht schließen"
    >
      <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </button>

    <div class="flex-1 overflow-y-auto" data-overlay-scroll>
      <?php foreach ($projects as $overlayProject): ?>
        <?php
          $overlayLocation = $overlayProject->location()->value();
          $overlayPeriod   = $overlayProject->projectPeriod()->value();
          $overlaySubtitle = implode(', ', array_filter([$overlayLocation, $overlayPeriod]));
        ?>
        <article data-overlay-project="<?= esc($overlayProject->id()) ?>" hidden>
          <header class="border-b border-dark-green/20 p-5 pr-20 md:p-6 md:pr-20">
            <h2 class="font-heading text-4xl font-black leading-tight text-black-green md:text-5xl">
              <?= $overlayProject->title()->html() ?>
            </h2>

            <?php if ($overlaySubtitle !== ''): ?>
              <p class="mt-2 text-base text-dark-green"><?= esc($overlaySubtitle) ?></p>
            <?php endif ?>

            <?php snippet('best-practices/project-meta', [
              'project' => $overlayProject,
              'class'   => 'mt-5',
            ]) ?>
          </header>

          <?php if ($overlayProject->overlayLayout()->isNotEmpty()): ?>
            <div class="px-5 md:px-6">
              <?php snippet('layout', [
                'layoutField'  => $overlayProject->overlayLayout(),
                'edgePadding'  => false,
              ]) ?>
            </div>
          <?php endif ?>
        </article>
      <?php endforeach ?>
    </div>
  </aside>
</div>
