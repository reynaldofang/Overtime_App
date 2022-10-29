<?php

namespace Tests\Unit;

use Tests\TestCase;

class OvertimePayTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $value = [
            'month'  => '2022-10'
        ];

        $this->get('/overtime-pays/calculate', $value)->assertStatus(201);
    }
}
