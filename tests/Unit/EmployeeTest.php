<?php

namespace Tests\Unit;

use Tests\TestCase;
class EmployeeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $value = [
            'name'  => 'Reynaldo',
            'salary'=> 6500000

        ];

        $this->post('/employees', $value)->assertStatus(201);
    }
}
