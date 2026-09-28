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

// Content-based version: editing the popup in the panel re-shows it to
// visitors who already dismissed the previous version.
$popupVersion = substr(md5($headline . '|' . $text . '|' . $buttonLabel . '|' . $buttonUrl . '|' . $position), 0, 12);
?>

<aside
  id="site-popup"
  data-site-popup
  data-popup-version="<?= $popupVersion ?>"
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

    var COOKIE_NAME = 'rr_popup_seen';
    var COOKIE_MAX_AGE = 60 * 60 * 24 * 14; // 14 days
    var version = popup.getAttribute('data-popup-version') || '1';

    var readCookie = function (name) {
      var match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + '=([^;]*)'));
      return match ? decodeURIComponent(match[1]) : null;
    };
    var writeCookie = function (name, value) {
      var secure = window.location.protocol === 'https:' ? '; Secure' : '';
      document.cookie = name + '=' + encodeURIComponent(value) +
        '; Max-Age=' + COOKIE_MAX_AGE + '; Path=/; SameSite=Lax' + secure;
    };

    // Already seen this version of the popup: leave it hidden.
    if (readCookie(COOKIE_NAME) === version) return;

    var close = popup.querySelector('[data-popup-close]');
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var dismissed = false;
    var remember = function () {
      if (dismissed) return;
      dismissed = true;
      writeCookie(COOKIE_NAME, version);
    };
    var reveal = function () {
      popup.setAttribute('aria-hidden', 'false');
      popup.style.transform = 'translateY(0)';
      // Mark as seen once shown, so navigating to another page won't re-trigger it.
      remember();
    };
    var hide = function () {
      popup.setAttribute('aria-hidden', 'true');
      popup.style.transform = 'translateY(140%)';
      remember();
    };

    close.addEventListener('click', hide);
    window.setTimeout(reveal, reducedMotion ? 0 : 1000);
  })();
</script>
