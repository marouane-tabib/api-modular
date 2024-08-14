<?php

return [
    'log_level' => 'info',
    
    'meta_data' => [
        'release_version' => getReleaseVersion(),
        'commit_hash' => getCommitHash(),
        'commit_author' => getCommitAuthor(),
        'commit_date' => getCommitDate(),
        'author' => getAuthor(),
    ]
];
