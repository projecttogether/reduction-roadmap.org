<?php

///// Setup /////
/////////////////

$slides      = $block->slides()->toStructure();
$blockId     = 'splide-' . $block->id();
$aspectRatio = $block->aspect_ratio()->or('3/2')->value();
$perPage     = (int) $block->per_page()->or(4)->value();

if ($slides->isEmpty()) return;

// Shared static guard with the regular slideshow block
static $splideAssetsLoaded = false;

///// Markup /////
////////////////// ?>

<?php if (!$splideAssetsLoaded): $splideAssetsLoaded = true; ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/css/splide.min.css">
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0/dist/js/splide-extension-auto-scroll.min.js"></script>
<?php endif ?>

<section class="py-8">
  <div id="<?= esc($blockId) ?>" class="splide" aria-label="Logo Slideshow">
    <div class="splide__track">
      <ul class="splide__list">
        <?php foreach ($slides as $slide): ?>
          <?php if ($logo = $slide->logo()->toFile()): ?>
            <?php $alt = $slide->alt()->or($logo->alt())->html() ?>
            <li class="splide__slide">
              <figure
                class ="w-full overflow-hidden"
                style ="aspect-ratio: <?= esc($aspectRatio) ?>">
                <img
                  class ="w-full h-full object-contain block"
                  src   ="<?= $logo->url() ?>"
                  alt   ="<?= $alt ?>"
                  loading="lazy"
                >
              </figure>
            </li>
          <?php endif ?>
        <?php endforeach ?>
      </ul>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById(<?= json_encode($blockId) ?>);
    if (el) {
      new Splide(el, {
        type      : 'loop',
        drag      : 'free',
        perPage   : <?= json_encode($perPage) ?>,
        gap       : '4rem',
        arrows    : false,
        pagination: false,
        autoScroll: {
          speed       : 1,
          pauseOnHover: true,
        },

        breakpoints: {
          768: { perPage: Math.min(<?= json_encode($perPage) ?>, 3) },
          480: { perPage: 2 },
        },
      }).mount(window.splide.Extensions);
    }
  });
</script>
