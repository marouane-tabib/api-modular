<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('logs:info-to-channel http_requests elastic_info_http')->daily();
Schedule::command('logs:info-to-channel data_base_queries elastic_info_queries')->daily();
