<?php

namespace SchmollStudio\BestPractices;

use Kirby\Cms\Page;

/**
 * Page model for best-practice-project pages.
 *
 * Submissions store raw option keys (e.g. "new-build", "residential",
 * "10-20"). These helpers turn those keys into the human-readable German
 * labels used by the public project card, the single-project template and
 * the filter bar, so there is a single source of truth for the mapping.
 */
class BestPracticeProjectPage extends Page
{
  public const BUILDING_USE_LABELS = [
    'residential'     => 'Wohngebäude',
    'non-residential' => 'Nichtwohngebäude',
    'neighborhood'    => 'Quartier oder Siedlung',
    'mixed'           => 'Gemischte Nutzung',
    'other'           => 'Andere Nutzung',
  ];

  public const CONSTRUCTION_TYPE_LABELS = [
    'new-build'         => 'Neubau',
    'existing-building' => 'Bauen im Bestand',
    'combined'          => 'Kombination mehrerer Maßnahmen',
    'other'             => 'Andere Maßnahme',
  ];

  public const THG_RANGE_LABELS = [
    'below-10' => 'Unter 10 kgCO₂e/m²a',
    '10-20'    => '10–20 kgCO₂e/m²a',
    '20-30'    => '20–30 kgCO₂e/m²a',
    '30-plus'  => '30+ kgCO₂e/m²a',
    'none'     => 'Kein Zielwert',
    'unknown'  => 'Unbekannt',
  ];

  /** Ranges that represent an actual CO₂ figure worth showing as a tag. */
  public const THG_NUMERIC_RANGES = ['below-10', '10-20', '20-30', '30-plus'];

  public function buildingUseLabel(): string
  {
    $key = (string)$this->buildingUse()->value();
    return self::BUILDING_USE_LABELS[$key] ?? $key;
  }

  public function constructionTypeLabel(): string
  {
    $key = (string)$this->constructionType()->value();
    return self::CONSTRUCTION_TYPE_LABELS[$key] ?? $key;
  }

  public function thgRangeLabel(): string
  {
    $key = (string)$this->thgTarget()->value();
    return self::THG_RANGE_LABELS[$key] ?? '';
  }

  /** Only true for ranges that carry a meaningful CO₂ figure. */
  public function hasThgRange(): bool
  {
    return in_array((string)$this->thgTarget()->value(), self::THG_NUMERIC_RANGES, true);
  }

  /** Gross floor area formatted for display, e.g. "36.000 m²". */
  public function displayArea(): string
  {
    $raw = trim((string)$this->grossFloorArea()->value());
    if ($raw === '') return '';

    $normalized = str_replace(' ', '', $raw);
    if (str_contains($normalized, ',') && str_contains($normalized, '.')) {
      $normalized = str_replace('.', '', $normalized);
      $normalized = str_replace(',', '.', $normalized);
    } elseif (str_contains($normalized, ',')) {
      $normalized = str_replace(',', '.', $normalized);
    }

    $value = (float)$normalized;
    return $value > 0 ? number_format($value, 0, ',', '.') . ' m²' : '';
  }

  /** External source link, falling back to this project page. */
  public function detailUrl(): string
  {
    return $this->sourceUrl()->isNotEmpty() ? $this->sourceUrl()->value() : $this->url();
  }

  public function hasExternalDetail(): bool
  {
    return $this->sourceUrl()->isNotEmpty();
  }
}
