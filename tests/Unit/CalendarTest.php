<?php

use App\Models\Calendar;
use Illuminate\Support\Facades\Log;


test('Create a Calendar', function () {
    $calendar = Calendar::factory()->create();
    expect($calendar->id)->toBe(1);
});


