<?php

namespace App\Logging\Processors;

use Illuminate\Support\Facades\Auth;

class ContextUserProcessor
{
    public function __invoke()
    {
        return [
            'id' => Auth::check() ? Auth::user()->id : 'N/A',
            'name' => Auth::check() ? Auth::user()->name : 'N/A',
            'email' => Auth::check() ? Auth::user()->email : 'N/A',
        ];
    }
}
