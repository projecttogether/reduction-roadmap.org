<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta
        name   ="viewport"
        content="width=device-width, initial-scale=1.0">
    <title><?= $page->title()->html() ?> | <?= $site->title()->html() ?></title>
    <meta
        name   ="description"
        content="<?= $page->description()->or($site->description())->html() ?>">
    <link
        rel ="icon"
        href="<?= url('assets/images/favicon.ico') ?>">
    <link
        rel ="preconnect"
        href="https://fonts.googleapis.com">
    <link
        rel        ="preconnect"
        href       ="https://fonts.gstatic.com"
        crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Martel:wght@700;900&family=Inter:wght@400;500;700&display=swap"
        rel ="stylesheet">
    <link
        rel ="stylesheet"
        href="<?= url('assets/css/main.css') ?>">
  </head>
  <body class="font-body text-black-green bg-off-white antialiased">

    <a
        href ="#page"
        class="skip-link px-4 py-2 bg-dark-green text-off-white font-bold no-underline rounded-b">Skip to Content</a>

    <header
        class="sticky top-0 z-50 bg-off-white border-b border-transparent"
        id   ="header">
      <div class="container flex items-center justify-between gap-8 py-4">

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
          <ul
              class="flex gap-1 list-none m-0 p-0"
              role ="list">
            <?php if ($site->navigation()->isNotEmpty()): ?>
              <?php foreach ($site->navigation()->toStructure() as $item): ?>
                <?php $linkedPage = $item->link()->toPage() ?>
                <li>
                  <a
                      href ="<?= $linkedPage ? $linkedPage->url() : '#' ?>"
                      class="block px-3 py-1.5 text-sm font-medium no-underline rounded transition-colors hover:bg-light-bg<?= $linkedPage?->isActive() ? ' text-dark-green font-bold' : '' ?>"
                      <?= $linkedPage?->isActive() ? 'aria-current="page"' : '' ?>>
                    <?= $item->label()->html() ?></a>
                </li>
              <?php endforeach ?>
            <?php else: ?>
              <?php foreach ($site->children()->listed() as $item): ?>
                <li>
                  <a
                      href ="<?= $item->url() ?>"
                      class="block px-3 py-1.5 text-sm font-medium no-underline rounded transition-colors hover:bg-light-bg<?= $item->isActive() ? ' text-dark-green font-bold' : '' ?>"
                      <?= $item->isActive() ? 'aria-current="page"' : '' ?>>
                    <?= $item->title()->html() ?></a>
                </li>
              <?php endforeach ?>
            <?php endif ?>
          </ul>
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
              <li>
                <a
                    href ="<?= $linkedPage ? $linkedPage->url() : '#' ?>"
                    class="block py-4 font-heading text-[clamp(1.5rem,5vw,2.5rem)] font-bold no-underline transition-colors hover:text-dark-green<?= $linkedPage?->isActive() ? ' text-dark-green' : '' ?>">
                  <?= $item->label()->html() ?></a>
              </li>
            <?php endforeach ?>
          <?php else: ?>
            <?php foreach ($site->children()->listed() as $item): ?>
              <li>
                <a
                    href ="<?= $item->url() ?>"
                    class="block py-4 font-heading text-[clamp(1.5rem,5vw,2.5rem)] font-bold no-underline transition-colors hover:text-dark-green<?= $item->isActive() ? ' text-dark-green' : '' ?>">
                  <?= $item->title()->html() ?></a>
              </li>
            <?php endforeach ?>
          <?php endif ?>
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
