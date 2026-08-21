<header
  class="sticky top-0 z-50 bg-off-white border-b border-transparent"
  id   ="header">

  <div class="max-w-[1100px] mx-auto py-6 flex items-center justify-between gap-8">

    <div>
      <a
          href      ="<?= $site->url() ?>"
          class     ="block no-underline leading-none"
          aria-label="<?= $site->title()->html() ?> – Home">
        <?php if ($logo = $site->logo()->toFile()): ?>
                <img
                    src   ="<?= $logo->url() ?>"
                    alt   ="<?= $site->title()->html() ?>"
                    class ="h-12 w-auto"
                    width ="<?= $logo->width() ?>"
                    height="<?= $logo->height() ?>">
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
              $isExternal = !$linkedPage && preg_match('/^(https?:)?\/\//i', (string)$linkedUrl) === 1;
              snippet('btn', [
                'url'       => $linkedUrl ?: ($linkedPage ? $linkedPage->url() : '#'),
                'label'     => $item->label()->html(),
                'isActive'  => $linkedPage ? $linkedPage->isActive() : false,
                'highlight' => $item->is_cta()->isTrue(),
                'target'    => $isExternal ? '_blank' : null,
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
      class     ="hidden fixed inset-0 bg-off-white z-40 items-center justify-center px-[clamp(1.5rem,4vw,4rem)]"
      id        ="mobile-nav"
      aria-label="Mobile navigation">
    <ul
        class="list-none m-0 p-0 text-center"
        role ="list">
      <?php
        if ($site->navigation()->isNotEmpty()) {
          foreach ($site->navigation()->toStructure() as $item) {
            $linkedPage = $item->link()->toPage();
            $linkedUrl  = $item->link()->toUrl();
            $isExternal = !$linkedPage && preg_match('/^(https?:)?\/\//i', (string)$linkedUrl) === 1;

            snippet('btn', [
              'url'      => $linkedUrl ?: ($linkedPage ? $linkedPage->url() : '#'),
              'label'    => $item->label()->html(),
              'isActive' => $linkedPage ? $linkedPage->isActive() : false,
              'mobile'   => true,
              'target'   => $isExternal ? '_blank' : null,
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
    if (!toggle || !nav) return;
    toggle.addEventListener('click', function () {
      var open = toggle.getAttribute('aria-expanded') === 'true';
      if (open) {
        nav.classList.remove('flex');
        nav.classList.add('hidden');
        toggle.setAttribute('aria-expanded', 'false');
      } else {
        nav.classList.remove('hidden');
        nav.classList.add('flex');
        toggle.setAttribute('aria-expanded', 'true');
      }
    });
  })();
</script>
