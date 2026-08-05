<?php

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
    'pull'          => true,
    'push'          => true,
    'commit'        => true,
    'gitBin'        => '/usr/bin/git',
    'author'        => 'Johannes Schmoll <johannes@schmoll.studio>',
    'branch'        => 'devel',
  ],
];
