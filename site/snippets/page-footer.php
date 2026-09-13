<footer id="page-footer" class="bg-dark-green py-16 text-off-white md:py-24">
  <div class="mx-auto grid grid-cols-12 max-lg:gap-y-12 lg:gap-12 px-6 md:px-16 lg:px-16">
    <div class="col-span-12 lg:col-span-3">
      <a
        href      ="<?= $site->url() ?>"
        class     ="block no-underline leading-none"
        aria-label="<?= $site->title()->html() ?> – Home"
      >
        <?php if ($logo = $site->logoWhite()->toFile()): ?>
          <img
            src   ="<?= $logo->url() ?>"
            alt   ="<?= $site->title()->html() ?>"
            class ="h-12 w-auto"
            width ="<?= $logo->width() ?>"
            height="<?= $logo->height() ?>"
          >
        <?php endif ?>
      </a>
    </div>

    <nav
      class     ="col-span-12 grid gap-8 sm:grid-cols-2 lg:col-span-9 lg:grid-cols-4"
      aria-label="Footer navigation"
    >
      <?php if ($site->footerSections()->isNotEmpty()): ?>
        <?php foreach ($site->footerSections()->toStructure() as $section): ?>
          <section>
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-off-white/70">
              <?= $section->title()->html() ?>
            </h2>
            <ul class="m-0 list-none space-y-2 p-0 text-sm" role="list">
              <?php foreach ($section->links()->toStructure() as $item):
                $linkedPage = $item->link()->toPage();
                $linkedUrl = $item->link()->toUrl();
                $url = $linkedUrl ?: ($linkedPage?->url() ?? '#');
                $isExternal = !$linkedPage && preg_match('/^(https?:|mailto:|tel:|\/\/)/i', (string)$url) === 1; ?>
                <li>
                  <a
                    href       ="<?= esc($url) ?>"
                    class      ="no-underline transition-colors hover:text-white/70"
                    <?= $isExternal && !preg_match('/^(mailto:|tel:)/i', (string)$url) ? 'target="_blank" rel="noopener noreferrer"' : '' ?>
                  >
                    <?= $item->label()->html() ?>
                  </a>
                </li>
              <?php endforeach ?>
            </ul>
          </section>
        <?php endforeach ?>
      <?php elseif ($site->footerNavigation()->isNotEmpty()): ?>
        <section>
          <ul class="m-0 list-none space-y-2 p-0 text-sm" role="list">
            <?php foreach ($site->footerNavigation()->toStructure() as $item):
              $linkedPage = $item->link()->toPage(); ?>
              <li>
                <a
                  href ="<?= esc($linkedPage?->url() ?? '#') ?>"
                  class="no-underline transition-colors hover:text-white/70"
                >
                  <?= $item->label()->html() ?>
                </a>
              </li>
            <?php endforeach ?>
        </section>
      <?php endif ?>
    </nav>

    <?php if ($site->footerInfo()->isNotEmpty()): ?>
      <div class="col-span-12 lg:col-span-6 text-sm leading-relaxed text-off-white/80">
        <?= $site->footerInfo()->kt() ?>
      </div>
    <?php endif ?>
  </div>
</footer>

</body>
</html>
