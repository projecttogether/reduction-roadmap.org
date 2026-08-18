<?php

use Kirby\Cms\Find;
use SchmollStudio\BestPractices\BestPracticesProjectConversion;

return [
  'buttons' => [
    'convertBestPracticeSubmission' => function (\Kirby\Cms\Page $page) {
      // intendedTemplate(), because no matching template file exists
      if ($page->intendedTemplate()->name() !== 'best-practice-submission' || $page->convertedProject()->isNotEmpty()) return null;
      return [
        'component' => 'k-view-button',
        'icon' => 'copy',
        'text' => 'Convert to project',
        'dialog' => 'best-practices/convert/' . $page->id(),
      ];
    },
  ],
  'dialogs' => [
    'best-practices.convert' => [
      'pattern' => 'best-practices/convert/(:all)',
      'load' => function (string $id) {
        $submission = Find::page($id);
        if ($submission === null || $submission->intendedTemplate()->name() !== 'best-practice-submission') {
          throw new \Kirby\Exception\NotFoundException('Best Practices submission not found.');
        }
        return [
          'component' => 'k-remove-dialog',
          'props' => [
            'text' => 'Create a draft Best Practice Project from this submission? The original submission will be kept for reference.',
            'submitButton' => 'Convert to project',
            'icon' => 'copy',
          ],
        ];
      },
      'submit' => function (string $id) {
        $project = BestPracticesProjectConversion::convert(Find::page($id));
        return ['redirect' => $project->panel()->url(true)];
      },
    ],
  ],
];
