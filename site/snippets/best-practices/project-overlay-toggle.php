<?php

/** @var string $blockId */

$blockId ??= '';
?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var grid = document.getElementById('<?= esc($blockId) ?>');
    var overlay = document.getElementById('best-practices-overlay-<?= esc($blockId) ?>');

    if (!grid || !overlay) return;

    var backdrop = overlay.querySelector('[data-overlay-backdrop]');
    var panel = overlay.querySelector('[data-overlay-panel]');
    var scrollArea = overlay.querySelector('[data-overlay-scroll]');
    var sections = overlay.querySelectorAll('[data-overlay-project]');
    var closeButton = overlay.querySelector('[data-overlay-close]');

    var isOpen = false;
    var hideTimer = null;
    var lastFocused = null;

    function focusable() {
      return Array.prototype.filter.call(
        panel.querySelectorAll('a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])'),
        function (el) { return el.offsetParent !== null; }
      );
    }

    function open(card) {
      // Remember what to hand focus back to when the panel closes.
      lastFocused = card.querySelector('[data-project-more]') || card;

      // Reveal this project's section and hide the others. The dialog has no
      // single static heading, so it is labelled from the card instead.
      var projectId = card.dataset.projectId;
      Array.prototype.forEach.call(sections, function (section) {
        section.hidden = section.dataset.overlayProject !== projectId;
      });
      panel.setAttribute('aria-label', card.dataset.projectTitle || 'Projektdetails');
      scrollArea.scrollTop = 0;

      window.clearTimeout(hideTimer);
      overlay.hidden = false;
      void overlay.offsetWidth; // force a reflow so the transition actually runs

      backdrop.classList.remove('opacity-0');
      backdrop.classList.add('opacity-100');
      panel.classList.remove('translate-x-full');
      panel.classList.add('translate-x-0');
      document.body.classList.add('overflow-hidden');

      isOpen = true;
      closeButton.focus();
    }

    function close() {
      if (!isOpen) return;
      isOpen = false;

      backdrop.classList.remove('opacity-100');
      backdrop.classList.add('opacity-0');
      panel.classList.remove('translate-x-0');
      panel.classList.add('translate-x-full');
      document.body.classList.remove('overflow-hidden');

      // Timer rather than transitionend: with reduced motion there is no
      // transition and the event would never fire, leaving the panel in the
      // accessibility tree.
      window.clearTimeout(hideTimer);
      hideTimer = window.setTimeout(function () {
        if (!isOpen) overlay.hidden = true;
      }, 300);

      if (lastFocused) lastFocused.focus();
    }

    grid.addEventListener('click', function (event) {
      if (event.target.closest('a')) return; // let real links through

      var card = event.target.closest('[data-project-trigger]');
      if (!card || !grid.contains(card)) return;

      event.preventDefault();
      open(card);
    });

    closeButton.addEventListener('click', close);
    backdrop.addEventListener('click', close);

    document.addEventListener('keydown', function (event) {
      if (!isOpen) return;

      if (event.key === 'Escape') {
        event.preventDefault();
        close();
        return;
      }

      if (event.key !== 'Tab') return;

      // Keep focus inside the dialog while it is open.
      var items = focusable();
      if (items.length === 0) return;

      var first = items[0];
      var last = items[items.length - 1];

      if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
      } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
      }
    });
  });
</script>
