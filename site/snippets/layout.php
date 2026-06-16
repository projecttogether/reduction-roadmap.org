<?php if ($page->layout()->isNotEmpty()): ?>
  <?php foreach ($page->layout()->toLayouts() as $layout): ?>
    <?php $colCount = $layout->columns()->count() ?>
    <section class="section section--white">
      <div class="container">
        <div class="layout layout--<?= $colCount === 1 ? 'single' : 'two-col' ?>">
          <?php foreach ($layout->columns() as $column): ?>
            <?php $widthClass = str_replace('/', '-', (string)$column->width()) ?>
            <div class="layout__column layout__column--<?= $widthClass ?>">
              <?= $column->blocks() ?>
            </div>
          <?php endforeach ?>
        </div>
      </div>
    </section>
  <?php endforeach ?>
<?php endif ?>
