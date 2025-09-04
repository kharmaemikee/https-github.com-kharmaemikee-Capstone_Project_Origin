<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the boat assignment commands
Artisan::command('boats:assign-on-pickup', function () {
    $this->call('boats:assign-on-pickup');
})->purpose('Mark boats as assigned when their pickup time arrives');

Artisan::command('boats:update-statuses', function () {
    $this->call('boats:update-statuses');
})->purpose('Update boat statuses from assigned to open when bookings are completed');
