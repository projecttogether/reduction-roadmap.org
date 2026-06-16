<?php snippet('header') ?>

<main id="page">
  <section class="py-16 bg-off-white">
    <div class="container">
      <h1 class="font-heading font-black text-[clamp(2rem,5vw,3.5rem)] leading-[1.1] mb-8">Page not found</h1>
      <p class="mb-8">The page you were looking for could not be found.</p>
      <a href="<?= $site->url() ?>" class="btn btn-primary">Return Home</a>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
