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

// Kirby config. //
////////////////////////////////////

return [
  'debug' => false,
  'url'   => $siteUrl,
  'panel' => [
    'install' => true,
    'vue' => [
      'compiler' => false,
    ],
  ],
  'thathoff.git-content' => [
    'disable'       => !is_file('/run/git-content-ready'),
    'pull'          => true,
    'push'          => true,
    'commit'        => true,
    'gitBin'        => '/usr/bin/git',
    'author'        => 'Johannes Schmoll <johannes@schmoll.studio>',
    'branch'        => $gitBranch,
  ],
  'schmoll-studio.contact-form' => [
    'recipient'  => 'hello@reduction-roadmap.de',
    'subject'    => 'New message from the website',
    'from-name'  => 'Reduction Roadmap',
    'from-email' => 'noreply@reduction-roadmap.de',
  ],
];
