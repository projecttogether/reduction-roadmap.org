        <nav
            class     ="hidden md:block"
            aria-label="Main navigation">
          <div
              class="flex gap-1 list-none m-0 p-0"
              role ="list">
            <?php if ($site->navigation()->isNotEmpty()): ?>
              <?php foreach ($site->navigation()->toStructure() as $item): ?>
                <?php $linkedPage = $item->link()->toPage() ?>
                <?php snippet('btn', [
                  'url'      => $linkedPage ? $linkedPage->url() : '#',
                  'label'    => $item->label()->html(),
                  'isActive' => (bool)$linkedPage?->isActive(),
                ]) ?>
              <?php endforeach ?>
            <?php else: ?>
              <?php foreach ($site->children()->listed() as $item): ?>
                <?php snippet('btn', [
                  'url'      => $item->url(),
                  'label'    => $item->title()->html(),
                  'isActive' => (bool)$item->isActive(),
                ]) ?>
              <?php endforeach ?>
            <?php endif ?>
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
          <?php if ($site->navigation()->isNotEmpty()): ?>
            <?php foreach ($site->navigation()->toStructure() as $item): ?>
              <?php $linkedPage = $item->link()->toPage() ?>
              <?php snippet('btn', [
                'url'      => $linkedPage ? $linkedPage->url() : '#',
                'label'    => $item->label()->html(),
                'isActive' => (bool)$linkedPage?->isActive(),
                'mobile'   => true,
              ]) ?>
            <?php endforeach ?>
          <?php else: ?>
            <?php foreach ($site->children()->listed() as $item): ?>
              <?php snippet('btn', [
                'url'      => $item->url(),
                'label'    => $item->title()->html(),
                'isActive' => (bool)$item->isActive(),
                'mobile'   => true,
              ]) ?>
            <?php endforeach ?>
          <?php endif ?>
        </ul>
      </nav>

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
