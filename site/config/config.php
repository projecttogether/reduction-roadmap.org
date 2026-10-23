<?php

// Config. of correct site URL //
////////////////////////////////////

$gitBranch = getenv('GIT_BRANCH') ?: (getenv('COOLIFY_BRANCH') ?: 'devel');
$siteUrl   = getenv('SITE_URL') ?: getenv('COOLIFY_URL');
if ($siteUrl === false || $siteUrl === '') {
  $host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? null;
  $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ($_SERVER['HTTPS'] ?? 'off');

  if ($scheme === 'https' || $scheme === 'on' || ($scheme !== 'http' && ($_SERVER['SERVER_PORT'] ?? 80) == 443)) {
    $scheme = 'https';
  } else {
    $scheme = 'http';
  }

  if ($host !== null && $host !== '') {
    $siteUrl = $scheme . '://' . $host;
  } else {
    $siteUrl = 'https://reduction-roadmap.de';
  }
}

$siteUrl = trim(explode(',', $siteUrl)[0]);

// Debug mode. //
////////////////////////////////////

// Debug output renders stack traces, file paths and source snippets to whoever
// triggers the error, so it must never be on for the public site. It defaults
// to off and is only enabled automatically for local development hosts.
// KIRBY_DEBUG=true|false overrides the detection, e.g. to inspect an error on a
// staging deployment or when developing on a custom local hostname.
$debugOverride = trim((string)getenv('KIRBY_DEBUG'));

if ($debugOverride !== '') {
  $debug = filter_var($debugOverride, FILTER_VALIDATE_BOOLEAN);
} else {
  $debugHost = (string)($_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '');
  $debugHost = trim(explode(',', $debugHost)[0]);
  $debugHost = strtolower(trim(preg_replace('/:\d+$/', '', $debugHost), '[]'));
  $debug     = in_array($debugHost, ['localhost', '127.0.0.1', '::1'], true)
    || str_ends_with($debugHost, '.test')
    || str_ends_with($debugHost, '.localhost');
}

// Kirby config. //
////////////////////////////////////

return [
  'debug' => $debug,
  'url'   => $siteUrl,
  'panel' => [
    'install' => true,
    'vue' => [
      'compiler' => false,
    ],
  ],
  'email' => [
    'transport' => [
      'type'     => 'smtp',
      'host'     => 'smtp.mailersend.net',
      'port'     => 587,
      'security' => 'tls',
      'auth'     => true,
      'username' => getenv('MAILERSEND_SMTP_USERNAME') ?: '',
      'password' => getenv('MAILERSEND_SMTP_PASSWORD') ?: '',
    ],
  ],

  'thathoff.git-content' => [
    'disable'       => !is_file('/run/git-content-ready'),
    // Point the plugin at the actual repo root. The git repo lives at the app
    // root (/var/www/html/.git), not in content/. Since content/ is a separate
    // mounted volume in production, git can no longer discover the repo by
    // walking up across the filesystem boundary, so we set the path explicitly.
    'path'          => dirname(__DIR__, 2),
    'pull'          => true,
    'push'          => true,
    'commit'        => true,
    // Content commits are pushed to the deploy branch, which would otherwise
    // trigger a full Coolify redeploy for every submission or panel save. The
    // push is still wanted as an off-site backup, the redeploy is not: content
    // persists on its own volume. The marker tells Coolify to skip deployment;
    // code pushes use normal messages and keep deploying as before.
    'commitMessage' => ':action:(:item:): :url: [skip ci]',
    'gitBin'        => '/usr/bin/git',
    'author'        => 'Johannes Schmoll <johannes@schmoll.studio>',
    'branch'        => $gitBranch,
  ],
  
  'hooks' => [
    'thathoff.git-content.pull:after' => function () {
      $kirby = kirby();
      $models = [$kirby->site(), ...$kirby->site()->index(true)];

      foreach ($models as $model) {
        foreach ($model->files() as $file) {
          if (is_file($file->root()) && is_file($file->mediaRoot()) === false) {
            \Kirby\Cms\Media::publish($file, $file->mediaRoot());
          }
        }
      }
    },
    'thathoff.git-content.reset:after' => function () {
      kirby()->trigger('thathoff.git-content.pull:after');
    },
  ],
  'schmoll-studio.contact-form' => [
    'recipient'            => 'hello@reduction-roadmap.de',
    'subject'              => 'Neue Nachricht über reduction-roadmap.de',
    'confirmation-subject' => 'Vielen Dank für deine Nachricht',
    'from-name'            => 'Reduction Roadmap',
    'from-email'           => 'noreply@reduction-roadmap.de',
  ],
];
