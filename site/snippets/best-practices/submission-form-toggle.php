<?php

/** @var string $blockId */

$blockId ??= '';
?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const root = document.getElementById('best-practices-submission-<?= esc($blockId) ?>');

    if (!root) return;

    const trigger = root.querySelector('[data-submission-trigger]');
    const form = root.querySelector('form');

    if (!trigger || !form) return;

    trigger.addEventListener('click', function () {
      const isOpen = form.hidden === false;
      form.hidden = isOpen;
      trigger.setAttribute('aria-expanded', String(!isOpen));

      if (isOpen === false) {
        form.querySelector('input:not([type="hidden"]), textarea, select')?.focus();
      }
    });
  });
</script>
