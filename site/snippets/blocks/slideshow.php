<?php

///// Setup /////
/////////////////

$slides = $block->slides()->toStructure();
$blockId = 'splide-' . $block->id();

if ($slides->isEmpty()) return;

static $splideAssetsLoaded = false;

///// Markup /////
////////////////// ?>

<?php if (!$splideAssetsLoaded): $splideAssetsLoaded = true; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/css/splide.min.css">
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js"></script>
<?php endif ?>

<section class="py-8">
  <div id="<?= esc($blockId) ?>" class="splide" aria-label="Slideshow">
    <div class="splide__track">
      <ul class="splide__list">
        <?php foreach ($slides as $slide): ?>
          <?php if ($image = $slide->image()->toFile()): ?>
            <li class="splide__slide">
              <figure>
                <img
                  class="w-full max-h-[70vh] object-cover block"
                  src="<?= $image->url() ?>"
                  alt="<?= $slide->caption()->or($image->alt())->html() ?>"
                  width="<?= $image->width() ?>"
                  height="<?= $image->height() ?>"
                  loading="lazy"
                >
                <?php if ($slide->caption()->isNotEmpty()): ?>
                  <figcaption class="text-sm text-center mt-2 text-gray-600">
                    <?= $slide->caption()->html() ?>
                  </figcaption>
                <?php endif ?>
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
        type: 'loop',
        perPage: 1,
        arrows: true,
        pagination: true,
      }).mount();
    }
  });
</script>
