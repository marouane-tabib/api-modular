<?php

if (!function_exists('getReleaseVersion')) {
    function getReleaseVersion()
    {
        return env('APP_RELEASE_VERSION', '1.0.0');
    }
}

if (!function_exists('getCommitHash')) {
    function getCommitHash()
    {
        return trim(shell_exec('git log --pretty="%h" -n1 HEAD'));
    }
}

if (!function_exists('getCommitAuthor')) {
    function getCommitAuthor()
    {
        return trim(shell_exec('git log --pretty="%an" -n1 HEAD'));
    }
}

if (!function_exists('getCommitDate')) {
    function getCommitDate()
    {
        return trim(shell_exec('git log --pretty="%ci" -n1 HEAD'));
    }
}

if (!function_exists('getAuthor')) {
    function getAuthor()
    {
        return env('APP_AUTHOR', trim(shell_exec('git config user.name')));
    }
}
