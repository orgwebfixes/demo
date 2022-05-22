<?php

return [
    'dsn' => env('SENTRY_DSN'),
    //'dsn' => 'https://5e3b53a09e14497baad96332a30c2319:36dec60c69a44d57b55de80e821618dd@sentry.io/98330',
        // capture release as git sha
        // 'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),
];
