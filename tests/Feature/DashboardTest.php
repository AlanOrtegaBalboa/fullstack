<?php


uses(\Illuminate\Foundation\Testing\DatabaseMigrations::class);

test('example', function () {
    $response = $this->get('/');

    $response->assertOk();
});
