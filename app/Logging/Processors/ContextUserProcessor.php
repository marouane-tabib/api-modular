<?php

namespace App\Logging\Processors;

class ContextUserProcessor 
{
    public function __invoke()
    {
        return [
            'id' => auth()->check() ? auth()->id() : 'N/A',
            'name' => auth()->check() ? auth()->user()->name : 'N/A',
            'email' => auth()->check() ? auth()->user()->email : 'N/A',
        ];
    }
}