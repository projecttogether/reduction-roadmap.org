<?php

/**
 * Slide-in detail panel for the project grid.
 * One instance per grid; the content is filled from the clicked card.
 *
 * @var string $blockId
 */

$blockId ??= '';
$overlayId = 'best-practices-overlay-' . $blockId;
$titleId   = $overlayId . '-title';
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
    aria-labelledby="<?= esc($titleId) ?>"
  >
    <header class="flex items-start justify-between gap-4 border-b border-dark-green/20 p-5 md:p-6">
      <h2
        id="<?= esc($titleId) ?>"
        class="font-heading text-3xl font-black leading-tight text-black-green"
        data-overlay-title
      ></h2>

      <button
        type="button"
        class="flex size-10 shrink-0 items-center justify-center border border-dark-green text-dark-green transition-colors hover:bg-dark-green hover:text-off-white focus:outline-none focus:ring-2 focus:ring-dark-green/30"
        data-overlay-close
        aria-label="Detailansicht schließen"
      >
        <svg class="size-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
      </button>
    </header>

    <div class="flex-1 overflow-y-auto p-5 md:p-6" data-overlay-content></div>
  </aside>
</div>
