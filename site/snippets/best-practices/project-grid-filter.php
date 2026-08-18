<?php

/** @var string $blockId */

$blockId ??= '';
?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const grid = document.getElementById('<?= esc($blockId) ?>');

    if (!grid) return;

    const filters = [...grid.querySelectorAll('[data-filter]')];
    const projects = [...grid.querySelectorAll('.best-practices-project')];
    const emptyState = grid.querySelector('[data-empty-results]');

    function updateProjects() {
      const activeFilters = Object.fromEntries(
        filters.map((filter) => [filter.dataset.filter, filter.value])
      );
      let visibleCount = 0;

      projects.forEach((project) => {
        const matches = Object.entries(activeFilters).every(([key, value]) => {
          return value === '' || project.dataset[key] === value;
        });

        project.hidden = !matches;
        visibleCount += matches ? 1 : 0;
      });

      emptyState.hidden = visibleCount !== 0;
    }

    filters.forEach((filter) => filter.addEventListener('change', updateProjects));
    updateProjects();
  });
</script>
