<?php
$hasHero = false;
$logoWhite = $site->logoWhite()->toFile();
$transparentNavigation = $page->transparentNavigation()->isTrue();
foreach ($page->layout()->toLayouts() as $layout)
  foreach ($layout->columns() as $column)
    foreach ($column->blocks() as $block)
      if ($block->type() === 'hero') {
        $hasHero = true;
        break 3;
      }
?>

<header
  class="<?= $hasHero || $transparentNavigation ? 'fixed inset-x-0 bg-transparent' : 'sticky bg-off-white' ?> top-0 z-50 border-b border-transparent transition-colors duration-300"
  data-hero-nav="<?= $hasHero || $transparentNavigation ? 'true' : 'false' ?>"
  data-white-logo="<?= $logoWhite ? 'true' : 'false' ?>"
  id   ="header">

  <div class="mx-auto px-16 py-6 flex items-center justify-between gap-8">

    <div>
      <a
          href      ="<?= $site->url() ?>"
          class     ="block no-underline leading-none"
          aria-label="<?= $site->title()->html() ?> – Home">
        <?php if ($logo = $site->logo()->toFile()): ?>
                <span class="grid h-12">
                  <img
                      src   ="<?= $logo->url() ?>"
                      alt   ="<?= $site->title()->html() ?>"
                      class ="nav-logo nav-logo-regular col-start-1 row-start-1 h-12 w-auto"
                      width ="<?= $logo->width() ?>"
                      height="<?= $logo->height() ?>">
                  <?php if ($logoWhite): ?><img
                      src   ="<?= $logoWhite->url() ?>"
                      alt   ="<?= $site->title()->html() ?>"
                      class ="nav-logo nav-logo-white col-start-1 row-start-1 h-12 w-auto"
                      width ="<?= $logoWhite->width() ?>"
                      height="<?= $logoWhite->height() ?>"><?php endif ?>
                </span>
        <?php else: ?>
                <span class="font-heading font-black text-lg text-dark-green"><?= $site->title()->html() ?></span>
        <?php endif ?>
      </a>
    </div>

    <nav
        class     ="hidden md:block"
        aria-label="Main navigation">

      <div
          class="flex gap-1 list-none m-0 p-0"
          role ="list">
        <?php
          if ($site->navigation()->isNotEmpty()) {
            foreach ($site->navigation()->toStructure() as $item) {
              $linkedPage = $item->link()->toPage();
              $linkedUrl  = $item->link()->toUrl();
              $footerLink = $item->footer()->isTrue();
              $isExternal = !$linkedPage && preg_match('/^(https?:)?\/\//i', (string)$linkedUrl) === 1;
              snippet('btn', [
                'url'       => $footerLink ? '#page-footer' : ($linkedUrl ?: ($linkedPage ? $linkedPage->url() : '#')),
                'label'     => $item->label()->html(),
                'isActive'  => $linkedPage ? $linkedPage->isActive() : false,
                'highlight' => $item->is_cta()->isTrue(),
                'target'    => $footerLink || !$isExternal ? null : '_blank',
              ]);
            }
          } else {
            foreach ($site->children()->listed() as $item) {
              snippet('btn', [
                'url'       => $item->url(),
                'label'     => $item->title()->html(),
                'isActive'  => (bool)$item->isActive(),
                'highlight' => $item->is_cta()->isTrue(),
              ]);
            }
          }
        ?>
      </div>

    </nav>

    <button
        id           ="nav-toggle"
        class        ="md:hidden flex flex-col justify-center gap-[5px] w-9 h-9 bg-transparent border-0 cursor-pointer p-1"
        aria-controls="mobile-nav"
        aria-expanded="false"
        aria-label   ="Toggle navigation">
      <span class="hamburger-bar"></span>
      <span class="hamburger-bar"></span>
      <span class="hamburger-bar"></span>
    </button>

  </div>

  <!-- Mobile nav: starts hidden; JS toggles the 'hidden' class -->
  <nav
      class     ="hidden fixed inset-0 bg-off-white z-40 flex-col items-start justify-end px-6 pb-10"
      id        ="mobile-nav"
      aria-label="Mobile navigation">
    <button
      type       ="button"
      id         ="mobile-nav-close"
      class      ="absolute right-6 top-6 inline-flex h-10 w-10 items-center justify-center border-0 bg-transparent text-4xl leading-none text-dark-green"
      aria-label  ="Close navigation"
    >
      <span aria-hidden="true">×</span>
    </button>
    <ul
        class="m-0 flex w-full list-none flex-col items-start gap-2 p-0 text-left"
        role ="list">
      <?php
        if ($site->navigation()->isNotEmpty()) {
          foreach ($site->navigation()->toStructure() as $item) {
            $linkedPage = $item->link()->toPage();
            $linkedUrl  = $item->link()->toUrl();
            $footerLink = $item->footer()->isTrue();
            $isExternal = !$linkedPage && preg_match('/^(https?:)?\/\//i', (string)$linkedUrl) === 1;

            snippet('btn', [
              'url'      => $footerLink ? '#page-footer' : ($linkedUrl ?: ($linkedPage ? $linkedPage->url() : '#')),
              'label'    => $item->label()->html(),
              'isActive' => $linkedPage ? $linkedPage->isActive() : false,
              'mobile'   => true,
              'target'   => $footerLink || !$isExternal ? null : '_blank',
            ]);
          }
        } else {
          foreach ($site->children()->listed() as $item) {
            snippet('btn', [
              'url'      => $item->url(),
              'label'    => $item->title()->html(),
              'isActive' => (bool)$item->isActive(),
              'mobile'   => true,
            ]);
          }
        }
      ?>
    </ul>
  </nav>

</header>

<script>
  (function () {
    var toggle = document.getElementById('nav-toggle');
    var nav    = document.getElementById('mobile-nav');
    var close  = document.getElementById('mobile-nav-close');
    var header = document.getElementById('header');
    if (!toggle || !nav || !header) return;

    document.querySelectorAll('a[href="#page-footer"]').forEach(function (link) {
      link.addEventListener('click', function (event) {
        var footer = document.getElementById('page-footer');
        if (!footer) return;

        event.preventDefault();
        footer.scrollIntoView({
          behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth',
          block: 'start',
        });
        history.replaceState(null, '', '#page-footer');
      });
    });

    if (header.dataset.heroNav === 'true') {
      var updateHeader = function () {
        header.classList.toggle('nav-scrolled', window.scrollY > 150);
      };

      window.addEventListener('scroll', updateHeader, { passive: true });
      updateHeader();
    }

    var setOpen = function (open) {
      nav.classList.toggle('hidden', !open);
      nav.classList.toggle('flex', open);
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    };

    toggle.addEventListener('click', function () {
      setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });
    if (close) close.addEventListener('click', function () { setOpen(false); });
  })();
</script>
