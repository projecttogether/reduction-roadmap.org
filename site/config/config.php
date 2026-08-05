<?php

$gitBranch = getenv('GIT_BRANCH') ?: (getenv('COOLIFY_BRANCH') ?: 'devel');
$siteUrl = getenv('SITE_URL') ?: (getenv('COOLIFY_URL') ?: 'https://reduction-roadmap.de');
$siteUrl = trim(explode(',', $siteUrl)[0]);

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
];
