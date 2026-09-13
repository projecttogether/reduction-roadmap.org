<?php

$enabled = $site->popupEnabled()->isTrue();
$headline = $site->popupHeadline();
$text = $site->popupText();
$buttonLabel = $site->popupButtonLabel();
$buttonUrl = $site->popupButtonLink()->toUrl();
$position = $site->popupPosition()->or('right')->value();

if (!$enabled || ($headline->isEmpty() && $text->isEmpty())) return;

$hasButton = $buttonLabel->isNotEmpty() && $buttonUrl !== null;
$isExternal = $buttonUrl && preg_match('/^(https?:)?\/\//i', $buttonUrl) === 1;
?>

<aside
  id="site-popup"
  data-site-popup
  aria-labelledby="site-popup-title"
  aria-describedby="site-popup-text"
  aria-hidden="true"
  class="
    site-popup fixed bottom-5 z-[9999] w-[calc(100vw-2.5rem)] max-w-[28rem] 
    border border-dark-green bg-off-white p-5 shadow-2xl transition-transform duration-300 ease-out 
    md:bottom-12 <?= $position === 'left' ? 'left-5 md:left-16' : 'right-5 md:right-16' ?>
    flex flex-col items-start"
  style="transform: translateY(140%);"
>
  <button
    type="button"
    class="absolute right-3 top-3 inline-flex size-8 items-center justify-center text-2xl leading-none text-black transition-opacity hover:opacity-60"
    data-popup-close
    aria-label="Popup schließen"
  >
    <span aria-hidden="true">×</span>
  </button>

  <?php if ($headline->isNotEmpty()): ?>
    <h2 id="site-popup-title" class="pr-8 font-heading text-2xl font-black leading-tight">
      <?= $headline->html() ?>
    </h2>
  <?php endif ?>

  <?php if ($text->isNotEmpty()): ?>
    <div id="site-popup-text" class="mt-3 max-w-prose text-base leading-relaxed">
      <?= $text->kt() ?>
    </div>
  <?php endif ?>

  <?php if ($hasButton): ?>
    <div class="mt-5">
      <?php snippet('btn', [
        'label' => $buttonLabel->html(),
        'url' => $buttonUrl,
        'size' => 'sm',
        'target' => $isExternal ? '_blank' : null,
      ]) ?>
    </div>
  <?php endif ?>
</aside>

<script>
  (function () {
    var popup = document.querySelector('[data-site-popup]');
    if (!popup) return;

    var close = popup.querySelector('[data-popup-close]');
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var reveal = function () {
      popup.setAttribute('aria-hidden', 'false');
      popup.style.transform = 'translateY(0)';
    };
    var hide = function () {
      popup.setAttribute('aria-hidden', 'true');
      popup.style.transform = 'translateY(140%)';
    };

    close.addEventListener('click', hide);
    window.setTimeout(reveal, reducedMotion ? 0 : 1000);
  })();
</script>
