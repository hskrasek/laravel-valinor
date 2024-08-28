<?php

declare(strict_types=1);

use function Pest\Laravel\postJson;

describe('parsed requests', tests: function () {
    it('successfully resolves a parsed request', function () {
        postJson(
            uri: '/',
            data: $data = [
                'name' => fake()->name,
                'email' => fake()->email,
                'password' => fake()->password,
            ]
        )->assertStatus(200)->assertJson($data);
    });
});
