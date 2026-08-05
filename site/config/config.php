<?php

$gitBranch = getenv('GIT_BRANCH') ?: (getenv('COOLIFY_BRANCH') ?: 'devel');

return [
  'debug' => false,
  'url'   => 'https://reduction-roadmap.de',
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
