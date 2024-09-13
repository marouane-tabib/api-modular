<?php

namespace App\Logging\Processors;

class ContextVersionProcessor
{
    public function __invoke()
    {
        return [
            'release_version' => getReleaseVersion(),
            'commit_hash'     => getCommitHash(),
            'commit_author'   => getCommitAuthor(),
            'commit_date'     => getCommitDate(),
            'author'          => getAuthor(),
        ];
    }
}
