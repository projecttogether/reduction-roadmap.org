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

    <div class="hidden border border-red-300 bg-red-50 px-4 py-4 text-sm text-red-900" data-submission-errors role="alert" tabindex="-1">
      <p class="font-bold">Bitte überprüfe die folgenden Angaben:</p>
      <ul class="mt-2 list-disc pl-5" data-submission-error-list></ul>
    </div>

    <details class="group border border-dark-green/20 bg-off-white">
      <summary class="cursor-pointer list-none px-5 py-4 font-heading text-2xl font-bold text-black-green marker:hidden">
        Teil A: Angaben zum Praxisbeispiel
        <span class="float-right flex items-center gap-3">
          <span class="inline-flex size-6 items-center justify-center rounded-full border-2 border-slate-300 text-transparent transition-colors" data-section-valid aria-label="Teil A ist noch nicht vollständig">
            <svg class="size-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
              <path d="M3 8.5 6.25 12 13 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span class="transition-transform group-open:rotate-180" aria-hidden="true">⌄</span>
        </span>
      </summary>
      <div class="space-y-5 border-t border-dark-green/20 px-5 py-5">
        <p class="text-sm leading-relaxed text-dark-green/80">Die übermittelten Informationen werden nach Prüfung und gesonderter Freigabe auf der Website erscheinen.</p>
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
      </div>
    </details>

    <details class="group border border-dark-green/20 bg-off-white">
      <summary class="cursor-pointer list-none px-5 py-4 font-heading text-2xl font-bold text-black-green marker:hidden">
        Teil B: Kontakte und interne Hinweise
        <span class="float-right flex items-center gap-3">
          <span class="inline-flex size-6 items-center justify-center rounded-full border-2 border-slate-300 text-transparent transition-colors" data-section-valid aria-label="Teil B ist noch nicht vollständig">
            <svg class="size-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
              <path d="M3 8.5 6.25 12 13 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <span class="transition-transform group-open:rotate-180" aria-hidden="true">⌄</span>
        </span>
      </summary>
      <div class="space-y-5 border-t border-dark-green/20 px-5 py-5">
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
      </div>
    </details>

    <div>
      <?php snippet('btn', $args_btn) ?>
    </div>
  </form>
</div>

<?php snippet('best-practices/submission-form-toggle', ['blockId' => $block->id()]) ?>

<script>
  (function () {
    var form = document.getElementById('best-practices-submission-fields-<?= esc($block->id()) ?>');
    if (!form) return;

    var summary = form.querySelector('[data-submission-errors]');
    var errorList = form.querySelector('[data-submission-error-list]');
    var sections = Array.from(form.querySelectorAll('details'));

    function labelFor(field) {
      var label = field.closest('label');
      return label ? label.querySelector('span')?.textContent.trim() : field.name;
    }

    function clearErrors() {
      form.querySelectorAll('[aria-invalid="true"]').forEach(function (field) {
        field.removeAttribute('aria-invalid');
      });
      form.querySelectorAll('[data-field-error]').forEach(function (error) {
        error.remove();
      });
      summary.classList.add('hidden');
      errorList.replaceChildren();
    }

    function fieldMessage(field, includeOptional = false) {
      if (!includeOptional && !field.required) return '';
      if (field.required && !field.value.trim()) return 'Bitte fülle dieses Feld aus.';
      if (field.type === 'email' && field.value && !field.validity.valid) return 'Bitte gib eine gültige E-Mail-Adresse ein.';
      if (field.type === 'url' && field.value && !field.validity.valid) return 'Bitte gib eine gültige URL ein.';
      if (field.name === 'description' && field.value.trim().split(/\s+/).filter(Boolean).length > 100) return 'Maximal 100 Wörter erlaubt.';
      return '';
    }

    function sectionIsValid(section) {
      var fields = Array.from(section.querySelectorAll('input[required], select[required], textarea[required]'));
      var valid = fields.every(function (field) { return fieldMessage(field) === ''; });
      var fileInput = form.querySelector('input[type="file"][name="projectImages[]"]');
      var imageRights = form.querySelector('[name="imageRights"]');
      if (section.contains(imageRights) && fileInput?.files.length && !imageRights.value) valid = false;
      return valid;
    }

    function updateSectionStatus() {
      sections.forEach(function (section) {
        var indicator = section.querySelector('[data-section-valid]');
        if (!indicator) return;
        var valid = sectionIsValid(section);
        indicator.classList.toggle('border-green-700', valid);
        indicator.classList.toggle('bg-green-700', valid);
        indicator.classList.toggle('text-off-white', valid);
        indicator.classList.toggle('border-slate-300', !valid);
        indicator.classList.toggle('text-transparent', !valid);
        indicator.setAttribute('aria-label', valid ? 'Abschnitt vollständig ausgefüllt' : 'Abschnitt noch nicht vollständig');
      });
    }

    function validate() {
      clearErrors();
      var invalid = [];
      var fields = Array.from(form.querySelectorAll('input, select, textarea')).filter(function (field) {
        return field.name && field.name !== 'csrf' && field.name !== 'parent' && field.name !== 'website' && field.type !== 'file';
      });

      fields.forEach(function (field) {
        var message = fieldMessage(field);
        if (!message) return;

        field.setAttribute('aria-invalid', 'true');
        var error = document.createElement('p');
        error.dataset.fieldError = 'true';
        error.className = 'mt-2 text-sm text-red-700';
        error.textContent = message;
        field.closest('label')?.append(error);
        invalid.push({ field: field, label: labelFor(field), message: message });
      });

      var hasImages = form.querySelector('input[type="file"][name="projectImages[]"]')?.files.length > 0;
      var imageRights = form.querySelector('[name="imageRights"]');
      if (hasImages && imageRights && !imageRights.value) {
        imageRights.setAttribute('aria-invalid', 'true');
        invalid.push({ field: imageRights, label: labelFor(imageRights), message: 'Bitte bestätige die Bildrechte.' });
      }

      if (invalid.length) {
        invalid.forEach(function (item) {
          var li = document.createElement('li');
          li.textContent = item.label + ': ' + item.message;
          errorList.append(li);
          item.field.closest('details')?.setAttribute('open', '');
        });
        summary.classList.remove('hidden');
        summary.focus();
        invalid[0].field.scrollIntoView({ behavior: 'smooth', block: 'center' });
        invalid[0].field.focus({ preventScroll: true });
        return false;
      }

      return true;
    }

    form.addEventListener('input', updateSectionStatus);
    form.addEventListener('change', updateSectionStatus);
    updateSectionStatus();

    form.addEventListener('submit', function (event) {
      if (!validate()) event.preventDefault();
    });
  })();
</script>
