<?php

namespace Tests\Unit;
use Tests\TestCase;


class OvertimeTest extends TestCase
{


    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        //$this->assertTrue(true);
        $value = [
            'name'  => 'Money',
            'salary' => 65000000
        ];

        $this->post('/overtimes', $value)->assertStatus(201);
    }
}
