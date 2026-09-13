<?php

/** @var \Kirby\Cms\Block $block */

$slides = $block->slides()->toStructure();
$images = [];
foreach ($slides as $slide) {
  if ($image = $slide->image()->toFile()) $images[] = [$image, $slide->caption()];
}

if ($images === []) return;

$blockId = 'image-marquee-' . $block->id();
$slideHeight = max(150, min(1000, $block->slideHeight()->or(400)->toInt()));
$renderTwice = count($images) <= 2;
static $splideAssetsLoaded = false;
?>

<?php if (!$splideAssetsLoaded): $splideAssetsLoaded = true; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/css/splide.min.css">
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4/dist/js/splide.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0/dist/js/splide-extension-auto-scroll.min.js"></script>
<?php endif ?>

<section
  id="<?= esc($blockId) ?>"
  class="image-marquee splide w-full"
  aria-label="Image slideshow"
  style="--image-marquee-height: <?= $slideHeight ?>px;"
>
  <div class="splide__track overflow-visible">
    <ul class="splide__list">
      <?php for ($set = 0; $set < ($renderTwice ? 2 : 1); $set++):
        foreach ($images as [$image, $caption]): ?>
          <li class="splide__slide group relative h-(--image-marquee-height) w-[min(82vw,38rem)] overflow-hidden border border-black md:w-[min(55vw,42rem)]">
            <img
              src="<?= esc($image->url()) ?>"
              alt="<?= esc($image->alt()->or($caption)->value()) ?>"
              class="size-full object-cover"
              width="<?= $image->width() ?>"
              height="<?= $image->height() ?>"
              loading="lazy"
            >
            <?php if ($caption->isNotEmpty()): ?><div class="absolute inset-x-4 bottom-4 max-w-[min(50%,24rem)] translate-y-full border border-black bg-dark-green p-4 text-sm text-off-white opacity-0 transition-[translate,opacity] duration-300 ease-in-out group-hover:translate-y-0 group-hover:opacity-100">
                <?= $caption->kt() ?>
              </div><?php endif ?>
          </li>
        <?php endforeach;
      endfor ?>
    </ul>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var element = document.getElementById(<?= json_encode($blockId) ?>);
    if (!element || typeof Splide === 'undefined') return;

    new Splide(element, {
      type: 'loop',
      focus: 'center',
      drag: 'free',
      autoWidth: true,
      arrows: false,
      pagination: false,
      gap: '2rem',
      autoScroll: {
        speed: 0.45,
        pauseOnHover: false,
        pauseOnFocus: false,
      },
    }).mount(window.splide.Extensions);
  });
</script>
