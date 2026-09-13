<?php

/** @var \Kirby\Cms\Block $block */

$status = get('submission-status');
$parent = $block->parent()->toPage() ?? site()->find('best-practices');
$intro = $block->intro()->or(null);
$triggerLabel = $block->triggerLabel()->or('Submit new project');
$submitLabel = $block->submitLabel()->or('Projekt einreichen');

if ($parent === null) return;

$formOpen = $status === 'error';

$args_field_title = [
  'label' => 'Projekttitel',
  'name' => 'title',
  'type' => 'text',
  'autocomplete' => 'off',
  'placeholder' => 'Name des Projekts',
];
$args_field_sponsor = [
  'label' => 'Projektträger:in oder Auftraggeber:in',
  'name' => 'projectSponsor',
  'type' => 'text',
  'placeholder' => 'Hauptverantwortliche Organisation',
];
$args_field_organizations = [
  'label' => 'Beteiligte Organisationen',
  'name' => 'participatingOrganizations',
  'rows' => 4,
  'placeholder' => 'Planungsbüros, Bauunternehmen, Kooperationspartner',
  'required' => false,
];
$args_field_status = [
  'label' => 'Projektstatus',
  'name' => 'projectStatus',
  'options' => [
    'planning' => 'In Planung',
    'under-construction' => 'Im Bau',
    'completed' => 'Fertiggestellt',
  ],
];
$args_field_period = [
  'label' => 'Projektzeitraum',
  'name' => 'projectPeriod',
  'type' => 'text',
  'placeholder' => '2019 - 2024; Fertigstellung geplant für 2027',
  'required' => false,
];
$args_field_building_use = [
  'label' => 'Gebäudenutzung',
  'name' => 'buildingUse',
  'options' => [
    'residential' => 'Wohngebäude',
    'non-residential' => 'Nichtwohngebäude',
    'neighborhood' => 'Quartier oder Siedlung',
    'mixed' => 'Gemischte Nutzung',
    'other' => 'Andere Nutzung',
  ],
];
$args_field_area = [
  'label' => 'Brutto-Grundfläche (BGF) des Projekts in m²',
  'name' => 'grossFloorArea',
  'type' => 'number',
  'placeholder' => '36000',
  'required' => false,
];
$args_field_target = [
  'label' => 'THG-Zielwert in der Planung in kgCO₂e/m²a',
  'name' => 'thgTarget',
  'options' => [
    'below-10' => 'Unter 10',
    '10-20' => '10 bis unter 20',
    '20-30' => '20 bis unter 30',
    '30-plus' => '30 oder mehr',
    'none' => 'Kein Zielwert festgelegt',
    'unknown' => 'Unbekannt',
  ],
];
$args_field_value = [
  'label' => 'THG-Kennwert bei Projektabschluss in kgCO₂e/m²a',
  'name' => 'thgValue',
  'type' => 'text',
  'placeholder' => '23,4',
  'required' => false,
];
$args_field_area_reference = [
  'label' => 'Flächenbezug der angegebenen THG-Werte',
  'name' => 'areaReference',
  'options' => [
    'gross-floor-area' => 'Brutto-Grundfläche (BGF)',
    'net-room-area' => 'Nettoraumfläche (NRF)',
    'living-area' => 'Wohnfläche (WoFl)',
    'usable-area' => 'Nutzfläche (NUF)',
    'other' => 'Andere',
    'unknown' => 'Nicht bekannt',
  ],
];
$args_field_name = [
  'label' => 'Dein Name',
  'name' => 'submitterName',
  'type' => 'text',
  'autocomplete' => 'name',
  'placeholder' => 'Vor- und Nachname',
];
$args_field_email = [
  'label' => 'E-Mail-Adresse',
  'name' => 'submitterEmail',
  'type' => 'email',
  'autocomplete' => 'email',
  'placeholder' => 'name@beispiel.org',
];
$args_field_location = [
  'label' => 'Projektstandort',
  'name' => 'location',
  'type' => 'text',
  'autocomplete' => 'address-level2',
  'placeholder' => 'Stadt, Land',
];
$args_field_role = [
  'label' => 'Deine Funktion oder Bezug zum Projekt',
  'name' => 'submitterRole',
  'type' => 'text',
  'placeholder' => 'Bauherr:in, Projektbeteiligte:r, Kooperationspartner',
  'required' => false,
];
$args_field_organization = [
  'label' => 'Deine Organisation oder Institution',
  'name' => 'submitterOrganization',
  'type' => 'text',
  'placeholder' => 'Name der Organisation',
  'required' => false,
];
$args_field_phone = [
  'label' => 'Deine Telefonnummer',
  'name' => 'submitterPhone',
  'type' => 'tel',
  'autocomplete' => 'tel',
  'placeholder' => '+49 015 12345678',
  'required' => false,
];
$args_field_construction = [
  'label' => 'Baumaßnahme',
  'name' => 'constructionType',
  'options' => [
    'new-build' => 'Neubau',
    'existing-building' => 'Bauen im Bestand',
    'combined' => 'Kombination mehrerer Maßnahmen',
    'other' => 'Andere Maßnahme',
  ],
];
$args_field_source = [
  'label' => 'Projektwebseite oder andere Quelle',
  'name' => 'sourceUrl',
  'type' => 'url',
  'autocomplete' => 'url',
  'placeholder' => 'https://',
  'required' => false,
];
$args_field_description = [
  'label' => 'Projektbeschreibung',
  'name' => 'description',
  'rows' => 7,
  'placeholder' => 'Besondere Lösung, Materialität und Bauweise, Ambitionsniveau oder Learning. Maximal 100 Wörter.',
];
$args_field_internal_notes = [
  'label' => 'Hinweise und Ergänzungen',
  'name' => 'internalNotes',
  'rows' => 5,
  'placeholder' => 'Nur für das Roadmap Germany Team bestimmte Hinweise',
  'required' => false,
];
$args_field_submit_permission = [
  'label' => 'Ich darf die Angaben zur fachlichen Prüfung an die Roadmap Germany übermitteln.',
  'name' => 'submitPermission',
  'options' => ['yes' => 'Ja'],
];
$args_field_image_rights = [
  'label' => 'Falls ich Bilder hochgeladen habe, liegen die erforderlichen Rechte zur Weitergabe vor.',
  'name' => 'imageRights',
  'options' => ['yes' => 'Ja'],
  'required' => false,
];
$args_field_contact_permission = [
  'label' => 'Dürfen wir Dich bei Rückfragen kontaktieren?',
  'name' => 'contactPermission',
  'options' => ['yes' => 'Ja', 'no' => 'Nein'],
];
$args_btn = [
  'label' => $submitLabel->html(),
  'is_link' => false,
  'type' => 'submit',
  'size' => 'md',
];
?>

<div
  id="best-practices-submission-<?= esc($block->id()) ?>"
  class="best-practices-submission-form flex flex-col gap-8"
>
  <?php if ($intro && $intro->isNotEmpty()): ?>
    <div class="text-base leading-relaxed text-dark-green/80">
      <?= $intro->kt() ?>
    </div>
  <?php endif ?>

  <?php if ($status === 'success'): ?>
    <?php snippet('notifications/alert', ['type' => 'success', 'message' => 'Vielen Dank! Deine Einreichung wurde übermittelt und wird nun geprüft.']) ?>
  <?php elseif ($status === 'success-email-error'): ?>
    <?php snippet('notifications/alert', ['type' => 'warning', 'message' => 'Deine Einreichung wurde erfolgreich gespeichert und wird nun geprüft. Die Benachrichtigungs-E-Mail konnte jedoch nicht versendet werden.']) ?>
  <?php elseif ($status === 'error'): ?>
    <?php snippet('notifications/alert', ['type' => 'error', 'message' => 'Beim Übermitteln ist ein Fehler aufgetreten. Bitte überprüfe deine Angaben und versuche es erneut.']) ?>
  <?php endif ?>

  <?php if (!$formOpen): ?>
    <button
      type="button"
      class="flex w-fit items-center justify-center rounded bg-dark-green px-6 py-3 text-sm font-medium text-off-white transition-colors hover:bg-dark-green/65 focus:outline-none focus:ring-2 focus:ring-dark-green/30"
      data-submission-trigger
      aria-expanded="false"
      aria-controls="best-practices-submission-fields-<?= esc($block->id()) ?>"
    >
      <?= $triggerLabel->html() ?>
    </button>
  <?php endif ?>

  <form
    id="best-practices-submission-fields-<?= esc($block->id()) ?>"
    action="<?= esc(parse_url(url('best-practices-submission'), PHP_URL_PATH)) ?>"
    method="post"
    enctype="multipart/form-data"
    class="space-y-5"
    <?= $formOpen ? '' : 'hidden' ?>
    novalidate
  >
    <input type="hidden" name="csrf" value="<?= esc(csrf()) ?>">
    <input type="hidden" name="parent" value="<?= esc($parent->id()) ?>">

    <div class="hidden" aria-hidden="true">
      <label for="best-practices-submission-website">Website</label>
      <input id="best-practices-submission-website" name="website" type="text" tabindex="-1" autocomplete="off">
    </div>

    <p class="text-sm leading-relaxed text-dark-green/80">Die übermittelten Informationen werden nach Prüfung und gesonderter Freigabe auf der Website erscheinen.</p>
    <h2 class="font-heading text-2xl font-bold text-black-green">Teil A: Angaben zum Praxisbeispiel</h2>
    <?php snippet('form-fields/input', $args_field_title) ?>

    <div class="grid gap-5 md:grid-cols-2">
      <?php snippet('form-fields/input', $args_field_sponsor) ?>
      <?php snippet('form-fields/select', $args_field_status) ?>
      <?php snippet('form-fields/input', $args_field_period) ?>
      <?php snippet('form-fields/input', $args_field_location) ?>
      <?php snippet('form-fields/select', $args_field_construction) ?>
      <?php snippet('form-fields/select', $args_field_building_use) ?>
      <?php snippet('form-fields/input', $args_field_area) ?>
      <?php snippet('form-fields/select', $args_field_target) ?>
      <?php snippet('form-fields/input', $args_field_value) ?>
      <?php snippet('form-fields/select', $args_field_area_reference) ?>
      <?php snippet('form-fields/input', $args_field_source) ?>
    </div>

    <?php snippet('form-fields/textarea', $args_field_organizations) ?>
    <?php snippet('form-fields/textarea', $args_field_description) ?>

    <label class="block">
      <span class="mb-2 block text-sm font-medium text-dark-green">Darstellungen oder Bilder vom Projekt</span>
      <input type="file" name="projectImages[]" multiple accept="image/*" class="block w-full rounded-md border border-slate-300 bg-off-white px-4 py-3 text-base text-black-green">
      <span class="mt-2 block text-sm text-dark-green/70">Bitte nur Bilder hochladen, deren Weitergabe erlaubt ist. Fotograf:in, Bildquelle und gewünschte Bildunterschrift bitte im Hinweisfeld angeben.</span>
    </label>

    <h2 class="font-heading text-2xl font-bold text-black-green">Teil B: Kontakte und interne Hinweise</h2>
    <p class="text-sm leading-relaxed text-dark-green/80">Diese Angaben dienen ausschließlich der Rückfrage und internen Bearbeitung. Sie werden nicht auf der Website veröffentlicht.</p>
    <div class="grid gap-5 md:grid-cols-2">
      <?php snippet('form-fields/input', $args_field_name) ?>
      <?php snippet('form-fields/input', $args_field_role) ?>
      <?php snippet('form-fields/input', $args_field_organization) ?>
      <?php snippet('form-fields/input', $args_field_email) ?>
      <?php snippet('form-fields/input', $args_field_phone) ?>
    </div>

    <?php snippet('form-fields/select', $args_field_submit_permission) ?>
    <?php snippet('form-fields/select', $args_field_image_rights) ?>
    <?php snippet('form-fields/select', $args_field_contact_permission) ?>
    <?php snippet('form-fields/textarea', $args_field_internal_notes) ?>

    <div>
      <?php snippet('btn', $args_btn) ?>
    </div>
  </form>
</div>

<?php snippet('best-practices/submission-form-toggle', ['blockId' => $block->id()]) ?>
