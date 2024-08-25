<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('logs:info-to-channel http_requests elastic_info_http')->daily();
Schedule::command('logs:info-to-channel data_base_queries elastic_info_queries')->daily();
