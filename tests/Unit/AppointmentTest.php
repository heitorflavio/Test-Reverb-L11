<?php

use App\Models\Appointment;

test('Create a appointment', function () {
    $appointment = Appointment::factory()->create();
    expect($appointment->id)->toBe(1);
});
