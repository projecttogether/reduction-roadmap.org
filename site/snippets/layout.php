<?php if ($page->layout()->isNotEmpty()): ?>
        <?php foreach ($page->layout()->toLayouts() as $layout): ?>
                <?php $colCount = $layout->columns()->count() ?>
                <section class="py-16 bg-off-white">
                  <div class="container">
                    <div class="grid gap-8 <?= match($colCount) { 2 => 'grid-cols-1 md:grid-cols-2', 3 => 'grid-cols-1 md:grid-cols-3', default => 'grid-cols-1' } ?>">
                      <?php foreach ($layout->columns() as $column): ?>
                              <div class="min-w-0 flex flex-col gap-8">
                                <?= $column->blocks() ?>
                              </div>
                      <?php endforeach ?>
                    </div>
                  </div>
                </section>
        <?php endforeach ?>
<?php endif ?>
