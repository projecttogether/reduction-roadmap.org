<footer class="bg-off-white border-t border-light-bg py-8">
  <div class="max-w-[1100px] mx-auto flex flex-wrap items-center justify-between gap-8">

    <nav aria-label="Footer navigation">
      <ul class="flex flex-wrap gap-x-8 gap-y-2 list-none m-0 p-0 text-sm" role="list">
        <?php if ($site->footerNavigation()->isNotEmpty()): ?>
          <?php foreach ($site->footerNavigation()->toStructure() as $item): ?>
            <?php $linkedPage = $item->link()->toPage() ?>
            <li>
              <a href="<?= $linkedPage ? $linkedPage->url() : '#' ?>" class="no-underline transition-colors hover:text-dark-green">
                <?= $item->label()->html() ?>
              </a>
            </li>
          <?php endforeach ?>
        <?php else: ?>
          <?php if ($about = page('about')): ?>
            <li><a href="<?= $about->url() ?>" class="no-underline transition-colors hover:text-dark-green">About</a></li>
          <?php endif ?>
          <?php if ($contact = page('contact')): ?>
            <li><a href="<?= $contact->url() ?>" class="no-underline transition-colors hover:text-dark-green">Contact</a></li>
          <?php endif ?>
          <?php if ($privacy = page('privacy')): ?>
            <li><a href="<?= $privacy->url() ?>" class="no-underline transition-colors hover:text-dark-green">Privacy policy</a></li>
          <?php endif ?>
        <?php endif ?>
      </ul>
    </nav>

    <div class="flex gap-4">
      <?php if ($site->socialLinkedin()->isNotEmpty()): ?>
        <a href="<?= $site->socialLinkedin()->esc() ?>" class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-black-green text-off-white transition-all hover:bg-dark-green hover:scale-105" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
          <svg class="w-[22px] h-[22px] fill-current" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
          </svg>
        </a>
      <?php endif ?>
      <?php if ($site->socialInstagram()->isNotEmpty()): ?>
        <a href="<?= $site->socialInstagram()->esc() ?>" class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-black-green text-off-white transition-all hover:bg-dark-green hover:scale-105" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
          <svg class="w-[22px] h-[22px] fill-current" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
          </svg>
        </a>
      <?php endif ?>
    </div>

  </div>
</footer>

</body>
</html>
