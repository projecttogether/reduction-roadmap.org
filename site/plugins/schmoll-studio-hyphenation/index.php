<?php

use Vanderlee\Syllable\Syllable;

Kirby::plugin('schmoll-studio/hyphenation', [
  'fieldMethods' => [
    'hyph' => function ($field, $lang = null) {
      $lang = $lang ?? option('hyphenation.language', 'de');
      $text = $field->kt(); // Process KirbyText first

      // TeX-based hyphenation via vanderlee/syllable
      // Set cache directory before constructing (constructor triggers language load)
      $cacheDir = kirby()->root('cache') . '/hyphenation';
      if (!is_dir($cacheDir)) mkdir($cacheDir, 0755, true);
      Syllable::setCacheDir($cacheDir);

      $syllable = new Syllable($lang);
      $syllable->setHyphen(new \Vanderlee\Syllable\Hyphen\Soft()); // &shy;
      $syllable->setMinWordLength(6); // Only hyphenate words with 6+ chars

      // Only hyphenate text content inside HTML, not tags/attributes
      $text = preg_replace_callback(
        '/(?<=>)[^<]+(?=<)/',
        fn($match) => $syllable->hyphenateText($match[0]),
        $text
     );

      return $text;
    }
  ]
]);