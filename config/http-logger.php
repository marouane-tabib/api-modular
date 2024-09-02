<?php

return [

    /*
     * Determine if the http-logger middleware should be enabled.
     */
    'enabled' => env('HTTP_LOGGER_ENABLED', true),
    /*
     * The log profile which determines whether a request should be logged.
     * It should implement `LogProfile`.
     */
    'log_profile' => \Spatie\HttpLogger\LogNonGetRequests::class,

    /*
     * The log writer used to write the request to a log.
     * It should implement `LogWriter`.
     */
    'log_writer' => \Spatie\HttpLogger\DefaultLogWriter::class,

    /*
     * The log channel used to write the request.
     */
    'log_channel' => env('LOG_CHANNEL', 'stack'),

    /*
     * The log level used to log the request.
     */
    'log_level' => 'info',

    /*
     * Filter out body fields which will never be logged.
     */
    'except' => [
        'password',
        'password_confirmation',
        'current_password',
    ],

    /*
     * List of headers that will be sanitized. For example Authorization, Cookie, Set-Cookie...
     */
    'sanitize_headers' => [
        'authorization', 'cookie', 'password', 'password_confirmation', 'current_password'
    ],

    'meta_data' => [
        'release_version' => getReleaseVersion(),
        'commit_hash' => getCommitHash(),
        'commit_author' => getCommitAuthor(),
        'commit_date' => getCommitDate(),
        'author' => getAuthor(),
    ]
];
