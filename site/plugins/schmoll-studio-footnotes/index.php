<?php

use Kirby\Text\KirbyTag;

Kirby::plugin('schmoll-studio/footnotes', [
  'tags' => [
    'footnote' => [
      'attr' => [],
      'html' => function (KirbyTag $tag): string {
        $number = trim((string)$tag->value);
        if ($number === '' || preg_match('/^\d+$/', $number) !== 1) return '';

        $id = 'footnote-' . $number;
        $escapedId = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
        $escapedNumber = htmlspecialchars($number, ENT_QUOTES, 'UTF-8');
        return '<sup class="footnote-marker"><a href="#' . $escapedId . '" aria-label="Footnote ' . $escapedNumber . '">' . $escapedNumber . '</a></sup>';
      },
    ],
    'fn' => [
      'attr' => [],
      'html' => function (KirbyTag $tag): string {
        $number = trim((string)$tag->value);
        if ($number === '' || preg_match('/^\d+$/', $number) !== 1) return '';

        $id = 'footnote-' . $number;
        $escapedId = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
        $escapedNumber = htmlspecialchars($number, ENT_QUOTES, 'UTF-8');
        return '<sup class="footnote-marker"><a href="#' . $escapedId . '" aria-label="Footnote ' . $escapedNumber . '">' . $escapedNumber . '</a></sup>';
      },
    ],
  ],
]);
