<?php

use Vanderlee\Syllable\Syllable;

Kirby::plugin('schmoll-studio/hyphenation', [
  'fieldMethods' => [
    'hyph' => function ($field, $lang = null) {
      $lang = $lang ?? option('hyphenation.language', 'de');
      $text = $field->kt(); // Process KirbyText first
      $minPartLength = max(2, (int)option('hyphenation.minPartLength', 3));

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
        function ($match) use ($syllable, $minPartLength) {
          $hyphenated = $syllable->hyphenateText($match[0]);

          return preg_replace_callback(
            '/(?<![\p{L}])([\p{L}]+(?:&shy;[\p{L}]+)+)(?![\p{L}])/u',
            function ($word) use ($minPartLength) {
              // Merge each too-short syllable into its neighbour instead of
              // discarding all break points for the whole word.
              $parts = explode('&shy;', $word[1]);
              $merged = [];
              $buffer = '';
              foreach ($parts as $part) {
                $buffer .= $part;
                if (mb_strlen($buffer) >= $minPartLength) {
                  $merged[] = $buffer;
                  $buffer = '';
                }
              }
              if ($buffer !== '') { // too-short trailing fragment
                if ($merged) $merged[count($merged) - 1] .= $buffer;
                else $merged[] = $buffer;
              }

              return implode('&shy;', $merged);
            },
            $hyphenated
          );
        },
        $text
     );

      return $text;
    }
  ]
]);