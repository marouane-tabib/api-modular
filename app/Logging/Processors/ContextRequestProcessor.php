<?php

namespace App\Logging\Processors;

class ContextRequestProcessor 
{
    public function __invoke()
    {
        return [
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'headers' => request()->except(['authorization', 'cookie', 'password', 'password_confirmation', 'current_password']),
            'body' => request()->except(['password', 'password_confirmation', 'current_password']),
            'query' => request()->query(),
            'from' => request()->query('from', 'N/A'),
            'to' => request()->query('to', 'N/A'),
            'user_agent' => request()->header('User-Agent'),
            'ip_address' => request()->ip(),
        ];
    }
}