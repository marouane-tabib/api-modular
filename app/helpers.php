<?php

if (!function_exists('getReleaseVersion')) {
    function getReleaseVersion()
    {
        // You can define your own way to fetch the release version, or simply return a default value.
        return env('APP_RELEASE_VERSION', '1.0.0');
    }
}

if (!function_exists('getCommitHash')) {
    function getCommitHash()
    {
        // Execute the git command to get the latest commit hash
        return trim(shell_exec('git log --pretty="%h" -n1 HEAD'));
    }
}

if (!function_exists('getCommitAuthor')) {
    function getCommitAuthor()
    {
        // Execute the git command to get the author of the latest commit
        return trim(shell_exec('git log --pretty="%an" -n1 HEAD'));
    }
}

if (!function_exists('getCommitDate')) {
    function getCommitDate()
    {
        // Execute the git command to get the date of the latest commit
        return trim(shell_exec('git log --pretty="%ci" -n1 HEAD'));
    }
}

if (!function_exists('getAuthor')) {
    function getAuthor()
    {
        // Optionally, you can define a static author or retrieve it from a specific Git configuration
        return env('APP_AUTHOR', trim(shell_exec('git config user.name')));
    }
}

