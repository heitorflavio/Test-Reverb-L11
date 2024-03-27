<?php

test('example', function () {
    $response = $this->get(route('calendar.index'));
    $response->assertStatus(200);
});
