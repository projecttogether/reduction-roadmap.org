<?php

namespace SchmollStudio\BestPractices;

use Kirby\Cms\Page;
use RuntimeException;

class BestPracticesProjectConversion
{
  public static function convert(Page $submission): Page
  {
    if ($submission->intendedTemplate()->name() !== 'best-practice-submission') throw new RuntimeException('Only Best Practices submissions can be converted.');
    if ($submission->convertedProject()->isNotEmpty()) throw new RuntimeException('This submission has already been converted.');

    $parent = $submission->parent();
    $project = $parent->createChild([
      'slug' => static::uniqueSlug($parent, $submission->title()->value()),
      'template' => 'best-practice-project',
      'content' => [
        'title' => $submission->title()->value(),
        'location' => $submission->location()->value(),
        'year' => $submission->projectPeriod()->value(),
        'area' => $submission->grossFloorArea()->value(),
        'function' => $submission->buildingUse()->value(),
        'constructionType' => $submission->constructionType()->value(),
        'co2Range' => $submission->thgTarget()->value() === '30-plus' ? 'above-30' : $submission->thgTarget()->value(),
        'co2Value' => $submission->thgValue()->value(),
        'description' => $submission->description()->value(),
        'detailLink' => $submission->sourceUrl()->value(),
      ],
    ]);

    $submission->update(['convertedProject' => $project->id()]);
    return $project;
  }

  protected static function uniqueSlug(Page $parent, string $title): string
  {
    $base = \Kirby\Toolkit\Str::slug($title) ?: 'project';
    $slug = $base;
    $counter = 1;
    while ($parent->children()->find($slug)) $slug = $base . '-' . $counter++;
    return $slug;
  }
}
